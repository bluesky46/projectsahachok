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
    <title>สต็อกสินค้า </title>
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
                        <li class="nav-item">
                            <a href="{{ route('admin.order.proof') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-truck"></i> <span
                                    class="ms-1 d-none d-sm-inline">หลักฐานการจัดส่ง</span>
                            </a>
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
                                @if ($products->where('stock_quantity', '<', 10)->count() > 0)
                                    <i class="bi bi-exclamation-circle-fill text-danger" title="สินค้าสต็อกต่ำ"></i>
                                @endif
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
                        <li>
                            <a href="{{ route('suppliers.index') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-people"></i>
                                <span class="ms-1 d-none d-sm-inline">ข้อมูลผู้จัดซื้อ</span>
                            </a>
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
                {{-- <h3 class="mb-3">รายการสต็อกสินค้า</h3>


                @if ($products->where('min_stock', '<', 10)->count() > 0)
                    <div class="alert alert-warning d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div>มีสินค้าที่สต็อกต่ำกว่า 10 ชิ้น กรุณาตรวจสอบ!</div>
                    </div>
                @endif --}}

                {{-- ฟอร์มค้นหา --}}
                {{-- <form method="GET" action="{{ route('#') }}" class="mb-4">
                    <div class="input-group shadow-sm mb-4">
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="ค้นหาสินค้า / รหัส / การเคลื่อนไหว..." onkeyup="filterStockData()">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>

                </form> --}}

                {{-- <script>
                    function filterStockData() {
                        const input = document.getElementById('searchInput').value.toLowerCase();

                        // ค้นหาใน "รายการสต็อกสินค้า"
                        document.querySelectorAll('.stock-table tbody tr').forEach(row => {
                            const rowText = row.innerText.toLowerCase();
                            row.style.display = rowText.includes(input) ? '' : 'none';
                        });

                        // ค้นหาใน "ประวัติการเคลื่อนไหว"
                        document.querySelectorAll('.movement-table tbody tr').forEach(row => {
                            const rowText = row.innerText.toLowerCase();
                            row.style.display = rowText.includes(input) ? '' : 'none';
                        });
                    }
                </script> --}}




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

                    {{-- <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <a class="btn btn-primary" href="{{ route ('stock') }}">ข้อมูลสต็อกสินค้า</a>
                        <a  class="btn btn-primary" href="{{ route('stock2') }}">ข้อมูลการเคลื่อนไหวของสินค้า</a> --}}
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
                                Dropdown
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                                <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                            </ul>
                        </div> --}}

                </div>

                @if ($products->isEmpty())
                    <div class="alert alert-warning">ยังไม่มีข้อมูลสินค้า</div>
                @else
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table align-middle table-hover">

                                    <thead class="table-light">
                                        <th>รหัสสินค้า</th>
                                        <th>ชื่อสินค้า</th>
                                        <th>คงเหลือ (หน่วย)</th>
                                        <th>ราคาทุน</th>
                                        <th>ราคาปลีก</th>
                                        <th>ราคาส่ง</th>
                                        <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $p)
                                            <tr>
                                                <td>{{ $p->product_code }}</td>
                                                <td>{{ optional($p->productItem)->item_name ?? '-' }}</td>
                                                <td>{{ number_format($p->stock_quantity) }}</td>
                                                <td>{{ number_format(optional($p->productItem)->cost_price ?? 0, 2) }}
                                                    ฿</td>
                                                <td>{{ number_format(optional($p->productItem)->retail_price ?? 0, 2) }}
                                                    ฿</td>
                                                <td>{{ number_format(optional($p->productItem)->wholesale_price ?? 0, 2) }}
                                                    ฿</td>
                                                <td>
                                                    <button class="btn btn-sm btn-success"
                                                        onclick="openAddStockModal({{ $p->id }}, '{{ $p->productItem->item_name }}')">
                                                        เพิ่มสต็อก
                                                    </button>
                                                </td>


                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="modal fade" id="addStockModal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">เพิ่มสต็อกสินค้า</h5>
                                                <button class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <h6 id="stockProductName"></h6>

                                                <input type="hidden" id="stockProductId">

                                                <label>จำนวนที่รับเข้า</label>
                                                <input type="number" id="addQty" class="form-control">
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-primary"
                                                    onclick="confirmAddStock()">บันทึก</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                @endif
                <script>
                    function openAddStockModal(id, name) {
                        document.getElementById('stockProductId').value = id;
                        document.getElementById('stockProductName').innerText = name;
                        document.getElementById('addQty').value = '';

                        new bootstrap.Modal(document.getElementById('addStockModal')).show();
                    }

                    function confirmAddStock() {
                        const id = document.getElementById('stockProductId').value;
                        const qty = document.getElementById('addQty').value;

                        if (!qty || qty <= 0) {
                            Swal.fire('ผิดพลาด', 'กรุณาใส่จำนวนให้ถูกต้อง', 'error');
                            return;
                        }

                        fetch('{{ route('stock.add') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    product_id: id,
                                    qty: qty
                                })
                            })
                            .then(res => res.json())
                            .then(res => {
                                if (res.success) {
                                    Swal.fire('สำเร็จ', 'เพิ่มสต็อกแล้ว', 'success')
                                        .then(() => location.reload());
                                }
                            })
                            .catch(() => {
                                Swal.fire('ผิดพลาด', 'ไม่สามารถเพิ่มสต็อกได้', 'error');
                            });
                    }
                </script>

            </div>


        </div>



</body>

</html>
