@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="col-12" style="height: 100%; overflow: auto;">
        <div class="profile-container" style="width: 50%; margin: 50px auto;">
            <div class="form-group row mb-3">
                <h4>
                    <span class="register-icon">
                        <img src="images/hacker.png" style="width: 64px; height: 64px; margin-right: 20px;"/>
                    </span>
                    <strong>User Profile</strong>
                </h4>
            </div>
            <br/>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation" style="cursor: pointer;">
                    <a class="nav-link" id="personal-info-tab" data-bs-toggle="tab" data-bs-target="#personal-info" type="button" role="tab">
                        Personal Information
                    </a>
                </li>
                <li class="nav-item" role="presentation" style="cursor: pointer;">
                    <a class="nav-link" id="security-info-tab"
                       data-bs-toggle="tab"
                       data-bs-target="#security-info"
                       type="button" role="tab">Security Information
                    </a>
                </li>
                <li class="nav-item" role="presentation" style="cursor: pointer;">
                    <a class="nav-link " id="address-tab"
                       data-bs-toggle="tab" data-bs-target="#address"
                       type="button" role="tab">Address
                    </a>
                </li>
                <li class="nav-item" role="presentation" style="cursor: pointer;">
                    <a class="nav-link " id="orders-tab" data-bs-toggle="tab"
                       data-bs-target="#orders"
                       type="button" role="tab">Orders
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="profileTabContent">
                <div class="tab-pane fade " id="personal-info"
                     role="tabpanel"
                     aria-labelledby="personal-info-tab">
                     <form action="{{ route('user.personal.update') }}" method="post">
                        @csrf
                        <br>
                        <div class="alert alert-danger {{ session('error') ? '' : 'd-none' }}" role="alert">
                            {{ session('error') }}
                        </div>
                        <div class="alert alert-success {{ session('success') ? '' : 'd-none' }}" role="alert">
                            {{ session('success') }}
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="first_name"
                                       value="{{ Auth::user()->first_name }}"
                                       placeholder="First Name"
                                       required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="last_name" value="{{ Auth::user()->last_name }}"
                                       placeholder="Last Name"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <input type="date" class="form-control" name="birthdate" placeholder="Date of Birth"
                                       value="{{ Auth::user()->birthdate }}">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="phone" placeholder="Phone Number"
                                       maxlength="15"
                                       value="{{ Auth::user()->phone }}">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade " id="security-info"
                     role="tabpanel" aria-labelledby="security-info-tab">
                     <form action="{{ route('user.security.update') }}" method="post">
                        @csrf
                        <br>
                        @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                        @endif
                        @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif
                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" placeholder="Email" value="{{ Auth::user()->email }}">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <input type="password" id="password" class="form-control" name="new_password" placeholder="New Password" value="" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <input type="password"  id="password-confirm" class="form-control" name="new_password_confirmation" placeholder="Repeat Password" value="" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="current_password" placeholder="Current Password" value="" required>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-right">Save</button>
                            </div>
                        </div>
                    </form>
                        
                </div>
                
                <div class="tab-pane fade " id="address" role="tabpanel"
                     aria-labelledby="address-tab">
                    <form action="{{ route('user.address.update') }}" method="post">
                        @csrf
                        <br>
                        <div class="alert alert-danger {{ session('error') ? '' : 'd-none' }}" role="alert">
                            {{ session('error') }}
                        </div>
                        <div class="alert alert-success {{ session('success') ? '' : 'd-none' }}" role="alert">
                            {{ session('success') }}
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="street" placeholder="Street" required
                                value="{{ session('address')->street ?? $address->street ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control" name="number" placeholder="Number" required
                                value="{{ session('address')->number ??  $address->number ?? ''}}">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="city" placeholder="City" required
                                    value="{{ session('address')->city ??  $address->city ?? ''}}">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="postal_code" placeholder="Postal Code"
                                    required value="{{ session('address')->postal_code ??  $address->postal_code ?? ''}}">
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                    <br>
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                        @endif
                        @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Order Id</th>
                            <th scope="col">Date Created</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Info</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($allOrders as $order)
                            <tr>
                                <th scope="row">{{ $order->order_id }}</th>
                                <td>{{ (new DateTime ($order->created_at))->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $order->total_price }} €</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm btn-info"
                                          data-order-modal-id="orderModal{{ $order->order_id }}">Info</button>

                                    <!-- Order Modal -->
                                    <div class="modal fade" id="orderModal{{ $order->order_id }}" class="info" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="orderModalLabel">Order Info - Order ID: {{ $order->order_id }}</h5>
                                                    <h5>Total price: {{$order->total_price}} €</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size:1vw">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Product</th>
                                                                <th scope="col">Company</th>
                                                                <th scope="col">Quantity</th>
                                                                <th scope="col">Price</th>
                                                                <th scope="col">Total Price</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($order->orderProducts as $orderProduct)
                                                                @if($orderProduct->order_id==$order->order_id) 
                                                                  <tr>
                                                                     <td>{{ $orderProduct->product->title }}</td> 
                                                                     {{-- <td>{{ $orderProduct->business ? $orderProduct->business->name : 'N/A' }}</td> --}}
                                                                     <td>{{ $orderProduct->product->business->name }}</td> 
                                                                     <td>{{ $orderProduct->quantity }}</td>
                                                                     <td>{{ $orderProduct->initial_price }} €</td>
                                                                     <td>{{ number_format($orderProduct->quantity * $orderProduct->initial_price, 2)}} €</td>
                                                                  </tr>
                                                                 @endif 
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <p><strong>Comments:</strong></p>
                                                    @foreach($allOrders as $a)
                                                        @if($a->order_id==$order->order_id)
                                                           <p>{{$a->comments}}</p> 
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary " id="close" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabLinks = document.querySelectorAll('.nav-link[data-bs-toggle="tab"]');
        tabLinks.forEach((link) => {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                const targetId = link.getAttribute("data-bs-target");
                const targetTab = document.querySelector(targetId);
                tabLinks.forEach((l) => l.classList.remove("active"));
                link.classList.add("active");
                document.querySelectorAll('.tab-pane.fade').forEach((pane) => {
                    pane.classList.remove("show", "active");
                });
                targetTab.classList.add("show", "active");
            });
        });

        // Trigger a click event on the "Personal Information" tab to activate it by default
        const personalInfoTab = document.getElementById("personal-info-tab");
        personalInfoTab.click();

        // Check if a form was submitted and which one
        const formToDisplay = "{{ session('form_to_display') }}";

        if (formToDisplay === 'address') {
            const addressTab = document.getElementById("address-tab");
            addressTab.click();
        } else if (formToDisplay === 'security-info') {
            const securityInfoTab = document.getElementById("security-info-tab");
            securityInfoTab.click();
        } else if (formToDisplay === 'orders') {
            const ordersTab = document.getElementById("orders-tab");
            ordersTab.click();
        }

        // Modal initialization code
        const infoButtons = document.querySelectorAll('.btn-info');

        infoButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const orderModalId = button.getAttribute("data-order-modal-id");
                const orderModal = new bootstrap.Modal(document.getElementById(orderModalId));
                orderModal.show();
            });
        });

        // Add the code to reinitialize the modal here
        $('#orderModal').on('hidden.bs.modal', function (e) {
            $(this).removeData('bs.modal');
        });

        // Close button click event
        const closeButton = document.querySelector('.btn-close');
        closeButton.addEventListener("click", function () {
            const activeModal = document.querySelector('.modal.show');
            activeModal.style.display = 'none'; // Close the active modal
        });
    });
</script>

