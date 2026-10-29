@extends('admin.layout.app')

@section('title', 'Score Management - ' . $match->team_a . ' vs ' . $match->team_b)

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-950 p-4 lg:p-8">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- ============ HERO SCOREBOARD ============ --}}
            <div
                class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-800 shadow-2xl">
                <div class="absolute inset-0 opacity-10"
                    style="background-image:radial-gradient(circle at 20% 50%, white 1px, transparent 1px), radial-gradient(circle at 80% 80%, white 1px, transparent 1px); background-size: 40px 40px;">
                </div>
                <div class="relative p-6 lg:p-10">
                    <div class="flex items-center justify-between mb-6">
                        <span
                            class="px-3 py-1 text-xs font-bold uppercase tracking-widest bg-white/20 backdrop-blur text-white rounded-full">
                            <i class="fas fa-circle text-red-400 animate-pulse mr-1"></i> {{ $match->status }}
                        </span>
                        @if($match->batting_first)
                            <span class="text-white/80 text-sm font-medium">
                                <i class="fas fa-baseball-ball mr-1"></i> Team {{ $match->batting_first }} batting first
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                        <div class="text-center md:text-right">
                            <p class="text-white/60 text-xs uppercase tracking-widest mb-2">Team A</p>
                            <h2 class="text-3xl lg:text-4xl font-black text-white">{{ $match->team_a }}</h2>
                        </div>

                        <div class="text-center">
                            <div
                                class="inline-block px-8 py-4 bg-black/30 backdrop-blur-xl rounded-2xl border border-white/10">
                                <p class="text-5xl lg:text-7xl font-black text-white tracking-tight">
                                    <span id="match-score">{{ $match->score ?? 0 }}</span><span
                                        class="text-white/40">/</span><span
                                        id="match-wickets">{{ $match->wickets ?? 0 }}</span>
                                </p>
                                <p class="text-emerald-200 text-sm font-semibold mt-2">{{ $match->overs ?? 0 }} OVERS</p>
                            </div>
                        </div>

                        <div class="text-center md:text-left">
                            <p class="text-white/60 text-xs uppercase tracking-widest mb-2">Team B</p>
                            <h2 class="text-3xl lg:text-4xl font-black text-white">{{ $match->team_b }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ============ TOSS SETTINGS ============ --}}
            <div class="bg-slate-800/60 backdrop-blur-xl rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-700/50 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-yellow-500/20 flex items-center justify-center">
                        <i class="fas fa-coins text-yellow-400"></i>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-lg">Toss Settings</h3>
                        <p class="text-slate-400 text-xs">Select toss winner and decision</p>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        {{-- Toss Winner --}}
                        <div>
                            <label class="block text-slate-300 text-sm font-medium mb-2">
                                Toss Winner
                            </label>

                            <select id="toss-winner"
                                class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white">

                                <option value="">Select Team</option>

                                <option value="{{ $match->team_a }}" {{ $match->toss_winner == $match->team_a ? 'selected' : '' }}>
                                    {{ $match->team_a }}
                                </option>

                                <option value="{{ $match->team_b }}" {{ $match->toss_winner == $match->team_b ? 'selected' : '' }}>
                                    {{ $match->team_b }}
                                </option>
                            </select>
                        </div>

                        {{-- Toss Decision --}}
                        <div>
                            <label class="block text-slate-300 text-sm font-medium mb-2">
                                Toss Decision
                            </label>

                            <select id="toss-decision"
                                class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-yellow-500 focus:ring-0">
                                <option value="">Choose Decision</option>

                                <option value="bat" {{ $match->toss_decision == 'bat' ? 'selected' : '' }}>
                                    Bat First
                                </option>

                                <option value="bowl" {{ $match->toss_decision == 'bowl' ? 'selected' : '' }}>
                                    Bowl First
                                </option>
                            </select>
                        </div>

                        {{-- Save --}}
                        <div class="flex items-end">
                            <button id="save-toss-btn" type="submit"
                                class="w-full py-3 rounded-xl bg-gradient-to-r from-yellow-500 to-amber-600 hover:from-yellow-400 hover:to-amber-500 text-white font-bold transition">
                                <i class="fas fa-save mr-2"></i>
                                Save Toss
                            </button>
                        </div>

                    </div>

                    {{-- Preview --}}
                    <div id="toss-preview" class="mt-5 rounded-xl border border-yellow-500/20 bg-yellow-500/10 p-4">

                        <p class="text-yellow-300 text-sm">
                            Toss information will automatically determine:
                        </p>

                        <ul class="mt-2 text-sm text-slate-300 space-y-1">
                            <li>• 1st Innings Batting Team</li>
                            <li>• 1st Innings Bowling Team</li>
                            <li>• 2nd Innings Batting Team</li>
                            <li>• 2nd Innings Bowling Team</li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- ============ INNINGS TABS ============ --}}
            <div class="bg-slate-800/60 backdrop-blur-xl rounded-2xl border border-slate-700/50 shadow-xl p-2">
                <div class="grid grid-cols-2 gap-2" id="innings-tabs">
                    <button data-innings="1"
                        class="innings-tab py-3 rounded-xl font-bold text-sm uppercase tracking-widest transition bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-lg">
                        <i class="fas fa-flag mr-2"></i> 1st Innings
                    </button>
                    <button data-innings="2"
                        class="innings-tab py-3 rounded-xl font-bold text-sm uppercase tracking-widest transition bg-slate-900/60 text-slate-400 hover:text-white">
                        <i class="fas fa-flag-checkered mr-2"></i> 2nd Innings
                    </button>
                </div>
            </div>

            {{-- ============ INNINGS PANELS ============ --}}
            @foreach([1, 2] as $inningsNum)

                @php

                    $data = $inningsData[$inningsNum];

                    $battingTeam = $data['battingTeam'];
                    $bowlingTeam = $data['bowlingTeam'];
                    $batsmens = $data['batsmens'];
                    $bowlers = $data['bowlers'];
                    $currentBatsmen = $data['currentBatsmen'];

                    $availableBatsmen = $data['availableBatsmen'];
                    $availableBowlers = $data['availableBowlers'];
                @endphp

                <div class="innings-panel space-y-6 {{ $inningsNum === 2 ? 'hidden' : '' }}"
                    data-innings-panel="{{ $inningsNum }}">
                    <div class="bg-slate-800/40 border border-slate-700/50 rounded-xl px-4 py-2 text-slate-300 text-sm">
                        <i class="fas fa-info-circle text-emerald-400 mr-2"></i>
                        Showing controls for <strong
                            class="text-white">{{ $inningsNum === 1 ? '1st' : '2nd' }}Innings({{ $battingTeam }}
                            batting)</strong>
                    </div>

                    {{-- ============ MAIN GRID: BATTING + BOWLING ============ --}}
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

                        {{-- ============ BATTING CARD ============ --}}
                        <div
                            class="bg-slate-800/60 backdrop-blur-xl rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden">
                            <div
                                class="px-6 py-4 bg-gradient-to-r from-blue-600/20 to-transparent border-b border-slate-700/50 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center">
                                    <i class="fas fa-baseball-bat-ball text-blue-400"></i>
                                </div>
                                <div>
                                    <h3 class="text-white font-bold text-lg">Batting</h3>
                                    <p class="text-slate-400 text-xs">{{ $battingTeam }}</p>
                                </div>
                            </div>

                            <div class="p-6 space-y-6">

                                {{-- ===== SET STRIKER / NON-STRIKER ===== --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    {{-- Striker --}}
                                    <div class="bg-emerald-900/20 rounded-xl p-4 border border-emerald-500/30">
                                        <h4
                                            class="text-emerald-300 text-xs uppercase tracking-widest font-semibold mb-3 flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Set Striker
                                            *
                                        </h4>
                                        <div class="flex gap-2">
                                            <select id="striker-select-{{ $inningsNum }}"
                                                class="flex-1 bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:border-emerald-500 focus:outline-none">
                                                <option value="">Choose striker...</option>
                                                @foreach($availableBatsmen as $player)
                                                    <option value="{{ $player->id }}">{{ $player->name ?? 'N/A' }}</option>
                                                @endforeach
                                            </select>
                                            <button
                                                class="set-striker-btn px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg font-semibold text-sm transition"
                                                data-role="striker" data-innings="{{ $inningsNum }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Non-Striker --}}
                                    <div class="bg-blue-900/20 rounded-xl p-4 border border-blue-500/30">
                                        <h4
                                            class="text-blue-300 text-xs uppercase tracking-widest font-semibold mb-3 flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-blue-400"></span> Set Non-Striker
                                        </h4>
                                        <div class="flex gap-2">
                                            <select id="nonstriker-select-{{ $inningsNum }}"
                                                class="flex-1 bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:border-blue-500 focus:outline-none">
                                                <option value="">Choose non-striker...</option>
                                                @foreach($availableBatsmen as $player)
                                                    <option value="{{ $player->id }}">{{ $player->name ?? 'N/A' }}</option>
                                                @endforeach

                                            </select>
                                            <button
                                                class="set-striker-btn px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg font-semibold text-sm transition"
                                                data-role="non-striker" data-innings="{{ $inningsNum }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Swap Strike --}}
                                <button
                                    class="swap-strike-btn w-full py-2 bg-slate-900/60 border border-slate-700 hover:border-amber-500 hover:bg-amber-500/10 text-amber-300 rounded-lg text-sm font-semibold transition">
                                    <i class="fas fa-exchange-alt mr-2"></i> Swap Strike
                                </button>

                                {{-- Current Batsmen --}}
                                <div>
                                    <h4 class="text-slate-300 text-xs uppercase tracking-widest font-semibold mb-3">Current
                                        Batsmen</h4>
                                    <div class="space-y-3">
                                        @forelse($currentBatsmen as $index => $batsman)
                                            <div id="batsman-card-{{ $batsman->id }}"
                                                class="bg-slate-900/60 rounded-xl p-4 border {{ $index === 0 ? 'border-emerald-500/40' : 'border-slate-700/50' }} hover:border-slate-600 transition">
                                                <div class="flex items-center justify-between mb-3">
                                                    <div class="flex items-center gap-2">
                                                        <h5 class="font-bold text-white">{{ $batsman->name ?? 'N/A' }}</h5>
                                                        @if($batsman->batting_status === 'in_strike')
                                                            <span
                                                                class="px-2 py-0.5 text-[10px] font-bold uppercase bg-emerald-500/20 text-emerald-400 rounded-full border border-emerald-500/30">Striker
                                                                *</span>
                                                        @else
                                                            <span
                                                                class="px-2 py-0.5 text-[10px] font-bold uppercase bg-blue-500/20 text-blue-400 rounded-full border border-blue-500/30">Non-Striker</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-3 gap-2 mb-3">
                                                    <div class="bg-slate-800/60 rounded-lg p-2 text-center">
                                                        <p class="text-2xl font-black text-white"
                                                            id="batsman-runs-{{ $batsman->id }}">{{ $batsman->runs ?? 0 }}</p>
                                                        <p class="text-[10px] text-slate-400 uppercase">Runs</p>
                                                    </div>
                                                    <div class="bg-slate-800/60 rounded-lg p-2 text-center">
                                                        <p class="text-2xl font-black text-white">{{ $batsman->balls_faced ?? 0 }}
                                                        </p>
                                                        <p class="text-[10px] text-slate-400 uppercase">Balls</p>
                                                    </div>
                                                    <div class="bg-slate-800/60 rounded-lg p-2 text-center">
                                                        <p class="text-2xl font-black text-white">{{ $batsman->strike_rate ?? 0 }}
                                                        </p>
                                                        <p class="text-[10px] text-slate-400 uppercase">SR</p>
                                                    </div>
                                                </div>

                                                <div class="flex gap-4 text-xs text-slate-400 mb-3">
                                                    <span><span class="text-amber-400 font-bold">4s:</span>
                                                        {{ $batsman->fours ?? 0 }}</span>
                                                    <span><span class="text-purple-400 font-bold">6s:</span>
                                                        {{ $batsman->sixes ?? 0 }}</span>
                                                </div>
                                            </div>
                                        @empty
                                            <div
                                                class="text-center py-8 bg-slate-900/40 rounded-xl border border-dashed border-slate-700">
                                                <i class="fas fa-info-circle text-3xl text-slate-500 mb-2"></i>
                                                <p class="text-slate-400 text-sm">No batsmen currently batting.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                {{-- Next Batsman --}}
                                @if($availableBatsmen->count() > 0)
                                    <div class="bg-slate-900/40 rounded-xl p-4 border border-slate-700/50">
                                        <h4 class="text-slate-300 text-xs uppercase tracking-widest font-semibold mb-3">Select Next
                                            Batsman</h4>
                                        <div class="flex gap-2">
                                            <select id="next-batsman-select"
                                                class="flex-1 bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:border-emerald-500 focus:outline-none">
                                                <option value="">Choose next batsman...</option>
                                                @foreach($availableBatsmen as $player)
                                                    <option value="{{ $player->id }}">{{ $player->player->name ?? 'N/A' }}
                                                        ({{ $player->player->role ?? 'N/A' }})</option>
                                                @endforeach
                                            </select>
                                            <button id="set-next-batsman-btn"
                                                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg font-semibold text-sm transition">
                                                <i class="fas fa-user-plus mr-1"></i> Set
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                @if(
                                        $batsmens->count() < 2
                                        &&
                                        $availableBatsmen->count() >= 2
                                        &&
                                        $battingTeam
                                    ) <button id="initialize-batting-btn"
                                        class="w-full py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold rounded-xl transition shadow-lg shadow-emerald-900/50">
                                        <i class="fas fa-play-circle mr-2"></i> Initialize Batting
                                    </button>
                                @endif

                                {{-- All Batsmen Table --}}
                                <div>
                                    <h4 class="text-slate-300 text-xs uppercase tracking-widest font-semibold mb-3">All Batsmen
                                    </h4>
                                    <div class="overflow-x-auto rounded-xl border border-slate-700/50">
                                        <table class="w-full text-sm">
                                            <thead class="bg-slate-900/80 text-slate-400 text-xs uppercase">
                                                <tr>
                                                    <th class="px-3 py-2 text-left">Batsman</th>
                                                    <th class="px-2 py-2">R</th>
                                                    <th class="px-2 py-2">B</th>
                                                    <th class="px-2 py-2">4s</th>
                                                    <th class="px-2 py-2">6s</th>
                                                    <th class="px-2 py-2">SR</th>
                                                    <th class="px-2 py-2">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-800">
                                                @foreach($batsmens as $batsmen)
                                                    <tr class="text-slate-300 hover:bg-slate-900/40">
                                                        <td class="px-3 py-2 font-medium text-white">{{ $batsmen->name ?? 'N/A' }}
                                                        </td>
                                                        <td class="px-2 py-2 text-center">{{ $batsmen->runs ?? 0 }}</td>
                                                        <td class="px-2 py-2 text-center">{{ $batsmen->balls_faced ?? 0 }}</td>
                                                        <td class="px-2 py-2 text-center">{{ $batsmen->fours ?? 0 }}</td>
                                                        <td class="px-2 py-2 text-center">{{ $batsmen->sixes ?? 0 }}</td>
                                                        <td class="px-2 py-2 text-center">{{ $batsmen->strike_rate ?? 0 }}</td>
                                                        <td class="px-2 py-2 text-center">
                                                            @if($batsmen->is_out)
                                                                <span
                                                                    class="px-2 py-0.5 text-[10px] rounded-full bg-red-500/20 text-red-400 border border-red-500/30">Out</span>
                                                            @elseif($batsmen->is_batting)
                                                                <span
                                                                    class="px-2 py-0.5 text-[10px] rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">Batting</span>
                                                            @else
                                                                <span
                                                                    class="px-2 py-0.5 text-[10px] rounded-full bg-slate-600/30 text-slate-400 border border-slate-600/40">Yet
                                                                    to bat</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ============ BOWLING CARD ============ --}}
                        <div
                            class="bg-slate-800/60 backdrop-blur-xl rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden">
                            <div
                                class="px-6 py-4 bg-gradient-to-r from-rose-600/20 to-transparent border-b border-slate-700/50 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-rose-500/20 flex items-center justify-center">
                                    <i class="fas fa-baseball-ball text-rose-400"></i>
                                </div>
                                <div>
                                    <h3 class="text-white font-bold text-lg">Bowling</h3>
                                    <p class="text-slate-400 text-xs"> {{ $bowlingTeam }}</p>
                                </div>
                            </div>

                            <div class="p-6 space-y-6">
                                {{-- Current Bowler --}}
                                <div>
                                    <h4 class="text-slate-300 text-xs uppercase tracking-widest font-semibold mb-3">Current
                                        Bowler</h4>
                                    @if($bowlers)
                                        @foreach ($bowlers as $bowler)

                                        @endforeach
                                        <div
                                            class="bg-gradient-to-br from-rose-900/40 to-slate-900/60 rounded-xl p-4 border border-rose-500/20">
                                            <h5 class="font-bold text-white mb-3 flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full bg-rose-400 animate-pulse"></span>
                                                {{ $bowler->name ?? 'N/A' }}
                                            </h5>
                                            <div class="grid grid-cols-4 gap-2 mb-4">
                                                <div class="bg-slate-800/60 rounded-lg p-2 text-center">
                                                    <p class="text-xl font-black text-white">{{ $bowler->overs_bowled ?? 0 }}</p>
                                                    <p class="text-[10px] text-slate-400 uppercase">Overs</p>
                                                </div>
                                                <div class="bg-slate-800/60 rounded-lg p-2 text-center">
                                                    <p class="text-xl font-black text-white">{{ $bowler->runs_conceded ?? 0 }}</p>
                                                    <p class="text-[10px] text-slate-400 uppercase">Runs</p>
                                                </div>
                                                <div class="bg-slate-800/60 rounded-lg p-2 text-center">
                                                    <p class="text-xl font-black text-white" id="bowler-wkts-{{ $bowler->id }}">
                                                        {{ $bowler->wickets ?? 0 }}
                                                    </p>
                                                    <p class="text-[10px] text-slate-400 uppercase">Wkts</p>
                                                </div>
                                                <div class="bg-slate-800/60 rounded-lg p-2 text-center">
                                                    <p class="text-xl font-black text-white">{{ $bowler->economy ?? 0 }}</p>
                                                    <p class="text-[10px] text-slate-400 uppercase">Econ</p>
                                                </div>
                                            </div>

                                            {{-- BOWLER BALL PAD --}}
                                            <div class="pt-3 border-t border-rose-500/20">
                                                <p class="text-[10px] uppercase tracking-widest text-slate-400 mb-2">Bowl Delivery
                                                </p>
                                                <div class="grid grid-cols-5 gap-2 mb-2">
                                                    @foreach([1, 2, 3, 4, 6] as $r)
                                                        <button data-runs="{{ $r }}" data-bowler-id="{{ $bowler->id }}"
                                                            data-innings="{{ $inningsNum }}" class="bowler-run-btn h-12 rounded-lg font-bold text-white text-lg transition transform hover:scale-105 active:scale-95
                                                                                    @if($r === 4) bg-gradient-to-br from-amber-500 to-orange-600 hover:from-amber-400
                                                                                    @elseif($r === 6) bg-gradient-to-br from-purple-500 to-pink-600 hover:from-purple-400
                                                                                    @else bg-rose-600 hover:bg-rose-500 @endif">
                                                            {{ $r }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                                <div class="grid grid-cols-2 gap-2">
                                                    {{-- Dot Ball --}}
                                                    <button
                                                        class="ball-btn h-10 rounded-lg bg-slate-700 text-white font-bold text-sm"
                                                        data-type="dot" data-runs="0" data-innings="{{ $inningsNum }}"
                                                        data-bowler-id="{{ $bowler->id }}">
                                                        Dot (0)
                                                    </button>

                                                    {{-- 1 Run --}}
                                                    <button
                                                        class="ball-btn h-10 rounded-lg bg-slate-600 text-white font-bold text-sm"
                                                        data-type="run" data-runs="1" data-innings="{{ $inningsNum }}"
                                                        data-bowler-id="{{ $bowler->id }}">

                                                        1 Run
                                                    </button>

                                                    {{-- Wide --}}
                                                    <button
                                                        class="ball-btn h-10 rounded-lg bg-yellow-600/20 text-yellow-400 font-bold text-sm"
                                                        data-type="wide" data-runs="1" data-innings="{{ $inningsNum }}"
                                                        data-bowler-id="{{ $bowler->id }}">

                                                        Wide (+1)
                                                    </button>

                                                    {{-- No Ball --}}
                                                    <button
                                                        class="ball-btn h-10 rounded-lg bg-purple-600/20 text-purple-400 font-bold text-sm"
                                                        data-type="noball" data-runs="1" data-innings="{{ $inningsNum }}"
                                                        data-bowler-id="{{ $bowler->id }}">

                                                        No Ball (+1)
                                                    </button>

                                                    {{-- Wicket (basic) --}}
                                                    <button
                                                        class="ball-btn h-10 rounded-lg bg-red-600/20 text-red-400 font-bold text-sm"
                                                        data-type="wicket" data-innings="{{ $inningsNum }}"
                                                        data-bowler-id="{{ $bowler->id }}">

                                                        Wicket(Bolt)
                                                    </button>

                                                    {{-- Catch Out --}}
                                                    <button
                                                        class="ball-btn h-10 rounded-lg bg-red-700/20 text-red-300 font-bold text-sm"
                                                        data-type="caught" data-innings="{{ $inningsNum }}"
                                                        data-bowler-id="{{ $bowler->id }}">

                                                        Catch Out
                                                    </button>

                                                    {{-- Run Out Striker --}}
                                                    <button
                                                        class="ball-btn h-10 rounded-lg bg-red-800/20 text-red-200 font-bold text-sm"
                                                        data-type="runout_striker" data-innings="{{ $inningsNum }}"
                                                        data-bowler-id="{{ $bowler->id }}">
                                                        Run Out (Striker)
                                                    </button>

                                                    {{-- Run Out Non-Striker --}}
                                                    <button
                                                        class="ball-btn h-10 rounded-lg bg-red-800/30 text-red-200 font-bold text-sm"
                                                        data-type="runout_nonstriker" data-innings="{{ $inningsNum }}"
                                                        data-bowler-id="{{ $bowler->id }}">
                                                        Run Out (Non-Striker)
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            class="text-center py-8 bg-slate-900/40 rounded-xl border border-dashed border-slate-700">
                                            <i class="fas fa-exclamation-triangle text-3xl text-amber-500 mb-2"></i>
                                            <p class="text-slate-400 text-sm">No bowler selected.</p>
                                        </div>
                                    @endif
                                </div>

                                {{-- Select Bowler --}}
                                <div class="bg-slate-900/40 rounded-xl p-4 border border-slate-700/50">
                                    <h4 class="text-slate-300 text-xs uppercase tracking-widest font-semibold mb-3">Select
                                        Bowler</h4>
                                    <div class="flex gap-2">
                                        <select id="bowler-select"
                                            class="flex-1 bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:border-rose-500 focus:outline-none">
                                            <option value="">Choose bowler...</option>
                                            @foreach($availableBowlers as $player)
                                                <option value="{{ $player->id }}" {{ $bowler && $bowler->id === $player->id ? 'selected' : '' }}>
                                                    {{ $player->name ?? 'N/A' }} ({{ $player->wickets ?? 0 }} wkts)
                                                </option>
                                            @endforeach
                                        </select>
                                        <button id="set-bowler-btn"
                                            class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-lg font-semibold text-sm transition">
                                            <i class="fas fa-check mr-1"></i> Set
                                        </button>
                                    </div>
                                </div>

                                {{-- All Bowlers Table --}}
                                <div>
                                    <h4 class="text-slate-300 text-xs uppercase tracking-widest font-semibold mb-3">All Bowlers
                                    </h4>
                                    <div class="overflow-x-auto rounded-xl border border-slate-700/50">
                                        <table class="w-full text-sm">
                                            <thead class="bg-slate-900/80 text-slate-400 text-xs uppercase">
                                                <tr>
                                                    <th class="px-3 py-2 text-left">Bowler</th>
                                                    <th class="px-2 py-2">O</th>
                                                    <th class="px-2 py-2">R</th>
                                                    <th class="px-2 py-2">W</th>
                                                    <th class="px-2 py-2">Econ</th>
                                                    <th class="px-2 py-2">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-800">
                                                @if($bowlers && $bowlers->count())
                                                    @foreach($bowlers as $bowler)
                                                        <tr class="text-slate-300 hover:bg-slate-900/40">

                                                            <td class="px-3 py-2 font-medium text-white">
                                                                {{ $bowler->name ?? 'N/A' }}
                                                            </td>

                                                            <td class="px-2 py-2 text-center">
                                                                {{ $bowler->overs_bowled ?? 0 }}
                                                            </td>

                                                            <td class="px-2 py-2 text-center">
                                                                {{ $bowler->runs_conceded ?? 0 }}
                                                            </td>

                                                            <td class="px-2 py-2 text-center">
                                                                {{ $bowler->wickets ?? 0 }}
                                                            </td>

                                                            <td class="px-2 py-2 text-center">
                                                                {{ $bowler->economy ?? 0 }}
                                                            </td>

                                                            <td class="px-2 py-2 text-center">
                                                                @if($bowler->is_bowling)
                                                                    <span
                                                                        class="px-2 py-0.5 text-[10px] rounded-full bg-rose-500/20 text-rose-400 border border-rose-500/30">
                                                                        Bowling
                                                                    </span>
                                                                @else
                                                                    <span
                                                                        class="px-2 py-0.5 text-[10px] rounded-full bg-slate-600/30 text-slate-400 border border-slate-600/40">
                                                                        Available
                                                                    </span>
                                                                @endif
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="6" class="text-center py-4 text-slate-400">
                                                            No bowlers available
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- TOAST --}}
            <div class="fixed top-6 right-6 z-50">
                <div id="toast-notification"
                    class="toast hide bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden min-w-[300px]"
                    role="alert">
                    <div class="flex items-center justify-between px-4 py-2 bg-slate-900/80 border-b border-slate-700">
                        <strong id="toast-title" class="text-white text-sm font-semibold">Notification</strong>
                        <button type="button" class="text-slate-400 hover:text-white" data-bs-dismiss="toast">×</button>
                    </div>
                    <div id="toast-message" class="px-4 py-3 text-slate-200 text-sm">Message here</div>
                </div>
            </div>
        </div>
@endsection

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const matchId = {{ $match->id }};

                Echo.channel('match.' + matchId)
                    .listen('.ball.updated', (data) => {

                        console.log("LIVE UPDATE:", data);

                        // SCORE UPDATE
                        document.getElementById('match-score').innerText = data.score;
                        document.getElementById('match-wickets').innerText = data.wickets;

                        // STRIKER UPDATE
                        if (data.striker) {
                            document.getElementById(
                                'batsman-runs-' + data.striker.id
                            ).innerText = data.striker.runs;
                        }

                        // BOWLER UPDATE
                        if (data.bowler) {
                            document.getElementById(
                                'bowler-wkts-' + data.bowler.id
                            ).innerText = data.bowler.wickets;
                        }

                        if (data.swap_strike) {
                            console.log("Strike swapped LIVE");
                        }
                    });
                function showToast(title, message, type = 'success') {
                    $('#toast-title').text(title);
                    $('#toast-message').text(message);
                    $('#toast-notification').toast('show');
                }

                // ============================
                // COMMON FETCH FUNCTION
                // ============================

                async function fetchRequest(url, method = 'POST', data = {}) {

                    try {

                        const response = await fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(data)
                        });

                        return await response.json();

                    } catch (error) {
                        console.error(error);

                        return {
                            success: false,
                            message: 'Something went wrong'
                        };
                    }
                }

                // ============================
                // SAVE TOSS
                // ============================

                document.getElementById('save-toss-btn')
                    .addEventListener('click', async function () {

                        const tossWinner = document.getElementById('toss-winner').value;
                        const tossDecision = document.getElementById('toss-decision').value;

                        if (!tossWinner || !tossDecision) {
                            return showToast(
                                'Warning',
                                'Please select toss winner and decision',
                                'warning'
                            );
                        }

                        const response = await fetchRequest(
                            '{{ route("admin.matches.save-toss", $match->id) }}',
                            'PATCH',
                            {
                                toss_winner: tossWinner,
                                toss_decision: tossDecision
                            }
                        );

                        if (response.success) {
                            showToast('Success', response.message);
                            setTimeout(() => location.reload(), 800);
                        } else {
                            showToast('Error', response.message);
                        }
                    });

                // ============================
                // INNINGS TABS
                // ============================

                document.querySelectorAll('.innings-tab')
                    .forEach(tab => {

                        tab.addEventListener('click', function () {

                            const innings = this.dataset.innings;

                            document.querySelectorAll('.innings-tab')
                                .forEach(btn => {

                                    btn.classList.remove(
                                        'bg-gradient-to-r',
                                        'from-emerald-600',
                                        'to-teal-600',
                                        'text-white',
                                        'shadow-lg'
                                    );

                                    btn.classList.add(
                                        'bg-slate-900/60',
                                        'text-slate-400'
                                    );
                                });

                            this.classList.remove(
                                'bg-slate-900/60',
                                'text-slate-400'
                            );

                            this.classList.add(
                                'bg-gradient-to-r',
                                'from-emerald-600',
                                'to-teal-600',
                                'text-white',
                                'shadow-lg'
                            );

                            document.querySelectorAll('.innings-panel')
                                .forEach(panel => panel.classList.add('hidden'));

                            document.querySelector(
                                `[data-innings-panel="${innings}"]`
                            ).classList.remove('hidden');
                        });
                    });

                // ============================
                // SET STRIKER / NON STRIKER
                // ============================

                document.querySelectorAll('.set-striker-btn')
                    .forEach(button => {

                        button.addEventListener('click', async function () {

                            const role = this.dataset.role;
                            const innings = this.dataset.innings;

                            const selectId =
                                role === 'striker'
                                    ? `#striker-select-${innings}`
                                    : `#nonstriker-select-${innings}`;

                            const playerId =
                                document.querySelector(selectId).value;

                            if (!playerId) {
                                return showToast(
                                    'Warning',
                                    'Please select player',
                                    'warning'
                                );
                            }

                            const response = await fetchRequest(
                                '{{ route("admin.scores.next-batsman", ["match" => $match->id]) }}',
                                'POST',
                                {
                                    player_id: playerId,
                                    role: role,
                                    innings: innings
                                }
                            );

                            if (response.success) {
                                showToast('Success', response.message);
                                setTimeout(() => location.reload(), 800);
                            } else {
                                showToast('Error', response.message);
                            }
                        });
                    });

                // ============================
                // SWAP STRIKE
                // ============================

                document.querySelectorAll('.swap-strike-btn')
                    .forEach(button => {

                        button.addEventListener('click', async function () {

                            const response = await fetchRequest(
                                '{{ url("admin/scores/" . $match->id . "/swap-strike") }}'
                            );

                            if (response.success) {
                                showToast('Success', 'Strike swapped');
                                setTimeout(() => location.reload(), 600);
                            } else {
                                showToast('Error', response.message);
                            }
                        });
                    });

                // ============================
                // RUN BUTTON
                // ============================

                document.querySelectorAll('.run-btn')
                    .forEach(button => {

                        button.addEventListener('click', async function () {

                            const runs = this.dataset.runs;
                            const batsmanId = this.dataset.batsmanId;

                            const url =
                                '{{ route("admin.scores.runs", ["match" => $match->id, "player" => "__PLAYER_ID__"]) }}'
                                    .replace('__PLAYER_ID__', batsmanId);

                            const response = await fetchRequest(
                                url,
                                'POST',
                                { runs: runs }
                            );

                            if (response.success) {
                                // score
                                document.getElementById('match-score').innerText =
                                    response.score;

                                document.getElementById('match-wickets').innerText =
                                    response.wickets;

                                // striker runs
                                if (response.striker) {
                                    document.getElementById(
                                        'batsman-runs-' + response.striker.id
                                    ).innerText = response.striker.runs;
                                }

                                // bowler wickets
                                if (response.bowler) {

                                    document.getElementById(
                                        'bowler-wkts-' + response.bowler.id
                                    ).innerText = response.bowler.wickets;
                                }
                                showToast('Success', response.message);

                            } else {
                                showToast('Error', response.message);
                            }
                        });
                    });

                // ============================
                // BOWLER RUN BUTTON
                // ============================

                // ============================
                // NEXT BATSMAN
                // ============================

                const nextBtn =
                    document.getElementById('set-next-batsman-btn');

                if (nextBtn) {

                    nextBtn.addEventListener('click', async function () {

                        const playerId =
                            document.getElementById(
                                'next-batsman-select'
                            ).value;

                        if (!playerId) {
                            return showToast(
                                'Warning',
                                'Please select batsman',
                                'warning'
                            );
                        }

                        const response = await fetchRequest(
                            '{{ route("admin.scores.next-batsman", ["match" => $match->id]) }}',
                            'POST',
                            {
                                player_id: playerId
                            }
                        );

                        if (response.success) {
                            showToast('Success', response.message);
                            setTimeout(() => location.reload(), 800);
                        } else {
                            showToast('Error', response.message);
                        }
                    });
                }
                // ===========================
                //Ball Event
                // ============================
                document.querySelectorAll('.ball-btn').forEach(btn => {
                    btn.addEventListener('click', async function () {

                        const type = this.dataset.type;
                        const runs = this.dataset.runs || 0;
                        const innings = this.dataset.innings;

                        const response = await fetchRequest(
                            `{{ url("admin/scores/" . $match->id . "/ball-event") }}`,
                            'POST',
                            {
                                type,
                                runs,
                                innings
                            }
                        );

                        if (response.success) {

                            // update scoreboard
                            document.getElementById('match-score').innerText = response.score;
                            document.getElementById('match-wickets').innerText = response.wickets;

                            // update batsman
                            if (response.striker) {
                                document.getElementById('batsman-runs-' + response.striker.id).innerText = response.striker.runs;
                            }

                            showToast('Success', response.message);

                            // if striker changed → update UI without reload
                            if (response.swap_strike) {
                                console.log("Strike swapped");
                            }

                        } else {
                            showToast('Error', response.message);
                        }
                    });
                });
                // ============================
                // SET BOWLER
                // ============================

                const bowlerBtn =
                    document.getElementById('set-bowler-btn');

                if (bowlerBtn) {

                    bowlerBtn.addEventListener('click', async function () {

                        const playerId =
                            document.getElementById('bowler-select').value;

                        if (!playerId) {
                            return showToast(
                                'Warning',
                                'Please select bowler',
                                'warning'
                            );
                        }

                        const response = await fetchRequest(
                            '{{ route("admin.scores.set-bowler", ["match" => $match->id]) }}',
                            'POST',
                            {
                                player_id: playerId
                            }
                        );

                        if (response.success) {
                            showToast('Success', response.message);
                            setTimeout(() => location.reload(), 800);
                        } else {
                            showToast('Error', response.message);
                        }
                    });
                }

                // ============================
                // INITIALIZE BATTING
                // ============================

                const initBtn =
                    document.getElementById('initialize-batting-btn');

                if (initBtn) {

                    initBtn.addEventListener('click', async function () {

                        if (!confirm('Initialize batting?')) return;

                        const response = await fetchRequest(
                            '{{ route("admin.scores.initialize-batting", ["match" => $match->id]) }}'
                        );

                        if (response.success) {
                            showToast('Success', response.message);
                            setTimeout(() => location.reload(), 800);
                        } else {
                            showToast('Error', response.message);
                        }
                    });
                }

            });
        </script>
    @endsection