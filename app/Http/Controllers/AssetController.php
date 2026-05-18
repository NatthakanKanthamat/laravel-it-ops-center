<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\User; // ต้องเพิ่มเข้ามาเพื่อให้เรียกใช้ User:: ได้
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AssetController extends Controller
{
    // 1. แสดงหน้ารายการ (ปรับให้แยก Admin / User)
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            // แอดมิน: เห็นอุปกรณ์ทั้งหมดในบริษัท
            $assets = Asset::all();
        } else {
            // ยูสเซอร์: เห็นเฉพาะเครื่องที่มีชื่อตัวเองเป็นผู้รับผิดชอบ
            $assets = Asset::where('user_id', auth()->id())->get();
        }

        return view('assets.index', compact('assets')); 
    }

// 2. แสดงหน้าฟอร์มเพิ่มอุปกรณ์
public function create()
{
    if (auth()->user()->role == 'admin') {
        // แอดมิน: ต้องดึง User "ทุกคน" (all) เพื่อให้เลือกมอบหมายเครื่องได้
        $users = User::all(); 
    } else {
        // ยูสเซอร์ทั่วไป: ดึงมาเฉพาะ "ตัวเอง" เพื่อล็อกค่าไว้
        $users = User::where('id', auth()->id())->get();
    }

    return view('assets.create', compact('users'));
}

   // 3. รับข้อมูลจากฟอร์มมาบันทึก
    public function store(Request $request)
    { 
        $request->validate([
            'asset_tag' => 'required|unique:assets,asset_tag', 
            'name' => 'required',
        ], [
            'asset_tag.unique' => 'หมายเลขอุปกรณ์นี้ถูกใช้ไปแล้ว กรุณาใส่หมายเลขอุปกรณ์ใหม่',
            'name.required' => 'กรุณากรอกชื่ออุปกรณ์',
        ]);

        $data = $request->all();

        // ปรับปรุง: ถ้า Admin เลือกผู้ใช้คนอื่นมา ให้ใช้ค่าจากฟอร์ม (user_id)
        // แต่ถ้าเป็น User ทั่วไปเพิ่มเอง ให้ใช้ ID ตัวเอง
        if (!$request->has('user_id') || auth()->user()->role !== 'admin') {
            $data['user_id'] = auth()->id();
        }
        // จัดการอัปโหลดรูปภาพ (ถ้ามี)
        if ($request->hasFile('asset_image')) {
            $file = $request->file('asset_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
            $data['asset_image'] = $fileName;
        }

        Asset::create($data);
        return redirect()->route('assets.index')->with('success', 'เพิ่มอุปกรณ์เรียบร้อยแล้ว!');
    }

    // 4. แสดงหน้าฟอร์มแก้ไขอุปกรณ์
    public function edit(Asset $asset)
    {
        // เช็คสิทธิ์: ถ้าไม่ใช่ Admin และไม่ใช่เจ้าของเครื่อง ห้ามเข้าหน้าแก้ไข (403)
        if (auth()->user()->role !== 'admin' && $asset->user_id !== auth()->id()) {
            abort(403);
        }

        if (auth()->user()->role == 'admin') {
            $users = User::select('id', 'username')->get();
        } else {
            $users = User::where('id', auth()->id())->select('id', 'username')->get();
        }

        return view('assets.edit', compact('asset', 'users'));
    }

    // 6. อัปเดตข้อมูล (เพิ่ม Validation ป้องกันหน้าแดง)
    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            // unique:assets,asset_tag,ID_ตัวเอง คือการบอกว่า "ซ้ำกับคนอื่นได้ ยกเว้นเลขเดิมของตัวเอง"
            'asset_tag' => 'required|unique:assets,asset_tag,' . $asset->id,
            'name' => 'required',
        ], [
            'asset_tag.unique' => 'หมายเลขอุปกรณ์นี้ถูกใช้โดยเครื่องอื่นแล้ว!',
        ]);

        $data = $request->all();

        // จัดการรูปภาพเวลาอัปเดต (ถ้ามีรูปใหม่ ให้ลบรูปเก่า)
        if ($request->hasFile('asset_image')) {
            if ($asset->asset_image) {
                File::delete(public_path('uploads/' . $asset->asset_image));
            }
            $file = $request->file('asset_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
            $data['asset_image'] = $fileName;
        }

        $asset->update($data);
        return redirect()->route('assets.index')->with('success', 'อัปเดตข้อมูลสำเร็จ!');
    }

    // 7. ฟังก์ชันลบอุปกรณ์
    public function destroy(Asset $asset)
    {
        // 1. ลบรูปภาพออกจากโฟลเดอร์ uploads ก่อน (ถ้ามี)
        if ($asset->asset_image && file_exists(public_path('uploads/' . $asset->asset_image))) {
            File::delete(public_path('uploads/' . $asset->asset_image));
        }

        // 2. ลบข้อมูลจากฐานข้อมูล
        $asset->delete();

        return redirect()->route('assets.index')->with('success', 'ลบข้อมูลอุปกรณ์เรียบร้อยแล้ว!');
    }
}