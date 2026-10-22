@extends('layout.layout')
@section('title', 'Lista de Proveedores')
@section('content')

<div class="container-fluid px-0">
    <!-- Encabezado de la sección -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-dark">Directorio de Proveedores</h2>
            <p class="text-muted small mb-0">Gestión de contactos comerciales y distribución de productos.</p>
        </div>
        <div>
            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill fs-6">
                <i class="bi bi-truck me-1"></i> {{ $providers->total() }} Proveedores Registrados
            </span>
        </div>
    </div>

    <!-- Tabla Responsiva de Proveedores -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="px-3 py-3">NIT / Doc</th>
                        <th scope="col" class="py-3">Razón Social / Nombre</th>
                        <th scope="col" class="py-3">Contacto</th>
                        <th scope="col" class="py-3">Dirección</th>
                        <th scope="col" class="px-3 py-3 text-center">Productos Vinculados</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($providers as $provider)
                        <tr>
                            <td class="px-3 fw-semibold text-secondary">
                                <code>{{ $provider->nit ?? 'S/N' }}</code>
                            </td>
                            <td class="fw-bold text-dark">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="badge-icon-box text-primary">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <span>{{ $provider->name }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column small">
                                    @if ($provider->phone)
                                        <span class="text-secondary">
                                            <i class="bi bi-telephone text-muted me-1"></i> {{ $provider->phone }}
                                        </span>
                                    @endif
                                    @if ($provider->email)
                                        <span class="text-muted">
                                            <i class="bi bi-envelope text-muted me-1"></i> {{ $provider->email }}
                                        </span>
                                    @endif
                                    @if (!$provider->phone && !$provider->email)
                                        <span class="text-muted italic">Sin contacto registrado</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="text-secondary small">
                                    <i class="bi bi-geo-alt text-muted me-1"></i> {{ $provider->address ?? 'No especificada' }}
                                </span>
                            </td>
                            <td class="px-3 text-center">
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1 rounded-pill">
                                    <i class="bi bi-box-seam me-1"></i> {{ $provider->products_count }} productos
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-truck fs-1 d-block mb-2 text-secondary"></i>
                                No hay proveedores registrados actualmente.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación Responsiva -->
    <div class="mt-3">
        {{ $providers->links() }}
    </div>
</div>

@endsection
