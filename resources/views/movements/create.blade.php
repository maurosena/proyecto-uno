@extends('layout.layout')
@section('title', 'Agregar Movimiento')

@section('content')

<div class="container-fluid px-0">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white py-3 px-4">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left-right"></i> Registrar Movimiento de Stock
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('movimientos.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label for="type" class="form-label fw-semibold small text-secondary">Tipo de Movimiento</label>
                                <select name="type" id="type" class="form-select rounded-3" required>
                                    @foreach ($movements_type as $type)
                                        <option value="{{ $type }}">{{ mb_strtoupper($type) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-sm-6">
                                <label for="amount" class="form-label fw-semibold small text-secondary">Cantidad a Procesar</label>
                                <input type="number" min="1" name="amount" id="amount" class="form-control rounded-3" placeholder="Ej: 10" required>
                            </div>

                            <div class="col-12 col-sm-6">
                                <label for="sale_point" class="form-label fw-semibold small text-secondary">Punto de Transacción / Caja</label>
                                <select name="sale_point" id="sale_point" class="form-select rounded-3" required>
                                    <option value="" disabled selected>Seleccione la caja o punto</option>
                                    <option value="1">Caja 1 - Principal</option>
                                    <option value="2">Caja 2 - Bodega</option>
                                    <option value="3">Caja 3 - Despachos</option>
                                </select>
                            </div>

                            <div class="col-12 col-sm-6">
                                <label for="producto" class="form-label fw-semibold small text-secondary">Producto Seleccionado</label>
                                <select name="producto" id="producto" class="form-select rounded-3" required>
                                    <option value="" disabled selected>Escoja un producto</option>
                                    @foreach ($products as $producto)
                                        <option value="{{ $producto->id }}">
                                            {{ $producto->name }} (Stock actual: {{ $producto->amount }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
                            <a href="{{ route('movimientos.index') }}" class="btn btn-outline-secondary px-4 rounded-3 order-2 order-sm-1">
                                <i class="bi bi-arrow-left me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary px-4 rounded-3 order-1 order-sm-2 shadow-sm">
                                <i class="bi bi-check-lg me-1"></i> Registrar Movimiento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
