<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    protected $fillable = [
        's_url_code',
        'long_url',
        'hits',
        'status',
        'member_id',
        'admin_id',
        'company_id',
    ];

    public function member() {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }

    public function admin() {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }
}
