<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Models\Branch;

class BranchController extends Controller
{
    public static function saveBranches(Array $branches = [])
    {
        foreach ($branches as $branch) {
            try {
                Branch::updateOrCreate(
                    ['kiotviet_id' => $branch->id],
                    ['name' => $branch->branchName, 'phone_number' => optional($branch)->contactNumber, 'email' => optional($branch)->email, 'address' => optional($branch)->address]
                );
            } catch (QueryException $e) {
                \Log::debug('Cannot save branch: ' . $e->getMessage());
                throw $e;
            }
        }
    }
}
