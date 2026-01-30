<x-app-layout>
  <x-slot name="header">
    <div>
      <h2 class="font-semibold text-xl text-gray-900 leading-tight">Permisos</h2>
      <div class="text-sm text-gray-500 mt-1">Listado solo lectura. Se asignan vía roles.</div>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

      {{-- Búsqueda --}}
      <x-card title="Búsqueda" subtitle="Filtrá permisos por nombre.">
        <form method="GET">
          <x-filterbar>
            <div class="w-full md:w-96">
              <label class="block text-sm text-gray-600 mb-1">Buscar</label>
              <input name="q" value="{{ $q }}"
                     placeholder="Ej: opportunities.view, users.delete"
                     class="w-full bg-white rounded-xl px-3 py-2 ring-1 ring-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-900/20">
            </div>

            <x-primary-button>Buscar</x-primary-button>

            @if($q)
              <a href="{{ route('permissions.index') }}">
                <x-secondary-button type="button">Limpiar</x-secondary-button>
              </a>
            @endif
          </x-filterbar>
        </form>
      </x-card>

      {{-- Listado --}}
      <x-card title="Listado" subtitle="Permisos agrupados por recurso.">
        <x-table>
          <thead class="bg-gray-50">
            <tr>
              <th class="text-left p-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Recurso</th>
              <th class="text-left p-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Acción</th>
              <th class="text-left p-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Permiso</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-100 bg-white">
            @foreach($groups as $resource => $perms)
              @foreach($perms as $perm)
                @php
                  $parts = explode('.', $perm->name, 2);
                @endphp
                <tr class="hover:bg-gray-50/60">
                  <td class="p-3 font-medium text-gray-900">{{ $resource }}</td>
                  <td class="p-3">
                    <x-badge variant="default">{{ $parts[1] ?? '—' }}</x-badge>
                  </td>
                  <td class="p-3 font-mono text-gray-800">{{ $perm->name }}</td>
                </tr>
              @endforeach
            @endforeach
          </tbody>
        </x-table>
      </x-card>

    </div>
  </div>
</x-app-layout>
