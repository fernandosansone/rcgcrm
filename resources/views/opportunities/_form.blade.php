@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div class="md:col-span-2">
        <label class="block mb-1">Contacto</label>
        <select name="contact_id" class="border rounded w-full px-3 py-2">
            <option value="">Seleccionar...</option>
            @foreach($contacts as $c)
                @php
                    $label = $c->last_name . ', ' . $c->first_name;
                    if ($c->company_name) $label .= ' — ' . $c->company_name;
                @endphp
                <option value="{{ $c->id }}" @selected((string)old('contact_id', $opportunity->contact_id ?? '') === (string)$c->id)>{{ $label }}</option>
            @endforeach
        </select>
        @error('contact_id') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block mb-1">Producto / Detalle</label>
        <input name="detail" value="{{ old('detail', $opportunity->detail ?? '') }}" class="border rounded w-full px-3 py-2">
        @error('detail') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block mb-1">Cantidad</label>
        <input name="quantity" value="{{ old('quantity', $opportunity->quantity ?? '') }}" class="border rounded w-full px-3 py-2">
        @error('quantity') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block mb-1">Medida</label>
        <input name="unit" value="{{ old('unit', $opportunity->unit ?? '') }}" class="border rounded w-full px-3 py-2">
        @error('unit') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block mb-1">Importe</label>
        <input name="amount" value="{{ old('amount', $opportunity->amount ?? '') }}" class="border rounded w-full px-3 py-2">
        @error('amount') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block mb-1">Estado</label>
        <select name="status" class="border rounded w-full px-3 py-2">
            @foreach($statuses as $st)
                <option value="{{ $st }}" @selected(old('status', ($opportunity->status->value ?? $opportunity->status ?? 'prospecto')) === $st)>{{ $st }}</option>
            @endforeach
        </select>
        @error('status') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block mb-1">Fecha apertura</label>
        <input type="date" name="opened_at" value="{{ old('opened_at', $opportunity->opened_at ?? '') }}" class="border rounded w-full px-3 py-2">
        @error('opened_at') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block mb-1">Fecha cierre</label>
        <input type="date" name="closed_at" value="{{ old('closed_at', $opportunity->closed_at ?? '') }}" class="border rounded w-full px-3 py-2">
        @error('closed_at') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
    </div>

</div>

<div class="mt-4 flex gap-2">
    <button class="px-4 py-2 bg-black text-white rounded">Guardar</button>
    <a href="{{ route('opportunities.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
</div>
