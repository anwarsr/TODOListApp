# Fix Google OAuth Redirect URI Mismatch Error

## Masalah
Error **400: redirect_uri_mismatch** terjadi karena redirect URI yang terdaftar di Google Cloud Console tidak cocok dengan yang digunakan aplikasi Laravel.

**Current State:**
- Google Cloud Console: `http://127.0.0.1:8000` ❌
- Laravel App Needs: `http://127.0.0.1:8000/auth/google/callback` ✓

## Solusi: Update Google Cloud Console (RECOMMENDED)

### Langkah-langkah:

#### 1. Buka Google Cloud Console
- Pergi ke: https://console.cloud.google.com/
- Login dengan akun **anwar.saipul120305@gmail.com**

#### 2. Select Project
- Klik dropdown project di navbar atas
- Pilih project: **"to-do-list-app-479910"**

#### 3. Navigate ke Credentials
- Di sidebar kiri, klik **"APIs & Services"**
- Klik **"Credentials"**

#### 4. Edit OAuth 2.0 Client
- Cari OAuth 2.0 Client ID: `293725840826-3djstg6cavp759o47j6c47v0n0ovof1l.apps.googleusercontent.com`
- Klik icon **pensil (edit)** di sebelah kanan

#### 5. Update Authorized Redirect URIs
- Scroll ke bagian **"Authorized redirect URIs"**
- Klik **"+ ADD URI"**
- Masukkan: `http://127.0.0.1:8000/auth/google/callback`
- Klik **"+ ADD URI"** lagi (optional untuk localhost alias)
- Masukkan: `http://localhost:8000/auth/google/callback`

**Hasil akhir seharusnya:**
```
Authorized redirect URIs:
✓ http://127.0.0.1:8000
✓ http://127.0.0.1:8000/auth/google/callback
✓ http://localhost:8000/auth/google/callback
```

#### 6. Save Changes
- Scroll ke bawah
- Klik **"SAVE"**
- Tunggu beberapa detik hingga muncul notifikasi "Client ID updated"

#### 7. Download Updated Client Secret (Optional)
- Klik icon **download** di sebelah Client ID
- Save file baru untuk backup
- **JANGAN commit file ini ke Git!**

#### 8. Update Laravel .env
Buka `.env` file dan update redirect URI:
```env
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

#### 9. Clear Laravel Config Cache
```powershell
php artisan config:clear
php artisan cache:clear
```

#### 10. Test OAuth Login
- Buka: http://127.0.0.1:8000/login
- Klik tombol **"Sign in with Google"**
- Seharusnya tidak ada error lagi ✓

---

## Alternative: Temporary Fix (NOT RECOMMENDED)

Jika tidak bisa akses Google Cloud Console, bisa pakai redirect URI yang sudah terdaftar:

### .env
```env
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000
```

### Update GoogleAuthController.php
```php
public function redirectToGoogle()
{
    return Socialite::driver('google')
        ->redirectUrl('http://127.0.0.1:8000')
        ->redirect();
}

public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')
            ->redirectUrl('http://127.0.0.1:8000')
            ->user();
        // ... rest of code
    } catch (Exception $e) {
        return redirect('/login')->with('error', 'Failed to login: ' . $e->getMessage());
    }
}
```

**Catatan:** Cara ini tidak standard dan mungkin menyebabkan masalah routing.

---

## Verification Checklist

Setelah fix, pastikan:
- [ ] Bisa klik "Sign in with Google" tanpa error
- [ ] Redirect ke Google OAuth consent screen
- [ ] Bisa pilih akun Google
- [ ] Redirect kembali ke http://127.0.0.1:8000/tasks
- [ ] User ter-login dan bisa akses tasks
- [ ] Database users table ada data google_id dan avatar

---

## Troubleshooting

### Error: "This app hasn't been verified"
**Solusi:** Klik "Advanced" → "Go to to-do-list-app (unsafe)"
(Normal untuk development mode)

### Error: "Access blocked: Authorization Error"
**Solusi:** 
1. Pastikan email anwar.saipul120305@gmail.com ditambahkan sebagai Test User
2. Di Google Cloud Console: APIs & Services → OAuth consent screen → Test users → Add users

### Redirect URI masih error setelah update
**Solusi:**
1. Wait 5-10 menit (Google OAuth cache)
2. Clear browser cache dan cookies
3. Coba incognito/private browsing
4. Verify redirect URI di Google Console sudah benar-benar tersimpan

---

## Production Deployment

Saat deploy ke production (misal: https://todolist.example.com):

1. Tambah production redirect URI di Google Console:
   ```
   https://todolist.example.com/auth/google/callback
   ```

2. Update .env production:
   ```env
   GOOGLE_REDIRECT_URI=https://todolist.example.com/auth/google/callback
   ```

3. Update OAuth consent screen status dari "Testing" ke "Published"

4. Add domain verification di Google Search Console

---

**Created:** December 1, 2025  
**Status:** Pending fix - User needs to update Google Cloud Console
