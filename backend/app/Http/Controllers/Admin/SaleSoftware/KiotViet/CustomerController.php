<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Models\Customer;

class CustomerController extends Controller
{
    public static function saveCustomers(Array $customers)
    {
        foreach ($customers as $customer) {
            try {
                Customer::updateOrCreate(
                    ['kiotviet_id' => $customer->id],
                    ['name' => $customer->name, 'gender' => optional($customer)->gender, 'phone_number' => optional($customer)->contactNumber, 'address' => optional($customer)->address, 'email' => optional($customer)->email, 'code' => optional($customer)->code]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save customer: ' . $e->getMessage());
                throw $e;
            }
        }
    }
}
