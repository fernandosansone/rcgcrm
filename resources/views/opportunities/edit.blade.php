<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between gap-4">
      <div>
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">Editar oportunidad</h2>
        <div class="text-sm text-gray-500 mt-1">ID #{{ $opportunity->id }} · Modificá la información y, si corresponde, la fecha de cierre.</div>
      </div>

      <a href="{{ route('opportunities.index') }}">
        <x-secondary-button type="button">Cancelar</x-secondary-button>
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

      <x-card title="Datos de la oportunidad" subtitle="Modificá detalle, estado, importe y fechas.">
        <form method="POST" action="{{ route('opportunities.update', $opportunity) }}">
          @csrf
          @method('PUT')
          @include('opportunities._form', ['opportunity' => $opportunity, 'showClosedAt' => true])
        </form>
      </x-card>

    </div>
  </div>
</x-app-layout>
