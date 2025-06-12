<?php

namespace App\Helpers;
use App\Models\LeadAttachment;

class LeadHelper
{
    public static function get_attachments($id)
    {
     $images = LeadAttachment::where('lead_id',$id)->get();
     return $images;
    }
}