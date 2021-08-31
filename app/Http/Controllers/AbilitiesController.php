<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbilitiesController extends Controller
{
    public function index()
    {
        $roles = auth()->user()->roles()->get()->pluck('title');
        $permissions = auth()->user()->roles()->with('permissions')->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('title')
            ->toArray();

        return response()->json(['roles' => $roles, 'permissions' => $permissions]);
    }
}
