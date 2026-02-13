<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Admin CRM Controller
 * 
 * Purpose: Global controller for CRM-related views (Banners, Home Page Sections).
 * 
 * Data Flow: 
 * - Primarily serves structural views for CRM internal navigation.
 * 
 * Database: 
 * - N/A (Redirects to specific CRM tables like `banners`, `home_sections`).
 * 
 * Dependencies: Admin Layout Master.
 */
class CRMController extends Controller
{
    public function index()    { return view('admin.crm.index'); }
    public function popup()    { return view('admin.crm.popup'); }
    public function settings() { return view('admin.crm.settings'); }
}
