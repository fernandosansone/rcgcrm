<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between gap-4">
      <div>
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">Editar rol</h2>
        <div class="text-sm text-gray-500 mt-1">ID #{{ $role->id }} · Ajustá nombre y permisos asignados.</div>
      </div>

      <a href="{{ route('roles.index') }}">
        <x-secondary-button type="button">Cancelar</x-secondary-button>
      </a>
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
          <x-alert type="error">{{ $errors->first() }}</x-alert>
        </x-card>
      @endif

      <x-card title="Datos del rol" subtitle="Nombre del rol y permisos asignados.">
        <form method="POST" action="{{ route('roles.update', $role) }}">
          @csrf
          @method('PUT')

          @include('roles._form', [
            'role' => $role,
            'permissions' => $permissions,
            'selectedPermissions' => old('permissions', $role->permissions->pluck('name')->toArray())
          ])
        </form>
      </x-card>

    </div>
  </div>
</x-app-layout>
