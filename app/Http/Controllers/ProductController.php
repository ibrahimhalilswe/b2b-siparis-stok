<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $products = Product::with('category')
        ->when($request->search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })
        ->when($request->category_id, function ($query, $categoryId) {
            $query->where('category_id', $categoryId);
        })
        ->latest()
        ->paginate(10);

    $categories = Category::all();

    return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $categories = Category::all();
    return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $validated = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
        'sku' => 'required|string|unique:products,sku',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $validated['image_path'] = $request->file('image')->store('products', 'public');
    }

    Product::create($validated);

    return redirect()->route('products.index')->with('success', 'Ürün eklendi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
    $categories = Category::all();
    return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
    $validated = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
        'sku' => 'required|string|unique:products,sku,' . $product->id,
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $validated['image_path'] = $request->file('image')->store('products', 'public');
    }

    $product->update($validated);

    return redirect()->route('products.index')->with('success', 'Ürün güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
    $product->delete();
    return redirect()->route('products.index')->with('success', 'Ürün silindi.');
    }

    public function trashed()
    {
    $products = Product::onlyTrashed()->with('category')->paginate(10);
    return view('products.trashed', compact('products'));
    }

    public function restore($id)
    {
    $product = Product::onlyTrashed()->findOrFail($id);
    $product->restore();
    return redirect()->route('products.trashed')->with('success', 'Ürün geri yüklendi.');
    }
}
