<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Contactos
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
                <form method="GET" class="flex gap-2">
                    <input type="text" name="q" value="{{ $q }}" placeholder="Buscar..." class="border rounded px-3 py-2 w-72">
                    <button class="px-3 py-2 border rounded">Buscar</button>
                </form>

                @can('contacts.create')
                    <a href="{{ route('contacts.create') }}" class="px-3 py-2 bg-black text-white rounded">
                        Nuevo contacto
                    </a>
                @endcan
            </div>

            <div class="bg-white shadow rounded">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-3">Nombre</th>
                            <th class="text-left p-3">Razón Social</th>
                            <th class="text-left p-3">Teléfono</th>
                            <th class="text-left p-3">Email</th>
                            <th class="text-right p-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $c)
                            <tr class="border-b">
                                <td class="p-3">{{ $c->last_name }}, {{ $c->first_name }}</td>
                                <td class="p-3">{{ $c->company_name }}</td>
                                <td class="p-3">{{ $c->phone_1 }}</td>
                                <td class="p-3">{{ $c->email_1 }}</td>
                                <td class="p-3 text-right">
                                    @can('contacts.update')
                                        <a class="underline" href="{{ route('contacts.edit', $c) }}">Editar</a>
                                    @endcan

                                    @can('contacts.delete')
                                        <form method="POST" action="{{ route('contacts.destroy', $c) }}" class="inline"
                                              onsubmit="return confirm('¿Eliminar contacto?');">
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
                    {{ $contacts->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
