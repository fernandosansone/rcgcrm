@php
  $input = "w-full bg-white rounded-xl px-3 py-2 ring-1 ring-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-900/20";
  $error = "ring-red-300 focus:ring-red-300";

  $selected = old('permissions', $selectedPermissions ?? []);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

  {{-- Nombre del rol --}}
  <div class="md:col-span-2">
    <label class="block text-sm text-gray-600 mb-1">Nombre del rol</label>
    <input name="name" type="text"
      value="{{ old('name', $role->name ?? '') }}"
      class="{{ $input }} @error('name') {{ $error }} @enderror"
      required>
    @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Permisos --}}
  <div class="md:col-span-2">
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
            @checked(in_array($perm->name, $selected))>
          <span class="text-sm text-gray-800">{{ $perm->name }}</span>
        </label>
      @endforeach
    </div>

    @error('permissions') <div class="text-red-600 text-sm mt-2">{{ $message }}</div> @enderror
  </div>

</div>

<div class="mt-6 flex justify-end gap-2">
  <a href="{{ route('roles.index') }}">
    <x-secondary-button type="button">Cancelar</x-secondary-button>
  </a>
  <x-primary-button>Guardar</x-primary-button>
</div>
