<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Cricket\BallProcessingService;
use App\Events\BallUpdated;
use App\Models\MatchInnings;
use App\Models\InningsState;
class MatchBallController extends Controller
{
      protected $ballService;

    public function __construct(BallProcessingService $ballService)
    {
        $this->ballService = $ballService;
    }

    public function addBall(Request $request, $matchId)
    {
        $request->validate([
            'innings_id' => 'required',
            'striker_id' => 'required',
            'non_striker_id' => 'required',
            'bowler_id' => 'required',
            'runs' => 'required|integer',
            'is_wicket' => 'boolean'
        ]);

        $result = $this->ballService->process(
            $matchId,
            $request->innings_id,
            $request->striker_id,
            $request->non_striker_id,
            $request->bowler_id,
            $request->runs,
            $request->is_wicket ?? false
        );

        // 🔥 Get fresh match state for frontend
        $innings = MatchInnings::find($request->innings_id);
        $state = InningsState::where('innings_id', $request->innings_id)->first();

        $payload = [
            'match_id' => $matchId,
            'innings_id' => $request->innings_id,
            'score' => [
                'runs' => $innings->runs,
                'wickets' => $innings->wickets,
                'overs' => $innings->overs,
            ],
            'striker_id' => $state->striker_id,
            'non_striker_id' => $state->non_striker_id,
        ];

        // ⚡ BROADCAST REAL-TIME EVENT
        event(new BallUpdated($payload));

        return response()->json([
            'success' => true,
            'data' => $payload
        ]);
    }
}
