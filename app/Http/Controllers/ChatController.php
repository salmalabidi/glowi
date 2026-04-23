<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $messages = Message::with('user')->latest()->take(60)->get()->reverse()->values();
        return view('chat.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string|max:500',
        ]);

        Message::create([
            'user_id' => Auth::id(),
            'body'    => $request->body,
        ]);

        return back();
    }

    /**
     * AJAX — retourne les nouveaux messages depuis un id donné.
     */
    public function poll(Request $request)
    {
        $since = $request->query('since', 0);

        $messages = Message::with('user')
            ->where('id', '>', $since)
            ->orderBy('id')
            ->get()
            ->map(fn($m) => [
                'id'     => $m->id,
                'body'   => e($m->body),
                'user'   => $m->user->name,
                'me'     => $m->user_id === Auth::id(),
                'time'   => $m->created_at->format('H:i'),
            ]);

        return response()->json($messages);
    }
}
