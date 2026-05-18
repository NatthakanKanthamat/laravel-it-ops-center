<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white py-3">
                        <h4 class="mb-0 fw-bold">📝 สร้างใบแจ้งซ่อมใหม่</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('maintenances.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold">เลือกอุปกรณ์ที่มีปัญหา</label>
                                <select name="asset_id" id="asset_select" class="form-select border-success" required>
                                    <option value="">-- เลือกอุปกรณ์ --</option>
                                    @foreach($assets as $asset)
                                        <option value="{{ $asset->id }}" data-user="{{ $asset->user_id }}">
                                            {{ $asset->asset_tag }} - {{ $asset->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">ผู้แจ้งซ่อม</label>
                                {{-- เพิ่ม @if ตรงนี้เพื่อเช็คสิทธิ์ --}}
                                @if(auth()->user()->role == 'admin')
                                    <select name="user_id" id="user_select" class="form-select" required>
                                        <option value="">-- เลือกผู้แจ้งซ่อม --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" @selected(auth()->id() == $user->id)>
                                                {{ $user->username }} ({{ $user->role }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text text-primary small">ชื่อจะเปลี่ยนอัตโนมัติตามเจ้าของอุปกรณ์ (แต่แอดมินแก้ไขได้)</div>
                                @else
                                    {{-- ถ้าไม่ใช่ Admin ให้แสดงชื่อตัวเองแบบแก้ไขไม่ได้ --}}
                                    <input type="text" class="form-control bg-light" value="{{ auth()->user()->username }}" readonly>
                                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">รายละเอียดอาการเสีย</label>
                                <textarea id="symptom_input" name="description" class="form-control" rows="3" placeholder="ระบุอาการเสียที่พบ..." oninput="checkKeywords()" required></textarea>
                            </div>

                            <div id="hint-box" class="alert alert-info d-none mt-3" style="border-left: 5px solid #0dcaf0;">
                                <strong class="text-info"><i class="fas fa-info-circle"></i> แนะนำวิธีแก้ไขเบื้องต้น </strong>
                                <p id="hint-text" class="mb-0 mt-2 text-dark"></p>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">ความเร่งด่วน</label>
                                <select name="priority" class="form-select">
                                    <option value="Low">Low (ทั่วไป)</option>
                                    <option value="Medium" selected>Medium (ปานกลาง)</option>
                                    <option value="High">High (ด่วนมาก)</option>
                                </select>
                            </div>

                            <div class="d-flex gap-2 pt-3 border-top">
                                <button type="submit" class="btn btn-success px-4 fw-bold shadow-sm">บันทึกข้อมูล</button>
                                <a href="{{ route('maintenances.index') }}" class="btn btn-outline-secondary px-4">กลับหน้า Dashboard</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script ส่วน Admin --}}
    @if(auth()->user()->role == 'admin')
    <script>
        document.getElementById('asset_select').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var ownerId = selectedOption.getAttribute('data-user');
            var userSelect = document.getElementById('user_select');
            
            if (userSelect) {
                userSelect.value = ownerId ? ownerId : "";
            }
        });
    </script>
    @endif

    {{-- Script แนะนำวิธีแก้เบื้องต้น --}}
    <script>
        function checkKeywords() {
            var input = document.getElementById('symptom_input');
            var box = document.getElementById('hint-box');
            var display = document.getElementById('hint-text');

            if (!input || !box || !display) return;

            var val = input.value;

            if (val.includes("จอ")) {
                display.innerText = "หากจอเป็นเส้นหรือกระพริบ 1.ลองขยับสายสัญญาณหลังเครื่องให้แน่นหรือเช็ควินโดว์อัพเดตเวอร์ชั่นล่าสุด 2.ถอดอุปกรณ์ทั้งหมดจากนั้นลองกดปุ่ม Power ค้างไว้ 15 วินาทีเพื่อเคลียร์ไฟค้าง แล้วเปิดใหม่";
                box.classList.remove('d-none');
            } else if (val.includes("ไฟ") || val.includes("ไม่ติด") || val.includes("ชาร์ทไฟไม่เข้า")) {
                display.innerText = "ถอดอุปกรณ์ทั้งหมดจากนั้นลองกดปุ่ม Power ค้างไว้ 15 วินาทีเพื่อเคลียร์ไฟค้าง";
                box.classList.remove('d-none');
            }else if (val.includes("คีย์บอร์ด") || val.includes("ปุ่มกด")) {
                display.innerText = "1.เช็ควินโดว์อัพเดตเวอร์ชั่นล่าสุด 2.ถอดอุปกรณ์ทั้งหมดจากนั้นลองกดปุ่ม Power ค้างไว้ 15 วินาทีเพื่อเคลียร์ไฟค้าง แล้วเปิดใหม่ครับ 3.ลองถอดคีย์บอร์ดแล้วเสียบใหม่ครับ";
                box.classList.remove('d-none');
            } else if (val.includes("เน็ต") || val.includes("internet") || val.includes("wifi")) {
                display.innerText = "หากเข้าเน็ตไม่ได้ ลองปิด-เปิด Wi-Fi ที่ตัวเครื่อง หรือเช็กสาย LAN ว่าเสียบแน่นดีหรือไม่";
                box.classList.remove('d-none');
            } else if (val.includes("ช้า") || val.includes("ค้าง") || val.includes("อืด")) {
                display.innerText = "หากเครื่องทำงานช้า ลองปิดโปรแกรมที่ไม่ใช้งาน หรือลอง Restart เครื่องเพื่อเคลียร์ Memory";
                box.classList.remove('d-none');
            } else {
                box.classList.add('d-none');
            }
        }
    </script>
</x-app-layout>