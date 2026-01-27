<div
  x-data="followupsModal()"
  x-on:open-followups.window="open($event.detail.opportunityId)"
  x-show="isOpen"
  x-cloak
  class="fixed inset-0 z-50 flex items-center justify-center"
>
  {{-- Backdrop --}}
  <div class="absolute inset-0 bg-gray-900/40" x-on:click="close()"></div>

  {{-- Panel --}}
  <div class="relative w-full max-w-3xl mx-4 rounded-2xl bg-white shadow-xl ring-1 ring-gray-100 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 flex items-start justify-between gap-4">
      <div>
        <div class="text-lg font-semibold text-gray-900">Historial de seguimiento</div>
        <div class="text-sm text-gray-500 mt-1" x-text="subtitle"></div>
      </div>

      <button class="rounded-xl px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100" x-on:click="close()">
        Cerrar
      </button>
    </div>

    <div class="p-5">
      {{-- Loading --}}
      <template x-if="loading">
        <div class="rounded-xl bg-gray-50 ring-1 ring-gray-100 p-4 text-sm text-gray-600">
          Cargando historial…
        </div>
      </template>

      {{-- Error --}}
      <template x-if="error">
        <div class="rounded-xl bg-red-50 ring-1 ring-red-200 p-4 text-sm text-red-700" x-text="error"></div>
      </template>

      {{-- Empty --}}
      <template x-if="!loading && !error && followups.length === 0">
        <div class="rounded-xl bg-gray-50 ring-1 ring-gray-100 p-4 text-sm text-gray-600">
          Esta oportunidad aún no tiene seguimientos registrados.
        </div>
      </template>

      {{-- List --}}
      <template x-if="!loading && !error && followups.length > 0">
        <div class="space-y-3">
          <template x-for="f in followups" :key="f.id">
            <div class="rounded-2xl ring-1 ring-gray-100 p-4">
              <div class="flex items-start justify-between gap-3">
                <div>
                  <div class="text-sm font-semibold text-gray-900">
                    <span x-text="formatDate(f.contact_date)"></span>
                    <span class="text-gray-400">·</span>
                    <span class="text-gray-700" x-text="f.contact_method"></span>
                  </div>

                  <div class="mt-2 text-sm text-gray-700 whitespace-pre-line" x-text="f.response || '—'"></div>
                </div>

                <div class="text-right shrink-0">
                  <div class="text-xs text-gray-500">Próximo contacto</div>
                  <div class="text-sm font-medium text-gray-900" x-text="f.next_contact_date ? formatDate(f.next_contact_date) : '—'"></div>
                </div>
              </div>
            </div>
          </template>
        </div>
      </template>
    </div>
  </div>
</div>

<script>
  function followupsModal() {
    return {
      isOpen: false,
      loading: false,
      error: '',
      subtitle: '',
      followups: [],
      async open(opportunityId) {
        this.isOpen = true;
        this.loading = true;
        this.error = '';
        this.followups = [];
        this.subtitle = `Oportunidad #${opportunityId}`;

        try {
          const res = await fetch(`/opportunities/${opportunityId}/followups`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
          });

          if (!res.ok) {
            if (res.status === 403) throw new Error('No tenés permisos para ver este historial.');
            throw new Error('No se pudo cargar el historial.');
          }

          const data = await res.json();
          this.subtitle = `#${data.opportunity.id} · ${data.opportunity.detail ?? ''}`;
          this.followups = data.followups ?? [];
        } catch (e) {
          this.error = e.message || 'Error inesperado.';
        } finally {
          this.loading = false;
        }
      },
      close() {
        this.isOpen = false;
      },
      formatDate(d) {
        if (!d) return '';
        // d viene YYYY-MM-DD o datetime -> cortamos a fecha
        const datePart = String(d).substring(0, 10);
        const [y,m,dd] = datePart.split('-');
        return `${dd}/${m}/${y}`;
      }
    }
  }
</script>
