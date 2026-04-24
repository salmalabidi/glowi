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
        $authId = Auth::id();
        $selectedUser = null;
        $messages = collect();

        $contacts = $this->getContacts($authId);

        $totalUnread = Message::where('recipient_id', $authId)
            ->where('is_read', false)
            ->count();

        if ($request->filled('user')) {
            $selectedUser = User::findOrFail($request->user);

            Message::where('user_id', $selectedUser->id)
                ->where('recipient_id', $authId)
                ->where('is_read', false)
                ->update(['is_read' => true]);

            $messages = Message::with('sender')
                ->betweenUsers($authId, $selectedUser->id)
                ->orderBy('created_at')
                ->get();

            $contacts = $this->getContacts($authId);
        }

        return view('chat.index', compact(
            'contacts',
            'selectedUser',
            'messages',
            'totalUnread'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'recipient_id' => ['required', 'exists:users,id'],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        Message::create([
            'user_id' => Auth::id(),
            'recipient_id' => $data['recipient_id'],
            'body' => $data['body'],
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    public function poll(Request $request)
    {
        $request->validate([
            'user' => ['required', 'exists:users,id'],
        ]);

        $authId = Auth::id();
        $selectedUser = User::findOrFail($request->user);

        Message::where('user_id', $selectedUser->id)
            ->where('recipient_id', $authId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::with('sender')
            ->betweenUsers($authId, $selectedUser->id)
            ->orderBy('created_at')
            ->get()
            ->map(function ($message) use ($authId) {
                return [
                    'id' => $message->id,
                    'body' => $message->body,
                    'mine' => $message->user_id === $authId,
                    'sender_name' => $message->sender?->name,
                    'time' => $message->created_at?->format('H:i'),
                ];
            });

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'contacts' => $this->contactsForJson($authId),
            'total_unread' => Message::where('recipient_id', $authId)
                ->where('is_read', false)
                ->count(),
        ]);
    }

    public function unreadCount()
    {
        return response()->json([
            'success' => true,
            'count' => Message::where('recipient_id', Auth::id())
                ->where('is_read', false)
                ->count(),
        ]);
    }

    public function destroy(User $user)
    {
        Message::betweenUsers(Auth::id(), $user->id)->delete();

        return redirect()
            ->route('chat.index')
            ->with('success', 'Discussion supprimée.');
    }

    private function getContacts(int $authId)
    {
        $contactIds = Message::where('user_id', $authId)
            ->orWhere('recipient_id', $authId)
            ->get()
            ->flatMap(function ($message) use ($authId) {
                return [
                    $message->user_id == $authId
                        ? $message->recipient_id
                        : $message->user_id
                ];
            })
            ->unique()
            ->filter()
            ->values();

        $contacts = User::whereIn('id', $contactIds)->get();

        foreach ($contacts as $contact) {
            $lastMessage = Message::betweenUsers($authId, $contact->id)
                ->latest()
                ->first();

            $contact->last_message_body = $lastMessage?->body;

            $contact->unread_count = Message::where('user_id', $contact->id)
                ->where('recipient_id', $authId)
                ->where('is_read', false)
                ->count();
        }

        return $contacts;
    }

    private function contactsForJson(int $authId)
    {
        return $this->getContacts($authId)->map(function ($contact) {
            return [
                'id' => $contact->id,
                'unread_count' => $contact->unread_count ?? 0,
                'last_message_body' => $contact->last_message_body ?? '',
            ];
        })->values();
    }
}