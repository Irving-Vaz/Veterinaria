<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpedientesController extends Controller
{
    public function index()
    {
        return view('modules.admin.expedientes.index');
    }
}
