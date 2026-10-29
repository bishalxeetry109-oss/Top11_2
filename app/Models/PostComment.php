<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'comment'
    ];

    /**
     * Get the post for this comment.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the user who created this comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
