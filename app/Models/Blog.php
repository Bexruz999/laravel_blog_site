<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Blog extends Model
{

    protected $fillable = [
        'title',
        'slug',
        'image',
        'blog_content_id',
        'author_id',
        'short_desc'
    ];

    public function content():BelongsTo
    {
        return $this->belongsTo(BlogContent::class, 'blog_content_id', 'id');
    }
}
