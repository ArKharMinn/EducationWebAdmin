<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function list()
    {
        $student = Student::when(
            request('search'),
            function ($query) {
                $query->orWhere('name', 'like', '%' . request('search') . '%')
                    ->orWhere('student_id', 'like', '%' . request('search') . '%')
                    ->orWhere('email', 'like', '%' . request('search') . '%')
                    ->orWhere('phone', 'like', '%' . request('search') . '%')
                    ->orWhere('address', 'like', '%' . request('search') . '%');
            }
        )
            ->get();
        $studentNavBar = Student::when(
            request('id'),
            function ($query) {
                $query->where('id', 'like', '%' . request('id') . '%');
            }
        )
            ->get();
        $message = Contact::where('student_id', request('id'))
            ->where('teacher_id', Auth::user()->id)
            ->get();

        $adminMessage = Contact::where('student_id', request('id'))
            ->where('admin_id', Auth::user()->id)
            ->get();

        return view('admin.inbox.list', compact('student', 'studentNavBar', 'message', 'adminMessage'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);
        $studentData = Student::where('id', $request->studentId)->first();
        if (Auth::user()->role == 'teacher') {

            $sendData = [
                'message' => $request->message,
                'from_userId' => Auth::user()->teacher_id,
                'teacher_id' => Auth::user()->id,
                'to_userId' => $studentData->student_id,
                'student_id' => $studentData->id
            ];
            Contact::create($sendData);
        } elseif (Auth::user()->role == 'admin') {

            $sendData = [
                'message' => $request->message,
                'from_userId' => Auth::user()->admin_id,
                'admin_id' => Auth::user()->id,
                'to_userId' => $studentData->student_id,
                'student_id' => $studentData->id
            ];
            Contact::create($sendData);
        }
        return back();
    }

    public function delete($id)
    {
        Contact::where('id', $id)->delete();
        return back();
    }
}
