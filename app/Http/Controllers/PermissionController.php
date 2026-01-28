<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Permission::class);

        $permissions = Permission::query()
            ->orderBy('name')
            ->get();

        return view('permissions.index', compact('permissions'));
    }
}
