<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function index(Request $request)
    {
        $query = Article::latest();

        if (isset($request->term)) {
            $query->matchByTerm($request->term);
        }

        if (isset($request->status)) {
            $query->matchByStatus($request->status);
        }

        $articles = $query->get();
        return view('articles.index')->with('articles', $articles);
    }
}
