<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AcuicultorMController extends Controller
{
    public function index() {
        return view('acuicultor_moral.index');
    }
}
