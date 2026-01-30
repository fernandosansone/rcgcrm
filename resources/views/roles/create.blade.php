<x-app-layout>
  <x-slot name="header">
    <div>
      <h2 class="font-semibold text-xl text-gray-900 leading-tight">Nuevo rol</h2>
      <div class="text-sm text-gray-500 mt-1">Creá un rol y definí sus permisos.</div>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

      @if (session('success'))
        <x-card>
          <x-alert type="success">{{ session('success') }}</x-alert>
        </x-card>
      @endif

      @if ($errors->any())
        <x-card>
          <x-alert type="error">Revisá los campos marcados.</x-alert>
        </x-card>
      @endif

      <x-card title="Datos del rol" subtitle="Nombre y permisos asociados.">
        <form method="POST" action="{{ route('roles.store') }}">
          @csrf
          @include('roles._form', [
            'permissions' => $permissions,
            'selectedPermissions' => old('permissions', [])
          ])
        </form>
      </x-card>

    </div>
  </div>
</x-app-layout>
