<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @extends('layouts.sidebar')
    <div class="col py-3 main-content">
         <!-- HEADER -->
         <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-primary">
                🖼️ รูปหลักฐานการจัดส่งจาก Rider
            </h3>

            <a href="{{ route('admin.order.proof') }}" class="btn btn-outline-secondary rounded-pill">
                ← กลับ
            </a>
        </div>

        <h3>📦 หลักฐาน Order #{{ $order->id }}</h3>

        <div class="card mt-4 text-center">
            <div class="card-body">

                @if($order->delivery_image)
                    <img src="{{ asset('storage/' . $order->delivery_image) }}"
                         class="img-fluid rounded shadow"
                         style="max-height: 500px;">

                    <div class="mt-3">
                        <a href="{{ asset('storage/' . $order->delivery_image) }}"
                           target="_blank"
                           class="btn btn-primary">
                            🔍 ดูภาพเต็ม
                        </a>
                    </div>
                @else
                    <p class="text-danger">ไม่มีรูป</p>
                @endif

            </div>
        </div>

    </div>

    </body>
    </html>
