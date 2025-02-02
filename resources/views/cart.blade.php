@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="col-12" style="height: 100%; overflow: auto;">
        <div class="cart-container" style="width: 50%; margin: 50px auto;">
            <div class="form-group row mb-3">
                <h4>
                    <span class="register-icon">
                        <img src="{{ asset('images/shopping-cart.png') }}"
                             style="width: 64px; height: 64px; margin-right: 20px;"/>
                    </span>
                    <strong>Your Cart</strong>
                </h4>
            </div>
            @if($errors->has('error'))
            <div class="alert alert-danger">
              {{ $errors->first('error') }}
            </div>
            @endif
            <br/>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Product Code</th>
                        <th scope="col">Title</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price per Unit</th>
                        <th scope="col">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartProducts  as $cartItem)
                        <tr>
                            <td>{{ $cartItem->product->code }}</td>
                            <td>
                                <a href="/products/{{ $cartItem->product->product_id }}">{{ $cartItem->product->title }}</a>
                            </td>
                            <td>
                                <div class="quantity-controls d-flex align-items-center">
                                    <span class="quantity mr-2">{{ $cartItem->quantity }}</span>

                                    <form action="{{ route('cart.update', ['product' => $cartItem->product->product_id]) }}" method="post" class="mr-1">
                                        @csrf
                                        <input type="hidden" name="amount" value="1">
                                        <button type="submit" class="badge bg-success" style="cursor: pointer;">+</button>
                                    </form>
                            
                                    
                                    <form action="{{ route('cart.update', ['product' => $cartItem->product->product_id]) }}" method="post" class="mr-1">
                                        @csrf
                                        <input type="hidden" name="amount" value="-1">
                                        <button type="submit" class="badge bg-danger" style="cursor: pointer;">-</button>
                                    </form>
                                </div>
                            </td>
                            <td>{{ number_format($cartItem->product->price, 2) }} €</td>
                            <td>{{ number_format($cartItem->quantity * $cartItem->product->price, 2) }} €</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            @if($cartProducts->count()>0)
            <div class="order-container d-flex justify-content-center">
                <a href="/checkout" class="btn btn-primary">Create Order</a>
            </div>
            @else
                <p style="text-align:center">Your cart is empty</p>
            @endif
            
        </div>
    </div>
</div>
@endsection
