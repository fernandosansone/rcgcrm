<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between gap-4">
      <div>
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">Editar usuario #{{ $user->id }}</h2>
        <div class="text-sm text-gray-500 mt-1">Actualizá datos y roles de acceso.</div>
      </div>

      <a href="{{ route('users.index') }}">
        <x-secondary-button type="button">Volver</x-secondary-button>
      </a>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

      @if (session('success'))
        <x-card><x-alert type="success">{{ session('success') }}</x-alert></x-card>
      @endif

      @if ($errors->any())
        <x-card><x-alert type="error">Revisá los campos marcados.</x-alert></x-card>
      @endif

      <x-card title="Datos del usuario" subtitle="Nombre, email, contraseña (opcional) y roles.">
        <form method="POST" action="{{ route('users.update', $user) }}">
          @csrf
          @method('PUT')

          @include('users._form', ['user' => $user, 'roles' => $roles])
        </form>
      </x-card>

    </div>
  </div>
</x-app-layout>
