<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: sarabun;
            font-size: 16px;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
        }

        .company {
            text-align: center;
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 4px;
            vertical-align: top;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .product-table th,
        .product-table td {
            border: 1px solid #000;
            padding: 7px;
        }

        .product-table th {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary {
            width: 45%;
            margin-left: auto;
            margin-top: 20px;
        }

        .summary td {
            padding: 5px;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <h1>ใบสั่งซื้อ</h1>

    <div class="company">
        <strong>{{ $store->shop_name ?? 'ไม่ระบุชื่อร้าน' }}</strong><br>

        {{ $store->address ?? '-' }}<br>

        โทร. {{ $store->phone ?? '-' }}<br>

        เลขผู้เสียภาษี {{ $store->tax_id ?? '-' }}
    </div>

    <table class="info-table">
        <tr>
            <td width="50%">
                <strong>เลขที่คำสั่งซื้อ:</strong>
                #{{ $order->id }}
                <br>

                <strong>วันที่:</strong>
                {{ $order->created_at->format('d/m/Y H:i') }}
            </td>

            <td width="50%">
                <strong>สถานะ:</strong>
                {{ $order->status == 'completed' ? 'เสร็จสิ้น' : 'รอดำเนินการ' }}
                <br>

                <strong>การจัดส่ง:</strong>
                {{ $order->is_delivery ? 'จัดส่ง' : 'รับสินค้าเอง' }}
            </td>
        </tr>
    </table>


    <table class="info-table">

        <tr>
            <td>
                <strong>ข้อมูลลูกค้า</strong>
            </td>
        </tr>

        <tr>
            <td>
                ชื่อ:
                {{ $order->customer->name ?? 'ลูกค้าทั่วไป' }}
            </td>

            <td>
                เบอร์โทร:
                {{ $order->customer_phone ?? '-' }}
            </td>
        </tr>

        @if ($order->customer)

            <tr>
                <td colspan="2">
                    ประเภทลูกค้า:
                    {{ $order->customer->type ?? '-' }}
                </td>
            </tr>

            @if ($order->is_delivery)

                <tr>
                    <td colspan="2">

                        <strong>ที่อยู่จัดส่ง:</strong>

                        {{ $order->customer->address_number ?? '' }}

                        {{ $order->customer->address_building ?? '' }}

                        {{ $order->customer->address_street ?? '' }}

                        {{ $order->customer->address_subdistrict ?? '' }}

                        {{ $order->customer->address_district ?? '' }}

                        {{ $order->customer->address_province ?? '' }}

                        {{ $order->customer->postal_code ?? '' }}

                    </td>
                </tr>

            @endif

        @endif

    </table>

    <table class="product-table">

        <thead>
            <tr>
                <th width="8%">ลำดับ</th>
                <th width="35%">สินค้า</th>
                <th width="12%">ประเภท</th>
                <th width="12%">จำนวน</th>
                <th width="16%">ราคา/หน่วย</th>
                <th width="17%">รวม</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($order->orderDetails as $index => $detail)

                <tr>

                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $detail->product->productItem->item_name ?? 'ไม่พบชื่อสินค้า' }}
                    </td>

                    <td class="text-center">

                        @if ($detail->price_type === 'ส่ง' || $detail->price_type === 'wholesale_price')
                            ราคาส่ง
                        @else
                            ราคาปลีก
                        @endif

                    </td>

                    <td class="text-center">
                        {{ $detail->quantity }}
                    </td>

                    <td class="text-right">
                        {{ number_format($detail->unit_price, 2) }}
                    </td>

                    <td class="text-right">
                        {{ number_format($detail->total_price, 2) }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>


    <table class="summary">

        <tr>
            <td>
                ยอดก่อน VAT
            </td>

            <td class="text-right">
                {{ number_format($subtotal, 2) }} ฿
            </td>
        </tr>

        <tr>
            <td>
                VAT 7%
            </td>

            <td class="text-right">
                {{ number_format($vat, 2) }} ฿
            </td>
        </tr>

        <tr class="total">

            <td>
                ยอดรวมสุทธิ
            </td>

            <td class="text-right">
                {{ number_format($grandTotal, 2) }} ฿
            </td>

        </tr>

    </table>


    <div class="footer">

        <table width="100%">

            <tr>

                <td width="50%" class="text-center">
                    ผู้สั่งซื้อ
                    <br><br><br>
                    ______________________
                </td>

                <td width="50%" class="text-center">
                    ผู้รับสินค้า
                    <br><br><br>
                    ______________________
                </td>

            </tr>

        </table>

    </div>

</body>

</html>
