<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Models\Employee;
use App\PackageWrapper\DateTime;

class EmployeeController extends Controller
{
    public static function saveEmployees(Array $employees)
    {
        foreach ($employees as $employee) {
            self::saveEmployee($employee);
        }
    }

    public static function saveEmployee(Object $employee)
    {
        $birthday = null;

        if (isset($employee->birthDate)) {
            $birthday = new \DateTime($employee->birthDate);
        }

        try {
            Employee::updateOrCreate(
                ['kiotviet_id' => $employee->id],
                ['username' => $employee->userName, 'name' => $employee->givenName, 'address' => optional($employee)->adddress, 'phone_number' => optional($employee)->mobilePhone, 'email' => optional($employee)->email, 'birthday' => $birthday]
            );
        } catch (QueryException $e) {
            \Log::error('Cannot save employee: ' . $e->getMessage());
            throw $e;
        }
    }
}
