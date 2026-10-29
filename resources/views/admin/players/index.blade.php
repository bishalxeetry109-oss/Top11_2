@extends('admin.layout.app')

@section('title', 'Player Management')
@section('page-title', 'Player Management')

@section('content')

<!-- Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold">Player Management</h2>
        <p class="text-gray-400">Manage player database</p>
    </div>
    <button onclick="openAddPlayerModal()" 
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg flex items-center gap-2 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add Player
    </button>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-5 gap-4 mb-6">
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 rounded-xl">
        <p class="text-gray-400 text-xs">TOTAL PLAYERS</p>
        <h3 class="text-2xl font-bold text-cyan-400">{{ $players->count() }}</h3>
    </div>
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 rounded-xl">
        <p class="text-gray-400 text-xs">BATSMEN</p>
        <h3 class="text-2xl font-bold text-blue-400">{{ $players->where('role', 'batsman')->count() }}</h3>
    </div>
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 rounded-xl">
        <p class="text-gray-400 text-xs">BOWLERS</p>
        <h3 class="text-2xl font-bold text-green-400">{{ $players->where('role', 'bowler')->count() }}</h3>
    </div>
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 rounded-xl">
        <p class="text-gray-400 text-xs">ALL ROUNDERS</p>
        <h3 class="text-2xl font-bold text-yellow-400">{{ $players->where('role', 'allrounder')->count() }}</h3>
    </div>
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 rounded-xl">
        <p class="text-gray-400 text-xs">WICKET KEEPERS</p>
        <h3 class="text-2xl font-bold text-purple-400">{{ $players->where('role', 'wicketkeeper')->count() }}</h3>
    </div>
</div>

<!-- Players Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    @forelse($players as $player)
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-xl p-4 hover:shadow-lg transition-all duration-200">
        <div class="flex items-start justify-between mb-3">
            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-lg font-bold">
                {{ substr($player->name, 0, 2) }}
            </div>
            <span class="px-2 py-1 rounded-full text-xs 
                @if($player->role === 'batsman') bg-blue-500/20 text-blue-400
                @elseif($player->role === 'bowler') bg-green-500/20 text-green-400
                @elseif($player->role === 'allrounder') bg-yellow-500/20 text-yellow-400
                @else bg-purple-500/20 text-purple-400
                @endif">
                {{ ucfirst($player->role) }}
            </span>
        </div>
        
        <h3 class="font-semibold text-lg mb-1">{{ $player->name }}</h3>
        <p class="text-gray-400 text-sm mb-3">{{ $player->team }}</p>
        
        <div class="flex justify-between items-center mb-3">
            <div>
                <p class="text-xs text-gray-400">Credits</p>
                <p class="text-cyan-400 font-bold">{{ $player->credits }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Points</p>
                <p class="text-green-400 font-bold">{{ $player->points }}</p>
            </div>
        </div>
        
        <div class="flex gap-2">
            <button onclick="openEditPlayerModal({{ $player->id }}, '{{ $player->name }}', '{{ $player->team }}', '{{ $player->role }}', {{ $player->credits }})" 
                    class="flex-1 px-3 py-2 rounded-lg text-xs bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 transition-colors">
                Edit
            </button>
            <form action="{{ route('players.destroy', $player->id) }}" method="POST" class="flex-1" 
                  onsubmit="return confirm('Are you sure you want to delete this player?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="w-full px-3 py-2 rounded-lg text-xs bg-red-500/20 text-red-400 hover:bg-red-500/30 transition-colors">
                    Delete
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12 text-gray-400">
        No players found. <button onclick="openAddPlayerModal()" class="text-blue-400 hover:underline">Add your first player</button>
    </div>
    @endforelse
</div>

<!-- Add Player Modal -->
<div id="addPlayerModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-gray-800 rounded-2xl p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Add New Player</h3>
            <button onclick="closeAddPlayerModal()" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form action="{{ route('players.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm text-gray-400 mb-2">Player Name</label>
                <input type="text" name="name" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                       placeholder="Enter player name">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm text-gray-400 mb-2">Team</label>
                <input type="text" name="team" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                       placeholder="Enter team name">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm text-gray-400 mb-2">Role</label>
                <select name="role" required
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                    <option value="">Select role</option>
                    <option value="batsman">Batsman</option>
                    <option value="bowler">Bowler</option>
                    <option value="allrounder">All Rounder</option>
                    <option value="wicketkeeper">Wicket Keeper</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm text-gray-400 mb-2">Credits (8-15)</label>
                <input type="number" name="credits" min="8" max="15" step="0.5" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                       placeholder="Enter credits">
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeAddPlayerModal()" 
                        class="flex-1 px-4 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 transition-colors">
                    Add Player
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Player Modal -->
<div id="editPlayerModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-gray-800 rounded-2xl p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Edit Player</h3>
            <button onclick="closeEditPlayerModal()" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form id="editPlayerForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm text-gray-400 mb-2">Player Name</label>
                <input type="text" name="name" id="editPlayerName" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm text-gray-400 mb-2">Team</label>
                <input type="text" name="team" id="editPlayerTeam" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm text-gray-400 mb-2">Role</label>
                <select name="role" id="editPlayerRole" required
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                    <option value="batsman">Batsman</option>
                    <option value="bowler">Bowler</option>
                    <option value="allrounder">All Rounder</option>
                    <option value="wicketkeeper">Wicket Keeper</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm text-gray-400 mb-2">Credits (8-15)</label>
                <input type="number" name="credits" id="editPlayerCredits" min="8" max="15" step="0.5" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeEditPlayerModal()" 
                        class="flex-1 px-4 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 transition-colors">
                    Update Player
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Add Player Modal
    function openAddPlayerModal() {
        document.getElementById('addPlayerModal').classList.remove('hidden');
        document.getElementById('addPlayerModal').classList.add('flex');
    }
    
    function closeAddPlayerModal() {
        document.getElementById('addPlayerModal').classList.add('hidden');
        document.getElementById('addPlayerModal').classList.remove('flex');
    }
    
    // Edit Player Modal
    function openEditPlayerModal(id, name, team, role, credits) {
        document.getElementById('editPlayerName').value = name;
        document.getElementById('editPlayerTeam').value = team;
        document.getElementById('editPlayerRole').value = role;
        document.getElementById('editPlayerCredits').value = credits;
        document.getElementById('editPlayerForm').action = `/admin/players/${id}`;
        document.getElementById('editPlayerModal').classList.remove('hidden');
        document.getElementById('editPlayerModal').classList.add('flex');
    }
    
    function closeEditPlayerModal() {
        document.getElementById('editPlayerModal').classList.add('hidden');
        document.getElementById('editPlayerModal').classList.remove('flex');
    }
    
    // Close modals on outside click
    document.getElementById('addPlayerModal').addEventListener('click', function(e) {
        if (e.target === this) closeAddPlayerModal();
    });
    
    document.getElementById('editPlayerModal').addEventListener('click', function(e) {
        if (e.target === this) closeEditPlayerModal();
    });
</script>
@endsection
