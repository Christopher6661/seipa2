<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PescadorFController extends Controller
{
    public function index() {
        return view('pescador_fisico.index');
    }
}
