<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between gap-4">
      <div>
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">Usuarios</h2>
        <div class="text-sm text-gray-500 mt-1">Administración de cuentas y roles.</div>
      </div>

      @can('users.create')
        <a href="{{ route('users.create') }}"><x-primary-button>Nuevo usuario</x-primary-button></a>
      @endcan
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

      @if (session('success'))
        <x-card><x-alert type="success">{{ session('success') }}</x-alert></x-card>
      @endif

      <x-card title="Filtros" subtitle="Buscá por nombre o email.">
        <form method="GET">
          <x-filterbar>
            <div class="w-full md:w-[28rem]">
              <label class="block text-sm text-gray-600 mb-1">Buscar</label>
              <input name="q" value="{{ $q }}" placeholder="Ej: Juan, admin@..."
                     class="w-full bg-white rounded-xl px-3 py-2 ring-1 ring-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-900/20">
            </div>
            <x-primary-button>Filtrar</x-primary-button>

            @if($q)
              <a href="{{ route('users.index') }}"><x-secondary-button type="button">Limpiar</x-secondary-button></a>
            @endif
          </x-filterbar>
        </form>
      </x-card>

      <x-card title="Listado" subtitle="Mostrando {{ $users->total() }} usuario(s).">
        <x-table>
          <thead class="bg-gray-50">
            <tr>
              <th class="text-left p-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre</th>
              <th class="text-left p-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
              <th class="text-left p-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Roles</th>
              <th class="text-right p-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 bg-white">
            @foreach($users as $u)
              <tr class="hover:bg-gray-50/60">
                <td class="p-3 font-medium text-gray-900">{{ $u->name }}</td>
                <td class="p-3 text-gray-800">{{ $u->email }}</td>
                <td class="p-3">
                  <div class="flex flex-wrap gap-2">
                    @forelse($u->roles as $r)
                      <x-badge variant="info">{{ $r->name }}</x-badge>
                    @empty
                      <x-badge variant="default">sin rol</x-badge>
                    @endforelse
                  </div>
                </td>
                <td class="p-3 text-right whitespace-nowrap">
                  <div class="inline-flex items-center gap-2">
                    @can('users.update')
                      <a href="{{ route('users.edit', $u) }}" class="text-sm font-medium text-gray-900 underline underline-offset-4">Editar</a>
                    @endcan

                    @can('users.delete')
                      <form method="POST" action="{{ route('users.destroy', $u) }}" onsubmit="return confirm('¿Eliminar usuario?');">
                        @csrf
                        @method('DELETE')
                        <button class="text-sm font-medium text-red-600 underline underline-offset-4">Eliminar</button>
                      </form>
                    @endcan
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </x-table>

        <div class="mt-4">{{ $users->links() }}</div>
      </x-card>

    </div>
  </div>
</x-app-layout>
