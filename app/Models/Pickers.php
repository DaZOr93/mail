<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pickers extends Model
{
    protected $fillable = ['status'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
