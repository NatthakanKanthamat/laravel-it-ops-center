<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">📝 แก้ไขข้อมูลพนักงาน (Edit User: {{ $user->username }})</h2>
                    </div>

                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" name="username" value="{{ $user->username }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Role (สิทธิ์)</label>
                                <select name="role" class="form-select">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Department (แผนก)</label>
                                <input type="text" name="department" value="{{ $user->department }}" class="form-control">
                            </div>
                        </div>

                        <hr class="my-4">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold text-danger">รหัสผ่านใหม่ (ปล่อยว่างไว้ถ้าไม่ต้องการเปลี่ยน)</label>
                            <input type="password" name="password" class="form-control" placeholder="ใส่รหัสผ่านใหม่ที่นี่">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">บันทึกการแก้ไข</button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary px-4">ยกเลิก</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>