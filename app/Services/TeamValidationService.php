<?php

namespace App\Services;

use App\Models\Team;
use App\Models\MatchPlayer;

class TeamValidationService
{
    /**
     * Validate team creation rules.
     *
     * @param array $playerIds
     * @param int $matchId
     * @return array
     */
    public static function validateTeam($playerIds, $matchId)
    {
        $errors = [];

        // Rule 1: Exactly 11 players
        if (count($playerIds) !== 11) {
            $errors[] = "Team must have exactly 11 players. Currently has " . count($playerIds) . " players.";
        }

        // Get all players
        $players = MatchPlayer::whereIn('id', $playerIds)
            ->where('match_id', $matchId)
            ->get();

        // Rule 2: Max 100 credits
        $totalCredits = $players->sum('credit');
        if ($totalCredits > 100) {
            $errors[] = "Total credits cannot exceed 100. Currently using {$totalCredits} credits.";
        }

        // Rule 3: Role limits
        $roleCounts = [
            'WK' => 0,
            'BAT' => 0,
            'AR' => 0,
            'BOWL' => 0
        ];

        foreach ($players as $player) {
            $roleCounts[$player->role]++;
        }

        // WK: 1-4
        if ($roleCounts['WK'] < 1 || $roleCounts['WK'] > 4) {
            $errors[] = "Must have 1-4 Wicket Keepers. Currently has {$roleCounts['WK']}.";
        }

        // BAT: 3-6
        if ($roleCounts['BAT'] < 3 || $roleCounts['BAT'] > 6) {
            $errors[] = "Must have 3-6 Batsmen. Currently has {$roleCounts['BAT']}.";
        }

        // BOWL: 3-6
        if ($roleCounts['BOWL'] < 3 || $roleCounts['BOWL'] > 6) {
            $errors[] = "Must have 3-6 Bowlers. Currently has {$roleCounts['BOWL']}.";
        }

        // AR: 1-4
        if ($roleCounts['AR'] < 1 || $roleCounts['AR'] > 4) {
            $errors[] = "Must have 1-4 All Rounders. Currently has {$roleCounts['AR']}.";
        }

        // Rule 4: Max 7 players from one team
        $teamCounts = [
            'A' => 0,
            'B' => 0
        ];

        foreach ($players as $player) {
            $teamCounts[$player->team]++;
        }

        if ($teamCounts['A'] > 7 || $teamCounts['B'] > 7) {
            $errors[] = "Cannot select more than 7 players from one team. Team A: {$teamCounts['A']}, Team B: {$teamCounts['B']}.";
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
            'stats' => [
                'total_players' => count($playerIds),
                'total_credits' => $totalCredits,
                'role_counts' => $roleCounts,
                'team_counts' => $teamCounts
            ]
        ];
    }

    /**
     * Validate captain and vice-captain selection.
     *
     * @param int $captainId
     * @param int $viceCaptainId
     * @param array $playerIds
     * @return array
     */
    public static function validateCaptains($captainId, $viceCaptainId, $playerIds)
    {
        $errors = [];

        // Captain and vice-captain must be different
        if ($captainId === $viceCaptainId) {
            $errors[] = "Captain and Vice-Captain must be different players.";
        }

        // Both must be in the team
        if (!in_array($captainId, $playerIds)) {
            $errors[] = "Captain must be in the team.";
        }

        if (!in_array($viceCaptainId, $playerIds)) {
            $errors[] = "Vice-Captain must be in the team.";
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Calculate team points with captain/vice-captain multipliers.
     *
     * @param Team $team
     * @return int
     */
    public static function calculateTeamPoints(Team $team)
    {
        $totalPoints = 0;

        foreach ($team->players as $teamPlayer) {
            $playerPoints = $teamPlayer->matchPlayer->points;

            if ($teamPlayer->is_captain) {
                $playerPoints *= 2;
            } elseif ($teamPlayer->is_vice_captain) {
                $playerPoints *= 1.5;
            }

            $totalPoints += $playerPoints;
        }

        return $totalPoints;
    }

    /**
     * Get team statistics.
     *
     * @param Team $team
     * @return array
     */
    public static function getTeamStats(Team $team)
    {
        $players = $team->players->map(function ($teamPlayer) {
            return $teamPlayer->matchPlayer;
        });

        return [
            'total_players' => $players->count(),
            'total_credits' => $players->sum('credit'),
            'total_points' => self::calculateTeamPoints($team),
            'role_counts' => [
                'WK' => $players->where('role', 'WK')->count(),
                'BAT' => $players->where('role', 'BAT')->count(),
                'AR' => $players->where('role', 'AR')->count(),
                'BOWL' => $players->where('role', 'BOWL')->count(),
            ],
            'team_counts' => [
                'A' => $players->where('team', 'A')->count(),
                'B' => $players->where('team', 'B')->count(),
            ]
        ];
    }
}
