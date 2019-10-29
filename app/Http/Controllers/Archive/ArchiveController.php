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
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ArchiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Gate::allows('list-files')){
            $categories = ArchiveCategorie::all();
            return view('archives', ['categorias' => json_encode($categories)]);
        }else{
            abort(403,'Você não possui permissão para gerenciar arquivos. Contate o administrador!');
        }
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

    public function sanitizeString($str) 
    {
        $str = preg_replace('/[áàãâä]/ui', 'a', $str);
        $str = preg_replace('/[éèêë]/ui', 'e', $str);
        $str = preg_replace('/[íìîï]/ui', 'i', $str);
        $str = preg_replace('/[óòõôö]/ui', 'o', $str);
        $str = preg_replace('/[úùûü]/ui', 'u', $str);
        $str = preg_replace('/[ç]/ui', 'c', $str);
        $str = preg_replace('/[^a-z0-9.]/i', '_', $str);
        return $str;
    }

    public function create(Request $request){
        if (Gate::denies('upload-files')) {
            return false;
        }

        $file = $request->file('file');

        $name = \strtolower($file->getClientOriginalName());
        $name = $this->sanitizeString($name);
        
        if(Storage::exists('/arquivos/'. $name)){
            $i = 0;
            do {
                $i++;
                $tmp = "($i)_".$name;
            } while (Storage::exists('arquivos/'.$tmp));
            $name = "($i)_".$name;
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
        if (Gate::denies('download-files')) {
            abort(403,'Você não possui permissão para fazer Download de arquivos. Contate o administrador!');
        }

        $file = Archive::find($request->id);
        return response()->download(storage_path('app/public'.$file->caminho));
    }

    public function delete($id)
    {
        if (Gate::denies('delete-file')) {
            return false;
        }

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
