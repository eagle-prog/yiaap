<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DevelopersController extends Controller
{
    public function index()
    {
        return view('developers.index');
    }

    public function stats()
    {
        return view('developers.stats.index');
    }

    public function websites()
    {
        return view('developers.websites.index');
    }

    public function account()
    {
        return view('developers.account.index');
    }
}
