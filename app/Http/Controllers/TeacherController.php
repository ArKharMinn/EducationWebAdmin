<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    //
    public function list()
    {
        $teacher = User::where('role', 'teacher')->when(request('search'), function ($query) {
            $query->where('role', 'teacher')
                ->where(function ($query) {
                    $query->orWhere('name', 'like', '%' . request('search') . '%')
                        ->orWhere('email', 'like', '%' . request('search') . '%')
                        ->orWhere('phone', 'like', '%' . request('search') . '%')
                        ->orWhere('teacher_id', 'like', '%' . request('search') . '%');
                });
        })
            ->orderBy('created_at', 'desc')->paginate(20);
        $teacher->appends(request()->all());
        return view('admin.teacherList.list', compact('teacher'));
    }

    public function detail(Request $request)
    {
        $data = User::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function delete(Request $request)
    {
        User::where('id', $request->id)->delete();
        return response()->json();
    }

    public function changeRole(Request $request)
    {
        $data = [
            'role' => 'admin',
            'admin_id' => rand(100000, 999999),
            'teacher_id' => null
        ];
        User::where('id', $request->id)->update($data);
        return response()->json();
    }

    public function add()
    {
        return view('admin.teacherList.addTeacher');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);
        $data = $this->createTeacher($request);
        User::create($data);
        return redirect()->route('teacher#list')->with([
            'status' => 'success'
        ]);
    }

    private function createTeacher($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'role' => 'teacher',
            'password' => Hash::make($request->password),
            'teacher_id' => rand(100000, 999999),
        ];
    }
}
