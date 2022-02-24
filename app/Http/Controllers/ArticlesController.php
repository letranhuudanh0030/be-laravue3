<?php

namespace App\Http\Controllers;

use App\Actions\UploadFile;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CategoryResource;
use App\Models\Article;
use App\Models\Category;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;


class ArticlesController extends Controller
{
    public function index()
    {
        return Inertia::render('Articles/Index', [
            'articles' => ArticleRepository::list(10, ['category:id,name']),
        ]);
    }

    public function showArticleByCategory(Request $request)
    {

        // dd($request->category);
        return Inertia::render('Articles/Index', [
            'articles' => ArticleRepository::list(10, ['category:id,name'], [
                ['category_id', '=', $request->category],
            ]),
            'category' => CategoryRepository::findById($request->category, ['id', 'name'])
        ]);
    }

    public function search(Request $request)
    {
        return Inertia::render('Articles/Index', [
            'articles' => ArticleRepository::list(10, ['category:id,name'], [
                ['title', 'like', "%$request->searchTerm%"],
            ]),
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Articles/Create', [
            'edit' => false,
            'article' => ArticleRepository::find(new Article()),
            'categories' => CategoryRepository::list(null, null, ['id', 'name'])
        ]);
    }

    public function createArticleByCategory(Request $request)
    {
        return Inertia::render('Articles/Create', [
            'edit' => false,
            'article' => ArticleRepository::find(new Article()),
            'category' => CategoryRepository::findById($request->category, ['id', 'name']),
            'categories' => CategoryRepository::list(null, null, ['id', 'name'])
        ]);
    }

    public function store(StoreArticleRequest $request, UploadFile $uploadFile)
    {
        $data = $request->validated();
        $data['image'] = $uploadFile->setFile($request->file('image'))
            ->setUploadPath((new Article())->uploadFolder())
            ->execute();

        Article::create($data);

        return redirect()->route('articles.index')->with('success', 'Article saved successfully.');
    }

    public function edit(Article $article)
    {
        return Inertia::render('Articles/Create', [
            'edit' => true,
            'article' => ArticleRepository::find($article),
            'category' => CategoryRepository::findById($article->category_id, ['id', 'name']),
            'categories' => CategoryRepository::list(null, null, ['id', 'name'])
        ]);
    }

    public function update(UpdateArticleRequest $request, Article $article, UploadFile $uploadFile)
    {
        $data = $request->validated();
        $data['image'] = $article->image;
        if ($request->file('image')) {
            $article->deleteImage();

            $data['image'] = $uploadFile->setFile($request->file('image'))
                ->setUploadPath((new Article())->uploadFolder())
                ->execute();
        }

        $article->update($data);

        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        $article->deleteImage();
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }
}
