<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $wishlists = Auth::user()->favorites()->with('category')->get();
        return view('client.pages.account.wishlist', compact('wishlists'));
    }

    public function toggle(Product $product)
    {
        $user = Auth::user();

        // Check if the product is already in favorites
        $favorite = $user->favorites()->where('product_id', $product->id)->exists();

        if ($favorite) {
            // Remove from favorites
            $user->favorites()->detach($product->id);
            $added = false;
        } else {
            // Add to favorites
            $user->favorites()->attach($product->id);
            $added = true;
        }
        
        return response()->json([
            'success' => true,
            'added' => $added,
            'message' => $added ? 'Thêm vào danh sách yêu thích thành công' : 'Đã xóa khỏi danh sách yêu thích'
        ]);
    }

    public function destroy($productId)
    {
        $user = Auth::user();
        $user->favorites()->detach($productId);

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi danh sách yêu thích');
    }
}