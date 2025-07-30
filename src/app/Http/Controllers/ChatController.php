<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class ChatController extends Controller
{
    public function index()
    {
        $messages = Message::with('user')->latest()->limit(50)->get()->reverse();
        return view('chat', compact('messages'));
    }

    public function send(Request $request)
    {
        $message = Message::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($message->load('user')))->toOthers();

        Redis::set('last_message', $message->message);

        return ['status' => 'Message Sent!'];
    }
}
