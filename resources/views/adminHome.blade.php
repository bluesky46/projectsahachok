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

    <title>Home</title>
    <style>
        body {
            background: #f4f6f9;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 230px;
            background: linear-gradient(180deg, #1e3c72, #2a5298);
            color: white;
            z-index: 1000;
        }

        .sidebar a {
            color: #ddd;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-radius: 8px;
        }

        .content {
            margin-left: 230px;
            padding: 25px;
        }

        /* Card style */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        .card-header {
            font-weight: 600;
            border-radius: 15px 15px 0 0 !important;
        }

        /* Dashboard title */
        h2 {
            font-weight: 700;
        }

        /* Stat cards */
        .stat-card {
            border-radius: 15px;
            padding: 20px;
            color: white;
        }

        .bg-gradient-blue {
            background: linear-gradient(45deg, #36d1dc, #5b86e5);
        }

        .bg-gradient-green {
            background: linear-gradient(45deg, #11998e, #38ef7d);
        }

        .bg-gradient-orange {
            background: linear-gradient(45deg, #ff9966, #ff5e62);
        }

        /* list */
        .list-group-item {
            border: none;
            border-bottom: 1px solid #eee;
        }

        /* modal */
        .modal-content {
            border-radius: 15px;
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
                <li>
                    <a href="{{ route('admin.checkuser') }}" class="nav-link px-0 align-middle">
                        <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">จัดการผู้ใช้</span>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>📊 Admin Dashboard</h2>
                <span class="text-muted">ระบบจัดการร้านวัสดุก่อสร้าง</span>
            </div>

            <div class="row g-4">

                <!-- สินค้าใกล้หมด 5 อันดับ -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-danger text-white">
                            ⚠️ สินค้าใกล้หมด (Top 5)
                        </div>
                        <ul class="list-group list-group-flush">
                            @forelse($lowStockProductsTop ?? [] as $product)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $product->product_name ?? 'ไม่พบชื่อสินค้า' }}
                                    <span class="badge bg-warning text-dark">
                                        {{ $product->current_stock ?? 0 }}
                                    </span>
                                </li>
                            @empty
                                <li class="list-group-item text-center">
                                    ไม่มีสินค้าใกล้หมดสต็อก
                                </li>
                            @endforelse
                        </ul>
                        <div class="card-footer text-end">
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#lowStockModal">
                                ดูสินค้าใกล้หมดสต็อกทั้งหมด
                            </button>
                        </div>
                    </div>
                </div>


                <!-- สินค้าขายดี 5 อันดับ -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            สินค้าขายดี (5 อันดับ)
                        </div>
                        <ul class="list-group list-group-flush">
                            @forelse($bestSellingProductsTop ?? [] as $product)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $product->product->productItem->item_name ?? 'ไม่พบชื่อสินค้า' }}
                                    {{-- {{ $product->product_name ?? 'ไม่พบชื่อสินค้า' }} --}}
                                    <span class="badge bg-success">
                                        {{ $product->total_quantity }}
                                    </span>
                                </li>
                            @empty
                                <li class="list-group-item text-center">
                                    ไม่มีข้อมูลสินค้าขายดี
                                </li>
                            @endforelse
                        </ul>
                        <div class="card-footer text-end">
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#bestSellingModal">
                                ดูสินค้าขายดีทั้งหมด
                            </button>
                        </div>
                    </div>
                </div>

                <!-- รายได้เดือนนี้ -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white d-flex justify-content-between">
                            <span>รายได้เดือนนี้</span>
                            <form method="GET" action="{{ route('admin.index') }}">
                                <select name="month" class="form-select form-select-sm" onchange="this.form.submit()">
                                    @foreach ($availableMonths ?? [] as $value => $name)
                                        <option value="{{ $value }}"
                                            {{ request('month') == $value ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <div class="card-body">
                            <h4>{{ number_format($currentMonthRevenue ?? 0, 2) }} บาท</h4>
                            <p>
                                เทียบเดือนก่อน:
                                <span class="{{ ($percentageChange ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($percentageChange ?? 0, 2) }}%
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- จำนวนคำสั่งซื้อ -->
            <div class="row g-4 mt-1">
            <div class="col-md-3">
                <a href="{{ route('admin.today') }}" class="text-decoration-none">
                    <div class="stat-card bg-gradient-blue text-center">
                        <h6>คำสั่งซื้อวันนี้</h6>
                        <h2>{{ $todayOrders ?? 0 }}</h2>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('admin.month') }}" class="text-decoration-none">
                    <div class="stat-card bg-gradient-green text-center">
                        <h6>คำสั่งซื้อเดือนนี้</h6>
                        <h2>{{ $monthOrders ?? 0 }}</h2>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('admin.pending') }}" class="text-decoration-none">
                    <div class="stat-card bg-gradient-orange text-center">
                        <h6>รอจัดส่ง</h6>
                        <h2>{{ $pendingCount }}</h2>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
            <a href="{{ route('admin.completed') }}" class="text-decoration-none">
                <div class="stat-card bg-success text-center">
                    <h6>ส่งสำเร็จ</h6>
                    <h2>{{ $completedCount }}</h2>
                </div>
            </a>
            </div>
        </div>


            <!-- กราฟยอดขาย -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-primary text-white">
                    📈 ยอดขาย 7 วันล่าสุด
                </div>
                <div class="card-body" style="height:300px">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- ประวัติการเคลื่อนไหว -->
            <div class="card shadow-sm mt-4">
                <div class="card-header">ประวัติการเคลื่อนไหวสต็อก</div>
                <ul class="list-group list-group-flush">
                    @forelse($recentActivities ?? [] as $activity)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge {{ $activity->type === 'รับเข้า' ? 'bg-success' : 'bg-danger' }}">
                                {{ $activity->type }}
                            </span>
                            {{ $activity->product->productItem->item_name ?? '-' }}
                            ({{ $activity->quantity }})
                        </div>
                        <small class="text-muted">
                            {{ $activity->created_at->format('d/m/Y H:i') }}
                        </small>
                    </li>
                    @empty
                        <li class="list-group-item text-center">
                            ไม่มีรายการเคลื่อนไหว
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal สินค้าใกล้หมด -->
    <div class="modal fade" id="lowStockModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">สินค้าใกล้หมดสต็อกทั้งหมด</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>รหัสสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>คงเหลือ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowStockProductsAll ?? [] as $product)
                                <tr>
                                    <td>{{ $product->product_code }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->current_stock }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">ไม่มีข้อมูล</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal สินค้าขายดี -->
    <div class="modal fade" id="bestSellingModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">สินค้าขายดีทั้งหมด</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>รหัสสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>จำนวนขาย</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bestSellingProductsAll ?? [] as $item)
                                <tr>
                                    <td>{{ $item->product->product_code ?? '-' }}</td>
                                    <td>{{ $item->product->productItem->item_name ?? '-' }}</td>
                                    <td>{{ $item->total_quantity }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">ไม่มีข้อมูล</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @if (!empty($salesLabels) && !empty($salesData))
        <script>
            const ctx = document.getElementById('salesChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($salesLabels) !!},
                    datasets: [{
                        label: 'ยอดขาย (บาท)',
                        data: {!! json_encode($salesData) !!},
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        </script>
    @endif

</body>

</html>
