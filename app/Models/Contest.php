<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    protected $fillable = [
        'name',
        'match_id',
        'entry_fee',
        'prize_pool',
        'max_spots',
        'joined_spots',
        'status',
        'first_prize',
        'winners_count'
    ];

    /**
     * Get the match for this contest.
     */
    public function match()
    {
        return $this->belongsTo(Matches::class);
    }

    /**
     * Get the entries for this contest.
     */
    public function entries()
    {
        return $this->hasMany(ContestEntry::class);
    }

    /**
     * Get the users who joined this contest.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'contest_entries')
                    ->withPivot('points', 'rank', 'winnings')
                    ->withTimestamps();
    }

    /**
     * Check if contest is full.
     */
    public function isFull()
    {
        return $this->joined_spots >= $this->max_spots;
    }

    /**
     * Check if contest is open.
     */
    public function isOpen()
    {
        return $this->status === 'open';
    }

    /**
     * Check if contest is live.
     */
    public function isLive()
    {
        return $this->status === 'live';
    }

    /**
     * Check if contest is closed.
     */
    public function isClosed()
    {
        return $this->status === 'closed';
    }

    /**
     * Get available spots.
     */
    public function getAvailableSpotsAttribute()
    {
        return $this->max_spots - $this->joined_spots;
    }
}
