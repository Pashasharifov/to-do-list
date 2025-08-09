<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'title',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // Listin bir useri olur
    }
    public function tasks()
    {
        return $this->hasMany(Task::class); // Listin choxlu tasklari ola biler
    }
}
