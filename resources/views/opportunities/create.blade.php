<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nueva oportunidad
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="{{ route('opportunities.store') }}">
                    @include('opportunities._form', ['showClosedAt' => false])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
