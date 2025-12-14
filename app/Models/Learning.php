<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learning extends Model
{
    /** @use HasFactory<\Database\Factories\LearningFactory> */
    use HasFactory;
    // Protection contre l'assignation de masse
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'source_url',
        'topic',
        'last_reviewed_at',
        'next_review_at',
    ];
    
    // Casting des dates pour qu'elles soient manipulées comme des objets Carbon
    protected $casts = [
        'last_reviewed_at' => 'datetime',
        'next_review_at' => 'datetime',
    ];

    // Relation avec l'utilisateur (Sécurité : un apprentissage appartient à un utilisateur)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
