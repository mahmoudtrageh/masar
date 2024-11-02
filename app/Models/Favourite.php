<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favourite extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'favouritable_id', 'favouritable_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favouritable()
    {
        return $this->morphTo();
    }
}
