<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentUser extends Controller
{
    //
    public function user(Request $request)
    {
        $user = Student::where('student_id', $request->id)->first();
        return response()->json([
            'user' => $user
        ]);
    }
}
