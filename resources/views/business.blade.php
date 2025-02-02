@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="col-12" style="height: 100%; overflow: auto;">
        <div class="profile-container" style="width: 50%; margin: 50px auto;">
            <div class="form-group row mb-3">
                <h4>
                    <span class="register-icon">
                        <img src="{{ asset('images/hacker.png') }}" style="width: 64px; height: 64px; margin-right: 20px;"/>
                    </span>
                    <strong>Business Profile</strong>
                </h4>
            </div>
            <br/>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation" style="cursor: pointer;">
                    <a class="nav-link {{ $section == 'basic' ? 'active' : '' }}" id="basic-info-tab"
                       data-bs-toggle="tab" data-bs-target="#basic-info"
                       type="button" role="tab">Basic Information
                    </a>
                </li>
                <li class="nav-item" role="presentation" style="cursor: pointer;">
                    <a class="nav-link {{ $section == 'products' ? 'active' : '' }}" id="products-tab"
                       data-bs-toggle="tab" data-bs-target="#products"
                       type="button" role="tab">Products
                    </a>
                </li>
                <li class="nav-item" role="presentation" style="cursor: pointer;">
                    <a class="nav-link {{ $section == 'orders' ? 'active' : '' }}" id="orders-tab"
                       data-bs-toggle="tab" data-bs-target="#orders"
                       type="button" role="tab">Orders
                    </a>
                </li>
            </ul>
            <br>
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @if(session('tab') === 'products')
                    <script>
                        $(document).ready(function () {
                            // Activate the 'products' tab
                        $('#products-tab').tab('show');
                        });
                    </script>
                @endif
            @endif
            <div class="tab-content" id="profileTabContent">
                <div class="tab-pane fade {{ $section == 'basic' ? 'show active' : '' }}" id="basic-info"
                     role="tabpanel" aria-labelledby="basic-info-tab">
                    <form action="{{ route('business') }}" method="post">
                        @csrf
                        @if ($basic_info_error ?? false)
                            <div class="alert alert-danger" role="alert">{{ $basic_info_error_message }}</div>
                        @endif
                        @if ($basic_info_success ?? false)
                            <div class="alert alert-success" role="alert">{{ $basic_info_success_message }}</div>
                        @endif
                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="name"
                                       value="{{ $businessInfo['name'] ?? '' }}"
                                       placeholder="Name"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <select class="form-control" name="sector">
                                    <option value="technology" {{ ($businessInfo['sector'] ?? '') == 'technology' ? 'selected' : '' }}>
                                        Technology
                                    </option>
                                    <option value="Fashion" {{ ($businessInfo['sector'] ?? '') == 'Fashion' ? 'selected' : '' }}>
                                        Fashion
                                    </option>
                                    <option value="Gaming" {{ ($businessInfo['sector'] ?? '') == 'Gaming' ? 'selected' : '' }}>
                                        Gaming
                                    </option>
                                    <option value="Sports" {{ ($businessInfo['sector'] ?? '') == 'Sports' ? 'selected' : '' }}>
                                        Sports
                                    </option>
                                    <option value="Books" {{ ($businessInfo['sector'] ?? '') == 'Books' ? 'selected' : '' }}>
                                        Books
                                    </option>
                                    <option value="Other" {{ ($businessInfo['sector'] ?? '') == 'Other' ? 'selected' : '' }}>
                                        Other
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <textarea class="form-control"
                                          name="description">{{ $businessInfo['description'] ?? '' }}</textarea>
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade {{ $section == 'products' ? 'show active' : '' }}" id="products"
                     role="tabpanel" aria-labelledby="products-tab">
                    <br>
                    @if ($products_error ?? false)
                        <div class="alert alert-danger" role="alert">{{ $products_error_message }}</div>
                    @endif
                    @if ($products_success ?? false)
                        <div class="alert alert-success" role="alert">{{ $products_success_message }}</div>
                    @endif
                    
                    <br>
                    <div class="add-review d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#addProduct">Add New Product
                        </button>
                        <!-- New Product Modal -->
                        <div class="modal fade" id="addProduct" tabindex="-1"
                             aria-labelledby="addModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <form action="{{ route('business.products') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Create a Product</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size:1vw">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group row mb-3">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="code"
                                                           placeholder="Product Code" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="title"
                                                           placeholder="Title" required>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <div class="col-md-6">
                                                    <select class="form-control" name="category_id" required>
                                                        @foreach($productCategories as $productCategory)
                                                            <option
                                                                value="{{ $productCategory['category_id'] }}">{{ $productCategory['title'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control" name="price"
                                                           placeholder="Price" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control" name="stock"
                                                           placeholder="Stock" required>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <div class="col-md-12">
                                                    <textarea class="form-control" name="short_description" rows="2"
                                                              required placeholder="Short Description"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <div class="col-md-12">
                                                    <textarea class="form-control" name="long_description" rows="5"
                                                              required placeholder="Long Description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <div class="col-md-12">
                                                <label class="form-check-label" for="photo">Choose Photo:</label>
                                                <input type="file"  name="photo" class="form-control">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    @foreach($products as $product)
                        <div class="product-container row">
                            <div class="col-2 mb-3 text-center">
                                <div class="image-container" style="width: 150px; height: 150px; margin: 0 auto; background: url() no-repeat center; background-size: contain;">
                                    @if($product->image_url)
                                     <img src="{{ asset('images/' . $product->image_url) }}" alt="" style="width: 150px; height: 150px;">
                                    @else
                                     <img src="images/product.png" alt="" style="width: 150px; height: 150px;">
                                    @endif
                                 </div>
                            </div>
                            <div class="col-8 mb-3">
                                <h4>{{$product['title']}}</h4>
                                <div class="star-rating">
                                    <h5><b>{{ number_format($product->avg_review, 1) }}</b>
                                        <span class=".star-rating .star.active">&#9733;</span> ({{  $product->reviews->count()  }})    
                                    </h5>
                                </div>
                                <p>{{$product['short_description']}}</p>
                            </div>
                            <div class="col-2 mb-3 text-end">
                                <h3>{{$product['price']}} €</h3>

                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editProduct{{ $product['product_id'] }}">Edit
                                </button>
                                <!-- Edit Product Modal -->
                                <div class="modal fade" id="editProduct{{ $product['product_id'] }}" tabindex="-1"
                                     aria-labelledby="addModal" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content">
                                            <form action="/business/products/{{ $product['product_id'] }}"
                                                  method="post">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Product</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size:1vw">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group row mb-3">
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="code"
                                                                   placeholder="Product Code" required
                                                                   value="{{ $product['code'] }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="title"
                                                                   placeholder="Title" required
                                                                   value="{{ $product['title'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <div class="col-md-6">
                                                            <select class="form-control" name="category_id" required>
                                                                @foreach($productCategories as $productCategory)
                                                                    <option
                                                                        value="{{ $productCategory['category_id'] }}" {{ $product['category_id'] == $productCategory['category_id'] ? 'selected' : '' }}>{{ $productCategory['title'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="number" class="form-control" name="price"
                                                                   placeholder="Price" required
                                                                   value="{{ $product['price'] }}">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="number" class="form-control" name="stock"
                                                                   placeholder="Stock" required
                                                                   value="{{ $product['stock'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <div class="col-md-12">
                                                    <textarea class="form-control" name="short_description" rows="2"
                                                              required
                                                              placeholder="Short Description">{{ $product['short_description'] }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <div class="col-md-12">
                                                    <textarea class="form-control" name="long_description" rows="5"
                                                              required
                                                              placeholder="Long Description">{{ $product['long_description'] }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="tab-pane fade {{ $section == 'orders' ? 'show active' : '' }}" id="orders" role="tabpanel"
                aria-labelledby="orders-tab">
               <br>
               <table class="table table-bordered">
                   <thead>
                   <tr>
                       <th scope="col">Order Id</th>
                       <th scope="col">Date Created</th>
                       <th scope="col">User</th>
                       <th scope="col">Total Price</th>
                       <th scope="col">Info</th>
                   </tr>
                   </thead>
                   <tbody>
                   @foreach ($orders as $order)
                       <tr>
                           <th scope="row">{{ $order['order_id'] }}</th>
                           <td>{{ (new DateTime($order['created_at']))->format('Y-m-d') }}</td>
                           <td>{{ $order['user']['first_name'].' '.$order['user']['last_name'] }}</td>
                           <td>{{ $order['total_price'] }} €</td>
                           <td>
                               <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                       data-bs-target="#orderModal{{ $order['order_id'] }}">Info
                               </button>
                               <!-- Order Modal -->
                               <div class="modal fade" id="orderModal{{ $order['order_id'] }}" tabindex="-1"
                                    aria-labelledby="orderModal" aria-hidden="true">
                                   <div class="modal-dialog modal-dialog-centered modal-xl">
                                       <div class="modal-content">
                                           <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">Order Info
                                                   - {{ $order['order_id'] }}</h5>
                                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size:1vw">&times;</button>
                                           </div>
                                           <div class="modal-body">
                                               <table class="table table-bordered">
                                                   <thead>
                                                   <tr>
                                                       <th scope="col">Product</th>
                                                       <th scope="col">Quantity</th>
                                                       <th scope="col">Price</th>
                                                       <th scope="col">Total Price</th>
                                                   </tr>
                                                   </thead>
                                                   <tbody>
                                                    @foreach($order->orderProducts as $orderProduct)
                                                        @if($orderProduct->order_id==$order['order_id']) 
                                                      <tr>
                                                        <td>{{ $orderProduct->product->title }}</td> 
                                                        <td>{{ $orderProduct->quantity }}</td>
                                                        <td>{{ $orderProduct->initial_price }} €</td>
                                                        <td>{{ number_format($orderProduct->quantity * $orderProduct->initial_price, 2)}} €</td>
                                                      </tr>
                                                      @endif
                                                     @endforeach
                                                   </tbody>
                                               </table>
                                               <p><strong>Comments:</strong></p>
                                               <p>{{ $order['comments'] }}</p>
                                           </div>
                                           <div class="modal-footer">
                                               <button type="button" class="btn btn-primary"
                                                       data-bs-dismiss="modal">Close
                                               </button>
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



