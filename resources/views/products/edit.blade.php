@extends('layouts.app')

@section('content')
    <h3>Ürünü Düzenle</h3>

    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-select" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($product->category_id == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Ürün Adı</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">SKU</label>
            <input type="text" name="sku" class="form-control" value="{{ $product->sku }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Fiyat</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Görsel (değiştirmek istemiyorsan boş bırak)</label>
            <input type="file" name="image" class="form-control">
            @if ($product->image_path)
                <img src="{{ asset('storage/' . $product->image_path) }}" width="80" class="mt-2">
            @endif
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Güncelle</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Vazgeç</a>
    </form>
@endsection
