<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Include Bootstrap 4 CSS from a CDN -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/8879801888.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
{{--     <script src="/js/rating/rater.js"></script>
 --}}
    
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Your custom styles -->
    <style>
        nav{
            background-color: #2a8ef8;
        }
        .navbar-brand{
            font-size:2rem;
            
        }
        .nav-link {
    font-size: 1.2rem; /* Adjust the size as needed */
    transition: color 0.3s; /* Smooth color transition on hover */
}

/* Define hover effect */
a.nav-link:hover {
    color: #268efe; /* Change the link color on hover to the desired color */
}

footer{
    position: absolute;
    top:96vh;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    justify-content: flex-start;
    
}
footer :nth-child(1){
    margin-right: 90vw;
}
    </style>
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <img src="{{ asset('images/store.png') }}" alt="" class="img-fluid" style="width:4vw">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Collapsible Navbar Section -->
                <div class="collapse navbar-collapse row" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                              <a class="nav-link" href="{{ route('cart') }}" style="position: relative;">
                                <img src="{{ asset('images/cart.png') }}" style="margin-right: 10px; margin-top: 0.2rem; height: 1.8rem; width: 1.8rem;">
                                <span id="cart-count" class="badge badge-pill badge-danger" style="position: absolute; top: 0; right: 0;"></span>
                              </a>
                            </li>
                            <li class="nav-item dropdown row">
                                   <a class="nav-link" href="{{ route('dashboard') }}" style="position: relative;">
                                       <img src="{{ asset('images/profile-user.png') }}" width="20" style="margin-right:10px; margin-left:10px; margin-top:0.3rem; height:1.8rem; width:1.8rem"/>
                                   </a>
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                   <li><a class="dropdown-item" href="/user">Settings</a></li>
                                   <li><a class="dropdown-item" href="{{ route('business') }}">My Business</a></li>
                                   <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main content -->
        <main class="py-4">
            @yield('content')
        </main>

        <!-- Footer -->
        {{-- <footer>
            <div>©Nikos Voutsi</div>
            <div>CollegeLink</div>
        </footer> --}}
    </div>

    

</body>

<script>
    function updateCartCount() {
        // Fetch the cart count from the server
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                // Update the cart count in the UI
                document.getElementById('cart-count').textContent = data.count;
            })
            .catch(error => {
                console.error('Error fetching cart count:', error);
            });
    }

    // Update the cart count initially
    updateCartCount();

    // Periodically update the cart count (every 60 seconds in this example)
    setInterval(updateCartCount, 60000);
</script>
</html>


