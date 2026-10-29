<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top11 - Fantasy Sports Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Outfit', sans-serif; }
        
        .gradient-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
            animation: float 8s ease-in-out infinite;
        }
        
        .gradient-orb-1 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #06b6d4, #3b82f6);
            top: -100px;
            left: -100px;
        }
        
        .gradient-orb-2 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #8b5cf6, #ec4899);
            bottom: 10%;
            right: -50px;
            animation-delay: -2s;
        }
        
        .gradient-orb-3 {
            width: 250px;
            height: 250px;
            background: linear-gradient(135deg, #10b981, #06b6d4);
            top: 40%;
            left: 30%;
            animation-delay: -4s;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -30px) scale(1.1); }
        }
        
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .glass-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.02));
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            border-color: rgba(6, 182, 212, 0.5);
            box-shadow: 0 20px 40px rgba(6, 182, 212, 0.2);
        }
        
        .glass-button {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .glass-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(6, 182, 212, 0.4);
        }
        
        .glass-input {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        
        .glass-input:focus {
            border-color: #06b6d4;
            box-shadow: 0 0 20px rgba(6, 182, 212, 0.2);
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #06b6d4, #8b5cf6, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .glow {
            animation: glow 2s ease-in-out infinite alternate;
        }
        
        @keyframes glow {
            from { box-shadow: 0 0 20px rgba(6, 182, 212, 0.3); }
            to { box-shadow: 0 0 40px rgba(6, 182, 212, 0.6); }
        }
        
        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }
        
        @keyframes pulse-glow {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }
        
        /* Transparent Modal Backdrop */
        dialog::backdrop {
                background: rgba(255, 255, 255, 0.02); /* almost invisible */
    backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(8px);
        }
        
        /* Glass Input Enhancement */
        .glass-input {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(10px);
        }
        
        .glass-input:focus {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: rgba(6, 182, 212, 0.5) !important;
            box-shadow: 0 0 25px rgba(6, 182, 212, 0.25);
        }
    </style>
</head>
<body class="bg-[#0a0a0f] text-white min-h-screen relative overflow-x-hidden">

    <!-- Animated Background Orbs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="gradient-orb gradient-orb-1"></div>
        <div class="gradient-orb gradient-orb-2"></div>
        <div class="gradient-orb gradient-orb-3"></div>
    </div>

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-400 to-purple-500 flex items-center justify-center">
                        <span class="text-xl font-bold">11</span>
                    </div>
                    <span class="text-2xl font-bold">Top<span class="text-cyan-400">11</span></span>
                </a>
                
                <!-- Nav Links -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-gray-300 hover:text-cyan-400 transition">Features</a>
                    <a href="#how-it-works" class="text-gray-300 hover:text-cyan-400 transition">How it Works</a>
                    <a href="#contests" class="text-gray-300 hover:text-cyan-400 transition">Contests</a>
                </div>
                
                <!-- Auth Buttons -->
                <div class="flex items-center gap-3">
                    <button onclick="openModal('loginModal')" class="px-5 py-2 text-gray-300 hover:text-white transition">Sign In</button>
                    <button onclick="openModal('registerModal')" class="glass-button px-5 py-2 rounded-xl font-semibold">Play Now</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center pt-20">
        <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 glass px-4 py-2 rounded-full mb-8">
                <span class="w-2 h-2 bg-green-400 rounded-full pulse-glow"></span>
                <span class="text-sm text-gray-300">🏆 Over $4.5M in prizes won</span>
            </div>
            
            <!-- Main Heading -->
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight">
                Build Your <span class="text-gradient">Dream Team</span><br>
                Dominate the Competition
            </h1>
            
            <p class="text-xl text-gray-400 max-w-2xl mx-auto mb-10">
                The next-generation fantasy sports platform. Draft real players, 
                track live scores, and compete for massive prizes in daily contests.
            </p>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                <button onclick="openModal('registerModal')" class="glass-button px-8 py-4 rounded-xl text-lg font-semibold flex items-center gap-2">
                    Start Playing Free
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button onclick="openModal('loginModal')" class="glass px-8 py-4 rounded-xl text-lg font-semibold flex items-center gap-2 hover:bg-white/10 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                    </svg>
                    Watch Demo
                </button>
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
                <div class="glass-card rounded-2xl p-6 text-center">
                    <div class="text-3xl font-bold text-cyan-400">2.4M+</div>
                    <div class="text-gray-400 text-sm">Active Players</div>
                </div>
                <div class="glass-card rounded-2xl p-6 text-center">
                    <div class="text-3xl font-bold text-purple-400">1,500+</div>
                    <div class="text-gray-400 text-sm">Daily Contests</div>
                </div>
                <div class="glass-card rounded-2xl p-6 text-center">
                    <div class="text-3xl font-bold text-pink-400">$4.5M</div>
                    <div class="text-gray-400 text-sm">Prizes Won</div>
                </div>
                <div class="glass-card rounded-2xl p-6 text-center">
                    <div class="text-3xl font-bold text-green-400">24/7</div>
                    <div class="text-gray-400 text-sm">Live Matches</div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    Why Choose <span class="text-cyan-400">Top11</span>?
                </h2>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                    Experience fantasy sports like never before with cutting-edge features and seamless gameplay.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="glass-card rounded-3xl p-8">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Real-Time Scoring</h3>
                    <p class="text-gray-400">Watch your points update instantly as players perform. No refresh needed.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="glass-card rounded-3xl p-8">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Massive Prize Pools</h3>
                    <p class="text-gray-400">Compete in daily leagues, head-to-head battles, and mega contests.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="glass-card rounded-3xl p-8">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-400 to-cyan-500 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Fair Play</h3>
                    <p class="text-gray-400">Transparent system with anti-fraud protection ensures complete fairness.</p>
                </div>
                
                <!-- Feature 4 -->
                <div class="glass-card rounded-3xl p-8">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Social Leagues</h3>
                    <p class="text-gray-400">Create private contests with friends and challenge each other.</p>
                </div>
                
                <!-- Feature 5 -->
                <div class="glass-card rounded-3xl p-8">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Fast Drafts</h3>
                    <p class="text-gray-400">Quick and responsive team building with smart player suggestions.</p>
                </div>
                
                <!-- Feature 6 -->
                <div class="glass-card rounded-3xl p-8">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-400 to-red-500 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Instant Withdrawals</h3>
                    <p class="text-gray-400">Withdraw your winnings quickly to your bank account or wallet.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    How It <span class="text-gradient">Works</span>
                </h2>
                <p class="text-gray-400 text-lg">Get started in 3 simple steps</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 relative">
                <!-- Connecting Line -->
                <div class="hidden md:block absolute top-1/2 left-0 right-0 h-0.5 bg-gradient-to-r from-cyan-500 via-purple-500 to-pink-500 -translate-y-1/2 z-0"></div>
                
                <!-- Step 1 -->
                <div class="relative z-10">
                    <div class="glass-card rounded-3xl p-8 text-center">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center mx-auto mb-6 text-2xl font-bold">1</div>
                        <h3 class="text-xl font-semibold mb-3">Create Your Team</h3>
                        <p class="text-gray-400">Select 11 players within your budget of 100 credits. Choose your captain wisely!</p>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="relative z-10">
                    <div class="glass-card rounded-3xl p-8 text-center">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center mx-auto mb-6 text-2xl font-bold">2</div>
                        <h3 class="text-xl font-semibold mb-3">Join Contests</h3>
                        <p class="text-gray-400">Enter daily contests compete with thousands of other fantasy managers.</p>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="relative z-10">
                    <div class="glass-card rounded-3xl p-8 text-center">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-pink-400 to-red-500 flex items-center justify-center mx-auto mb-6 text-2xl font-bold">3</div>
                        <h3 class="text-xl font-semibold mb-3">Win Prizes</h3>
                        <p class="text-gray-400">Watch live scores and climb the leaderboard to win real cash prizes!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Live Matches Preview -->
    <section id="contests" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-4xl font-bold mb-2">Live & <span class="text-cyan-400">Upcoming</span></h2>
                    <p class="text-gray-400">Join contests for upcoming matches</p>
                </div>
                <a href="/matches" class="glass px-5 py-2 rounded-xl hover:bg-white/10 transition">View All →</a>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Match Card 1 -->
                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 bg-red-500/20 text-red-400 text-xs rounded-full">LIVE</span>
                        <span class="text-gray-400 text-sm">T20 International</span>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-center">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center mb-2 mx-auto">🇮🇳</div>
                            <div class="font-semibold">IND</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-cyan-400">145/2</div>
                            <div class="text-xs text-gray-400">15.2 ov</div>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-500 to-orange-400 flex items-center justify-center mb-2 mx-auto">🇦🇺</div>
                            <div class="font-semibold">AUS</div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="flex-1 glass-button py-2 rounded-xl text-sm font-semibold">View Contests</button>
                    </div>
                </div>
                
                <!-- Match Card 2 -->
                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 bg-blue-500/20 text-blue-400 text-xs rounded-full">UPCOMING</span>
                        <span class="text-gray-400 text-sm">IPL 2024</span>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-center">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center mb-2 mx-auto">💙</div>
                            <div class="font-semibold">MI</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-400">VS</div>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-500 to-blue-500 flex items-center justify-center mb-2 mx-auto">💛</div>
                            <div class="font-semibold">CSK</div>
                        </div>
                    </div>
                    <div class="text-center text-gray-400 text-sm mb-4">Tomorrow, 7:30 PM</div>
                    <div class="flex gap-2">
                        <button class="flex-1 glass-button py-2 rounded-xl text-sm font-semibold">Create Team</button>
                    </div>
                </div>
                
                <!-- Match Card 3 -->
                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 bg-purple-500/20 text-purple-400 text-xs rounded-full">UPCOMING</span>
                        <span class="text-gray-400 text-sm">Premier League</span>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-center">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-red-500 to-white flex items-center justify-center mb-2 mx-auto">🔴</div>
                            <div class="font-semibold">MUN</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-400">VS</div>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-white flex items-center justify-center mb-2 mx-auto">🔵</div>
                            <div class="font-semibold">ARS</div>
                        </div>
                    </div>
                    <div class="text-center text-gray-400 text-sm mb-4">Sat, 5:00 PM</div>
                    <div class="flex gap-2">
                        <button class="flex-1 glass-button py-2 rounded-xl text-sm font-semibold">Create Team</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 relative">
        <div class="max-w-4xl mx-auto px-6">
            <div class="glass-card rounded-3xl p-12 text-center relative overflow-hidden">
                <!-- Background Glow -->
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/20 via-purple-500/20 to-pink-500/20"></div>
                <div class="relative z-10">
                    <h2 class="text-4xl md:text-5xl font-bold mb-6">
                        Ready to <span class="text-gradient">Dominate</span>?
                    </h2>
                    <p class="text-xl text-gray-300 mb-8 max-w-xl mx-auto">
                        Join millions of fantasy sports enthusiasts and start building your winning team today!
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <button onclick="openModal('registerModal')" class="glass-button px-8 py-4 rounded-xl text-lg font-semibold glow">
                            Get Started Free
                        </button>
                        <a href="#features" class="glass px-8 py-4 rounded-xl text-lg font-semibold">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-white/10 py-12 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-400 to-purple-500 flex items-center justify-center">
                            <span class="text-xl font-bold">11</span>
                        </div>
                        <span class="text-2xl font-bold">Top<span class="text-cyan-400">11</span></span>
                    </div>
                    <p class="text-gray-400 text-sm">The ultimate fantasy sports platform. Build your dream team and win real prizes.</p>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-cyan-400 transition">Home</a></li>
                        <li><a href="#features" class="hover:text-cyan-400 transition">Features</a></li>
                        <li><a href="#contests" class="hover:text-cyan-400 transition">Contests</a></li>
                        <li><a href="#" class="hover:text-cyan-400 transition">Leaderboard</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-cyan-400 transition">Help Center</a></li>
                        <li><a href="#" class="hover:text-cyan-400 transition">Contact Us</a></li>
                        <li><a href="#" class="hover:text-cyan-400 transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-cyan-400 transition">Terms of Service</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Connect</h4>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 glass rounded-full flex items-center justify-center hover:bg-white/20 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 glass rounded-full flex items-center justify-center hover:bg-white/20 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 glass rounded-full flex items-center justify-center hover:bg-white/20 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.85.38-1.78.64-2.75.76 1-.6 1.76-1.55 2.12-2.68-.93.55-1.96.95-3.06 1.17-.88-.94-2.13-1.53-3.51-1.53-2.66 0-4.81 2.16-4.81 4.81 0 .38.04.75.13 1.1-4-.2-7.58-2.11-9.96-5.02-.42.72-.66 1.56-.66 2.46 0 1.68.85 3.16 2.14 4.02-.79-.02-1.53-.24-2.18-.6v.06c0 2.35 1.67 4.31 3.88 4.76-.4.1-.83.16-1.27.16-.31 0-.62-.03-.92-.08.63 1.96 2.45 3.39 4.61 3.43-1.69 1.32-3.83 2.1-6.15 2.1-.4 0-.8-.02-1.19-.07 2.19 1.4 4.78 2.22 7.57 2.22 9.07 0 14.02-7.52 14.02-14.02 0-.21 0-.43-.01-.64.96-.69 1.79-1.56 2.45-2.55z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-white/10 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2024 Top11 Fantasy Sports. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Login Modal - Transparent Background -->
    <dialog id="loginModal" class="w-full h-full p-0 m-0 bg-transparent">

    <div class="flex items-center justify-center min-h-screen p-4">

        <!-- LOGIN FORM -->
        <form method="POST" action="{{route('login')}}"
              class="max-w-md w-full rounded-3xl p-8 border border-white/20 relative
                     backdrop-blur-xl bg-white/5 shadow-2xl"
              onclick="event.stopPropagation()">

            <!-- CLOSE BUTTON (IMPORTANT FIX: type=button) -->
            <button type="button"
                    onclick="closeModal('loginModal')"
                    class="absolute top-4 right-4 text-gray-400 hover:text-white text-2xl">
                &times;
            </button>

            <!-- HEADER -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-cyan-400 to-purple-500 flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold">11</span>
                </div>

                <h2 class="text-3xl font-bold mb-2">Welcome Back</h2>
                <p class="text-gray-400">Sign in to continue your fantasy journey</p>
            </div>

            @csrf

            <!-- INPUTS -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-2">Email</label>
                    <input type="email" name="email" required
                           placeholder="Enter your email"
                           class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2">Password</label>
                    <input type="password" name="password" required
                           placeholder="Enter your password"
                           class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400">
                </div>

                <!-- OPTIONS -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" class="rounded border-white/30 text-cyan-500">
                        <span class="text-sm text-gray-400">Remember me</span>
                    </label>

                    <a href="#" class="text-sm text-cyan-400 hover:text-cyan-300">
                        Forgot password?
                    </a>
                </div>

                <!-- BUTTON -->
                <button type="submit"
                        class="w-full bg-cyan-500 hover:bg-cyan-600 py-3 rounded-xl font-semibold transition">
                    Sign In
                </button>
            </div>

            <!-- FOOTER -->
            <div class="mt-6 text-center">
                <p class="text-gray-400">
                    Don't have an account?
                    <button type="button"
                            onclick="switchModal('loginModal','registerModal')"
                            class="text-cyan-400 hover:text-cyan-300 font-medium">
                        Sign up
                    </button>
                </p>
            </div>

        </form>

    </div>
</dialog>

    <!-- Register Modal - Transparent Background -->
    <dialog id="registerModal" class=" p-0 m-0 w-full h-full bg-transparent">
        <div class="flex items-center justify-center min-h-screen p-4">
            <!-- Transparent glass form with enhanced blur -->
            <form method="POST" action="{{route('register')}}" class="max-w-md w-full bg-white/[0.03] backdrop-blur-xl rounded-3xl p-8 shadow-2xl border border-white/[0.15] relative" style="background: linear-gradient(135deg, rgba(255,255,255,0.05), rgba(255,255,255,0.01));">
                <button onclick="closeModal('registerModal')" class="absolute top-4 right-4 text-gray-400 hover:text-white text-2xl">&times;</button>
                
                <div class="text-center mb-8">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-cyan-400 to-purple-500 flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold">11</span>
                    </div>
                    <h2 class="text-3xl font-bold mb-2">Join Top11</h2>
                    <p class="text-gray-400">Create your account and start playing</p>
                </div>
                
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-gray-400 mb-2">Full Name</label>
                        <input type="text" name="name" required placeholder="Enter your name" 
                               class="w-full px-4 py-3 glass-input rounded-xl text-white placeholder-gray-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-2">Email</label>
                        <input type="email" name="email" required placeholder="Enter your email" 
                               class="w-full px-4 py-3 glass-input rounded-xl text-white placeholder-gray-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-2">Password</label>
                        <input type="password" name="password" required placeholder="Create a password" 
                               class="w-full px-4 py-3 glass-input rounded-xl text-white placeholder-gray-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" required placeholder="Confirm your password" 
                               class="w-full px-4 py-3 glass-input rounded-xl text-white placeholder-gray-500 focus:outline-none">
                    </div>
                    
                    <button type="submit" class="w-full glass-button py-3 rounded-xl font-semibold">
                        Create Account
                    </button>
                </div>
                
                <div class="mt-6 text-center">
                    <p class="text-gray-400">Already have an account? 
                        <button type="button" onclick="switchModal('registerModal', 'loginModal')" class="text-cyan-400 hover:text-cyan-300 font-medium">Sign in</button>
                    </p>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).showModal();
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).close();
        }
        
        function switchModal(fromModal, toModal) {
            document.getElementById(fromModal).close();
            setTimeout(() => {
                document.getElementById(toModal).showModal();
            }, 100);
        }
        
        // Close modal on backdrop click
        document.querySelectorAll('dialog').forEach(modal => {
            modal.addEventListener('click', (e) => {
                const dialogDimensions = modal.getBoundingClientRect();
                if (
                    e.clientX < dialogDimensions.left ||
                    e.clientX > dialogDimensions.right ||
                    e.clientY < dialogDimensions.top ||
                    e.clientY > dialogDimensions.bottom
                ) {
                    modal.close();
                }
            });
        });
    </script>
</body>
</html>
