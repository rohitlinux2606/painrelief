<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Container\Attributes\Log;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;

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
}
