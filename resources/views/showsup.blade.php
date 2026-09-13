@extends('layouts.sidebar')

@section('content')
<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">
            🏗️ สินค้าจาก Supplier
        </h3>

        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary rounded-pill">
            ← กลับ
        </a>
    </div>

    <!-- SUPPLIER INFO -->
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body">
            <h5 class="mb-1 fw-bold">{{ $supplier->name }}</h5>
            <small class="text-muted">
                จำนวนสินค้า: {{ $supplier->productItems->count() }} รายการ
            </small>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table align-middle table-hover">

                    <thead class="table-light">
                        <tr>
                            <th>📦 ชื่อสินค้า</th>
                            <th>📊 จำนวนคงเหลือ</th>
                            <th>💰 ราคาทุน</th>
                            <th>💵 ราคาปลีก</th>
                            <th>🛒 ราคาส่ง</th>
                            <th>📅 วันที่รับสินค้า</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($supplier->productItems as $product)
                        <tr>
                            <!-- ชื่อสินค้า -->
                            <td class="fw-semibold">{{ $product->item_name }}</td>

                            <!-- จำนวนคงเหลือ -->
                            <td>
                                <span class="badge
                                    {{ $product->stock_quantity <= 5 ? 'bg-danger' :
                                       ($product->stock_quantity <= 20 ? 'bg-warning text-dark' : 'bg-success') }}">
                                    {{ $product->stock_quantity }}
                                </span>
                            </td>

                            <!-- ราคาทุน -->
                            <td class="fw-bold text-success">
                                ฿{{ number_format($product->cost_price, 2) }}
                            </td>

                            <!-- ราคาปลีก -->
                            <td class="fw-bold text-primary">
                                ฿{{ number_format($product->retail_price, 2) }}
                            </td>

                            <!-- ราคาส่ง -->
                            <td class="fw-bold text-warning">
                                ฿{{ number_format($product->wholesale_price, 2) }}
                            </td>

                            <!-- วันที่รับสินค้า -->
                            <td>
                                {{ $product->received_date
                                    ? \Carbon\Carbon::parse($product->received_date)->format('d/m/Y')
                                    : '-' }}
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                😢 ไม่มีสินค้าใน Supplier นี้
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
@endsection
