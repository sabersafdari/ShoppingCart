<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends WebsiteController
{
    public function index(Request $request)
    {
        $products = Product::latest()->simplePaginate(9);
        $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
        $cart = new Cart($oldCart);

        return view('website.product.index', compact('products', 'cart'));
    }

    public function show(Product $product, Request $request)
    {
        $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
        $cart = new Cart($oldCart);

        return view('website.product.show', compact('product', 'cart'));
    }
}
