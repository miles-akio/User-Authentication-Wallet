<?php
// API Routes

// User registration route for new account creation.
Route::post('/signup', [AuthController::class, 'signup']);

// User login route for generating JWT tokens upon successful authentication.
Route::post('/login', [AuthController::class, 'login']);

// Routes protected by the JWT authentication middleware.
Route::middleware('auth:api')->group(function () {
    // Route to fetch the wallet balance of the authenticated user.
    Route::get('/dashboard', [UserController::class, 'dashboard']);

    // Route to handle deposit functionality with Stripe integration.
    Route::post('/deposit', [TransactionController::class, 'deposit']);
});
