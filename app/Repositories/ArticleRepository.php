<?php

namespace App\Repositories;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Repositories\Interfaces\ArticleRepositoryInterface;

class ArticleRepository implements ArticleRepositoryInterface
{
    public static function list($limit = null, $withTable = null, $where = null)
    {
        $list =
            Article::when($withTable, function ($q, $withTable) {
                return $q->with($withTable);
            })
            ->when($where, function ($q, $whereClause) {
                return $q->where($whereClause);
            })
            ->latest()
            ->when($limit, function ($q, $limit) {
                return $q->simplePaginate($limit);
            }, function ($q) {
                return $q->get();
            })->appends(request()->all());
        return ArticleResource::collection($list);
    }

    public static function find($item)
    {
        return new ArticleResource($item);
    }
}
