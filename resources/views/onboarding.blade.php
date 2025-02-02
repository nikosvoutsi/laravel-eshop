@extends('layouts.app')

@section('content')
<div class="main-container row" style="height: 100%;">
    <div class="col-12 col-md-5" style="background: #019eff; min-height: 100%; padding-top: 10%; color: #fff;">
        <div class="m-auto" style="width: 70%; text-align: center;">
            <img src="images/store_color.png" width="150"/>
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
        <form action="/onboarding" method="post" style="width: 50%; margin: 50px auto;">
            @csrf
            <div class="form-group row">
                <h4>
                    <span class="register-icon">
                        <img src="images/hacker.png" style="width: 64px; height: 64px; margin-right: 20px;"/>
                    </span>
                    <strong>Complete your profile</strong>
                </h4>
            </div>
            <br/>
            {{-- <div class="alert alert-danger" role="alert">Error Message</div> --}}
            <p><strong>Personal Info</strong></p>
            <hr/>
            <div class="form-group row">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="first_name"  value="{{ Auth::user()->first_name }}"
                           placeholder="First Name"
                           required>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="last_name"  value="{{ Auth::user()->last_name }}"
                           placeholder="Last Name"
                           required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <input type="date" class="form-control date-input" name="birthdate" placeholder="Date of Birth"
                           value="">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <input type="text" class="form-control" name="phone" placeholder="Phone Number" maxlength="15"
                           value="">
                </div>
            </div>
            <p><strong>Your Address</strong></p>
            <hr/>
            <div class="form-group row">
                <div class="col-md-8">
                    <input type="text" class="form-control" name="street" placeholder="Address" required
                           value="">
                </div>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="number" placeholder="Number" required
                           value="">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-8">
                    <input type="text" class="form-control" name="city" placeholder="City" required
                           value="">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="postal_code" placeholder="Postal Code" required
                           value="">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary float-right">Continue</button>
                    <a href="/" target="_self" class="btn btn-outline-secondary float-right right"
                       style="margin-right: 10px;">Skip this step</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

<script src="https://kit.fontawesome.com/8879801888.js" crossorigin="anonymous"></script>
<script>
    // Get all date input fields with the 'date-input' class
    const dateInputs = document.querySelectorAll('.date-input');

    dateInputs.forEach((dateInput) => {
        dateInput.addEventListener('input', (e) => {
            const inputValue = e.target.value;

            if (inputValue) {
                const date = new Date(inputValue);
                const formattedDate = date.toLocaleDateString('en-US');
                e.target.value = formattedDate;
            }
        });
    });
</script>
