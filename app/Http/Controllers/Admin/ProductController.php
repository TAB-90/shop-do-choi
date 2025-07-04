<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);

        return view('admin.pages.products.index', compact('products'));
    }
    
    public function create()
    {
        $categories = Category::all();

        return view('admin.pages.products.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
     
      
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ], [
            'title.required' => 'Sản phẩm là bắt buộc.',
            'title.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'description.required' => 'Mô tả sản phẩm là bắt buộc.',
            'cover_image.required' => 'Ảnh bìa là bắt buộc.',
            'cover_image.image' => 'Ảnh bìa phải là một hình ảnh.',
            'cover_image.mimes' => 'Ảnh bìa phải có định dạng jpeg, png, jpg hoặc gif.',

            'price.required' => 'Giá sản phẩm là bắt buộc.',
            'price.numeric' => 'Giá sản phẩm phải là một số.',
            'price.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0.',
            'stock.required' => 'Số lượng tồn kho là bắt buộc.',
            'stock.integer' => 'Số lượng tồn kho phải là một số nguyên.',
            'stock.min' => 'Số lượng tồn kho phải lớn hơn hoặc bằng 0.',
            'category_id.required' => 'Vui lòng chọn một danh mục cho sản phẩm.',
            'category_id.exists' => 'Danh mục đã chọn không hợp lệ.',
        ]);
        
        $imagePath = $request->file('cover_image')->store('covers', 'public');

        Product::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'description' => $request->description,
            'cover_image' => $imagePath,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_bestseller' => $request->has('is_bestseller') ? true : false,
            'category_id' => $request->category_id,
        ]);
        
        return redirect()->route('admin.products.index')->with('success', 'Tạo sản phẩm thành công');
    }
    
    public function edit(Product $product)
    {
        $categories = Category::all();
        
        return view('admin.pages.products.edit', compact('product', 'categories'));
    }
    
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ], [
            'title.required' => 'Tên sản phẩm là bắt buộc.',
            'title.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'description.required' => 'Mô tả sản phẩm là bắt buộc.',
            'cover_image.required' => 'Ảnh bìa là bắt buộc.',
            'cover_image.image' => 'Ảnh bìa phải là một hình ảnh.',
            'cover_image.mimes' => 'Ảnh bìa phải có định dạng jpeg, png, jpg hoặc gif.',

            'price.required' => 'Giá sản phẩm là bắt buộc.',
            'price.numeric' => 'Giá sản phẩm phải là một số.',
            'price.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0.',
            'stock.required' => 'Số lượng tồn kho là bắt buộc.',
            'stock.integer' => 'Số lượng tồn kho phải là một số nguyên.',
            'stock.min' => 'Số lượng tồn kho phải lớn hơn hoặc bằng 0.',
            'category_id.required' => 'Vui lòng chọn một danh mục cho sản phẩm.',
            'category_id.exists' => 'Danh mục đã chọn không hợp lệ.',
        ]);
        
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_bestseller' => $request->has('is_bestseller') ? true : false,
            'category_id' => $request->category_id,
        ];
        
        if ($request->hasFile('cover_image')) {
            if ($product->cover_image) {
                Storage::disk('public')->delete($product->cover_image);
            }
            
            $imagePath = $request->file('cover_image')->store('covers', 'public');
            $data['cover_image'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công');
    }

    public function destroy(Product $product)
    {
        if ($product->cover_image) {
            Storage::disk('public')->delete($product->cover_image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công');
    }
}