@extends('layouts.product')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            สร้างคำสั่งซื้อใหม่
        </div>
        <div class="card-body">

            <!-- แสดงผลแจ้งเตือน -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @elseif(session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif

            <!-- ฟอร์มค้นหา -->
            <div class="mb-3">
                <form method="GET" action="{{ route('product.search') }}" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="ค้นหาสินค้า..." value="{{ old('search', request()->input('search')) }}">
                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                    </div>
                </form>
            </div>

            <form action="{{ route('order.store') }}" method="POST">
                @csrf

                <!-- ข้อมูลลูกค้า -->
                <div class="mb-3">
                    <label for="customer_name" class="form-label">ชื่อลูกค้า</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" required value="{{ old('search', request()->input('search')) }}">
                </div>
                <div class="mb-3">
                    <label for="customer_phone" class="form-label">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control" id="customer_phone" name="customer_phone" required value="{{ old('search', request()->input('search')) }}">
                </div>
                <div class="mb-3">
                    <label for="customer_email" class="form-label">อีเมล</label>
                    <input type="email" class="form-control" id="customer_email" name="customer_email" required value="{{ old('search', request()->input('search')) }}">
                </div>

                <!-- แสดงรายการสินค้า -->
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>ชื่อสินค้า</th>
                            <th>จำนวนคงเหลือ</th>
                            <th>ราคาขายปลีก</th>
                            <th>ราคาขายส่ง</th>
                            <th>จำนวนที่ต้องการ</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($products as $product)
                        <tr class="text-center">
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ number_format($product->retail_price, 2) }} บาท</td>
                            <td>{{ number_format($product->wholesale_price, 2) }} บาท</td>
                            <td>
                                <input type="number" name="products[{{ $product->id }}]" class="form-control" max="{{ $product->quantity }}" value="0">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- เลือกประเภทของราคา (ราคาขายปลีกหรือราคาขายส่ง) -->
                <div class="mb-3">
                    <label for="price_type" class="form-label">เลือกประเภทของราคา</label>
                    <select id="price_type" name="price_type" class="form-control">
                        <option value="retail">ราคาขายปลีก</option>
                        <option value="wholesale">ราคาขายส่ง</option>
                    </select>
                </div>

                <!-- ปุ่มยืนยันคำสั่งซื้อ -->
                <button type="submit" class="btn btn-primary mt-3">ยืนยันคำสั่งซื้อ</button>
            </form>
        </div>
    </div>
</div>
@endsection
