<?php

namespace App\Models;

use App\Contracts\ImageableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Traits\Imageable;


class Article extends Model implements ImageableContract
{
    use HasFactory;
    use Imageable;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withDefault();
    }

    public function uploadFolder(): string
    {
        return "public/articles";
    }
}
