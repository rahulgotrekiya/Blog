<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageReplied;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);
        $unreadCount = ContactMessage::where('is_read', false)->count();

        return view('admin.messages.index', compact('messages', 'unreadCount'));
    }

    public function show(ContactMessage $message)
    {
        // Mark as read when viewing
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function markAsRead(ContactMessage $message)
    {
        $message->update(['is_read' => !$message->is_read]);

        return redirect()->route('admin.messages.index')->with('success', 'Message status updated.');
    }

    public function reply(Request $request, ContactMessage $message)
    {
        $validated = $request->validate([
            'replied_message' => 'required|string|min:5',
        ]);

        // Save reply + timestamp
        $message->update([
            'replied_message' => $validated['replied_message'],
            'replied_at'      => now(),
            'is_read'         => true,
        ]);

        // Send email to the user
        Mail::to($message->email)->send(new ContactMessageReplied($message));

        return redirect()
            ->route('admin.messages.show', $message)
            ->with('success', "Reply sent and emailed to {$message->email}!");
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Message deleted successfully.');
    }
}
