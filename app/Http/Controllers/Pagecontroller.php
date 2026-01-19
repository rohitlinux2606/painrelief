<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Str;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Address;

class Pagecontroller extends Controller
{
    public function home()
    {
        $products = Product::with('images')->get();
        return view('index', compact('products'));
    }

    public function productDetail($id)
    {
        $product = Product::find($id);
        return view('product-detail', compact('product'));
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        // 1. Session dhundho ya banao (Guest users ke liye)
        $sessionId = Session::getId();
        $userId = Auth::id(); // Agar login hai to ID milegi, warna null

        // 2. User ka Cart dhundho ya naya banao
        $cart = Cart::firstOrCreate(
            ['user_id' => $userId, 'session_id' => $sessionId]
        );

        // 3. Check karo kya ye product pehle se cart mein hai?
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $id)
            ->first();

        if ($cartItem) {
            // Agar hai to quantity badha do
            $cartItem->increment('quantity');
        } else {
            // Naya item add karo
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $id,
                'quantity' => 1,
                'price' => $product->price
            ]);
        }

        return redirect()->route('show-cart')->with('success', 'Product added to cart!');
    }

    // CartController.php mein add karein
    public function updateQuantity(Request $request)
    {
        $item = CartItem::findOrFail($request->item_id);

        if ($request->action == 'increase') {
            $item->increment('quantity');
        } else if ($request->action == 'decrease' && $item->quantity > 1) {
            $item->decrement('quantity');
        }

        // Naya total calculate karke bhejein
        $cart = Cart::with('items')->find($item->cart_id);
        $newSubtotal = $cart->items->sum(function ($i) {
            return $i->price * $i->quantity;
        });

        return response()->json([
            'status' => 'success',
            'new_qty' => $item->quantity,
            'item_total' => number_format($item->price * $item->quantity, 2),
            'cart_subtotal' => number_format($newSubtotal, 2)
        ]);
    }

    public function showCart()
    {
        $sessionId = Session::getId();
        $userId = Auth::id();

        // User ka cart load karo uske items aur products ke saath
        $cart = Cart::where('user_id', $userId)
            ->orWhere('session_id', $sessionId)
            ->with('items.product')
            ->first();

        return view('cart', compact('cart'));
    }

    public function checkout()
    {
        // if (!Auth::check()) {
        //     return redirect()->route('login');
        // }
        $sessionId = Session::getId();
        $cart = Cart::where('session_id', $sessionId)->with('items.product')->first();

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
