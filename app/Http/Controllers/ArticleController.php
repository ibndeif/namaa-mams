<?php

namespace App\Http\Controllers;

use App\Enum\ArticleStatus;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('viewAny', Article::class);

        $query = Article::latest()->with('author', function ($query) {
            $query->select('id', 'name');
        });

        if ($request->filled('term')) {
            $query->matchByTerm($request->term);
        }

        if ($request->filled('status')) {
            $query->matchByStatus($request->status);
        }

        if ($request->filled('my-articles-only')) {
            $query->where('author_id', $request->user()->id);
        }

        $articles = $query->paginate(15);

        return view('articles.index')->with('articles', $articles);
    }

    public function create()
    {
        $this->authorize('create', Article::class);
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Article::class);

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
        $this->authorize('update', $article);

        return view('articles.edit')->with('article', $article);
    }

    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);

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
        $this->authorize('delete', $article);

        $article->delete();
        return redirect(route('articles.index'))->with('success', 'Article has been deleted.');
    }

    public function show(Article $article)
    {
        $this->authorize('view', $article);

        $article->load('comments.author'); // load relations to avoid n+1 problem
        return view('articles.show')->with('article', $article);
    }

    public function publish(Article $article)
    {
        $this->authorize('publish', $article);

        $article->update(['status' => ArticleStatus::Published->value]);
        return redirect(route('articles.index'))->with('success', 'Article has been published.');
    }

    public function unpublish(Article $article)
    {
        $this->authorize('unpublish', $article);

        $article->update(['status' => ArticleStatus::Unpublished->value]);
        return redirect(route('articles.index'))->with('success', 'Article has been unpublished.');
    }
}
