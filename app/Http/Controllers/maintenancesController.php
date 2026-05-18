<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\User;
use App\Models\Maintenances; 

class MaintenancesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->check()) {
            
            // ดึงข้อมูลแจ้งซ่อมพร้อมความสัมพันธ์กับ Asset และ User
            $query = Maintenances::with(['asset', 'user']);

            if (auth()->user()->role == 'admin') {
                $maintenances = $query->latest()->get();
            } else {
                $maintenances = $query->where('user_id', auth()->id())->latest()->get();
            }
        } else {
            return redirect()->route('login');
        }

        return view('maintenances.index', compact('maintenances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $user = auth()->user();

    // เช็คสิทธิ์ Admin 
    if ($user->role === 'admin') {
        // แอดมิน: ต้องดึง User ทุกคน และ Asset ทุกชิ้น
        $users = \App\Models\User::all();
        $assets = \App\Models\Asset::all();
    } else {
        // ยูสเซอร์ทั่วไป: ดึงแค่ตัวเอง และ Asset ที่ตัวเองถืออยู่
        $users = \App\Models\User::where('id', $user->id)->get();
        $assets = \App\Models\Asset::where('user_id', $user->id)->get();
    }

    
    return view('maintenances.create', compact('users', 'assets'));
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required',
            'description' => 'required',
            'priority' => 'required',
        ]);

        
        Maintenances::create([
            'asset_id' => $request->asset_id,
            'user_id' => auth()->id(), // แนะนำให้ใช้ id คนล็อกอินแจ้งเองอัตโนมัติ
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'Pending',
        ]);

        $asset = Asset::find($request->asset_id);
        if ($asset) {
            $asset->update(['status' => 'maintenance']);
        }

        return redirect()->route('maintenances.index')->with('success', 'บันทึกข้อมูลแจ้งซ่อมแล้ว');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $maintenance = Maintenances::findOrFail($id);
        $assets = Asset::all();
        $users = User::all();
        return view('maintenances.edit', compact('maintenance', 'assets', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'asset_id' => 'required',
            'priority' => 'required',
            'status' => 'required',
            'description' => 'required',
        ]);

        $maintenance = Maintenances::findOrFail($id);
        $maintenance->update($request->all());

        // ถ้าซ่อมเสร็จแล้ว ให้คืนสถานะอุปกรณ์
        if ($request->status == 'Completed') {
            $asset = Asset::find($maintenance->asset_id);
            if ($asset) {
                $asset->update(['status' => 'available']);
            }
        }

        return redirect()->route('maintenances.index')->with('success', 'อัปเดตข้อมูลแจ้งซ่อมแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $maintenance = Maintenances::findOrFail($id);
        $maintenance->delete();

        return redirect()->route('maintenances.index')->with('error', 'ลบข้อมูลแจ้งซ่อมแล้ว');
    }

 
}