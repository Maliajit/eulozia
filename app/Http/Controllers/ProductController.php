<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.listing');
    }

    public function show($id)
    {
        return view('products.details', compact('id'));
    }

    public function search()
    {
        return view('products.search');
    }

    public function category($slug)
    {
        return view('products.category', compact('slug'));
    }
}
