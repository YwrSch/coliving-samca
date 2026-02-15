<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $conversations = Message::where('from_id', $userId)
            ->orWhere('to_id', $userId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique(function ($msg) use ($userId) {
                return $msg->from_id == $userId ? $msg->to_id : $msg->from_id;
            });

        $view = Auth::user()->role == 'proprietario' ? 'mensagens_proprietario' : 'mensagens';

        return view($view, ['conversations' => $conversations]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'to_id' => 'required|exists:users,id',
            'body' => 'required|string|max:500',
        ]);

        Message::create([
            'from_id' => Auth::id(),
            'to_id' => $request->to_id,
            'body' => $request->body,
            'read' => false
        ]);

        return response()->json(['success' => true]);
    }

    public function show($userId)
    {
        $myId = Auth::id();
        $messages = Message::where(function($q) use ($myId, $userId) {
            $q->where('from_id', $myId)->where('to_id', $userId);
        })
        ->orWhere(function($q) use ($myId, $userId) {
            $q->where('from_id', $userId)->where('to_id', $myId);
        })
        ->orderBy('created_at', 'asc')
        ->get();
        Message::where('from_id', $userId)->where('to_id', $myId)->update(['read' => true]);

        return response()->json($messages);
    }
}