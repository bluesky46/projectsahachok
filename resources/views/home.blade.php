<!DOCTYPE html>
<html lang="en" dir="ltr">

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

    <title>หน้าหลัก</title>
    <style>
        .content {
            overflow: auto;
            max-height: 80vh;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            overflow: auto;
            max-height: 60vh;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            width: 200px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }

        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }

        .quantity-control {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        .quantity-control button {
            padding: 5px 10px;
            margin: 0 5px;
            cursor: pointer;
        }

        .confirm-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }

        .total-price {
            font-weight: bold;
            margin-top: 10px;
        }

        .search-filter input {
            flex: 1;
        }

        .product-card p {
            font-size: 14px;
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
            /* ให้เท่ากับความกว้าง sidebar */
            padding: 20px;
            max-width: 100%;
            overflow-x: hidden;
            box-sizing: border-box;
        }



        .card {
            border-radius: 1rem;
        }

        .qty-input {
            border-radius: 0.5rem;
            border: 1px solid #0d6efd;
        }

        .card .total-price {
            font-weight: bold;
        }

        #categoryButtons button {
            transition: all 0.2s ease;
            border-radius: 1rem;
        }

        #categoryButtons button.active {
            transform: translateY(-3px);
            background-color: #0d6efd;
            color: white;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        }

        #categoryButtons button:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
@extends('layouts.sidebar')


<div class="col py-3 main-content">
    {{-- <h2>รายการสินค้า</h2>
            <div class="search-filter d-flex align-items-center gap-3 mb-4">
                <input type="text" id="searchInput" class="form-control" placeholder="ค้นหาสินค้า..."
                    onkeyup="filterProducts()">
            </div> --}}


    {{-- <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('cart') }}" class="btn btn-warning">
                    <i class="bi bi-cart3"></i> ตะกร้าสินค้า
                    <span class="badge bg-danger" id="cartCount">{{ count($cart ?? []) }}</span>
                </a>
            </div> --}}

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">POS</h2>
        <a href="{{ route('cart') }}" class="btn btn-warning">
            <i class="bi bi-cart3"></i> ตะกร้าสินค้า
            <span class="badge bg-danger" id="cartCount">{{ count($cart ?? []) }}</span>
        </a>
    </div>

    <div class="search-filter d-flex align-items-center gap-3 mb-4">
        <input type="text" id="searchInput" class="form-control" placeholder="ค้นหาสินค้า...">
    </div>

    {{-- ฟอร์มค้นหา --}}
    {{-- <form method="GET" action="{{ route('home') }}" class="mb-4">
                <div class="input-group shadow-sm mb-4">
                    <input type="text" id="searchInput" class="form-control" placeholder="ค้นหาสินค้า">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>
            </form>
            <script>

                document.getElementById('searchInput').value.toLowerCase(); // คำค้นหา

                document.querySelectorAll('.product-card').forEach(card => {
                    const name = card.dataset.name; // ชื่อสินค้าใน data-name
                    // ตรวจสอบว่าชื่อสินค้าตรงกับคำค้นหาไหม
                    const matchesName = name.includes(searchTerm);

                    // แสดงหรือซ่อน card
                    card.style.display = matchesName ? 'block' : 'none';
                });

            // เรียกใช้งานเมื่อพิมพ์
            document.getElementById('searchInput').addEventListener('input', filterProducts);
            </script> --}}

    {{-- ปุ่ม filter หมวดหมู่ --}}
    {{-- @php
                dd($categories);
            @endphp --}}

    <form action="{{ route('home') }}" method="GET" id="filterForm" class="row g-2">
        <div class="col-auto">
            {{-- <div class="d-flex flex-wrap gap-2 mb-4" id="categoryButtons">
                        <button type="button" class="btn btn-outline-primary active" data-id="">ทั้งหมด</button>
                        @isset($categories)
                            @foreach ($categories as $cat)
                                <button type="button" class="btn btn-outline-primary"
                                    data-id="{{ $cat->id }}">{{ $cat->name }}</button>
                            @endforeach
                        @endisset
                    </div> --}}
            <div class="d-flex flex-wrap gap-2 mb-4" id="categoryButtons">
                <button type="button"
                    class="btn btn-outline-primary {{ request('category_id') == '' ? 'active' : '' }}"
                    data-id="">ทั้งหมด</button>

                @foreach ($categories as $cat)
                    <button type="button"
                        class="btn btn-outline-primary {{ request('category_id') == $cat->id ? 'active' : '' }}"
                        data-id="{{ $cat->id }}">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>
            <!-- hidden input เพื่อส่งค่า category_id -->
            <input type="hidden" name="category_id" id="categoryInput">
        </div>
    </form>

    <div class="row g-3">
        @foreach ($products as $product)
            @php
                $cartQty = $cart[$product->id]['qty'] ?? 0;
                $categoryName = strtolower($product->productItem->category ?? '');
            @endphp
            <div class="col-md-3 product-card" data-name="{{ strtolower($product->productItem->item_name ?? '') }}">
                <div class="card h-100 shadow-sm border border-primary rounded-3 p-2">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title text-center">
                            {{ $product->productItem->item_name ?? 'ไม่พบชื่อสินค้า' }}</h5>
                        <p class="text-center mb-2">ราคา: <span class="product-price"
                                data-retail="{{ $product->productItem->retail_price }}"
                                data-wholesale="{{ $product->productItem->wholesale_price }}">
                                {{ number_format($product->productItem->retail_price, 2) }} ฿
                            </span></p>
                        {{-- <p class="text-center mb-2">คงเหลือ: {{ $product->stock_quantity }} ชิ้น</p> --}}
                        <p class="text-center mb-2">คงเหลือ : {{ $product->stock_quantity }} ชิ้น</p>

                        <div class="d-flex justify-content-center align-items-center mb-2 gap-2">
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                onclick="changeQty(this,-1)">-</button>
                            <input type="number" min="0" value="{{ $cartQty }}"
                                class="form-control form-control-sm text-center qty-input border-primary rounded-2"style="width: 60px;"
                                data-id="{{ $product->id }}" data-name="{{ $product->productItem->item_name ?? '' }}"
                                data-price="{{ $product->productItem->retail_price ?? 0 }}">
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                onclick="changeQty(this,1)">+</button>
                        </div>
                        <p class="text-center mb-0">ราคารวม: <span class="total-price">0</span> ฿</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Toast Notification -->
    <div id="toastContainer" style="position: fixed; top: 20px; right: 20px; z-index: 2000;"></div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('#categoryButtons button');
        const categoryInput = document.getElementById('categoryInput');
        const filterForm = document.getElementById('filterForm');

        buttons.forEach(btn => {
            btn.addEventListener('click', function() {
                // ล้าง active เดิม
                buttons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // เก็บค่า id ของหมวดหมู่
                categoryInput.value = this.dataset.id;

                // ✅ ส่งฟอร์มอัตโนมัติเมื่อคลิกหมวดหมู่
                filterForm.submit();
            });
        });
    });


    //เก่าล่าสุดก่อน document.addEventListener('DOMContentLoaded', function()
    // document.addEventListener('DOMContentLoaded', function() {
    //     const categoryButtons = document.querySelectorAll('#categoryButtons button');
    //     const searchInput = document.getElementById('searchInput');
    //     const cards = document.querySelectorAll('.product-card');
    //     let selectedCategory = '';

    //     function filterProducts() {
    //         const searchTerm = searchInput.value.toLowerCase();
    //         cards.forEach(card => {
    //             const name = card.dataset.name.toLowerCase();
    //             const category = card.dataset.category.toLowerCase();
    //             const matchName = name.includes(searchTerm);
    //             const matchCategory = !selectedCategory || category === selectedCategory;
    //             card.style.display = (matchName && matchCategory) ? '' : 'none';
    //         });
    //     }

    //     categoryButtons.forEach(btn => {
    //         btn.addEventListener('click', function() {
    //             categoryButtons.forEach(b => b.classList.remove('active'));
    //             this.classList.add('active');
    //             selectedCategory = this.dataset.category.toLowerCase();
    //             filterProducts();
    //         });
    //     });

    //     searchInput.addEventListener('input', filterProducts);
    // });


    function changeQty(btn, delta) {
        const input = btn.closest('.d-flex').querySelector('.qty-input');
        let value = parseInt(input.value) || 0;
        value += delta;
        if (value < 0) value = 0;
        input.value = value;
        const card = btn.closest('.card');
        updatePrice(card);
        updateSelectedList(card);
    }

    function updatePrice(card) {
        const input = card.querySelector('.qty-input');
        let qty = Math.max(0, parseInt(input.value) || 0); //  กัน NaN และค่าติดลบ
        input.value = qty;

        const priceElem = card.querySelector('.product-price');
        const retail = parseFloat(priceElem.dataset.retail) || 0;
        const wholesale = parseFloat(priceElem.dataset.wholesale) || 0;


        let price = qty >= 50 ? wholesale : retail;


        priceElem.textContent = price.toLocaleString(undefined, {
            minimumFractionDigits: 2
        }) + ' ฿';


        const totalElem = card.querySelector('.total-price');
        totalElem.textContent = (qty * price).toLocaleString(undefined, {
            minimumFractionDigits: 2
        });
    }

    function updateSelectedList(card) {
        const input = card.querySelector('.qty-input');
        let qty = Math.max(0, parseInt(input.value) || 0); // กัน NaN และค่าติดลบ
        input.value = qty;

        const priceElem = card.querySelector('.product-price');
        const price = parseFloat(priceElem.textContent.replace(/,/g, '').replace(' ฿', '')) || 0;

        const id = input.dataset.id;
        const name = input.dataset.name;

        fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: id,
                    name: name,
                    qty: qty,
                    price: price, // ✅ เพิ่ม
                    price_type: 'ปลีก' // ✅ เพิ่ม (default หน้า home)
                })
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('cartCount').textContent = data.cart_count;
                input.value = data.current_qty ?? qty;
                if (qty > 0) {
                    showToast(`${name} ถูกเพิ่ม/อัปเดตในตะกร้า`);
                } else {
                    showToast(`${name} ถูกลบออกจากตะกร้า`);
                }
            });
    }


    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('input', function() {
            const card = input.closest('.card');
            updatePrice(card);
            updateSelectedList(card);
        });
    });
    window.changeQty = changeQty;


    function showToast(message) {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = 'toast align-items-center text-bg-success border-0 show';
        toast.style.minWidth = '200px';
        toast.style.marginTop = '10px';
        toast.innerHTML = `<div class="d-flex"><div class="toast-body">${message}</div></div>`;
        container.appendChild(toast);
        setTimeout(() => {
            toast.remove();
        }, 2000);
    }

    function filterProducts() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase(); // คำค้นหา

        document.querySelectorAll('.product-card').forEach(card => {
            const name = card.dataset.name; // ชื่อสินค้าใน data-name
            // ตรวจสอบว่าชื่อสินค้าตรงกับคำค้นหาไหม
            const matchesName = name.includes(searchTerm);

            // แสดงหรือซ่อน card
            card.style.display = matchesName ? 'block' : 'none';
        });
    }
    // เรียกใช้งานเมื่อพิมพ์
    document.getElementById('searchInput').addEventListener('input', filterProducts);
</script>



</body>

</html>
