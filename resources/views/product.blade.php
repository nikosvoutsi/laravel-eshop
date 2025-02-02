@extends('layouts.app')

@section('content')
<div class="main-container container" style="max-width: 70%;">
    <div class="row category" style="margin: 30px 0;">
        <div class="product-info text-primary">
            <span><a href="/search_results" style="text-decoration: none;">All Products</a></span>
            <span> > </span>
            <span style="color: {{$category->color}}">{{$category->title}}</span>
        </div>
    </div>

    <div class="product-container row">
        <div class="col-md-3 text-center"> <!-- Adjusted column width for medium screens -->
            <div class="image-container" style="width: 200px; height: 200px; margin: 0 auto; background: url() no-repeat center; background-size: contain;">
                @if($product->image_url)
                    <img src="{{ asset('images/' . $product->image_url) }}" alt="" style="width: 100%; height: 100%;">
                @else
                    <img src="{{ asset('images/product.png') }}" alt="" style="width: 100%; height: 100%;">
                @endif
            </div>
        </div>
        <div class="col-md-6"> <!-- Adjusted column width for medium screens -->
            <h3>{{$product->title}}</h3>
            <span>
                <div class="star-rating">
                    <h5><b>{{ number_format($product->avg_review, 1) }}</b>
                        <span class=".star-rating .star.active">&#9733;</span> ({{  $reviews->count()  }})    
                    </h5>
                </div>
            </span>
            <span><p class="text-primary">Code: {{$product->code}}</p></span>
            
            <div style="max-width: 80%;"> <!-- Adjusted max-width of the description for responsiveness -->
                {{$product->short_description}}
            </div>
        </div>
        <div class="col-md-3 text-end"> <!-- Adjusted column width for medium screens and alignment -->
            <h3>{{$product->price}} €</h3>
            @if($product->stock > 0)
            <form action="{{ route('cart.add', ['product' => $product]) }}" method="post" class="float-end">
                @csrf
                <div class="input-group">
                    <button class="btn btn-danger btn-md" type="submit">Add to Cart</button>
                </div>
            </form>
            @else
                <span class="badge bg-warning text-dark">Out of Stock</span>
            @endif
            @if(session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
            @endif
        </div>
    </div><br><br>	

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation" style="cursor: pointer;">
            <a class="nav-link " id="product-details-tab"
               data-bs-toggle="tab"
               data-bs-target="#product-details"
               type="button" role="tab">Details</a>
        </li>
        <li class="nav-item" role="presentation" style="cursor: pointer;">
            <a class="nav-link " id="product-reviews-tab"
               data-bs-toggle="tab"
               data-bs-target="#product-reviews"
               type="button" role="tab">Reviews</a>
        </li>
        <li class="nav-item" role="presentation" style="cursor: pointer;">
            <a class="nav-link " id="similar-products-tab"
               data-bs-toggle="tab" data-bs-target="#similar-products"
               type="button" role="tab">Similar Products</a>
        </li>
    </ul>

    <div class="tab-content" id="profileTabContent">
        <div class="tab-pane fade" id="product-details"
          role="tabpanel" aria-labelledby="product-details-tab" style="padding: 20px 10px;">
          <p>{{$product->long_description}}</p>
        </div>
        <div class="tab-pane fade" id="product-reviews" role="tabpanel" aria-labelledby="product-reviews-tab" style="padding: 20px 10px;">
            <div class="add-review d-flex justify-content-end">
                <button type="button" id="showReviewModal" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addReviewModal">Add Review</button>

                <!-- Order Modal -->
                <div class="modal fade" id="addReviewModal" tabindex="-1"
                aria-labelledby="orderModal" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered modal-lg">
                   <div class="modal-content">
                    <form action="{{ route('product.addReview', ['product_id' => $product->product_id]) }}" method="POST" onsubmit="return validateForm();">
                        @csrf
                        <input type="hidden" name="score" id="review-score" value="1" required>
                           <div class="modal-header">
                               <h5 class="modal-title" id="exampleModalLabel">Add Review
                                   - {{$product->title}}</h5>
                                   <button type="button" id="close" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size:1vw">&times;</button>

                           </div>
                           <div class="modal-body" id="reviewModal">
                               <div id="review-rating">
                                <div class="star-rating" data-rating="0">
                                    <span class="star" data-value="1" name="score">&#9733;</span>
                                    <span class="star" data-value="2" name="score">&#9733;</span>
                                    <span class="star" data-value="3" name="score">&#9733;</span>
                                    <span class="star" data-value="4" name="score">&#9733;</span>
                                    <span class="star" data-value="5" name="score">&#9733;</span>
                                </div>
    
                                <script>
                                    // Show the review modal when clicking "Add Review"
                                    document.getElementById('showReviewModal').addEventListener('click', function () {
                                        document.getElementById('reviewModal').style.display = 'block';
                                    });
                                
                                    // Handle star rating
                                    const stars = document.querySelectorAll('.star-rating .star');
const scoreInput = document.getElementById('review-score');

stars.forEach(star => {
    star.addEventListener('click', () => {
        const rating = star.getAttribute('data-value');
        document.querySelector('.star-rating').setAttribute('data-rating', rating);
        scoreInput.value = rating; // Set the score input field

        // Update the appearance of stars (make previous stars filled)
        stars.forEach(s => {
            const sValue = s.getAttribute('data-value');
            if (sValue <= rating) {
                s.classList.add('active');
            } else {
                s.classList.remove('active');
            }
        });
    });
})
                                
                                    // Handle review submission
                                    document.getElementById('submitReview').addEventListener('click', function () {
                                        const rating = document.querySelector('.star-rating').getAttribute('data-rating');
                                        const reviewText = document.getElementById('reviewText').value;
                                        
                                        // Check if a rating has been selected
                                        if (rating === '0') {
                                            alert('Please select a star rating.');
                                            return;
                                        }
                                
                                        // Now, you can proceed with inserting the review into the database
                                        // and display the success message.
                                        // ...
                                
                                        // Hide the modal
                                        document.getElementById('reviewModal').style.display = 'none';
                                
                                        // Display the success message (for demonstration)
                                        alert('Review submitted successfully');
                                    });

                                    function validateForm() {
                                    const rating = document.querySelector('.star-rating').getAttribute('data-rating');
                                     if (rating === "0") {
                                      alert('Please select a star rating before submitting the review.');
                                      return false; // Prevent form submission
                                     }
                                    return true; // Allow form submission
                                    }
                                </script>
                               </div>
                               <textarea class="form-control" name="review" required></textarea>
                           </div>
                           <div class="modal-footer">
                               <button type="submit" class="btn btn-primary">Save</button>
                           </div>
                       </form>
                   </div>
                </div>
               </div>
            </div>
        
            <!-- Display all product reviews -->
            @if($reviews->count() > 0)
                @foreach($reviews as $review)
                    <div class="product-container row">
                        <div class="col-2 mb-3">
                            <p><strong>{{ $review->user->first_name }} {{ $review->user->last_name }}</strong></p>
                            <!-- Display review score as stars or some other format -->
                            <div class="review-stars">
                                @for($i = 1; $i <= $review->score; $i++)
                                   <i class="fas fa-star fa-lg"></i> <!-- Use a filled star icon for a scored star -->
                                @endfor
                                @for($i = $review->score + 1; $i <= 5; $i++)
                                   <i class="far fa-star fa-lg"></i> <!-- Use an empty star icon for an un-scored star -->
                                @endfor
                            </div>
                            <p>{{ $review->created_at->format('Y-m-d') }}</p>
                        </div>
                        <div class="col-10 mb-3">
                            <pre>{{ $review->review }}</pre>
                        </div>
                    </div>
                    <hr>
                @endforeach
            @else
                <p>No reviews available for this product.</p><i class="bi bi-star-fill"></i>
            @endif
        </div>
        </div>
        <div class="tab-pane fade d-flex justify-content-center" id="similar-products" role="tabpanel" aria-labelledby="similar-products-tab">
            @foreach($similarProducts as $similarProduct)
                <a href="/products/{{ $similarProduct->product_id }}" class="text-center" style="text-decoration: none; margin: 0 10px;">
                    <div class="image-container" style="width: 100px; height: 100px; margin: 10px auto; background: url() no-repeat center; background-size: contain;">
                        @if($product->image_url)
                           <img src="{{ asset('images/' . $similarProduct->image_url) }}" alt="" style="width: 100%; height: 100%;">
                        @else
                           <img src="{{ asset('images/product.png') }}" alt="" style="width: 100%; height: 100%;">
                        @endif
                    </div>
                    <div>{{ $similarProduct->title }}</div>
                    <div>{{ $similarProduct->price }} €</div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection



<script>
    // Trigger a click event on the "Details" tab when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        var detailsTab = document.getElementById('product-details-tab');
        detailsTab.click();

        const formToDisplay = "{{ session('form_to_display') }}";
        if (formToDisplay === 'review') {
            const reviewTab = document.getElementById("product-reviews-tab");
            reviewTab.click();
        }
    });
</script>

<!-- Include Font Awesome via CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>
<script>
// rater.js

// This script assumes you're using Font Awesome for star icons. You can adjust the HTML structure and classes as needed.

$(document).ready(function () {
    // Initialize the rating stars
    $(".star-rating").each(function () {
        var starRating = $(this);
        var starRatingInput = starRating.find("input[type='hidden']");
        var starRatingStars = starRating.find(".star");

        starRatingStars.on("click", function () {
            var starValue = $(this).data("value");
            starRatingInput.val(starValue);

            // Update the appearance of stars
            starRatingStars.each(function () {
                var star = $(this);
                var starNumber = star.data("value");

                if (starNumber <= starValue) {
                    star.addClass("filled");
                } else {
                    star.removeClass("filled");
                }
            });
        });
    });
});
</script> 

<style>
   .fa-star {
    color: rgb(20, 105, 242);
    height:1vw;
}
    /* Star rating styles */
    .star-rating {
        font-size: 1.9vw;
        cursor: pointer;
    }

    .star-rating .star {
        display: inline-block;
        margin-right: 5px;
        color: gray;
    }

    .star-rating .star.active {
        color: rgb(20, 105, 242);
    }

.star-outline {
  width: 100%;
  height: 100%;
  background-color: gray; /* Color for empty stars */
}
</style>

<script>
    function submitReviewForm() {
        // Your existing review submission logic here...

        // After successful submission, trigger a click event on the "Reviews" tab
        document.getElementById('product-reviews-tab').click();

        // Optionally, you can scroll to the reviews section for a better user experience
        // Adjust the target element's id to match your reviews section
        document.getElementById('product-reviews').scrollIntoView({ behavior: 'smooth' });

        // Prevent the default form submission
        return false;
    }
</script>


