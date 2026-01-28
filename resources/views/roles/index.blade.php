<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between gap-4">
      <div>
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">Roles</h2>
        <div class="text-sm text-gray-500 mt-1">Administrá roles y asignación de permisos.</div>
      </div>

      @can('roles.create')
        <a href="{{ route('roles.create') }}">
          <x-primary-button>Nuevo rol</x-primary-button>
        </a>
      @endcan
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

      @if (session('success'))
        <x-card><x-alert type="success">{{ session('success') }}</x-alert></x-card>
      @endif

      <x-card title="Listado" subtitle="Cantidad de permisos por rol.">
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead class="text-gray-500">
              <tr class="border-b border-gray-100">
                <th class="text-left py-3 pr-4">Rol</th>
                <th class="text-left py-3 pr-4">Permisos</th>
                <th class="text-right py-3">Acciones</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              @foreach($roles as $role)
                <tr>
                  <td class="py-3 pr-4 font-medium text-gray-900">{{ $role->name }}</td>
                  <td class="py-3 pr-4 text-gray-700">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-50 text-gray-700 ring-1 ring-gray-200">
                      {{ $role->permissions_count }}
                    </span>
                  </td>
                  <td class="py-3 text-right">
                    <div class="inline-flex items-center gap-2">
                      @can('roles.update')
                        <a href="{{ route('roles.edit', $role) }}" class="text-gray-900 hover:underline">Editar</a>
                      @endcan

                      @can('roles.delete')
                        @if($role->name !== 'Admin')
                          <form method="POST" action="{{ route('roles.destroy', $role) }}" onsubmit="return confirm('¿Eliminar rol {{ $role->name }}?');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Eliminar</button>
                          </form>
                        @endif
                      @endcan
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </x-card>
    </div>
  </div>
</x-app-layout>
