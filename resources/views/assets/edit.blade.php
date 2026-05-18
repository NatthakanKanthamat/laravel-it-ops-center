<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">🛠 แก้ไขข้อมูลอุปกรณ์ (Edit Asset: {{ $asset->asset_tag }})</h2>
                    </div>

                    <form action="{{ route('assets.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Asset Tag</label>
                                <input type="text" name="asset_tag" value="{{ old('asset_tag', $asset->asset_tag) }}" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Serial Number</label>
                                <input type="text" name="serial_number" value="{{ old('serial_number', $asset->serial_number) }}" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">ชื่ออุปกรณ์</label>
                            <input type="text" name="name" value="{{ old('name', $asset->name) }}" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">หมวดหมู่</label>
                                <select name="category" class="form-select">
                                    <option value="PC" {{ $asset->category == 'PC' ? 'selected' : '' }}>PC</option>
                                    <option value="Laptop" {{ $asset->category == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                                    <option value="Monitor" {{ $asset->category == 'Monitor' ? 'selected' : '' }}>Monitor</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">สถานะ</label>
                                <select name="status" class="form-select">
                                    <option value="available" {{ $asset->status == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="in_use" {{ $asset->status == 'in_use' ? 'selected' : '' }}>In Use</option>
                                    <option value="maintenance" {{ $asset->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">วันที่ซื้อ</label>
                                <input type="date" name="purchase_date" value="{{ $asset->purchase_date }}" class="form-control" required>
                            </div>
                        </div>

                        @if(auth()->user()->role == 'admin')
                            <div class="mb-3">
                                <label class="form-label fw-bold">ผู้ดูแลอุปกรณ์ (Assign to)</label>
                                <select name="user_id" class="form-select">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $asset->user_id == $user->id ? 'selected' : '' }}>
                                         {{ $user->username }}
                                         </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-bold">รายละเอียด/สเปคอุปกรณ์</label>
                            <textarea class="form-control" name="spec_details" rows="3">{{ $asset->spec_details }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">รูปอุปกรณ์ (อัปโหลดใหม่เพื่อเปลี่ยน)</label>
                            @if($asset->asset_image)
                                <div class="mb-2">
                                    <img src="{{ asset('uploads/' . $asset->asset_image) }}" alt="Current Image" style="height: 100px;" class="img-thumbnail">
                                </div>
                            @endif
                            <input type="file" name="asset_image" class="form-control">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning px-4 fw-bold">อัปเดตข้อมูล</button>
                            <a href="{{ route('assets.index') }}" class="btn btn-secondary px-4">ยกเลิก</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>