@extends('layouts.adminside')

@section('content')

<div class="container mt-4">
    <h2>📦 หลักฐานการจัดส่ง</h2>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
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

                            <td>
                                @if($order->delivery_image)
                                    <img src="{{ asset('storage/' . $order->delivery_image) }}"
                                         width="70"
                                         height="70"
                                         class="rounded-3 shadow-sm">
                                @else
                                    <span class="text-danger">ไม่มีรูป</span>
                                @endif
                            </td>

                            <td>
                                @if($order->delivery_image)
                                    <span class="badge bg-success">ส่งแล้ว</span>
                                @else
                                    <span class="badge bg-danger">ยังไม่ส่ง</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="{{ route('admin.proof.show', $order->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    👁 ดูภาพ
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

@endsection
