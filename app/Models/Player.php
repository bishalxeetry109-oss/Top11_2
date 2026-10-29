<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'name',
        'team_id',
        'role',
        'credit',
        'points',
        'image'
    ];

    /**
     * Get the match players for this player.
     */
    public function matchPlayers()
    {
        return $this->hasMany(MatchPlayer::class);
    }

    /**
     * Get the team players for this player.
     */
    public function teamPlayers()
    {
        return $this->hasManyThrough(TeamPlayer::class, MatchPlayer::class, 'player_id', 'match_player_id', 'id', 'id');
    }
}
