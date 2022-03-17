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

    private $category;

    function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        return Inertia::render('Categories/Index', [
            'categories' => $this->category->list(10, ['articles']),
        ]);
    }

    public function indexRecursive()
    {
        return Inertia::render('Categories/IndexRecursive', [
            'categories' => $this->category->treeList(10, ['articles']),
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Categories/Create', [
            'edit' => false,
            'category' => (object)[],
            'categories' => $this->category->list(),
        ]);
    }

    public function createRecursive(Category $category)
    {
        $sort = false;
        if (request('sort')) {
            $sort = true;
        }

        return Inertia::render('Categories/Create', [
            'edit' => false,
            'sort' => $sort,
            'category' => $this->category->find($category),
            'categories' => $this->category->list(),
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        // dd($request->all());
        $data = $request->validated();
        if ($request->sort) {
            $data += ['sort_order' => $request->sort_order];
        }
        $this->category->create($data);
        return redirect()->route('categories.index.recursive')->with('success', 'Category saved successfully.');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Categories/Create', [
            'edit' => true,
            'category' => $this->category->find($category),
            'categories' => $this->category->list(),
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        return redirect()->route('categories.index.recursive')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index.recursive')->with('success', 'Category deleted successfully.');
    }

    public function reOrder(Request $request)
    {
        $this->category->reOrder($request);

        return redirect()->route('categories.index.recursive')->with('success', 'Re order successfully.');
    }
}
