@php
  $input = "w-full bg-white rounded-xl px-3 py-2 ring-1 ring-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-900/20";
  $error = "ring-red-300 focus:ring-red-300";
  $editing = isset($user);
  $currentRoles = $editing ? $user->roles->pluck('name')->all() : (old('roles', []));
@endphp

@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

  <div>
    <label class="block text-sm text-gray-600 mb-1">Nombre</label>
    <input name="name" value="{{ old('name', $user->name ?? '') }}"
           class="{{ $input }} @error('name') {{ $error }} @enderror">
    @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm text-gray-600 mb-1">Email</label>
    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
           class="{{ $input }} @error('email') {{ $error }} @enderror">
    @error('email') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm text-gray-600 mb-1">
      {{ $editing ? 'Nueva contraseña (opcional)' : 'Contraseña' }}
    </label>
    <input type="password" name="password"
           class="{{ $input }} @error('password') {{ $error }} @enderror">
    @error('password') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm text-gray-600 mb-1">
      {{ $editing ? 'Confirmar nueva contraseña (opcional)' : 'Confirmar contraseña' }}
    </label>
    <input type="password" name="password_confirmation" class="{{ $input }}">
  </div>

  <div class="md:col-span-2">
    <label class="block text-sm text-gray-600 mb-2">Roles</label>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
      @foreach($roles as $r)
        @php $checked = in_array($r->name, old('roles', $currentRoles)); @endphp
        <label class="flex items-center gap-2 p-3 rounded-xl ring-1 ring-gray-200 hover:bg-gray-50">
          <input type="checkbox" name="roles[]" value="{{ $r->name }}" @checked($checked)
                 class="rounded border-gray-300 text-gray-900 focus:ring-gray-900/20">
          <span class="text-sm text-gray-800 font-medium">{{ $r->name }}</span>
        </label>
      @endforeach
    </div>
    @error('roles') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

</div>

<div class="mt-6 flex justify-end gap-2">
  <a href="{{ route('users.index') }}"><x-secondary-button type="button">Cancelar</x-secondary-button></a>
  <x-primary-button>Guardar</x-primary-button>
</div>
