<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchInnings extends Model
{
    protected $table = 'match_innings';

    protected $fillable = [
        'match_id',
        'innings_number',
        'batting_team_id',
        'bowling_team_id',
        'runs',
        'wickets',
        'overs',
        'balls',
        'is_completed'
    ];

}
