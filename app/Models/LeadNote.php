<?php

namespace App\Models;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Model;

class LeadNote extends Model
{
    protected $guarded = [];
    public function lead()
    {
        $this->belongsTo(Lead::class);
    }
}
