@extends('layouts.app')

@section('content')
<div class="main-container" style="width: 50%; margin: 50px auto;">
    <h3 class="mb-4">Enter Your Card Details</h3>
    <form method="GET" action="#">
        @csrf
        <div class="form-group mb-3">
            <label for="card-holder-name">Card Holder Name</label>
            <input type="text" id="card-holder-name" class="form-control" placeholder="Full Name" required>
        </div>
        <div class="form-group mb-3">
            <label for="card-number">Card Number</label>
            <input type="text" id="card-number" class="form-control" placeholder="1234 5678 9101 1121" required>
        </div>
        <div class="form-row mb-3">
            <div class="col">
                <label for="expiry-date">Expiry Date</label>
                <input type="text" id="expiry-date" class="form-control" placeholder="MM/YY" required>
            </div>
            <div class="col">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" class="form-control" placeholder="123" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
