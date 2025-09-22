<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku',
            'type' => 'required|in:physical,digital,service',
            'price_cents' => 'required|integer|min:0',
            'stock' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'sku', 'type', 'price_cents', 'stock', 'is_active']);
        $data['is_active'] = $request->has('is_active');
        
        // メタデータの処理
        $metadata = [];
        if ($request->filled('description')) {
            $metadata['description'] = $request->description;
        }
        
        // 画像アップロード処理
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $metadata['image'] = $imagePath;
        }
        
        if (!empty($metadata)) {
            $data['metadata'] = $metadata;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', '商品が正常に作成されました。');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'type' => 'required|in:physical,digital,service',
            'price_cents' => 'required|integer|min:0',
            'stock' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'sku', 'type', 'price_cents', 'stock', 'is_active']);
        $data['is_active'] = $request->has('is_active');
        
        // メタデータの処理
        $metadata = $product->metadata ?? [];
        if ($request->filled('description')) {
            $metadata['description'] = $request->description;
        } else {
            unset($metadata['description']);
        }
        
        // 画像アップロード処理
        if ($request->hasFile('image')) {
            // 古い画像を削除
            if (isset($metadata['image'])) {
                Storage::disk('public')->delete($metadata['image']);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $metadata['image'] = $imagePath;
        }
        
        $data['metadata'] = $metadata;

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', '商品が正常に更新されました。');
    }

    public function destroy(Product $product)
    {
        // 画像を削除
        if ($product->metadata && isset($product->metadata['image'])) {
            Storage::disk('public')->delete($product->metadata['image']);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', '商品が正常に削除されました。');
    }
}
