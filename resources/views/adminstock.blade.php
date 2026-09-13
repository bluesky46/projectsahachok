<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>


    <title>Admin Stock</title>

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
                    <a href="{{ route('admin.index') }}" class="nav-link align-middle px-0">
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

        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            ออกจากระบบ
        </a>

    </div>




    <div class="content">
        <div class="container-fluid mt-4">
            <form method="GET" action="{{ route('adminstock') }}" class="mb-3">
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control" placeholder="วันที่เริ่มต้น">
                    </div>
                    <div class="col-auto">
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control" placeholder="วันที่สิ้นสุด">
                    </div>

                    {{-- เลือกสินค้า --}}
                    <div class="col-auto">
                        <select name="product_id" class="form-select">
                            <option value="">-- สินค้าทั้งหมด --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{-- {{ $product->product_name }} --}}
                                    {{ $product->productItem->item_name }}

                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ประเภทการเคลื่อนไหว --}}
                    <div class="col-auto">
                        <select name="movement_type" class="form-select">
                            <option value="">-- ทุกประเภทการเคลื่อนไหว --</option>
                            <option value="เข้า" {{ request('movement_type') == 'เข้า' ? 'selected' : '' }}>เข้า</option>
                            <option value="ออก" {{ request('movement_type') == 'ออก' ? 'selected' : '' }}>ออก</option>
                            <option value="เพิ่มสินค้าใหม่" {{ request('movement_type') == 'เพิ่มสินค้าใหม่' ? 'selected' : '' }}>เพิ่มสินค้าใหม่</option>
                        </select>
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">กรองข้อมูล</button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('adminstock') }}" class="btn btn-secondary">รีเซ็ต</a>
                    </div>


                    <div class="col-auto">
                        <a href="{{ route('adminstock.export', request()->query()) }}" class="btn btn-success">ส่งออก Excel</a>
                    </div>
                </div>
            </form>


     {{-- ตารางแสดงการเคลื่อนไหวสต็อก --}}
     <h4 class="mb-3">ประวัติการเคลื่อนไหวสต็อก</h4>
     <div class="table-responsive shadow-sm rounded">
         <table class="table table-hover table-bordered align-middle movement-table">
             <thead class="table-secondary text-center">
                 <tr>
                     <th>สินค้า</th>
                     <th>จำนวน</th>
                     <th>ประเภทการเคลื่อนไหว</th>
                     <th>วันที่และเวลา</th>
                 </tr>
             </thead>

             <tbody>
                 @forelse ($stockMovements as $movement)
                     <tr>
                         <td>
                             <span class="d-none">{{ $movement->product->product_code ?? '' }}</span>
                             {{-- ถ้าสินค้าถูกลบ จะแสดง note แทนชื่อสินค้า --}}
                             {{-- {{ $movement->product->product_name ?? $movement->note }} --}}
                             {{ $movement->product->productItem->item_name ?? $movement->note }}
                         </td>

                         <td class="text-center {{ $movement->quantity > 0 ? 'text-success' : 'text-danger' }}">
                             {{ $movement->quantity > 0 ? '-' : '' }}{{ $movement->quantity }}
                         </td>

                         {{-- <td class="text-center {{ $movement->quantity > 0 ? 'text-success' : 'text-danger' }}">
                            {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }} --}}

                         </td>
                         <td class="text-center">{{ ucfirst($movement->movement_type) }}</td>
                         <td class="text-center">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                     </tr>
                 @empty
                     <tr>
                         <td colspan="4" class="text-center text-muted">ไม่มีข้อมูลการเคลื่อนไหว</td>
                     </tr>
                 @endforelse
             </tbody>

         </table>
     </div>

        </div>
    </div>






</body>
</html>
