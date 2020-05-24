<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colors extends Model
{
  public function folders()
  {
      return $this->hasMany(Folders::class , 'color_id');
  }
}