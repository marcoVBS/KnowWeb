<?php

namespace App\Http\Controllers\Archive;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Archive\ArchiveCategorie;
use App\Models\Archive\Archive;
use Illuminate\Support\Facades\Auth;
use App\Models\Archive\ArchiveExtension;
use Illuminate\Support\Facades\Storage;
use App\User;

class ArchiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = ArchiveCategorie::all();
        return view('archives', ['categorias' => json_encode($categories)]);
    }

    public function getFiles()
    {
        $files = Archive::orderBy('nome', 'asc')->get();
        foreach ($files as $file) {
            $file->extensao = ArchiveExtension::find($file->extensao_arquivo_id)->extensao;
            $file->categoria = ArchiveCategorie::find($file->categoria_arquivo_id)->nome;
            $file->usuario = User::find($file->usuario_id)->nome;
            
            $tamanho = $file->tamanho;
            if($tamanho < 1024){
                $file->tamanho .= ' Bytes'; 
            }elseif ($tamanho < 1048576) {
                $file->tamanho = number_format($tamanho/1024, 1, ',', '.').' KB';
            }elseif ($tamanho < 1073741824) {
                $file->tamanho = number_format($tamanho/1024/1024, 1, ',', '.').' MB';                
            }else{
                $file->tamanho = number_format($tamanho/1024/1024/1024, 1, ',', '.').' GB';
            }

            
            if(file_exists("img/app/file_types/{$file->extensao}.png")){
                $file->img_ext = "img/app/file_types/{$file->extensao}.png";
            }
            else{
                $file->img_ext = "img/app/file_types/file.png";
            }
        }
        return response()->json([
            'files' => $files
        ]);
    }

    public function create(Request $request){
        $file = $request->file('file');

        $name = \strtolower($file->getClientOriginalName());
        
        if(Storage::exists('/arquivos/'. $name)){
            $i = 0;
            do {
                $i++;
                $tmp = "($i) ".$name;
            } while (Storage::exists('arquivos/'.$tmp));
            $name = "($i) ".$name;
        }
        $path = '/arquivos/'. $name;
        
        $type = $file->getClientOriginalExtension();
        $size = $file->getClientSize();

        $extension = ArchiveExtension::where('extensao', $type)->get();
        if(isset($extension[0])){
            if($request->hasFile('file') && $file->isValid()){
                $upload = $file->storeAs('/arquivos/', $name);
    
                if($upload){
                    $file = new Archive();
                    $file->caminho = $path;
                    $file->tamanho = $size;
                    $file->nome = $name;
                    $file->categoria_arquivo_id = $request->categorie;
                    $file->usuario_id = Auth::id();
                    $file->extensao_arquivo_id = $extension[0]->id_extensao_arquivo;
    
                    if($file->save()){
                        return response()->json([
                            'stored' => true,
                            'message' => 'Arquivo "'.$name.'" enviado com sucesso!'
                        ]);
                    }else{
                        
                        Storage::delete($path);
                        
                        return response()->json([
                            'stored' => false
                        ]);
                    }
                }else{
                    return response()->json([
                        'stored' => false
                    ]);
                }
            }else{
                return response()->json([
                    'stored' => false
                ]);
            }
        }else{
            return response()->json([
                'stored' => false,
                'message' => 'Extensão do arquivo "'.$name.'" não permitida!'
            ]);
        }

    }

    public function downloadFile(Request $request){
        $file = Archive::find($request->id);
        return response()->download(storage_path('app/public'.$file->caminho));
    }

    public function delete($id)
    {
        $file = Archive::find($id);
        if(Storage::delete($file->caminho)){
            if($file->delete()){
                return response()->json([
                    'message' => "Arquivo {$file->nome} excluído com sucesso!",
                    'deleted' => true
                ]);
            }else{
                return response()->json([
                    'message' => "Falha ao excluir arquivo!",
                    'deleted' => false
                ]);
            }
        }else{
            return response()->json([
                'message' => "Falha ao excluir arquivo!",
                'deleted' => false
            ]);
        }
    }
}
