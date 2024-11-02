<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    //

    use HasFactory;
    protected $fillable = [
        'user_id',
        'url_id',
        'category_id',
        'rate',
        'category_duration',
        'url_duration',
        'review',
        'status',
        'order',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(related: Category::class);
    }

    public function url()
    {
        return $this->belongsTo(Url::class);
    }
}
