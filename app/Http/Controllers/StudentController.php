<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function list()
    {
        $student = Student::when(request('search'), function ($query) {
            $query->orWhere('name', 'like', '%' . request('search') . '%')
                ->orWhere('student_id', 'like', '%' . request('search') . '%')
                ->orWhere('email', 'like', '%' . request('search') . '%')
                ->orWhere('phone', 'like', '%' . request('search') . '%')
                ->orWhere('address', 'like', '%' . request('search') . '%');
        })
            ->orderBy('created_at', 'desc')->paginate(10);
        $score = Student::orderBy('score', 'desc')->take(3)->get();
        $student->appends(request()->all());
        return view('admin.studentList.studentList', compact('student', 'score'));
    }

    public function detail(Request $request)
    {
        $data = Student::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function delete(Request $request)
    {
        Student::where('id', $request->id)->delete();
        return response()->json();
    }
}
