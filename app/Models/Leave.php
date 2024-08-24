<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['employee'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function getFormattedLeaveDateAttribute()
    {
        return Carbon::parse($this->leave_date)->format('d-M-Y');
    }
}
