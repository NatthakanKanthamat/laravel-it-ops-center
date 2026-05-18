<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-xl sm:rounded-lg border-0 overflow-hidden">
                
                {{-- ส่วนหัว: ใช้สีเขียวเรียบๆ --}}
                <div class="p-4 bg-success text-white">
                    <h4 class="mb-0 fw-bold">📝 อัพเดตใบแจ้งซ่อม</h4>
                </div>

                <div class="p-6">
                    {{-- ตรวจสอบว่ามี Error แจ้งเตือนไหม --}}
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('maintenances.update', $maintenance->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- อุปกรณ์ --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">อุปกรณ์ที่มีปัญหา</label>
                            <select name="asset_id" class="form-select border-light-subtle bg-light" required>
                                @foreach($assets as $asset)
                                    <option value="{{ $asset->id }}" @selected($maintenance->asset_id == $asset->id)>
                                        {{ $asset->asset_tag }} - {{ $asset->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- ผู้แจ้ง --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">ผู้แจ้งซ่อม</label>
                            <select name="user_id" class="form-select border-light-subtle bg-light" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @selected($maintenance->user_id == $user->id)>
                                        {{ $user->username }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- อาการเสีย --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">รายละเอียดอาการเสีย</label>
                            <textarea name="description" class="form-control border-light-subtle" rows="3" required>{{ $maintenance->description }}</textarea>
                        </div>

                        {{-- เพิ่มส่วน Priority --}}
<div class="mb-4">
    <label class="form-label fw-bold">ระดับความสำคัญ (Priority)</label>
    <select name="priority" class="form-select" required>
        <option value="Low" @selected($maintenance->priority == 'Low')>ต่ำ (Low)</option>
        <option value="Medium" @selected($maintenance->priority == 'Medium')>ปานกลาง (Medium)</option>
        <option value="High" @selected($maintenance->priority == 'High')>สูง (High)</option>
    </select>
</div>

                        {{-- สถานะ: --}}
                        <div class="mb-4 pt-3 border-top">
                            <label class="form-label fw-bold text-primary">สถานะการซ่อม (Status)</label>
                            <select name="status" class="form-select border-primary-subtle shadow-sm" style="border-width: 2px;">
                                <option value="Pending" @selected($maintenance->status == 'Pending')>🟡 รอดำเนินการ</option>
                                <option value="In Progress" @selected($maintenance->status == 'In Progress')>🔵 กำลังดำเนินการ</option>
                                <option value="Completed" @selected($maintenance->status == 'Completed')>🟢 ซ่อมเสร็จสิ้น</option>
                            </select>
                        </div>

                        {{-- ปุ่มกด --}}
                        <div class="d-flex items-center justify-content-end gap-2 pt-4 border-t mt-4">
                            <a href="{{ route('maintenances.index') }}" class="btn btn-light px-4 border">ยกเลิก</a>
                            <button type="submit" class="btn btn-success px-5 fw-bold shadow-sm">บันทึกการแก้ไข</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>