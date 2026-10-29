<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::where('role', 'user')->orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user details.
     */
    public function show($id)
    {
        $user = User::with(['teams', 'contestEntries'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Toggle user status (activate/deactivate).
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->save();

        $status = $user->status ? 'activated' : 'deactivated';
        return redirect()->route('users')->with('success', "User {$status} successfully");
    }

    /**
     * Add wallet balance to user.
     */
    public function addBalance(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        $user = User::findOrFail($id);
        $user->wallet += $request->amount;
        $user->save();

        return redirect()->route('users')->with('success', "Balance added successfully. New balance: ₹{$user->wallet}");
    }

    /**
     * Deduct wallet balance from user.
     */
    public function deductBalance(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        $user = User::findOrFail($id);
        
        if ($user->wallet < $request->amount) {
            return redirect()->route('users')->with('error', 'Insufficient balance');
        }

        $user->wallet -= $request->amount;
        $user->save();

        return redirect()->route('users')->with('success', "Balance deducted successfully. New balance: ₹{$user->wallet}");
    }

    /**
     * View user's teams.
     */
    public function viewTeams($id)
    {
        $user = User::with(['teams.match', 'teams.players.matchPlayer'])->findOrFail($id);
        return view('admin.users.teams', compact('user'));
    }

    /**
     * View user's contest entries.
     */
    public function viewContests($id)
    {
        $user = User::with(['contestEntries.contest.match', 'contestEntries.team'])->findOrFail($id);
        return view('admin.users.contests', compact('user'));
    }
}
