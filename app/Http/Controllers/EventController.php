<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show()
    {
        return view('event-detail');
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function ticket()
    {
        return view('ticket'); // halaman tiket user
    }

    public function indexAdmin()
    {
        return view('admin.events'); // halaman admin event list
    }
}
