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

    <title>การจัดส่ง</title>
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
                    <a href="{{ route('admin.index') }}"class="nav-link align-middle px-0">
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
            <h3>รายการรอจัดส่ง</h3>

            <button id="selectAllBtn" class="btn btn-sm btn-primary mb-3">เลือกทั้งหมด</button>
            <form action="{{ route('admin.orders.print') }}" method="POST" id="bulkPrintForm">
                @csrf
                <input type="hidden" name="order_ids" id="orderIdsInput">
                <button type="submit" class="btn btn-sm btn-success">พิมพ์ใบสั่งซื้อ</button>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>เลขที่สั่งซื้อ</th>
                        <th>ลูกค้า</th>
                        <th>เบอร์โทร</th>
                        <th>สินค้า</th>
                        <th>ยอดรวม</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td><input type="checkbox" class="orderCheckbox" value="{{ $order->id }}"></td>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer ? $order->customer->name : '-' }}</td>
                            <td>{{ $order->customer_phone }}</td>
                            <td>
                                @foreach ($order->orderDetails as $item)
                                    {{ $item->product->name }} ({{ $item->quantity }})<br>
                                @endforeach
                            </td>
                            <td>{{ number_format($order->total_price, 2) }}</td>
                            <td><span class="badge bg-warning">รอจัดส่ง</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <script>
                document.getElementById('selectAll').addEventListener('click', function() {
                    const checkboxes = document.querySelectorAll('.orderCheckbox');
                    checkboxes.forEach(cb => cb.checked = this.checked);
                });

                document.getElementById('selectAllBtn').addEventListener('click', function() {
                    const checkboxes = document.querySelectorAll('.orderCheckbox');
                    checkboxes.forEach(cb => cb.checked = true);
                });

                document.getElementById('bulkPrintForm').addEventListener('submit', function(e) {
                    const selected = [];
                    document.querySelectorAll('.orderCheckbox:checked')
                        .forEach(cb => selected.push(cb.value));

                    if (selected.length === 0) {
                        e.preventDefault();
                        alert('กรุณาเลือกออเดอร์อย่างน้อย 1 รายการ');
                        return;
                    }

                    // ส่งข้อมูลแบบ array ปกติ
                    document.getElementById('orderIdsInput').value = selected.join(',');
                });
            </script>
        </div>
    </div>



</body>

</html>
