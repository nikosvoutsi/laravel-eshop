<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Models\Order;
use App\Models\Business;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\OrderProduct;
use Auth;

class HomeController extends Controller
{
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

     public function home()
    {
        // Retrieve all categories
        $categories = ProductCategory::all();

        return view('home', compact('categories'));
    }

    public function showCategory($category_id, Request $request)
{
    $category = ProductCategory::find($category_id);

    if (!$category) {
        abort(404); 
    }

    // Start with a base query
    $products = Product::where('category_id', $category_id);
    

    // Get filter parameters from the request
    $orderBy = $request->input('order_by', 'default');
    $priceRange = $request->input('priceRange', 'default');
    $selectedInStock = $request->input('in_stock', false);
    $search = $request->input('search');

    // Apply price range filter
    if ($priceRange != 'default') {
        switch ($priceRange) {
            case '100':
                $products->where('price', '<', 100);
                break;
            case '500':
                $products->whereBetween('price', [100, 500]);
                break;
            case '1000':
                $products->whereBetween('price', [500, 1000]);
                break;
            case 'inf':
                $products->where('price', '>', 1000);
                break;
            default:
        }
    }

    // Apply availability filter
    if ($selectedInStock) {
        $products->where('stock', '>', 0);
    }
   

    // Apply sorting
    switch ($orderBy) {
        case 'price_asc':
            $products->orderBy('price', 'asc');
            break;
        case 'price_desc':
            $products->orderBy('price', 'desc');
            break;
        case 'newest_first':
            $products->orderByDesc('created_at');
            break;
        case 'oldest_first':
            $products->orderBy('created_at');
            break;
        default:         
    }

    $filteredProducts = $products->where('title', 'like', '%' . $search . '%')->get(); 
    

    /* $filteredProducts = $products->get(); */
    $inStockCount = $products->where('stock', '>', 0)->count();


   


    // Calculate product counts for each price range
   $priceRanges = [
    Product::where('category_id', $category_id)->where('price', '<', 100)->count(),
    Product::where('category_id', $category_id)->whereBetween('price', [100, 500])->count(),
    Product::where('category_id', $category_id)->whereBetween('price', [500, 1000])->count(),
    Product::where('category_id', $category_id)->where('price', '>', 1000)->count()
];  

    

    return view('category', compact(
        'category',
        'filteredProducts',
        'priceRange',
        'priceRanges',
        'selectedInStock',
        'inStockCount',
        'orderBy'
    ));
}

    public function searchResults(Request $request)
{
    $search = $request->input('search');
    $selectedCategories = $request->input('categories', []);
    $priceRange = $request->input('priceRange');
    $selectedInStock = $request->input('in_stock');
    $selectedOutOfStock = $request->input('out_of_stock');
    

    // Create a base query
    $query = Product::query();

    // Perform a search query using the $search variable
    $query->where('title', 'like', '%' . $search . '%');

    // Filter by selected categories
    if (!empty($selectedCategories)) {
        $query->whereIn('category_id', $selectedCategories);
    }

    // Load categories and products_count for checkboxes
    $categories = ProductCategory::withCount('products')->get();

    // Filter by selected price range
    switch ($priceRange) {
        case '100':
            $query->where('price', '<', 100);
            break;
        case '500':
            $query->whereBetween('price', [100, 500]);
            break;
        case '1000':
            $query->whereBetween('price', [500, 1000]);
            break;
        case 'inf':
            $query->where('price', '>', 1000);
            break;
        default:
            // No price range selected
    }

    // Filter by availability (in stock or out of stock)
    if ($selectedInStock && !$selectedOutOfStock) {
        $query->where('stock', '>', 0);
    } elseif (!$selectedInStock && $selectedOutOfStock) {
        $query->where('stock', '=', 0);
    }

    // Get paginated results
    $results = $query->with('category');

    $orderBy = $request->input('order_by', 'default'); // Default sorting option

    // Modify the database query to handle sorting
    switch ($orderBy) {
        case 'price_asc':
            $results->orderBy('price', 'asc');
            break;
        case 'price_desc':
            $results->orderBy('price', 'desc');
            break;
        case 'newest_first':
            $results->orderByDesc('created_at'); // Sort by newest first
            break;
        case 'oldest_first':
            $results->orderBy('created_at'); // Sort by oldest first
            break;
        default:
            // No sorting selected, use the default order for your table
    }

    $results = $results->paginate(25);

    // Calculate product counts for each price range
    $priceRanges = [
        Product::where('price', '<', 100)->count(),
        Product::whereBetween('price', [100, 500])->count(),
        Product::whereBetween('price', [500, 1000])->count(),
        Product::where('price', '>', 1000)->count()
    ];

    // Fetch the counts of in-stock and out-of-stock products
    $inStockCount = $query->where('stock', '>', 0)->count();
    $outOfStockCount = $query->where('stock', '=', 0)->count();

    return view('search', compact(
        'results',
        'categories',
        'selectedCategories',
        'priceRange',
        'priceRanges',
        'selectedInStock',
        'selectedOutOfStock',
        'inStockCount',
        'outOfStockCount',
        'orderBy' // Pass the orderBy variable to the view
    ));
}


    public function index()
    {
        $user = Auth::user();
        $address = Address::where('user_id', $user->id)->first();
         $allOrders = Order::with('orderProducts.product.business')->where('user_id', $user->id)->orderBy('created_at', 'desc')->get(); 

       // Use the Query Builder to fetch orders and related data
    $orders = DB::table('order')
    ->join('order_product', 'order.order_id', '=', 'order_product.order_id')
    ->join('product', 'order_product.product_id', '=', 'product.product_id')
    ->join('business', 'product.business_id', '=', 'id')
    ->select(
        'order.order_id',
        'order.created_at',
        'order.total_price as total_price',
        'product.title as product_title',
        'business.name as business_name',
        'order_product.quantity',
        'order_product.initial_price',
        'order_product.total_price as total_product_price',
        'order.comments as comments',
    )
    ->where('order.user_id', $user->id)
    ->orderBy('created_at', 'desc')
    ->get();

        return view('user', ['address' => $address, 'orders' => $orders, 'allOrders' => $allOrders]);

    }


    

    public function onboardingPage()
    {
        return view('onboarding');
    }

    public function onboarding(Request $request)
    {
        // Validate the form data
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'phone' => 'required|string|max:15',
            'street' => 'required|string|max:255',
            'number' => 'required|numeric',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
        ]);

        // Get the authenticated user
        $user = auth()->user();

        // Update the user's profile with the provided data
        $user->update($data);

        // Create or update the user's address
        $addressData = [
            'street' => $data['street'],
            'number' => $data['number'],
            'city' => $data['city'],
            'postal_code' => $data['postal_code'],
        ];

        $user->address()->updateOrCreate([], $addressData);

        // Redirect the user to a dashboard or another page
        return redirect('/');
    }

    
    
}

