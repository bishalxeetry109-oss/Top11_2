<?php

namespace App\Http\Controllers\Admin;

use App\Models\Player;
use App\Models\MatchPlayer;
use App\Models\Matches;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlayerController extends Controller
{
    /**
     * Display a listing of players.
     */
    public function index()
    {
        $players = Player::all();
        return view('admin.players.index', compact('players'));
    }

    /**
     * Show the form for creating a player.
     */
    public function create()
    {
        return view('admin.players.create');
    }

    /**
     * Store a newly created player.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'team' => 'required|string|max:255',
            'role' => 'required|in:batsman,bowler,allrounder,wicketkeeper',
            'credits' => 'required|numeric|min:8|max:15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('players', 'public');
        }

        Player::create([
            'name' => $request->name,
            'team' => $request->team,
            'role' => $request->role,
            'credits' => $request->credits,
        ]);

        return redirect()->route('players.index')
            ->with('success', 'Player created successfully');
    }

    /**
     * Show the form for editing a player.
     */
    public function edit($id)
    {
        $player = Player::findOrFail($id);
        return view('admin.players.edit', compact('player'));
    }

    /**
     * Update the specified player.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'team' => 'required|string|max:255',
            'role' => 'required|in:batsman,bowler,allrounder,wicketkeeper',
            'credits' => 'required|numeric|min:8|max:15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $player = Player::findOrFail($id);

        $imagePath = $player->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('players', 'public');
        }

        $player->update([
            'name' => $request->name,
            'team' => $request->team,
            'role' => $request->role,
            'credits' => $request->credits,
        ]);

        return redirect()->route('players')
            ->with('success', 'Player updated successfully');
    }

    /**
     * Delete a player.
     */
    public function destroy($id)
    {
        $player = Player::findOrFail($id);
        $player->delete();

        return redirect()->route('players.index')
            ->with('success', 'Player deleted successfully');
    }

    /**
     * Add players to a match.
     */
    public function addToMatch(Request $request, $matchId)
    {
        $request->validate([
            'player_ids' => 'required|array|min:1',
            'player_ids.*' => 'exists:players,id',
        ]);

        $match = Matches::findOrFail($matchId);

        foreach ($request->player_ids as $playerId) {
            $player = Player::findOrFail($playerId);
            
            MatchPlayer::create([
                'match_id' => $match->id,
                'name' => $player->name,
                'team' => $player->team,
                'role' => $this->convertRole($player->role),
                'credit' => $player->credits,
            ]);
        }

        return redirect()->route('matches.showNext', $matchId)
            ->with('success', 'Players added to match successfully');
    }

    /**
     * Convert player role to match player role format.
     */
    private function convertRole($role)
    {
        $roleMap = [
            'batsman' => 'BAT',
            'bowler' => 'BOWL',
            'allrounder' => 'AR',
            'wicketkeeper' => 'WK',
        ];

        return $roleMap[$role] ?? $role;
    }

    /**
     * Search players.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $players = Player::where('name', 'like', "%{$query}%")
            ->orWhere('team', 'like', "%{$query}%")
            ->get();

        return response()->json($players);
    }
}
