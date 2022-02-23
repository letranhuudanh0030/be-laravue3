<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Traits\Paginateable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;


class CategoriesController extends Controller
{
    use Paginateable;

    public function index()
    {
        return Inertia::render('Categories/Index', [
            'categories' => CategoryRepository::list(10, ['articles']),
        ]);
    }

    public function indexRecursive()
    {
        return Inertia::render('Categories/IndexRecursive', [
            'categories' => CategoryRepository::treeList(10, ['articles']),
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Categories/Create', [
            'edit' => false,
            'category' => (object) [],
            'categories' => CategoryRepository::list(),
        ]);
    }

    public function createRecursive(Category $category)
    {
        return Inertia::render('Categories/Create', [
            'edit' => false,
            'category' => CategoryRepository::find($category),
            'categories' => CategoryRepository::list(),
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        CategoryRepository::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Category saved successfully.');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Categories/Create', [
            'edit' => true,
            'category' => new CategoryResource($category),
            'categories' => CategoryResource::collection(Category::latest()->get()),
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
