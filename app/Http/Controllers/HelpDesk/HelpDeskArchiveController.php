<?php

namespace App\Http\Controllers\HelpDesk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HelpDeskArchiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function uploadImage(Request $request){
        $extension = $request->file->getClientOriginalExtension();
        $nome = time().'id-'.Auth::id().'.'.$extension;
        $path = 'storage/atendimentos/imagens/' . $nome;
        
        $upload = $request->file->storeAs('/atendimentos/imagens/', $nome);
        if($upload){
            return response()->json([
                'path' => $path
            ]);
        }else{
            return false;
        }
    }
}
