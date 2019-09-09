<?php

namespace App\Http\Controllers\Article;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use App\Models\Article\ArticleArchive;
use App\Models\Article\ArticleCategorie;
use App\Models\Article\Tag;
use App\Models\Article\TagArticle;
use App\User;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $articles = Article::all();
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
        return view('article.listarticles', ['articles' => json_encode($articles)]);
    }

    public function new()
    {
        $categories = ArticleCategorie::all();
        $tags = Tag::all();
        return view('article.newarticle', ['update' => json_encode(false), 'categories' => json_encode($categories), 'tags' => json_encode($tags)]);
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

}
