<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">👥 เพิ่มพนักงานใหม่ (Create New User)</h2>
                    </div>

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="กรอกชื่อผู้ใช้งาน" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Role (สิทธิ์การใช้งาน)</label>
                                <select name="role" class="form-select">
                                    <option value="user">User (พนักงานทั่วไป)</option>
                                    <option value="admin">Admin (ผู้ดูแลระบบ)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Department (แผนก)</label>
                                <input type="text" name="department" class="form-control" placeholder="ระบุแผนก">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="กำหนดรหัสผ่านอย่างน้อย 8 ตัวอักษร" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">บันทึกข้อมูล</button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary px-4">ยกเลิก</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>