<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $currentUser = Auth::user();
        $contacts = User::query()
            ->whereKeyNot($currentUser->id)
            ->orderByRaw('is_admin desc')
            ->orderBy('name')
            ->get();

        $selectedUserId = (int) ($request->query('user') ?: ($contacts->first()->id ?? 0));
        $selectedUser = $contacts->firstWhere('id', $selectedUserId);

        $messages = collect();
        if ($selectedUser) {
            $messages = Message::with(['sender', 'recipient'])
                ->betweenUsers($currentUser->id, $selectedUser->id)
                ->orderBy('id')
                ->get();
        }

        return view('chat.index', compact('contacts', 'selectedUser', 'messages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'body' => 'required|string|max:500',
            'recipient_id' => 'required|exists:users,id',
        ]);

        $message = Message::create([
            'user_id' => Auth::id(),
            'recipient_id' => (int) $data['recipient_id'],
            'body' => $data['body'],
        ]);

        if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'id' => $message->id]);
        }

        return redirect()->route('chat.index', ['user' => $data['recipient_id']]);
    }

    public function poll(Request $request)
    {
        $data = $request->validate([
            'since' => 'nullable|integer|min:0',
            'user' => 'required|exists:users,id',
        ]);

        $since = (int) ($data['since'] ?? 0);
        $otherUserId = (int) $data['user'];

        $messages = Message::with('sender')
            ->betweenUsers(Auth::id(), $otherUserId)
            ->where('id', '>', $since)
            ->orderBy('id')
            ->get()
            ->map(fn($m) => [
                'id' => $m->id,
                'body' => e($m->body),
                'user' => $m->sender?->name,
                'me' => $m->user_id === Auth::id(),
                'time' => $m->created_at->format('H:i'),
            ]);

        return response()->json($messages);
    }
}
