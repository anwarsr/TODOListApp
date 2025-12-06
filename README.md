# TODO List App (Laravel + Vite)

Laravel 10 task manager with categories, subtasks, important flagging, and Google OAuth sign-in. Includes role-based admin tools for user and task oversight.

## Features
- Email/password auth with Laravel Fortify; Google OAuth via Socialite.
- Roles (`admin`, `user`) with policy-protected admin routes.
- Tasks: CRUD, due dates, statuses, priority/important toggle, attachments via storage, and category assignment.
- Subtasks under each task with completion tracking.
- Categories: CRUD and filtering for tasks.
- Task filters/sorts: status, category, date range, and importance flag.
- Admin panel: manage users, tasks, and categories; role-gated actions.
- Profile: update name, email, password; back link returns admins to dashboard and users to tasks.

## Tech Stack
- PHP/Laravel 10, Inertia, Vite, TypeScript, Vue 3
- Tailwind CSS + DaisyUI styling
- MySQL (default) or other DB via `config/database.php`
- Pest/PHPUnit for tests

## Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL (or compatible database)

## Setup
1) Install PHP deps: `composer install`
2) Install JS deps: `npm install`
3) Copy env: `cp .env.example .env` (PowerShell: `copy .env.example .env`)
4) Generate key: `php artisan key:generate`
5) Configure database in `.env`
6) Run migrations: `php artisan migrate`
7) Build assets for dev: `npm run dev` (use `npm run build` for production)
8) Start server: `php artisan serve`

## Google OAuth Setup
- Create OAuth 2.0 Client ID (Web) in Google Cloud Console.
- Authorized redirect URI: `http://localhost:8000/auth/google/callback` (or your host).
- Add credentials to `.env`:
  - `GOOGLE_CLIENT_ID=...`
  - `GOOGLE_CLIENT_SECRET=...`
  - `GOOGLE_REDIRECT=http://localhost:8000/auth/google/callback`

## Admin & Access Control
- Roles stored on `users.role`; `admin` can access admin panel routes.
- Promote a user by updating `role` to `admin` in DB or dedicated admin UI.
- Policies/middleware protect admin actions; non-admins are blocked.

## Database Schema (key tables)
- `users`: name, email, password, `role`, `google_id`, `avatar`, two-factor columns.
- `tasks`: title, description, `category_id`, `is_important`, due date, status.
- `subtasks`: `task_id`, title, completed flag.
- `categories`: name, optional color/metadata.

## Running Tests
- PHP: `php artisan test` (or `./vendor/bin/pest`)
- JS lint: `npm run lint`

## Project Structure (high level)
- `app/Models`: `User`, `Task`, `Category`, `Subtask`.
- `app/Http/Controllers`: auth, Google OAuth, tasks, subtasks, categories, admin, profile.
- `routes/web.php`: web routes; `routes/auth.php`: auth routes; `routes/settings.php`: settings/profile.
- `resources/views` and `resources/js`: UI with Vite + Tailwind/DaisyUI.

## Deployment Notes
- Configure `APP_URL`, `ASSET_URL`, and storage link (`php artisan storage:link`).
- Set `SESSION_DOMAIN`/`SANCTUM_STATEFUL_DOMAINS` if using a separate frontend host.
- Ensure OAuth redirect matches deployed domain.
