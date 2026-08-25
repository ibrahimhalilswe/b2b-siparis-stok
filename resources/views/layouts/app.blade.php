<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>B2B Sipariş & Stok Yönetimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('products.index') }}">B2B Panel</a>
            <div>
                <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-sm">Ürünler</a>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-light btn-sm">Kategoriler</a>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-light btn-sm">Siparişler</a>
            </div>
        </div>
    </nav>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>
