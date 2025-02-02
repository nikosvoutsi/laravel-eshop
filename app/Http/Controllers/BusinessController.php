<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Business;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductCategory;
use App\Models\ProductReview;
use App\Models\User;
use Auth;

class BusinessController extends Controller
{
    public function registerBusinessForm()
{
    return view('business_register');
}

public function registerBusiness(Request $request)
{
    // Get the currently authenticated user
    $user = Auth::user();

    // Check if the user already has a business
    if ($user->business) {
        return redirect()->back()->with('error', 'You already have a business.');
    }

    // Validate the request
    $request->validate([
        'name' => 'required|string',
        'description' => 'required|string',
        'sector' => 'required|string',
    ]);

    // Create a new business and associate it with the user
    $business = $user->business()->create([
        'name' => $request->input('name'),
        'description' => $request->input('description'),
        'sector' => $request->input('sector'),
    ]);

    return redirect()->route('home')->with('success', 'Business registered successfully!');
}


public function businessPage(Request $request)
{
    // Get the authenticated user
    $user = auth()->user();

    // Check if the user has a business
    if ($user->business) {
        // Retrieve the user's products
        $products = Product::where('business_id', $user->business->id)->get();

        // Retrieve product categories
        $productCategories = ProductCategory::all();

        // Retrieve the user's business information
        $businessInfo = $user->business;

        $businessId = $businessInfo->id; // Assuming the business ID is stored in the 'id' column of the 'business' table

        // Retrieve orders and related product information for a specific business
        $orders = Order::with(['orderProducts.product', 'user'])
            ->whereHas('orderProducts.product', function ($query) use ($businessId) {
                $query->where('business_id', $businessId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

            

        // Load additional information for each order product
        $orders->each(function ($order) {
            $order->orderProducts->each(function ($orderProduct) {
                $orderProduct->load('product');
            });
        });

        // Retrieve product reviews for each product
        $reviews = $products->map(function ($product) {
            $product->reviews = $product->productReviews()->orderBy('created_at', 'desc')->get();
            return $product;
        });

        // Check if the form is submitted
        if ($request->isMethod('post')) {
            // Validate the business information form data
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'sector' => 'required|string',
            ]);

            // Update the business information
            $user->business->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'sector' => $request->input('sector'),
            ]);

            // Redirect with success message for updating business information
            return redirect()->route('business')->with([
                'success' => 'Business information updated successfully!',
                'products' => $products,
                'productCategories' => $productCategories,
                'reviews' => $reviews,
                'orders' => $orders
            ]);
        }

        // Return the view with the business information
        return view('business', [
            'section' => 'basic',
            'businessInfo' => $businessInfo,
            'products' => $products,
            'productCategories' => $productCategories,
            'reviews' => $reviews,
            'orders' => $orders
        ]);
    } else {
        // If the user does not have a business, redirect to business_register
        return redirect()->route('business.register');
    }
}

public function showProducts(Request $request)
{
    // Get the authenticated user
    $user = auth()->user();

    // Check if the user has a business
    if ($user->business) {
        // Retrieve the user's products
        $products = Product::where('business_id', $user->business->id)->get();

        // Retrieve product categories
        $productCategories = ProductCategory::all();

        // Retrieve product reviews for each product
$reviews = $products->map(function ($product) {
    $product->reviews = $product->productReviews()->orderBy('created_at', 'desc')->get();
    return $product;
});

        // Check if the request has product data
if ($request->filled(['code', 'title', 'category_id', 'price', 'stock', 'short_description', 'long_description'])) {

    // Check if a file has been uploaded
if ($request->hasFile('photo')) {
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Get the uploaded file
    $photo = $request->file('photo');

    // Log the file information for debugging
    \Log::info('Uploaded Photo:', ['filename' => $photo->getClientOriginalName(), 'size' => $photo->getSize()]);

    // Generate a unique name for the file
    $photoName = $photo->getClientOriginalName();

    // Move the file to the 'images' folder in the storage disk
    $photo->move(public_path('images'), $photoName);
;
} else {
    $photoName = null;
}


    // Insert a new product into the database
    $newProduct = new Product();
    $newProduct->business_id = $user->business->id;
    $newProduct->code = $request->input('code');
    $newProduct->title = $request->input('title');
    $newProduct->image_url = $photoName;
    $newProduct->category_id = $request->input('category_id');
    $newProduct->price = $request->input('price');
    $newProduct->stock = $request->input('stock');
    $newProduct->short_description = $request->input('short_description');
    $newProduct->long_description = $request->input('long_description');
    
    // Save the new product
    $newProduct->save();

    // Redirect to the Products tab after adding a new product
    return redirect()->route('business')->with([
        'success' => 'Product added successfully!',
        'products' => $products,
        'productCategories' => $productCategories,
        'reviews' => $reviews,
        'section' => 'products', // Indicate the Products tab
    ]);
}
    }

    // If the user does not have a business, redirect to business_register
    return redirect()->route('business.register');
}

public function update(Request $request, $product_id)
{
    // Validation (Add more if needed)
    $request->validate([
        'code' => 'required',
        'title' => 'required',
        'category_id' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|numeric',
        'short_description' => 'required',
        'long_description' => 'required',
    ]);

    // Retrieve the product
    $product = Product::findOrFail($product_id);

    // Update product information
    $product->update([
        'code' => $request->input('code'),
        'title' => $request->input('title'),
        'category_id' => $request->input('category_id'),
        'price' => $request->input('price'),
        'stock' => $request->input('stock'),
        'short_description' => $request->input('short_description'),
        'long_description' => $request->input('long_description'),
    ]);

    // Redirect back or to a specific route
    return redirect()->back()->with('success', 'Product updated successfully')->with('tab', 'products');
}
}
