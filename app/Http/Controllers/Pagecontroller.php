<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVideos;
use App\Services\AmazonSpApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class Pagecontroller extends Controller
{
    protected $amazonService;

    public function __construct(AmazonSpApiService $amazonService)
    {
        $this->amazonService = $amazonService;
    }

    /* =========================
       SESSION HELPER (IMPORTANT)
    ========================== */
    private function getCartSessionId()
    {
        if (! session()->has('cart_session')) {
            session(['cart_session' => session()->getId()]);
        }

        return session('cart_session');
    }

    /* ========================= */

    public function home()
    {
        $products = Product::with('images')->get();
        $videos = ProductVideos::all();

        return view('index', compact('products', 'videos'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function productDetail($id)
    {
        $product = Product::find($id);

        return view('product-detail', compact('product'));
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        $sessionId = $this->getCartSessionId();
        $userId = Auth::id();

        // CART FETCH / CREATE (FIXED)
        $cart = Cart::where(function ($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('session_id', $sessionId);
            }
        })->first();

        if (! $cart) {
            $cart = Cart::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
            ]);
        }

        // CART ITEM LOGIC (UNCHANGED)
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $id,
                'quantity' => 1,
                'price' => $product->price,
            ]);
        }

        return redirect()->route('show-cart')->with('success', 'Product added to cart!');
    }

    public function buyNow($id)
    {
        $product = Product::findOrFail($id);

        $sessionId = $this->getCartSessionId();
        $userId = Auth::id();

        // CART FETCH / CREATE
        $cart = Cart::where(function ($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('session_id', $sessionId);
            }
        })->first();

        if (! $cart) {
            $cart = Cart::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
            ]);
        }

        // CART ITEM LOGIC
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $id,
                'quantity' => 1,
                'price' => $product->price,
            ]);
        }

        return redirect()->route('checkout')->with('success', 'Proceeding to checkout!');
    }

    public function updateQuantity(Request $request)
    {
        $item = CartItem::findOrFail($request->item_id);

        if ($request->action == 'increase') {
            $item->increment('quantity');
        } elseif ($request->action == 'decrease' && $item->quantity > 1) {
            $item->decrement('quantity');
        }

        $cart = Cart::with('items')->find($item->cart_id);
        $newSubtotal = $cart->items->sum(fn ($i) => $i->price * $i->quantity);

        return response()->json([
            'status' => 'success',
            'new_qty' => $item->quantity,
            'item_total' => number_format($item->price * $item->quantity, 2),
            'cart_subtotal' => number_format($newSubtotal, 2),
        ]);
    }

    public function showCart()
    {
        $sessionId = $this->getCartSessionId();
        $userId = Auth::id();

        $cart = Cart::where(function ($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('session_id', $sessionId);
            }
        })
            ->with('items.product')
            ->first();

        return view('cart', compact('cart'));
    }

    public function removeItem($itemId)
    {
        $sessionId = $this->getCartSessionId();
        $userId = Auth::id();

        // पहले cart निकालो
        $cart = Cart::where(function ($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('session_id', $sessionId);
            }
        })->first();

        if (! $cart) {
            return redirect()->back()->with('error', 'Cart not found');
        }

        // अब उसी cart का item ढूंढो
        $item = CartItem::where('id', $itemId)
            ->where('cart_id', $cart->id)
            ->first();

        if (! $item) {
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        $item->delete();

        return redirect()->back()->with('success', 'Item removed from cart');
    }

    public function checkout()
    {
        $sessionId = $this->getCartSessionId();
        $userId = Auth::id();

        $cart = Cart::where(function ($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('session_id', $sessionId);
            }
        })
            ->with('items.product')
            ->first();

        if (! $cart || $cart->items->count() == 0) {
            return redirect()->route('show-cart')->with('error', 'Your cart is empty');
        }

        return view('checkout', compact('cart'));
    }

    public function placeOrder(Request $request)
    {
        // Log::info($request->all());

        // 1. Validation
        $request->validate([
            'email' => 'nullable|email',
            'first_name' => 'required',
            'last_name' => 'nullable',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
        ]);

        $sessionId = $this->getCartSessionId();
        $userId = Auth::id();

        $cart = Cart::where(function ($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('session_id', $sessionId);
            }
        })->with('items.product')->first();

        // Log::info('Cart Status: '.($cart ? 'Found with '.$cart->items->count().' items' : 'Not Found'));

        if (! $cart || $cart->items->count() == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Your cart is empty or session expired',
            ]);
        }

        // 2. CUSTOMER LOGIC
        $customer = Customer::where('email', $request->email)
            ->orWhere('phone', $request->phone)
            ->first();

        if ($customer) {
            $customer->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
            ]);
        } else {
            $customer = Customer::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt(Str::random(10)),
                'is_active' => true,
            ]);
        }

        // 3. ADDRESS LOGIC: Naya address save karein
        $address = Address::create([
            'customer_id' => $customer->id,
            'type' => 'shipping',
            'name' => $request->first_name.' '.$request->last_name,
            'phone' => $request->phone,
            'address_line1' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->pincode,
            'country' => 'IN',
        ]);

        // 4. PRE-CALCULATE ORDER VARIABLES
        $master = \App\Models\WebSetting::first();
        $discount_percentage = $master->discount_percentage ?? 0;
        $shipping_charge_rate = $master->shipping_charge ?? 0;
        $free_shipping_amount = $master->free_shipping_amount ?? 0;

        $cart_subtotal = $cart->items->sum(fn ($item) => $item->price * $item->quantity);
        $effective_shipping = ($cart_subtotal < $free_shipping_amount) ? $shipping_charge_rate : 0;
        $discount = ($cart_subtotal * $discount_percentage) / 100;
        $order_total = round($cart_subtotal + $effective_shipping - $discount);

        // 5. CREATE ORDER (customer_id aur address_id ke saath)
        $order = Order::create([
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_number' => 'JVN-'.strtoupper(Str::random(10)),
            'subtotal' => $cart_subtotal,
            'shipping' => $effective_shipping,
            'discount' => $discount,
            'total' => $order_total,
            'status' => 'pending',
            'payment_method' => 'COD',
            'payment_status' => 'unpaid',
        ]);

        // 5. Save Order Items
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'title' => $item->product->title,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'total' => $item->price * $item->quantity,
            ]);
        }

        // 🚀 Create Amazon MCF Order
        try {
            $this->amazonService->createMcfOrder($order);
        } catch (\Exception $e) {
            // Log the error but don't fail the local order creation
            Log::error("Amazon MCF Order Creation Failed for Order #{$order->order_number}: ".$e->getMessage());
        }

        // 6. Return response to triggering AJAX frontend modal
        return response()->json([
            'status' => 'success',
            'data' => [
                'customer' => $customer,
                'address' => $address,
                'order_id' => $order->id,
                'order' => $order,
            ],
        ]);

        // return redirect()->route('order-success', $order->order_number)->with('success', 'Your order has been placed successfully!');
    }

    public function cancelOrder(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
        ]);

        $order = Order::where('order_number', $request->order_number)->first();

        if (! $order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found.',
            ], 404);
        }

        // Basic security check: verify order belongs to current session/customer
        $sessionId = $this->getCartSessionId();
        $userId = Auth::id();

        // If order has a customer, check if it matches the current user or falls within the recent session
        // For simplicity in this guest-friendly flow, we'll allow cancellation if it matches the session or user
        // In a production app, we might check `created_at` or a session token stored in the order
        if ($order->status === 'cancelled') {
            return response()->json([
                'status' => 'error',
                'message' => 'Order is already cancelled.',
            ]);
        }

        try {
            // 1. Cancel at Amazon
            $this->amazonService->cancelFulfillmentOrder($order->order_number);

            // 2. Update local order
            $order->update(['status' => 'cancelled']);

            // 3. Restore Stock
            if ($order->items) {
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product && $product->track_quantity) {
                        $product->increment('stock_quantity', $item->quantity);
                    }
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Order cancelled successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error("Manual Order Cancellation Failed for #{$order->order_number}: ".$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Could not cancel order at Amazon. It might already be in processing.',
            ], 500);
        }
    }

    public function orderSuccess($orderNumber)
    {
        // Customer details ke saath order load karein
        $order = Order::with('customer', 'items')->where('order_number', $orderNumber)->first();

        if (! $order) {
            return redirect()->route('page.home');
        }

        return view('order-success', compact('order'));
    }

    public function privacyPolicy()
    {
        return view('policies.privacy-policy');
    }

    public function termsConditions()
    {
        return view('policies.terms-conditions');
    }

    public function refundPolicy()
    {
        return view('policies.refund-policy');
    }

    public function returnPolicy()
    {
        return view('policies.return-policy');
    }
}
