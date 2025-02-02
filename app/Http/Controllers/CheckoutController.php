<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Address;
use App\Models\User;
use Auth;


class CheckoutController extends Controller
{
    public function showCheckoutForm()
    {
        // Fetch cart items
        $cartItems = CartProduct::where('user_id', auth()->id())->get();

        // Fetch user's address if it exists
        $userAddress = Address::where('user_id', auth()->id())->first();

        // Calculate total amount
        $totalAmount = $cartItems->sum(function($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });

        return view('checkout', compact('cartItems', 'totalAmount', 'userAddress'));
    }

    public function createOrder(Request $request)
{
    // Validate the request
    $request->validate([
        'street' => 'required|string',
        'number' => 'required|numeric',
        'city' => 'required|string',
        'postal_code' => 'required|string',
        'comments' => 'nullable|string',
        'terms' => 'required|accepted',
    ]);

    // Calculate total_quantity and total_price based on cart items
    $cartItems = CartProduct::where('user_id', auth()->id())->get();
    $totalQuantity = $cartItems->sum('quantity');
    $totalPrice = $cartItems->sum(function ($cartItem) {
        return $cartItem->quantity * $cartItem->product->price;
    });

    // Create a new order
    $order = new Order([
        'user_id' => auth()->id(),
        'address_street' => $request->input('street'),
        'address_number' => $request->input('number'),
        'address_city' => $request->input('city'),
        'address_postal_code' => $request->input('postal_code'),
        'comments' => $request->input('comments'),
        'total_quantity' => $totalQuantity,
        'total_price' => $totalPrice
    ]);

    $order->save();

    // Attach products to the order
    foreach ($cartItems as $cartItem) {
        $orderProduct = new OrderProduct([
            'product_id' => $cartItem->product_id,
            'quantity' => $cartItem->quantity,
            'initial_price' => $cartItem->product->price,
            'total_price' => $cartItem->quantity * $cartItem->product->price,
        ]);

        // Save the order product
        $order->orderProducts()->save($orderProduct);

        // Decrease stock
        $cartItem->product->stock -= $cartItem->quantity;
        $cartItem->product->save();
    }

    // Clear the user's cart
    CartProduct::where('user_id', auth()->id())->delete();

    return redirect()->route('dashboard')->with('success', 'Order created successfully')->with('form_to_display', 'orders');
}

public function showCardForm()
{
    return view('card-form');
}

}
