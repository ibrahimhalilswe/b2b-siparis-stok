@extends('layouts.app')

@section('content')
    <h3>Kategoriler</h3>

    <form method="POST" action="{{ route('categories.store') }}" class="row g-2 mb-4">
        @csrf
        <div class="col-auto">
            <input type="text" name="name" class="form-control" placeholder="Yeni kategori adı" required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Ekle</button>
        </div>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ad</th>
                <th>Slug</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                </tr>
            @empty
                <tr><td colspan="2" class="text-center">Kategori yok.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $categories->links() }}
@endsection
