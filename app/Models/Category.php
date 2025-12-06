<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Category Model
 * 
 * Model untuk tabel categories
 * Dipersiapkan untuk fitur kategorisasi task di masa depan
 * Saat ini belum digunakan dalam aplikasi
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $color
 * @property bool $is_system
 * @property int|null $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'color', 'user_id', 'is_system'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Relasi ke pemilik kategori.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}