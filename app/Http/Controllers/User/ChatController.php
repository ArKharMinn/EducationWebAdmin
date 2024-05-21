<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    //
    public function teacher()
    {
        $teacher = User::where('role', 'teacher')->get();
        return response()->json([
            'teacher' => $teacher
        ]);
    }

    public function chatTeacher(Request $request)
    {
        $chatTeacher = User::where('teacher_id', $request->id)->get();
        return response()->json([
            'chatTeacher' => $chatTeacher
        ]);
    }

    public function searchChat(Request $request)
    {
        $search = User::where('name', 'like', '%' . $request->search . '%')
            ->where('role', 'teacher')
            ->get();
        return response()->json([
            'search' => $search
        ]);
    }

    public function contactTeacher(Request $request)
    {
        $message = [
            'to_userId' => $request->toUserId,
            'from_userId' => $request->fromUserId,
            'message' => $request->message,
            'teacher_id' => $request->teacherIdDb,
            'student_id' => $request->studentId
        ];
        Contact::create($message);
        return response()->json();
    }

    public function chatList(Request $request)
    {
        $allMessage = Contact::where('to_userId', $request->teacherId)
            ->orWhere('from_userId', $request->teacherId)
            ->orWhere('from_userId', $request->student_id)
            ->select(
                'contacts.*',
                'users.name as teacherName',
                'users.image as teacherImage',
                'students.name as studentName',
                'students.image as studentImage'
            )
            ->join('users', 'users.id', 'contacts.teacher_id')
            ->join('students', 'students.id', 'contacts.student_id')
            ->get();
        return response()->json([
            'allMessage' => $allMessage
        ]);
    }

    public function deleteMessage(Request $request)
    {
        Contact::where('id', $request->id)->delete();
        return response()->json([
            'messageDelete' => 'successfully deleted'
        ]);
    }
}
