<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $this->authorize('create', Comment::class);

        $data = $request->validate([
            'body' => 'required'
        ]);

        $article->comments()->create([
            'body' => $data['body'],
            'author_id' => $request->user()->id
        ]);

        return back()->with('success', 'Your comment has been placed');
    }

    public function destroy($_, Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return back()->with('success', 'Comment has been deleted');
    }
}
