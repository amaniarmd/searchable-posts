<?php

namespace App\Models;

use App\Enumerations\Post\Fields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        Fields::TITLE->value,
        Fields::BODY->value,
        Fields::CATEGORY_ID->value
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
