<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matches;
use App\Models\MatchPlayer;
use App\Models\Player;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
public function index($id)
{
    $match = Matches::with([
        'players.player',
        'innings'
    ])->findOrFail($id);

    /*
    |------------------------------------
    | 1. BLOCK UNTIL TOSS IS COMPLETED
    |------------------------------------
    */
    if (!$match->toss_winner_id || !$match->batting_first_id) {
        return redirect()
            ->route('matches.index')
            ->with('error', 'Please complete toss before starting scoring.');
    }

    /*
    |------------------------------------
    | 2. GET INNINGS SAFELY
    |------------------------------------
    */
    $innings1 = $match->innings
        ->where('innings_number', 1)
        ->first();

    $innings2 = $match->innings
        ->where('innings_number', 2)
        ->first();

    if (!$innings1 || !$innings2) {
        return redirect()
            ->route('matches.index')
            ->with('error', 'Innings not initialized. Please complete toss setup.');
    }

    /*
    |------------------------------------
    | 3. PLAYERS
    |------------------------------------
    */
    $players = $match->players;

    /*
    |------------------------------------
    | 4. TEAM IDS FROM INNINGS TABLE
    |------------------------------------
    */
    $innings1BattingTeam = $innings1->batting_team_id;
    $innings1BowlingTeam = $innings1->bowling_team_id;

    $innings2BattingTeam = $innings2->batting_team_id;
    $innings2BowlingTeam = $innings2->bowling_team_id;

    /*
    |------------------------------------
    | 5. INNINGS 1 DATA
    |------------------------------------
    */
    $innings1CurrentBatsmen = $players->where('team_id', $innings1BattingTeam)
        ->whereIn('batting_status', ['in_strike', 'in_non_strike']);

    $innings1Batsmen = $players->where('team_id', $innings1BattingTeam);

    $innings1Bowler = $players->where('team_id', $innings1BowlingTeam)
        ->whereIn('role', ['BOWL', 'AR']);

    $innings1AvailableBatsmen = $players->where('team_id', $innings1BattingTeam)
        ->where('batting_status', 'yet_to_bat');

    $innings1AvailableBowlers = $players->where('team_id', $innings1BowlingTeam)
        ->whereIn('role', ['BOWL', 'AR']);

    /*
    |------------------------------------
    | 6. INNINGS 2 DATA
    |------------------------------------
    */
    $innings2CurrentBatsmen = $players->where('team_id', $innings2BattingTeam)
        ->whereIn('batting_status', ['in_strike', 'in_non_strike']);

    $innings2Batsmen = $players->where('team_id', $innings2BattingTeam);

    $innings2Bowler = $players->where('team_id', $innings2BowlingTeam)
        ->whereIn('role', ['BOWL', 'AR']);

    $innings2AvailableBatsmen = $players->where('team_id', $innings2BattingTeam)
        ->where('batting_status', 'yet_to_bat');

    $innings2AvailableBowlers = $players->where('team_id', $innings2BowlingTeam)
        ->whereIn('role', ['BOWL', 'AR']);

    /*
    |------------------------------------
    | 7. FINAL RESPONSE STRUCTURE
    |------------------------------------
    */
    $inningsData = [
        1 => [
            'battingTeam' => $innings1BattingTeam,
            'bowlingTeam' => $innings1BowlingTeam,
            'currentBatsmen' => $innings1CurrentBatsmen,
            'batsmens' => $innings1Batsmen,
            'bowlers' => $innings1Bowler,
            'availableBatsmen' => $innings1AvailableBatsmen,
            'availableBowlers' => $innings1AvailableBowlers,
        ],
        2 => [
            'battingTeam' => $innings2BattingTeam,
            'bowlingTeam' => $innings2BowlingTeam,
            'currentBatsmen' => $innings2CurrentBatsmen,
            'batsmens' => $innings2Batsmen,
            'bowlers' => $innings2Bowler,
            'availableBatsmen' => $innings2AvailableBatsmen,
            'availableBowlers' => $innings2AvailableBowlers,
        ],
    ];

    return view('admin.scores.index', compact('match', 'inningsData'));
}

    /**
     * Update runs for a batsman.
     */
   

   

    /**
     * Set next batsman.
     */
    public function setNextBatsman(Request $request, $matchId)
    {
        $request->validate([
            'player_id' => 'required|exists:match_players,id',
        ]);

        $match = Matches::findOrFail($matchId);
        $player = MatchPlayer::where('match_id', $matchId)
            ->where('id', $request->player_id)
            ->firstOrFail();

        // Get current max batting position
        $maxPosition = MatchPlayer::where('match_id', $matchId)
    ->whereIn('batting_status', ['in_strike', 'in_non_strike'])
    ->max('batting_position') ?? 0;

        // Set player as batting
        $player->batting_status = 'in_strike';
        $player->batting_position = $maxPosition + 1;
        $player->save();

        return response()->json([
            'success' => true,
            'message' => 'Next batsman set successfully',
            'player' => $player->load('player'),
        ]);
    }

    /**
     * Set current bowler.
     */
    public function ballEvent(Request $request, $matchId)
{
    $match = Matches::findOrFail($matchId);

    $type = $request->type;
    $runs = (int) $request->runs;
    $innings = $request->innings;

    $striker = $this->getStriker($match, $innings);
    $nonStriker = $this->getNonStriker($match, $innings);
    $bowler = $this->getCurrentBowler($match, $innings);

    if (!$striker || !$bowler) {
        return response()->json([
            'success' => false,
            'message' => 'Striker or Bowler not set'
        ], 400);
    }

    $swapStrike = false;
    $isLegalBall = true;

    /* =========================
        RUNS (0,1,2,3,4,6)
    ========================== */
    if (in_array($type, ['run', 'dot'])) {

        $match->score += $runs;

        $striker->runs += $runs;
        $striker->balls_faced += 1;

        $bowler->runs_conceded += $runs;
        $bowler->balls += 1;

        if ($runs == 4) $striker->fours++;
        if ($runs == 6) $striker->sixes++;

        if ($runs % 2 == 1) {
            $swapStrike = true;
        }
    }

    /* =========================
        WIDE / NO BALL
    ========================== */
    elseif (in_array($type, ['wide', 'noball'])) {

        $match->score += 1;
        $bowler->runs_conceded += 1;

        $isLegalBall = false; // NOT counted in over
    }

    /* =========================
        WICKET (bowler credit)
    ========================== */
    elseif (in_array($type, ['wicket', 'caught'])) {

        $striker->batting_status = 'out';
        $striker->dismissal_type = $type;
        $striker->balls_faced += 1;

        $bowler->wickets += 1;
        $bowler->balls += 1;

        $match->wickets += 1;
    }

    /* =========================
        RUN OUT STRIKER
    ========================== */
    elseif ($type == 'runout_striker') {

        $striker->batting_status = 'out';
        $striker->dismissal_type = 'runout';

        $match->wickets += 1;
    }

    /* =========================
        RUN OUT NON STRIKER
    ========================== */
    elseif ($type == 'runout_nonstriker') {

        $nonStriker->batting_status = 'out';
        $nonStriker->dismissal_type = 'runout';

        $match->wickets += 1;
    }

    /* =========================
        SAVE PLAYERS
    ========================== */
    $striker->save();
    $nonStriker->save();
    $bowler->save();
    $match->save();

    /* =========================
        OVER LOGIC
    ========================== */
    if ($isLegalBall) {
        if ($swapStrike) {
            $this->swapStrikePlayers($match, $innings);
        }

        if ($bowler->balls % 6 == 0) {
            $this->swapStrikePlayers($match, $innings);
        }
    }
event(new \App\Events\BallUpdated([
    'match_id' => $match->id,
    'score' => $match->score,
    'wickets' => $match->wickets,
    'striker' => $striker,
    'bowler' => $bowler,
    'swap_strike' => $swapStrike,
]));
    return response()->json([
        'success' => true,
        'message' => 'Ball updated',
        'score' => $match->score,
        'wickets' => $match->wickets,
        'striker' => $striker,
        'bowler' => $bowler,
        'swap_strike' => $swapStrike
    ]);
}
private function getStriker($match, $innings)
{
    $team = $innings == 1
        ? $match->inning1_batting_team
        : $match->inning2_batting_team;

    return MatchPlayer::where('match_id', $match->id)
        ->where('team', $team)
        ->where('batting_status', 'in_strike')
        ->first();
}
private function getNonStriker($match, $innings)
{
    $team = $innings == 1
        ? $match->inning1_batting_team
        : $match->inning2_batting_team;

    return MatchPlayer::where('match_id', $match->id)
        ->where('team', $team)
        ->where('batting_status', 'in_non_strike')
        ->first();
}
private function getCurrentBowler($match, $innings)
{
    $team = $innings == 1
        ? $match->inning1_bowling_team
        : $match->inning2_bowling_team;

    return MatchPlayer::where('match_id', $match->id)
        ->where('team', $team)
        ->where('is_bowling', 1)
        ->first();
}
private function swapStrikePlayers($match, $innings)
{
    $striker = $this->getStriker($match, $innings);
    $nonStriker = $this->getNonStriker($match, $innings);

    $striker->batting_status = 'in_non_strike';
    $nonStriker->batting_status = 'in_strike';

    $striker->save();
    $nonStriker->save();

    return true;
}
    /**
     * Initialize batting lineup.
     */
    public function initializeBatting(Request $request, $matchId)
    {
        $match = Matches::findOrFail($matchId);
        $battingTeam = $match->batting_first ?? 'A';

        // Get first two batsmen from the batting team
        $batsmen = MatchPlayer::where('match_id', $matchId)
            ->where('team', $battingTeam)
            ->whereHas('player', function ($query) {
                $query->whereIn('role', ['BAT', 'WK', 'AR']);
            })
            ->orderBy('id')
            ->take(2)
            ->get();

        if ($batsmen->count() < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough batsmen available',
            ], 400);
        }

        $batsmen[0]->batting_status = 'in_strike';
        $batsmen[1]->batting_status = 'in_non_strike';

        $batsmen[0]->save();
        $batsmen[1]->save();

        return response()->json([
            'success' => true,
            'message' => 'Batting lineup initialized',
            'batsmen' => $batsmen->load('player'),
        ]);
    }

    /**
     * Update score for a player (legacy method).
     */
    public function update(Request $request)
    {
        $request->validate([
            'player_id' => 'required|exists:match_players,id',
            'runs' => 'required|integer|min:0',
            'wickets' => 'required|integer|min:0',
            'catches' => 'required|integer|min:0',
        ]);

        $player = MatchPlayer::findOrFail($request->player_id);
        $player->runs = $request->runs;
        $player->wickets = $request->wickets;
        $player->catches = $request->catches;
        $player->save();

        return response()->json([
            'success' => true,
            'message' => 'Score updated successfully',
        ]);
    }
}
