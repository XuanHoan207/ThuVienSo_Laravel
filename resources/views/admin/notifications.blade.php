@extends('admin.component-admin.layout')

@section('title', 'Thông báo - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Thông báo</h1>
            <p class="text-muted mb-0">Quản lý thông báo hệ thống</p>
        </div>
        <a href="{{ url('/admin/notifications/create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Gửi thông báo
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <p class="text-muted text-center py-5">
                <i class="bi bi-bell fs-1 d-block mb-3"></i>
                Trang quản lý thông báo đang được phát triển...
            </p>
        </div>
    </div>
@endsection
