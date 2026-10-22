<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ManualController extends Controller
{
    /**
     * Muestra el Manual de Usuario interactivo del sistema.
     */
    public function index(): View
    {
        return view('manual.index');
    }
}
