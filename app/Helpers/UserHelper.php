<?php

namespace App\Helpers;
use App\Models\InvestorProperty;
use App\Models\PartnerProperty;
use App\Models\Property;
use App\Models\User;

class UserHelper
{
    public static function investor_user_property($user_id)
    {
        $properties = InvestorProperty::where('user_id', $user_id)
            ->where('status', '1')
            ->get();

        $propid = [];
        $data = [];

        if ($properties->isNotEmpty()) {
            foreach ($properties as $property) {
                $propid[] = $property->property_id;
            }
            $data = Property::whereIn('property_id', $propid)
                ->where('status', '1')
                ->get();
        }
        return $data;
    }


    public static function partner_user_property($user_id)
    {
        $properties = PartnerProperty::where('user_id', $user_id)->where('status', '1')->get();
        $propid = [];
        $data = [];
        if ($properties->isNotEmpty()) {
            foreach ($properties as $property) {
                $propid[] = $property->property_id;
            }
            $data = Property::whereIn('property_id', $propid)
                ->where('status', '1')
                ->get();
        }
        return $data;
    }

    public static function user_property($user_id)
    {
        $properties = User::with([
            'investorProperties' => function ($query) {
                $query->select('user_id', 'property_id');
            },
            'partnerProperties' => function ($query) {
                $query->select('user_id', 'property_id');
            }
        ])->find($user_id);
        $propid = [];
        $data = [];
        if (!empty($properties)) {
            foreach ($properties->investorProperties as $property) {
                $propid[] = $property->property_id;
            }
            foreach ($properties->partnerProperties as $property) {
                $propid[] = $property->property_id;
            }
            $data = Property::whereIn('property_id', $propid)
                ->where('status', '1')
                ->get();
        }
        return $data;

    }
}
