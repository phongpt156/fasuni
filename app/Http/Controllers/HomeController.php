<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index() {
        return file_get_contents(resource_path('web/dist/index.html'));
    }

    public function admin()
    {
        return file_get_contents(resource_path('admin/dist/index.html'));
    }
}
