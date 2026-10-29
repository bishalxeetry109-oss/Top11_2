<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamPlayer extends Model
{
    protected $fillable = [
        'team_id',
        'match_player_id',
        'is_captain',
        'is_vice_captain'
    ];

    /**
     * Get the team that owns this player.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the match player.
     */
    public function matchPlayer()
    {
        return $this->belongsTo(MatchPlayer::class);
    }

    /**
     * Check if player is captain.
     */
    public function isCaptain()
    {
        return $this->is_captain === true;
    }

    /**
     * Check if player is vice captain.
     */
    public function isViceCaptain()
    {
        return $this->is_vice_captain === true;
    }

    /**
     * Get points with multiplier applied.
     */
    public function getPointsWithMultiplier()
    {
        $points = $this->matchPlayer->points;
        if ($this->is_captain) {
            return $points * 2;
        } elseif ($this->is_vice_captain) {
            return $points * 1.5;
        }
        return $points;
    }
}
