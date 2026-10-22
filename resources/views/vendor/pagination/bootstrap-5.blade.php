@if ($paginator->hasPages())
    <nav class="custom-pagination-nav d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 p-3 my-4 bg-white rounded-4 border shadow-sm" aria-label="Navegación de páginas">
        {{-- Información de registros --}}
        <div class="pagination-info text-muted small d-flex align-items-center gap-2 order-2 order-md-1">
            <span class="badge-icon-box">
                <i class="bi bi-layers-fill text-primary"></i>
            </span>
            <span>
                Mostrando del <strong class="text-dark fw-bold">{{ $paginator->firstItem() ?? 0 }}</strong>
                al <strong class="text-dark fw-bold">{{ $paginator->lastItem() ?? 0 }}</strong>
                de <strong class="text-primary fw-bold">{{ $paginator->total() }}</strong> registros
            </span>
        </div>

        {{-- Controles de páginas --}}
        <div class="order-1 order-md-2">
            <ul class="pagination custom-pagination mb-0">
                {{-- Botón Anterior --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true" aria-label="Anterior">
                        <span class="page-link" aria-hidden="true">
                            <i class="bi bi-chevron-left me-1"></i>
                            <span class="d-none d-sm-inline">Anterior</span>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Anterior">
                            <i class="bi bi-chevron-left me-1"></i>
                            <span class="d-none d-sm-inline">Anterior</span>
                        </a>
                    </li>
                @endif

                {{-- Elementos de Paginación (Páginas y Puntos suspensivos) --}}
                @foreach ($elements as $element)
                    {{-- Separador "..." --}}
                    @if (is_string($element))
                        <li class="page-item disabled separator" aria-disabled="true">
                            <span class="page-link">{{ $element }}</span>
                        </li>
                    @endif

                    {{-- Enlaces a las páginas --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Botón Siguiente --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Siguiente">
                            <span class="d-none d-sm-inline">Siguiente</span>
                            <i class="bi bi-chevron-right ms-1"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true" aria-label="Siguiente">
                        <span class="page-link" aria-hidden="true">
                            <span class="d-none d-sm-inline">Siguiente</span>
                            <i class="bi bi-chevron-right ms-1"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
@endif
