# GenZtask - TODO List Application 📝

![Laravel](https://img.shields.io/badge/Laravel-10.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue?style=flat-square&logo=php)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

Aplikasi TODO List modern dengan desain glass morphism yang elegan. Dibangun menggunakan Laravel 10, aplikasi ini menyediakan fitur lengkap untuk manajemen task dengan sistem autentikasi dan panel admin.

## ✨ Fitur Utama

### 🔐 Autentikasi
- **Register** - Registrasi user baru dengan validasi lengkap
- **Login** - Login user dengan email dan password
- **Logout** - Logout user dengan aman
- **Profile Management** - Edit nama, email, dan password
- **Delete Account** - Hapus akun beserta semua data

### 📋 Manajemen Task (CRUD Lengkap)
- **Create Task** - Buat task baru dengan:
  - Judul (wajib)
  - Deskripsi (opsional)
  - Deadline (opsional)
  - Priority: Low, Medium, High
  
- **Read Tasks** - Lihat semua task dengan fitur:
  - Filter berdasarkan status (Pending/Completed)
  - Filter berdasarkan tanggal (Today, Tomorrow, This Week, Overdue, dll)
  - Sorting berdasarkan Deadline, Priority, atau Created Date
  - Pencarian task berdasarkan title dan description
  
- **Update Task** - Edit task yang sudah ada
  
- **Delete Task** - Hapus task dengan konfirmasi
  
- **Toggle Status** - Ubah status task (Pending ↔ Completed) dengan satu klik

### 👨‍💼 Admin Panel
- **Admin Login** - Login terpisah untuk admin
  - Username: `admin`
  - Password: `admin`
- **User Management** - Lihat, edit, dan hapus user
- **Dashboard** - Lihat daftar semua user dengan pagination

### 🎨 UI/UX Features
- **Glass Morphism Design** - Desain modern dengan efek kaca
- **Smooth Animations** - Animasi halus di setiap interaksi
- **Responsive Layout** - Tampilan optimal di berbagai ukuran layar
- **Color-coded Priority** - Warna berbeda untuk setiap level prioritas
- **Overdue Indicator** - Penanda visual untuk task yang terlambat
- **Success/Error Messages** - Notifikasi yang jelas untuk setiap aksi

## 🛠️ Teknologi yang Digunakan

- **Backend:** Laravel 10
- **Frontend:** Blade Templates + Tailwind CSS
- **Database:** MySQL
- **Authentication:** Laravel Auth
- **Icons:** Font Awesome 6.5
- **Styling:** Custom CSS dengan Glass Morphism

## 📦 Instalasi

### Persyaratan Sistem
- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js & NPM (untuk Tailwind CSS)

### Langkah-langkah Instalasi

1. **Clone Repository**
```bash
git clone <repository-url>
cd TODOListApp
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database**

Edit file `.env` dan sesuaikan dengan konfigurasi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todolist_db
DB_USERNAME=root
DB_PASSWORD=
```

5. **Migrasi Database & Seeding**
```bash
php artisan migrate
php artisan db:seed
```

6. **Compile Assets**
```bash
npm run dev
# Atau untuk production:
npm run build
```

7. **Jalankan Aplikasi**
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 👤 Kredensial Testing

### User Testing
Terdapat 3 user testing yang sudah disiapkan:

**User 1:**
- Email: `test@example.com`
- Password: `password`

**User 2:**
- Email: `demo@example.com`
- Password: `password`

**User 3:**
- Email: `john@example.com`
- Password: `password`

### Admin
- Username: `admin`
- Password: `admin`
- URL: `http://localhost:8000/admin/login`

## 📁 Struktur Project

```
TODOListApp/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── TaskController.php      # CRUD Task
│   │   │   ├── AuthController.php      # Autentikasi User
│   │   │   └── AdminController.php     # Admin Panel
│   │   └── Middleware/
│   │       └── AdminMiddleware.php     # Proteksi Route Admin
│   ├── Models/
│   │   ├── Task.php                    # Model Task
│   │   ├── User.php                    # Model User
│   │   └── Category.php                # Model Category (future)
│   └── Policies/
│       └── TaskPolicy.php              # Authorization Policy
├── database/
│   ├── migrations/                     # Database Migrations
│   └── seeders/
│       ├── DatabaseSeeder.php          # Seeder Utama
│       └── CategorySeeder.php          # Seeder Category
├── resources/
│   ├── views/
│   │   ├── auth/                       # Views Autentikasi
│   │   ├── tasks/                      # Views Task
│   │   ├── admin/                      # Views Admin
│   │   ├── profile/                    # Views Profile
│   │   └── layouts/
│   │       └── app.blade.php           # Main Layout
│   └── css/
│       └── animations.css              # Custom Animations
├── routes/
│   └── web.php                         # Route Definitions
└── public/
    └── css/
        └── animations.css              # CSS Animations
```

## 🎯 Fitur Unggulan

### 1. Filter & Pencarian Canggih
- Filter berdasarkan status task
- Filter berdasarkan rentang tanggal
- Sorting multi-kolom
- Full-text search pada title dan description

### 2. Sistem Otorisasi
- Task Policy memastikan user hanya bisa mengakses task miliknya
- Admin middleware melindungi route admin
- Validasi input di frontend dan backend

### 3. User Experience
- Confirmation modal sebelum delete
- Auto-hide success messages
- Loading states untuk aksi async
- Keyboard shortcuts (ESC untuk close modal)

### 4. Kode Berkualitas
- **Dokumentasi Lengkap** - Setiap class dan method memiliki PHPDoc
- **Struktur Modular** - Separation of concerns yang jelas
- **Clean Code** - Mengikuti Laravel best practices
- **Error Handling** - Penanganan error yang komprehensif

## 📊 Database Schema

### Tabel: users
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary Key |
| name | varchar | Nama user |
| email | varchar | Email (unique) |
| password | varchar | Password (hashed) |
| created_at | timestamp | Waktu pembuatan |
| updated_at | timestamp | Waktu update |

### Tabel: tasks
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary Key |
| user_id | bigint | Foreign Key ke users |
| title | varchar | Judul task |
| description | text | Deskripsi detail |
| deadline | datetime | Batas waktu |
| status | enum | pending/completed |
| priority | enum | low/medium/high |
| created_at | timestamp | Waktu pembuatan |
| updated_at | timestamp | Waktu update |

### Tabel: categories (Prepared for future)
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary Key |
| name | varchar | Nama kategori |
| color | varchar | Warna kategori |
| created_at | timestamp | Waktu pembuatan |
| updated_at | timestamp | Waktu update |

## 🔒 Keamanan

- ✅ Password hashing menggunakan bcrypt
- ✅ CSRF Protection di semua form
- ✅ SQL Injection protection via Eloquent ORM
- ✅ XSS Protection via Blade templating
- ✅ Authorization via Policies dan Middleware
- ✅ Input validation di frontend dan backend

## 🎨 Customization

### Mengubah Warna Tema
Edit file `resources/views/layouts/app.blade.php` dan ubah gradient background:
```css
background: linear-gradient(120deg, #f5f7fa 0%, #c3cfe2 100%);
```

### Menambah Animasi
Tambahkan animasi baru di `public/css/animations.css`

## 🐛 Troubleshooting

### Error: "Class not found"
```bash
composer dump-autoload
```

### Error: "SQLSTATE[HY000] [1045]"
Periksa konfigurasi database di file `.env`

### Assets tidak muncul
```bash
npm run build
php artisan optimize:clear
```

## 📝 To-Do Features (Future Enhancement)

- [ ] Implementasi fitur Categories
- [ ] Export tasks ke PDF/Excel
- [ ] Task sharing antar user
- [ ] Email notifications untuk deadline
- [ ] Dark mode toggle
- [ ] Mobile app version
- [ ] Task attachments
- [ ] Task comments
- [ ] Recurring tasks
- [ ] Task templates

## 👥 Kontributor

- **Developer:** [Nama Anda]
- **Mata Kuliah:** Praktikum Pemrograman 2
- **Institusi:** [Nama Universitas]

## 📄 License

Project ini dibuat untuk keperluan akademik.

## 🙏 Acknowledgments

- Laravel Framework
- Tailwind CSS
- Font Awesome Icons
- Glass Morphism Design Inspiration

---

⭐ **Jika project ini membantu, jangan lupa beri star!** ⭐

**GenZtask** - Organize your tasks, organize your life! 🚀
