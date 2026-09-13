<!-- resources/views/checkout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Check Out</title>
</head>
<body>
    <div class="sidebar">
        <div class="logo_content">
            <a href="{{ route('home') }}" class="logo">
                <i class='bx bx-store'></i>
                <div class="logo_name">Home</div>
            </a>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav_list">
            <li>
                <a href="{{ route('product.list') }}">
                    <i class='bx bx-box'></i>
                    <span class="link_name">Product list</span>
                </a>
                <span class="tooltip">Product list</span>
            </li>
            <!-- Other menu items -->
            <li>
                <a href="#">
                    <i class='bx bx-line-chart'></i>
                    <span class="link_name">Sales Data</span>
                </a>
                <span class="tooltip">Sales Data</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-group'></i>
                    <span class="link_name">Customer Data</span>
                </a>
                <span class="tooltip">Customer Data</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-store'></i>
                    <span class="link_name">Seller Data</span>
                </a>
                <span class="tooltip">Seller Data</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-check-square'></i>
                    <span class="link_name">Stock Check</span>
                </a>
                <span class="tooltip">Stock Check</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-cog'></i>
                    <span class="link_name">Settings</span>
                </a>
                <span class="tooltip">Settings</span>
            </li>
            <li>
                <a href="#" class="log_out_btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class='bx bx-log-out'></i>
                    <span class="link_name">Log Out</span>
                </a>
                <span class="tooltip">Log Out</span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    <h1>การชำระเงิน</h1>

    <h2>รายละเอียดการสั่งซื้อ</h2>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total Price</th>
        </tr>
        @foreach ($orders as $order)
        <tr>
            {{-- <td>{{ $order->product_name }}</td> --}}
            <td>{{ $order->product->productItem->item_name }}</td>

            <td>{{ $order->quantity }}</td>
            <td>฿{{ number_format($order->total_price, 2) }}</td>
        </tr>
        @endforeach
    </table>

    <h3>Total Amount: ฿{{ number_format($sellData->total_amount, 2) }}</h3>

    <!-- Form for payment -->
    <form action="{{ route('process.payment') }}" method="POST">
        @csrf
        <button type="submit">Proceed to Payment</button>
    </form>
   
</body>
</html>
