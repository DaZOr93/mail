<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Folders extends Model
{
    public function messages()
    {
        return $this->hasMany(Letter::class , 'folder_id');
    }

    public function colors()
    {
        return $this->belongsTo(Colors::class , 'folder_id');
    }

}

