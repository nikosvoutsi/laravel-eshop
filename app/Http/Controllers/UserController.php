<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

     // Update personal information
    public function updatePersonalInfo(Request $request)
    {
        $user = Auth::user();
        
        $data=$request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthdate' => 'nullable|date',
            'phone' => 'nullable|string|max:15',
        ]);

        // Update user's personal information here
        $user->update($data);

        return redirect()->back()->with('success', 'Personal information updated successfully.');
    }



    // Update security information
    public function updateSecurity(Request $request)
{
    // Define custom error messages for validation rules
    $customMessages = [
        'email.email' => 'The email must be a valid email address.',
        'new_password.confirmed' => 'The new password confirmation does not match.',
        'new_password.min' => 'The new password must be at least :min characters long.',
    ];

    // Validate the form data with custom error messages
    $validator = Validator::make($request->all(), [
        'email' => 'email',
        'new_password' => 'nullable|confirmed|min:8',
    ], $customMessages);

    if ($validator->fails()) {
        $errors = $validator->errors();
        if ($errors->has('email')) {
            return redirect()->back()->with('error', $errors->first('email'))->with('form_to_display', 'security-info');
        }
        if ($errors->has('new_password')) {
            return redirect()->back()->with('error', $errors->first('new_password'))->with('form_to_display', 'security-info');
        }
        // Handle other validation errors as needed
    }

    // Check if the current password is correct
    if (!Hash::check($request->input('current_password'), Auth::user()->password)) {
        return redirect()->back()->with('error', 'Current password is incorrect.')->with('form_to_display', 'security-info');
    }

    // Update email if provided
    if ($request->filled('email')) {
        Auth::user()->email = $request->input('email');
    }

    // Update password if provided
    if ($request->filled('new_password')) {
        Auth::user()->password = Hash::make($request->input('new_password'));
    }

    Auth::user()->save();

    return redirect()->back()->with('success', 'Security information updated successfully.')->with('form_to_display', 'security-info');
}

public function updateAddress(Request $request)
{
    // Validate the form data
    $data = $request->validate([
        'street' => 'required|string|max:255',
        'number' => 'required|numeric',
        'city' => 'required|string|max:255',
        'postal_code' => 'required|string|max:10',
    ]);

    // Get the authenticated user
    $user = Auth::user();

    

    // Create or update the user's address
    $addressData = [
        'street' => $data['street'],
        'number' => $data['number'],
        'city' => $data['city'],
        'postal_code' => $data['postal_code'],
    ];

    $user->address()->updateOrCreate([], $addressData);

    // Fetch the user's address based on their user ID
    $address = Address::where('user_id', $user->id)->first();


    return redirect()->back()->with('success', 'Address information updated successfully.')->with ('address', $address)->with('form_to_display', 'address');
}


}
