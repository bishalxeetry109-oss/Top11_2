<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'image',
        'type',
        'likes'
    ];

    /**
     * Get the user who created this post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the comments for this post.
     */
    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    /**
     * Increment likes count.
     */
    public function incrementLikes()
    {
        $this->increment('likes');
    }

    /**
     * Decrement likes count.
     */
    public function decrementLikes()
    {
        if ($this->likes > 0) {
            $this->decrement('likes');
        }
    }

    /**
     * Check if post is news.
     */
    public function isNews()
    {
        return $this->type === 'news';
    }

    /**
     * Check if post is result.
     */
    public function isResult()
    {
        return $this->type === 'result';
    }

    /**
     * Check if post is announcement.
     */
    public function isAnnouncement()
    {
        return $this->type === 'announcement';
    }
}
