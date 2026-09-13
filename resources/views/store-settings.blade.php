@extends('layouts.adminside')

@section('content')
<title>ตั้งค่าร้านค้า</title>

<style>
    body {
        font-family: Arial, sans-serif;
        padding: 30px;
    }

    .container {
        max-width: 700px;
        margin: auto;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
    }

    input,
    textarea {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
    }

    textarea {
        min-height: 100px;
    }

    button {
        padding: 10px 25px;
        cursor: pointer;
    }

    .success {
        background: #d4edda;
        padding: 10px;
        margin-bottom: 20px;
    }

    .error {
        color: red;
    }
</style>



<div class="container-fluid px-4">

    <h1>ตั้งค่าข้อมูลร้านค้า</h1>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('store-settings.update') }}" method="POST">

        @csrf

        <div class="form-group">
            <label>ชื่อร้าน</label>

            <input
                type="text"
                name="shop_name"
                value="{{ old('shop_name', $store->shop_name ?? '') }}"
                required
            >
        </div>

        <div class="form-group">
            <label>ที่อยู่ร้าน</label>

            <textarea name="address">{{ old('address', $store->address ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label>เบอร์โทรศัพท์</label>

            <input
                type="text"
                name="phone"
                value="{{ old('phone', $store->phone ?? '') }}"
            >
        </div>

        <div class="form-group">
            <label>เลขประจำตัวผู้เสียภาษี</label>

            <input
                type="text"
                name="tax_id"
                maxlength="13"
                value="{{ old('tax_id', $store->tax_id ?? '') }}"
            >
        </div>

        <button type="submit">
            บันทึกข้อมูล
        </button>

    </form>

</div>

@endsection
