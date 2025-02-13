<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avurnav extends Model
{
    use HasFactory;

    protected $fillable = [
        'avurnav_local',
        'ile',
        'vous_signale',
        'position',
        'navire',
        'pob',
        'type',
        'caracteristiques',
        'zone',
        'derniere_communication',
        'contacts',
    ];
}