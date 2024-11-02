<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class NotificationController extends Controller
{
    public function index()
    {
        return view('notification_index');
    }

    public function unreadNotifs(Request $request)
    {
        $unread_notifications = $request->user()->unreadNotifications()->take(20)->get();
        return response()->json($unread_notifications);
    }
}
