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
    <title>สต็อกสินค้า</title>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .container-fluid {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .row.flex-nowrap {
            flex: 1;
            display: flex;
        }

        .sidebar-fixed {
            width: 240px;
        }

        .table-warning td {
            font-weight: bold;
        }

        .sidebar-fixed {
            position: fixed;
            /* ทำให้ sidebar อยู่กับที่ */
            top: 0;
            left: 0;
            height: 100vh;
            /* ความสูงเต็มหน้าจอ */
            width: 240px;
            overflow-y: auto;
            /* เลื่อน scrollbar ใน sidebar ได้ */
            z-index: 1000;
            /* อยู่ด้านบนเนื้อหา */
        }

        /* เนื้อหาหลักให้เว้นที่ซ้ายเท่ากับความกว้าง sidebar */
        .col.p-4 {
            margin-left: 240px;
            overflow-x: hidden;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
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
                            <a href="{{ route('stock') }}"
                                class="nav-link px-0 align-middle d-flex align-items-center justify-content-between">
                                <span>
                                    <i class="bi bi-archive"></i>
                                    <span class="ms-1 d-none d-sm-inline">สต็อกสินค้า</span>
                                </span>

                                {{-- เช็คว่ามีสินค้าสต็อกต่ำกว่า 10 ไหม --}}
                                {{-- @if ($products->where('min_stock', '<', 10)->count() > 0) --}}
                                {{-- @if ($products->where('stock_quantity', '<', 10)->count() > 0)
                                    <i class="bi bi-exclamation-circle-fill text-danger" title="สินค้าสต็อกต่ำ"></i>
                                @endif --}}
                            </a>
                        </li>

                        {{-- <li>
                            <a href="{{ route('coildata') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-cpu"></i><span class="ms-1 d-none d-sm-inline">ข้อมูลคอยล์</span></a>
                        </li> --}}
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
            {{--
            <div class="col p-4">
                <h2 class="mb-4 fw-bold text-primary">ข้อมูลประวัติการเคลื่อนไหวของสินค้า</h2>
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <a class="btn btn-primary" href="{{ route('stock') }}">ข้อมูลสต็อกสินค้า</a>
                    <a class="btn btn-primary" href="{{ route('stock2') }}">ข้อมูลการเคลื่อนไหวของสินค้า</a>

                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                            <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                        </ul>
                    </div>
                </div>


                <div >
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>สินค้า</th>
                                <th>จำนวน</th>
                                <th>ประเภท</th>
                                <th>ราคาทุน</th>
                                <th>ราคาขาย</th>
                                <th>กำไร</th>
                                <th>หมายเหตุ</th>
                                <th>วันที่</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stockMovements as $movement)
                                @php
                                    $item = $movement->product->productItem ?? null;
                                    $costPrice = $item->cost_price ?? 0;
                                    $salePrice = $item->retail_price ?? 0;
                                    $profit = $salePrice - $costPrice;
                                @endphp
                                <tr>
                                    <td>{{ $item->item_name ?? '-' }}</td>
                                    <td>{{ $movement->quantity }}</td>
                                    <td>{{ $movement->movement_type === 'in' ? 'เข้า' : 'ออก' }}</td>
                                    <td>{{ number_format($costPrice, 2) }} ฿</td>
                                    <td>{{ number_format($salePrice, 2) }} ฿</td>
                                    <td>{{ number_format($profit, 2) }} ฿</td>
                                    <td>{{ $movement->note ?? '-' }}</td>
                                    <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> --}}
            <div class="col p-4">
            <div class="container py-4">
                <h2 class="mb-4 fw-bold text-primary">ข้อมูลสต็อกสินค้าและประวัติการเคลื่อนไหว</h2>
                {{-- ฟอร์มค้นหา --}}
                <div class="input-group shadow-sm mb-4 rounded-3 overflow-hidden">
                    <span class="input-group-text bg-white border-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-0"
                        placeholder="ค้นหาสินค้า / รหัส..." onkeyup="filterStockData()">
                </div>
                <script>
                    document.getElementById('searchInput').addEventListener('keyup', function() {
                        const input = this.value.toLowerCase();
                        const rows = document.querySelectorAll('table tbody tr:not(.collapse)');

                        rows.forEach(row => {
                            const text = row.innerText.toLowerCase();
                            row.style.display = text.includes(input) ? '' : 'none';
                        });

                        document.querySelectorAll('tr.collapse').forEach(row => {
                            const prevRow = row.previousElementSibling;
                            if (prevRow.style.display === 'none') {
                                row.style.display = 'none';
                            } else {
                                row.style.display = '';
                            }
                        });
                    });
                </script>

                <div class="btn-group mb-4 shadow-sm">
                    <a class="btn btn-outline-primary {{ request()->routeIs('stock') ? 'active' : '' }}"
                        href="{{ route('stock') }}">
                        📦 สต็อกสินค้า
                    </a>

                    <a class="btn btn-outline-primary {{ request()->routeIs('stock2') ? 'active' : '' }}"
                        href="{{ route('stock2') }}">
                        🔄 การเคลื่อนไหว
                    </a>
                </div>
                    {{-- <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            dropdown
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <li><a class="dropdown-item" href="#">วัน</a></li>
                            <li><a class="dropdown-item" href="#">เดือน</a></li>
                            <li><a class="dropdown-item" href="#">ปี</a></li>
                        </ul>
                    </div> --}}


                </div>
                <div class="mb-4 mt-4">
                    <table class="table table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>สินค้า</th>
                                <th>จำนวน</th>
                                <th>ประเภท</th>
                                <th>ราคาทุน</th>
                                <th>ราคาขาย</th>
                                <th>กำไร</th>
                                <th>หมายเหตุ</th>
                                <th>วันที่</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stockMovements as $movement)
                                @php
                                    $item = $movement->product->productItem ?? null;
                                    $costPrice = $item->cost_price ?? 0;
                                    $salePrice = $item->retail_price ?? 0;
                                    $profit = $salePrice - $costPrice;
                                    $rowClass = $movement->movement_type === 'in' ? 'table-success' : 'table-danger';
                                @endphp
                                <tr class="{{ $rowClass }}">
                                    <td>{{ $item->item_name ?? '-' }}</td>
                                    <td>{{ $movement->quantity }}</td>
                                    <td>{{ $movement->movement_type === 'in' ? 'เข้า' : 'ออก' }}</td>
                                    <td>{{ number_format($costPrice, 2) }} ฿</td>
                                    <td>{{ number_format($salePrice, 2) }} ฿</td>
                                    <td>{{ number_format($profit, 2) }} ฿</td>
                                    <td>{{ $movement->note ?? '-' }}</td>
                                    <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <script>
            document.getElementById('searchInput').addEventListener('keyup', function() {
                const input = this.value.toLowerCase();
                const rows = document.querySelectorAll('table tbody tr:not(.collapse)');

                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(input) ? '' : 'none';
                });

                // ซ่อน/แสดงแถวรายละเอียดตามการแสดงผลของแถวหลัก
                document.querySelectorAll('tr.collapse').forEach(row => {
                    const prevRow = row.previousElementSibling;
                    if (prevRow.style.display === 'none') {
                        row.style.display = 'none';
                    } else {
                        row.style.display = '';
                    }
                });
            });
        </script>

</body>

</html>
