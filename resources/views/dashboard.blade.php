<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 bg-white h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="fas fa-laptop text-primary fs-3"></i>
                        </div>
                        <div>
                            <!-- ปรับข้อความตาม Role -->
                            <p class="text-muted mb-1">{{ Auth::user()->role === 'admin' ? 'อุปกรณ์ทั้งหมดในระบบ' : 'อุปกรณ์ในการดูแลของคุณ' }}</p>
                            <h3 class="mb-0 fw-bold">{{ $assetsCount }} รายการ</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 bg-white h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="fas fa-tools text-warning fs-3"></i>
                        </div>
                        <div>
                            <!-- ปรับข้อความตาม Role -->
                            <p class="text-muted mb-1">{{ Auth::user()->role === 'admin' ? 'งานซ่อมรอดำเนินการทั้งหมด' : 'งานซ่อมของคุณที่รอดำเนินการ' }}</p>
                            <h3 class="mb-0 fw-bold">{{ $pendingMaintenances }} งาน</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 bg-white h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="fas fa-user-check text-success fs-3"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">ยินดีต้อนรับคุณ</p>
                            <h3 class="mb-0 fw-bold">{{ Auth::user()->username }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-0 p-6">
            <h4 class="fw-bold mb-4">ทางลัดการใช้งาน</h4>
            <div class="row text-center">
                <!-- 1. แจ้งซ่อมใหม่ (เห็นทุกคน) -->
                <div class="col-6 col-md-3 mb-3">
                    <a href="{{ route('maintenances.create') }}" class="text-decoration-none">
                        <div class="p-3 border rounded-3 hover-shadow transition">
                            <i class="fas fa-plus-circle text-primary fs-2 mb-2"></i>
                            <div class="text-dark">แจ้งซ่อมใหม่</div>
                        </div>
                    </a>
                </div>

                <!-- 2. ดูอุปกรณ์ (ชื่อปุ่มเปลี่ยนตามสิทธิ์) -->
                <div class="col-6 col-md-3 mb-3">
                    <a href="{{ route('assets.index') }}" class="text-decoration-none">
                        <div class="p-3 border rounded-3 hover-shadow transition">
                            <i class="fas fa-list text-secondary fs-2 mb-2"></i>
                            <div class="text-dark">
                                {{ Auth::user()->role === 'admin' ? 'จัดการอุปกรณ์ทั้งหมด' : 'ดูอุปกรณ์ของฉัน' }}
                            </div>
                        </div>
                    </a>
                </div>

                <!-- 3. จัดการพนักงาน (เฉพาะ Admin เท่านั้นถึงจะเห็น) -->
                @if(Auth::user()->role === 'admin')
                <div class="col-6 col-md-3 mb-3">
                    <a href="{{ route('users.index') }}" class="text-decoration-none">
                        <div class="p-3 border rounded-3 hover-shadow transition">
                            <i class="fas fa-user-cog text-info fs-2 mb-2"></i>
                            <div class="text-dark">จัดการพนักงาน</div>
                        </div>
                    </a>
                </div>
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>