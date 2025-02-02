<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Models\Order;
use App\Models\Business;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ProductCategory;
use App\Models\OrderProduct;
use Auth;


class ProductController extends Controller{

/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function show($id)
{
    // Retrieve the product by its ID along with its associated category and reviews
    $product = Product::with('category', 'productReviews.user')->find($id);

    // Check if the product exists
    if (!$product) {
        abort(404); // You can customize this based on your error handling approach
    }

    // Now you can access the product's category and reviews
    $category = $product->category;
    $reviews = $product->productReviews()->orderBy('created_at', 'desc')->get();

    // Retrieve similar products based on category and price criteria
    $similarProducts = Product::where('category_id', $category->category_id)
        ->whereBetween('price', [$product->price - 100, $product->price + 100])
        ->where('product_id', '<>', $product->product_id) // Exclude the current product
        ->get();


    // Pass the currently authenticated user to the view
    $user = Auth::user();
    return view('product', compact('product', 'category', 'reviews', 'user', 'similarProducts'));
}

public function addReview(Request $request, $product_id)
    {
        // Get the authenticated user's ID (assuming you are using Laravel's authentication)
        $user_id = auth()->user()->id;

        // Validate the request data
        $validatedData = $request->validate([
            'score' => 'required|integer|between:1,5', // Assuming a score between 1 and 5
            'review' => 'required|string',
        ]);

        // Insert the review into the database
        ProductReview::create([
            'product_id' => $product_id,
            'score' => $validatedData['score'],
            'review' => $validatedData['review'],
            'user_id' => $user_id,
        ]);

        // Redirect or return a response as needed
        // For example, redirect back to the product page with a success message
        return redirect()->route('product.show', ['product_id' => $product_id])->with('success', 'Review added successfully')->with('form_to_display', 'review');
    }
}

 
