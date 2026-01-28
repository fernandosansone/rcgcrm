@csrf

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
  <div class="sm:col-span-2">
    <x-input-label for="name" value="Nombre del rol" />
    <input id="name" name="name" type="text"
      value="{{ old('name', $role->name ?? '') }}"
      class="mt-1 w-full bg-white ring-1 ring-gray-200 focus:ring-2 focus:ring-gray-900/20 rounded-xl"
      required>
    <x-input-error class="mt-2" :messages="$errors->get('name')" />
  </div>

  <div class="sm:col-span-2">
    <div class="flex items-center justify-between">
      <div>
        <div class="text-sm font-semibold text-gray-900">Permisos</div>
        <div class="text-xs text-gray-500">Seleccioná qué puede hacer este rol.</div>
      </div>
      <div class="text-xs text-gray-500">
        {{ count($permissions) }} permisos
      </div>
    </div>

    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-2">
      @foreach($permissions as $perm)
        <label class="flex items-center gap-2 rounded-xl ring-1 ring-gray-100 px-3 py-2 hover:bg-gray-50">
          <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
            class="rounded"
            @checked(in_array($perm->name, old('permissions', $selectedPermissions ?? [])))>
          <span class="text-sm text-gray-800">{{ $perm->name }}</span>
        </label>
      @endforeach
    </div>

    <x-input-error class="mt-2" :messages="$errors->get('permissions')" />
  </div>
</div>

<div class="mt-5 flex items-center justify-end gap-2">
  <a href="{{ route('roles.index') }}">
    <x-secondary-button type="button">Cancelar</x-secondary-button>
  </a>
  <x-primary-button>Guardar</x-primary-button>
</div>
