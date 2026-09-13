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
                <a href="#"
                    class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
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
                            <i class="fs-4 bi-table"></i> <span
                                class="ms-1 d-none d-sm-inline">ประวัติการเคลื่อนไหว</span>
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
                <h2 class="mb-4">Admin Dashboard</h2>
                <a href="{{ route('admin.index') }}" class="btn btn-primary btn-sm mt-3">
                    กลับไปหน้าหลัก
                </a>

                <h3 class="mb-4">{{ $title }}</h3>

                <!-- 🔽 ตัวเลือก วัน / เดือน -->
                <form method="GET" class="row g-2 mb-4">
                    <div class="col-md-3">
                        <select name="type" class="form-select" onchange="this.form.submit()">
                            <option value="day" {{ $type == 'day' ? 'selected' : '' }}>รายวัน</option>
                            <option value="month" {{ $type == 'month' ? 'selected' : '' }}>รายเดือน</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <input type="{{ $type == 'day' ? 'date' : 'month' }}" name="date" value="{{ $date }}"
                            class="form-control" onchange="this.form.submit()">
                    </div>
                </form>

                <!-- 🔹 สรุปด้านบน -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>จำนวนคำสั่งซื้อ</h6>
                                <h4>{{ $orderCount }} รายการ</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>ยอดขายรวม</h6>
                                <h4>{{ number_format($totalRevenue, 2) }} บาท</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 🔹 ตารางรายการออเดอร์ -->
                <div class="card shadow-sm">
                    <div class="card-header">รายการคำสั่งซื้อ</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>เลขออเดอร์</th>
                                    <th>ยอดรวม</th>
                                    <th>วันที่</th>
                                    <th>รายละเอียด</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ number_format($order->total_price, 2) }}</td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                                class="btn btn-sm btn-primary">
                                                ดูรายละเอียด
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">ไม่มีคำสั่งซื้อ</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>



    </body>

    </html>
