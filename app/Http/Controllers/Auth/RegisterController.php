<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;


class RegisterController extends Controller
{
    
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    

protected $redirectTo = '/onboarding'; // Change to your profile route

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // app/Http/Controllers/Auth/RegisterController.php

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    protected function validator(array $data)
{
    return Validator::make($data, [
        'firstname' => ['required', 'string', 'max:255'],
        'lastname' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'], // This is the password rule
    ]);
}

protected function create(array $data)
{
    return User::create([
        'firstname' => $data['firstname'], // Correct key name
        'lastname' => $data['lastname'],   // Correct key name
        'email' => $data['email'],
        'password' => bcrypt($data['password']), // Hash the password correctly
    ]);
}


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    

     public function register(Request $request)
     {
         try {
             // Validate the incoming request with custom rules
             $validatedData = $request->validate([
                 'email' => 'required|string|email|max:255|unique:users,email', // Ensure email is unique
                 'firstname' => 'required|string|max:255',
                 'lastname' => 'required|string|max:255',
                 'password' => 'required|string|min:8|confirmed', // Ensure password is confirmed
             ], [
                 'email.unique' => 'This email is already registered. Please use a different email.',
                 'password.confirmed' => 'The password confirmation does not match.',
             ]);
     
             // Hash the password and create the user
             $user = User::create([
                 'email' => $validatedData['email'],
                 'firstname' => $validatedData['firstname'],
                 'lastname' => $validatedData['lastname'],
                 'password' => bcrypt($validatedData['password']), // Hash the password
             ]);
     
             // Automatically log in the newly registered user
             Auth::login($user);
     
             // Redirect to the login view after successful registration
             return redirect()->route('login')->with('success', 'Registration successful! You can now log in.');
     
         } catch (\Illuminate\Validation\ValidationException $e) {
             // Redirect back to the registration form with validation errors
             return redirect()->route('register')
                 ->withErrors($e->validator) // Pass the validation errors back to the form
                 ->withInput(); // Keep old input values
     
         } catch (\Throwable $e) {
             // Log the error for debugging
             \Log::error('Registration error: ' . $e->getMessage());
     
             // Redirect back with a specific error message if something goes wrong
             return redirect()->back()->with('error', $e->getMessage());
         }
     }
}
