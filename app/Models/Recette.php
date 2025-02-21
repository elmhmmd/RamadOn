<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recette extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'content', 'image'];

    public function category()
    
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()

    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
