# TrackEd – Centralized School Information System

A Laravel-based capstone project for DepEd schools. Tracks teacher performance (DLL builder), student behavior (incident log + Good Moral clearance), and property inventory (E-PAR).

## Setup in your Laravel project

1. **Pull this repo into your existing Laravel project folder:**
   ```bash
   git pull origin <branch-name>
   ```

2. **The following files will be added/updated automatically:**
   - `resources/views/layouts/app.blade.php` — sidebar + header layout
   - `resources/views/layouts/guest.blade.php` — login/register layout
   - `resources/views/auth/login.blade.php`
   - `resources/views/auth/register.blade.php`
   - `resources/views/dashboard.blade.php`
   - `resources/views/teacher-performance.blade.php`
   - `resources/views/student-behavior.blade.php`
   - `resources/views/property-inventory.blade.php`
   - `public/js/auth.js` — client-side auth (localStorage-based)
   - `routes/web.php` — all page routes

3. **Serve the app:**
   ```bash
   php artisan serve
   ```
   Then open `http://127.0.0.1:8000` in your browser.

## Demo credentials

| Role        | Email                       | Password   |
|-------------|-----------------------------|------------|
| Admin       | admin@deped.edu.ph          | Admin123   |
| School Head | schoolhead@deped.edu.ph     | Head123    |
| Counselor   | counselor@deped.edu.ph      | Counsel123 |
| Teacher     | teacher@deped.edu.ph        | Teacher123 |

> Click any row on the login page to auto-fill the credentials.

## Pages

| Route                  | Description                            |
|------------------------|----------------------------------------|
| `/`                    | Login page                             |
| `/register`            | Registration page                      |
| `/dashboard`           | KPI cards, DLL compliance chart        |
| `/teacher-performance` | DLL builder, AI pre-check, DSS ranking |
| `/student-behavior`    | Incident log, Good Moral certificate   |
| `/property-inventory`  | E-PAR asset table, year-end clearance  |

## License

MIT
