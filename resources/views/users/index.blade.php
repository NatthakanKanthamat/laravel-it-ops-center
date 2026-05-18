<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">👥 รายชื่อพนักงาน (Users List)</h2>
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm shadow-sm">+ เพิ่มพนักงานใหม่</a>
                    </div>

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

                    <div class="table-responsive">
                        <table class="table table-hover align-middle border">
                            <thead class="table-dark">
                                <tr class="text-nowrap">
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Department</th>
                                    <th>วันที่สร้าง</th>
                                    <th>อัปเดตล่าสุด</th>
                                    <th width="150px">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td class="fw-bold">{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 'bg-info text-dark' }}">
                                            {{ strtoupper($user->role) }}
                                        </span>
                                    </td>
                                    <td>{{ $user->department ?? 'ไม่ระบุ' }}</td>
                                    <td class="small text-muted">
                                        {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}
                                    </td>
                                    <td class="small text-muted">
                                        {{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : '-' }}
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบพนักงานคนนี้?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">ลบ</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> </div>
            </div>
        </div>
    </div>
</x-app-layout>