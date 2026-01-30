<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between gap-4">
      <div>
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">Editar contacto</h2>
        <div class="text-sm text-gray-500 mt-1">ID #{{ $contact->id }} · Modificá nombre, empresa, emails y teléfonos.</div>
      </div>

      <a href="{{ route('contacts.index') }}">
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
          <x-alert type="error">
            {{ $errors->first() }}
          </x-alert>
        </x-card>
      @endif

      <x-card title="Datos del contacto" subtitle="Modificá nombre, empresa, emails y teléfonos.">
        <form method="POST" action="{{ route('contacts.update', $contact) }}">
          @csrf
          @method('PUT')
          @include('contacts._form', ['contact' => $contact])
        </form>
      </x-card>

    </div>
  </div>
</x-app-layout>
