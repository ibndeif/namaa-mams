<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function index(Request $request)
    {
        $query = Article::latest()->with('author', function ($query) {
            $query->select('id', 'name');
        });

        if (isset($request->term)) {
            $query->matchByTerm($request->term);
        }

        if (isset($request->status)) {
            $query->matchByStatus($request->status);
        }

        $articles = $query->paginate(15);

        return view('articles.index')->with('articles', $articles);
    }
}
