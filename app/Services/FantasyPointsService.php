<?php

namespace App\Services;

use App\Models\MatchPlayer;

class FantasyPointsService
{
    /**
     * Fantasy points configuration.
     */
    const POINTS_CONFIG = [
        'run' => 1,
        'wicket' => 25,
        'catch' => 10,
        'stumping' => 10,
        'run_out' => 10,
        'maiden_over' => 4,
        'bonus_30_runs' => 4,
        'bonus_50_runs' => 8,
        'bonus_100_runs' => 16,
        'bonus_3_wickets' => 4,
        'bonus_5_wickets' => 8,
        'bonus_100_strike_rate' => 2,
        'bonus_150_strike_rate' => 4,
        'bonus_economy_under_5' => 2,
        'bonus_economy_under_4' => 4,
    ];

    /**
     * Calculate fantasy points for a player.
     *
     * @param MatchPlayer $player
     * @return int
     */
    public static function calculatePoints(MatchPlayer $player)
    {
        $points = 0;

        // Basic points
        $points += $player->runs * self::POINTS_CONFIG['run'];
        $points += $player->wickets * self::POINTS_CONFIG['wicket'];
        $points += $player->catches * self::POINTS_CONFIG['catch'];

        // Bonus points for milestones
        $points += self::calculateBonusPoints($player);

        return $points;
    }

    /**
     * Calculate bonus points for milestones.
     *
     * @param MatchPlayer $player
     * @return int
     */
    private static function calculateBonusPoints(MatchPlayer $player)
    {
        $bonus = 0;

        // Run milestones
        if ($player->runs >= 100) {
            $bonus += self::POINTS_CONFIG['bonus_100_runs'];
        } elseif ($player->runs >= 50) {
            $bonus += self::POINTS_CONFIG['bonus_50_runs'];
        } elseif ($player->runs >= 30) {
            $bonus += self::POINTS_CONFIG['bonus_30_runs'];
        }

        // Wicket milestones
        if ($player->wickets >= 5) {
            $bonus += self::POINTS_CONFIG['bonus_5_wickets'];
        } elseif ($player->wickets >= 3) {
            $bonus += self::POINTS_CONFIG['bonus_3_wickets'];
        }

        return $bonus;
    }

    /**
     * Update player points.
     *
     * @param MatchPlayer $player
     * @return int
     */
    public static function updatePlayerPoints(MatchPlayer $player)
    {
        $points = self::calculatePoints($player);
        $player->points = $points;
        $player->save();

        return $points;
    }

    /**
     * Bulk update points for multiple players.
     *
     * @param array $playersData
     * @return array
     */
    public static function bulkUpdatePoints($playersData)
    {
        $results = [];

        foreach ($playersData as $playerData) {
            $player = MatchPlayer::find($playerData['id']);
            
            if ($player) {
                $player->runs = $playerData['runs'] ?? 0;
                $player->wickets = $playerData['wickets'] ?? 0;
                $player->catches = $playerData['catches'] ?? 0;
                
                $points = self::updatePlayerPoints($player);
                
                $results[] = [
                    'player_id' => $player->id,
                    'player_name' => $player->name,
                    'points' => $points,
                    'success' => true
                ];
            }
        }

        return $results;
    }

    /**
     * Get points breakdown for a player.
     *
     * @param MatchPlayer $player
     * @return array
     */
    public static function getPointsBreakdown(MatchPlayer $player)
    {
        $breakdown = [
            'runs' => [
                'count' => $player->runs,
                'points_per' => self::POINTS_CONFIG['run'],
                'total' => $player->runs * self::POINTS_CONFIG['run']
            ],
            'wickets' => [
                'count' => $player->wickets,
                'points_per' => self::POINTS_CONFIG['wicket'],
                'total' => $player->wickets * self::POINTS_CONFIG['wicket']
            ],
            'catches' => [
                'count' => $player->catches,
                'points_per' => self::POINTS_CONFIG['catch'],
                'total' => $player->catches * self::POINTS_CONFIG['catch']
            ],
            'bonus' => self::calculateBonusPoints($player),
            'total' => $player->points
        ];

        return $breakdown;
    }

    /**
     * Get top performers for a match.
     *
     * @param int $matchId
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public static function getTopPerformers($matchId, $limit = 5)
    {
        return MatchPlayer::where('match_id', $matchId)
            ->orderBy('points', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get player statistics summary.
     *
     * @param MatchPlayer $player
     * @return array
     */
    public static function getPlayerStats(MatchPlayer $player)
    {
        return [
            'name' => $player->name,
            'team' => $player->team,
            'role' => $player->role,
            'credit' => $player->credit,
            'runs' => $player->runs,
            'wickets' => $player->wickets,
            'catches' => $player->catches,
            'points' => $player->points,
            'points_breakdown' => self::getPointsBreakdown($player)
        ];
    }
}
