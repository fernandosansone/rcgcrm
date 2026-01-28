<x-app-layout>
  <x-slot name="header">
    <div>
      <h2 class="font-semibold text-xl text-gray-900 leading-tight">Permisos</h2>
      <div class="text-sm text-gray-500 mt-1">Listado (solo lectura). Los permisos se administran por seeder.</div>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
      <x-card title="Listado de permisos" subtitle="Usá estos nombres en policies, gates y @can().">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
          @foreach($permissions as $perm)
            <div class="rounded-xl ring-1 ring-gray-100 px-3 py-2 text-sm text-gray-800">
              {{ $perm->name }}
            </div>
          @endforeach
        </div>
      </x-card>
    </div>
  </div>
</x-app-layout>
