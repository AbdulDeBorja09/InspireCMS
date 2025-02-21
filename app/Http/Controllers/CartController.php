<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Add to Cart Function
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1); // Default to 1 if no quantity is provided

        // Check if the user is authenticated
        if (Auth::check()) {
            $userId = Auth::id();

            // Check if the product already exists in the user's cart
            $cartItem = Cart::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                // Update the quantity if the product already exists in the cart
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                // Add new cart item for the user
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        } else {
            // Handle cart for guest users using session
            $cart = session()->get('cart', []);

            if (isset($cart[$productId])) {
                // Update the quantity if the product already exists in the session cart
                $cart[$productId]['quantity'] += $quantity;
            } else {
                // Add new cart item to the session
                $cart[$productId] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ];
            }

            session()->put('cart', $cart);
        }

        return response()->json(['message' => 'Product added to cart successfully']);
    }

    // Transfer Guest Cart to Authenticated Cart
    public function transferGuestCartToUser()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $cart = session()->get('cart', []);

            foreach ($cart as $productId => $cartItem) {
                $quantity = $cartItem['quantity'];

                // Check if the product already exists in the user's cart
                $existingCartItem = Cart::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->first();

                if ($existingCartItem) {
                    // Update the quantity if the product already exists
                    $existingCartItem->quantity += $quantity;
                    $existingCartItem->save();
                } else {
                    // Add the guest cart item to the user's cart
                    Cart::create([
                        'user_id' => $userId,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                    ]);
                }
            }

            // Clear the session cart after transferring
            session()->forget('cart');
        }
    }
}
