# Fantasy Cricket Admin Panel - Complete Documentation

## 🎯 Overview

This is a complete Laravel-based admin panel for a fantasy cricket application (similar to Dream11). The system includes full admin flow, database migrations, controllers, models, routes, and business logic.

## 📋 Table of Contents

1. [Database Schema](#database-schema)
2. [Admin Flow](#admin-flow)
3. [Controllers](#controllers)
4. [Models & Relationships](#models--relationships)
5. [Routes](#routes)
6. [Services & Business Logic](#services--business-logic)
7. [Middleware](#middleware)
8. [Installation](#installation)

---

## 🗄️ Database Schema

### Tables Created

#### 1. users (Updated)
- Added `wallet` (decimal) - User's wallet balance
- Added `status` (boolean) - User active/inactive status

#### 2. matches
- `team_a`, `team_b` - Team names
- `sport` - Sport type
- `venue` - Match venue
- `date`, `match_time` - Match schedule
- `status` - UPCOMING, LIVE, DONE

#### 3. players
- `name`, `team` - Player info
- `role` - batsman, bowler, allrounder, wicketkeeper
- `credits` - Fantasy credit value (8-15)
- `points` - Total fantasy points

#### 4. match_players
- `match_id`, `name`, `team` - Match-specific player
- `role` - WK, BAT, AR, BOWL
- `credit` - Credit value
- `runs`, `wickets`, `catches`, `points` - Performance stats

#### 5. teams (NEW)
- `user_id`, `match_id` - User's team for a match
- `team_name` - Custom team name

#### 6. team_players (NEW)
- `team_id`, `match_player_id` - Team composition
- `is_captain`, `is_vice_captain` - Captain/VC flags

#### 7. contests
- `match_id` - Associated match
- `name`, `entry_fee`, `prize_pool` - Contest details
- `max_spots`, `joined_spots` - Participation limits
- `status` - open, live, closed
- `first_prize`, `winners_count` - Prize distribution

#### 8. contest_entries (NEW)
- `contest_id`, `user_id`, `team_id` - Entry details
- `points`, `rank`, `winnings` - Performance & rewards

#### 9. posts (NEW)
- `user_id`, `content`, `image` - Social feed posts
- `type` - news, result, announcement
- `likes` - Like count

#### 10. post_comments (NEW)
- `post_id`, `user_id`, `comment` - Comments on posts

---

## 🔄 Admin Flow

### 1. Admin Authentication
```
Admin Login → Middleware Check → Dashboard
```
- Role-based access control
- Session management
- Active status verification

### 2. User Management
```
Dashboard → Users → View/Activate/Deactivate → Add/Deduct Balance
```
- View all users
- Toggle user status (active/inactive)
- Manage wallet balance
- View user teams & contest entries

### 3. Match Management
```
Dashboard → Matches → Create Match → Add Players → Set Status
```
- Create matches with team details
- Add players to matches
- Update match status (UPCOMING → LIVE → DONE)
- Edit/Delete matches

### 4. Player Management
```
Dashboard → Players → Add/Edit/Delete → Assign to Matches
```
- Manage player database
- Set roles and credits
- Assign players to matches

### 5. Contest Management
```
Dashboard → Matches → Contests → Create/Edit → Calculate Rankings → Distribute Prizes
```
- Create contests for matches
- Set entry fees and prize pools
- Monitor participation
- Calculate rankings
- Distribute prizes to winners

### 6. Score Management
```
Dashboard → Matches → Scores → Update Player Stats → Auto-calculate Points
```
- Update player performance (runs, wickets, catches)
- Auto-calculate fantasy points
- Bulk score updates
- Real-time leaderboard updates

### 7. Social Feed Management
```
Dashboard → Posts → Create/Edit/Delete → Manage Comments
```
- Post news and announcements
- Share match results
- Moderate comments

---

## 🎮 Controllers

### Admin Controllers

#### 1. DashboardController
- `index()` - Display dashboard with statistics

#### 2. AdminUserController
- `index()` - List all users
- `show($id)` - View user details
- `toggleStatus($id)` - Activate/deactivate user
- `addBalance(Request, $id)` - Add wallet balance
- `deductBalance(Request, $id)` - Deduct wallet balance
- `viewTeams($id)` - View user's teams
- `viewContests($id)` - View user's contest entries

#### 3. MatchesController
- `index()` - List all matches
- `create()` - Show create form
- `addMatches(Request)` - Store new match
- `showNext($id)` - Show add players form
- `addPlayers(Request, $id)` - Add players to match
- `edit($id)` - Show edit form
- `update(Request, $id)` - Update match
- `updateStatus(Request, $id)` - Update match status
- `destroy($id)` - Delete match
- `viewPlayers($id)` - View match players

#### 4. PlayerController
- `index()` - List all players
- `create()` - Show create form
- `store(Request)` - Store new player
- `edit($id)` - Show edit form
- `update(Request, $id)` - Update player
- `destroy($id)` - Delete player
- `addToMatch(Request, $matchId)` - Add players to match
- `search(Request)` - Search players

#### 5. ContestController
- `index($id)` - List contests for match
- `create($id)` - Show create form
- `store(Request, $id)` - Store new contest
- `show($id)` - View contest details
- `edit($id)` - Show edit form
- `update(Request, $id)` - Update contest
- `updateStatus(Request, $id)` - Update contest status
- `destroy($id)` - Delete contest
- `leaderboard($id)` - View contest leaderboard
- `calculateRankings($id)` - Calculate rankings
- `distributePrizes($id)` - Distribute prizes

#### 6. ScoreController
- `index($id)` - Show score management
- `update(Request)` - Update multiple player scores
- `updatePlayerScore(Request, $playerId)` - Update single player
- `bulkUpdate(Request)` - Bulk score update

#### 7. PostController
- `index()` - List all posts
- `create()` - Show create form
- `store(Request)` - Store new post
- `edit($id)` - Show edit form
- `update(Request, $id)` - Update post
- `destroy($id)` - Delete post
- `viewComments($id)` - View post comments
- `deleteComment($postId, $commentId)` - Delete comment

---

## 🔗 Models & Relationships

### User Model
```php
- hasMany(Team)
- hasMany(ContestEntry)
- hasMany(Post)
- hasMany(PostComment)
- isAdmin()
- isActive()
```

### Matches Model
```php
- hasMany(MatchPlayer)
- hasMany(Contest)
- hasMany(Team)
- isUpcoming()
- isLive()
- isCompleted()
```

### Contest Model
```php
- belongsTo(Matches)
- hasMany(ContestEntry)
- belongsToMany(User)
- isFull()
- isOpen()
- isLive()
- isClosed()
- available_spots (attribute)
```

### MatchPlayer Model
```php
- belongsTo(Matches)
- hasMany(TeamPlayer)
- calculatePoints()
- role_display (attribute)
```

### Team Model
```php
- belongsTo(User)
- belongsTo(Matches)
- hasMany(TeamPlayer)
- belongsToMany(MatchPlayer)
- hasMany(ContestEntry)
- calculateTotalPoints()
- total_credits (attribute)
- getPlayerCountByRole()
```

### TeamPlayer Model
```php
- belongsTo(Team)
- belongsTo(MatchPlayer)
- isCaptain()
- isViceCaptain()
- getPointsWithMultiplier()
```

### ContestEntry Model
```php
- belongsTo(Contest)
- belongsTo(User)
- belongsTo(Team)
- calculateAndUpdatePoints()
- updateRank()
- updateWinnings()
```

### Post Model
```php
- belongsTo(User)
- hasMany(PostComment)
- incrementLikes()
- decrementLikes()
- isNews()
- isResult()
- isAnnouncement()
```

### PostComment Model
```php
- belongsTo(Post)
- belongsTo(User)
```

---

## 🛣️ Routes

### Public Routes
```
GET  /                          - Welcome page
POST /register                  - User registration
POST /login                     - User login
POST /logout                    - User logout (auth required)
```

### User Routes (Authenticated)
```
GET  /user/dashboard            - User dashboard
GET  /user/teams                - User's teams
GET  /user/contests             - User's contests
GET  /user/leaderboard          - Leaderboard
GET  /user/matches              - Available matches
GET  /user/news                 - Social feed
```

### Admin Routes (Authenticated + Admin Middleware)
```
Dashboard:
GET  /admin/dashboard           - Admin dashboard

User Management:
GET  /admin/users                       - List users
GET  /admin/users/{id}                  - View user
POST /admin/users/{id}/toggle           - Toggle status
POST /admin/users/{id}/wallet/add       - Add balance
POST /admin/users/{id}/wallet/deduct    - Deduct balance
GET  /admin/users/{id}/teams            - View user teams
GET  /admin/users/{id}/contests         - View user contests

Match Management:
GET    /admin/matches                   - List matches
GET    /admin/matches/create            - Create form
POST   /admin/matches                   - Store match
GET    /admin/matches/{id}/edit         - Edit form
PUT    /admin/matches/{id}              - Update match
POST   /admin/matches/{id}/status       - Update status
DELETE /admin/matches/{id}              - Delete match
GET    /admin/matches/{id}/players      - View players
GET    /admin/matches/{id}/addplayers   - Add players form
POST   /admin/matches/{id}/players      - Add players

Player Management:
GET    /admin/players                   - List players
GET    /admin/players/create            - Create form
POST   /admin/players                   - Store player
GET    /admin/players/{id}/edit         - Edit form
PUT    /admin/players/{id}              - Update player
DELETE /admin/players/{id}              - Delete player
POST   /admin/matches/{matchId}/players/add - Add to match
GET    /admin/players/search            - Search players

Contest Management:
GET    /admin/matches/{id}/contests     - List contests
GET    /admin/matches/{id}/contests/create - Create form
POST   /admin/matches/{id}/contests     - Store contest
GET    /admin/contests/{id}             - View contest
GET    /admin/contests/{id}/edit        - Edit form
PUT    /admin/contests/{id}             - Update contest
POST   /admin/contests/{id}/status      - Update status
DELETE /admin/contests/{id}             - Delete contest
GET    /admin/contests/{id}/leaderboard - View leaderboard
POST   /admin/contests/{id}/calculate-rankings - Calculate rankings
POST   /admin/contests/{id}/distribute-prizes - Distribute prizes

Score Management:
GET  /admin/matches/{id}/scores        - Score management
POST /admin/scores/update              - Update scores
POST /admin/scores/player/{playerId}   - Update single player
POST /admin/scores/bulk                - Bulk update

Post Management:
GET    /admin/posts                     - List posts
GET    /admin/posts/create              - Create form
POST   /admin/posts                     - Store post
GET    /admin/posts/{id}/edit           - Edit form
PUT    /admin/posts/{id}                - Update post
DELETE /admin/posts/{id}                - Delete post
GET    /admin/posts/{id}/comments       - View comments
DELETE /admin/posts/{postId}/comments/{commentId} - Delete comment
```

---

## 🧠 Services & Business Logic

### 1. TeamValidationService
**Purpose**: Validate team creation rules

**Rules**:
- Exactly 11 players
- Max 100 credits
- Role limits:
  - WK: 1-4
  - BAT: 3-6
  - BOWL: 3-6
  - AR: 1-4
- Max 7 players from one team

**Methods**:
- `validateTeam($playerIds, $matchId)` - Validate team composition
- `validateCaptains($captainId, $viceCaptainId, $playerIds)` - Validate captain selection
- `calculateTeamPoints(Team)` - Calculate total points with multipliers
- `getTeamStats(Team)` - Get team statistics

### 2. ContestService
**Purpose**: Manage contest operations

**Methods**:
- `joinContest(User, Contest, $teamId)` - Join contest with validation
- `calculateRankings(Contest)` - Calculate and update rankings
- `distributePrizes(Contest)` - Distribute prizes to winners
- `getLeaderboard(Contest)` - Get contest leaderboard
- `getUserContestHistory(User)` - Get user's contest history
- `getContestStats(Contest)` - Get contest statistics

**Prize Distribution Logic**:
- Winner gets 50% of prize pool
- Remaining 50% distributed equally among other winners

### 3. FantasyPointsService
**Purpose**: Calculate fantasy points

**Points Configuration**:
- Run: 1 point
- Wicket: 25 points
- Catch: 10 points
- Stumping: 10 points
- Run out: 10 points
- Maiden over: 4 points
- Bonus 30 runs: 4 points
- Bonus 50 runs: 8 points
- Bonus 100 runs: 16 points
- Bonus 3 wickets: 4 points
- Bonus 5 wickets: 8 points

**Methods**:
- `calculatePoints(MatchPlayer)` - Calculate points for player
- `updatePlayerPoints(MatchPlayer)` - Update player points
- `bulkUpdatePoints($playersData)` - Bulk update points
- `getPointsBreakdown(MatchPlayer)` - Get detailed breakdown
- `getTopPerformers($matchId, $limit)` - Get top performers
- `getPlayerStats(MatchPlayer)` - Get player statistics

---

## 🔐 Middleware

### AdminMiddleware
**Purpose**: Protect admin routes

**Checks**:
1. User is authenticated
2. User role is 'admin'
3. User status is active

**Usage**:
```php
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Admin routes
});
```

---

## 🚀 Installation

### Step 1: Run Migrations
```bash
php artisan migrate
```

### Step 2: Create Admin User
```bash
php artisan tinker
```
```php
User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
    'wallet' => 0,
    'status' => true
]);
```

### Step 3: Access Admin Panel
```
URL: http://your-domain.com/admin/dashboard
Login: admin@example.com
Password: password
```

---

## 📊 Key Features

### ✅ Implemented Features

1. **Admin Authentication**
   - Role-based access control
   - Session management
   - Active status verification

2. **User Management**
   - View all users
   - Activate/deactivate users
   - Manage wallet balance
   - View user teams & contests

3. **Match Management**
   - Create/edit/delete matches
   - Add players to matches
   - Update match status
   - View match details

4. **Player Management**
   - Manage player database
   - Set roles and credits
   - Assign to matches

5. **Contest Management**
   - Create contests
   - Set entry fees & prize pools
   - Monitor participation
   - Calculate rankings
   - Distribute prizes

6. **Score Management**
   - Update player performance
   - Auto-calculate fantasy points
   - Bulk score updates
   - Real-time leaderboard

7. **Social Feed**
   - Post news & announcements
   - Share match results
   - Moderate comments

8. **Business Logic**
   - Team validation rules
   - Fantasy points calculation
   - Prize distribution
   - Captain/VC multipliers

---

## 🎯 Next Steps

### Recommended Enhancements

1. **Admin UI**
   - Build Blade templates with Tailwind CSS
   - Add charts and graphs
   - Real-time updates with AJAX

2. **User Side**
   - Team creation interface
   - Contest joining flow
   - Live leaderboard

3. **Advanced Features**
   - WebSocket for live updates
   - Payment gateway integration
   - Push notifications
   - Advanced analytics

4. **Security**
   - Rate limiting
   - CSRF protection
   - Input sanitization
   - SQL injection prevention

---

## 📝 Notes

- All admin routes are protected by `admin` middleware
- Fantasy points are calculated automatically when scores are updated
- Captain gets 2x points, Vice-Captain gets 1.5x points
- Prize distribution can be customized in `ContestService`
- Team validation rules can be adjusted in `TeamValidationService`

---

## 🆘 Support

For issues or questions, refer to the Laravel documentation or contact the development team.
