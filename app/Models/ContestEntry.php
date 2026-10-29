<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContestEntry extends Model
{
    protected $fillable = [
        'contest_id',
        'user_id',
        'team_id',
        'points',
        'rank',
        'winnings'
    ];

    /**
     * Get the contest for this entry.
     */
    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    /**
     * Get the user for this entry.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the team for this entry.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Calculate and update points based on team performance.
     */
    public function calculateAndUpdatePoints()
    {
        $this->points = $this->team->calculateTotalPoints();
        $this->save();
        return $this->points;
    }

    /**
     * Update rank based on contest leaderboard.
     */
    public function updateRank($rank)
    {
        $this->rank = $rank;
        $this->save();
    }

    /**
     * Update winnings.
     */
    public function updateWinnings($amount)
    {
        $this->winnings = $amount;
        $this->save();
    }
}
