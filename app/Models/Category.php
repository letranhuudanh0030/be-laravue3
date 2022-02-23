<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function tree($withCount = null)
    {
        $allCategories = Category::when($withCount, function ($q, $withCount) {
            return $q->withCount($withCount);
        })->latest()->get();

        $rootCategories = $allCategories->whereNull('parent_id');

        self::formatTree($rootCategories, $allCategories);

        return $rootCategories;
    }

    public static function formatTree($categories, $allCategories)
    {
        foreach ($categories as $category) {
            $category->children = $allCategories->where('parent_id', $category->id)->values();
            $category->is_child = $category->isChild();
            $category->created_at_for_human = $category->created_at->diffForHumans();
            if ($category->children->isNotEmpty()) {
                self::formatTree($category->children, $allCategories);
            }
        }
    }

    public function isChild()
    {
        return $this->parent_id !== null;
    }

    public function parent()
    {
        return Category::where('id', $this->parent_id)->first();
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
