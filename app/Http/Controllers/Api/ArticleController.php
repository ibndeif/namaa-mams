<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::latest()->published()->with('author', function ($query) {
            $query->select('id', 'name');
        })->select('id', 'title', 'slug', 'image', 'created_at', 'author_id');

        if (isset($request->term)) {
            $query->matchByTerm($request->term);
        }

        return $query->paginate(15);
    }
}
