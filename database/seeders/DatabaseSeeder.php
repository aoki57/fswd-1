<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\User;
use Illuminate\Database\Schema\ForeignKeyDefinition;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        Leave::truncate();
        LeaveBalance::truncate();
        Employee::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin',
            'is_admin' => true
        ]);

        $employeeNumbers = ['IP06001', 'IP06002', 'IP06003', 'IP06004', 'IP06005', 'IP06006', 'IP06007', 'IP06008', 'IP06009', 'IP06010'];
        $employeeNames = ['Agus', 'Amin', 'Yusuf', 'Alyssa', 'Maulana', 'Agfika', 'James', 'Octavanus', 'Nugroho', 'Raisa'];
        $employeeAdresses = [
            'Jln Gaja Mada no 12, Surabaya',
            'Jln Imam Bonjol no 11, Mojokerto',
            'Jln A Yani Raya 15 No 14 Malang',
            'Jln Bungur Sari V no 166, Bandung',
            'Jln Candi Agung, No 78 Gg 5, Jakarta',
            'Jln Nangka, Jakarta Timur',
            'Jln Merpati, 8 Surabaya',
            'Jln A Yani 17, B 08 Sidoarjo',
            'Jln Duren tiga 167, Jakarta Selatan',
            'Jln Kelapa Sawit, Jakarta Selatan'
        ];
        $birthDates = ['1980-01-11', '1977-09-03', '1973-08-09', '1983-03-18', '1978-11-10', '1979-02-07', '1989-05-18', '1985-04-14', '1984-01-01', '1990-12-17'];
        $joinDates = ['2005-08-07', '2005-08-07', '2006-08-07', '2006-09-06', '2006-09-10', '2007-01-02', '2007-04-04', '2007-05-19', '2008-01-16', '2008-08-16'];

        foreach ($employeeNumbers as $index => $employeeNumber) {
            Employee::create([
                'employee_number' => $employeeNumber,
                'name' => $employeeNames[$index],
                'address' => $employeeAdresses[$index],
                'birth_date' => $birthDates[$index],
                'join_date' => $joinDates[$index]
            ]);
        }

        $leaves = [
            ['employee_id' => 1, 'leave_date' => '2020-08-02', 'leave_duration' => 2, 'leave_information' => 'Acara Keluarga'],
            ['employee_id' => 1, 'leave_date' => '2020-08-18', 'leave_duration' => 2, 'leave_information' => 'Anak Sakit'],
            ['employee_id' => 6, 'leave_date' => '2020-08-19', 'leave_duration' => 1, 'leave_information' => 'Nenek Sakit'],
            ['employee_id' => 7, 'leave_date' => '2020-08-23', 'leave_duration' => 1, 'leave_information' => 'Sakit'],
            ['employee_id' => 4, 'leave_date' => '2020-08-29', 'leave_duration' => 5, 'leave_information' => 'Menikah'],
            ['employee_id' => 3, 'leave_date' => '2020-08-30', 'leave_duration' => 2, 'leave_information' => 'Acara Keluarga'],
        ];

        foreach ($leaves as $leave) {
            Leave::create($leave);
        }

        $leaveIds = Leave::pluck('id');

        foreach ($leaveIds as $leaveId) {

            $leave = Leave::findOrFail($leaveId);

            $year = date('Y', strtotime($leave->leave_date));

            $leaveBalance = LeaveBalance::firstOrCreate(
                [
                    'employee_id' => $leave->employee_id,
                ],
                [
                    'year' => $year,
                    'leave_quota' => 12,
                    'leave_taken' => 0
                ]
            );

            $leaveBalance->leave_taken += $leave->leave_duration;
            $leaveBalance->leave_quota -= $leave->leave_duration;
            $leaveBalance->save();
        }
    }
}
