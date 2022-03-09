<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function creating(Category $category)
    {
        // dd(Category::where('parent_id', $category->parent_id)->max('sort_order') + 1);
        if(is_null($category->sort_order)){
            $category->sort_order = Category::where('parent_id', $category->parent_id)->max('sort_order') + 1;
            return;
        }

        // $lowerPriorityCategories = Category::where(['sort_order', '>=', $category->sort_order])
        //     ->get();

        // foreach ($lowerPriorityCategories as $lowerPriorityCategory) {
        //     $lowerPriorityCategory->sort_order++;
        //     $lowerPriorityCategory->saveQuietly();
        // }
    }
}
