<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Billmanagement;



// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [Billmanagement::class, 'index']);
Route::get('/product_details/{bill_no}', [Billmanagement::class, 'product_details']);
Route::post('/update_product_details', [Billmanagement::class, 'update_product_details']);
Route::get('/edit_bill_details', [Billmanagement::class, 'edit_bill_details']);
