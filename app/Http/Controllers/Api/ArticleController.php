<?php

namespace App\Http\Controllers\Api;

use App\Events\ArticleCache;
use App\Models\Article;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $msg = '';
        $articles = Article::latest()->paginate(10);
        if (!$articles->count() > 0)
            $msg = 'Data tidak ditemukan';

        event(new ArticleCache($articles));
        return new ArticleResource(true, $msg, $articles);
    }
}
