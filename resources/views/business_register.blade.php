@extends('layouts.app')

@section('content')
<div class="main-container row" style="height: 100%;">
    <div class="col-12 col-md-5" style="background: #019eff; min-height: 100%; padding-top: 10%; color: #fff;">
        <div class="m-auto" style="width: 70%; text-align: center;">
            <img src="{{ asset('images/store.png') }}" width="150"/>
            <br>
            <br>
            <br>
            <br>
            <h2>Welcome to Big Market!</h2>
            <br>
            <h2>Find everything you need in a click of a button.</h2>
        </div>
    </div>
    <div class="col-12 col-md-7" style="min-height: 100%; overflow: auto;">
        <form action="{{ route('business.register') }}" method="post" style="width: 50%; margin: 50px auto;">
            @csrf
            <div class="form-group row">
                <h4>
                    <span class="register-icon">
                        <img src="{{ asset('images/hacker.png') }}" style="width: 64px; height: 64px; margin-right: 20px;"/>
                    </span>
                    <strong>Register your Business</strong>
                </h4>
            </div>
            <br/>
            @if(session('error'))
              <div class="alert alert-danger">
                {{ session('error') }}
              </div>
            @endif
            <div class="form-group row">
                <div class="col-md-12">
                    <label for="name">Business Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <label for="sector">Business Sector</label>
                    <select class="form-control" id="sector" name="sector" required>
                        <option value="Technology">Technology</option>
                        <option value="Fashion">Fashion</option>
                        <option value="Gaming">Gaming</option>
                        <option value="Sports">Sports</option>
                        <option value="Books">Books</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                   <label for="description">Business Description</label>
                   <textarea class="form-control" id="description" name="description" required></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary float-right">Register</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

<script src="https://kit.fontawesome.com/8879801888.js" crossorigin="anonymous"></script>

