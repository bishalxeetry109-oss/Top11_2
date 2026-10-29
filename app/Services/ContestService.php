<?php

namespace App\Services;

use App\Models\Contest;
use App\Models\ContestEntry;
use App\Models\User;

class ContestService
{
    /**
     * Join a contest.
     *
     * @param User $user
     * @param Contest $contest
     * @param int $teamId
     * @return array
     */
    public static function joinContest(User $user, Contest $contest, $teamId)
    {
        // Check if contest is open
        if (!$contest->isOpen()) {
            return [
                'success' => false,
                'message' => 'Contest is not open for joining'
            ];
        }

        // Check if contest is full
        if ($contest->isFull()) {
            return [
                'success' => false,
                'message' => 'Contest is full'
            ];
        }

        // Check if user already joined this contest with this team
        $existingEntry = ContestEntry::where('contest_id', $contest->id)
            ->where('user_id', $user->id)
            ->where('team_id', $teamId)
            ->first();

        if ($existingEntry) {
            return [
                'success' => false,
                'message' => 'You have already joined this contest with this team'
            ];
        }

        // Check if user has sufficient balance
        if ($user->wallet < $contest->entry_fee) {
            return [
                'success' => false,
                'message' => 'Insufficient wallet balance'
            ];
        }

        // Deduct entry fee from wallet
        $user->wallet -= $contest->entry_fee;
        $user->save();

        // Create contest entry
        $entry = ContestEntry::create([
            'contest_id' => $contest->id,
            'user_id' => $user->id,
            'team_id' => $teamId,
            'points' => 0,
            'rank' => null,
            'winnings' => 0,
        ]);

        // Increment joined spots
        $contest->joined_spots++;
        $contest->save();

        return [
            'success' => true,
            'message' => 'Successfully joined the contest',
            'entry' => $entry
        ];
    }

    /**
     * Calculate and update rankings for a contest.
     *
     * @param Contest $contest
     * @return array
     */
    public static function calculateRankings(Contest $contest)
    {
        $entries = $contest->entries()
            ->with('team')
            ->get()
            ->sortByDesc(function ($entry) {
                return TeamValidationService::calculateTeamPoints($entry->team);
            });

        $rank = 1;
        foreach ($entries as $entry) {
            $entry->points = TeamValidationService::calculateTeamPoints($entry->team);
            $entry->rank = $rank;
            $entry->save();
            $rank++;
        }

        return [
            'success' => true,
            'message' => 'Rankings calculated successfully',
            'entries_updated' => $entries->count()
        ];
    }

    /**
     * Distribute prizes for a contest.
     *
     * @param Contest $contest
     * @return array
     */
    public static function distributePrizes(Contest $contest)
    {
        if (!$contest->isClosed()) {
            return [
                'success' => false,
                'message' => 'Contest must be closed to distribute prizes'
            ];
        }

        $entries = $contest->entries()
            ->whereNotNull('rank')
            ->orderBy('rank')
            ->get();

        $totalPrize = $contest->prize_pool;
        $winnersCount = $contest->winners_count ?? 1;

        // Prize distribution logic
        $prizes = self::calculatePrizeDistribution($totalPrize, $winnersCount);

        foreach ($entries as $entry) {
            if ($entry->rank <= $winnersCount) {
                $prize = $prizes[$entry->rank - 1] ?? 0;
                $entry->winnings = $prize;
                $entry->save();

                // Add winnings to user wallet
                $entry->user->wallet += $prize;
                $entry->user->save();
            }
        }

        return [
            'success' => true,
            'message' => 'Prizes distributed successfully',
            'total_distributed' => array_sum($prizes)
        ];
    }

    /**
     * Calculate prize distribution.
     *
     * @param float $totalPrize
     * @param int $winnersCount
     * @return array
     */
    private static function calculatePrizeDistribution($totalPrize, $winnersCount)
    {
        $prizes = [];
        
        // Simple distribution: winner gets 50%, rest distributed equally
        if ($winnersCount === 1) {
            $prizes[0] = $totalPrize;
        } else {
            $firstPrize = $totalPrize * 0.5;
            $remainingPrize = $totalPrize - $firstPrize;
            $prizePerWinner = $remainingPrize / ($winnersCount - 1);

            $prizes[0] = $firstPrize;
            for ($i = 1; $i < $winnersCount; $i++) {
                $prizes[$i] = $prizePerWinner;
            }
        }

        return $prizes;
    }

    /**
     * Get contest leaderboard.
     *
     * @param Contest $contest
     * @return \Illuminate\Support\Collection
     */
    public static function getLeaderboard(Contest $contest)
    {
        return $contest->entries()
            ->with(['user', 'team'])
            ->orderBy('points', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Get user's contest history.
     *
     * @param User $user
     * @return \Illuminate\Support\Collection
     */
    public static function getUserContestHistory(User $user)
    {
        return $user->contestEntries()
            ->with(['contest.match', 'team'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get contest statistics.
     *
     * @param Contest $contest
     * @return array
     */
    public static function getContestStats(Contest $contest)
    {
        $entries = $contest->entries;

        return [
            'total_entries' => $entries->count(),
            'available_spots' => $contest->available_spots,
            'total_points' => $entries->sum('points'),
            'average_points' => $entries->avg('points'),
            'max_points' => $entries->max('points'),
            'min_points' => $entries->min('points'),
            'total_winnings' => $entries->sum('winnings'),
        ];
    }
}
