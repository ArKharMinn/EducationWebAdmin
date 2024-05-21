<?php

namespace App\Http\Controllers\User;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $user = Student::where('email', $request->email)->first();
        if (isset($user)) {
            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'user' => $user,
                    'token' => $user->createToken(time())->plainTextToken
                ]);
            } else {
                return response()->json(['failed' => 'Credential do not match']);
            }
        } else {
            return response()->json(['failed' => 'Credential do not match']);
        }
    }

    public function register(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'student_id' => rand(100000, 999999),
            'password' => Hash::make($request->password),
        ];
        Student::create($data);
        $user = Student::where('email', $request->email)->first();
        return response()->json([
            'user' => $user,
            'token' => $user->createToken(time())->plainTextToken
        ]);
    }

    public function changeProfile(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
        ];
        Student::where('id', $request->id)->update($data);
        return response()->json([
            'update' => 'Profile Successfully Updated'
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = Student::select('password')->where('student_id', $request->id)->first();
        $dbPassword = $user->password;

        if (Hash::check($request->oldPassword, $dbPassword)) {
            $pass = [
                'password' => Hash::make($request->newPassword)
            ];
            Student::where('student_id', $request->id)->update($pass);
            return response()->json([
                'password' => 'Password Successfully Changed'
            ]);
        };

        return response()->json([
            'failed' => 'Credential do not match'
        ]);
    }
}
