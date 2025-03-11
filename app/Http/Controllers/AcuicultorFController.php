<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AcuicultorFController extends Controller
{
    public function index() {
        return view('acuicultor_fisico.index');
    }
}
