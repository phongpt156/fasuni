<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function render(Request $request) {
        \Log::debug($request->all());
    }
}
