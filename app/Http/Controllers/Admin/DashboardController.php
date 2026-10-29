<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Matches;
use App\Models\Contest;
use App\Models\Post;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'active_users' => User::where('role', 'user')->where('status', true)->count(),
            'total_matches' => Matches::count(),
            'upcoming_matches' => Matches::where('status', 'UPCOMING')->count(),
            'live_matches' => Matches::where('status', 'LIVE')->count(),
            'completed_matches' => Matches::where('status', 'DONE')->count(),
            'total_contests' => Contest::count(),
            'open_contests' => Contest::where('status', 'open')->count(),
            'total_posts' => Post::count(),
            'total_revenue' => Contest::sum('entry_fee'),
            'total_prize_pool' => Contest::sum('prize_pool'),
        ];

        $recentMatches = Matches::orderBy('created_at', 'desc')->take(5)->get();
        $recentUsers = User::where('role', 'user')->orderBy('created_at', 'desc')->take(5)->get();
        $recentContests = Contest::with('match')->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentMatches', 'recentUsers', 'recentContests'));
    }
}
