<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('front.notifications', [
            'notifications' => $user->notifications,
            'unread' => $user->unreadNotifications()->count(),
        ]);
    }

    public function read($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);

        //$user->notifications->markAsRead();

        $notification->markAsRead();

        if (isset($notification->data['action']) && $notification->data['action']) {
            return redirect()->to($notification->data['action']);
        }

        return redirect()->back();
    }
}
