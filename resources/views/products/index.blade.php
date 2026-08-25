@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Ürünler</h3>
        <div>
            <a href="{{ route('products.trashed') }}" class="btn btn-outline-secondary">Silinen Ürünler</a>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Yeni Ürün Ekle</a>
        </div>
    </div>

    <form method="GET" action="{{ route('products.index') }}" class="row g-2 mb-3">
        <div class="col-auto">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Ürün adı ara...">
        </div>
        <div class="col-auto">
            <select name="category_id" class="form-select">
                <option value="">Tüm Kategoriler</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-secondary">Filtrele</button>
        </div>
    </form>

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Görsel</th>
                <th>Ürün</th>
                <th>Kategori</th>
                <th>SKU</th>
                <th>Fiyat</th>
                <th>Stok</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>
                        @if ($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" width="50">
                        @else
                            <span class="text-muted">Yok</span>
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ number_format($product->price, 2) }} ₺</td>
                    <td>
                        @if ($product->stock == 0)
                            <span class="badge bg-danger">Stokta Yok</span>
                        @else
                            {{ $product->stock }}
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('orders.store') }}" class="d-flex gap-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="text" name="customer_name" class="form-control form-control-sm" placeholder="Müşteri adı" required>
                            <input type="number" name="quantity" class="form-control form-control-sm" style="width:70px" min="1" value="1" required>
                            <button type="submit" class="btn btn-sm btn-success" @disabled($product->stock == 0)>
                                Hızlı Sipariş Ver
                            </button>
                        </form>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning mt-1">Düzenle</a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger mt-1" onclick="return confirm('Emin misiniz?')">Sil</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Ürün bulunamadı.</td></tr>
            @endforelse
        </tbody>
    </table>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{ $products->links() }}
@endsection
