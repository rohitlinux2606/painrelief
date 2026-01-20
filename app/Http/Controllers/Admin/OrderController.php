<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderController extends Controller
{
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

        return view('admin.pages.orders.index', compact('orders'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create New Order";

        $customers = Customer::where('is_active', 1)->get();
        // $products  = Product::where('status', 'active')->get();
        $products  = Product::all();

        return view('admin.pages.orders.create', compact('title', 'customers', 'products'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'address_id'  => 'required|exists:addresses,id',
            'status'      => 'required|in:pending,paid,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',

            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.price'      => 'required|numeric|min:0',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {

            $subtotal = 0;

            foreach ($request->items as $item) {
                $subtotal += $item['price'] * $item['quantity'];

                $product = Product::findOrFail($item['product_id']);

                // 🚨 Stock check
                if ($product->track_quantity && !$product->continue_selling_out_of_stock) {
                    if ($product->stock_quantity < $item['quantity']) {
                        throw new \Exception("Not enough stock for product: {$product->title}");
                    }
                }
            }

            $tax      = $request->tax ?? 0;
            $shipping = $request->shipping ?? 0;
            $total    = $subtotal + $tax + $shipping;

            $order = Order::create([
                'customer_id'    => $request->customer_id,
                'address_id'     => $request->address_id,
                'order_number'   => 'ORD-' . time(),
                'subtotal'       => $subtotal,
                'tax'            => $tax,
                'shipping'       => $shipping,
                'total'          => $total,
                'status'         => $request->status,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
            ]);

            foreach ($request->items as $item) {

                $product = Product::findOrFail($item['product_id']);

                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'title'      => $product->title,
                    'price'      => $item['price'],
                    'quantity'   => $item['quantity'],
                    'total'      => $item['price'] * $item['quantity'],
                ]);

                // 🔻 Deduct stock
                if ($product->track_quantity) {
                    $product->stock_quantity -= $item['quantity'];
                    $product->save();
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
        $customer = Order::with(['orders', 'addresses'])->findOrFail($id);
        $title = "View Customer";

        return view('admin.pages.customers.show', compact('customer', 'title'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title      = "Edit Customer Detail";
        $customer    = Order::findOrFail($id);
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
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone'      => 'nullable|string|unique:customers,phone,' . $customer->id,
            'password'   => 'nullable|string|min:6|confirmed',
            'dob'        => 'nullable|date',
            'gender'     => 'nullable|in:male,female,other',
            'is_active'  => 'required|boolean',
        ]);

        try {
            // Password update only if entered
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

            return redirect()->back()->with('success', 'Customer Deleted Successfully.');
        } catch (\Exception $e) {
            Log::error("Tour Delete Error: " . $e->getMessage());
            return back()->with('error', 'Something went wrong.');
        }
    }
}
