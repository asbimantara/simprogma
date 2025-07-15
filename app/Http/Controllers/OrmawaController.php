<?php

namespace App\Http\Controllers;

use App\Models\User;

class OrmawaController extends Controller
{
    public function index()
    {
        $ormawas = User::where('role', 'user')->get();
        return view('ormawa.index', compact('ormawas'));
    }
} 