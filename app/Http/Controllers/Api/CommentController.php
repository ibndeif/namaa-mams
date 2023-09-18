<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;

class CommentController extends Controller
{
    public function index(Article $article)
    {
        $comments = $article
            ->comments()
            ->with('author:id,name')
            ->paginate(1);
        return $comments;
    }
}
