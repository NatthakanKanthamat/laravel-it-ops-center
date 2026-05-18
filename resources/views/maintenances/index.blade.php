<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ส่วนการแจ้งเตือน SweetAlert --}}
            @if(session('success') || session('error'))
                <script>
                    Swal.fire({
                        icon: "{{ session('success') ? 'success' : 'error' }}",
                        title: "{{ session('success') ? 'สำเร็จ!' : 'ดำเนินการแล้ว!' }}",
                        text: "{{ session('success') ?? session('error') }}",
                        showConfirmButton: false,
                        timer: 3000
                    });
                </script>
            @endif

            {{-- 1. ส่วนหัว (Header) แยกตามสิทธิ์ --}}
            @if(auth()->user()->role == 'admin')
                <div class="mb-4">
                    <h1 class="h3 fw-bold text-gray-800">📊 Dashboard แจ้งซ่อมอุปกรณ์ IT</h1>
                    <p class="text-muted">สรุปภาพรวมการแจ้งซ่อมอุปกรณ์ IT ทั้งหมดในระบบ</p>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card bg-primary text-white shadow border-0">
                            <div class="card-body">
                                <h5 class="card-title opacity-75">รายการทั้งหมด</h5>
                                <h2 class="display-6 fw-bold">{{ $maintenances->count() }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-warning text-dark shadow border-0">
                            <div class="card-body">
                                <h5 class="card-title opacity-75">รอดำเนินการ (Pending)</h5>
                                <h2 class="display-6 fw-bold">{{ $maintenances->where('status', 'Pending')->count() }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-danger text-white shadow border-0">
                            <div class="card-body">
                                <h5 class="card-title opacity-75">งานด่วน (High)</h5>
                                <h2 class="display-6 fw-bold">{{ $maintenances->where('priority', 'High')->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white p-4 rounded shadow-sm mb-4">
                    <h4 class="fw-bold">สวัสดีคุณ {{ auth()->user()->username }} 👋</h4>
                    <p class="mb-0 text-muted">คุณสามารถตรวจสอบสถานะการแจ้งซ่อมอุปกรณ์ของคุณได้ที่ตารางด้านล่าง</p>
                </div>
            @endif

            {{-- 2. ส่วนตารางข้อมูล --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h5 mb-0 fw-bold">📋 รายการแจ้งซ่อม (Summary)</h2>
                        <a href="{{ route('maintenances.create') }}" class="btn btn-success btn-sm shadow-sm">+ แจ้งซ่อมใหม่</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle border">
                            <thead class="table-dark">
                                <tr class="text-nowrap">
                                    <th>ID</th>
                                    <th>อุปกรณ์</th>
                                    <th>ผู้แจ้ง</th>
                                    <th>อาการเสีย</th>
                                    <th class="text-center">ความเร่งด่วน</th>
                                    <th class="text-center">สถานะ</th>
                                    <th>วันที่แจ้ง</th>
                                    @if(auth()->user()->role == 'admin')
                                        <th class="text-center">จัดการ</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($maintenances as $maintenance)
                                <tr>
                                    <td>{{ $maintenance->id }}</td>
                                    <td class="fw-bold">{{ $maintenance->asset->name ?? 'N/A' }}</td>
                                    <td>{{ $maintenance->user->username ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($maintenance->description, 50) }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $maintenance->priority == 'High' ? 'bg-danger' : ($maintenance->priority == 'Medium' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                            {{ $maintenance->priority }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill bg-info text-dark">
                                            {{ $maintenance->status }}
                                        </span>
                                    </td>
                                    <td class="small text-muted text-nowrap">
                                        {{ $maintenance->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    
                                    @if(auth()->user()->role == 'admin')
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('maintenances.edit', $maintenance->id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                            <form action="{{ route('maintenances.destroy', $maintenance->id) }}" method="POST" onsubmit="return confirm('ยืนยันการลบใบแจ้งซ่อม?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">ลบ</button>
                                            </form>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>