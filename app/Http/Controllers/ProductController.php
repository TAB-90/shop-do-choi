<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Lọc theo danh mục
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Lọc sản phẩm bán chạy
        if ($request->has('is_bestseller')) {
            $query->where('is_bestseller', true);
        }

        // Lọc sản phẩm mới
        if ($request->has('newest')) {
            $query->latest();
        }

        // Tìm kiếm
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Phân trang kết quả
        $products = $query->paginate(12);

        // Đánh dấu sản phẩm đã yêu thích nếu người dùng đã đăng nhập
        if (Auth::check()) {
            $favoriteProductIds = Auth::user()->favorites()->pluck('product_id')->toArray();

            foreach ($products as $product) {
                $product->is_favorited = in_array($product->id, $favoriteProductIds);
            }
        }

        // Lấy tất cả danh mục
        $categories = Category::withCount('products')->get();

        return view('client.pages.products.index', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // Đánh dấu nếu sản phẩm đã được yêu thích
        if (Auth::check()) {
            $product->is_favorited = Auth::user()->favorites()->where('product_id', $product->id)->exists();
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        // Đánh dấu sản phẩm liên quan đã yêu thích
        if (Auth::check()) {
            $favoriteProductIds = Auth::user()->favorites()->pluck('product_id')->toArray();

            foreach ($relatedProducts as $relatedProduct) {
                $relatedProduct->is_favorited = in_array($relatedProduct->id, $favoriteProductIds);
            }
        }

        return view('client.pages.products.show', compact('product', 'relatedProducts'));
    }
}
