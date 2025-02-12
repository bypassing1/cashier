<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Categories::all();
        return view('product-grid', compact('products', 'categories'));
    }
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('partials.product-detail', compact('product'));
    }
    public function getSelectedProducts(Request $request)
{
    $ids = $request->query('ids'); // Get IDs from query parameters

    if (!$ids) {
        return response()->json([]);
    }

    $products = Product::whereIn('id', explode(',', $ids))->get(); // Fetch products
    return response()->json($products);
}
}
