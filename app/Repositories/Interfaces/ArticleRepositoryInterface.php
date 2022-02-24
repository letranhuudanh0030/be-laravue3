<?php

namespace App\Repositories\Interfaces;

interface ArticleRepositoryInterface
{
    public static function list($limit, $withTable, $whereClause);
    public static function find($item);
}
