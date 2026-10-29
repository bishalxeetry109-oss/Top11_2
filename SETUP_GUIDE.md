# Top11 Fantasy Cricket - Setup Guide

## Quick Start

### 1. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=top11
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Database Setup
```bash
# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

### 3. Create Admin User
```bash
php artisan tinker
```
```php
User::create([
    'name' => 'Admin',
    'email' => 'admin@top11.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
    'wallet' => 0,
    'status' => true
]);
```

### 4. Start Development Server
```bash
php artisan serve
```

Access the application at: `http://localhost:8000`

## Admin Panel Access

### Login Credentials
- **URL**: http://localhost:8000/login
- **Email**: admin@top11.com
- **Password**: password

### Admin Features

#### 1. Dashboard
- View total users, matches, contests, revenue
- Recent matches and users
- System logs

#### 2. User Management
- View all users
- Activate/deactivate users
- Add/deduct wallet balance
- View user teams and contest entries

#### 3. Match Management
- Create new matches
- Edit match details
- Update match status (UPCOMING, LIVE, DONE)
- Add players to matches
- Delete matches

#### 4. Player Management
- Add players to database
- Set player role (BAT, BOWL, WK, ALL)
- Set credit value (8-15)
- Edit/delete players

#### 5. Contest Management
- Create contests for matches
- Set entry fee and prize pool
- View contest leaderboard
- Calculate rankings
- Distribute prizes

#### 6. Score Management
- Update player scores (runs, wickets, catches)
- Auto-calculate fantasy points
- Bulk score updates

#### 7. Social Feed
- Create posts (news, results, announcements)
- Manage comments
- Delete inappropriate content

## User Features

### Registration & Login
- User registration with validation
- Login with email/password
- Session-based authentication

### User Dashboard
- View available matches
- Join contests
- Create teams
- View leaderboard
- Social feed

## Database Schema

### Tables
1. **users** - User accounts with wallet and status
2. **matches** - Cricket matches
3. **players** - Player database
4. **match_players** - Players in specific matches
5. **teams** - User-created fantasy teams
6. **team_players** - Players in teams with captain/VC
7. **contests** - Contest definitions
8. **contest_entries** - User contest participation
9. **posts** - Social feed posts
10. **post_comments** - Comments on posts

## Business Logic

### Team Creation Rules
- Exactly 11 players
- Maximum 100 credits
- Role limits:
  - WK: 1-4
  - BAT: 3-5
  - ALL: 1-4
  - BOWL: 3-5
- Maximum 7 players from one team

### Fantasy Points System
- **Runs**: 1 point per run
- **Wickets**: 25 points per wicket
- **Catches**: 10 points per catch
- **Captain**: 2x points
- **Vice-Captain**: 1.5x points

### Prize Distribution
- 1st Place: 50% of prize pool
- 2nd Place: 30% of prize pool
- 3rd Place: 20% of prize pool

## API Endpoints

### Authentication
- `GET /login` - Login page
- `POST /login` - Login action
- `GET /register` - Register page
- `POST /register` - Register action
- `POST /logout` - Logout action

### Admin Routes (Protected)
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/users` - User management
- `GET /admin/matches` - Match management
- `GET /admin/players` - Player management
- `GET /admin/contests` - Contest management
- `GET /admin/scores` - Score management
- `GET /admin/posts` - Social feed management

## Troubleshooting

### Common Issues

1. **Method Not Allowed Error**
   - Ensure routes support both GET and POST methods
   - Check route definitions in `routes/web.php`

2. **Database Connection Error**
   - Verify database credentials in `.env`
   - Ensure database exists

3. **Permission Denied**
   - Check file permissions
   - Ensure storage and bootstrap/cache are writable

4. **Session Issues**
   - Clear session: `php artisan session:table`
   - Restart server: `php artisan serve`

## Support

For issues or questions, refer to:
- Laravel Documentation: https://laravel.com/docs
- Project Documentation: `ADMIN_PANEL_DOCUMENTATION.md`
