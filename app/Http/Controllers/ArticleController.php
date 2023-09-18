<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255|unique:articles',
            'body' => 'required',
            'image' => 'required|image'
        ]);

        $data['image'] = $request->file('image')->store('articles');
        $data['slug'] = Str::slug($data['title']);

        $request->user()->articles()->create($data);

        return redirect(route('articles.index'))->with('success', 'Article has been created.');
    }
}
