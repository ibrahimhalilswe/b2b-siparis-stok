<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('product')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['quantity'] > $product->stock) {
            return back()->withErrors([
                'quantity' => 'Girilen adet mevcut stoktan fazla. Stokta ' . $product->stock . ' adet var.',
            ])->withInput();
        }

        $totalPrice = $product->price * $validated['quantity'];

        Order::create([
            'product_id' => $product->id,
            'customer_name' => $validated['customer_name'],
            'quantity' => $validated['quantity'],
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        $product->decrement('stock', $validated['quantity']);

        return redirect()->route('products.index')->with('success', 'Sipariş oluşturuldu.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
