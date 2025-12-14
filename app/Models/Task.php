<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'note_id',
        'due_date',
        'priority',
        'is_completed',
    ];
    
    // Conversion des dates et des booléens
    protected $casts = [
        'due_date' => 'datetime',
        'is_completed' => 'boolean',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
   
}
