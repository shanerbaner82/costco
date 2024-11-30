<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
Route::get('/test', function(){
    dd(Product::where('vendor_id'));
});
Route::get('/', \App\Livewire\Snapshot::class);
