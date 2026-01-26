@php
  $item = function(string $label, string $route, string $activeStartsWith = null) {
    $active = false;

    if ($activeStartsWith) {
      $active = request()->is($activeStartsWith . '*');
    } else {
      $active = request()->routeIs($route);
    }

    $base = 'flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition';
    $cls = $active
      ? $base . ' bg-gray-900 text-white'
      : $base . ' text-gray-700 hover:bg-gray-100';

    return ['active' => $active, 'cls' => $cls];
  };
@endphp

<aside class="h-full w-72 bg-white ring-1 ring-gray-100">
  <div class="p-5 border-b border-gray-100">
    <div class="text-lg font-semibold text-gray-900">Mini CRM</div>
    <div class="text-sm text-gray-500 mt-1">Panel comercial</div>
  </div>

  <nav class="p-4 space-y-1">
    @php($a = $item('Dashboard', 'dashboard', 'dashboard'))
    <a href="{{ route('dashboard') }}" class="{{ $a['cls'] }}">Dashboard</a>

    @php($a = $item('Agenda', 'agenda.index', 'agenda'))
    <a href="{{ route('agenda.index') }}" class="{{ $a['cls'] }}">Agenda</a>

    @php($a = $item('Contactos', 'contacts.index', 'contacts'))
    <a href="{{ route('contacts.index') }}" class="{{ $a['cls'] }}">Contactos</a>

    @php($a = $item('Oportunidades', 'opportunities.index', 'opportunities'))
    <a href="{{ route('opportunities.index') }}" class="{{ $a['cls'] }}">Oportunidades</a>

    @can('reports.view')
      @php($a = $item('Reporte comercial', 'reports.commercial', 'reports/commercial'))
      <a href="{{ route('reports.commercial') }}" class="{{ $a['cls'] }}">Reporte comercial</a>
    @endcan
  </nav>

  <div class="p-4 border-t border-gray-100 mt-auto">
    <div class="text-xs text-gray-500">Usuario</div>
    <div class="text-sm font-medium text-gray-900">{{ auth()->user()->name ?? '' }}</div>

    <form method="POST" action="{{ route('logout') }}" class="mt-3">
      @csrf
      <button class="w-full text-left px-3 py-2 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition">
        Cerrar sesión
      </button>
    </form>
  </div>
</aside>
