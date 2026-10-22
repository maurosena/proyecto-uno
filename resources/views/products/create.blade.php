@extends('layout.layout')
@section('title', 'Agregar Producto')
@section('content')

<div class="container-fluid px-0">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white py-3 px-4">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="bi bi-box-seam"></i> Registrar Nuevo Producto
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('productos.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label for="code" class="form-label fw-semibold small text-secondary">Código del Producto</label>
                                <input type="text" name="code" id="code" class="form-control rounded-3" placeholder="Ej: PROD-001" required value="{{ old('code') }}">
                            </div>

                            <div class="col-12 col-sm-6">
                                <label for="name" class="form-label fw-semibold small text-secondary">Nombre del Producto</label>
                                <input type="text" name="name" id="name" class="form-control rounded-3" placeholder="Ej: Portátil Gamer" required value="{{ old('name') }}">
                            </div>

                            <div class="col-12 col-sm-6">
                                <label for="amount" class="form-label fw-semibold small text-secondary">Cantidad Inicial</label>
                                <input type="number" min="0" name="amount" id="amount" class="form-control rounded-3" placeholder="Ej: 50" required value="{{ old('amount') }}">
                            </div>

                            <div class="col-12 col-sm-6">
                                <label for="unit" class="form-label fw-semibold small text-secondary">Unidad de Medida</label>
                                <select class="form-select rounded-3" name="unit" id="unit" required>
                                    <option value="" disabled selected>Seleccione una unidad</option>
                                    <option value="Und" {{ old('unit') == 'Und' ? 'selected' : '' }}>Und (Unidad)</option>
                                    <option value="Kg" {{ old('unit') == 'Kg' ? 'selected' : '' }}>Kg (Kilogramo)</option>
                                    <option value="Gr" {{ old('unit') == 'Gr' ? 'selected' : '' }}>Gr (Gramo)</option>
                                    <option value="Pack" {{ old('unit') == 'Pack' ? 'selected' : '' }}>Pack (Paquete)</option>
                                    <option value="Lb" {{ old('unit') == 'Lb' ? 'selected' : '' }}>Lb (Libra)</option>
                                </select>
                            </div>

                            <div class="col-12 col-sm-6">
                                <label for="price" class="form-label fw-semibold small text-secondary">Precio Unitario ($)</label>
                                <input type="number" min="0" step="any" name="price" id="price" class="form-control rounded-3" placeholder="Ej: 250000" required value="{{ old('price') }}">
                            </div>

                            <div class="col-12 col-sm-6">
                                <label for="provider_id" class="form-label fw-semibold small text-secondary">Proveedor Asignado</label>
                                <select name="provider_id" id="provider_id" class="form-select rounded-3">
                                    <option value="" selected>Sin proveedor asignado</option>
                                    @foreach ($providers as $provider)
                                        <option value="{{ $provider->id }}" {{ old('provider_id') == $provider->id ? 'selected' : '' }}>
                                            {{ $provider->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
                            <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary px-4 rounded-3 order-2 order-sm-1">
                                <i class="bi bi-arrow-left me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary px-4 rounded-3 order-1 order-sm-2 shadow-sm">
                                <i class="bi bi-check-lg me-1"></i> Guardar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
