<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LeadAttachment;
use App\Models\LeadNote;
class Lead extends Model
{
    protected $guarded = [];
    // Lead.php
    public function attachments()
    {
        return $this->hasMany(LeadAttachment::class);
    }
    public function lead_note()
    {
        return $this->hasMany(LeadNote::class)
            ->where('is_delete', 0)
            ->orderBy('id', 'desc');
    }

}
