<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'phone',
        'avatar',
        'gender',
        'dob',
        'country',
        'JMBG',
        'email',
        'password',
        'approve_status',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public function themes()
    {
        return $this->hasMany(Theme::class);
    }

    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function followedThemes()
    {
        return $this->belongsToMany(Theme::class, 'theme_user','theme_id', 'user_id' );
    }

    public function votedComments()
    {
        return $this->belongsToMany(Comment::class);
    }

    public function votedReplies()
    {
        return $this->belongsToMany(Reply::class);
    }

    public function blockedThemes()
    {
        return $this->belongsToMany(Theme::class, 'topic_user_block');
    }

    
}
