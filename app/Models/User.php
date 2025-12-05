<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'admin_id',
        'company_id'
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

    public function shortUrlsByAdmin() {
        return $this->hasMany(ShortUrl::class, 'admin_id', 'id')->whereNull('member_id');
    }

    public function shortUrlsByMember() {
        return $this->hasMany(ShortUrl::class, 'member_id', 'id');
    }

    public function company() {
        return $this->belongsTo(User::class, 'company_id', 'id');
    }

    public function shortUrlByCompany() {
        return $this->hasMany(ShortUrl::class, 'company_id');
    }

    public function usersByCompany() {
        return $this->hasMany(User::class, 'company_id');
    }

}
