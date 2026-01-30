<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Permission::class);

        $q = trim((string) $request->query('q', ''));

        $permissions = Permission::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->orderBy('name')
            ->get();

        $groups = $permissions
            ->groupBy(fn($perm) => explode('.', $perm->name, 2)[0] ?? 'other')
            ->sortKeys();

        return view('permissions.index', compact('groups', 'q'));
    }
}
