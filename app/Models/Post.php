<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Theme;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content'];

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }
}
