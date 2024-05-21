<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Post;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    //
    public function login()
    {
        return view('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function check()
    {
        return view('check');
    }

    public function register()
    {
        return view('register');
    }

    public function dashboard()
    {
        $student = Student::latest()->take(5)->get();
        $teacher = User::where('role', 'teacher')->latest()->take(5)->get();
        $admin = User::where('role', 'admin')->latest()->take(5)->get();
        $quiz = Exam::get();
        $course = Post::get();
        return view('admin.home.dashboard', compact('student', 'teacher', 'admin', 'course', 'quiz'));
    }

    public function teacher(Request $request)
    {
        $teacher = User::where('id', $request->id)->get();
        return $teacher;
    }

    public function student(Request $request)
    {
        $student = Student::where('id', $request->id)->get();
        return $student;
    }

    public function list()
    {
        $admin = User::orderBy('created_at', 'desc')
            ->when(request('search'), function ($query) {
                $query->where('role', 'admin')
                    ->where(function ($query) {
                        $query->orWhere('name', 'like', '%' . request('search') . '%')
                            ->orWhere('email', 'like', '%' . request('search') . '%')
                            ->orWhere('phone', 'like', '%' . request('search') . '%')
                            ->orWhere('admin_id', 'like', '%' . request('search') . '%');
                    });
            })
            ->where('role', 'admin')
            ->paginate(10);
        $admin->appends(request()->all());
        $isAdmin = Auth::user()->role;
        return view('admin.adminList.list', compact('admin', 'isAdmin'));
    }

    public function detail(Request $request)
    {
        $user = User::where('id', $request->id)->get();
        return response()->json($user);
    }

    public function delete(Request $request)
    {
        User::where('id', $request->id)->delete();
        return response()->json();
    }

    public function manage()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('admin.settings.manage', compact('user'));
    }

    public function editProfile()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('admin.settings.editProfile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $data = $this->profileUpdate($request);
        if ($request->hasFile('image')) {
            $dbImage = Auth::user()->image;

            if ($dbImage) {
                Storage::delete('public/' . $dbImage);
            };

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        };
        User::where('id', Auth::user()->id)->update($data);
        return redirect()->route('setting#manage')->with([
            'editProfile' => 'success'
        ]);
    }

    public function deletepp($id)
    {
        $user = User::where('id', $id)->first();
        if ($user->image) {
            Storage::delete('public/' . $user->image);
            $user->image = null;
            $user->save();
        };
        return back();
    }

    public function change(Request $request)
    {
        $user = User::select('password')->where('id', Auth::user()->id)->first();
        $dbPassword = $user->password;
        $request->validate([
            'oldPassword'  => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword',
        ]);

        if (Hash::check($request->oldPassword, $dbPassword)) {
            $pass = [
                'password' => Hash::make($request->newPassword)
            ];
            User::where('id', Auth::user()->id)->update($pass);
            return redirect()->route('setting#editProfile')->with([
                'change' => 'success'
            ]);
        };

        return back()->with([
            'status' => 'fail'
        ]);
    }

    public function deleteAcc(Request $request)
    {
        User::where('id', $request->id)->delete();
        return response()->json();
    }

    public function changeRole(Request $request)
    {
        $data = [
            'role' => 'teacher',
            'admin_id' => null,
            'teacher_id' => rand(100000, 999999),
        ];
        User::where('id', $request->id)->update($data);
        return response()->json();
    }

    private function profileUpdate($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'updated_at' => Carbon::now()
        ];
    }
}
