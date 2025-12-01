# Railway Deployment Guide - TODOListApp

## ⚠️ Build Error Fix

### Problem
Deployment fails with error:
```
[vite:load-fallback] Could not load /resources/js/actions/App/Http/Controllers/Auth/...
ENOENT: no such file or directory
```

### Root Cause
Laravel Wayfinder plugin **does not generate action files for subfolder controllers** like:
- `App\Http\Controllers\Auth\*`
- `App\Http\Controllers\Settings\*`

### Solution Applied

#### 1. Created Build Script
**File:** `scripts/create-auth-actions.cjs`
- Generates missing Auth controller actions
- Generates appearance routes
- Runs automatically before Vite build

#### 2. Updated package.json
```json
"scripts": {
    "build": "npm run generate-actions && vite build",
    "generate-actions": "php artisan wayfinder:generate && node scripts/create-auth-actions.cjs"
}
```

#### 3. Disabled Wayfinder Vite Plugin
**File:** `vite.config.ts`
- Commented out `wayfinder({...})` plugin
- Prevents regeneration during build (which deletes manual files)

#### 4. Added Path Alias
**File:** `vite.config.ts`
```typescript
resolve: {
    alias: {
        '@': path.resolve(__dirname, './resources/js'),
    },
},
```

### ⚠️ PENDING: Settings Controllers

The script currently generates **Auth controllers** only. You still need to add **Settings controllers**:

**Required:**
- `PasswordController.ts`
- `ProfileController.ts`

**Option 1:** Update `scripts/create-auth-actions.cjs` to include Settings
**Option 2:** Convert Settings controllers to root-level (move from subfolder)

### Railway Deployment Steps

1. **Push to GitHub:**
   ```bash
   git add .
   git commit -m "Fix: Generate missing Wayfinder action files for deployment"
   git push origin main
   ```

2. **Update Google OAuth Redirect URI:**
   - Go to: https://console.cloud.google.com
   - Project: to-do-list-app-479910
   - Add Railway domain: `https://your-app.up.railway.app/auth/google/callback`

3. **Set Railway Environment Variables:**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-app.up.railway.app
   
   GOOGLE_CLIENT_ID=293725840826-3djstg6cavp759o47j6c47v0n0ovof1l.apps.googleusercontent.com
   GOOGLE_CLIENT_SECRET=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
   GOOGLE_REDIRECT_URI=https://your-app.up.railway.app/auth/google/callback
   
   DB_CONNECTION=mysql
   # Railway will inject MySQL variables automatically
   ```

4. **Deploy:**
   - Railway auto-deploys from GitHub
   - Build command: `npm run build` (already configured)
   - Start command: `php artisan serve --host=0.0.0.0 --port=$PORT`

### Build Process Flow

```
npm run build
    ↓
npm run generate-actions
    ↓
php artisan wayfinder:generate  (generates root-level controllers)
    ↓
node scripts/create-auth-actions.cjs  (adds Auth + appearance manually)
    ↓
vite build  (builds with all files present)
```

### Files Modified

- ✅ `package.json` - Updated build scripts
- ✅ `vite.config.ts` - Disabled wayfinder plugin, added path alias
- ✅ `scripts/create-auth-actions.cjs` - Created action generator script
- ✅ `resources/js/routes/appearance.ts` - Manual route file
- ✅ `resources/js/actions/App/Http/Controllers/Auth/*` - 5 auth controller files

### Files to Add (Settings Controllers)

Create these files manually or update the script:

**`resources/js/actions/App/Http/Controllers/Settings/PasswordController.ts`**
**`resources/js/actions/App/Http/Controllers/Settings/ProfileController.ts`**

Use same pattern as Auth controllers with appropriate routes from `routes/settings.php`.

### Testing Locally

```bash
# Clean build
npm run build

# If Settings error occurs:
# 1. Check routes/settings.php for PasswordController & ProfileController routes
# 2. Add them to scripts/create-auth-actions.cjs following Auth pattern
# 3. Or create files manually in resources/js/actions/App/Http/Controllers/Settings/
```

### Alternative Solution (If script approach fails)

Move controllers to root level:
```bash
# Move Auth controllers to root
mv app/Http/Controllers/Auth/* app/Http/Controllers/
# Move Settings controllers to root  
mv app/Http/Controllers/Settings/* app/Http/Controllers/
# Update namespaces and imports
# Wayfinder will then generate all files correctly
```

---

**Status:** Build script created for Auth controllers. Settings controllers still need to be added to script or moved to root level.

**Created:** December 1, 2025
