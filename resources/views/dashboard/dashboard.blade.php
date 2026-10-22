@extends('layout.layout')
@section('title', 'Dashboard Inventario')
@section('content')

<div class="container-fluid px-0">
    <!-- Encabezado de bienvenida / estado -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-dark">Dashboard Inventario</h2>
            <p class="text-muted small mb-0">Resumen en tiempo real del estado de existencias y niveles de alerta.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('productos.index') }}" class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-2">
                <i class="bi bi-box-seam"></i> Ver Productos
            </a>
            <a href="{{ route('movimientos.create') }}" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i> Nuevo Movimiento
            </a>
        </div>
    </div>

    {{-- TARJETAS MÉTRICAS RESPONSIVAS (1 col móvil, 2 tablet, 4 desktop) --}}
    <div class="row g-3 g-md-4 mb-4">
        {{-- Total Productos --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-dark text-white position-relative overflow-hidden">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 small text-uppercase fw-semibold tracking-wide">Total Productos</span>
                        <h2 class="display-6 fw-bold mb-0 mt-1">{{ $totalProducts }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-10 rounded-3 text-white fs-3">
                        <i class="bi bi-boxes"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stock Crítico --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-danger text-white position-relative overflow-hidden">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 small text-uppercase fw-semibold tracking-wide">Stock Crítico</span>
                        <h2 class="display-6 fw-bold mb-0 mt-1">{{ $criticalCount }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-10 rounded-3 text-white fs-3">
                        <i class="bi bi-exclamation-octagon-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stock Medio --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-warning text-dark position-relative overflow-hidden">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-dark text-opacity-75 small text-uppercase fw-semibold tracking-wide">Stock Medio</span>
                        <h2 class="display-6 fw-bold mb-0 mt-1">{{ $warningCount }}</h2>
                    </div>
                    <div class="p-3 bg-dark bg-opacity-10 rounded-3 text-dark fs-3">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stock Normal --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-success text-white position-relative overflow-hidden">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 small text-uppercase fw-semibold tracking-wide">Stock Normal</span>
                        <h2 class="display-6 fw-bold mb-0 mt-1">{{ $normalCount }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-10 rounded-3 text-white fs-3">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PRODUCTOS CRÍTICOS CON TABLA RESPONSIVA --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-danger text-white py-3 px-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-shield-exclamation fs-5"></i>
                <h5 class="mb-0 fw-bold">Productos con Stock Crítico</h5>
            </div>
            <span class="badge bg-white text-danger fw-semibold px-2 py-1 rounded-pill">
                {{ $criticalProducts->count() }} ítems
            </span>
        </div>
        <div class="card-body p-0">
            @if($criticalProducts->isEmpty())
                <div class="p-4 text-center">
                    <div class="text-success fs-1 mb-2">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h6 class="fw-bold text-success mb-1">¡No hay productos en estado crítico!</h6>
                    <p class="text-muted small mb-0">Todas las referencias del inventario se encuentran en niveles seguros de almacenamiento.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="px-4 py-3">Código</th>
                                <th scope="col" class="py-3">Producto</th>
                                <th scope="col" class="py-3 text-center">Cantidad</th>
                                <th scope="col" class="px-4 py-3 text-end">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($criticalProducts as $product)
                            <tr>
                                <td class="px-4 fw-semibold text-secondary">
                                    <code>{{ $product->code }}</code>
                                </td>
                                <td class="fw-medium text-dark">
                                    {{ $product->name }}
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold text-danger">{{ $product->amount }}</span>
                                </td>
                                <td class="px-4 text-end">
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> CRÍTICO
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
