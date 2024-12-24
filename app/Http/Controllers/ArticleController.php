<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $articles = Article::orderBy('title','ASC')->paginate(2);

        return view('articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
       $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'article' => ['nullable', 'string'],
            'author' => ['required', 'string', 'max:255'],
        ]);

        $article = Article::create([
            'title' => $request->title,
            'article' => $request->article,
            'author' => $request->author,
        ]);

       if($article){
            return redirect()->route('articles.index')->with('success','Article created successfully');
        }else{
            return redirect()->back()->withErrors('')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
        return view('articles.show',compact('article'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
