<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between gap-4">
      <div>
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">Editar contacto #{{ $contact->id }}</h2>
        <div class="text-sm text-gray-500 mt-1">Actualizá información y mantené la base limpia.</div>
      </div>

      <a href="{{ route('contacts.index') }}">
        <x-secondary-button type="button">Volver</x-secondary-button>
      </a>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

      @if ($errors->any())
        <x-card>
          <div class="p-3 bg-red-50 border border-red-100 rounded-xl text-red-800">
            Revisá los campos marcados en rojo.
          </div>
        </x-card>
      @endif

      <x-card title="Datos del contacto" subtitle="Modificá nombre, empresa, emails y teléfonos.">
        <form method="POST" action="{{ route('contacts.update', $contact) }}">
          @method('PUT')
          @include('contacts._form', ['contact' => $contact])
        </form>
      </x-card>

    </div>
  </div>
</x-app-layout>
