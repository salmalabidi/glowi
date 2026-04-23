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
        $me = Auth::user();

        $contacts = User::query()
            ->where('id', '!=', $me->id)
            ->orderBy('name')
            ->get()
            ->map(function ($user) use ($me) {
                $lastMessage = Message::betweenUsers($me->id, $user->id)
                    ->latest('created_at')
                    ->first();

                $user->unread_count = Message::query()
                    ->where('user_id', $user->id)
                    ->where('recipient_id', $me->id)
                    ->where('is_read', false)
                    ->count();

                $user->last_message_at = optional($lastMessage)->created_at;
                $user->last_message_body = optional($lastMessage)->body;

                return $user;
            })
            ->sortByDesc(function ($user) {
                return optional($user->last_message_at)->timestamp ?? 0;
            })
            ->values();

        $selectedUser = null;
        $messages = collect();

        if ($request->filled('user')) {
            $selectedUser = User::findOrFail($request->integer('user'));

            $messages = Message::betweenUsers($me->id, $selectedUser->id)
                ->with(['sender', 'recipient'])
                ->orderBy('created_at')
                ->get();

            Message::query()
                ->where('user_id', $selectedUser->id)
                ->where('recipient_id', $me->id)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        $totalUnread = Message::query()
            ->where('recipient_id', $me->id)
            ->where('is_read', false)
            ->count();

        return view('chat.index', compact('contacts', 'selectedUser', 'messages', 'totalUnread'));
    }

    public function poll(Request $request)
    {
        $request->validate([
            'user' => ['required', 'integer', 'exists:users,id'],
        ]);

        $me = Auth::user();
        $otherUserId = (int) $request->user;

        $messages = Message::betweenUsers($me->id, $otherUserId)
            ->with(['sender', 'recipient'])
            ->orderBy('created_at')
            ->get()
            ->map(function ($message) use ($me) {
                return [
                    'id' => $message->id,
                    'body' => $message->body,
                    'time' => $message->created_at?->format('H:i'),
                    'mine' => (int) $message->user_id === (int) $me->id,
                    'sender_name' => $message->sender?->name,
                ];
            });

        Message::query()
            ->where('user_id', $otherUserId)
            ->where('recipient_id', $me->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $contacts = User::query()
            ->where('id', '!=', $me->id)
            ->orderBy('name')
            ->get()
            ->map(function ($user) use ($me) {
                return [
                    'id' => $user->id,
                    'unread_count' => Message::query()
                        ->where('user_id', $user->id)
                        ->where('recipient_id', $me->id)
                        ->where('is_read', false)
                        ->count(),
                ];
            });

        $totalUnread = Message::query()
            ->where('recipient_id', $me->id)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'contacts' => $contacts,
            'total_unread' => $totalUnread,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'recipient_id' => ['required', 'integer', 'exists:users,id', 'different:' . Auth::id()],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $message = Message::create([
            'user_id' => Auth::id(),
            'recipient_id' => $data['recipient_id'],
            'body' => trim($data['body']),
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'body' => $message->body,
                'time' => $message->created_at?->format('H:i'),
                'mine' => true,
                'sender_name' => Auth::user()->name,
            ],
        ]);
    }

    public function unreadCount()
    {
        $count = Message::query()
            ->where('recipient_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }
}
