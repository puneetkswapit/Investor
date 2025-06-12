<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPersonalReport extends Model
{
      protected $guarded = [];
       public function user()
    {
        return $this->belongsTo(User::class); // Foreign key is assumed to be 'user_id'
    }
}
