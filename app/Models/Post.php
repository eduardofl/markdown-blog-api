<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    protected $fillable = [
        'id',
        'title',
        'description',
        'content',
        'created_at',
        'updated_at',
    ];
}
