<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Project;
use App\Models\ArticleProject;
use App\Models\Type;
use Carbon\Carbon;
use DB;
use File;

class ArticleController extends Controller
{
    public function getArticle()
    {
        
        if(Auth::user()->role_id == 1){
            $article = Article::orderBy('id', 'desc')->with('articleprojects.project')->with('type')->get();
            foreach($article as $key => $arti)
            {
                $article[$key]->date = Carbon::createFromFormat('Y-m-d H:i:s', $arti->created_at)->format('F d, Y');
            }
            return $article;
        } else if(Auth::user()->role_id == 2){
            $article = Article::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->with('articleprojects.project')->with('type')->get();
            foreach($article as $key => $arti)
            {
                $article[$key]->date = Carbon::createFromFormat('Y-m-d H:i:s', $arti->created_at)->format('F d, Y');
            }
            return $article;
        }
        
    }

    public function storeArticle(Request $request){
        $validated = $request->validate([
            'title' => 'required',
            'article' => 'required',    
            'projectValue' => 'required',    
            'typeValue' => 'required',          
            'image' => 'required',
        ]);

        $newArticle = new Article;
        $newArticle->user_id = Auth::id();
        $newArticle->type_id = $request->typeValue;
        $newArticle->title = $request->title;
        $newArticle->author = $request->author;
        $newArticle->image = $request->image;
        $newArticle->article = $request->article;
        $newArticle->save();

        $projects = $request->projectValue;

        foreach($projects as $key => $project){
            if($project == '1'){
                ArticleProject::create([
                    'article_id' =>  $newArticle->id,
                    'project_id' => 1,
                ]);
            } else if ($project == '2') {
                ArticleProject::create([
                    'article_id' =>  $newArticle->id,
                    'project_id' => 2,
                ]);
            } else if ($project == '3') {
                ArticleProject::create([
                    'article_id' =>  $newArticle->id,
                    'project_id' => 3,
                ]);
            } else if ($project == '4') {
                ArticleProject::create([
                    'article_id' =>  $newArticle->id,
                    'project_id' => 4,
                ]);
            }
            
        }
        
        return;
    }

    public function upload(Request $request){
        // return $request; 
        $request->validate([
            'file' => 'required'
        ]); 
        $file = $request->file;
        $picName = time().'.webp';

        $img = \Image::make($file)->encode('webp');

        if($img->width()>=800){
            $img->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $img->save(public_path('/img/uploads/'.$picName));

        // $request->file->move(public_path('uploads/high'),$picName);
        return $picName;
    }

    public function deleteImage(Request $request){
        $fileName = $request->imageName;
        $this->deleteFileFromServe($fileName);
        return 'done';
    }

    public function deleteFileFromServe($fileName){
        $filePath = public_path().'/img/uploads/'.$fileName;
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        return;
    }

    public function deleteArticle(Request $ruquest){
        $Article = Article::find($ruquest->id);
        $fileName = $Article->image;
        $filePath = public_path().'/img/uploads/'.$fileName;
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        $Article->delete();
        return $fileName;
    }

    public function getArticleEdit($id)
    {
        return Article::orderBy('id', 'desc')->with('articleprojects.project')->with('type')->get();
    }

    public function updateArticle(Request $request){

        ArticleProject::where('article_id', $request->id)->delete();

        $validated = $request->validate([
            'title' => 'required',
            'article' => 'required',    
            'projectValue' => 'required',    
            'typeValue' => 'required',         
            'image' => 'required',
        ]);

        DB::table('articles')
        ->where('id', $request->id)
        ->update([
        'user_id' => Auth::id(),
        'title' => $request->title,
        'type_id' => $request->typeValue[0],
        'author' => $request->author,
        'image' => $request->image,
        'article' => $request->article,
        ]);

        $projects = $request->projectValue;

        foreach($projects as $key => $project){
            if($project == '1'){
                ArticleProject::create([
                    'article_id' =>  $request->id,
                    'project_id' => 1,
                ]);
            } else if ($project == '2') {
                ArticleProject::create([
                    'article_id' =>  $request->id,
                    'project_id' => 2,
                ]);
            } else if ($project == '3') {
                ArticleProject::create([
                    'article_id' =>  $request->id,
                    'project_id' => 3,
                ]);
            } else if ($project == '4') {
                ArticleProject::create([
                    'article_id' =>  $request->id,
                    'project_id' => 4,
                ]);
            }
            
        }

        return;
    }
}
