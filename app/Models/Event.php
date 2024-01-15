<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'event_place',
        'event_start_date',
        'event_start_time',
        'event_desc',
        'user_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}