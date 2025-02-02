<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Models\Order;
use Auth;

class OrderController extends Controller
{
    public function getOrderDetails($orderId)
{
    // Retrieve the order details based on the $orderId
    $order = Order::find($orderId);

    if (!$order) {
        return Response::json(['success' => false, 'error' => 'Order not found'], 404);
    }

    // Get the order details, such as product title, business name, quantity, etc.
    $orderDetails = $order->orderProducts()->with('product.business')->get();

    return Response::json(['success' => true, 'orderDetails' => $orderDetails]);
}
}
