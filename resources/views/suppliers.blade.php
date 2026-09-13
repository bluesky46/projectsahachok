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
    <title>ผู้ขาย</title>
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
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col p-4">

                <!-- HEADER -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold text-primary">
                        🏗️ รายชื่อผู้จัดซื้อ (Suppliers)
                    </h3>

                    <span class="badge bg-dark">
                        ทั้งหมด {{ $suppliers->count() }} รายการ
                    </span>
                </div>

                <!-- CARD TABLE -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">

                        <!-- SEARCH -->
                        <div class="mb-3">
                            <input type="text" id="searchInput" class="form-control"
                                placeholder="🔍 ค้นหาชื่อ Supplier...">
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle table-hover">

                                <thead class="table-light">
                                    <tr>
                                        <th>🏢 ชื่อ Supplier</th>
                                        <th class="text-center">📦 จัดการ</th>
                                    </tr>
                                </thead>

                                <tbody id="supplierTable">
                                    @forelse($suppliers as $supplier)
                                    <tr>
                                        <td class="fw-semibold">
                                            <i class="bi bi-building me-2 text-primary"></i>
                                            {{ $supplier->name }}
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('suppliers.show', $supplier->id) }}"
                                               class="btn btn-sm btn-outline-primary rounded-pill">
                                               <i class="bi bi-eye"></i> ดูสินค้า
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-4">
                                            😢 ไม่มีข้อมูล Supplier
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>

            </div>

            <!-- 🔥 JS ค้นหาแบบ real-time -->
            <script>
            document.getElementById('searchInput').addEventListener('keyup', function () {
                let filter = this.value.toLowerCase();
                let rows = document.querySelectorAll('#supplierTable tr');

                rows.forEach(row => {
                    let text = row.innerText.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });
            </script>

</body>
</html>
