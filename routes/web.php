<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MatchesController;
use App\Http\Controllers\Admin\PlayerController;
use App\Http\Controllers\Admin\ContestController;
use App\Http\Controllers\Admin\ScoreController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth routes
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.submit');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Matches
    Route::resource('matches', MatchesController::class);
    Route::post('/matches/{match}/add-players', [MatchesController::class, 'addPlayers'])->name('admin.matches.add-players');
    Route::post('/matches/{match}/add-players', [MatchesController::class, 'addPlayers'])
        ->name('matches.addPlayers');

    Route::get('/matches/{match}/next', [MatchesController::class, 'showNext'])
        ->name('matches.showNext');
        Route::post('/matches/{match}/status', [MatchesController::class, 'updateStatus'])
    ->name('admin.matches.status');
   Route::patch('/matches/{id}/toss', [MatchesController::class, 'saveToss'])
    ->name('admin.matches.save-toss');
    // Players
    Route::resource('players', PlayerController::class);

    // Contests
    Route::resource('contests', ContestController::class);
    // Users
    Route::resource('users', AdminUserController::class);

    // Posts
    Route::resource('posts', PostController::class);
    
    // Score Management
      Route::prefix('scores')->name('admin.scores.')->group(function () {

            // Score Dashboard
            Route::get('/{match}', [ScoreController::class, 'index'])
                ->name('index');

            // Add Runs
            Route::post('/{match}/runs/{player}', [ScoreController::class, 'updateRuns'])
                ->name('runs');

            // Mark Out
            Route::post('/{match}/out/{player}', [ScoreController::class, 'markOut'])
                ->name('out');

            // Select Next Batsman
            Route::post('/{match}/next-batsman', [ScoreController::class, 'setNextBatsman'])
                ->name('next-batsman');
             Route::post('{match}/ball-event', [ScoreController::class, 'ballEvent'])
        ->name('ball-event');
            // Set Current Bowler
            Route::post('/{match}/set-bowler', [ScoreController::class, 'setBowler'])
                ->name('set-bowler');

            // Set Batting First Team
            Route::post('/{match}/batting-first', [ScoreController::class, 'setBattingFirst'])
                ->name('batting-first');

            // Initialize First Two Batsmen
            Route::post('/{match}/initialize-batting', [ScoreController::class, 'initializeBatting'])
                ->name('initialize-batting');

            // Legacy Manual Update
            Route::post('/update', [ScoreController::class, 'update'])
                ->name('update');
                Route::post('{match}/swap-strike', [ScoreController::class, 'swapStrike'])->name('swap-strike');

        });

});
// User routes
// Route::middleware(['auth'])->prefix('user')->group(function () {
//     Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');
//     Route::get('/matches', [App\Http\Controllers\User\MatchController::class, 'index'])->name('user.matches');
//     Route::get('/matches/{match}', [App\Http\Controllers\User\MatchController::class, 'show'])->name('user.matches.show');
//     Route::get('/contests', [App\Http\Controllers\User\ContestController::class, 'index'])->name('user.contests');
//     Route::get('/contests/{contest}', [App\Http\Controllers\User\ContestController::class, 'show'])->name('user.contests.show');
//     Route::post('/contests/{contest}/join', [App\Http\Controllers\User\ContestController::class, 'join'])->name('user.contests.join');
//     Route::get('/teams', [App\Http\Controllers\User\TeamController::class, 'index'])->name('user.teams');
//     Route::get('/teams/create/{match}', [App\Http\Controllers\User\TeamController::class, 'create'])->name('user.teams.create');
//     Route::post('/teams', [App\Http\Controllers\User\TeamController::class, 'store'])->name('user.teams.store');
//     Route::get('/leaderboard', [App\Http\Controllers\User\LeaderboardController::class, 'index'])->name('user.leaderboard');
//     Route::get('/news', [App\Http\Controllers\User\NewsController::class, 'index'])->name('user.news');
// });
