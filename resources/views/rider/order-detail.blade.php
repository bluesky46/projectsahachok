<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>รายละเอียดออเดอร์</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body style="background-color:#f5f6fa;">

    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold">
                <i class="bi bi-bicycle"></i> Rider Panel
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger btn-sm rounded-pill px-3">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container py-5">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <h3 class="fw-bold text-primary">
                <a href="{{ route('rider.dashboard') }}" class="btn btn-outline-secondary rounded-pill">
                    ← กลับ
                </a>
                <i class="bi bi-receipt"></i> รายละเอียด Order #{{ $order->id }}
            </h3>

            <span class="badge bg-warning text-dark px-3 py-2">
                รอจัดส่ง
            </span>

        </div>
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-body">

                {{-- <div class="bg-light p-3 rounded-3"> --}}
                <span class="fw-bold">ชื่อ : </span>{{ $order->customer->name ?? ''}}
                <span class="fw-bold">เบอร์โทรลูกค้า :</span>{{ $order->customer->address_number ?? '' }}
                <span class="fw-bold">บ้าน/อาคาร :</span>{{ $order->customer->address_building ?? '' }}
                <span class="fw-bold">ถนน :</span>{{ $order->customer->address_street ?? '' }}<br>

                <span class="fw-bold">ตำบล :</span> {{ $order->customer->address_subdistrict ?? '' }}
                <span class="fw-bold">อำเภอ :</span>{{ $order->customer->address_district ?? '' }}<br>

                <span class="fw-bold">จังหวัด :</span>{{ $order->customer->address_province ?? '' }}
                <span class="fw-bold">รหัสไปรษณี : </span>{{ $order->customer->postal_code ?? '' }}
                {{-- </div> --}}
            </div>
        </div>

        <!-- TABLE CARD -->
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>สินค้า</th>
                                <th>จำนวน</th>
                                <th>ราคา/ชิ้น</th>
                                <th>รวม</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($order->orderDetails as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td class="fw-semibold">
                                        {{ $item->product->productItem->item_name }}
                                    </td>

                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $item->quantity }}
                                        </span>
                                    </td>

                                    <td>{{ number_format($item->price) }} บาท</td>

                                    <td class="fw-bold text-success">
                                        {{ number_format($item->price * $item->quantity) }} บาท
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
        {{-- <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->customer->full_address) }}"
            target="_blank"
            class="btn btn-outline-primary btn-sm mt-2">
            <i class="bi bi-map"></i> เปิดแผนที่
         </a> --}}

        <!-- UPLOAD CARD -->
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">

                <h5 class="fw-bold mb-3">
                    <i class="bi bi-camera"></i>  อัปโหลดหลักฐานการจัดส่ง
                </h5>

                <!-- ALERT -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('rider.order.complete', $order->id) }}" method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">
                        <input type="file" name="delivery_image" class="form-control" accept="image/*"
                            capture="environment" required>
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-success rounded-pill">
                            <i class="bi bi-check-circle"></i> ยืนยันการจัดส่ง
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

</body>

</html>
