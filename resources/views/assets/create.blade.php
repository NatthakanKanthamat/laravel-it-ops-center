<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h4 class="mb-0 fw-bold text-primary">📦 เพิ่มอุปกรณ์ใหม่เข้าสู่ระบบ</h4>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Asset Tag <span class="text-danger">*</span></label>
                                    <input type="text" name="asset_tag" class="form-control @error('asset_tag') is-invalid @enderror" 
                                           placeholder="เช่น IT-69001" value="{{ old('asset_tag') }}" required>  
                                           @error('asset_tag')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">ผู้รับผิดชอบ (เจ้าของเครื่อง)</label>
                                    
                                    @if(auth()->user()->role == 'admin')
                                        <select name="user_id" class="form-select shadow-none border-primary">
                                            <option value="">-- ส่วนกลาง (ยังไม่มีผู้ถือครอง) --</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->username }} ({{ $user->role }})
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="text" class="form-control bg-light" value="{{ auth()->user()->username }}" readonly>
                                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                        <small class="text-muted">อุปกรณ์นี้จะถูกลงทะเบียนในชื่อของคุณ</small>
                                    @endif
                                </div>

                                <div class="col-md-8">
                                    <label class="form-label fw-bold">ชื่ออุปกรณ์ <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control"  @error('name') is-invalid @enderror
                                           placeholder="เช่น MacBook Air M2" value="{{ old('name') }}" required>
                                           @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                         @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">หมวดหมู่</label>
                                    <select name="category" class="form-select">
                                        <option value="PC" {{ old('category') == 'PC' ? 'selected' : '' }}>PC</option>
                                        <option value="Laptop" {{ old('category') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                                        <option value="Monitor" {{ old('category') == 'Monitor' ? 'selected' : '' }}>Monitor</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Serial Number</label>
                                    <input type="text" name="serial_number" class="form-control" 
                                           placeholder="ระบุ S/N ถ้ามี" value="{{ old('serial_number') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">วันที่ซื้อ</label>
                                    <input type="date" name="purchase_date" class="form-control" 
                                           value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold">สถานะเริ่มต้น</label>
                                    <select name="status" class="form-select bg-light">
                                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available (พร้อมใช้งาน)</option>
                                        <option value="in_use" {{ old('status') == 'in_use' ? 'selected' : '' }}>In Use (ถูกมอบหมายแล้ว)</option>
                                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance (ส่งซ่อม)</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold">รูปถ่ายอุปกรณ์</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="asset_image" id="inputGroupFile02">
                                        <label class="input-group-text bg-white" for="inputGroupFile02"><i class="fas fa-upload text-muted"></i></label>
                                    </div>
                                    <div class="form-text mt-1 text-muted small">แนะนำไฟล์ .jpg หรือ .png ไม่เกิน 2MB</div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold">รายละเอียดสเปค / หมายเหตุ</label>
                                    <textarea class="form-control" name="spec_details" rows="3" 
                                              placeholder="ระบุ CPU, RAM, SSD หรือประวัติการซ่อมเดิม...">{{ old('spec_details') }}</textarea>
                                </div>

                                <div class="col-12 mt-4 border-top pt-4 d-flex justify-content-between align-items-center">
                                    <a href="{{ route('assets.index') }}" class="btn btn-link text-decoration-none text-muted">
                                        <i class="fas fa-arrow-left me-1"></i> กลับไปรายการอุปกรณ์
                                    </a>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-success px-5 shadow-sm fw-bold">
                                            <i class="fas fa-save me-1"></i> บันทึกอุปกรณ์
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>