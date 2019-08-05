<?php

namespace App\Http\Controllers\Computer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sector\Setor;
use App\Models\Computer\OperationalSystem;

class ComputerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sectors = Setor::all();
        $sos = OperationalSystem::all();
        return view('computers', [ 'setores' => json_encode($sectors), 'sos' => json_encode($sos)]);
    }
}
