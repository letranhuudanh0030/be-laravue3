<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function creating(Category $category)
    {
        // dd($category);
        if(is_null($category->sort_order)){
            $category->sort_order = Category::where('parent_id', $category->parent_id)->max('sort_order') + 1;
            return;
        }

        $lowerPriorityCategories = Category::where('parent_id', $category->parent_id)->where('sort_order', '>=', $category->sort_order)->get();

        // dd($lowerPriorityCategories);
        foreach ($lowerPriorityCategories as $lowerPriorityCategory) {
            $lowerPriorityCategory->sort_order++;
            $lowerPriorityCategory->saveQuietly();
        }
    }
}
