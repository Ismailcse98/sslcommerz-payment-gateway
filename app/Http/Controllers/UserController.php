<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function checkout($slug){
        $product = Product::where('slug', $slug)->first();
        return view('checkout', compact('product'));
    }
}
