<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $users = \App\Models\User::all();
    return view('users.index', compact('users'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
{
    
    $request->validate([
        'username' => 'required|unique:users,username|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'department' => 'nullable',
        'role' => 'required'
    ], [
        'username.unique' => 'ชื่อผู้ใช้นี้ถูกใช้แล้ว',
        'email.unique' => 'อีเมลนี้ถูกใช้แล้ว',
    ]);

    \App\Models\User::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => bcrypt($request->password), // สำคัญมาก: ต้องใช้ bcrypt หรือ Hash::make
        'department' => $request->department ?? 'General', // ถ้าไม่ได้กรอกแผนกจะเป็น null
        'role' => $request->role,
    ]);

    return redirect()->route('users.index')->with('success', 'เพิ่มพนักงานเรียบร้อย');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
    
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            // รหัสผ่านไม่ต้องตรวจถ้าไม่ได้กรอกใหม่
        ], [
            'username.unique' => 'ชื่อผู้ใช้นี้ถูกใช้แล้ว',

        ]);

        $data = $request->only(['username', 'email', 'role', 'department']);
    

        // ถ้ามีการกรอกรหัสผ่านใหม่ค่อยอัปเดต
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'อัปเดตข้อมูลพนักงานแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('users.index')->with('success', 'ลบข้อมูลพนักงานแล้ว');
    }
}
