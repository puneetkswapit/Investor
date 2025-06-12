<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PartnerProperty extends Model
{
   protected $guarded = [];

   public function User()
   {
      return $this->belongsTo(User::class);
   }
}
