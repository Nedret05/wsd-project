<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EchoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok'
    ]);
});

