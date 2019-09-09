<?php

namespace App\Http\Controllers\HelpDesk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HelpDesk\HelpDeskCategorie;
use Illuminate\Support\Facades\Auth;
use App\Models\HelpDesk\HelpDesk;
use App\Models\HelpDesk\HelpDeskArchive;
use App\User;

class HelpDeskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $helpdesks = HelpDesk::all();
        foreach ($helpdesks as $helpdesk) {
            $helpdesk->autor = User::find($helpdesk->usuario_solicitante_id)->nome;
            $helpdesk->categoria = HelpDeskCategorie::find($helpdesk->categoria_atendimento_id)->nome;
            if($helpdesk->atendente_responsavel_id){
                $helpdesk->responsavel = User::find($helpdesk->atendente_responsavel_id)->nome;
            }
            if(strlen($helpdesk->titulo) > 27){
                $helpdesk->titulo = substr($helpdesk->titulo, 0, 27)."...";
            }
            if(strlen($helpdesk->categoria) > 30){
                $helpdesk->categoria = substr($helpdesk->categoria, 0, 30)."...";
            }
        }
        return view('helpdesk.listhelpdesks', ['helpdesks'=> json_encode($helpdesks)]);
    }

    public function new()
    {
        $categories = HelpDeskCategorie::all();
        return view('helpdesk.newhelpdesk', ['categories' => json_encode($categories)]);
    }

    public function create(Request $request){
        $helpdesk = new HelpDesk();
        $helpdesk->titulo = $request->titulo;
        $helpdesk->descricao = $request->descricao;
        $helpdesk->prioridade = 'Média';
        $helpdesk->status = 'Aberto';
        $helpdesk->categoria_atendimento_id = $request->categoria_id;
        $helpdesk->usuario_solicitante_id = Auth::id();
        if($helpdesk->save()){
            foreach ($request->imagens as $image) {
                $upload = $this->saveArchive($helpdesk->id_atendimento, $image['nome'], $image['caminho'], 'Imagem');
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

    public function saveArchive($atendimento_id, $name, $caminho, $tipo){
        $archive = new HelpDeskArchive();
        $archive->atendimento_id = $atendimento_id;
        $archive->nome = $name;
        $archive->caminho = $caminho;
        $archive->tipo = $tipo;
        if($archive->save()){
            return true;
        }else{
            return false;
        }
    }

    public function uploadImage(Request $request){
        $extension = $request->file->getClientOriginalExtension();
        $name = time().'id-'.Auth::id().'.'.$extension;
        $path = '/KnowWeb/public/storage/atendimentos/imagens/' . $name;
        
        if($request->hasFile('file') && $request->file('file')->isValid()){
            $upload = $request->file->storeAs('/atendimentos/imagens/', $name);
            if($upload){
                return response()->json([
                    'path' => $path,
                    'name' => $name
                ]);
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function uploadFiles(Request $request){
        $id_atendimento = $request->id;
        $name = $request->file('file')->getClientOriginalName();
        $path = 'storage/atendimentos/arquivos/'.$id_atendimento.'/'. $name;

        if($request->hasFile('file') && $request->file('file')->isValid()){
            $upload = $request->file('file')->storeAs('/atendimentos/arquivos/'.$id_atendimento.'/', $name);

            if($upload){
                $save = $this->saveArchive($id_atendimento, $name, $path, 'Arquivo');
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
        }else{
            return response()->json([
                'upload' => false
            ]);
        }
    }

    public function view(Request $request){
        $helpdesk = HelpDesk::find($request->id);
        $user = User::find($helpdesk->usuario_solicitante_id);
        $helpdesk->autor = $user->nome;
        $helpdesk->autor_foto = $user->foto;
        $helpdesk->categoria = HelpDeskCategorie::find($helpdesk->categoria_atendimento_id)->nome;
        $arquivos = HelpDeskArchive::where('atendimento_id', $request->id)->whereNull('resposta_atendimento_id')->where('tipo', '<>', 'Imagem')->get();
        $helpdesk->arquivos = $arquivos;
        return view('helpdesk.helpdesk', ['helpdesk'=> json_encode($helpdesk)]);
    }

    public function changePriority(Request $request){
        $helpdesk = HelpDesk::find($request->id_atendimento);
        $helpdesk->prioridade = $request->prioridade;
        if($helpdesk->save()){
            return response()->json([
                'success' => true
            ]);
        }else{
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function changeStatus(Request $request){
        $helpdesk = HelpDesk::find($request->id_atendimento);
        $helpdesk->status = $request->status;
        $helpdesk->atendente_responsavel_id = Auth::id();
        if($helpdesk->save()){
            return response()->json([
                'success' => true
            ]);
        }else{
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function downloadFile(Request $request){
        $arquivo = HelpDeskArchive::find($request->id);
        return response()->download($arquivo->caminho);
    }
    
}
