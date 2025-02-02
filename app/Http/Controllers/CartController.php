<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\CartProduct;
use App\Models\User;
use Auth;

class CartController extends Controller
{

    public function addToCart(Request $request, $product_id)
    {
        $user = Auth::user();
    
        // Check if the product is already in the cart
        $existingCartItem = CartProduct::where('user_id', $user->id)
            ->where('product_id', $product_id)
            ->first();
    
        if ($existingCartItem) {
            // If the product is already in the cart, update the quantity
        $existingCartItem->quantity = $existingCartItem->quantity + $request->input('amount');
        $existingCartItem->save();
        } else {
            // If it's not in the cart, create a new cart item with a quantity of 1
            CartProduct::create([
                'user_id' => $user->id,
                'product_id' => $product_id,
                'quantity' => 1,
            ]);
        }
    
        // Redirect back to the product page or wherever you want
        return redirect()->back()->with(['success' => 'Product added to cart.', 'added_product_id' => $product_id]);
    }
    
    public function viewCart()
{
    $user = auth()->user();
    $cartProducts = CartProduct::with('product')
        ->where('user_id', $user->id)
        ->get();

    return view('cart', compact('cartProducts'));
}

public function updateCartItem(Request $request, $product_id)
{
    $user = Auth::user();

    // Retrieve the cart item
    $cartItem = CartProduct::where('user_id', $user->id)
        ->where('product_id', $product_id)
        ->first();

    if ($cartItem) {
        // Update the quantity
        $newQuantity = $cartItem->quantity + $request->input('amount');

        if ($newQuantity > 0) {
            if($newQuantity <= $cartItem->product->stock){
                $cartItem = CartProduct::updateOrInsert(
                    ['user_id' => $user->id, 'product_id' => $product_id],
                    ['quantity' => $newQuantity]
                );
            } else{
                return redirect()->route('cart')->withErrors(['error' => 'Quantity exceeds available stock.']);
            }

            
        } else {
            // If the new quantity is 0 or negative, remove the item from the cart
            CartProduct::where([
                'user_id' => $cartItem->user_id,
                'product_id' => $cartItem->product_id,
            ])->delete();
        }
    }

    // Redirect back to the cart page or wherever you want
    return redirect()->route('cart')->with('success', 'Cart item updated.');
}

public function getCartCount()
{
    $user = Auth::user();
    $cartCount = CartProduct::where('user_id', $user->id)->count();

    return response()->json(['count' => $cartCount]);
}

}
