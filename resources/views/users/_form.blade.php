@php
  $isEdit = isset($user);
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

  {{-- Nombre --}}
  <div>
    <label class="block text-sm text-gray-600 mb-1">Nombre</label>
    <input name="name"
           value="{{ old('name', $user->name ?? '') }}"
           class="w-full bg-white ring-1 ring-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-gray-900/20">
    @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Email --}}
  <div>
    <label class="block text-sm text-gray-600 mb-1">Email</label>
    <input name="email" type="email"
           value="{{ old('email', $user->email ?? '') }}"
           class="w-full bg-white ring-1 ring-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-gray-900/20">
    @error('email') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Password --}}
  <div>
    <label class="block text-sm text-gray-600 mb-1">
      {{ $isEdit ? 'Nueva contraseña (opcional)' : 'Contraseña' }}
    </label>
    <input name="password" type="password"
           class="w-full bg-white ring-1 ring-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-gray-900/20">
    @error('password') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Confirm password --}}
  <div>
    <label class="block text-sm text-gray-600 mb-1">Confirmar contraseña</label>
    <input name="password_confirmation" type="password"
           class="w-full bg-white ring-1 ring-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-gray-900/20">
  </div>

</div>

{{-- ROLES --}}
@include('users._roles')

<div class="mt-5 flex justify-end gap-2">
  <a href="{{ route('users.index') }}">
    <x-secondary-button type="button">Cancelar</x-secondary-button>
  </a>
  <x-primary-button>Guardar</x-primary-button>
</div>
