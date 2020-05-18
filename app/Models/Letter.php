<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $fillable = ['seen'];

    public function attachments()
    {
        return $this->hasMany(Attachments::class);
    }

}
