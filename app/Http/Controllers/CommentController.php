<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $data = $request->validate([
            'body' => 'required'
        ]);

        $article->comments()->create([
            'body' => $data['body'],
            'author_id' => $request->user()->id
        ]);

        return back()->with('success', 'Your comment has been placed');
    }
}
