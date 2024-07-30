<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    protected $table = 'travels';

    protected $fillable = [
        'employee_id',
        'start_date',
        'end_date',
        'purpose_of_visit',
        'country',    // Used for international trips
        'state',             // Used for local trips
        'origin',            // Used for local trips
        'destination',       // Used for local trips
        'description',
        'created_by',
    ];

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'employee_id');
    }
}

