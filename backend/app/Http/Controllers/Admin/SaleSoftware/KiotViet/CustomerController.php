<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use App\Models\Customer;

class CustomerController
{
    public static function saveCustomers($customers)
    {
        foreach ($customers as $customer) {
            try {
                Customer::updateOrCreate(
                    ['kiotviet_id' => $customer->id],
                    ['name' => $customer->name, 'gender' => optional($customer)->gender, 'phone_number' => optional($customer)->contactNumber, 'address' => optional($customer)->address, 'email' => optional($customer)->email, 'code' => optional($customer)->code]
                );
            } catch (QueryException $e) {
                \Log::debug('Cannot save customer: ' . $e->getMessage());
                throw $e;
            }
        }
    }
}
