<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>ข้อมูลลูกค้า</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            height: 100vh;
            background-color: #343a40;
            padding-top: 1rem;
        }

        .sidebar a {
            display: block;
            color: #fff;
            padding: 12px 20px;
            text-decoration: none;
        }

        /* Form control with blue border */
        .form-control {
            border: 1px solid #0d6efd !important;
            /* Bootstrap primary blue */
        }

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

        .customers-row {
            display: grid !important;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
            justify-content: start;
        }

        .customers-row .customer-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }



        .customer-card .card-body.view-mode,
        .customer-card .card-body.edit-mode {
            flex-grow: 1;
        }

        .customer-card .card-footer {
            margin-top: auto;
        }

        .customer-card .card-body.edit-mode {
            display: none;
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
        </div>
    </div>



    <div class="col py-3">
        <div class="main-content">
            <div class="container-fluid py-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0">ข้อมูลลูกค้า</h2>
                    <button class="btn btn-success" onclick="toggleAddForm()" type="button">
                        + เพิ่มข้อมูลลูกค้า
                    </button>
                </div>
                <!-- ช่องค้นหา -->
                <div class="search-filter mb-3">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="ค้นหาด้วยชื่อ หรือ รหัสลูกค้า" onkeyup="filterCustomers()" />
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                </div>

                <!-- ฟอร์มเพิ่มลูกค้า -->
                <div id="addCustomerForm" class="card p-4 shadow-sm mb-4" style="display: none;">
                    <form action="{{ route('customer.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">รหัสลูกค้า :</label>
                                <input type="text" class="form-control" value="{{ $newCustomerId }}" readonly />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">ชื่อลูกค้า :</label>
                                <input type="text" name="name" class="form-control" required />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">ประเภทลูกค้า :</label>
                                <select name="type" class="form-control" required>
                                    <option value="">-- เลือกประเภทลูกค้า --</option>
                                    <option value="ทั่วไป">ทั่วไป</option>
                                    <option value="ร้านค้า">ร้านค้า</option>
                                    <option value="ช่าง">ช่าง</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">เบอร์โทร :</label>
                                <input type="text" name="phone" class="form-control" required />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">ผู้ติดต่อ (ถ้ามี) :</label>
                                <input type="text" name="contact_person" class="form-control" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">ที่อยู่</label>
                                <div class="row g-2">
                                    <div class="col-md-2">
                                        <input type="text" name="address_number" placeholder="เลขที่"
                                            class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="address_building" placeholder="บ้าน/อาคาร"
                                            class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="address_street" placeholder="ถนน"
                                            class="form-control" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="address_subdistrict" placeholder="ตำบล"
                                            class="form-control" />
                                    </div>

                                    <div class="col-md-3 mt-2">
                                        <input type="text" name="address_district" placeholder="อำเภอ"
                                            class="form-control" />
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <input type="text" name="address_province" placeholder="จังหวัด"
                                            class="form-control" />
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <input type="text" name="postal_code" placeholder="รหัสไปรษณีย์"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">บันทึกข้อมูลลูกค้า</button>
                    </form>
                </div>


                <!-- รายการลูกค้า -->
                {{-- <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4"> --}}
                <div class="row customers-row">
                    @foreach ($customers as $customer)
                        <div class="col">
                            <div class="card customer-card shadow-sm h-100">
                                <div class="card-body view-mode">
                                    <h5 class="card-title">{{ $customer->name }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">รหัสลูกค้า: {{ $customer->customer_id }}
                                    </h6>
                                    <p class="mb-1"><strong>ประเภทลูกค้า:</strong> {{ $customer->type }}</p>
                                    <p class="mb-1"><strong>เบอร์โทร:</strong> {{ $customer->phone }}</p>
                                    <p class="mb-1"><strong>ผู้ติดต่อ:</strong>
                                        {{ $customer->contact_person ?? '-' }}</p>
                                    <p class="mb-1">
                                        <strong>ที่อยู่:</strong><br />
                                        เลขที่ {{ $customer->address_number ?? '-' }},
                                        บ้าน/อาคาร {{ $customer->address_building ?? '-' }},<br />
                                        ถนน {{ $customer->address_street ?? '-' }},
                                        ตำบล {{ $customer->address_subdistrict ?? '-' }},<br />
                                        อำเภอ {{ $customer->address_district ?? '-' }},
                                        จังหวัด {{ $customer->address_province ?? '-' }},<br />
                                        รหัสไปรษณีย์ {{ $customer->postal_code ?? '-' }}
                                    </p>
                                </div>

                                <div class="card-body edit-mode">
                                    <form action="{{ route('customer.update', $customer->id) }}" method="POST"
                                        class="edit-form">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-2">
                                            <label class="form-label">รหัสลูกค้า</label>
                                            <input type="text" name="customer_id" class="form-control"
                                                value="{{ $customer->customer_id }}" required />
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">ชื่อลูกค้า</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $customer->name }}" required />
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">ประเภทลูกค้า</label>
                                            <select name="type" class="form-control" required>
                                                <option value="ทั่วไป"
                                                    {{ $customer->type == 'ทั่วไป' ? 'selected' : '' }}>ทั่วไป</option>
                                                <option value="ร้านค้า"
                                                    {{ $customer->type == 'ร้านค้า' ? 'selected' : '' }}>ร้านค้า
                                                </option>
                                                <option value="ช่าง"
                                                    {{ $customer->type == 'ช่าง' ? 'selected' : '' }}>ช่าง</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">เบอร์โทร</label>
                                            <input type="text" name="phone" class="form-control"
                                                value="{{ $customer->phone }}" required />
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">ผู้ติดต่อ (ถ้ามี)</label>
                                            <input type="text" name="contact_person" class="form-control"
                                                value="{{ $customer->contact_person }}" />
                                        </div>

                                        <label class="form-label">ที่อยู่</label>
                                        <div class="row g-2 mb-3">
                                            <div class="col-md-2">
                                                <label class="form-label small">เลขที่</label>
                                                <input type="text" name="address_number" placeholder="เลขที่"
                                                    class="form-control" value="{{ $customer->address_number }}" />
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small">บ้าน/อาคาร</label>
                                                <input type="text" name="address_building"
                                                    placeholder="บ้าน/อาคาร" class="form-control"
                                                    value="{{ $customer->address_building }}" />
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small">ถนน</label>
                                                <input type="text" name="address_street" placeholder="ถนน"
                                                    class="form-control" value="{{ $customer->address_street }}" />
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label small">ตำบล</label>
                                                <input type="text" name="address_subdistrict" placeholder="ตำบล"
                                                    class="form-control"
                                                    value="{{ $customer->address_subdistrict }}" />
                                            </div>

                                            <div class="col-md-3 mt-2">
                                                <label class="form-label small">อำเภอ</label>
                                                <input type="text" name="address_district" placeholder="อำเภอ"
                                                    class="form-control" value="{{ $customer->address_district }}" />
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <label class="form-label small">จังหวัด</label>
                                                <input type="text" name="address_province" placeholder="จังหวัด"
                                                    class="form-control" value="{{ $customer->address_province }}" />
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <label class="form-label small">รหัสไปรษณีย์</label>
                                                <input type="text" name="postal_code" placeholder="รหัสไปรษณีย์"
                                                    class="form-control" value="{{ $customer->postal_code }}" />
                                            </div>
                                        </div>


                                        <button type="submit" class="btn btn-primary btn-sm">บันทึก</button>
                                        <button type="button"
                                            class="btn btn-secondary btn-sm btn-cancel-edit">ยกเลิก</button>
                                    </form>
                                </div>


                                <div class="card-footer d-grid gap-2"
                                    style="grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));">
                                    <button class="btn btn-outline-primary btn-sm btn-edit">แก้ไข</button>

                                    <form action="{{ route('customer.destroy', $customer->id) }}" method="POST"
                                        onsubmit="return confirm('ยืนยันการลบลูกค้า {{ $customer->name }} ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">ลบ</button>
                                    </form>
                                    {{-- <a href="{{ route('customer.orders', ['phone' => $customer->phone]) }}" class="btn btn-outline-info btn-sm">
                                        ดูข้อมูลการซื้อ
                                    </a> --}}
                                </div>

                            </div>
                        </div>
                    @endforeach
                    <script>
                        document.querySelectorAll('.btn-edit').forEach(button => {
                            button.addEventListener('click', () => {
                                const card = button.closest('.customer-card');
                                card.querySelector('.view-mode').style.display = 'none';
                                card.querySelector('.edit-mode').style.display = 'block';
                            });
                        });

                        document.querySelectorAll('.btn-cancel-edit').forEach(button => {
                            button.addEventListener('click', () => {
                                const card = button.closest('.customer-card');
                                card.querySelector('.edit-mode').style.display = 'none';
                                card.querySelector('.view-mode').style.display = 'block';
                            });
                        });


                        function filterCustomers() {
                            const input = document.getElementById("searchInput").value.toLowerCase();
                            const cards = document.querySelectorAll(".customer-card");

                            cards.forEach(card => {
                                // ดึงชื่อและรหัสลูกค้า จาก element ภายใน card
                                const name = card.querySelector('.card-title').textContent.toLowerCase();
                                const customerId = card.querySelector('.card-subtitle').textContent.toLowerCase();

                                // เช็คว่ามีคำค้นในชื่อหรือรหัสลูกค้าหรือไม่
                                if (name.includes(input) || customerId.includes(input)) {
                                    card.style.display = ""; // แสดงการ์ด
                                } else {
                                    card.style.display = "none"; // ซ่อนการ์ด
                                }
                            });
                        }
                        // Toggle form show/hide
                        function toggleAddForm() {
                            const form = document.getElementById("addCustomerForm");
                            form.style.display =
                                form.style.display === "none" || form.style.display === "" ? "block" : "none";
                        }

                        // Filter customers by name or id
                        // function filterCustomers() {
                        //     const input = document.getElementById("searchInput").value.toLowerCase();
                        //     const items = document.querySelectorAll(".customer-card");

                        //     items.forEach((item) => {
                        //         const name = item.getAttribute("data-name");
                        //         const id = item.getAttribute("data-id");
                        //         if (name.includes(input) || id.includes(input)) {
                        //             item.style.display = "";
                        //         } else {
                        //             item.style.display = "none";
                        //         }
                        //     });
                        // }
                    </script>

                </div>
            </div>
        </div>
    </div>

</body>

</html>
