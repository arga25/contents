<?php

namespace App\Listeners;

use App\Events\ArticleCache;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class StoreArticleCache
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ArticleCache  $event
     * @return void
     */
    public function handle(ArticleCache $event)
    {
        $articles = $event->articles;
        if (Cache::has('articles'))
        {
            Cache::forget('articles');
        }

        return Cache::put('articles', $articles);
    }
}
