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
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>


    <title>รายการสินค้า</title>
    <style>
        .product-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-size: 14px;
        }

        .product-item p {
            margin: 0;
            padding: 5px;
            display: inline-block;
        }

        .product-item .actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 6px 12px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-edit {
            background-color: #4CAF50;
            color: white;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .edit-form {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #ddd;
            display: none;
        }

        body {
            overflow-x: hidden;
        }

        /* .content {
            max-width: 100%;
            overflow-x: hidden;
        } */

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
    </style>
</head>

<body>
    {{-- <div class="container-fluid">
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
                            <a href="{{ route('products.list') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-box-seam"></i> <span class="ms-1 d-none d-sm-inline">รายการสินค้า</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('products.add') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-box-seam"></i> <span
                                    class="ms-1 d-none d-sm-inline">จัดการประเภทสินค้า</span>
                            </a>
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

            <div class="col py-3">
                <div class="main-content">

                    <script>
                        function toggleAddForm() {
                            const form = document.getElementById("addProductForm");
                            form.style.display = form.style.display === "none" || form.style.display === "" ? "block" : "none";
                        }
                    </script>
                    <style>
                        .form-control {
                            border: 1px solid #0d6efd !important;

                        }
                    </style>




                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold text-primary">เลือกสินค้าที่ต้องการขาย</h2>

                        <button type="button" class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="bi bi-box-arrow-in-down me-1"></i> เพิ่มรายการสินค้า
                        </button>
                    </div>


<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">นำเข้าสินค้าเข้าหน้าขาย</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3 d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="selectAllProducts()">เลือกทั้งหมด</button>
                    <button class="btn btn-outline-danger" onclick="unselectAllProducts()">ยกเลิก</button>
                </div>

                <div id="all-products-list" class="row g-2">

                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="importSelectedProducts()">
                    นำเข้าสินค้า
                </button>
            </div>

        </div>
    </div>
</div>

                    <div class="search-filter d-flex align-items-center gap-3 mb-4">
                        <input type="text" id="searchInput" class="form-control" placeholder="ค้นหาสินค้า...">
                    </div>

                    <script>
                        function searchInput() {
                            const searchTerm = document.getElementById('searchInput').value.toLowerCase();

                            document.querySelectorAll('#selected-products-container .card').forEach(card => {
                                const name = card.dataset.name || '';
                                const matches = name.includes(searchTerm);
                                card.style.display = matches ? '' : 'none';
                            });
                        }


                        document.getElementById('searchInput').addEventListener('input', searchInput);


                        const importModal = document.getElementById('importModal');

importModal.addEventListener('shown.bs.modal', function () {

    const container = document.getElementById('all-products-list');
    container.innerHTML = '<div class="text-center p-4">กำลังโหลดสินค้า...</div>';

    fetch('/ajax/all-products')
    .then(res => res.json())
    .then(products => {

        container.innerHTML = '';

        if(products.length === 0){
            container.innerHTML = '<div class="text-center text-muted p-4">ยังไม่มีสินค้าในระบบ</div>';
            return;
        }

        products.forEach(p => {

            const div = document.createElement('div');
            div.className = 'col-md-4';

            div.innerHTML = `
            <div class="card shadow-sm h-100">
                <div class="card-body">

                    <div class="form-check">
                        <input class="form-check-input import-checkbox"
                               type="checkbox"
                               value="${p.id}"
                               id="product_${p.id}">

                        <label class="form-check-label w-100" for="product_${p.id}">
                            <strong>${p.item_name}</strong><br>
                            <small class="text-muted">
                                รหัส: ${p.item_code}<br>
                                หมวด: ${p.category?.name || '-'}<br>
                                ยี่ห้อ: ${p.brand?.name || '-'}<br>
                                คงเหลือ: ${p.stock_quantity ?? 0}
                            </small>
                        </label>
                    </div>

                </div>
            </div>
            `;

            container.appendChild(div);
        });

    })
    .catch(()=>{
        container.innerHTML = '<div class="text-danger text-center p-4">โหลดสินค้าไม่สำเร็จ (API error)</div>';
    });

});



function importSelectedProducts(){

let ids=[];
document.querySelectorAll('.import-checkbox:checked').forEach(c=>{
    ids.push(parseInt(c.value));
});

if(ids.length===0){
    Swal.fire('กรุณาเลือกสินค้า');
    return;
}

fetch("{{ route('products.importToPOS') }}",{
    method:'POST',
    headers:{
        'Content-Type':'application/json',
        'Accept':'application/json',
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
    },
    body:JSON.stringify({
        product_ids:ids
    })
})
.then(res=>res.json())
.then(res=>{
    if(res.success){
        Swal.fire('สำเร็จ','นำเข้าสินค้าเรียบร้อย','success')
        .then(()=> location.reload());
    }else{
        Swal.fire('ผิดพลาด',res.message,'error');
    }
});
}

function selectAllProducts(){
    document.querySelectorAll('.import-checkbox').forEach(cb=>{
        cb.checked = true;
    });
}

function unselectAllProducts(){
    document.querySelectorAll('.import-checkbox').forEach(cb=>{
        cb.checked = false;
    });
}
                    </script>




                    <div id="selected-products-list">
                        <h6>สินค้าที่พร้อมขาย:</h6>
                        <div id="selected-products-container" class="d-flex flex-column gap-2">
                            @forelse($readyProducts as $p)
                                <div class="card p-2 mb-2"
                                    data-name="{{ strtolower($p->productItem->item_name ?? '') }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $p->productItem->item_name ?? '-' }}</strong>
                                            รหัส: {{ $p->product_code }}<br>
                                            Category: {{ $p->productItem->category->name ?? '-' }} |
                                            Brand: {{ $p->productItem->brand->name ?? '-' }} |
                                            Supplier: {{ $p->productItem->supplier->name ?? '-' }}<br>
                                            ราคาปลีก: {{ number_format($p->productItem->retail_price ?? 0, 2) }} |
                                            จำนวน: {{ $p->stock_quantity }}
                                        </div>
                                        <form action="{{ route('products.removeFromPOS', $p->id) }}" method="POST"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">ลบ</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">ยังไม่มีสินค้าพร้อมขาย</p>
                            @endforelse


                        </div>
                    </div>

                </div>




                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        new TomSelect("#add_category", {
                            create: true,
                            sortField: {
                                field: "text",
                                direction: "asc"
                            }
                        });

                        new TomSelect("#add_brand", {
                            create: true,
                            sortField: {
                                field: "text",
                                direction: "asc"
                            }
                        });

                        new TomSelect("#add_supplier", {
                            create: true,
                            sortField: {
                                field: "text",
                                direction: "asc"
                            }
                        });

                        new TomSelect("#add_product", {
                            create: true,
                            sortField: {
                                field: "text",
                                direction: "asc"
                            }
                        });
                    });


                    function showAddProductForm() {
                        document.getElementById('addProductForm').style.display = 'block';
                    }



                    const categorySelect = document.getElementById('add_category');
                    const brandSelect = document.getElementById('add_brand');
                    const supplierSelect = document.getElementById('add_supplier');
                    const productSelect = document.getElementById('add_product');
                    const container = document.getElementById('selected-products-container');
                    const productDetails = document.getElementById('productDetails');



                    document.querySelectorAll('.delete-form').forEach(form => {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            Swal.fire({
                                title: 'คุณแน่ใจไหม?',
                                text: "คุณต้องการลบสินค้านี้ออกจากรายการ?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'ลบ',
                                cancelButtonText: 'ยกเลิก'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    form.submit();
                                }
                            });
                        });
                    });


                    categorySelect.addEventListener('change', function() {
                        let category = this.value;
                        brandSelect.tomselect.clearOptions();
                        supplierSelect.tomselect.clearOptions();
                        productSelect.tomselect.clearOptions();

                        if (!category) return;

                        fetch(`/ajax/brands/${category}`)
                            .then(res => res.json())
                            .then(data => {
                                data.forEach(b => {
                                    brandSelect.tomselect.addOption({
                                        value: b.id,
                                        text: b.name
                                    });
                                });
                                brandSelect.tomselect.refreshOptions();
                            });
                    });


                    brandSelect.addEventListener('change', function() {
                        let category = categorySelect.value;
                        let brand = this.value;
                        supplierSelect.tomselect.clearOptions();
                        productSelect.tomselect.clearOptions();

                        if (!brand) return;

                        fetch(`/ajax/suppliers?category_id=${category}&brand_id=${brand}`)
                            .then(res => res.json())
                            .then(data => {
                                data.forEach(s => {
                                    supplierSelect.tomselect.addOption({
                                        value: s.id,
                                        text: s.name
                                    });
                                });
                                supplierSelect.tomselect.refreshOptions();
                            });
                    });


                    supplierSelect.addEventListener('change', function() {
                        let category = categorySelect.value;
                        let brand = brandSelect.value;
                        let supplier = this.value;
                        productSelect.tomselect.clearOptions();

                        if (!supplier) return;

                        fetch(`/ajax/products?category_id=${category}&brand_id=${brand}&supplier_id=${supplier}`)
                            .then(res => res.json())
                            .then(data => {
                                data.forEach(p => {
                                    productSelect.tomselect.addOption({
                                        value: p.id,
                                        text: p.item_name,
                                        data: {
                                            code: p.item_code,
                                            categoryName: p.category?.name ?? '-',
                                            brandName: p.brand?.name ?? '-',
                                            supplierName: p.supplier?.name ?? '-',
                                            cost: p.cost_price ?? 0,
                                            retail: p.retail_price ?? 0,
                                            wholesale: p.wholesale_price ?? 0,
                                            unit: p.stock_unit ?? '-',
                                            stock: p.stock_quantity ?? 0
                                        }
                                    });
                                });
                                productSelect.tomselect.refreshOptions();
                            });
                    });

                    productSelect.addEventListener('change', function() {
                        const ts = productSelect.tomselect;
                        const value = ts.getValue();
                        if (!value) {
                            productDetails.innerHTML = '<em>กรุณาเลือก Category, Brand, Supplier และสินค้า</em>';
                            return;
                        }

                        const item = ts.options[value];
                        if (!item) return;

                        const data = item.data || {}; //

                        productDetails.innerHTML = `
        <strong>${item.text || '-'}</strong>
        <ul class="list-unstyled small text-secondary mt-2">
            <li>รหัส: ${data.code || '-'}</li>
            <li>Category: ${data.categoryName || '-'}</li>
            <li>Brand: ${data.brandName || '-'}</li>
            <li>Supplier: ${data.supplierName || '-'}</li>
            <li>ราคาทุน: ${data.cost != null ? data.cost : '-'}</li>
            <li>ราคาปลีก: ${data.retail != null ? data.retail : '-'}</li>
            <li>ราคาส่ง: ${data.wholesale != null ? data.wholesale : '-'}</li>
            <li>หน่วย: ${data.unit || '-'}</li>

        </ul>
    `;
                    });




                    function addProductToList() {
                        const selected = productSelect.options[productSelect.selectedIndex];
                        if (!selected.value) return Swal.fire('ผิดพลาด', 'กรุณาเลือกสินค้า', 'error');

                        fetch("{{ route('products.addProductToPOS') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    product_item_id: selected.value
                                })
                            })
                            .then(res => res.json())
                            .then(res => {
                                if (res.success) {
                                    Swal.fire('สำเร็จ', res.message, 'success');

                                    const p = res.product;

                                    const div = document.createElement('div');
                                    div.classList.add('card', 'p-2', 'mb-2');
                                    div.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>${p.name}</strong> (รหัส: ${p.code})<br>
                    Category: ${p.category} | Brand: ${p.brand} | Supplier: ${p.supplier}<br>
                    ราคาปลีก: ${p.retail} | จำนวน: ${p.stock}
                </div>
                <button type="button" class="btn btn-sm btn-danger">ลบ</button>
            </div>
        `;
                                    container.appendChild(div); --}}

                                    {{-- // รีเซ็ต select และรายละเอียด
                //                     productSelect.selectedIndex = 0;
                //                     productDetails.innerHTML = '<em>กรุณาเลือก Category, Brand, Supplier และสินค้า</em>';
                //                 } else {
                //                     Swal.fire('ผิดพลาด', res.message || 'เกิดข้อผิดพลาด', 'error');
                //                 }
                //             })

                //             .catch(err => Swal.fire('ผิดพลาด', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้', 'error'));
                //     } --}}
                 </script>






</body>

</html>
