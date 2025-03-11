<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PescadorMController extends Controller
{
    public function index() {
        return view('pescador_moral.index');
    }
}
