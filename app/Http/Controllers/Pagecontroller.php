<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Address;
use App\Models\ProductVideos;

class Pagecontroller extends Controller
{
    /* =========================
       SESSION HELPER (IMPORTANT)
    ========================== */
    private function getCartSessionId()
    {
        if (!session()->has('cart_session')) {
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

        if (!$cart) {
            $cart = Cart::create([
                'user_id'    => $userId,
                'session_id' => $sessionId
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
                'price' => $product->price
            ]);
        }

        return redirect()->route('show-cart')->with('success', 'Product added to cart!');
    }

    public function updateQuantity(Request $request)
    {
        $item = CartItem::findOrFail($request->item_id);

        if ($request->action == 'increase') {
            $item->increment('quantity');
        } else if ($request->action == 'decrease' && $item->quantity > 1) {
            $item->decrement('quantity');
        }

        $cart = Cart::with('items')->find($item->cart_id);
        $newSubtotal = $cart->items->sum(fn($i) => $i->price * $i->quantity);

        return response()->json([
            'status' => 'success',
            'new_qty' => $item->quantity,
            'item_total' => number_format($item->price * $item->quantity, 2),
            'cart_subtotal' => number_format($newSubtotal, 2)
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

        if (!$cart) {
            return redirect()->back()->with('error', 'Cart not found');
        }

        // अब उसी cart का item ढूंढो
        $item = CartItem::where('id', $itemId)
            ->where('cart_id', $cart->id)
            ->first();

        if (!$item) {
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        $item->delete();

        return redirect()->back()->with('success', 'Item removed from cart');
    }


    public function checkout()
    {
        $sessionId = $this->getCartSessionId();

        $cart = Cart::where('session_id', $sessionId)
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('show-cart')->with('error', 'Your cart is empty');
        }

        return view('checkout', compact('cart'));
    }


    public function placeOrder(Request $request)
    {
        // 1. Validation
        $request->validate([
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
        ]);

        $sessionId = Session::getId();
        $cart = Cart::where('session_id', $sessionId)->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('show-cart')->with('error', 'Cart is empty');
        }

        // 2. CUSTOMER LOGIC
        $customer = Customer::where('email', $request->email)
            ->orWhere('phone', $request->phone)
            ->first();

        if ($customer) {
            $customer->update([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
            ]);
        } else {
            $customer = Customer::create([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'password'   => bcrypt(Str::random(10)),
                'is_active'  => true
            ]);
        }

        // 3. ADDRESS LOGIC: Naya address save karein
        $address = Address::create([
            'customer_id'   => $customer->id,
            'type'          => 'shipping',
            'name'          => $request->first_name . ' ' . $request->last_name,
            'phone'         => $request->phone,
            'address_line1' => $request->address,
            'city'          => $request->city,
            'state'         => $request->state,
            'postal_code'   => $request->pincode,
            'country'       => 'India',
        ]);

        // 4. CREATE ORDER (customer_id aur address_id ke saath)
        // Note: Make sure aapke orders table mein address_id ka column ho
        $order = Order::create([
            'customer_id'    => $customer->id,
            'address_id'     => $address->id, // Address link kar diya
            'order_number'   => 'ORD-' . strtoupper(Str::random(10)),
            'subtotal'       => $cart->items->sum(fn($item) => $item->price * $item->quantity),
            'total'          => $cart->items->sum(fn($item) => $item->price * $item->quantity),
            'status'         => 'pending',
            'payment_method' => 'COD',
            'payment_status' => 'unpaid',
        ]);

        // 5. Save Order Items
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'title'      => $item->product->title,
                'price'      => $item->price,
                'quantity'   => $item->quantity,
                'total'      => $item->price * $item->quantity,
            ]);
        }

        // 6. Cleanup
        $cart->items()->delete();
        $cart->delete();

        return redirect()->route('order-success', $order->order_number);
    }

    public function orderSuccess($orderNumber)
    {
        // Customer details ke saath order load karein
        $order = Order::with('customer', 'items')->where('order_number', $orderNumber)->first();

        if (!$order) {
            return redirect()->route('home');
        }

        return view('order-success', compact('order'));
    }
}
