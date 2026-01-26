<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Mi agenda
    </h2>
  </x-slot>

  <div class="py-6" x-data="followupModal()">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-200 rounded">
          {{ session('success') }}
        </div>
      @endif

      {{-- ATRASADOS --}}
      <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Atrasados</h3>
        <div class="bg-white shadow rounded overflow-x-auto">
          <table class="min-w-full">
            <thead>
              <tr class="border-b">
                <th class="text-left p-3">Contacto</th>
                <th class="text-left p-3">Oportunidad</th>
                <th class="text-left p-3">Próximo contacto</th>
                <th class="text-left p-3">Atraso</th>
                <th class="text-right p-3">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse($overdue as $r)
                @php $o = $r['opportunity']; @endphp
                <tr class="border-b">
                  <td class="p-3">
                    {{ $o->contact?->last_name }}, {{ $o->contact?->first_name }}
                    @if($o->contact?->company_name)
                      <div class="text-sm text-gray-500">{{ $o->contact->company_name }}</div>
                    @endif
                  </td>
                  <td class="p-3">{{ $o->detail }}</td>
                  <td class="p-3">{{ $r['next_contact_date'] }}</td>
                  <td class="p-3">
                    <span class="px-2 py-1 rounded bg-red-100 border border-red-200">
                      {{ $r['days_late'] }} día(s)
                    </span>
                  </td>
                  <td class="p-3 text-right">
                    <x-primary-button type="button"
                      @click="open({{ $o->id }}, '{{ addslashes($o->detail) }}', '{{ $r['next_contact_date'] }}')">
                      Registrar seguimiento
                    </x-primary-button>
                  </td>
                </tr>
              @empty
                <tr><td class="p-3 text-gray-500" colspan="5">Sin atrasos 🎉</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      {{-- HOY --}}
      <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Para hoy</h3>
        <div class="bg-white shadow rounded overflow-x-auto">
          <table class="min-w-full">
            <thead>
              <tr class="border-b">
                <th class="text-left p-3">Contacto</th>
                <th class="text-left p-3">Oportunidad</th>
                <th class="text-left p-3">Próximo contacto</th>
                <th class="text-right p-3">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse($todayRows as $r)
                @php $o = $r['opportunity']; @endphp
                <tr class="border-b">
                  <td class="p-3">{{ $o->contact?->last_name }}, {{ $o->contact?->first_name }}</td>
                  <td class="p-3">{{ $o->detail }}</td>
                  <td class="p-3">{{ $r['next_contact_date'] }}</td>
                  <td class="p-3 text-right">
                    <x-primary-button type="button"
                      @click="open({{ $o->id }}, '{{ addslashes($o->detail) }}', '{{ $r['next_contact_date'] }}')">
                      Registrar seguimiento
                    </x-primary-button>
                  </td>
                </tr>
              @empty
                <tr><td class="p-3 text-gray-500" colspan="4">No hay tareas para hoy.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      {{-- SIN FECHA --}}
      <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Sin próxima fecha</h3>
        <div class="bg-white shadow rounded overflow-x-auto">
          <table class="min-w-full">
            <thead>
              <tr class="border-b">
                <th class="text-left p-3">Contacto</th>
                <th class="text-left p-3">Oportunidad</th>
                <th class="text-right p-3">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse($noDate as $r)
                @php $o = $r['opportunity']; @endphp
                <tr class="border-b">
                  <td class="p-3">{{ $o->contact?->last_name }}, {{ $o->contact?->first_name }}</td>
                  <td class="p-3">{{ $o->detail }}</td>
                  <td class="p-3 text-right">
                    <x-primary-button type="button"
                      @click="open({{ $o->id }}, '{{ addslashes($o->detail) }}', '')">
                      Registrar primer seguimiento
                    </x-primary-button>
                  </td>
                </tr>
              @empty
                <tr><td class="p-3 text-gray-500" colspan="3">No hay oportunidades sin fecha.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      {{-- MODAL --}}
      <div x-show="isOpen" class="fixed inset-0 flex items-center justify-center bg-black/50" style="display:none">
        <div class="bg-white rounded p-6 w-full max-w-xl">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Registrar seguimiento</h3>
            <button type="button" @click="isOpen=false">✕</button>
          </div>

          <div class="text-sm text-gray-600 mb-4">
            <div><strong>Oportunidad:</strong> <span x-text="oppDetail"></span></div>
            <template x-if="dueDate">
              <div><strong>Vencía:</strong> <span x-text="dueDate"></span></div>
            </template>
          </div>

          <form method="POST" action="{{ route('agenda.followups.store') }}">
            @csrf
            <input type="hidden" name="opportunity_id" :value="oppId">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label class="block mb-1">Fecha contacto</label>
                <input type="datetime-local" name="contact_date" class="border rounded w-full px-3 py-2"
                       value="{{ now()->format('Y-m-d\\TH:i') }}">
              </div>

              <div>
                <label class="block mb-1">Forma</label>
                <select name="contact_method" class="border rounded w-full px-3 py-2">
                  <option value="telefono">Teléfono</option>
                  <option value="email">Email</option>
                  <option value="reunion">Reunión</option>
                  <option value="whatsapp">WhatsApp</option>
                  <option value="otro">Otro</option>
                </select>
              </div>

              <div class="md:col-span-2">
                <label class="block mb-1">Respuesta</label>
                <textarea name="response" class="border rounded w-full px-3 py-2" rows="3"></textarea>
              </div>

              <div>
                <label class="block mb-1">Próximo contacto</label>
                <input type="date" name="next_contact_date" class="border rounded w-full px-3 py-2">
              </div>
            </div>

            <div class="mt-4 flex gap-2 justify-end">
              <x-secondary-button type="button" @click="isOpen=false">Cancelar</x-secondary-button>
              <x-primary-button>Guardar</x-primary-button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>

  <script>
    function followupModal() {
      return {
        isOpen: false,
        oppId: null,
        oppDetail: '',
        dueDate: '',
        open(id, detail, due) {
          this.oppId = id;
          this.oppDetail = detail;
          this.dueDate = due || '';
          this.isOpen = true;
        }
      }
    }
  </script>
</x-app-layout>
