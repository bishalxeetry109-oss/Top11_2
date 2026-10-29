<?php

namespace App\Services\Cricket;

use App\Models\MatchInnings;
use App\Models\InningsState;
use App\Models\BatsmanScorecard;
use App\Models\BowlerScorecard;
use App\Models\BallByBall;

class BallProcessingService
{
    public function process($matchId, $inningsId, $strikerId, $nonStrikerId, $bowlerId, $runs, $isWicket = false)
    {
        $innings = MatchInnings::findOrFail($inningsId);
        $state = InningsState::where('innings_id', $inningsId)->first();

        $this->updateBallCount($innings);
        $this->updateScore($innings, $runs, $isWicket);
        $this->updateBatsman($inningsId, $strikerId, $runs, $isWicket);
        $this->updateBowler($inningsId, $bowlerId, $runs, $isWicket);
        $this->saveBall($matchId, $inningsId, $strikerId, $nonStrikerId, $bowlerId, $runs, $isWicket);

        $state = $this->updateStrikerLogic($state, $runs, $isWicket, $innings);

        return [
            'runs' => $innings->runs,
            'wickets' => $innings->wickets,
            'overs' => $innings->overs,
            'striker' => $state->striker_id,
            'non_striker' => $state->non_striker_id,
        ];
    }
    private function updateBallCount($innings)
{
    $innings->balls += 1;

    $overs = intdiv($innings->balls, 6);
    $balls = $innings->balls % 6;

    $innings->overs = $overs . '.' . $balls;

    $innings->save();
}
private function updateScore($innings, $runs, $isWicket)
{
    $innings->runs += $runs;

    if ($isWicket) {
        $innings->wickets += 1;
    }

    $innings->save();
}
private function updateBatsman($inningsId, $playerId, $runs, $isWicket)
{
    $batsman = BatsmanScorecard::firstOrCreate([
        'innings_id' => $inningsId,
        'player_id' => $playerId,
    ]);

    $batsman->runs += $runs;
    $batsman->balls += 1;

    if ($runs == 4) $batsman->fours += 1;
    if ($runs == 6) $batsman->sixes += 1;

    if ($isWicket) $batsman->is_out = true;

    $batsman->save();
}
}