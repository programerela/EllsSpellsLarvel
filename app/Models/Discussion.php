<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Theme;
use App\Models\Commment;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id', 'theme_id'];

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
