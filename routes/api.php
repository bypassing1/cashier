<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/checkout', function (Request $request) {
    $cart = $request->input('cart');
    $paymentMethod = $request->input('paymentMethod');
    $totalPrice = 0;

    DB::beginTransaction();
    try {
        foreach ($cart as $item) {
            $product = DB::table('products')->where('id', $item['id'])->first();
            if (!$product || $product->stock < $item['quantity']) {
                return response()->json(["success" => false, "message" => "Insufficient stock"], 400);
            }

            // Deduct stock and update units_sold
            DB::table('products')->where('id', $item['id'])->update([
                'stock' => $product->stock - $item['quantity'],
                'units_sold' => $product->units_sold + $item['quantity']
            ]);

            $totalPrice += $product->price * $item['quantity'];
        }

        // Insert into transactions table
        DB::table('transactions')->insert([
            'total_price' => $totalPrice,
            'payment_method' => $paymentMethod,
            'transaction_time' => now()
        ]);

        DB::commit();
        return response()->json(["success" => true]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(["success" => false, "message" => "Transaction failed"], 500);
    }
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
