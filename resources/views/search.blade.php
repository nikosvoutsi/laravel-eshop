@extends('layouts.app')

@section('content')
<div class="search-container" style="position: absolute; width: 100%; z-index: 5; background-color: #ccc;">
    <form id="search-form" action="{{ route('search_results') }}" method="get" style="margin: 20px 40px;">
        <div class="input-group">
            <input type="search" class="form-control" placeholder="Search for a Product" required
                   aria-label="Search for a Product" aria-describedby="search-button" name="search"
                   value="">
            <button class="btn btn-primary" type="submit" id="search-button">Search</button>
        </div>
    </form>
</div>
<div class="main-container" style="padding-top: 78px">
    <div class="row" style="height: 100%; overflow: auto;">
        <div class="filter-container col-3" style="padding: 20px 40px; border-right: 1px solid #ccc; margin-top: 20px;">
            <form id="filter-form" action="{{ route('search_results') }}" method="get">
                <input type="hidden" name="search" value="">
                <input type="hidden" name="order_by" value="{{ $orderBy }}">
                <h5>Order By</h5>
                <select class="form-select" name="order_by" onchange="document.getElementById('filter-form').submit()">
                    <option value="default" {{ $orderBy === 'default' ? 'selected' : '' }}>Order by</option>
                    <option value="price_asc" {{ $orderBy === 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                    <option value="price_desc" {{ $orderBy === 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                    <option value="newest_first" {{ $orderBy === 'newest_first' ? 'selected' : '' }}>Newest First</option>
                    <option value="oldest_first" {{ $orderBy === 'oldest_first' ? 'selected' : '' }}>Oldest First</option>
                </select>
                <br><br>
                <div class="product-category">
                    <h5>Categories</h5>
                    @foreach ($categories as $category)
                        <div class="form-check">
                            <input id="category-check-{{ $category->category_id }}" class="form-check-input" type="checkbox"
                              name="categories[]" value="{{ $category->category_id }}"
                             {{ in_array($category->category_id, $selectedCategories) ? 'checked' : '' }}>
                            <label class="form-check-label" for="category-check-{{ $category->category_id }}">
                                {{ $category->title }} ({{ $category->products_count }})
                            </label>
                        </div>
                    @endforeach
                    <hr>
                </div>
                <div class="price-range">
                    <h5>Price Range</h5>
                    <div class="form-check">
                        <input id="price-range-100" class="form-check-input" type="radio"
                               name="priceRange" value="100"
                                onchange="document.getElementById('filter-form').submit()"
                                {{ $priceRange === '100' ? 'checked' : '' }}>
                        <label class="form-check-label" for="price-range-100"> < € 100 ({{$priceRanges[0]}})
                        </label>
                    </div>
                    <div class="form-check">
                        <input id="price-range-500" class="form-check-input" type="radio"
                               name="priceRange" value="500"
                                onchange="document.getElementById('filter-form').submit()"
                                {{ $priceRange === '500' ? 'checked' : '' }}>
                        <label class="form-check-label" for="price-range-500"> € 100 - € 500 ({{$priceRanges[1]}})
                        </label>
                    </div>
                    <div class="form-check">
                        <input id="price-range-1000" class="form-check-input" type="radio"
                               name="priceRange" value="1000"
                                onchange="document.getElementById('filter-form').submit()"
                                {{ $priceRange === '1000' ? 'checked' : '' }}>
                        <label class="form-check-label" for="price-range-1000"> € 500 - € 1000 ({{$priceRanges[2]}})
                        </label>
                    </div>
                    <div class="form-check">
                        <input id="price-range-inf" class="form-check-input" type="radio"
                               name="priceRange" value="inf"
                                onchange="document.getElementById('filter-form').submit()"
                                {{ $priceRange === 'inf' ? 'checked' : '' }}>
                        <label class="form-check-label" for="price-range-inf"> > € 1000 ({{$priceRanges[3]}})
                        </label>
                    </div>
                    <hr>
                </div>
                <div class="availability-filter">
                    <h5>Availability</h5>
                    <div class="form-check">
                        <input id="in-stock" class="form-check-input" type="checkbox"
                               name="in_stock" value="1"
                               {{ $selectedInStock ? 'checked' : '' }}
                                onchange="document.getElementById('filter-form').submit()">
                        <label class="form-check-label" for="in-stock"> In Stock ({{ $inStockCount}})
                        </label>
                    </div>
                    {{-- <div class="form-check">
                        <input id="out-of-stock" class="form-check-input" type="checkbox"
                               name="out_of_stock" value="1"
                               {{ $selectedOutOfStock ? 'checked' : '' }}
                                onchange="document.getElementById('filter-form').submit()">
                        <label class="form-check-label" for="out-of-stock"> Out of Stock ({{ $outOfStockCount }})
                        </label>
                    </div> --}}
                </div><br>
                {{-- <button type="submit" class="btn btn-primary">Apply Filters</button> --}}
            </form>
        </div>
        <div class="search-results-container col-9" style="padding: 40px;">
            @if($results->count() > 0)
               @foreach($results as $product)
                  <div class="product-container row">
                      <div class="col-2 mb-3 text-center">
                        <div class="image-container" style="width: 150px; height: 150px; margin: 0 auto; background: url() no-repeat center; background-size: contain;">
                           @if($product->image_url)
                            <img src="images/{{$product->image_url}}" alt="" style="width: 150px; height: 150px;">
                           @else
                            <img src="images/product.png" alt="" style="width: 150px; height: 150px;">
                           @endif
                        </div>
                      </div>
                      <div class="col-8 mb-3">
                         <h3>{{ $product->title }}</h3>
                         <p>{{ $product->short_description }}</p>
                         <div class="product-info text-primary">
                            <span style="color:{{ $product->category->color }}">{{ $product->category->title }}</span>
                           <span>|</span>
                           <a href="{{ route('product.show', ['product_id' => $product->product_id]) }}" style="text-decoration: none;">More Info</a>
                           
                         </div>
                      </div>
                      <div class="col-2 mb-3 text-end">
                         <h3>{{$product->price}} € </h3>
                         @if($product->stock > 0)
                         <form action="{{ route('cart.add', ['product' => $product]) }}" method="post" class="float-end">
                            @csrf
                               <button class="form-control btn-danger btn-sm" type="submit">Add to Cart</button>
                            </form>
                         @else
                           <span class="badge bg-warning text-dark">Out of Stock</span>
                         @endif
                         @if(session('success')  && session('added_product_id') == $product->product_id)
                            <div class="alert alert-success">
                              {{ session('success') }}
                            </div>
                         @endif
                      </div>
                  </div>
                  <hr>
                @endforeach
                <div class="pagination float-end">
                  @if($results->count() > 25)
                    @if ($results->onFirstPage())
                        <!-- If on the first page, show the "Next Page" button only -->
                        <a href="{{ $results->nextPageUrl() }}"
                           class="btn btn-outline-primary"
                           id="next-page"
                           style="margin-right: 10px;">Next Page</a>
                    @elseif ($results->hasMorePages())
                        <!-- If not on the first or last page, show both "Previous Page" and "Next Page" buttons -->
                        <a href="{{ $results->previousPageUrl() }}"
                           class="btn btn-outline-primary"
                           id="previous-page"
                           style="margin-right: 10px;">Previous Page</a>
                        <a href="{{ $results->nextPageUrl() }}"
                           class="btn btn-outline-primary"
                           id="next-page"
                           style="margin-right: 10px;">Next Page</a>
                    @else
                        <!-- If on the last page, show the "Previous Page" button only -->
                        <a href="{{ $results->previousPageUrl() }}"
                           class="btn btn-outline-primary"
                           id="previous-page"
                           style="margin-right: 10px;">Previous Page</a>
                    @endif
                  @endif
                </div>
            @else
                <div class="alert alert-warning" role="alert">There are no products matching your search criteria!</div>
            @endif
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Listen for the change event on checkboxes
        $('input[type="checkbox"]').change(function() {
            // Trigger the form submission
            $('#filter-form').submit();
        });
    });
</script>

