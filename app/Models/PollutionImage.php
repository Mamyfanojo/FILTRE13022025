<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollutionImage extends Model
{
    protected $fillable = ['pollution_id', 'image_path'];

    public function pollution()
    {
        return $this->belongsTo(Pollution::class);
    }
}
