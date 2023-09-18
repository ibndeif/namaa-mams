<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'image' => 'required|image|max:2048'
        ]);

        $data['image'] = $request->file('image')->store('articles');
        $data['slug'] = Str::slug($data['title']);

        $request->user()->articles()->create($data);

        return redirect(route('articles.index'))->with('success', 'Article has been created.');
    }

    public function edit(Article $article)
    {
        return view('articles.edit')->with('article', $article);
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title' => 'required|max:255|unique:articles,title,' . $article->id,
            'body' => 'required',
            'image' => 'image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles');
            if (!empty($article->image) && Storage::fileExists($article->getRawOriginal('image'))) {
                Storage::delete($article->getRawOriginal('image'));
            }
        }

        $data['slug'] = Str::slug($data['title']);

        $article->update($data);

        return redirect(route('articles.index'))->with('success', 'Article has been updated.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect(route('articles.index'))->with('success', 'Article has been deleted.');
    }
}
