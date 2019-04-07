<?php

namespace App\Http\Controllers\HelpDesk;

use App\HelpDesk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HelpDeskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('helpdesk.helpdesk');
    }

    
}
