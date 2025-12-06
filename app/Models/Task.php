<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subtask;

/**
 * Task Model
 * 
 * Model untuk tabel tasks
 * Merepresentasikan task yang dibuat oleh user
 * 
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property \Carbon\Carbon|null $deadline
 * @property int|null $category_id
 * @property string $status - pending atau completed
 * @property string $priority - low, medium, atau high
 * @property bool $is_important
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Task extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara mass assignment
     * 
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'deadline',
        'status',
        'priority',
        'is_important'
    ];

    /**
     * Casting tipe data kolom
     * 
     * @var array
     */
    protected $casts = [
        'deadline' => 'datetime',
        'is_important' => 'boolean',
    ];

    /**
     * Relasi ke User (pemilik task)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke kategori (opsional).
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function subtasks()
    {
        return $this->hasMany(Subtask::class)->orderBy('created_at');
    }
}