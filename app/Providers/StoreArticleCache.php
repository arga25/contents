<?php

namespace App\Providers;

use App\Providers\ArticleCache;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
     * @param  \App\Providers\ArticleCache  $event
     * @return void
     */
    public function handle(ArticleCache $event)
    {
        //
    }
}
