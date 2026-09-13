 @extends('layouts.adminside')
 @section('content')

 <div class="container mt-4">

 <h2>🚚 รอจัดส่ง</h2>
            {{-- <span class="text-muted">ระบบจัดการร้านวัสดุก่อสร้าง</span> --}}

             <table class="table table-bordered">
                 <thead>
                     <tr>
                         <th>เลขออเดอร์</th>
                         <th>ลูกค้า</th>
                         <th>ราคารวม</th>
                         <th>สถานะ</th>
                         <th>วันที่</th>
                     </tr>
                 </thead>
                 <tbody>
                     @forelse($orders as $order)
                         <tr>
                             <td>{{ $order->id }}</td>
                             <td>{{ $order->customer_name ?? '-' }}</td>
                             <td>{{ number_format($order->total_price, 2) }}</td>
                             <td>{{ $order->status }}</td>
                             <td>{{ $order->created_at }}</td>
                         </tr>
                     @empty
                         <tr>
                             <td colspan="5" class="text-center">ไม่มีข้อมูล</td>
                         </tr>
                     @endforelse
                 </tbody>
             </table>
         @endsection
