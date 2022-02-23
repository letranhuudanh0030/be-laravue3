<?php

namespace App\Repositories;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\Paginateable;

class CategoryRepository implements CategoryRepositoryInterface
{
    use Paginateable;

    public static function list($limit = null, $withCount = null)
    {
        $list =
            Category::when($withCount, function ($q, $withCount) {
                return $q->withCount($withCount);
            })
            ->latest()
            ->when($limit, function ($q, $limit) {
                return $q->simplePaginate($limit);
            }, function ($q) {
                return $q->get();
            });

        return CategoryResource::collection($list);
    }

    public static function treeList($limit = null, $withCount = null)
    {
        $tree = Category::tree($withCount);
        $list = $tree;
        if ($limit) {
            $list = Paginateable::pagicoll($tree, $limit);
        }
        return CategoryResource::collection($list);
    }

    public static function find($item)
    {
        return new CategoryResource($item);
    }

    public static function create($data)
    {
        Category::create($data);
    }
}
