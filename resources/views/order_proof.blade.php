<!DOCTYPE html>
<html lang="th">
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

    <title>หน้าหลัก</title>

</head>
@extends('layouts.sidebar')

<div class="col py-4 main-content">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
             หลักฐานการจัดส่ง
        </h2>

        {{-- <span class="badge bg-success fs-6">
            {{ count($orders) }} ออเดอร์
        </span> --}}
    </div>

    <!-- CARD -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>ผู้ส่งสินค้า</th>
                            <th>รูปหลักฐาน</th>
                            <th>สถานะ</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td class="fw-semibold text-primary">
                                #{{ $order->id }}
                            </td>

                            <td>{{ auth()->user()->name }}</td>

                            <!-- รูป preview -->
                            <td>
                                @if($order->delivery_image)
                                    <img src="{{ asset('storage/' . $order->delivery_image) }}"
                                         width="70"
                                         height="70"
                                         class="rounded-3 shadow-sm object-fit-cover">
                                @else
                                    <span class="text-danger">ไม่มีรูป</span>
                                @endif
                            </td>

                            <!-- สถานะ -->
                            <td>
                                @if($order->delivery_image)
                                    <span class="badge bg-success">
                                        ส่งแล้ว
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        ยังไม่ส่ง
                                    </span>
                                @endif
                            </td>

                            <!-- ปุ่ม -->
                            <td class="text-center">
                                <a href="{{ route('admin.order.proof.show', $order->id) }}"
                                   class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="bi bi-eye"></i> ดูภาพ
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                ไม่มีข้อมูลการจัดส่ง
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

</body>
</html>
