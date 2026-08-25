@extends('layouts.app')

@section('content')
    <h3>Siparişler</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ürün</th>
                <th>Müşteri</th>
                <th>Adet</th>
                <th>Toplam Tutar</th>
                <th>Durum</th>
                <th>Tarih</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->product->name }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ number_format($order->total_price, 2) }} ₺</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Henüz sipariş yok.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $orders->links() }}
@endsection
