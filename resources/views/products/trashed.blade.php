@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Silinen Ürünler</h3>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Ürünlere Dön</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ürün</th>
                <th>Kategori</th>
                <th>SKU</th>
                <th>Silinme Tarihi</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->deleted_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <form method="POST" action="{{ route('products.restore', $product->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Geri Yükle</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Silinen ürün yok.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $products->links() }}
@endsection
