<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\GroupChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InboxController extends Controller
{
    //
    public function inbox(Request $request)
    {
        $admin = User::where('role', 'admin')->first();
        $inboxMessage = Contact::where('to_userId', $request->id)
            ->where('admin_id', $admin->id)
            ->where('from_userId', $admin->admin_id)
            ->get();

        return response()->json([
            'inboxMessage' => $inboxMessage
        ]);
    }

    public function groupChat()
    {
        $message = GroupChat::get();

        return response()->json([
            'message' => $message
        ]);
    }

    public function sendMessage(Request $request)
    {
        $data = [
            'user_id' => $request->id,
            'message' => $request->message,
            'user_name' => $request->name
        ];
        GroupChat::create($data);
        return response()->json();
    }

    public function deleteGroupChatMessage(Request $request)
    {
        GroupChat::where('id', $request->id)->delete();
        return response()->json([
            'messageDelete' => 'successfully deleted'
        ]);
    }
}
