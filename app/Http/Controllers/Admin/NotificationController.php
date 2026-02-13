<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Admin Notification Controller
 * 
 * Purpose: Displays system notifications and alerts for admin users.
 * 
 * Data Flow: 
 * - Serves the main notification center view.
 * 
 * Database: 
 * - `notifications`: (Typically uses Laravel Database Notifications table).
 * 
 * Dependencies: Admin Layout.
 */
class NotificationController extends Controller
{
    public function index() { return view('admin.notifications.index'); }
}
