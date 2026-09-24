<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shiprocket;
use App\Services\AmazonSpApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $amazonService;

    public function __construct(AmazonSpApiService $amazonService)
    {
        $this->amazonService = $amazonService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'address', 'items']);

        // 🔍 Search: Order No, Customer Name, Email, Phone
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                    ->orWhereHas('customer', function ($qc) use ($request) {
                        $qc->where('first_name', 'like', '%' . $request->search . '%')
                            ->orWhere('last_name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%')
                            ->orWhere('phone', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // 📦 Order Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 💳 Payment Status Filter
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->orderBy('id', 'DESC')
            ->paginate(15)
            ->withQueryString();

        $shiprocket = Shiprocket::first();

        return view('admin.pages.orders.index', compact('orders', 'shiprocket'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create New Order';

        $customers = Customer::where('is_active', 1)->get();
        $products = Product::all();

        return view('admin.pages.orders.create', compact('title', 'customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'address_id' => 'required|exists:addresses,id',
            'status' => 'required|in:pending,paid,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',

            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $subtotal = 0;

            foreach ($request->items as $item) {
                $subtotal += $item['price'] * $item['quantity'];

                $product = Product::findOrFail($item['product_id']);

                // 🚨 Stock check
                if ($product->track_quantity && ! $product->continue_selling_out_of_stock) {
                    if ($product->stock_quantity < $item['quantity']) {
                        throw new \Exception("Not enough stock for product: {$product->title}");
                    }
                }
            }

            $tax = $request->tax ?? 0;
            $shipping = $request->shipping ?? 0;
            $total = $subtotal + $tax + $shipping;

            $order = Order::create([
                'customer_id' => $request->customer_id,
                'address_id' => $request->address_id,
                'order_number' => 'ORD-' . time(),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
                'status' => $request->status,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'shipped_at' => $request->status === 'shipped' ? Carbon::now() : null,
            ]);

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'title' => $product->title,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total' => $item['price'] * $item['quantity'],
                ]);

                // 🔻 Deduct stock
                if ($product->track_quantity) {
                    $product->stock_quantity -= $item['quantity'];
                    $product->save();
                }
            }

            // 🚀 Create Amazon MCF Order
            try {
                $this->amazonService->createMcfOrder($order);
            } catch (\Exception $e) {
                Log::error("Amazon MCF Order Creation Failed for Order #{$order->order_number}: " . $e->getMessage());
            }

            // 📦 If status set to shipped, auto-create Shiprocket Order if integration active
            if ($request->status === 'shipped') {
                $shiprocket = Shiprocket::first();
                if ($shiprocket && $shiprocket->status && $shiprocket->isTokenValid()) {
                    try {
                        $shiprocket->createOrder($order);
                    } catch (\Exception $se) {
                        Log::error("Shiprocket Order Creation Error for Order #{$order->order_number}: " . $se->getMessage());
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.order-control.order.index')
                ->with('success', 'Order created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with(['items', 'address', 'customer'])->findOrFail($id);
        $shiprocket = Shiprocket::first();
        $title = 'View Order Detail';

        return view('admin.pages.orders.show', compact('order', 'shiprocket', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Edit Customer Detail';
        $customer = Order::findOrFail($id);

        return view('admin.pages.customers.edit', compact('title', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = Order::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|unique:customers,phone,' . $customer->id,
            'password' => 'nullable|string|min:6|confirmed',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'is_active' => 'required|boolean',
        ]);

        try {
            if ($request->filled('password')) {
                $validated['password'] = bcrypt($request->password);
            } else {
                unset($validated['password']);
            }

            $customer->update($validated);

            return redirect()->route('admin.customer-control.customer.index')
                ->with('success', 'Customer updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Order::findOrFail($id)->delete();

            return redirect()->back()->with('success', 'Order Deleted Successfully.');
        } catch (\Exception $e) {
            Log::error('Order Delete Error: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Ship Order via Shiprocket integration.
     */
    public function shipWithShiprocket(Request $request, $id)
    {
        $order = Order::with(['items', 'address', 'customer'])->findOrFail($id);

        $request->validate([
            'length' => 'nullable|numeric|min:0.1',
            'breadth' => 'nullable|numeric|min:0.1',
            'height' => 'nullable|numeric|min:0.1',
            'weight' => 'nullable|numeric|min:0.01',
            'pickup_location' => 'nullable|string',
        ]);

        $shiprocket = Shiprocket::first();

        if (!$shiprocket) {
            return redirect()->back()->with('error', 'Shiprocket is not configured yet. Please configure credentials in Shiprocket Settings first.');
        }

        $packageData = [
            'length' => $request->input('length', 10),
            'breadth' => $request->input('breadth', 10),
            'height' => $request->input('height', 10),
            'weight' => $request->input('weight', 0.5),
            'pickup_location' => $request->input('pickup_location', $shiprocket->pickup_location ?: 'Primary'),
        ];

        $result = $shiprocket->createOrder($order, $packageData);

        if ($result['success']) {
            return redirect()->back()->with('success', 'Order #' . $order->order_number . ' successfully pushed to Shiprocket! Shipment ID: ' . ($result['shipment_id'] ?? 'N/A'));
        }

        return redirect()->back()->with('error', 'Shiprocket Error: ' . $result['message']);
    }

    /**
     * Track Order Shipment via Shiprocket.
     */
    public function trackShiprocket(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $shiprocket = Shiprocket::first();

        if (!$shiprocket) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Shiprocket is not configured.']);
            }
            return redirect()->back()->with('error', 'Shiprocket is not configured.');
        }

        $searchId = $order->shiprocket_shipment_id ?: ($order->shiprocket_order_id ?: $order->order_number);

        $result = $shiprocket->trackShipment($searchId);

        if ($result['success']) {
            $trackData = $result['tracking_data'];

            $status = $trackData['current_status'] ?? ($trackData['status'] ?? $order->shiprocket_status);
            $courier = $trackData['courier_name'] ?? $order->shiprocket_courier_name;
            $awb = $trackData['awb_code'] ?? ($trackData['awb'] ?? $order->shiprocket_awb_code);
            $trackUrl = $trackData['track_url'] ?? ($trackData['tracking_url'] ?? $order->shiprocket_tracking_url);

            $updateData = [];
            if ($status) $updateData['shiprocket_status'] = $status;
            if ($courier) $updateData['shiprocket_courier_name'] = $courier;
            if ($awb) $updateData['shiprocket_awb_code'] = $awb;
            if ($trackUrl) $updateData['shiprocket_tracking_url'] = $trackUrl;

            if (strtolower($status) === 'delivered') {
                $updateData['status'] = 'delivered';
            } elseif (strtolower($status) === 'shipped' || strtolower($status) === 'in transit') {
                $updateData['status'] = 'shipped';
            }

            if (!empty($updateData)) {
                $order->update($updateData);
            }

            if ($request->wantsJson()) {
                return response()->json($result);
            }

            return redirect()->back()->with('success', 'Shipment tracking updated! Current Status: ' . ($status ?: 'In Transit'));
        }

        if ($request->wantsJson()) {
            return response()->json($result, 400);
        }

        return redirect()->back()->with('error', 'Tracking Error: ' . $result['message']);
    }

    /**
     * Cancel Shiprocket Order.
     */
    public function cancelShiprocket(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (!$order->shiprocket_order_id) {
            return redirect()->back()->with('error', 'Order is not associated with a Shiprocket Order ID.');
        }

        $shiprocket = Shiprocket::first();

        if (!$shiprocket) {
            return redirect()->back()->with('error', 'Shiprocket is not configured.');
        }

        $result = $shiprocket->cancelOrder($order->shiprocket_order_id);

        if ($result['success']) {
            $order->update([
                'status' => 'cancelled',
                'shiprocket_status' => 'CANCELLED',
            ]);

            return redirect()->back()->with('success', 'Order cancelled on Shiprocket successfully.');
        }

        return redirect()->back()->with('error', 'Cancel Error: ' . $result['message']);
    }

    /**
     * Update order status manually.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;

        if ($request->status === 'shipped' && !$order->shipped_at) {
            $order->shipped_at = Carbon::now();
        }

        $order->save();

        // If admin checked auto-push to Shiprocket when setting status to shipped
        if ($request->status === 'shipped' && $request->has('push_to_shiprocket') && !$order->shiprocket_order_id) {
            $shiprocket = Shiprocket::first();
            if ($shiprocket && $shiprocket->status && $shiprocket->isTokenValid()) {
                $shiprocket->createOrder($order);
            }
        }

        return redirect()->back()->with('success', 'Order status updated to ' . ucfirst($request->status));
    }
}
