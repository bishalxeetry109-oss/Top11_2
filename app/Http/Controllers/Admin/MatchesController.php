<?php

namespace App\Http\Controllers\Admin;

use App\Models\Matches;
use App\Models\MatchPlayer;
use App\Models\Player;
use App\Models\Team;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MatchesController extends Controller
{
    /**
     * Display a listing of matches.
     */
    public function index()
    {
        $matches = Matches::withCount(['players', 'contests'])
            ->orderBy('start_time', 'desc')
            ->get();
        return view('admin.matches.index', compact('matches'));
    }

    /**
     * Show the form for creating a new match.
     */
    public function create()
    {
        return view('admin.matches.add');
    }

    /**
     * Store a newly created match.
     */
    public function store(Request $request)
    {
        $request->validate([
            'team_a' => 'required|string|max:255',
            'team_b' => 'required|string|max:255',
            'venue' => 'required|string|max:255',
            'sport' => 'required|string|max:255',
            'start_time' => 'required|date',
            'status' => 'required|in:upcoming,live,completed',
        ]);
        // ✅ AUTO CREATE OR GET TEAM A
        $teamA = Team::firstOrCreate([
            'name' => $request->team_a
        ]);

        // ✅ AUTO CREATE OR GET TEAM B
        $teamB = Team::firstOrCreate([
            'name' => $request->team_b
        ]);

        $match = Matches::create([
            'team_a_id' => $teamA->id,
            'team_b_id' => $teamB->id,
            'start_time' => $request->start_time,
            'sport' => $request->sport,
            'venue' => $request->venue,
            'status' => $request->status,
            'current_innings' => 1,
            'overs_limit' => 20,
        ]);

        return redirect()
            ->route('matches.showNext', $match->id)
            ->with('success', 'Match created successfully');
    }

    /**
     * Show the form for adding players to a match.
     */
    public function showNext($id)
    {
        $match = Matches::with([
            'players',
            'teamA',
            'teamB'
        ])->findOrFail($id);

        return view('admin.matches.next', compact('match'));
    }
    /**
     * Add players to a match.
     */
    public function addPlayers(Request $request, $id)
    {
        $request->validate([
            'players' => 'required|array|min:1',
            'players.*.name' => 'required|string|max:255',
            'players.*.team' => 'required|exists:teams,id',
            'players.*.role' => 'required|in:WK,BAT,AR,BOWL',
            'players.*.credit' => 'required|numeric|min:8|max:15',
        ]);

        $match = Matches::findOrFail($id);

        foreach ($request->players as $playerData) {

            $teamId = $playerData['team'];

            // 1. Player master table
            $player = Player::firstOrCreate(
                [
                    'name' => $playerData['name'],
                    'team_id' => $teamId,
                ],
                [
                    'role' => $playerData['role'],
                    'credit' => $playerData['credit'],
                ]
            );

            // 2. Match player table
            MatchPlayer::create([
                'match_id' => $match->id,
                'player_id' => $player->id,
                'team_id' => $teamId,
                'role' => $playerData['role'],
                'credit' => $playerData['credit'],

                'is_playing' => true,
                'batting_position' => null,
                'batting_status' => 'yet_to_bat',
                'is_bowling' => false,
            ]);
        }

        return redirect()->route('matches.index')
            ->with('success', 'Players added successfully');
    } 
     /**
       * Show the form for editing a match.
       */
    public function edit($id)
    {
        $match = Matches::findOrFail($id);
        return view('admin.matches.edit', compact('match'));
    }

    /**
     * Update the specified match.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'team_a' => 'required|string|max:255',
            'team_b' => 'required|string|max:255',
            'sport' => 'required|string|max:255',
            'venue' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'required|in:upcoming,live,completed',
        ]);

        $match = Matches::findOrFail($id);
        $match->update([
            'team_a' => $request->team_a,
            'team_b' => $request->team_b,
            'sport' => $request->sport,
            'venue' => $request->venue,
            'start_time' => $request->start_time,
            'status' => $request->status,
        ]);

        return redirect()->route('matches.index')
            ->with('success', 'Match updated successfully');
    }

    /**
     * Update match status.
     */
    public function saveToss(Request $request, $matchId)
    {
        $request->validate([
            'toss_winner' => 'required',
            'toss_decision' => 'required|in:bat,bowl',
        ]);

        $match = Matches::findOrFail($matchId);

        $teamA = $match->team_a;
        $teamB = $match->team_b;

        $tossWinner = $request->toss_winner;

        /*
        |--------------------------------------------------------------------------
        | Determine batting and bowling teams
        |--------------------------------------------------------------------------
        */

        if ($request->toss_decision === 'bat') {

            $innings1BattingTeam = $tossWinner;

            $innings1BowlingTeam =
                $tossWinner === $teamA
                ? $teamB
                : $teamA;

        } else {

            $innings1BowlingTeam = $tossWinner;

            $innings1BattingTeam =
                $tossWinner === $teamA
                ? $teamB
                : $teamA;
        }

        /*
        |--------------------------------------------------------------------------
        | Save Toss Information
        |--------------------------------------------------------------------------
        */

        $match->toss_winner = $tossWinner;
        $match->toss_decision = $request->toss_decision;

        /*
        |--------------------------------------------------------------------------
        | Innings 1
        |--------------------------------------------------------------------------
        */

        $match->innings1_batting_team = $innings1BattingTeam;
        $match->innings1_bowling_team = $innings1BowlingTeam;

        /*
        |--------------------------------------------------------------------------
        | Innings 2
        |--------------------------------------------------------------------------
        */

        $match->innings2_batting_team = $innings1BowlingTeam;
        $match->innings2_bowling_team = $innings1BattingTeam;

        /*
        |--------------------------------------------------------------------------
        | Current Active Innings
        |--------------------------------------------------------------------------
        */

        $match->current_innings = 1;

        $match->batting_team = $innings1BattingTeam;
        $match->bowling_team = $innings1BowlingTeam;

        /*
        |--------------------------------------------------------------------------
        | Match Status
        |--------------------------------------------------------------------------
        */

        if (!$match->status || $match->status === 'UPCOMING') {
            $match->status = 'LIVE';
        }

        $match->save();

        return response()->json([
            'success' => true,
            'message' => 'Toss saved successfully',
            'data' => [
                'innings1_batting_team' => $match->innings1_batting_team,
                'innings1_bowling_team' => $match->innings1_bowling_team,
                'innings2_batting_team' => $match->innings2_batting_team,
                'innings2_bowling_team' => $match->innings2_bowling_team,
                'current_innings' => $match->current_innings,
            ]
        ]);
    }
    public function destroy($id)
    {
        $match = Matches::findOrFail($id);
        $match->delete();

        return redirect()->route('matches.index')
            ->with('success', 'Match deleted successfully');
    }

    /**
     * View match players.
     */
    public function viewPlayers($id)
    {
        $match = Matches::with('players')->findOrFail($id);
        return view('admin.matches.players', compact('match'));
    }
}
