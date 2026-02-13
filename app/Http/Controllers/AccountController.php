<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        return view('customer.account.profile');
    }

    public function profile()
    {
        return view('customer.account.profile');
    }

    public function orders()
    {
        return view('customer.account.orders');
    }

    public function orderDetails($id)
    {
        return view('customer.account.orderdetails', compact('id'));
    }

    public function addresses()
    {
        return view('customer.account.addresses');
    }
}
