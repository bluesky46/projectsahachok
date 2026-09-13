+
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
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>


    <title>ตะกร้าสินค้า</title>
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
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row flex-nowrap">
            {{-- <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark"> --}}
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

                                {{-- เช็คว่ามีสินค้าสต็อกต่ำกว่า 10 ไหม
                                @if ($products->where('min_stock', '<', 10)->count() > 0)
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
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col py-3 main-content">

                <!-- HEADER -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-primary">🛒 ตะกร้าสินค้า</h2>
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">+ เลือกสินค้า</a>
                </div>

                <!-- ROW หลัก -->
                <div class="row g-4">

                    <!-- LEFT: TABLE -->
                    <div class="col-lg-8">
                        <div class="card p-3">
                            @php $grandTotal = 0; @endphp

                            @if (count($cart ?? []) > 0)
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>สินค้า</th>
                                            <th>ราคา</th>
                                            <th>จำนวน</th>
                                            <th>ประเภทราคา</th>
                                            <th>รวม</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart as $id => $item)
                                            @php
                                                $total = $item['price'] * $item['qty'];
                                                $grandTotal += $total;
                                            @endphp
                                            <tr data-id="{{ $id }}"
                                                data-retail="{{ $item['retail_price'] }}"
                                                data-wholesale="{{ $item['wholesale_price'] }}">

                                                <td>{{ $item['name'] }}</td>

                                                <td>{{ number_format($item['price'], 2) }} ฿</td>

                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <button type="button" class="btn btn-outline-secondary qty-btn"
                                                            onclick="changeCartQty('{{ $id }}', -1)">-</button>

                                                        <input type="number"
                                                            class="form-control mx-2 text-center qty-cart"
                                                            style="width:60px" value="{{ $item['qty'] }}"
                                                            onchange="manualChangeQty('{{ $id }}', this)">

                                                        <button type="button"
                                                            class="btn btn-outline-secondary qty-btn"
                                                            onclick="changeCartQty('{{ $id }}', 1)">+</button>
                                                    </div>
                                                </td>
                                                <!-- ✅ ประเภทราคา -->
                                                <td class="price-type">
                                                    {{ $item['price_type'] ?? 'ปลีก' }}
                                                </td>

                                                <td class="total-price">
                                                    {{ number_format($total, 2) }} ฿
                                                </td>

                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="removeCartItem('{{ $id }}')">ลบ</button>
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-center">ไม่มีสินค้าในตะกร้า</p>
                            @endif

                        </div>
                    </div>

                    {{-- ================= RIGHT: SUMMARY ================= --}}
                    <div class="col-lg-4">
                        <div class="summary-box">

                            <h5 class="mb-3">💰 สรุปยอด</h5>

                            <div class="d-flex justify-content-between">
                                <span>Subtotal</span>
                                <span id="subtotal">{{ number_format($grandTotal, 2) }} ฿</span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span>VAT 7%</span>
                                <span id="vatAmount">{{ number_format($grandTotal * 0.07, 2) }} ฿</span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between total-highlight">
                                <span>Total</span>
                                <span id="grandTotalWithVat">
                                    {{ number_format($grandTotal * 1.07, 2) }} ฿
                                </span>
                            </div>

                            {{-- รับเงิน --}}
                            <div class="mt-3">
                                <label>รับเงิน</label>
                                <input type="number" id="amountReceived" class="form-control"
                                    placeholder="กรอกเงิน">
                            </div>

                            {{-- เงินทอน --}}
                            <div class="mt-2">
                                <label>เงินทอน</label>
                                <input class="form-control" id="changeAmount" disabled value="0.00 ฿">
                            </div>

                            {{-- เบอร์ลูกค้า --}}
                            <div class="mt-3">
                                <label>เบอร์ลูกค้า / ช่าง</label>
                                <div class="d-flex gap-2">
                                    {{-- <input type="text" id="customerPhone" class="form-control"> --}}
                                    <input type="text" id="customerPhone" name="customer_phone"
                                        class="form-control">
                                    <button type="button" class="btn btn-info"
                                        onclick="checkCustomerPhone()">ตรวจสอบ</button>
                                </div>
                            </div>


                            <form action="{{ route('cart.checkout') }}" method="POST"
                                onsubmit="prepareCustomerPhone()">

                                @csrf

                                <!-- ✅ ตัวส่งจริง -->
                                <input type="hidden" name="customer_phone" id="finalCustomerPhone">

                                <input type="checkbox" id="deliveryCheck" name="is_delivery" value="1" hidden>

                                <button type="button" class="btn btn-outline-primary w-100 mt-3"
                                    onclick="toggleDelivery()">
                                    + การจัดส่ง
                                </button>

                                <!-- SELECT -->
                                <div class="mt-3" id="phoneInputDiv" style="display:none;">
                                    <select id="customerSelect" class="form-control">
                                        <option value="">-- เลือกลูกค้า --</option>
                                        @foreach ($customers as $c)
                                            <option value="{{ $c->phone }}" data-name="{{ $c->name }}"
                                                data-type="{{ $c->type }}">
                                                {{ $c->name }} - {{ $c->phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="customerInfo" style="display:none;" class="border rounded p-2 mt-2">
                                    <p><strong>ชื่อ:</strong> <span id="custName"></span></p>
                                    <p><strong>ประเภท:</strong> <span id="custType"></span></p>
                                </div>

                                <button type="submit" class="btn btn-success w-100 mt-4">
                                    ยืนยันการสั่งซื้อ
                                </button>
                            </form>


                        </div>
                    </div>

                </div>
                <script>
                    document.getElementById('amountReceived').addEventListener('input', function() {

                        const received = parseFloat(this.value) || 0;

                        const totalText = document.getElementById('grandTotalWithVat')
                            .textContent.replace(/,/g, '').replace(' ฿', '');

                        const total = parseFloat(totalText) || 0;

                        let change = received - total;
                        if (change < 0) change = 0;

                        document.getElementById('changeAmount').value =
                            change.toLocaleString(undefined, {
                                minimumFractionDigits: 2
                            }) + ' ฿';
                    });

                    function prepareCustomerPhone() {

                        const isDelivery = document.getElementById('deliveryCheck').checked;

                        let phone = '';

                        if (isDelivery) {
                            phone = document.getElementById('customerSelect').value;
                        } else {
                            phone = document.getElementById('customerPhone').value;
                        }

                        if (!phone) {
                            alert('กรุณากรอกหรือเลือกลูกค้า');
                            event.preventDefault();
                            return false;
                        }

                        document.getElementById('finalCustomerPhone').value = phone;

                        console.log('📞 เบอร์ที่ส่ง:', phone);
                    }



                    //สะสมแต้ม
                    function checkCustomerPhone() {
                        const phone = document.getElementById('customerPhone').value;

                        if (!phone) {
                            alert('กรุณากรอกเบอร์โทร');
                            return;
                        }

                        // ✅ set ค่าไว้ล่วงหน้าเลย (สำคัญมาก)
                        document.getElementById('finalCustomerPhone').value = phone;

                        fetch('{{ route('cart.checkCustomer') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    phone
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {

                                    document.getElementById('customerInfo').style.display = 'block';
                                    document.getElementById('custName').textContent = data.customer.name;
                                    document.getElementById('custType').textContent = data.customer.type;

                                    if (data.can_use_wholesale) {
                                        alert('ลูกค้าผ่านเงื่อนไข → ราคาส่ง');
                                        applyWholesalePrice();
                                    } else {
                                        alert('ราคาปลีก');
                                        applyRetailPrice();
                                    }
                                }
                            });
                    }


                    function applyWholesalePrice() {
                        document.querySelectorAll('tr[data-id]').forEach(row => {

                            const id = row.dataset.id;
                            const wholesale = parseFloat(row.dataset.wholesale);
                            const qty = parseInt(row.querySelector('.qty-cart').value) || 0;

                            row.querySelector('td:nth-child(2)').textContent =
                                wholesale.toLocaleString(undefined, {
                                    minimumFractionDigits: 2
                                }) + ' ฿';

                            row.querySelector('.total-price').textContent =
                                (wholesale * qty).toLocaleString(undefined, {
                                    minimumFractionDigits: 2
                                }) + ' ฿';

                            row.querySelector('.price-type').textContent = 'ส่ง';

                            // ✅ ยิงอัปเดต backend
                            updateCartItem(id, qty, row);
                        });

                        updateGrandTotal();
                    }

                    function applyRetailPrice() {
                        document.querySelectorAll('tr[data-id]').forEach(row => {

                            const retail = parseFloat(row.dataset.retail);
                            const qty = parseInt(row.querySelector('.qty-cart').value) || 0;

                            row.querySelector('td:nth-child(2)').textContent =
                                retail.toLocaleString(undefined, {
                                    minimumFractionDigits: 2
                                }) + ' ฿';

                            row.querySelector('.total-price').textContent =
                                (retail * qty).toLocaleString(undefined, {
                                    minimumFractionDigits: 2
                                }) + ' ฿';

                            row.querySelector('.price-type').textContent = 'ปลีก';
                            updateCartItem(id, qty, row);
                        });

                        updateGrandTotal();
                    }

                    function toggleDelivery() {
                        const div = document.getElementById('phoneInputDiv');
                        const checkbox = document.getElementById('deliveryCheck');

                        if (div.style.display === "none" || div.style.display === "") {
                            div.style.display = "block";
                            checkbox.checked = true;
                        } else {
                            div.style.display = "none";
                            checkbox.checked = false;
                        }
                    }



                    function myConfirmFunction() {
                        if (confirm("คุณต้องการบันทึกข้อมูลใช่ไหม?")) {
                            alert("บันทึกข้อมูลแล้ว");
                        } else {
                            alert("ยกเลิกการบันทึก");
                        }
                    }



                    new TomSelect("#customerSelect", {
                        valueField: "value",
                        labelField: "text",
                        searchField: ["text"],
                        create: true, // ⭐ เปิดให้พิมพ์เองได้

                        onChange: function(value) {
                            const optionEl = this.options[value]?.$option;
                            const infoBox = document.getElementById('customerInfo');

                            if (value === "") {
                                infoBox.style.display = 'none';
                                return;
                            }

                            if (optionEl) {
                                infoBox.style.display = 'block';
                                document.getElementById('custName').textContent = optionEl.dataset.name || '-';
                                document.getElementById('custType').textContent = optionEl.dataset.type || '-';
                                document.getElementById('custContact').textContent = optionEl.dataset.contact || '-';
                                document.getElementById('custAddress').textContent = optionEl.dataset.address || '-';
                            } else {
                                infoBox.style.display = 'none';
                            }
                        }
                    });

                    function changeCartQty(id, delta) {
                        const row = document.querySelector(`tr[data-id='${id}']`);
                        const input = row.querySelector('.qty-cart');
                        let value = parseInt(input.value) || 0;
                        value += delta;
                        if (value < 0) value = 0;
                        input.value = value;
                        updateCartItem(id, value, row);
                    }

                    function updateCartItem(id, qty, row) {

                        const price = parseFloat(
                            row.querySelector('td:nth-child(2)').textContent
                            .replace(/,/g, '')
                            .replace(' ฿', '')
                        );

                        if (qty <= 0) {
                            row.remove();
                        } else {
                            row.querySelector('.total-price').textContent =
                                (price * qty).toLocaleString(undefined, {
                                    minimumFractionDigits: 2
                                }) + ' ฿';
                        }

                        updateGrandTotal();

                        const priceType = row.querySelector('.price-type').textContent.trim();

                        fetch('{{ route('cart.add') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    id: id,
                                    qty: qty,
                                    price: price, // ✅ ตอนนี้ใช้ได้แล้ว
                                    price_type: priceType
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                document.getElementById('cartCount').textContent = data.cart_count;
                            })
                            .catch(err => {
                                console.error(err); // 👈 จะเห็น error จริง
                            });
                    }



                    function removeCartItem(id) {
                        updateCartItem(id, 0, document.querySelector(`tr[data-id='${id}']`));
                    }

                    function showToast(msg) {
                        alert(msg);
                    }



                    function updateGrandTotal() {
                        let subtotal = 0;
                        document.querySelectorAll('tr[data-id]').forEach(row => {
                            const priceText = row.querySelector('.total-price').textContent.replace(/,/g, '').replace(' ฿',
                                '');
                            subtotal += parseFloat(priceText) || 0;
                        });

                        let vat = subtotal * 0.07;
                        let totalWithVat = subtotal + vat;

                        // อัปเดตค่าในตาราง
                        const subtotalEl = document.getElementById('subtotal');
                        const vatEl = document.getElementById('vatAmount');
                        const grandTotalWithVatEl = document.getElementById('grandTotalWithVat');

                        if (subtotalEl) subtotalEl.textContent = subtotal.toLocaleString(undefined, {
                            minimumFractionDigits: 2
                        }) + ' ฿';
                        if (vatEl) vatEl.textContent = vat.toLocaleString(undefined, {
                            minimumFractionDigits: 2
                        }) + ' ฿';
                        if (grandTotalWithVatEl) grandTotalWithVatEl.textContent = totalWithVat.toLocaleString(undefined, {
                            minimumFractionDigits: 2
                        }) + ' ฿';
                    }


                    function manualChangeQty(id, input) {
                        let value = parseInt(input.value) || 0;
                        updateCartItem(id, value, document.querySelector(`tr[data-id='${id}']`));
                    }

                    function toggleDelivery() {
                        const div = document.getElementById('phoneInputDiv');
                        const checkbox = document.getElementById('deliveryCheck');

                        if (div.style.display === "none" || div.style.display === "") {
                            div.style.display = "block";
                            checkbox.checked = true; // เปิดจัดส่ง
                        } else {
                            div.style.display = "none";
                            checkbox.checked = false; // ไม่จัดส่ง
                        }
                    }
                </script>

            </div>


</body>

</html>
