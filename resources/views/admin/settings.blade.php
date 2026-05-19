@extends('admin.component-admin.layout')

@section('title', 'Cài đặt - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Cài đặt Hệ thống</h1>
            <p class="text-muted mb-0">Cấu hình website</p>
        </div>
        <button type="submit" form="settingsForm" class="btn btn-primary">
            <i class="bi bi-check-circle me-2"></i>Lưu cài đặt
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.settings.store') }}" method="POST" id="settingsForm">
        @csrf
        <div class="row">
            <!-- Settings Navigation -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm sticky-top" style="top: 80px;">
                    <div class="card-body p-2">
                        <div class="nav flex-column nav-pills" id="settingsTabs" role="tablist">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="pill" data-bs-target="#general" type="button">
                                <i class="bi bi-gear me-2"></i>General
                            </button>
                            <button class="nav-link" id="contact-tab" data-bs-toggle="pill" data-bs-target="#contact" type="button">
                                <i class="bi bi-telephone me-2"></i>Liên hệ
                            </button>
                            <button class="nav-link" id="points-tab" data-bs-toggle="pill" data-bs-target="#points" type="button">
                                <i class="bi bi-coin me-2"></i>Điểm
                            </button>
                            <button class="nav-link" id="upload-tab" data-bs-toggle="pill" data-bs-target="#upload" type="button">
                                <i class="bi bi-upload me-2"></i>Upload
                            </button>
                            <button class="nav-link" id="social-tab" data-bs-toggle="pill" data-bs-target="#social" type="button">
                                <i class="bi bi-share me-2"></i>Mạng xã hội
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Content -->
            <div class="col-lg-9">
                <div class="tab-content" id="settingsTabsContent">
                    <!-- General Settings -->
                    <div class="tab-pane fade show active" id="general">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Cài đặt Chung</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="site_name" class="form-label">Tên website</label>
                                    <input type="text" class="form-control" id="site_name" name="site_name"
                                           value="{{ $settings['site_name'] ?? 'Thư Viện Số' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="site_description" class="form-label">Mô tả website</label>
                                    <textarea class="form-control" id="site_description" name="site_description"
                                              rows="3">{{ $settings['site_description'] ?? '' }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="site_logo" class="form-label">Logo</label>
                                    <input type="file" class="form-control" id="site_logo" name="site_logo" accept="image/*">
                                    @if(!empty($settings['site_logo']))
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $settings['site_logo']) }}"
                                                 alt="Logo" style="max-height: 60px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Settings -->
                    <div class="tab-pane fade" id="contact">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Thông tin Liên hệ</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="contact_email" class="form-label">Email liên hệ</label>
                                    <input type="email" class="form-control" id="contact_email" name="contact_email"
                                           value="{{ $settings['contact_email'] ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="contact_phone" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" id="contact_phone" name="contact_phone"
                                           value="{{ $settings['contact_phone'] ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="contact_address" class="form-label">Địa chỉ</label>
                                    <textarea class="form-control" id="contact_address" name="contact_address"
                                              rows="3">{{ $settings['contact_address'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Points Settings -->
                    <div class="tab-pane fade" id="points">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Cài đặt Điểm</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Tỷ lệ quy đổi: <strong>1,000 VNĐ = X điểm</strong>
                                </div>
                                <div class="mb-3">
                                    <label for="points_rate" class="form-label">Tỷ lệ điểm (1000 VND = X điểm)</label>
                                    <input type="number" class="form-control" id="points_rate" name="points_rate"
                                           value="{{ $settings['points_rate'] ?? 100 }}" min="1">
                                </div>
                                <div class="mb-3">
                                    <label for="min_recharge" class="form-label">Số tiền nạp tối thiểu (VNĐ)</label>
                                    <input type="number" class="form-control" id="min_recharge" name="min_recharge"
                                           value="{{ $settings['min_recharge'] ?? 10000 }}" min="1000">
                                </div>
                                <div class="mb-3">
                                    <label for="bonus_rate_10" class="form-label">Bonus khi nạp 10,000 - 49,000 VNĐ</label>
                                    <input type="number" class="form-control" id="bonus_rate_10" name="bonus_rate_10"
                                           value="{{ $settings['bonus_rate_10'] ?? 0 }}" min="0" max="100"> %
                                </div>
                                <div class="mb-3">
                                    <label for="bonus_rate_50" class="form-label">Bonus khi nạp 50,000 - 99,000 VNĐ</label>
                                    <input type="number" class="form-control" id="bonus_rate_50" name="bonus_rate_50"
                                           value="{{ $settings['bonus_rate_50'] ?? 10 }}" min="0" max="100"> %
                                </div>
                                <div class="mb-3">
                                    <label for="bonus_rate_100" class="form-label">Bonus khi nạp 100,000 - 199,000 VNĐ</label>
                                    <input type="number" class="form-control" id="bonus_rate_100" name="bonus_rate_100"
                                           value="{{ $settings['bonus_rate_100'] ?? 20 }}" min="0" max="100"> %
                                </div>
                                <div class="mb-3">
                                    <label for="bonus_rate_200" class="form-label">Bonus khi nạp 200,000 - 499,000 VNĐ</label>
                                    <input type="number" class="form-control" id="bonus_rate_200" name="bonus_rate_200"
                                           value="{{ $settings['bonus_rate_200'] ?? 30 }}" min="0" max="100"> %
                                </div>
                                <div class="mb-3">
                                    <label for="bonus_rate_500" class="form-label">Bonus khi nạp 500,000+ VNĐ</label>
                                    <input type="number" class="form-control" id="bonus_rate_500" name="bonus_rate_500"
                                           value="{{ $settings['bonus_rate_500'] ?? 50 }}" min="0" max="100"> %
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Settings -->
                    <div class="tab-pane fade" id="upload">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Cài đặt Upload</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="max_upload_size" class="form-label">Kích thước file tối đa (bytes)</label>
                                    <input type="number" class="form-control" id="max_upload_size" name="max_upload_size"
                                           value="{{ $settings['max_upload_size'] ?? 52428800 }}">
                                    <small class="text-muted">50MB = 52428800 bytes</small>
                                </div>
                                <div class="mb-3">
                                    <label for="allowed_file_types" class="form-label">Định dạng file cho phép</label>
                                    <input type="text" class="form-control" id="allowed_file_types" name="allowed_file_types"
                                           value="{{ $settings['allowed_file_types'] ?? 'pdf,epub' }}">
                                    <small class="text-muted">Các định dạng cách nhau bởi dấu phẩy (pdf, epub, mobi)</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Settings -->
                    <div class="tab-pane fade" id="social">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Mạng xã hội</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="social_facebook" class="form-label">Facebook</label>
                                    <input type="url" class="form-control" id="social_facebook" name="social_facebook"
                                           value="{{ $settings['social_facebook'] ?? '' }}" placeholder="https://facebook.com/...">
                                </div>
                                <div class="mb-3">
                                    <label for="social_google" class="form-label">Google</label>
                                    <input type="url" class="form-control" id="social_google" name="social_google"
                                           value="{{ $settings['social_google'] ?? '' }}" placeholder="https://...">
                                </div>
                                <div class="mb-3">
                                    <label for="social_zalo" class="form-label">Zalo</label>
                                    <input type="text" class="form-control" id="social_zalo" name="social_zalo"
                                           value="{{ $settings['social_zalo'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
