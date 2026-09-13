@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>ประวัติการสั่งซื้อของ {{ $customer->name }} ({{ $customer->phone }})</h4>

    @forelse ($orders as $order)
        <div class="card mb-3">
            <div class="card-header">
                วันที่: {{ $order->created_at->format('d/m/Y H:i') }}
            </div>
            <div class="card-body">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>ชื่อสินค้า</th>
                            <th>ประเภทราคา</th>
                            <th>ราคาต่อหน่วย</th>
                            <th>จำนวน</th>
                            <th>รวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderDetails as $detail)
                            <tr>
                                {{-- <td>{{ $detail->product->product_name ?? '-' }}</td> --}}
                                <td>{{ $detail->product->productItem->item_name ?? '-' }}</td>

                                <td>{{ $detail->price_type == 'wholesale_price' ? 'ราคาส่ง' : 'ราคาปลีก' }}</td>
                                <td>{{ number_format($detail->unit_price, 2) }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ number_format($detail->unit_price * $detail->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <strong>รวมทั้งสิ้น: {{ number_format($order->orderDetails->sum(fn($d) => $d->unit_price * $d->quantity), 2) }} บาท</strong>
            </div>
        </div>
    @empty
        <div class="alert alert-info">ไม่มีข้อมูลการสั่งซื้อ</div>
    @endforelse

    <a href="{{ route('customer.index') }}" class="btn btn-secondary">ย้อนกลับ</a>
</div>
@endsection
