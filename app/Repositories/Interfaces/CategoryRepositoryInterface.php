<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface
{
    public static function list($limit, $withCount, $select);

    public static function treeList($limit, $withCount);

    public static function find($item);

    public static function findById($item, $select);

    public static function create($data);

    public static function reOrder($data);
    // public static function update($data);
    // public static function delete($data);
}
