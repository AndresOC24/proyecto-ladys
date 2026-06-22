@if ($crud->hasAccess('update'))
<form action="{{ url($crud->route.'/'.$entry->id.'/toggle-activo') }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-sm {{ $entry->activo ? 'btn-outline-warning' : 'btn-outline-success' }}">
        <i class="la {{ $entry->activo ? 'la-toggle-off' : 'la-toggle-on' }}"></i>
        {{ $entry->activo ? 'Desactivar' : 'Activar' }}
    </button>
</form>
@endif
