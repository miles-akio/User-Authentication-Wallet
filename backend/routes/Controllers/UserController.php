<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Retrieves the authenticated user's wallet balance from the database.
    public function dashboard()
    {
        // Access the currently authenticated user.
        $user = Auth::user();

        // Return the wallet balance as a JSON response.
        return response()->json(['wallet_balance' => $user->wallet_balance], 200);
    }
}
