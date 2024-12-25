<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
	{
		return[
			new Middleware('permission:view articles', only: ['index']),
			new Middleware('permission:edit articles', only: ['edit']),
			new Middleware('permission:create articles', only: ['create']),
			new Middleware('permission:delete articles', only: ['destroy']),		
		
		];
		
	}
    
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
        // dd($article->id);
        // $article = Article::find($article);
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
        // dd($request, $article);
        $validator = Validator::make($request->all(),[
            'title' => 'required|min:3|regex:/^[a-zA-Z0-9 _-]+$/',
            'article' => 'required|min:3',
        ],[
            'name.regex' => 'The input field must contain only letters, spaces, underscores, or dashes.',
        ]);

        if($validator->passes()){
            $article = Article::find($article->id);
            $article->title = $request->input('title');
            $article->article = $request->input('article');
            $article->update();
            return redirect()->route('articles.index')->with('success','Article update successfully');
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $id = $article->id;
        $permission = Article::find($id);
        if( $permission == null){
            session()->flash('error','Article not found');
            return response()->json([
                'status' => false,
            ]);
        }

        $permission->delete();
        session()->flash('error','Article deleted successfully');
        return response()->json([
            'status' => true,
        ]);
    }
}
