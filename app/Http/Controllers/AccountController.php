<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        return view('account.profile');
    }

    public function profile()
    {
        return view('account.profile');
    }

    public function orders()
    {
        return view('account.orders');
    }

    public function orderDetails($id)
    {
        return view('account.orderdetails', compact('id'));
    }

    public function addresses()
    {
        return view('account.addresses');
    }
}
