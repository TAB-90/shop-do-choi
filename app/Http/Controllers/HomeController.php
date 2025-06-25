<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        $newProducts = Product::with('category')->latest()->take(5)->get();
        $bestsellerProducts = Product::with('category')->where('is_bestseller', true)->take(8)->get();
        $popularCategories = Category::withCount('products')->orderBy('products_count', 'desc')->take(8)->get();

        // Đánh dấu sản phẩm đã yêu thích nếu người dùng đã đăng nhập
        if (Auth::check()) {
            $favoriteProductIds = Auth::user()->favorites()->pluck('product_id')->toArray();

            foreach ($newProducts as $product) {
                $product->is_favorited = in_array($product->id, $favoriteProductIds);
            }

            foreach ($bestsellerProducts as $product) {
                $product->is_favorited = in_array($product->id, $favoriteProductIds);
            }
        }

        return view('client.pages.home', compact('newProducts', 'bestsellerProducts', 'popularCategories'));
    }

    public function showProducts(Request $request)
    {
        $products = Product::with('category')->paginate(20);
        return view('client.pages.products.index', compact('products'));
    }
}
