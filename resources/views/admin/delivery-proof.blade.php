<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>หลักฐานการจัดส่ง</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">📦 หลักฐานการจัดส่ง</h2>
        <a href="{{ route('admin.orders') }}" class="btn btn-secondary">← กลับ</a>
    </div>

    <!-- CARD -->
    <div class="card shadow-lg border-0">
        <div class="card-body">

            <h4 class="mb-3">Order #{{ $order->id }}</h4>

            <div class="row">

                <!-- LEFT: INFO -->
                <div class="col-md-6">
                    <p><strong>📅 วันที่สั่งซื้อ:</strong> {{ $order->created_at }}</p>
                    <p><strong>📞 เบอร์ลูกค้า:</strong> {{ $order->customer_phone ?? '-' }}</p>
                    <p>
                        <strong>📌 สถานะ:</strong>
                        @if($order->status == 'completed')
                            <span class="badge bg-success">จัดส่งแล้ว</span>
                        @else
                            <span class="badge bg-warning text-dark">{{ $order->status }}</span>
                        @endif
                    </p>
                </div>

                <!-- RIGHT: IMAGE -->
                <div class="col-md-6 text-center">
                    @if($order->delivery_image)
                        <p><strong>📸 หลักฐานการจัดส่ง</strong></p>

                        <img src="{{ asset('storage/' . $order->delivery_image) }}"
                             class="img-fluid rounded shadow"
                             style="max-height:300px; cursor:pointer;"
                             onclick="openImage(this.src)">

                        <p class="mt-2 text-muted">คลิกเพื่อดูขนาดเต็ม</p>
                    @else
                        <div class="alert alert-warning">
                            ❌ ยังไม่มีหลักฐานการจัดส่ง
                        </div>
                    @endif
                </div>

            </div>

            <hr>

            <!-- TABLE รายการสินค้า -->
            <h5 class="mb-3">🛒 รายการสินค้า</h5>

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>สินค้า</th>
                        <th>จำนวน</th>
                        <th>ราคา</th>
                        <th>รวม</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderDetails as $item)
                    <tr>
                        <td>{{ $item->product->name ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price,2) }} ฿</td>
                        <td>{{ number_format($item->unit_price * $item->quantity,2) }} ฿</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>

<!-- MODAL ดูรูปเต็ม -->
<div class="modal fade" id="imageModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-body text-center">
        <img id="modalImage" src="" class="img-fluid rounded">
      </div>
    </div>
  </div>
</div>

<script>
function openImage(src) {
    document.getElementById('modalImage').src = src;
    let modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
