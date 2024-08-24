<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function leaves()
    {
        return $this->hasMany(Leave::class, 'employee_id', 'id');
    }

    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class, 'employee_id', 'id');
    }

    public function getFormattedBirthDateAttribute()
    {
        return Carbon::parse($this->birth_date)->format('d-M-Y');
    }

    public function getFormattedJoinDateAttribute()
    {
        return Carbon::parse($this->join_date)->format('d-M-Y');
    }

    public static function codeNumber()
    {
        $employeeNumbers = Employee::pluck('employee_number');

        if ($employeeNumbers->isEmpty()) {
            return 'IP';
        }

        $codes = [];

        foreach ($employeeNumbers as $employeeNumber) {
            $code = substr($employeeNumber, 0, 2);
            $codes[] = $code;
        }

        $frequency = collect($codes)->countBy();
        $mostFrequencyCode = $frequency->sortDesc()->keys()->first();

        return $mostFrequencyCode;
    }

    public static function createEmployeeNumber($year = null)
    {
        $employeeNumbers = Employee::pluck('employee_number');
        $yearJoin = $year ?: date('y');

        if ($employeeNumbers->isEmpty()) {
            $newNumber = self::codeNumber() . $yearJoin . '001';
            return $newNumber;
        }

        $numbers = [];

        foreach ($employeeNumbers as $employeeNumber) {
            $number = substr($employeeNumber, 4);
            $numbers[] = $number;
        }

        $lastNumber = collect($numbers)->sort()->last();

        $numberDigit = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        $newNumber = self::codeNumber() . $yearJoin . $numberDigit;

        return $newNumber;
    }
}
