<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sitrep extends Model
{
    use HasFactory;

    protected $fillable = [
        'sitrep_sar', 'mrcc_madagascar', 'event', 'position', 'situation', 
        'number_of_persons', 'assistance_required', 'coordinating_rcc', 
        'initial_action_taken', 'chronology', 'additional_information'
    ];
}

