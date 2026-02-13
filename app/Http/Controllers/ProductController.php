<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('customer.products.listing');
    }

    public function show($id)
    {
        return view('customer.products.details', compact('id'));
    }

    public function search()
    {
        return view('customer.products.search');
    }

    public function category($slug)
    {
        return view('customer.products.category', compact('slug'));
    }
}
