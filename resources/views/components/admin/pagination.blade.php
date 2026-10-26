<nav class="admin-pagination" aria-label="Paginación">
    <span>{{ $records->total() }} registros · Página {{ $records->currentPage() }} de {{ $records->lastPage() }}</span>
    <div>@if($records->previousPageUrl())<a class="admin-button" href="{{ $records->previousPageUrl() }}">Anterior</a>@endif
    @if($records->nextPageUrl())<a class="admin-button" href="{{ $records->nextPageUrl() }}">Siguiente</a>@endif</div>
</nav>
