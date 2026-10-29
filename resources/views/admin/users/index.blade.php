@extends('admin.layout.app')

@section('title', 'User Management')
@section('page-title', 'User Management')

@section('content')

<!-- Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold">User Management</h2>
        <p class="text-gray-400">Manage all registered users</p>
    </div>
    <div class="flex gap-3">
        <input type="text" id="searchInput" placeholder="Search users..." 
               class="bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-blue-500">
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 rounded-xl">
        <p class="text-gray-400 text-xs">TOTAL USERS</p>
        <h3 class="text-2xl font-bold text-cyan-400">{{ $users->count() }}</h3>
    </div>
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 rounded-xl">
        <p class="text-gray-400 text-xs">ACTIVE USERS</p>
        <h3 class="text-2xl font-bold text-green-400">{{ $users->where('status', true)->count() }}</h3>
    </div>
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 rounded-xl">
        <p class="text-gray-400 text-xs">INACTIVE USERS</p>
        <h3 class="text-2xl font-bold text-red-400">{{ $users->where('status', false)->count() }}</h3>
    </div>
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 rounded-xl">
        <p class="text-gray-400 text-xs">TOTAL WALLET BALANCE</p>
        <h3 class="text-2xl font-bold text-purple-400">₹{{ number_format($users->sum('wallet'), 2) }}</h3>
    </div>
</div>

<!-- Users Table -->
<div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-800">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">User</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Wallet</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Joined</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($users as $user)
                <tr class="table-row hover:bg-gray-800/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-sm font-bold">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            <div>
                                <p class="font-medium">{{ $user->name }}</p>
                                <p class="text-xs text-gray-400">ID: {{ $user->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-300">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="text-green-400 font-semibold">₹{{ number_format($user->wallet, 2) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($user->status)
                            <span class="px-3 py-1 rounded-full text-xs bg-green-500/20 text-green-400">Active</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs bg-red-500/20 text-red-400">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-sm">
                        {{ $user->created_at->diffForHumans() }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <!-- Toggle Status -->
                            <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="px-3 py-1 rounded-lg text-xs {{ $user->status ? 'bg-red-500/20 text-red-400 hover:bg-red-500/30' : 'bg-green-500/20 text-green-400 hover:bg-green-500/30' }} transition-colors">
                                    {{ $user->status ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            
                            <!-- Add Balance Button -->
                            <button onclick="openAddBalanceModal({{ $user->id }}, '{{ $user->name }}')" 
                                    class="px-3 py-1 rounded-lg text-xs bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 transition-colors">
                                Add Balance
                            </button>
                            
                            <!-- View Details -->
                            <a href="{{ route('admin.users.show', $user->id) }}" 
                               class="px-3 py-1 rounded-lg text-xs bg-purple-500/20 text-purple-400 hover:bg-purple-500/30 transition-colors">
                                View
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                        No users found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Balance Modal -->
<div id="addBalanceModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-gray-800 rounded-2xl p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Add Balance</h3>
            <button onclick="closeAddBalanceModal()" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form id="addBalanceForm" method="POST">
            @csrf
            <div class="mb-4">
                <p class="text-gray-400 mb-2">Adding balance to: <span id="modalUserName" class="text-white font-semibold"></span></p>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm text-gray-400 mb-2">Amount (₹)</label>
                <input type="number" name="amount" step="0.01" min="0.01" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                       placeholder="Enter amount">
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeAddBalanceModal()" 
                        class="flex-1 px-4 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 transition-colors">
                    Add Balance
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
    
    // Modal functions
    function openAddBalanceModal(userId, userName) {
        document.getElementById('modalUserName').textContent = userName;
        document.getElementById('addBalanceForm').action = `/admin/users/${userId}/wallet/add`;
        document.getElementById('addBalanceModal').classList.remove('hidden');
        document.getElementById('addBalanceModal').classList.add('flex');
    }
    
    function closeAddBalanceModal() {
        document.getElementById('addBalanceModal').classList.add('hidden');
        document.getElementById('addBalanceModal').classList.remove('flex');
    }
    
    // Close modal on outside click
    document.getElementById('addBalanceModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAddBalanceModal();
        }
    });
</script>
@endsection
