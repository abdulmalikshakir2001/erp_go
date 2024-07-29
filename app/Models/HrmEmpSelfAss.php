<?php

namespace App\Models;
use App\Models\Branch;
use App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrmEmpSelfAss extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'hrm_emp_self_ass';

    // Specify the fillable fields
    protected $fillable = [
        'branch',
        'employee',
        'rating',
        'appraisal_date',
    ];
    public function branches()
    {
        return $this->belongsTo(Branch::class, 'branch');
    }

    public function employees()
    {
        return $this->belongsTo(Employee::class, 'employee');
    }
}
