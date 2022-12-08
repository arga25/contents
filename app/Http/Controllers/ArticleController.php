<?php

namespace App\Http\Controllers;

use App\Events\ArticleCache;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        $first = $articles->firstItem();
        return view('articles.index')
                ->with('articles', $articles)
                ->with('first', $first);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = [
            'title' => '',
            'content' => ''
        ];

        $prevUrl = str_replace(url('/'), '', url()->previous());
        return view('articles.form')
                ->with('title', 'New Article')
                ->with('previous', $prevUrl)
                ->with('post', $post)
                ->with('update', false);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug = Str::slug($request->title);
        $request->validate([
            'title' => 'required|string|max:190|unique:articles,title',
            'content' => 'required|string',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imgname = Str::snake($request->title)."_".time().'.'.$request->file->extension();  
        $request->file->move(public_path('storage'), $imgname);

        $article = new Article;
        $article->title = $request->title;
        $article->slug = $slug;
        $article->content = $request->content;
        $article->article_image = $imgname;
        $article->article_creator = auth()->user()->name;
        $article->save();

        event(new ArticleCache(Article::latest()->paginate(10)));
        return redirect()->route('article')->with('success','Article Has Been saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
        if (!$article)
            return redirect()->route('article')->with('error','Something wrong');

        $prevUrl = str_replace(url('/'), '', url()->previous());
        return view('articles.detail')
            ->with('article', $article)
            ->with('previous', $prevUrl);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::find($id);
        if (!$article)
            return redirect()->route('article')->with('error','Something wrong');
        
        $post = [
            'title' => $article->title,
            'content' => $article->content
        ];

        $prevUrl = str_replace(url('/'), '', url()->previous());
        return view('articles.form')
            ->with('id', $id)
            ->with('title', 'Update '.$article->title)
            ->with('previous', $prevUrl)
            ->with('post', $post)
            ->with('update', true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $slug = Str::slug($request->title);
        $request->validate([
            'title' => 'required|string|max:190|unique:articles,title,'.$id,
            'content' => 'required|string',
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $article = Article::find($id);
        $article->title = $request->title;
        $article->slug = $slug;
        $article->content = $request->content;
        
        if ($request->file)
        {
            $imgname = Str::snake($request->title)."_".time().'.'.$request->file->extension();  
            $request->file->move(public_path('storage'), $imgname);
            if (file_exists(public_path('storage/'.$article->article_image)))
            {
                @unlink(public_path('storage/'.$article->article_image));
            }
            $article->article_image = $imgname;
        }
        $article->save();

        event(new ArticleCache(Article::latest()->paginate(10)));
        return redirect()->route('article')->with('success','Article Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        if (file_exists(public_path('storage/'.$article->article_image)))
        {
            @unlink(public_path('storage/'.$article->article_image));
        }

        $article->delete();
        event(new ArticleCache(Article::latest()->paginate(10)));
        return redirect()->route('article')->with('success','Article Has Been deleted successfully');
    }
}