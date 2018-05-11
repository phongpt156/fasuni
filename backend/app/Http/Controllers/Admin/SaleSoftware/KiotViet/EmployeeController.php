<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\PackageWrapper\DateTime;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public static function saveEmployees(Array $employees)
    {
        foreach ($employees as $employee) {
            try {
                Employee::updateOrCreate(
                    ['kiotviet_id' => $employee->id],
                    ['username' => $employee->userName, 'name' => $employee->givenName, 'address' => optional($employee)->adddress, 'phone_number' => optional($employee)->mobilePhone, 'email' => optional($employee)->email, 'birthdate' => DateTime::create(optional($employee)->birthDate)]
                );
            } catch (QueryException $e) {
                \Log::debug('Cannot save employee: ' . $e->getMessage());
                throw $e;
            }
        }
    }
}
