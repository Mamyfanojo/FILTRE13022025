<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['flag', 'vessel_name', 'registered_owner', 'call_sign', 'mmsi', 'imo', 'ship_type', 'destination', 'eta', 'navigation_status', 'latitude', 'longitude', 'age', 'time_of_fix'];

    public function setTimeOfFixAttribute($value)
{
    $this->attributes['time_of_fix'] = date('Y-m-d H:i:s', strtotime($value));
}

}

