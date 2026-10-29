<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchPlayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_id',
        'player_id',
        'team_id',
        'role',
        'credit',

        'is_playing',
        'batting_position',
        'batting_status',
        'is_bowling',
    ];

    protected $casts = [
        'is_playing' => 'boolean',
        'is_bowling' => 'boolean',
    ];

    public function match()
    {
        return $this->belongsTo(Matches::class, 'match_id');
    }

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
    /**
     * Calculate strike rate.
     */
    public function calculateStrikeRate()
    {
        if ($this->balls_faced > 0) {
            $this->strike_rate = ($this->runs / $this->balls_faced) * 100;
        } else {
            $this->strike_rate = 0;
        }
        $this->save();
    }

    /**
     * Calculate economy rate.
     */
    public function calculateEconomy()
    {
        if ($this->overs_bowled > 0) {
            $this->economy = $this->runs_conceded / $this->overs_bowled;
        } else {
            $this->economy = 0;
        }
        $this->save();
    }

    /**
     * Calculate fantasy points.
     */
    public function calculateFantasyPoints()
    {
        $points = 0;

        // Batting points
        $points += $this->runs; // 1 point per run
        $points += $this->fours * 1; // 1 point per four
        $points += $this->sixes * 2; // 2 points per six

        // Bonus for half-century
        if ($this->runs >= 50) {
            $points += 8;
        }

        // Bonus for century
        if ($this->runs >= 100) {
            $points += 16;
        }

        // Bowling points
        $points += $this->wickets * 25; // 25 points per wicket
        $points += $this->maidens * 8; // 8 points per maiden

        // Bonus for 3+ wickets
        if ($this->wickets >= 3) {
            $points += 4;
        }

        // Bonus for 5+ wickets
        if ($this->wickets >= 5) {
            $points += 8;
        }

        // Fielding points
        $points += $this->catches * 8; // 8 points per catch
        $points += $this->stumpings * 12; // 12 points per stumping
        $points += $this->run_outs * 6; // 6 points per run out

        $this->points = $points;
        $this->save();

        return $points;
    }
}
