<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
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
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

      @if (session('success'))
        <x-card>
          <div class="p-3 bg-green-50 border border-green-100 rounded-xl text-green-800">
            {{ session('success') }}
          </div>
        </x-card>
      @endif

      {{-- Filtros (aunque sea informativo, mantiene coherencia) --}}
      <x-card title="Filtros" subtitle="Listado completo de roles del sistema.">
        <x-filterbar>
          <div class="text-sm text-gray-600">
            Total de roles: <span class="font-medium text-gray-900">{{ $roles->count() }}</span>
          </div>
        </x-filterbar>
      </x-card>

      {{-- Listado --}}
      <x-card title="Listado" subtitle="Mostrando {{ $roles->count() }} rol(es).">
        <x-table>
          <thead class="bg-gray-50">
            <tr>
              <th class="text-left p-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Rol</th>
              <th class="text-left p-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Permisos</th>
              <th class="text-right p-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-100 bg-white">
            @foreach($roles as $role)
              <tr class="hover:bg-gray-50/60">
                <td class="p-3 font-medium text-gray-900">
                  {{ $role->name }}
                </td>

                <td class="p-3 text-gray-700">
                  <x-badge variant="info">{{ $role->permissions_count }}</x-badge>
                </td>

                <td class="p-3 text-right whitespace-nowrap">
                  <div class="inline-flex items-center gap-2">
                    @can('roles.update')
                      <a href="{{ route('roles.edit', $role) }}"
                         class="text-sm font-medium text-gray-900 underline underline-offset-4">
                        Editar
                      </a>
                    @endcan

                    @can('roles.delete')
                      @if($role->name !== 'Admin')
                        <form method="POST"
                              action="{{ route('roles.destroy', $role) }}"
                              onsubmit="return confirm('¿Eliminar rol {{ $role->name }}?');">
                          @csrf
                          @method('DELETE')
                          <button class="text-sm font-medium text-red-600 underline underline-offset-4">
                            Eliminar
                          </button>
                        </form>
                      @endif
                    @endcan
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </x-table>
      </x-card>

    </div>
  </div>
</x-app-layout>
