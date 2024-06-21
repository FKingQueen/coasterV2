<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Article;
use App\Models\Project;
use App\Models\Type;

class HomeArticleController extends Controller
{
    public function getArticles() {
        $article =  Article::with('articleprojects.project')->with('type')->get();
        
        foreach($article as $key => $arti)
        {
            $article[$key]->date = Carbon::createFromFormat('Y-m-d H:i:s', $arti->created_at)->format('F d, Y');
        }

        return $article;
    }   

    public function getArticle($id){
        // return $id;
        $article = Article::where('id', $id)->with('articleprojects.project')->with('type')->get();

        $article[0]->date = Carbon::createFromFormat('Y-m-d H:i:s', $article[0]->created_at)->format('F d, Y');

        $articles =  Article::with('articleprojects.project')->with('type')->get();
        
        foreach($articles as $key => $arti)
        {
            $articles[$key]->date = Carbon::createFromFormat('Y-m-d H:i:s', $arti->created_at)->format('F d, Y');
        }

        return response()->json([
            'article'  =>  $article,
            'articles'  =>  $articles,
        ]);
    }

    public function getmoreArticle($id){
        $moreArticle =  Article::where('type_id', $id)->with('articleprojects.project')->with('type')->orderBy('created_at','DESC')->get();
        
        foreach($moreArticle as $key => $arti)
        {
            $moreArticle[$key]->date = Carbon::createFromFormat('Y-m-d H:i:s', $arti->created_at)->format('F d, Y');
        }

        $articles =  Article::where('type_id', $id)->with('articleprojects.project')->with('type')->get();
        
        foreach($articles as $key => $arti)
        {
            $articles[$key]->date = Carbon::createFromFormat('Y-m-d H:i:s', $arti->created_at)->format('F d, Y');
        }

        if($id == 1){
            $moreArticle1 =  Article::where('type_id', 2)->with('articleprojects.project')->with('type')->orderBy('created_at','DESC')->get();;
            $moreArticle2 =  Article::where('type_id', 3)->with('articleprojects.project')->with('type')->orderBy('created_at','DESC')->get();;
            foreach($moreArticle1 as $key => $arti)
            {
                $moreArticle1[$key]->date = Carbon::createFromFormat('Y-m-d H:i:s', $arti->created_at)->format('F d, Y');
            }
            foreach($moreArticle2 as $key => $arti)
            {
                $moreArticle2[$key]->date = Carbon::createFromFormat('Y-m-d H:i:s', $arti->created_at)->format('F d, Y');
            }
        } else if($id == 2){
            $moreArticle1 =  Article::where('type_id', 1)->with('articleprojects.project')->with('type')->orderBy('created_at','DESC')->get();;
            $moreArticle2 =  Article::where('type_id', 3)->with('articleprojects.project')->with('type')->orderBy('created_at','DESC')->get();;
            foreach($moreArticle1 as $key => $arti)
            {
                $moreArticle1[$key]->date = Carbon::createFromFormat('Y-m-d H:i:s', $arti->created_at)->format('F d, Y');
            }
            foreach($moreArticle2 as $key => $arti)
            {
                $moreArticle2[$key]->date = Carbon::createFromFormat('Y-m-d H:i:s', $arti->created_at)->format('F d, Y');
            }
        } else if($id == 3){
            $moreArticle1 =  Article::where('type_id', 1)->with('articleprojects.project')->with('type')->orderBy('created_at','DESC')->get();;
            $moreArticle2 =  Article::where('type_id', 2)->with('articleprojects.project')->with('type')->orderBy('created_at','DESC')->get();;
            foreach($moreArticle1 as $key => $arti)
            {
                $moreArticle1[$key]->date = Carbon::createFromFormat('Y-m-d H:i:s', $arti->created_at)->format('F d, Y');
            }
            foreach($moreArticle2 as $key => $arti)
            {
                $moreArticle2[$key]->date = Carbon::createFromFormat('Y-m-d H:i:s', $arti->created_at)->format('F d, Y');
            }
        }

        return response()->json([
            'moreArticle'  =>  $moreArticle,
            'moreArticle1'  =>  $moreArticle1,
            'moreArticle2'  =>  $moreArticle2,
            'articles'  =>  $articles,
        ]);

    }

    public function searchArticle(Request $request){
        $search = $request->data;
        $article = Article::where('title','LIKE',"%{$search}%")
        ->orWhere('article','LIKE',"%{$search}%")->orderBy('created_at')->with('articleprojects.project')->with('type')
        ->get();
        foreach($article as $key => $arti)
        {
            $article[$key]->date = Carbon::createFromFormat('Y-m-d H:i:s', $arti->created_at)->format('F d, Y');
        }

        $allArticles =  Article::with('articleprojects.project')->with('type')->get();
        
        foreach($allArticles as $key => $arti)
        {
            $allArticles[$key]->date = Carbon::createFromFormat('Y-m-d H:i:s', $arti->created_at)->format('F d, Y');
        }

        $newsArticle = Article::where('type_id', 1)->with('articleprojects.project')->with('type')->get();
        foreach($newsArticle as $key => $arti)
        {
            $newsArticle[$key]->date = Carbon::createFromFormat('Y-m-d H:i:s', $arti->created_at)->format('F d, Y');
        }

        $announcementsArticle = Article::where('type_id', 2)->with('articleprojects.project')->with('type')->get();
        foreach($announcementsArticle as $key => $arti)
        {
            $announcementsArticle[$key]->date = Carbon::createFromFormat('Y-m-d H:i:s', $arti->created_at)->format('F d, Y');
        }

        $eventsArticle = Article::where('type_id', 3)->with('articleprojects.project')->with('type')->get();
        foreach($eventsArticle  as $key => $arti)
        {
            $eventsArticle [$key]->date = Carbon::createFromFormat('Y-m-d H:i:s', $arti->created_at)->format('F d, Y');
        }


        
        return response()->json([
            'articles'  =>  $article,
            'newsArticle' => $newsArticle,
            'announcementsArticle' => $announcementsArticle,
            'eventsArticle' => $eventsArticle,
        ]);
    }
}
