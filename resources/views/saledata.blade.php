<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>ข้อมูลการขาย</title>
    <style>
        .sidebar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .main-content {
            margin-left: 240px;
            padding: 20px;
            max-width: 100%;
            overflow-x: hidden;
            box-sizing: border-box;
            /* แนะนำให้เพิ่มด้วย */
        }
    </style>



</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            {{-- <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark"> --}}
            <div class="bg-primary-subtle text-dark sidebar-fixed" style="width: 240px;">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100">
                    <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">Menu</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">

                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">หน้าหลัก</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('cart') }}" class="nav-link align-middle px-0">
                                <i class="bi bi-cart3"></i> <span class="ms-1 d-none d-sm-inline">ตะกร้าสินค้า</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('shippingblade') }}" class="nav-link align-middle px-0">
                                <i class="bi bi-cart3"></i> <span class="ms-1 d-none d-sm-inline">การจัดส่ง</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('product.list') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-box-seam"></i> <span
                                    class="ms-1 d-none d-sm-inline">รายการสินค้า</span></a>
                        </li>
                        <li>
                            <a href="{{ route('add.data') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-box-seam"></i> <span
                                    class="ms-1 d-none d-sm-inline">จัดการประเภทสินค้า</span></a>
                        </li>

                        <li>
                            <a href="{{ route('sale') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-graph-up"></i> <span
                                    class="ms-1 d-none d-sm-inline">ข้อมูลการขาย</span></a>
                        </li>
                        <li>
                            <a href="{{ route('stock') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-archive"></i><span
                                    class="ms-1 d-none d-sm-inline">สต็อกสินค้า</span></a>

                        </li>
                        <li>
                            <a href="#" class="nav-link px-0 align-middle">
                                <i class="bi bi-cpu"></i><span class="ms-1 d-none d-sm-inline">ข้อมูลคอยล์</span></a>
                        </li>
                        <li>
                            <a href="{{ route('customer') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-people"></i><span
                                    class="ms-1 d-none d-sm-inline">ข้อมูลลูกค้า</span></a>
                        </li>
                    </ul>
                    <hr>

                    <div class="dropdown pb-4">
                        <a href="#"
                            class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('img/user.jpeg') }}" alt="hugenerd" width="30" height="30"
                                class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1">User</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sign out
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col py-3">
                <div class="col py-3 main-content">

                    <!-- HEADER -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold text-primary">
                            <i class="bi bi-graph-up"></i> ข้อมูลการขาย
                        </h3>
                    </div>

                    <!-- SEARCH -->
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-body">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" id="searchInput" class="form-control"
                                    placeholder="ค้นหาด้วยรหัสออเดอร์ หรือวันที่">
                            </div>
                        </div>
                    </div>

                    <!-- TABLE CARD -->
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table align-middle table-hover">

                                    <thead class="table-light">
                                        <tr>
                                            <th>📅 วันที่</th>
                                            <th>🧾 Order</th>
                                            <th>📦 จำนวน</th>
                                            <th>💰 ยอดรวม</th>
                                            <th>📌 สถานะ</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($orders as $order)
                                        <tr>

                                            <td>{{ $order->created_at->format('d/m/Y') }}</td>

                                            <td class="fw-bold text-primary">
                                                #{{ $order->id }}
                                            </td>

                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $order->orderDetails->count() }} รายการ
                                                </span>
                                            </td>

                                            <td class="fw-bold text-success">
                                                ฿{{ number_format($order->total_price, 2) }}
                                            </td>

                                            <td>
                                                @php
                                                    $statusText = '';
                                                    $badgeClass = 'secondary';

                                                    if ($order->status === 'completed') {
                                                        $statusText = 'สำเร็จ';
                                                        $badgeClass = 'success';
                                                    }elseif ($order->status === 'pending_delivery') {
                                                        $statusText = 'รอจัดส่ง';
                                                        $badgeClass = 'warning text-dark';

                                                    } elseif ($order->status === 'canceled') {
                                                        $statusText = 'ยกเลิก';
                                                        $badgeClass = 'danger';
                                                    }
                                                @endphp

                                                <span class="badge bg-{{ $badgeClass }} px-3 py-2">
                                                    {{ $statusText }}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary rounded-pill"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#orderDetails{{ $order->id }}">
                                                    <i class="bi bi-eye"></i> ดู
                                                </button>

                                                <button class="btn btn-sm btn-outline-dark rounded-pill">
                                                    <i class="bi bi-printer"></i>
                                                </button>
                                            </td>

                                            <a href="{{ route('orders.pdf', $order->id) }}"
                                                dd($fontPath, file_exists($fontPath));
                                                target="_blank"
                                                class="btn btn-danger btn-sm">

                                                 📄 PDF

                                             </a>
                                        </tr>

                                        <!-- DETAIL -->
                                        <tr class="collapse" id="orderDetails{{ $order->id }}">
                                            <td colspan="6">

                                                <div class="p-3 bg-light rounded-3">

                                                    <p class="mb-2">
                                                        <strong>📞 เบอร์โทร:</strong>
                                                        {{ $order->customer_phone ?? '-' }}
                                                    </p>

                                                    <div class="table-responsive">
                                                        <table class="table table-sm align-middle mb-0">

                                                            <thead>
                                                                <tr>
                                                                    <th>สินค้า</th>
                                                                    <th>ประเภท</th>
                                                                    <th>จำนวน</th>
                                                                    <th>ราคา</th>
                                                                    <th>รวม</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                @foreach ($order->orderDetails as $item)
                                                                @php
                                                                    $productName = $item->product->productItem->item_name ?? 'สินค้า';
                                                                    $priceType = $item->price_type === 'wholesale_price' ? 'ราคาส่ง' : 'ราคาปลีก';
                                                                    $unitPrice = number_format($item->unit_price, 2);
                                                                    $total = number_format($item->unit_price * $item->quantity, 2);
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $productName }}</td>
                                                                    <td>
                                                                        <span class="badge bg-info text-dark">
                                                                            {{ $priceType }}
                                                                        </span>
                                                                    </td>
                                                                    <td>{{ $item->quantity }}</td>
                                                                    <td>฿{{ $unitPrice }}</td>
                                                                    <td class="fw-bold text-success">
                                                                        ฿{{ $total }}z
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>

                                                        </table>
                                                    </div>

                                                </div>

                                            </td>
                                        </tr>

                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>

                </div>
        </div>
</body>

</html>
