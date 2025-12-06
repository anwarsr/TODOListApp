<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use App\Models\Category;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $password
 * @property string|null $role
 * @property string|null $google_id
 * @property string|null $avatar
 * @property \Carbon\Carbon|null $email_verified_at
 * @property string|null $remember_token
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',        // user role (user/admin)
        'google_id',    // Google OAuth ID
        'avatar',       // Google profile picture URL
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted(): void
    {
        static::created(function (User $user) {
            $user->ensureDefaultCategories();
        });
    }

    /**
     * Get the tasks for the user.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Pastikan kategori bawaan tersedia untuk user baru.
     */
    public function ensureDefaultCategories(): void
    {
        $defaults = [
            ['name' => 'Personal', 'description' => 'Personal tasks and reminders', 'color' => '#16a34a'],
            ['name' => 'Work', 'description' => 'Work and professional tasks', 'color' => '#2563eb'],
            ['name' => 'Study', 'description' => 'Study plans and assignments', 'color' => '#8b5cf6'],
        ];

        foreach ($defaults as $item) {
            $category = Category::updateOrCreate(
                [
                    'user_id' => $this->id,
                    'name' => $item['name'],
                ],
                [
                    'description' => $item['description'],
                    'color' => $item['color'],
                    'is_system' => false,
                ]
            );

            // Pastikan tidak ada duplikat dengan nama bawaan lain.
            Category::where('user_id', $this->id)
                ->where('name', $item['name'])
                ->where('id', '!=', $category->id)
                ->delete();
        }
    }
}
