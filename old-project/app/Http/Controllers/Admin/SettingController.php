<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Admin Setting Controller
 * 
 * Purpose: Global store configuration management (Branding, API Keys, System Toggles).
 * 
 * Data Flow: 
 * - Serves the main settings interface.
 * - Integration with `SettingService` for persistent configuration.
 * 
 * Database: 
 * - `settings`: Stores key-value pairs for application-wide settings.
 * 
 * Dependencies: `SettingService`, Admin Layout.
 */
class SettingController extends Controller
{
    public function index() { return view('admin.settings.index'); }
}
