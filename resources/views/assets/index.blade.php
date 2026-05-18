<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">📦 รายการอุปกรณ์ไอที (IT Assets)</h2>
                        <a href="{{ route('assets.create') }}" class="btn btn-primary btn-sm shadow-sm">+ เพิ่มอุปกรณ์</a>
                    </div>

                    @if(session('success') || session('error'))
                        <script>
                            Swal.fire({
                                icon: "{{ session('success') ? 'success' : 'error' }}",
                                title: "{{ session('success') ? 'สำเร็จ!' : 'ลบข้อมูลแล้ว!' }}",
                                text: "{{ session('success') ?? session('error') }}",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle border">
                            <thead class="table-dark">
                                <tr class="text-nowrap">
                                    <th>ลำดับ</th>
                                    <th>Asset Tag</th>
                                    <th>ชื่ออุปกรณ์</th>
                                    <th>หมวดหมู่</th>
                                    <th>วันที่ซื้อ</th>
                                    <th>Serial Number</th>
                                    <th>สถานะ</th>
                                    <th>ผู้ใช้งาน</th>
                                    <th>รูปอุปกรณ์</th>
                                    <th>รายละเอียด</th>
                                    <th>วันที่เพิ่ม</th>
                                    <th width="120px">จัดการ</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assets as $asset)
                                    <tr>
                                        <td>{{ $asset->id }}</td>
                                        <td class="fw-bold">{{ $asset->asset_tag }}</td>
                                        <td>{{ $asset->name }}</td>
                                        <td><span class="badge bg-info text-dark">{{ $asset->category }}</span></td>
                                        <td>{{ $asset->purchase_date }}</td>
                                        <td><code>{{ $asset->serial_number }}</code></td>
                                        <td>
                                            <span class="badge {{ $asset->status == 'Ready' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $asset->status }}
                                            </span>
                                        </td>
                                        <td>{{ $asset->user ? $asset->user->username : 'ส่วนกลาง' }}</td>
                                        <td>
                                            @if($asset->asset_image)
                                                <img src="{{ asset('uploads/' . $asset->asset_image) }}" 
                                                     style="width: 60px; height: 45px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                            @else
                                                <span class="text-muted small italic">No Image</span>
                                            @endif
                                        </td>
                                        <td class="small">{{ Str::limit($asset->spec_details, 30) }}</td>
                                        <td class="small text-muted">{{ $asset->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @if(auth()->user()->role == 'admin')
                                            <div class="btn-group">
                                                <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                                <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('แน่ใจนะว่าจะลบ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">ลบ</button>
                                                </form>
                                            </div>
                                            @else
                                                @if($asset->user_id == auth()->id())
                                                    <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center py-4 text-muted">ไม่พบข้อมูลอุปกรณ์ในฐานข้อมูล</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div> </div>
            </div>
        </div>
    </div>
</x-app-layout>