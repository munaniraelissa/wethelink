<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of all contact messages.
     */
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(15);
        $unreadCount = ContactMessage::where('is_read', false)->count();

        return view('dashboard.contact-messages.index', compact('messages', 'unreadCount'));
    }

    /**
     * Display the specified contact message.
     */
    public function show(ContactMessage $message)
    {
        // Mark as read
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('dashboard.contact-messages.show', compact('message'));
    }

    /**
     * Delete the specified contact message.
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('dashboard.contact-messages.index')
            ->with('success', __('dashboard.contact_messages.message_deleted_successfully'));
    }

    /**
     * Mark message as read.
     */
    public function markAsRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);

        return back()->with('success', __('dashboard.contact_messages.message_marked_as_read'));
    }

    /**
     * Delete all read messages.
     */
    public function deleteRead()
    {
        ContactMessage::where('is_read', true)->delete();

        return back()->with('success', __('dashboard.contact_messages.read_messages_deleted_successfully'));
    }
}
