@extends('admin.component-admin.layout')

@section('title', 'Chi tiết Liên hệ - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Chi tiết Liên hệ</h1>
            <p class="text-muted mb-0">ID: #{{ $contact->id }}</p>
        </div>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Quay lại
        </a>
    </div>

    <div class="row">
        <!-- Contact Info -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Thông tin người gửi</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ $contact->user && $contact->user->avatar
                            ? asset('storage/avatars/' . $contact->user->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($contact->name) . '&background=random&size=80' }}"
                             alt="" class="rounded-circle mb-3"
                             style="width: 80px; height: 80px;">
                        <h5 class="mb-1">{{ $contact->name }}</h5>
                        @if($contact->user)
                            <span class="badge bg-primary">{{ $contact->user->role }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Email</label>
                        <p class="mb-0">
                            <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                        </p>
                    </div>

                    @if($contact->phone)
                        <div class="mb-3">
                            <label class="text-muted small">Số điện thoại</label>
                            <p class="mb-0">{{ $contact->phone }}</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="text-muted small">Ngày gửi</label>
                        <p class="mb-0">{{ $contact->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>

                    <div class="mb-0">
                        <label class="text-muted small">Trạng thái</label>
                        <p class="mb-0">
                            @switch($contact->status)
                                @case('unread')
                                    <span class="badge bg-warning text-dark">Chưa đọc</span>
                                    @break
                                @case('read')
                                    <span class="badge bg-info">Đã đọc</span>
                                    @break
                                @case('replied')
                                    <span class="badge bg-success">Đã phản hồi</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $contact->status }}</span>
                            @endswitch
                        </p>
                    </div>
                </div>
            </div>

            @if($contact->status !== 'replied')
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Đánh dấu</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.contacts.markRead', $contact->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="bi bi-check2 me-2"></i>Đánh dấu đã đọc
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <!-- Message Content -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Nội dung tin nhắn</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="text-muted small">Chủ đề</label>
                        <h5 class="mb-0">{{ $contact->subject }}</h5>
                    </div>

                    <hr>

                    <div class="message-content">
                        <p style="white-space: pre-wrap;">{{ $contact->message }}</p>
                    </div>
                </div>
            </div>

            @if($contact->status === 'replied' && $contact->admin_reply)
                <div class="card border-0 shadow-sm mb-4 border-start border-4 border-success">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="bi bi-reply text-success me-2"></i>Phản hồi của bạn
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="message-content">
                            <p style="white-space: pre-wrap;">{{ $contact->admin_reply }}</p>
                        </div>
                        <small class="text-muted">
                            Gửi lúc: {{ $contact->replied_at->format('d/m/Y H:i:s') }}
                        </small>
                    </div>
                </div>
            @endif

            @if($contact->status !== 'replied')
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="bi bi-reply me-2"></i>Gửi phản hồi
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.contacts.reply', $contact->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="admin_reply" class="form-label">Nội dung phản hồi</label>
                                <textarea class="form-control @error('admin_reply') is-invalid @enderror"
                                          id="admin_reply" name="admin_reply" rows="6"
                                          placeholder="Nhập nội dung phản hồi...">{{ old('admin_reply') }}</textarea>
                                @error('admin_reply')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-send me-2"></i>Gửi phản hồi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
