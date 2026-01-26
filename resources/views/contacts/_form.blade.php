@php
  $input = "w-full bg-white rounded-xl px-3 py-2 ring-1 ring-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-900/20";
  $error = "ring-red-300 focus:ring-red-300";
@endphp

@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

  {{-- NOMBRE --}}
  <div>
    <label class="block text-sm text-gray-600 mb-1">Nombre</label>
    <input name="first_name" value="{{ old('first_name', $contact->first_name ?? '') }}"
           class="{{ $input }} @error('first_name') {{ $error }} @enderror">
    @error('first_name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- APELLIDO --}}
  <div>
    <label class="block text-sm text-gray-600 mb-1">Apellido</label>
    <input name="last_name" value="{{ old('last_name', $contact->last_name ?? '') }}"
           class="{{ $input }} @error('last_name') {{ $error }} @enderror">
    @error('last_name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- RAZÓN SOCIAL --}}
  <div class="md:col-span-2">
    <label class="block text-sm text-gray-600 mb-1">Razón Social</label>
    <input name="company_name" value="{{ old('company_name', $contact->company_name ?? '') }}"
           class="{{ $input }} @error('company_name') {{ $error }} @enderror">
    @error('company_name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- TELÉFONO 1 --}}
  <div>
    <label class="block text-sm text-gray-600 mb-1">Teléfono 1</label>
    <input name="phone_1" value="{{ old('phone_1', $contact->phone_1 ?? '') }}"
           class="{{ $input }} @error('phone_1') {{ $error }} @enderror"
           placeholder="+54 261 ...">
    @error('phone_1') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- TELÉFONO 2 --}}
  <div>
    <label class="block text-sm text-gray-600 mb-1">Teléfono 2</label>
    <input name="phone_2" value="{{ old('phone_2', $contact->phone_2 ?? '') }}"
           class="{{ $input }} @error('phone_2') {{ $error }} @enderror">
    @error('phone_2') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- EMAIL 1 --}}
  <div>
    <label class="block text-sm text-gray-600 mb-1">Email 1</label>
    <input type="email" name="email_1" value="{{ old('email_1', $contact->email_1 ?? '') }}"
           class="{{ $input }} @error('email_1') {{ $error }} @enderror"
           placeholder="mail@empresa.com">
    @error('email_1') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- EMAIL 2 --}}
  <div>
    <label class="block text-sm text-gray-600 mb-1">Email 2</label>
    <input type="email" name="email_2" value="{{ old('email_2', $contact->email_2 ?? '') }}"
           class="{{ $input }} @error('email_2') {{ $error }} @enderror">
    @error('email_2') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

</div>

<div class="mt-6 flex justify-end gap-2">
  <a href="{{ route('contacts.index') }}">
    <x-secondary-button type="button">Cancelar</x-secondary-button>
  </a>
  <x-primary-button>Guardar</x-primary-button>
</div>
