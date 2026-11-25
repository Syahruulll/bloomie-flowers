<?php

namespace App\Http\Controllers;

use App\Models\Product;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()->orderBy('category')->orderBy('title')->get();
        $featuredProducts = $products->whereNotNull('photo')->take(4);

        $categories = Product::select('category')
            ->distinct()
            ->pluck('category');

        return view('User.index', compact('products', 'featuredProducts', 'categories'));
    }
}
