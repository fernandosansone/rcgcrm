<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Oportunidades
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-200 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex items-center justify-between gap-3">
                <form method="GET" class="flex flex-wrap gap-2 items-center">
                    <input type="text" name="q" value="{{ $q }}" placeholder="Buscar por detalle o contacto..." class="border rounded px-3 py-2 w-80">

                    <select name="status" class="border rounded px-3 py-2">
                        <option value="">Todos los estados</option>
                        @foreach ($statuses as $st)
                            <option value="{{ $st }}" @selected($status === $st)>{{ $st }}</option>
                        @endforeach
                    </select>

                    <!--<button class="px-3 py-2 border rounded">Filtrar</button>-->
                    <x-primary-button>Filtrar</x-primary-button>
                </form>

                @can('opportunities.create')
                    <a href="{{ route('opportunities.create') }}" class="px-3 py-2 bg-black text-white rounded">
                        Nueva oportunidad
                    </a>
                @endcan
            </div>

            <div class="bg-white shadow rounded overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-3">#</th>
                            <th class="text-left p-3">Contacto</th>
                            <th class="text-left p-3">Detalle</th>
                            <th class="text-left p-3">Estado</th>
                            <th class="text-left p-3">Importe</th>
                            <th class="text-left p-3">Ejecutivo</th>
                            <th class="text-right p-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($opportunities as $o)
                            <tr class="border-b">
                                <td class="p-3">{{ $o->id }}</td>
                                <td class="p-3">
                                    {{ $o->contact?->last_name }}, {{ $o->contact?->first_name }}
                                    @if($o->contact?->company_name)
                                        <div class="text-sm text-gray-500">{{ $o->contact->company_name }}</div>
                                    @endif
                                </td>
                                <td class="p-3">{{ $o->detail }}</td>
                                <td class="p-3">{{ $o->status->value ?? $o->status }}</td>
                                <td class="p-3">{{ $o->amount }}</td>
                                <td class="p-3">{{ $o->assignedUser?->name }}</td>
                                <td class="p-3 text-right">
                                    @can('opportunities.update')
                                        <a class="underline" href="{{ route('opportunities.edit', $o) }}">Editar</a>
                                    @endcan

                                    @can('opportunities.delete')
                                        <form method="POST" action="{{ route('opportunities.destroy', $o) }}" class="inline"
                                              onsubmit="return confirm('¿Eliminar oportunidad?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="underline text-red-600 ml-3">Eliminar</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-3">
                    {{ $opportunities->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
