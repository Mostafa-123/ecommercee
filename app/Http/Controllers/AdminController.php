<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function categories(){
        return view('admin.categories.index');
    }
}
