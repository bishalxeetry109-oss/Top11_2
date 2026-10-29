<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'short_name',
        'logo'
    ];

    /**
     * Players belonging to this team (real players)
     */
    public function players()
    {
        return $this->hasMany(Player::class);
    }

    /**
     * Matches where this team is Team A
     */
    public function matchesAsTeamA()
    {
        return $this->hasMany(Matches::class, 'team_a_id');
    }

    /**
     * Matches where this team is Team B
     */
    public function matchesAsTeamB()
    {
        return $this->hasMany(Matches::class, 'team_b_id');
    }
}