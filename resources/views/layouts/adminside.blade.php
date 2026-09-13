<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <title>Document</title>
     <style>
        body {
            background: #f4f6f9;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 230px;
            background: linear-gradient(180deg, #1e3c72, #2a5298);
            color: white;
            z-index: 1000;
        }

        .sidebar a {
            color: #ddd;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-radius: 8px;
        }

        .content {
            margin-left: 230px;
            padding: 25px;
        }

        /* Card style */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        .card-header {
            font-weight: 600;
            border-radius: 15px 15px 0 0 !important;
        }

        /* Dashboard title */
        h2 {
            font-weight: 700;
        }

        /* Stat cards */
        .stat-card {
            border-radius: 15px;
            padding: 20px;
            color: white;
        }

        .bg-gradient-blue {
            background: linear-gradient(45deg, #36d1dc, #5b86e5);
        }

        .bg-gradient-green {
            background: linear-gradient(45deg, #11998e, #38ef7d);
        }

        .bg-gradient-orange {
            background: linear-gradient(45deg, #ff9966, #ff5e62);
        }

        /* list */
        .list-group-item {
            border: none;
            border-bottom: 1px solid #eee;
        }

        /* modal */
        .modal-content {
            border-radius: 15px;
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
                <li>
                    <a href="{{ route('admin.checkuser') }}" class="nav-link px-0 align-middle">
                        <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">จัดการผู้ใช้</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('store-settings.edit') }}" class="nav-link"> ⚙️ ตั้งค่าร้านค้า </a>
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
    </div>
    <div class="content">
        @yield('content')   {{-- 🔥 ต้องมีบรรทัดนี้ --}}
    </div>

    <div class="content">


</body>
</html>
