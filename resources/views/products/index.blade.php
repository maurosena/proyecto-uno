@extends('layout.layout')
@section('title', 'Lista de Productos')
@section('content')

<div class="container-fluid px-0">
    <!-- Barra superior de acciones de la vista -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-dark">Catálogo de Productos</h2>
            <p class="text-muted small mb-0">Gestión de existencias, precios y proveedores asociados.</p>
        </div>
        <a href="{{ route('productos.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Agregar Producto</span>
        </a>
    </div>

    <!-- Contenedor con Tabla Responsiva -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="px-3 py-3">Código</th>
                        <th scope="col" class="py-3">Nombre</th>
                        <th scope="col" class="py-3 text-center">Cantidad</th>
                        <th scope="col" class="py-3">Proveedor</th>
                        <th scope="col" class="px-3 py-3 text-end" style="min-width: 170px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-3 fw-semibold text-secondary">
                                <code>{{ $product->code }}</code>
                            </td>
                            <td class="fw-medium text-dark">
                                {{ $product->name }}
                            </td>
                            <td class="text-center">
                                @if ($product->amount <= 100)
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill">
                                        <i class="bi bi-bell-fill me-1"></i> {{ $product->amount }}
                                    </span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill">
                                        <i class="bi bi-check-circle-fill me-1"></i> {{ $product->amount }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-truck me-1 text-primary"></i>
                                    {{ $product->provider?->name ?? 'Sin proveedor' }}
                                </span>
                            </td>
                            <td class="px-3 text-end">
                                <div class="action-buttons-group justify-content-end">
                                    <!-- Ver detalle modal -->
                                    <button type="button" class="btn btn-sm btn-outline-info"
                                        data-bs-toggle="modal" data-bs-target="#infoModal"
                                        data-id="{{ $product->id }}"
                                        data-code="{{ $product->code }}"
                                        data-name="{{ $product->name }}"
                                        data-amount="{{ $product->amount }}"
                                        data-unit="{{ $product->unit }}"
                                        data-price="{{ $product->price }}"
                                        data-provider_id="{{ $product->provider?->name ?? 'Sin Proveedor' }}"
                                        title="Ver detalle del producto" aria-label="Ver detalle">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <!-- Editar -->
                                    <a href="{{ route('productos.edit', ['producto' => $product->id]) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Editar producto" aria-label="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <!-- PDF -->
                                    <a href="{{ route('pdf', $product->id) }}" target="_blank"
                                       class="btn btn-sm btn-outline-secondary"
                                       title="Generar Ficha PDF" aria-label="Descargar PDF">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>

                                    <!-- Eliminar -->
                                    <form action="{{ route('productos.destroy', $product) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('¿Está seguro de eliminar el producto {{ $product->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar producto" aria-label="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                No hay productos registrados en el sistema.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación con estilos mejorados -->
    <div class="mt-3">
        {{ $products->links() }}
    </div>

    <!-- Modal Detalle del Producto (Responsive) -->
    <div class="modal fade" tabindex="-1" id="infoModal" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-primary text-white py-3 px-4">
                    <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="infoModalLabel">
                        <i class="bi bi-box-seam"></i> Detalle del Producto
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="list-group list-group-flush rounded-3 border">
                        <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                            <span class="text-muted small">ID Registro</span>
                            <span id="id" class="fw-semibold"></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                            <span class="text-muted small">Código</span>
                            <span id="code" class="fw-semibold font-monospace"></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                            <span class="text-muted small">Nombre</span>
                            <span id="name" class="fw-semibold"></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                            <span class="text-muted small">Cantidad en Stock</span>
                            <span id="amount" class="badge bg-primary rounded-pill px-3 py-1"></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                            <span class="text-muted small">Unidad de Medida</span>
                            <span id="unit" class="fw-semibold"></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                            <span class="text-muted small">Precio Unitario</span>
                            <span id="price" class="fw-bold text-success"></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                            <span class="text-muted small">Proveedor</span>
                            <span id="provider_id" class="fw-semibold text-primary"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm px-3 rounded-3" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const infoModal = document.getElementById('infoModal');
        if (infoModal) {
            infoModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                if (!button) return;

                document.getElementById('id').textContent = button.getAttribute('data-id') || '-';
                document.getElementById('code').textContent = button.getAttribute('data-code') || '-';
                document.getElementById('name').textContent = button.getAttribute('data-name') || '-';
                document.getElementById('amount').textContent = button.getAttribute('data-amount') || '0';
                document.getElementById('unit').textContent = button.getAttribute('data-unit') || '-';
                
                const rawPrice = button.getAttribute('data-price') || '0';
                const formattedPrice = Number(rawPrice).toLocaleString('es-CO', { style: 'currency', currency: 'COP', maximumFractionDigits: 0 });
                document.getElementById('price').textContent = formattedPrice;

                document.getElementById('provider_id').textContent = button.getAttribute('data-provider_id') || 'Sin Proveedor';
            });
        }
    });
</script>

@endsection
