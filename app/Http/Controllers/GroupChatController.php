<?php

namespace App\Http\Controllers;

use App\Models\GroupChat;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupChatController extends Controller
{
    //
    public function list()
    {
        $message = GroupChat::get();
        return view('admin.groupChat.list', compact('message'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);
        $name = User::where('id', Auth::user()->id)->first();
        $data = [
            'user_id' => $request->id,
            'message' => $request->message,
            'user_name' => $name->name
        ];
        GroupChat::create($data);
        return back();
    }

    public function delete($id)
    {
        GroupChat::where('id', $id)->delete();
        return back();
    }
}
