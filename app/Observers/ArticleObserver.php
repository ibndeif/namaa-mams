<?php

namespace App\Observers;

use App\Mail\ArticleCreated;
use App\Models\Article;
use Illuminate\Support\Facades\Mail;

class ArticleObserver
{
    /**
     * Handle the Article "created" event.
     */
    public function created(Article $article): void
    {
        Mail::send(new ArticleCreated($article));
    }
}
