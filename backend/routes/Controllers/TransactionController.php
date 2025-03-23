<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Charge;

class TransactionController extends Controller
{
    // Handles deposit functionality with Stripe integration and transaction logging.
    public function deposit(Request $request)
    {
        // Validate the deposit amount in the request.
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $amount = $validatedData['amount'];

        // Initialize Stripe with the secret API key.
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            // Create a Stripe charge for the deposit amount.
            $charge = Charge::create([
                'amount' => $amount * 100, // Convert amount to cents.
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Wallet deposit',
            ]);

            // Log the successful transaction in the database.
            Transaction::create([
                'user_id' => Auth::id(),
                'amount' => $amount,
                'status' => 'success',
            ]);

            // Update the user's wallet balance.
            $user = Auth::user();
            $user->wallet_balance += $amount;
            $user->save();

            return response()->json(['message' => 'Deposit successful'], 200);

        } catch (\Exception $e) {
            // Log the failed transaction in the database.
            Transaction::create([
                'user_id' => Auth::id(),
                'amount' => $amount,
                'status' => 'failed',
            ]);

            return response()->json(['error' => 'Transaction failed: ' . $e->getMessage()], 500);
        }
    }
}
