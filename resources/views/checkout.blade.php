@extends('layouts.app')

@section('content')
<div class="main-container" style="width: 80%; margin: 50px auto;">
    <form action="/checkout" method="POST" class="row">
        @csrf
        <!-- Address Section -->
        <div class="col-md-6" style="height: 100%; overflow: auto;">
            <h4 class="section-title mb-4">
                <span class="cart-icon">
                    <img src="{{ asset('images/hacker.png') }}" class="icon" />
                </span>
                <strong>Your Address</strong>
            </h4>
            <div class="form-group mb-3">
                <label for="street">Address</label>
                <input type="text" id="street" class="form-control" name="street" placeholder="Street Address" value="{{ $userAddress->street ?? '' }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="number">Number</label>
                <input type="number" id="number" class="form-control" name="number" placeholder="Number" value="{{ $userAddress->number ?? '' }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="city">City</label>
                <input type="text" id="city" class="form-control" name="city" placeholder="City" value="{{ $userAddress->city ?? '' }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="postal_code">Postal Code</label>
                <input type="text" id="postal_code" class="form-control" name="postal_code" placeholder="Postal Code" value="{{ $userAddress->postal_code ?? '' }}" required>
            </div>
        </div>

        <!-- Products Section -->
        <div class="col-md-6" style="height: 100%; overflow: auto;">
            <h4 class="section-title mb-4">
                <span class="cart-icon">
                    <img src="{{ asset('images/shopping-cart.png') }}" class="icon" />
                </span>
                <strong>Your Products</strong>
            </h4>
            <table class="table table-bordered mb-4">
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
                    @foreach($cartItems as $cartItem)
                        <tr>
                            <th scope="row">{{ $cartItem->product->code }}</th>
                            <td>
                                <a href="/products/{{ $cartItem->product->product_id }}" class="product-link">{{ $cartItem->product->title }}</a>
                            </td>
                            <td>{{ $cartItem->quantity }}</td>
                            <td>{{ number_format($cartItem->product->price, 2) }} €</td>
                            <td>{{ number_format($cartItem->quantity * $cartItem->product->price, 2) }} €</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <h3 class="text-end">Total Amount: {{ number_format($totalAmount, 2) }} €</h3>

            <!-- Card Details Section -->
            <h3 class="mt-4 mb-3">Enter Your Card Details</h3>
            <div class="form-group mb-3">
                <label for="card-holder-name">Card Holder Name</label>
                <input type="text" id="card-holder-name" class="form-control" name="card_holder_name" placeholder="Full Name" required>
            </div>
            <div class="form-group mb-3">
                <label for="card-number">Card Number</label>
                <input type="text" id="card-number" class="form-control" name="card_number" placeholder="1234 5678 9101 1121" required>
            </div>
            <div class="form-row mb-3">
                <div class="col">
                    <label for="expiry-date">Expiry Date</label>
                    <input type="text" id="expiry-date" class="form-control" name="expiry_date" placeholder="MM/YY" required>
                </div>
                <div class="col">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" class="form-control" name="cvv" placeholder="123" required>
                </div>
            </div>
            <div class="form-group mb-3">
                <textarea class="form-control" name="comments" placeholder="Any additional comments..."></textarea>
            </div>
            <div class="form-check mb-3">
                <input id="order-terms" class="form-check-input" type="checkbox" name="terms" required>
                <label class="form-check-label" for="order-terms">
                    I have read and accept the Terms and Conditions and Privacy Policy for this order.
                </label>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Create Order</button>
        </div>
    </form>
</div>

<style>
    /* Custom CSS for styling */
    .main-container {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .section-title {
        font-size: 1.5rem;
        color: #495057;
        font-weight: 600;
    }

    .icon {
        width: 40px;
        height: 40px;
        vertical-align: middle;
    }

    .cart-icon {
        margin-right: 10px;
    }

    .form-group label {
        font-weight: bold;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 12px;
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0,123,255,0.5);
    }

    .product-link {
        color: #007bff;
        text-decoration: none;
    }

    .product-link:hover {
        text-decoration: underline;
    }

    table th, table td {
        text-align: center;
        vertical-align: middle;
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table-bordered th, .table-bordered td {
        padding: 15px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 1.1rem;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .form-check-label {
        font-size: 0.9rem;
    }

    .form-check-input {
        margin-top: 2px;
    }

    h3 {
        font-size: 1.4rem;
        color: #495057;
        font-weight: 600;
    }

    textarea.form-control {
        height: 120px;
        resize: vertical;
    }
</style>
@endsection
