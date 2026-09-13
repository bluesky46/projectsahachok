<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Rider Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body style="background-color:#f5f6fa;">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold">
            <i class="bi bi-bicycle"></i> Rider Panel
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger btn-sm rounded-pill px-3">
                Logout
            </button>
        </form>
    </div>
</nav>

<div class="container py-5">

    <!-- PROFILE CARD -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body text-center">

            <h4 class="fw-bold mb-3">👋 ยินดีต้อนรับ Rider</h4>

            <p class="mb-1">
                <i class="bi bi-person"></i>
                <strong>{{ auth()->user()->name }}</strong>
            </p>

            <p class="mb-3">
                <i class="bi bi-envelope"></i>
                <strong>{{ auth()->user()->email }}</strong>
            </p>

            <span class="badge bg-warning text-dark px-3 py-2 fs-6">
                🚚 สถานะ: Rider
            </span>
        </div>
    </div>

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">
            <i class="bi bi-box-seam"></i> ออเดอร์ที่ต้องจัดส่ง
        </h4>

        <span class="badge bg-primary fs-6">
            {{ count($orders) }} รายการ
        </span>
    </div>

    <!-- ALERT -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded-3">
            {{ session('success') }}
        </div>
    @endif

    <!-- ORDER LIST -->
    <div class="row g-3">
        @forelse($orders as $order)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body">

                        <h5 class="fw-bold text-primary">
                            #{{ $order->id }}
                        </h5>

                        <p class="text-muted mb-2">
                            <i class="bi bi-calendar"></i>
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </p>

                        <span class="badge bg-warning text-dark mb-3">
                            รอจัดส่ง
                        </span>

                        <div class="d-grid">
                            <a href="{{ route('rider.order.show',$order->id) }}"
                               class="btn btn-primary rounded-pill">
                                <i class="bi bi-eye"></i> ดูรายละเอียด
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-3">ไม่มีออเดอร์ที่ต้องส่ง</p>
            </div>
        @endforelse
    </div>

</div>

</body>
</html>
