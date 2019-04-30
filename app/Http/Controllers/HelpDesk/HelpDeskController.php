<?php

namespace App\Http\Controllers\HelpDesk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HelpDesk\HelpDeskCategorie;
use Illuminate\Support\Facades\Auth;
use App\Models\HelpDesk\HelpDesk;
use App\Models\HelpDesk\HelpDeskArchive;

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

    public function create(Request $request){
        $helpdesk = new HelpDesk();
        $helpdesk->titulo = $request->titulo;
        $helpdesk->descricao = $request->descricao;
        $helpdesk->prioridade = 'Baixa';
        $helpdesk->status = 'Aberto';
        $helpdesk->categoria_atendimento_id = $request->categoria_id;
        $helpdesk->usuario_solicitante_id = Auth::id();
        if($helpdesk->save()){
            foreach ($request->imagens as $image) {
                $upload = $this->saveArchive($helpdesk->id_atendimento, $image['nome'], $image['caminho']);
                if(!$upload){
                    return response()->json([
                        'stored' => false
                    ]);
                }
            }
            return response()->json([
                'stored' => true,
                'id' => $helpdesk->id_atendimento
            ]);
        }else{
            return response()->json([
                'stored' => false
            ]);
        }
    }

    public function saveArchive($atendimento_id, $name, $caminho, $resposta_id = null){
        $archive = new HelpDeskArchive();
        $archive->atendimento_id = $atendimento_id;
        if($resposta_id){
            $archive->resposta_atendimento_id = $resposta_id;
        }
        $archive->nome = $name;
        $archive->caminho = $caminho;
        if($archive->save()){
            return true;
        }else{
            return false;
        }
    }

    public function uploadImage(Request $request){
        $extension = $request->file->getClientOriginalExtension();
        $name = time().'id-'.Auth::id().'.'.$extension;
        $path = 'storage/atendimentos/imagens/' . $name;
        
        $upload = $request->file->storeAs('/atendimentos/imagens/', $name);
        if($upload){
            return response()->json([
                'path' => $path,
                'name' => $name
            ]);
        }else{
            return false;
        }
    }

    public function uploadFiles(Request $request){
        $id_atendimento = $request->id;
        $name = $request->file('file')->getClientOriginalName();
        $path = 'storage/atendimentos/arquivos/'.$id_atendimento.'/'. $name;
        $upload = $request->file('file')->storeAs('/atendimentos/arquivos/'.$id_atendimento.'/', $name);

        if($upload){
            $save = $this->saveArchive($id_atendimento, $name, $path);
            if($save){
                return response()->json([
                    'upload' => true
                ]);
            }else{
                return response()->json([
                    'upload' => false
                ]);
            }
        }else{
            return response()->json([
                'upload' => false
            ]);
        }
    }
    
}
