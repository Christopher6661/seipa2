<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SessionsController extends Controller
{
    public function create() {
        return view('auth.login');
    }

    public function store() {
        if(auth()->attempt(request(['email', 'password'])) == false) {
            return back()->withErrors([
                'message' => 'El email ó la contraseña son incorrectos, porfavor intentelo de nuevo',
            ]);

        } else {

            if(auth()->user()->role == 'admin') {
                return redirect()->route('admin.index');
            } elseif(auth()->user()->role == 'personal') {
                return redirect()->route('personal.index'); 
            } elseif(auth()->user()->role === 'pescador fisico') {
                return redirect()->route('pescador_fisico.index'); 
            } elseif(auth()->user()->role == 'pescador moral') {
                return redirect()->route('pescador_moral.index'); 
            } elseif(auth()->user()->role == 'acuicultor fisico') {
                return redirect()->route('acuicultor_fisico.index');
            } elseif(auth()->user()->role == 'acuicultor moral') {
                return redirect()->route('acuicultor_moral.index');
            } else {
                return redirect()->to('/');
            }
        } 
    }

    public function destroy() {
        auth()->logout();

        return redirect()->to('/');
    }
}
