@extends('layouts.adminside')

@section('content')

<div class="container-fluid px-4">

    <h3 class="mt-4 mb-4">จัดการผู้ใช้ / สิทธิ์พนักงาน</h3>

    {{-- แจ้งเตือน --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            รายชื่อผู้ใช้งานทั้งหมด
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-secondary">
                    <tr>
                        <th width="60">#</th>
                        <th>ชื่อ</th>
                        <th>Email</th>
                        <th width="150">ตำแหน่ง</th>
                        <th width="420">จัดการสิทธิ์</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td class="text-start">
                            {{ $user->name }}
                            @if(auth()->id() == $user->id)
                                <span class="badge bg-primary ms-1">คุณ</span>
                            @endif
                        </td>

                        <td class="text-start">{{ $user->email }}</td>

                        {{-- แสดงตำแหน่ง --}}
                        <td>
                            @if($user->is_admin == 1)
                                <span class="badge bg-danger">Admin</span>
                            @elseif($user->role == 'rider')
                                <span class="badge bg-warning text-dark">Rider</span>
                            @else
                                <span class="badge bg-secondary">User</span>
                            @endif
                        </td>


                        {{-- ปุ่มจัดการ --}}
                        <td>

                            {{-- ========== RIDER ========== --}}
                            @if($user->role != 'rider')
                                <form action="{{ route('admin.makeRider',$user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-warning btn-sm">
                                        แต่งตั้ง Rider
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.removeRider',$user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-outline-secondary btn-sm">
                                        ถอด Rider
                                    </button>
                                </form>
                            @endif


                            {{-- ========== ADMIN ========== --}}
                            @if($user->is_admin != 1)
                                <form action="{{ route('admin.makeAdmin',$user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">
                                        แต่งตั้ง Admin
                                    </button>
                                </form>
                            @else
                                @if(auth()->id() != $user->id)
                                    <form action="{{ route('admin.removeAdmin',$user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-dark btn-sm">
                                            ถอด Admin
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-dark btn-sm" disabled>
                                        Admin ปัจจุบัน
                                    </button>
                                @endif
                            @endif

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            ไม่มีผู้ใช้งานในระบบ
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection
