@extends('layout.layout')
@section('title', 'Lista de Movimientos')

@section('content')

<div class="container-fluid px-0">
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>{{ Session::get('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Barra superior de acciones -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-dark">Historial de Movimientos</h2>
            <p class="text-muted small mb-0">Registro y auditoría de entradas, salidas y devoluciones de stock.</p>
        </div>
        <a href="{{ route('movimientos.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Nuevo Movimiento</span>
        </a>
    </div>

    <!-- Tabla Responsiva de Movimientos -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="px-3 py-3">ID</th>
                        <th scope="col" class="py-3">Tipo</th>
                        <th scope="col" class="py-3 text-center">Cantidad</th>
                        <th scope="col" class="py-3">Punto Venta / Caja</th>
                        <th scope="col" class="py-3">Producto</th>
                        <th scope="col" class="py-3 text-center">Stock Actual</th>
                        <th scope="col" class="px-3 py-3 text-end">Alarma</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($movements as $movement)
                        <tr>
                            <td class="px-3 text-secondary fw-semibold">
                                #{{ $movement->id }}
                            </td>
                            <td>
                                @php
                                    $typeClass = match(strtolower($movement->type)) {
                                        'entrada' => 'bg-success bg-opacity-10 text-success border-success border-opacity-25',
                                        'salida' => 'bg-danger bg-opacity-10 text-danger border-danger border-opacity-25',
                                        default => 'bg-warning bg-opacity-10 text-warning border-warning border-opacity-25'
                                    };
                                    $typeIcon = match(strtolower($movement->type)) {
                                        'entrada' => 'bi-box-arrow-in-down',
                                        'salida' => 'bi-box-arrow-up-right',
                                        default => 'bi-arrow-repeat'
                                    };
                                @endphp
                                <span class="badge {{ $typeClass }} border px-2 py-1 rounded-pill text-uppercase">
                                    <i class="bi {{ $typeIcon }} me-1"></i> {{ $movement->type }}
                                </span>
                            </td>
                            <td class="text-center fw-bold text-dark">
                                {{ $movement->amount }}
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-shop me-1 text-muted"></i> Caja {{ $movement->sale_point }}
                                </span>
                            </td>
                            <td class="fw-medium text-dark">
                                {{ $movement->product ? $movement->product->name : 'Sin Producto' }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary bg-opacity-10 text-dark border px-2 py-1 rounded-pill">
                                    {{ $movement->product ? $movement->product->amount : 'N/A' }}
                                </span>
                            </td>
                            <td class="px-3 text-end">
                                @if ($movement->product && $movement->product->amount <= 10)
                                    <span class="text-danger fw-bold d-inline-flex align-items-center gap-1" title="Alerta: Stock muy bajo">
                                        <i class="bi bi-bell-fill"></i> Bajo
                                    </span>
                                @else
                                    <span class="text-success fw-semibold d-inline-flex align-items-center gap-1" title="Stock en nivel adecuado">
                                        <i class="bi bi-check-circle-fill"></i> Normal
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-arrow-left-right fs-1 d-block mb-2 text-secondary"></i>
                                No hay movimientos de inventario registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación responsiva -->
    <div class="mt-3">
        {{ $movements->links() }}
    </div>
</div>

@endsection
