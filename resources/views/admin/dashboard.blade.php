@extends('admin.layout.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<!-- Heading -->
<div class="mb-6">
    <h2 class="text-3xl font-bold">System Overview</h2>
    <p class="text-gray-400">Platform health and metrics at a glance.</p>
</div>

<!-- ================= STATS ================= -->
<div class="grid grid-cols-4 gap-6 mb-8">

    <!-- Users -->
    <div class="stat-card bg-gradient-to-r from-gray-900 to-gray-800 p-6 rounded-2xl transition-all duration-200">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-400 text-sm">TOTAL USERS</p>
            <div class="w-10 h-10 rounded-lg bg-cyan-500/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-cyan-400">{{ $stats['total_users'] }}</h3>
        <p class="text-gray-500 text-sm mt-1">{{ $stats['active_users'] }} active</p>
    </div>

    <!-- Matches -->
    <div class="stat-card bg-gradient-to-r from-gray-900 to-gray-800 p-6 rounded-2xl transition-all duration-200">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-400 text-sm">ACTIVE MATCHES</p>
            <div class="w-10 h-10 rounded-lg bg-green-500/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-green-400">{{ $stats['live_matches'] }}</h3>
        <p class="text-gray-500 text-sm mt-1">of {{ $stats['total_matches'] }} total</p>
    </div>

    <!-- Contests -->
    <div class="stat-card bg-gradient-to-r from-gray-900 to-gray-800 p-6 rounded-2xl transition-all duration-200">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-400 text-sm">TOTAL CONTESTS</p>
            <div class="w-10 h-10 rounded-lg bg-yellow-500/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-yellow-400">{{ $stats['total_contests'] }}</h3>
        <p class="text-gray-500 text-sm mt-1">{{ $stats['open_contests'] }} open</p>
    </div>

    <!-- Revenue -->
    <div class="stat-card bg-gradient-to-r from-purple-900/40 to-gray-900 p-6 rounded-2xl transition-all duration-200">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-400 text-sm">TOTAL REVENUE</p>
            <div class="w-10 h-10 rounded-lg bg-purple-500/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-purple-400">₹{{ number_format($stats['total_revenue'], 2) }}</h3>
        <p class="text-gray-500 text-sm mt-1">Prize pool: ₹{{ number_format($stats['total_prize_pool'], 2) }}</p>
    </div>

</div>

<!-- ================= MAIN GRID ================= -->
<div class="grid grid-cols-3 gap-6">

    <!-- ================= CHART ================= -->
    <div class="col-span-2 bg-gradient-to-r from-gray-900 to-gray-800 p-6 rounded-2xl">

        <div class="flex justify-between mb-4">
            <h3 class="text-lg font-semibold">User & Revenue Trends</h3>

            <div class="flex gap-4 text-sm">
                <span class="text-cyan-400">— Revenue</span>
                <span class="text-purple-400">— Users</span>
            </div>
        </div>

        <!-- Chart -->
        <div class="h-64 flex items-center justify-center text-gray-500 border border-gray-700 rounded-xl">
            <canvas id="trendsChart"></canvas>
        </div>

    </div>

    <!-- ================= LOGS ================= -->
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-6 rounded-2xl">

        <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>

        <div class="space-y-4 text-sm">
            @forelse($recentMatches->take(4) as $match)
            <div class="flex gap-3">
                <span class="text-gray-500 w-10">{{ $match->created_at->diffForHumans() }}</span>
                <p>Match created: <span class="text-blue-400">{{ $match->team_a }} vs {{ $match->team_b }}</span></p>
            </div>
            @empty
            <div class="flex gap-3">
                <span class="text-gray-500 w-10">5m</span>
                <p>New user registered: <span class="text-blue-400">arjun_kumar</span></p>
            </div>

            <div class="flex gap-3">
                <span class="text-gray-500 w-10">15m</span>
                <p>Match IND vs AUS went live</p>
            </div>

            <div class="flex gap-3">
                <span class="text-gray-500 w-10">1h</span>
                <p>Mega Contest reached 1000 teams</p>
            </div>

            <div class="flex gap-3">
                <span class="text-gray-500 w-10">2h</span>
                <p>Scores updated for T20 World Cup</p>
            </div>
            @endforelse
        </div>

    </div>

</div>

<!-- ================= RECENT TABLES ================= -->
<div class="grid grid-cols-2 gap-6 mt-6">

    <!-- Recent Matches -->
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-700">
            <h3 class="text-lg font-semibold">Recent Matches</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Match</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($recentMatches as $match)
                    <tr class="hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-3">
                            <p class="font-medium">{{ $match->team_a }} vs {{ $match->team_b }}</p>
                        </td>
                        <td class="px-6 py-3 text-gray-400 text-sm">
                            {{ \Carbon\Carbon::parse($match->date)->format('M d') }}
                        </td>
                        <td class="px-6 py-3">
                            @if($match->status === 'UPCOMING')
                                <span class="px-2 py-1 rounded-full text-xs bg-yellow-500/20 text-yellow-400">Upcoming</span>
                            @elseif($match->status === 'LIVE')
                                <span class="px-2 py-1 rounded-full text-xs bg-green-500/20 text-green-400">Live</span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs bg-gray-500/20 text-gray-400">Done</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-400">No matches yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-700">
            <h3 class="text-lg font-semibold">Recent Users</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($recentUsers as $user)
                    <tr class="hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-xs font-bold">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                                <p class="font-medium">{{ $user->name }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-3 text-gray-400 text-sm">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-3 text-gray-400 text-sm">
                            {{ $user->created_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-400">No users yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
// Chart.js
const ctx = document.getElementById('trendsChart').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
        datasets: [
            {
                label: 'Revenue',
                data: [2500,1500,10000,4000,5000,3800,4500],
                borderColor: '#22d3ee',
                backgroundColor: 'rgba(34, 211, 238, 0.1)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Users',
                data: [4000,3000,2000,2800,1800,2400,3500],
                borderColor: '#a855f7',
                backgroundColor: 'rgba(168, 85, 247, 0.1)',
                tension: 0.4,
                fill: true
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            x: {
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)'
                },
                ticks: {
                    color: '#9ca3af'
                }
            },
            y: {
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)'
                },
                ticks: {
                    color: '#9ca3af'
                }
            }
        }
    }
});
</script>
@endsection
