<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <title>Document</title>
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 220px;
            background-color: #212529;
            overflow-y: auto;
            z-index: 1000;
        }

        /* เนื้อหาให้อยู่ทางขวา มีระยะห่างจาก Sidebar */
        .content {
            margin-left: 220px;
            padding: 20px;
            box-sizing: border-box;
        }

        /* ป้องกันให้ body ไม่เลื่อนซ้ายขวา (overflow-x) */
        body {
            overflow-x: hidden;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <!-- Sidebar code as before -->
        <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
            <a href="#" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-5 d-none d-sm-inline">Menu</span>
            </a>
            <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                id="menu">
                <li class="nav-item">
                    <a href="#" class="nav-link align-middle px-0">
                        <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">หน้าหลัก</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.loginHistory') }}" class="nav-link px-0 align-middle">
                        <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">เวลาเข้า-ออกระบบ</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('adminstock') }}" class="nav-link px-0 align-middle">
                        <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">ประวัติการเคลื่อนไหว</span>
                    </a>
                </li>
            </ul>
            <hr />
            <div class="dropdown pb-4">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('img/user.jpeg') }}" alt="hugenerd" width="30" height="30"
                        class="rounded-circle" />
                    <span class="d-none d-sm-inline mx-1">Admin</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign
                            out</a></li>
                </ul>
            </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <div class="content">
        <div class="container-fluid mt-4">
            <div class="container mt-4">

                <h3 class="mb-4">รายละเอียดคำสั่งซื้อ #{{ $order->id }}</h3>

                {{-- ข้อมูลออเดอร์ --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <p><strong>วันที่:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>ลูกค้า:</strong> {{ $order->customer->name ?? '-' }}</p>
                        <p><strong>เบอร์โทร:</strong> {{ $order->customer_phone }}</p>
                        <p><strong>ยอดรวม:</strong> {{ number_format($order->total_price, 2) }} บาท</p>
                    </div>
                </div>

                {{-- ตารางสินค้า --}}
                <div class="card">
                    <div class="card-header">รายการสินค้า</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>สินค้า</th>
                                    <th>จำนวน</th>
                                    <th>ราคาต่อหน่วย</th>
                                    <th>ประเภทราคา</th>
                                    <th>รวม</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($order->orderDetails as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->product->productItem->item_name ?? '-' }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>{{ number_format($detail->unit_price, 2) }}</td>
                                    <td>{{ $detail->price_type }}</td>
                                    <td>{{ number_format($detail->total_price, 2) }}</td>
                                   
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">
                    ← กลับ
                </a>

            </div>

</body>
</html>
