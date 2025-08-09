<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'list_id',
        'title',
        'is_done',
        'created_at',
    ];

    public function list()
    {
        return $this->belongsTo(Lists::class);
    }
}
