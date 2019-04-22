<?php

namespace App\Http\Controllers\HelpDesk;

use App\HelpDesk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HelpDesk\HelpDeskCategorie;

class HelpDeskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = HelpDeskCategorie::all();
        return view('helpdesk.helpdesk', ['categories' => json_encode($categories)]);
    }

    
}
