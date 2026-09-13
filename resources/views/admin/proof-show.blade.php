@extends('layouts.adminside')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📦 ดูหลักฐานการจัดส่ง</h2>
        <a href="{{ route('admin.completed') }}" class="btn btn-secondary">
            ⬅️ กลับ
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body text-center p-4">

            @if($order->delivery_image)
                <img src="{{ asset('storage/' . $order->delivery_image) }}"
                     class="img-fluid rounded shadow"
                     style="max-height: 400px;">
            @else
                <p class="text-danger">ไม่มีรูปหลักฐาน</p>
            @endif

            <hr>

            <p><strong>Order ID:</strong> #{{ $order->id }}</p>
            <p><strong>ลูกค้า:</strong> {{ $order->customer_phone ?? '-' }}</p>
            <p><strong>ราคารวม:</strong> {{ number_format($order->total_price, 2) }} บาท</p>

        </div>
    </div>

</div>

@endsection
