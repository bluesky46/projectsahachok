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


    <title>การจัดส่ง </title>
</head>
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


    .order-box {
        page-break-after: always;
        /* จะขึ้นหน้าใหม่หลังจากแต่ละออเดอร์ */
    }
</style>

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
            {{-- <div class="col p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-primary">การจัดส่ง</h2>

                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($orders->isEmpty())
                    <div class="alert alert-warning">ไม่มีรายการออเดอร์ที่ต้องจัดส่ง</div>
                @else
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>รหัสออเดอร์</th>
                                <th>ลูกค้า</th>
                                <th>รวมราคา</th>
                                <th>สถานะ</th>
                                <th>จัดการ</th>
                                <th>รายละเอียด</th> <!-- เพิ่มคอลัมน์ใหม่ -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $index => $order)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->customer_phone ?? '-' }}</td>
                                    <td>{{ number_format($order->total_price, 2) }}</td>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'pending_delivery' => 'bg-warning text-dark',
                                                'ready_to_ship' => 'bg-info text-white',
                                                'delivered' => 'bg-success text-white',
                                            ];
                                        @endphp
                                        <span class="badge {{ $statusClasses[$order->status] ?? 'bg-secondary' }}">
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('shipping.update', $order->id) }}" method="POST"
                                            class="d-flex gap-2">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-select form-select-sm">
                                                <option value="pending_delivery"
                                                    {{ $order->status == 'pending_delivery' ? 'selected' : '' }}>
                                                    รอตรวจสอบ</option>
                                                <option value="ready_to_ship"
                                                    {{ $order->status == 'ready_to_ship' ? 'selected' : '' }}>
                                                    จัดเสร็จรอส่ง</option>
                                                <option value="delivered"
                                                    {{ $order->status == 'delivered' ? 'selected' : '' }}>ส่งสำเร็จ
                                                </option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary">บันทึก</button>
                                        </form>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#orderDetailModal"
                                            onclick="loadOrderDetails({{ $order->id }})">
                                            ดูรายละเอียด
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
            <!-- Order Detail Modal -->
            <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="orderDetailModalLabel">รายละเอียดออเดอร์</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered" id="orderDetailTable">
                                <thead>
                                    <tr>
                                        <th>สินค้า</th>
                                        <th>ราคา/หน่วย</th>
                                        <th>จำนวน</th>
                                        <th>ราคารวม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- รายละเอียดจะถูกเติมด้วย JS -->
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>



                        </div>
                    </div>
                </div>
            </div>
            <script>
               function loadOrderDetails(orderId) {
    fetch(`/shipping/order-details/${orderId}`)
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector('#orderDetailTable tbody');
            tbody.innerHTML = '';
            let total = 0;

            data.items.forEach(item => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${item.name}</td>
                    <td>${Number(item.price).toLocaleString(undefined, {minimumFractionDigits:2})} ฿</td>
                    <td>${item.qty}</td>
                    <td>${Number(item.total).toLocaleString(undefined, {minimumFractionDigits:2})} ฿</td>
                `;
                tbody.appendChild(tr);
                total += Number(item.total);
            });


            const trTotal = document.createElement('tr');
            trTotal.innerHTML =
                `<td colspan="3" class="text-end fw-bold">รวมทั้งหมด</td>
                 <td class="fw-bold">${total.toLocaleString(undefined, {minimumFractionDigits:2})} ฿</td>`;
            tbody.appendChild(trTotal);
        });
}


    {{-- <div class="col p-4">
            </script> --}}
            <div class="col p-4">
                <div class="container py-4">

                    <h2 class="fw-bold text-primary mb-4">รายการออเดอร์ที่ต้องจัดส่ง</h2>

                    @if ($orders->isEmpty())
                        <div class="alert alert-warning">ไม่มีออเดอร์ที่ต้องจัดส่ง</div>
                    @else
                        <!-- ปุ่มเลือกทั้งหมด และพิมพ์ออเดอร์ที่เลือก -->
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary btn-sm"
                                onclick="toggleSelectAll()">เลือกทั้งหมด</button>
                            <button type="button" class="btn btn-success btn-sm"
                                onclick="printSelectedOrders()">พิมพ์ออเดอร์ที่เลือกทั้งหมด</button>
                        </div>

                        @foreach ($orders as $order)
                            <div class="order-box border p-3 mb-3 d-flex align-items-start">
                                <div class="me-3">
                                    <input type="checkbox" class="print-checkbox" value="{{ $order->id }}">
                                </div>

                                <div class="flex-grow-1">
                                    <div class="mb-3 d-flex justify-content-between">
                                        <div>
                                            <h1 class="text-center"><strong>บริษัท สหโชค จำกัด หลังคาเหล็ก</strong>
                                            </h1>
                                            {{-- <p><strong>ผู้ส่ง :</strong> ร้านสหโชคหลังคาเหล็ก 99/1 หมู่6 ตำบลในเมือง
                                                ถนนเลี่ยงเมือง อำเภอบ้านไผ่ จังหวัดขอนแก่น 40110</p> --}}
                                            <p><strong>ผู้รับ :</strong> {{ $order->customer->name ?? '-' }}</p>
                                            <p><strong>เบอร์โทร :</strong> {{ $order->customer->phone ?? '-' }}</p>
                                            <p><strong>ที่อยู่ :</strong>
                                                @if ($order->customer)
                                                    {{ collect([
                                                        $order->customer->address_number ? 'บ้านเลขที่ ' . $order->customer->address_number : null,
                                                        $order->customer->address_building ? 'บ้าน/อาคาร ' . $order->customer->address_building : null,
                                                        $order->customer->address_street ? 'ถนน ' . $order->customer->address_street : null,
                                                        $order->customer->address_subdistrict ? 'ตำบล ' . $order->customer->address_subdistrict : null,
                                                        $order->customer->address_district ? 'อำเภอ ' . $order->customer->address_district : null,
                                                        $order->customer->address_province ? 'จังหวัด ' . $order->customer->address_province : null,
                                                        $order->customer->postal_code ? 'รหัสไปรษณีย์ ' . $order->customer->postal_code : null,
                                                    ])->filter()->implode(' ') }}
                                                @else
                                                    - ไม่ระบุ -
                                                @endif
                                            </p>
                                        </div>

                                        <!-- ปุ่มพิมพ์ออเดอร์นี้ -->
                                        {{-- <div>
                                    <button type="button" class="btn btn-success btn-sm" onclick="printOrder({{ $order->id }})">พิมพ์</button>
                                </div> --}}
                                    </div>

                                    <!-- ตารางสินค้า -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>รหัสสินค้า</th>
                                                <th>ชื่อสินค้า</th>
                                                <th>ราคาต่อหน่วย</th>
                                                <th>จำนวน</th>
                                                <th>ราคารวม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $totalAll = 0; @endphp
                                            @foreach ($order->orderDetails as $detail)
                                                @php $totalAll += $detail->total_price; @endphp
                                                <tr>
                                                    <td>{{ $detail->product->id ?? '-' }}</td>
                                                    <td>{{ $detail->product->productItem->item_name ?? '-' }}</td>
                                                    <td>{{ number_format($detail->unit_price, 2) }} ฿</td>
                                                    <td>{{ $detail->quantity }}</td>
                                                    <td>{{ number_format($detail->total_price, 2) }} ฿</td>
                                                </tr>
                                            @endforeach

                                            <!-- สรุปราคา -->
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>ราคารวมทั้งหมด</strong>
                                                </td>
                                                <td><strong>{{ number_format($totalAll, 2) }} ฿</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>ราคารวมทั้งหมดหลังรวม VAT
                                                        (7%)</strong></td>
                                                <td><strong>{{ number_format($totalAll * 1.07, 2) }} ฿</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach

                        <script>
                            printWindow.document.write('<link rel="stylesheet" href="{{ asset('css/app.css') }}">');
                            printWindow.document.write(
                                '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');

                            function printOrder(orderId) {
                                const orderBox = document.querySelector('.order-box input[value="' + orderId + '"]').closest('.order-box');
                                const printWindow = window.open('', '', 'width=800,height=600');
                                printWindow.document.write('<html><head><title>ใบสั่งซื้อ</title>');
                                printWindow.document.write('<link rel="stylesheet" href="{{ asset('css/app.css') }}">');
                                printWindow.document.write('</head><body>');
                                printWindow.document.write(orderBox.outerHTML);
                                printWindow.document.write('</body></html>');
                                printWindow.document.close();
                                printWindow.focus();
                                printWindow.print();
                            }

                            function printSelectedOrders() {
                                const selectedOrders = document.querySelectorAll('.print-checkbox:checked');
                                if (selectedOrders.length === 0) {
                                    alert('กรุณาเลือกออเดอร์ก่อนพิมพ์');
                                    return;
                                }

                                let printContent = '';
                                selectedOrders.forEach(cb => {
                                    const orderBox = cb.closest('.order-box');
                                    printContent += orderBox.outerHTML;
                                });

                                const printWindow = window.open('', '', 'width=800,height=600');
                                printWindow.document.write('<html><head><title>ใบสั่งซื้อ</title>');
                                printWindow.document.write('<link rel="stylesheet" href="{{ asset('css/app.css') }}">');
                                printWindow.document.write(
                                    '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">'
                                    );
                                printWindow.document.write('<style>.order-box{page-break-after: always;}</style>');
                                printWindow.document.write('</head><body>');
                                printWindow.document.write(printContent);
                                printWindow.document.write('</body></html>');
                                printWindow.document.close();
                                printWindow.focus();
                                printWindow.print();
                            }

                            function toggleSelectAll() {
                                const checkboxes = document.querySelectorAll('.print-checkbox');
                                const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                                checkboxes.forEach(cb => cb.checked = !allChecked);
                            }
                        </script>

                    @endif

                </div>
            </div>
</body>

</html>
