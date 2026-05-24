<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $partners = \App\Models\Partner::all();
        $events = \App\Models\Event::all();
        return view('welcome', compact('partners', 'events'));
    }
}
