<?php

namespace App\Http\Controllers\Computer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use App\Models\Article\ComputerArticle;
use App\Models\Computer\Computer;
use App\Models\Sector\Setor;
use App\Models\Computer\OperationalSystem;
use App\User;
use Illuminate\Support\Facades\Gate;

class ComputerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Gate::allows('list-computers')){
            return view('computer.computers');
        }else{
            abort(403,'Você não possui permissão para gerenciar computadores. Contate o administrador!');
        }
    }

    public function new()
    {
        if(Gate::allows('create-computer')){
            $sectors = Setor::all();
            $sos = OperationalSystem::all();
            return view('computer.formcomputer', ['update' => json_encode(false), 'sos' => json_encode($sos),'setores' => json_encode($sectors)]);
        }else{
            abort(403,'Você não possui permissão para adicionar computadores. Contate o administrador!');
        }
    }

    public function view(Request $request){
        if(Gate::allows('view-computer')){
            $computer = Computer::find($request->id);
            $computer->setor = Setor::find($computer->setor_id)->nome;
            $computer->so = OperationalSystem::find($computer->sistema_operacional_id);
    
            $articles_computers = ComputerArticle::where('computador_id', $request->id)->get();
            $assocs = [];
            foreach ($articles_computers as $item) {
                $article = Article::where('id_artigo', $item->artigo_id)->get();
                $article[0]->autor = User::find($article[0]->usuario_autor_id)->nome;
                $article[0]->contador = $item->contador;
                $assocs[] = $article[0];
            }
    
            return view('computer.computer', ['computer'=> json_encode($computer), 'articles' => json_encode($assocs)]);
        }else{
            abort(403,'Você não possui permissão para vizualizar computadores. Contate o administrador!');
        }
    }

    public function change($id)
    {
        if(Gate::allows('view-computer')){
            $sectors = Setor::all();
            $sos = OperationalSystem::all();
            $pc = Computer::find($id);
            return view('computer.formcomputer', ['update' => json_encode(true), 'sos' => json_encode($sos),'setores' => json_encode($sectors), 'computerUpdate' => json_encode($pc)]);
        }else{
            abort(403,'Você não possui permissão para editar computadores. Contate o administrador!');
        }
    }

    public function getComputers()
    {
        $computers = Computer::all();
        foreach($computers as $computer){
            $computer->setor = Setor::find($computer->setor_id)->nome;
        }

        return response()->json([
            'computers' => $computers
        ]);
    }

    public function create(Request $request)
    {
        if (Gate::denies('create-computer')) {
            return false;
        }

        $computer = new Computer();
        $computer->placa_mae = $request->placa_mae;
        $computer->processador = $request->processador;
        $computer->memoria_ram = $request->memoria_ram;
        $computer->unidade_armazenamento = $request->unidade_armazenamento;
        $computer->mac_ethernet = strtoupper($request->mac_ethernet);
        $computer->mac_wireless = strtoupper($request->mac_wireless);
        $computer->senha_usuario_adm = $request->senha_usuario_adm;
        $computer->nome_computador = $request->nome_computador;
        $computer->identificador_computador = $request->identificador_computador;
        $computer->programas_especificos = $request->programas_especificos;
        $computer->sistema_operacional_id = $request->sistema_operacional_id;
        $computer->setor_id = $request->setor_id;
        
        if($computer->save()){
            return response()->json([
                'message' => "Computador cadastrado com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao cadastrar computador!",
                'stored' => false
            ]);
        }
    }

    public function update(Request $request)
    {
        if (Gate::denies('edit-computer')) {
            return false;
        }

        $computer = Computer::find($request->id_computador);
        $computer->placa_mae = $request->placa_mae;
        $computer->processador = $request->processador;
        $computer->memoria_ram = $request->memoria_ram;
        $computer->unidade_armazenamento = $request->unidade_armazenamento;
        $computer->mac_ethernet = strtoupper($request->mac_ethernet);
        $computer->mac_wireless = strtoupper($request->mac_wireless);
        $computer->senha_usuario_adm = $request->senha_usuario_adm;
        $computer->nome_computador = $request->nome_computador;
        $computer->identificador_computador = $request->identificador_computador;
        $computer->programas_especificos = $request->programas_especificos;
        $computer->sistema_operacional_id = $request->sistema_operacional_id;
        $computer->setor_id = $request->setor_id;
        if($computer->save()){
            return response()->json([
                'message' => "Computador atualizado com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao atualizar computador!",
                'stored' => false
            ]);
        }
    }

    public function delete($id)
    {
        if (Gate::denies('delete-computer')) {
            return false;
        }

        $computer = Computer::find($id);
        
        if($computer->delete()){
            return response()->json([
                'message' => "Computador excluído com sucesso!",
                'deleted' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao excluir computador!",
                'deleted' => false
            ]);
        }
    }

}
