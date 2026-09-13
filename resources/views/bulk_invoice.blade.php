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
   <title>ใบสั่งซื้อ</title>
   <style>
       body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
       table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
       th, td { border: 1px solid #000; padding: 6px; }
       th { background: #f0f0f0; }

       .header { text-align: center; margin-bottom: 10px; }
       .info { margin-bottom: 15px; }
       .footer { margin-top: 30px; font-size: 11px; }
       .sign { width: 45%; display: inline-block; text-align: center; margin-top: 50px; }
       hr { border: 0; border-top: 1px dashed #999; margin: 40px 0; }
       @font-face {
        font-family: 'sarabun';
        src: url('{{ public_path('fonts/THSarabunNew.ttf') }}') format('truetype');
    }
    body {
        font-family: 'sarabun', sans-serif;
        font-size: 12px;
    }
   </style>
</head>
<body>

@foreach($orders as $order)
<div class="invoice">

   <div class="header">
       <h2>ใบสั่งซื้อ (Purchase Order)</h2>
       <strong>บริษัทสหโชคหลังคาเหล็ก จำกัด</strong><br>
       <span style="font-size: 11px;">ที่อยู่/เบอร์โทร ใส่ข้อมูลของคุณตรงนี้</span>
   </div>

   <div class="info">
       <strong>เลขที่ใบสั่งซื้อ:</strong> {{ $order->id }}<br>
       <strong>วันที่:</strong> {{ $order->created_at->format('d/m/Y') }}<br>
       <strong>ลูกค้า:</strong> {{ $order->customer->name ?? '-' }}<br>
       <strong>เบอร์โทร:</strong> {{ $order->customer_phone }}<br>
   </div>

   <table>
       <thead>
           <tr>
               <th style="width: 50%;">รายการสินค้า</th>
               <th style="width: 15%;">จำนวน</th>
               <th style="width: 20%;">ราคาต่อหน่วย</th>
               <th style="width: 15%;">รวม</th>
           </tr>
       </thead>
       <tbody>
           @foreach($order->orderDetails as $detail)
           <tr>
               <td>{{ $detail->product->name ?? '-' }}</td>
               <td style="text-align:center;">{{ $detail->quantity }}</td>
               <td style="text-align:right;">{{ number_format($detail->unit_price, 2) }}</td>
               <td style="text-align:right;">{{ number_format($detail->total_price, 2) }}</td>
           </tr>
           @endforeach
       </tbody>
   </table>

   <div style="text-align: right;">
       <strong>รวมทั้งสิ้น: {{ number_format($order->total_price, 2) }} บาท</strong>
   </div>

   <br><br>

   <div style="text-align: center;">
       <div class="sign">
           ____________________________ <br>
           ผู้ส่งสินค้า
       </div>
       <div class="sign" style="float:right;">
           ____________________________ <br>
           ผู้รับสินค้า
       </div>
   </div>

</div>

@if(!$loop->last)
   <hr>
@endif
<script type="text/javascript">
    this.print();
</script>


@endforeach

</body>
</html>
