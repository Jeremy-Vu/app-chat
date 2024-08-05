<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('chat', compact('users'));
    }

    public function message(Request $request)
    {
        $user = Auth::user();

        $messages = $user?->messages()->create([
            'message' => $request->message
        ]);
        broadcast(new MessageSent($user, $messages))->toOthers();

        return $request->message;
    }

    public function allMessage()
    {
        return Message::with('user')->get();
    }

    public function loadMessage($userId)
    {
        $user = User::query()->find($userId);
        return $user?->messages()->with(['user'])->get();
    }


}
