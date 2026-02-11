<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }

    public function payment()
    {
        return view('checkout.payment');
    }

    public function confirmation()
    {
        return view('checkout.confirmation');
    }
}
