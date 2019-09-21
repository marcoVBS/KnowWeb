<?php

namespace App\Http\Controllers\Article;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Archive\Archive;
use App\Models\Archive\ArchiveCategorie;
use App\Models\Archive\ArchiveExtension;
use App\Models\Article\ArchiveArticle;
use App\Models\Article\Article;
use App\Models\Article\ArticleArchive;
use App\Models\Article\ArticleCategorie;
use App\Models\Article\ComputerArticle;
use App\Models\Article\EquipmentArticle;
use App\Models\Article\PasswordArticle;
use App\Models\Article\Tag;
use App\Models\Article\TagArticle;
use App\Models\Computer\Computer;
use App\Models\Equipment\Equipment;
use App\Models\Equipment\EquipmentCategorie;
use App\Models\Password\Password;
use App\Models\Sector\Setor;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('article.listarticles');
    }

    public function getArticles(){

        $articles = Article::orderBy('updated_at', 'desc')->get();
        foreach ($articles as $article) {
            $article->autor = User::find($article->usuario_autor_id)->nome;
            
            if(User::find($article->usuario_autor_id)->foto){
                $article->autor_foto = User::find($article->usuario_autor_id)->foto;
            }
            
            $article->categoria = ArticleCategorie::find($article->categoria_artigo_id)->nome;
            
            if($article->usuario_atualizador_id){
                $article->atualizador = User::find($article->usuario_atualizador_id)->nome;
            }

            $tags_article = TagArticle::where('artigo_id', $article->id_artigo)->get();
            if(count($tags_article) > 0){
                $tags = [];
                foreach ($tags_article as $tag) {
                    $get = Tag::where('id_tag', $tag->tag_id)->get();
                    $tags[] = $get[0]->nome;
                }
                $article->tags = $tags;
            }
        }

        return response()->json([
            'articles' => $articles
        ]);
    }
    
    public function new()
    {
        $categories = ArticleCategorie::all();
        $tags = Tag::all();
        return view('article.newarticle', ['update' => json_encode(false), 'categories' => json_encode($categories), 'tags' => json_encode($tags)]);
    }
    
    public function change($id){
        $categories = ArticleCategorie::all();
        $tags = Tag::all();
        $article = Article::find($id);

        $tag_article = TagArticle::where('artigo_id', $id)->get();
        if(count($tag_article) > 0){
            foreach($tag_article as $tag){
                $tags_name[] = Tag::find($tag->tag_id)->nome;
            }
            $article->tags = $tags_name;
        }

        $files = ArchiveArticle::where('artigo_id', $id)->get();
        if(count($files) > 0){
            foreach ($files as $file) {
                $files_id[] = $file->arquivo_id;
            }
            $article->files_id = $files_id;
        }
        $passwords = PasswordArticle::where('artigo_id', $id)->get();
        if(count($passwords) > 0){
            foreach ($passwords as $pass) {
                $pass_id[] = $pass->senha_id;
            }
            $article->passwords_id = $pass_id;
        }
        $computers = ComputerArticle::where('artigo_id', $id)->get();
        if(count($computers) > 0){
            foreach ($computers as $pc) {
                $pcs_id[] = $pc->computador_id;
            }
            $article->computers_id = $pcs_id;
        }
        $equipments = EquipmentArticle::where('artigo_id', $id)->get();
        if(count($equipments) > 0){
            foreach ($equipments as $equip) {
                $equips_id[] = $equip->equipamento_id;
            }
            $article->equipments_id = $equips_id;
        }
        return view('article.newarticle', ['update' => json_encode(true), 'categories' => json_encode($categories), 'tags' => json_encode($tags), 'articleUpdate' => json_encode($article)]);
    }
    
    public function uploadImage(Request $request){
        $extension = $request->file->getClientOriginalExtension();
        $name = time().'id-'.Auth::id().'.'.$extension;
        $path = '/KnowWeb/public/storage/artigos/imagens/' . $name;
        
        if($request->hasFile('file') && $request->file('file')->isValid()){
            $upload = $request->file->storeAs('/artigos/imagens/', $name);
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

    public function create(Request $request)
    {
        $article = new Article();
        $article->titulo = $request->titulo;
        $article->descricao = $request->descricao;
        $article->conteudo = $request->conteudo;
        $article->categoria_artigo_id = $request->categoria_id;
        $article->usuario_autor_id = Auth::id();
        
        if($article->save()){

            foreach ($request->tags as $tag) {
                $get = Tag::where('nome', $tag)->get();
                if(count($get) == 0){
                    $new_tag = new Tag();
                    $new_tag->nome = $tag;
                    if($new_tag->save()){
                        $tag_article = new TagArticle();
                        $tag_article->tag_id = $new_tag->id_tag;
                        $tag_article->artigo_id = $article->id_artigo;
                        $tag_article->save();
                    }
                }else{
                    $tag_article = new TagArticle();
                    $tag_article->tag_id = $get[0]->id_tag;
                    $tag_article->artigo_id = $article->id_artigo;
                    $tag_article->save();
                }
            }

            if(count($request->archives) > 0){
                foreach ($request->archives as $file) {
                    $file_article = new ArchiveArticle();
                    $file_article->artigo_id = $article->id_artigo;
                    $file_article->arquivo_id = $file;
                    $file_article->save();
                }
            }

            if(count($request->passwords) > 0){
                foreach ($request->passwords as $pass) {
                    $pass_article = new PasswordArticle();
                    $pass_article->artigo_id = $article->id_artigo;
                    $pass_article->senha_id = $pass;
                    $pass_article->save();
                }
            }

            if(count($request->computers) > 0){
                foreach ($request->computers as $pc) {
                    $pc_article = new ComputerArticle();
                    $pc_article->artigo_id = $article->id_artigo;
                    $pc_article->computador_id = $pc;
                    $pc_article->save();
                }
            }

            if(count($request->equipments) > 0){
                foreach ($request->equipments as $equip) {
                    $equip_article = new EquipmentArticle();
                    $equip_article->artigo_id = $article->id_artigo;
                    $equip_article->equipamento_id = $equip;
                    $equip_article->save();
                }
            }

            $stored = true;
            foreach($request->imagens as $img){
                $image = new ArticleArchive();
                $image->nome = $img['nome'];
                $image->caminho = $img['caminho'];
                $image->artigo_id = $article->id_artigo;
                if($image->save()){
                    $stored = true;
                }else{
                    $stored = false;
                }
            }
            if($stored == true){
                return response()->json([
                    'message' => "Artigo cadastrado com sucesso!",
                    'stored' => true
                ]);
            }else{
                return response()->json([
                    'message' => "Falha ao cadastrar artigo!",
                    'stored' => false
                ]);
            }
        }else{
            return response()->json([
                'message' => "Falha ao cadastrar artigo!",
                'stored' => false
            ]);
        }
    }

    public function update(Request $request){
        $stored = true;

        $article = Article::find($request->id_artigo);
        $article->titulo = $request->titulo;
        $article->descricao = $request->descricao;
        $article->conteudo = $request->conteudo;
        $article->categoria_artigo_id = $request->categoria_id;
        $article->usuario_atualizador_id = Auth::id();
        
        if($article->save()){
            
            TagArticle::where('artigo_id', $request->id_artigo)->delete();

            foreach ($request->tags as $tag) {
                $get = Tag::where('nome', $tag)->get();
                if(count($get) == 0){
                    $new_tag = new Tag();
                    $new_tag->nome = $tag;
                    if($new_tag->save()){
                        $tag_article = new TagArticle();
                        $tag_article->tag_id = $new_tag->id_tag;
                        $tag_article->artigo_id = $request->id_artigo;
                        $tag_article->save();
                    }
                }else{
                    $tag_article = new TagArticle();
                    $tag_article->tag_id = $get[0]->id_tag;
                    $tag_article->artigo_id = $request->id_artigo;
                    $tag_article->save();    
                }
            }

            foreach($request->imagens as $img){
                $image = new ArticleArchive();
                $image->nome = $img['nome'];
                $image->caminho = $img['caminho'];
                $image->artigo_id = $request->id_artigo;
                if($image->save()){
                    $stored = true;
                }
            }

            ArchiveArticle::where('artigo_id', $request->id_artigo)->delete();
            if(count($request->archives) > 0){
                foreach ($request->archives as $file) {
                    $file_article = new ArchiveArticle();
                    $file_article->artigo_id = $request->id_artigo;
                    $file_article->arquivo_id = $file;
                    $file_article->save();
                }
            }

            PasswordArticle::where('artigo_id', $request->id_artigo)->delete();
            if(count($request->passwords) > 0){
                foreach ($request->passwords as $pass) {
                    $pass_article = new PasswordArticle();
                    $pass_article->artigo_id = $request->id_artigo;
                    $pass_article->senha_id = $pass;
                    $pass_article->save();
                }
            }

            ComputerArticle::where('artigo_id', $request->id_artigo)->delete();
            if(count($request->computers) > 0){
                foreach ($request->computers as $pc) {
                    $pc_article = new ComputerArticle();
                    $pc_article->artigo_id = $request->id_artigo;
                    $pc_article->computador_id = $pc;
                    $pc_article->save();
                }
            }

            EquipmentArticle::where('artigo_id', $request->id_artigo)->delete();
            if(count($request->equipments) > 0){
                foreach ($request->equipments as $equip) {
                    $equip_article = new EquipmentArticle();
                    $equip_article->artigo_id = $request->id_artigo;
                    $equip_article->equipamento_id = $equip;
                    $equip_article->save();
                }
            }

        }else{
            $stored = false;
        }

        if($stored == true){
            return response()->json([
                'message' => "Artigo atualizado com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao atualizado artigo!",
                'stored' => false
            ]);
        }
    }

    public function delete($id)
    {
        TagArticle::where('artigo_id', $id)->delete();
        ArchiveArticle::where('artigo_id', $id)->delete();
        PasswordArticle::where('artigo_id', $id)->delete();
        ComputerArticle::where('artigo_id', $id)->delete();
        EquipmentArticle::where('artigo_id', $id)->delete();

        $images_directory = Storage::files('/artigos/imagens');
        foreach($images_directory as $img_dir){
            $path = '/KnowWeb/public/storage/'.$img_dir;
            if(count(ArticleArchive::where('caminho', $path)->get()) == 0){
                Storage::delete($img_dir);
            }
        }

        $images = ArticleArchive::where('artigo_id',$id)->get();
        foreach($images as $img){
            Storage::delete('/artigos/imagens/'.$img->nome);
        }

        $article = Article::find($id);
        
        if($article->delete()){
            return response()->json([
                'message' => "Artigo excluído com sucesso!",
                'deleted' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao excluir artigo!",
                'deleted' => false
            ]);
        }
    }

    public function view(Request $request){
        $article = Article::find($request->id);
        
        $article->autor = User::find($article->usuario_autor_id)->nome;
            
        if(User::find($article->usuario_autor_id)->foto){
            $article->autor_foto = User::find($article->usuario_autor_id)->foto;
        }
        
        $article->categoria = ArticleCategorie::find($article->categoria_artigo_id)->nome;
        
        if($article->usuario_atualizador_id){
            $article->atualizador = User::find($article->usuario_atualizador_id)->nome;
        }

        $tags_article = TagArticle::where('artigo_id', $article->id_artigo)->get();
        if(count($tags_article) > 0){
            $tags = [];
            foreach ($tags_article as $tag) {
                $get = Tag::where('id_tag', $tag->tag_id)->get();
                $tags[] = $get[0]->nome;
            }
            $article->tags = $tags;
        }

        $files_article = ArchiveArticle::where('artigo_id', $article->id_artigo)->get();
        if(count($files_article) > 0){
            $files = [];
            foreach($files_article as $file){
                $get = Archive::where('id_arquivo', $file->arquivo_id)->get();
                
                $get[0]->extensao = ArchiveExtension::find($get[0]->extensao_arquivo_id)->extensao;
                $get[0]->categoria = ArchiveCategorie::find($get[0]->categoria_arquivo_id)->nome;
                
                $tamanho = $get[0]->tamanho;
                if($tamanho < 1024){
                    $get[0]->tamanho .= ' Bytes'; 
                }elseif ($tamanho < 1048576) {
                    $get[0]->tamanho = number_format($tamanho/1024, 1, ',', '.').' KB';
                }elseif ($tamanho < 1073741824) {
                    $get[0]->tamanho = number_format($tamanho/1024/1024, 1, ',', '.').' MB';                
                }else{
                    $get[0]->tamanho = number_format($tamanho/1024/1024/1024, 1, ',', '.').' GB';
                }

                if(file_exists("img/app/file_types/{$get[0]->extensao}.png")){
                    $get[0]->img_ext = "img/app/file_types/{$get[0]->extensao}.png";
                }
                else{
                    $get[0]->img_ext = "img/app/file_types/file.png";
                }

                $files[] = $get[0];
            }
            $article->arquivos = $files;
        }

        $passwords_article = PasswordArticle::where('artigo_id', $article->id_artigo)->get();
        if(count($passwords_article) > 0){
            $passwords = [];
            foreach($passwords_article as $pass){
                $get = Password::where('id_senha', $pass->senha_id)->get();
                if($get[0]->equipamento_id){   
                    $get[0]->equipamento = Equipment::find($get[0]->equipamento_id);
                }
                $passwords[] = $get[0];
            }
            $article->senhas = $passwords;
        }

        $computers_article = ComputerArticle::where('artigo_id', $article->id_artigo)->get();
        if(count($computers_article) > 0){
            $computers = [];
            foreach($computers_article as $pc){
                $get = Computer::where('id_computador', $pc->computador_id)->get();
                $get[0]->setor = Setor::find($get[0]->setor_id)->nome;
                $computers[] = $get[0];
            }
            $article->computadores = $computers;
        }

        $equipments_article = EquipmentArticle::where('artigo_id', $article->id_artigo)->get();
        if(count($equipments_article) > 0){
            $equipments = [];
            foreach($equipments_article as $equip){
                $get = Equipment::where('id_equipamento', $equip->equipamento_id)->get();
                $get[0]->categoria = EquipmentCategorie::find($get[0]->categoria_equipamento_id)->nome;
                $equipments[] = $get[0];
            }
            $article->equipamentos = $equipments;
        }

        return view('article.article', ['article'=> json_encode($article)]);
    }

}
