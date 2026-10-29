<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contest;
use App\Models\Matches;
use App\Models\ContestEntry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContestController extends Controller
{
    /**
     * Display contests for a match.
     */
    public function index(Request $request)
    {
        $id=$request->id;
        $contests = Contest::where('match_id', $id)->withCount('entries')->get();
        $match = Matches::findOrFail($id);
        return view('admin.contests.index', compact('contests', 'match', 'id'));
    }

    /**
     * Show the form for creating a contest.
     */
    public function create(Request $request)
    {
        $id=$request->id;
        $match = Matches::findOrFail($id);
        return view('admin.contests.create', compact('match', 'id'));
    }

    /**
     * Store a newly created contest.
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'entry_fee' => 'required|numeric|min:0',
            'prize_pool' => 'required|numeric|min:0',
            'max_spots' => 'required|integer|min:2',
            'first_prize' => 'nullable|numeric|min:0',
            'winners_count' => 'nullable|integer|min:1',
        ]);

        Contest::create([
            'name' => $request->name,
            'match_id' => $id,
            'entry_fee' => $request->entry_fee,
            'prize_pool' => $request->prize_pool,
            'max_spots' => $request->max_spots,
            'joined_spots' => 0,
            'status' => 'open',
            'first_prize' => $request->first_prize,
            'winners_count' => $request->winners_count,
        ]);

        return redirect()->route('managecontests', $id)
            ->with('success', 'Contest created successfully');
    }

    /**
     * Show contest details.
     */
    public function show($id)
    {
        $contest = Contest::with(['match', 'entries.user', 'entries.team'])->findOrFail($id);
        return view('admin.contests.show', compact('contest'));
    }

    /**
     * Show the form for editing a contest.
     */
    public function edit($id)
    {
        $contest = Contest::findOrFail($id);
        return view('admin.contests.edit', compact('contest'));
    }

    /**
     * Update the specified contest.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'entry_fee' => 'required|numeric|min:0',
            'prize_pool' => 'required|numeric|min:0',
            'max_spots' => 'required|integer|min:2',
            'status' => 'required|in:open,live,closed',
            'first_prize' => 'nullable|numeric|min:0',
            'winners_count' => 'nullable|integer|min:1',
        ]);

        $contest = Contest::findOrFail($id);
        $contest->update($request->all());

        return redirect()->route('managecontests', $contest->match_id)
            ->with('success', 'Contest updated successfully');
    }

    /**
     * Update contest status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:open,live,closed',
        ]);

        $contest = Contest::findOrFail($id);
        $contest->status = $request->status;
        $contest->save();

        return redirect()->route('managecontests', $contest->match_id)
            ->with('success', 'Contest status updated successfully');
    }

    /**
     * Delete a contest.
     */
    public function destroy($id)
    {
        $contest = Contest::findOrFail($id);
        $matchId = $contest->match_id;
        $contest->delete();

        return redirect()->route('managecontests', $matchId)
            ->with('success', 'Contest deleted successfully');
    }

    /**
     * View contest leaderboard.
     */
    public function leaderboard($id)
    {
        $contest = Contest::with(['entries.user', 'entries.team'])->findOrFail($id);
        $entries = $contest->entries()->orderBy('points', 'desc')->get();
        
        return view('admin.contests.leaderboard', compact('contest', 'entries'));
    }

    /**
     * Calculate and update rankings for a contest.
     */
    public function calculateRankings($id)
    {
        $contest = Contest::findOrFail($id);
        $entries = $contest->entries()->orderBy('points', 'desc')->get();

        $rank = 1;
        foreach ($entries as $entry) {
            $entry->rank = $rank;
            $entry->save();
            $rank++;
        }

        return redirect()->route('admin.contests.leaderboard', $id)
            ->with('success', 'Rankings calculated successfully');
    }

    /**
     * Distribute prizes for a contest.
     */
    public function distributePrizes($id)
    {
        $contest = Contest::with('entries')->findOrFail($id);
        
        if ($contest->status !== 'closed') {
            return redirect()->route('admin.contests.leaderboard', $id)
                ->with('error', 'Contest must be closed to distribute prizes');
        }

        $entries = $contest->entries()->orderBy('rank')->get();
        $totalPrize = $contest->prize_pool;
        $winnersCount = $contest->winners_count ?? 1;

        // Simple prize distribution logic
        $prizePerWinner = $totalPrize / $winnersCount;

        foreach ($entries as $entry) {
            if ($entry->rank <= $winnersCount) {
                $entry->winnings = $prizePerWinner;
                $entry->save();

                // Add winnings to user wallet
                $entry->user->wallet += $prizePerWinner;
                $entry->user->save();
            }
        }

        return redirect()->route('admin.contests.leaderboard', $id)
            ->with('success', 'Prizes distributed successfully');
    }
}
