<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <title>การจัดการประเภทสินค้า</title>
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
                {{-- <h3 class="mb-3">จัดการประเภทสินค้า</h3> --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-primary">จัดการประเภทสินค้า</h2>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <form id="categoryForm" action="{{ route('product-items.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="category_id" class="form-label">หมวดหมู่</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="">เลือกหรือพิมพ์หมวดหมู่</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="brand_id" class="form-label">แบรนด์</label>
                                <select name="brand_id" id="brand_id" class="form-control" required>
                                    <option value="">เลือกหรือพิมพ์แบรนด์</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="supplier_id" class="form-label">ผู้จัดหา</label>
                                <select name="supplier_id" id="supplier_id" class="form-control">
                                    <option value="">เลือกหรือพิมพ์ผู้จัดหา</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="item_code" class="form-label">รหัสสินค้า</label>
                                    <input type="text" name="item_code" id="item_code" class="form-control"
                                        value="{{ $itemCode }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="item_name" class="form-label">ชื่อสินค้า</label>
                                    <input type="text" name="item_name" id="item_name" class="form-control"
                                        placeholder="ชื่อสินค้า" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="cost_price" class="form-label">ราคาทุน</label>
                                    <input type="number" name="cost_price" id="cost_price" class="form-control"
                                        placeholder="ราคาทุน" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="retail_price" class="form-label">ราคาปลีก</label>
                                    <input type="number" name="retail_price" id="retail_price" class="form-control"
                                        placeholder="ราคาปลีก">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="wholesale_price" class="form-label">ราคาส่ง</label>
                                    <input type="number" name="wholesale_price" id="wholesale_price"
                                        class="form-control" placeholder="ราคาส่ง">
                                </div>
                            </div>

                            <div class="row">
                                {{-- <div class="col-md-6 mb-3">
                                    <label for="stock_unit" class="form-label">หน่วย</label>
                                    <input type="text" name="stock_unit" id="stock_unit" class="form-control"
                                        placeholder="หน่วย" required>
                                </div> --}}
                                <div class="col-md-6 mb-3">
                                    <label for="unit_id" class="form-label">หน่วย</label>

                                    <div class="input-group">

                                        <select name="unit_id" id="unit_id" class="form-select" required>

                                            <option value="">เลือกหน่วย</option>

                                            @foreach($units as $unit)
                                                <option value="{{ $unit->id }}">
                                                    {{ $unit->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                        <button class="btn btn-success"
                                                type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#unitModal">

                                            <i class="bi bi-plus-lg"></i>

                                        </button>

                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="min_stock" class="form-label">สต็อกขั้นต่ำ</label>
                                    <input type="number" name="min_stock" id="min_stock" class="form-control"
                                        placeholder="สต็อกขั้นต่ำ">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>จำนวนเริ่มต้น</label>
                                    <input type="number" name="stock_quantity" id="stock_quantity"
                                        class="form-control" required placeholder="จำนวนรับเข้าครั้งแรก">

                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">บันทึก</button>

                        </form>
                    </div>
                </div>
                <!-- พื้นที่แสดงสินค้าแบบเรียงเป็น list ระเบียบ -->
                <!-- Header -->
                <div class="row fw-bold mb-2 py-2 border-bottom">
                    <div class="col-3">ชื่อสินค้า</div>
                    <div class="col-1">รหัส</div>
                    <div class="col-2">Category</div>
                    <div class="col-2">Brand</div>
                    <div class="col-2">Supplier</div>
                    <div class="col-1">ราคาปลีก</div>
                    <div class="col-1"></div> <!-- ช่องปุ่ม -->
                </div>

                <!-- รายการสินค้า -->
                <div id="productCards">
                    @foreach ($products ?? [] as $product)
                        <div class="row align-items-center py-2 border-bottom" id="product-card-{{ $product->id }}">
                            <div class="col-3">{{ $product->item_name }}</div>
                            <div class="col-1">{{ $product->item_code }}</div>
                            <div class="col-2">{{ $product->category->name ?? '-' }}</div>
                            <div class="col-2">{{ $product->brand->name ?? '-' }}</div>
                            <div class="col-2">{{ $product->supplier->name ?? '-' }}</div>
                            <div class="col-1">{{ number_format($product->retail_price, 2) }}</div>
                            <div class="col-1 d-flex gap-1">
                                {{-- <button class="btn btn-sm btn-warning editProductBtn"data-id="{{ $product->id }}">แก้ไข</button>
                                <button class="btn btn-sm btn-danger deleteProductBtn"data-id="{{ $product->id }}">ลบ</button> --}}
                                <button type="button" class="btn btn-sm btn-warning editProductBtn"
                                    data-id="{{ $product->id }}">แก้ไข</button>
                                <button type="button" class="btn btn-sm btn-danger deleteProductBtn"
                                    data-id="{{ $product->id }}">ลบ</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- <!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
    <div id="saveToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                บันทึกสินค้าสำเร็จ!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div> --}}


                <!-- Toast Container -->
                <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
                    <div id="saveToast" class="toast align-items-center text-white bg-success border-0"
                        role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                บันทึกสินค้าสำเร็จ!
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>





            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    const form = document.getElementById('categoryForm');

                    const categorySelect = new TomSelect("#category_id", {
                        create: true
                    });
                    const brandSelect = new TomSelect("#brand_id", {
                        create: true
                    });
                    const supplierSelect = new TomSelect("#supplier_id", {
                        create: true
                    });

                    new TomSelect("#stock_unit", {
                        create: true
                    });



                    /* -----------------------------
                    CATEGORY → BRAND
                    ----------------------------- */
                    /* CATEGORY → BRAND */

                    categorySelect.on('change', function(value) {

                        brandSelect.clear();
                        brandSelect.clearOptions();

                        supplierSelect.clear();
                        supplierSelect.clearOptions();

                        if (!value) return;

                        fetch(`/brands-by-category/${value}`)
                            .then(res => res.json())
                            .then(data => {

                                data.forEach(brand => {

                                    brandSelect.addOption({
                                        value: brand.id,
                                        text: brand.name
                                    });

                                });

                                brandSelect.refreshOptions();

                            });

                    });


                    /* -----------------------------
                    BRAND → SUPPLIER
                    ----------------------------- */
                    // brandSelect.on('change', function(value) {

                    //     supplierSelect.clear();
                    //     supplierSelect.clearOptions();

                    //     if (!value) return;

                    //     fetch(`/suppliers-by-brand/${value}`)
                    //         .then(res => res.json())
                    //         .then(data => {

                    //             data.forEach(supplier => {

                    //                 supplierSelect.addOption({
                    //                     value: supplier.id,
                    //                     text: supplier.name
                    //                 });

                    //             });

                    //             supplierSelect.refreshOptions();

                    //         });

                    // });
                    brandSelect.on('change', function(value) {

                        supplierSelect.clear();
                        supplierSelect.clearOptions();

                        if (!value) return;

                        let category_id = categorySelect.getValue(); // 🔥 เอา category มาด้วย

                        fetch(`/suppliers-by-brand?brand_id=${value}&category_id=${category_id}`)
                            .then(res => res.json())
                            .then(data => {

                                data.forEach(supplier => {
                                    supplierSelect.addOption({
                                        value: supplier.id,
                                        text: supplier.name
                                    });
                                });

                                supplierSelect.refreshOptions();
                            });

                    });

                    // Event delegation สำหรับ Edit/Delete
                    document.getElementById('productCards').addEventListener('click', function(e) {
                        const target = e.target;

                        // ลบสินค้า
                        if (target.classList.contains('deleteProductBtn')) {
                            if (!confirm('คุณแน่ใจหรือไม่ว่าต้องการลบสินค้า?')) return;
                            let id = target.dataset.id;
                            fetch(`/product-items/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        document.getElementById(`product-card-${id}`).remove();
                                        showToast('ลบสินค้าสำเร็จ!', 'bg-danger');
                                    } else alert(data.message);
                                }).catch(err => console.error(err));
                        }

                        // แก้ไขสินค้า
                        if (target.classList.contains('editProductBtn')) {
                            let id = target.dataset.id;
                            fetch(`/product-items/${id}`)
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        const p = data.product;
                                        document.getElementById('item_name').value = p.item_name;
                                        document.getElementById('item_code').value = p.item_code;
                                        document.getElementById('cost_price').value = p.cost_price;
                                        document.getElementById('retail_price').value = p.retail_price;
                                        document.getElementById('wholesale_price').value = p.wholesale_price;
                                        document.getElementById('stock_unit').value = p.stock_unit;
                                        document.getElementById('min_stock').value = p.min_stock;

                                        categorySelect.setValue([p.category_id]);
                                        brandSelect.setValue([p.brand_id]);
                                        if (p.supplier_id) supplierSelect.setValue([p.supplier_id]);
                                        else supplierSelect.clear(true);

                                        form.action = `/product-items/${id}`;
                                        form.dataset.method = 'PUT';
                                    }
                                }).catch(err => console.error(err));
                        }
                    });


                    function showToast(msg, color = 'bg-success') {
                        const toastEl = document.getElementById('saveToast');
                        toastEl.classList.remove('bg-success', 'bg-danger');
                        toastEl.classList.add(color);
                        toastEl.querySelector('.toast-body').innerText = msg;
                        const toast = new bootstrap.Toast(toastEl);
                        toast.show();
                    }


                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        let formData = new FormData(form);
                        let method = form.dataset.method || 'POST';
                        if (method === 'PUT') formData.append('_method', 'PUT');

                        fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    showToast(data.message);
                                    form.reset();
                                    categorySelect.clear();
                                    brandSelect.clear();
                                    supplierSelect.clear();
                                    form.action = "{{ route('product-items.store') }}";
                                    form.removeAttribute('data-method');
                                    setTimeout(() => {
                                        window.location.href = "{{ route('home') }}";
                                    }, 800);
                                } else alert(data.message || 'เกิดข้อผิดพลาด');
                            }).catch(err => console.error(err));
                    });
                });
            </script>
            <div class="modal fade" id="unitModal" tabindex="-1">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header bg-success text-white">

                            <h5 class="modal-title">

                                เพิ่มหน่วย

                            </h5>

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                            </button>

                        </div>

                        <div class="modal-body">

                            <div class="mb-3">

                                <label>ชื่อหน่วย</label>

                                <input
                                    type="text"
                                    id="unit_name"
                                    class="form-control"
                                    placeholder="เช่น เมตร">

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">

                                ยกเลิก

                            </button>

                            <button
                                type="button"
                                class="btn btn-success"
                                id="saveUnit">

                                บันทึก

                            </button>

                        </div>

                    </div>

                </div>

            </div>
            <script>

                document.getElementById('saveUnit').addEventListener('click',function(){

                    fetch("{{ route('units.store') }}",{

                        method:'POST',

                        headers:{
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}'
                        },

                        body:JSON.stringify({

                            name:document.getElementById('unit_name').value

                        })

                    })

                    .then(res=>res.json())

                    .then(unit=>{

                        let select=document.getElementById('unit_id');

                        let option=new Option(unit.name,unit.id,true,true);

                        select.add(option);

                        document.getElementById('unit_name').value='';

                        bootstrap.Modal.getInstance(document.getElementById('unitModal')).hide();

                    });

                });

                </script>

</body>

</html>
