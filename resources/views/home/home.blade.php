@extends('layout.layout')
@section('title', 'Inicio - Sistema de Inventario')
@section('content')

<div class="container-fluid px-0">
    <!-- Hero / Bienvenida -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-gradient text-white" style="background: linear-gradient(135deg, #0b1324 0%, #1e293b 100%);">
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-8">
                    <span class="badge bg-primary bg-opacity-25 text-info border border-primary border-opacity-50 px-3 py-2 rounded-pill mb-3">
                        <i class="bi bi-shield-check me-1"></i> Sistema Operativo & Conectado
                    </span>
                    <h1 class="display-5 fw-bold mb-3 text-white">Gestión Inteligente de Inventario y Existencias</h1>
                    <p class="lead text-slate-300 mb-4 text-white-50" style="max-width: 650px;">
                        Controla tu catálogo de productos, audita los movimientos de almacén y administra proveedores con una interfaz optimizada para cualquier dispositivo móvil y de escritorio.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4 py-2 rounded-3 shadow-sm d-inline-flex align-items-center gap-2">
                            <i class="bi bi-speedometer2"></i> Ir al Dashboard
                        </a>
                        <a href="{{ route('productos.index') }}" class="btn btn-outline-light btn-lg px-4 py-2 rounded-3 d-inline-flex align-items-center gap-2">
                            <i class="bi bi-box-seam"></i> Explorar Catálogo
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-4 text-center d-none d-lg-block">
                    <div class="p-4 bg-white bg-opacity-10 rounded-circle d-inline-flex text-primary display-1 shadow-lg" style="width: 140px; height: 140px; align-items: center; justify-content: center;">
                        <i class="bi bi-boxes text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Módulos de Acceso Rápido Responsivos (1 col móvil, 2 col tablet, 4 col desktop) -->
    <div class="row g-3 g-md-4 mb-4">
        <!-- Tarjeta Dashboard -->
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('dashboard') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3 hover-elevate transition-all">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="badge-icon-box text-primary fs-4" style="width: 48px; height: 48px;">
                                <i class="bi bi-grid-1x2-fill"></i>
                            </div>
                            <span class="text-muted small"><i class="bi bi-chevron-right"></i></span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Métricas & Dashboard</h5>
                        <p class="text-muted small mb-0">Supervisa alertas de stock crítico y estado global del almacén.</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Tarjeta Productos -->
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('productos.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3 hover-elevate transition-all">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="badge-icon-box text-success fs-4" style="width: 48px; height: 48px; background: rgba(16, 185, 129, 0.1);">
                                <i class="bi bi-box-seam-fill text-success"></i>
                            </div>
                            <span class="text-muted small"><i class="bi bi-chevron-right"></i></span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Productos</h5>
                        <p class="text-muted small mb-0">Gestión de códigos, precios, unidades y generación de reportes PDF.</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Tarjeta Movimientos -->
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('movimientos.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3 hover-elevate transition-all">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="badge-icon-box text-warning fs-4" style="width: 48px; height: 48px; background: rgba(245, 158, 11, 0.1);">
                                <i class="bi bi-arrow-left-right text-warning"></i>
                            </div>
                            <span class="text-muted small"><i class="bi bi-chevron-right"></i></span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Movimientos</h5>
                        <p class="text-muted small mb-0">Registro y trazabilidad de entradas, salidas y devoluciones.</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Tarjeta Proveedores -->
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('proveedores.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3 hover-elevate transition-all">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="badge-icon-box text-info fs-4" style="width: 48px; height: 48px; background: rgba(14, 165, 233, 0.1);">
                                <i class="bi bi-truck text-info"></i>
                            </div>
                            <span class="text-muted small"><i class="bi bi-chevron-right"></i></span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Proveedores</h5>
                        <p class="text-muted small mb-0">Directorio de contactos, números telefónicos y catálogo distribuido.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
.hover-elevate {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-elevate:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
}
</style>

@endsection
