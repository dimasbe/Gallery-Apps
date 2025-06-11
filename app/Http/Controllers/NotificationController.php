<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Mark the specified notification as read.
     */
    public function markAsRead($id, Request $request)
    {
        $notification = Notifikasi::find($id);
        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        $notification->dibaca = true;
        $notification->dibaca_pada = now();
        $notification->save();

        return response()->json(['message' => 'Notification marked as read']);
    }
}