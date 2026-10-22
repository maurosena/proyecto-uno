@extends('layout.layout')
@section('title', 'Manual de Usuario - InvStock Pro')

@section('content')

<div class="container-fluid px-0 manual-container">
    <!-- BARRA SUPERIOR DEL MANUAL: Título, Buscador en tiempo real y Botón de Impresión -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden bg-white">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">
                <div class="col-12 col-lg-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="brand-icon-box text-white fs-3" style="width: 52px; height: 52px; min-width: 52px;">
                            <i class="bi bi-book-half"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold text-dark mb-1">Manual de Usuario & Documentación</h3>
                            <p class="text-muted small mb-0">Guía funcional completa del sistema InvStock Pro (v1.0.0)</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-lg-end gap-2">
                        <!-- Buscador en tiempo real -->
                        <div class="input-group search-input-group flex-grow-1" style="max-width: 360px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" id="manualSearch" class="form-control bg-light border-start-0"
                                placeholder="Buscar en el manual (ej: stock, salida, pdf)..."
                                aria-label="Buscar en el manual">
                            <button class="btn btn-light border d-none" type="button" id="clearSearchBtn">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>

                        <!-- Botón Imprimir / PDF -->
                        <button type="button" onclick="window.print()" class="btn btn-outline-primary d-inline-flex align-items-center justify-content-center gap-2 shadow-sm print-manual-btn">
                            <i class="bi bi-printer"></i>
                            <span>Imprimir / PDF</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CUERPO PRINCIPAL DEL MANUAL: Navegación Lateral Sticky y Contenido -->
    <div class="row g-4">
        <!-- NAVEGACIÓN RÁPIDA / TABLA DE CONTENIDOS (Columna izquierda) -->
        <div class="col-12 col-lg-3 d-none d-lg-block">
            <div class="card border-0 shadow-sm rounded-4 sticky-top manual-sidebar-toc" style="top: 85px; z-index: 1020;">
                <div class="card-header bg-white py-3 px-3 border-bottom">
                    <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-list-nested text-primary"></i> Tabla de Contenidos
                    </h6>
                </div>
                <div class="card-body p-2 manual-toc-nav" style="max-height: calc(100vh - 180px); overflow-y: auto;">
                    <nav class="nav nav-pills flex-column gap-1">
                        <a class="nav-link py-2 px-3 small rounded-3 active" href="#cap-1">
                            <i class="bi bi-bookmark-star me-2 text-primary"></i>1. Portada y Generalidades
                        </a>
                        <a class="nav-link py-2 px-3 small rounded-3" href="#cap-2">
                            <i class="bi bi-info-circle me-2 text-info"></i>2. Introducción y Objetivos
                        </a>
                        <a class="nav-link py-2 px-3 small rounded-3" href="#cap-3">
                            <i class="bi bi-door-open me-2 text-success"></i>3. Acceso y Navegación
                        </a>
                        <a class="nav-link py-2 px-3 small rounded-3" href="#cap-4">
                            <i class="bi bi-speedometer2 me-2 text-warning"></i>4. Módulo Dashboard
                        </a>
                        <a class="nav-link py-2 px-3 small rounded-3" href="#cap-5">
                            <i class="bi bi-box-seam me-2 text-primary"></i>5. Módulo de Productos
                        </a>
                        <a class="nav-link py-2 px-3 small rounded-3" href="#cap-6">
                            <i class="bi bi-arrow-left-right me-2 text-danger"></i>6. Módulo de Movimientos
                        </a>
                        <a class="nav-link py-2 px-3 small rounded-3" href="#cap-7">
                            <i class="bi bi-truck me-2 text-secondary"></i>7. Módulo de Proveedores
                        </a>
                        <a class="nav-link py-2 px-3 small rounded-3" href="#cap-8">
                            <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>8. Reportes y Exportación PDF
                        </a>
                        <a class="nav-link py-2 px-3 small rounded-3" href="#cap-9">
                            <i class="bi bi-question-circle me-2 text-warning"></i>9. Preguntas Frecuentes
                        </a>
                        <a class="nav-link py-2 px-3 small rounded-3" href="#cap-10">
                            <i class="bi bi-tools me-2 text-dark"></i>10. Solución de Problemas
                        </a>
                        <a class="nav-link py-2 px-3 small rounded-3" href="#cap-11">
                            <i class="bi bi-spellcheck me-2 text-info"></i>11. Glosario de Términos
                        </a>
                        <a class="nav-link py-2 px-3 small rounded-3" href="#cap-12">
                            <i class="bi bi-shield-check me-2 text-success"></i>12. Buenas Prácticas
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- CONTENIDO DETALLADO DE LOS CAPÍTULOS (Columna central/derecha) -->
        <div class="col-12 col-lg-9">
            <div id="manualContentArea" class="d-flex flex-column gap-4">

                <!-- CAPÍTULO 1: PORTADA Y GENERALIDADES -->
                <section id="cap-1" class="manual-section card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0b1324 0%, #1d4ed8 100%);">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-white bg-opacity-25 text-white px-3 py-1 rounded-pill small">Capítulo 1</span>
                            <span class="text-white-50 small"><i class="bi bi-calendar3 me-1"></i> Actualizado: Octubre 2026</span>
                        </div>
                        <h4 class="fw-bold mb-1">InvStock Pro — Manual Oficial de Usuario</h4>
                        <p class="text-white-50 mb-0 small">Guía técnica y funcional para la administración integral de existencias, almacenes y proveedores.</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="p-3 bg-light rounded-3 text-center border">
                                    <span class="text-muted small d-block mb-1">Aplicación</span>
                                    <strong class="text-dark">InvStock Pro</strong>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="p-3 bg-light rounded-3 text-center border">
                                    <span class="text-muted small d-block mb-1">Versión del Sistema</span>
                                    <strong class="text-primary">1.0.0 Stable</strong>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="p-3 bg-light rounded-3 text-center border">
                                    <span class="text-muted small d-block mb-1">Tecnología Base</span>
                                    <strong class="text-dark">Laravel 13 & PHP 8.3</strong>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="p-3 bg-light rounded-3 text-center border">
                                    <span class="text-muted small d-block mb-1">Compatibilidad</span>
                                    <strong class="text-success"><i class="bi bi-check-all"></i> Multiplataforma</strong>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-primary bg-primary bg-opacity-10 border-primary border-opacity-25 rounded-3 mt-4 mb-0 d-flex align-items-start gap-3">
                            <i class="bi bi-info-circle-fill text-primary fs-4 mt-1"></i>
                            <div>
                                <h6 class="fw-bold text-primary mb-1">Propósito del Manual</h6>
                                <p class="mb-0 small text-secondary">
                                    Este documento está diseñado para guiar a los usuarios en las tareas diarias de operación del sistema sin necesidad de conocimientos de programación. Explica los flujos paso a paso, validaciones de seguridad, control de inventario y resolución de incidencias.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- CAPÍTULO 2: INTRODUCCIÓN Y OBJETIVOS -->
                <section id="cap-2" class="manual-section card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2 py-1 rounded-pill small">Capítulo 2</span>
                            <h5 class="fw-bold mb-0 text-dark">Introducción y Objetivos de la Aplicación</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-secondary">
                            <strong>InvStock Pro</strong> es una plataforma web desarrollada para simplificar y blindar el control de existencias en tiempo real dentro de almacenes, puntos de venta y centros de distribución.
                        </p>

                        <h6 class="fw-bold text-dark mt-4 mb-3">Problemas que resuelve:</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start gap-3 p-3 bg-light rounded-3 border h-100">
                                    <div class="badge-icon-box text-danger bg-danger bg-opacity-10">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </div>
                                    <div>
                                        <strong class="d-block text-dark mb-1">Evita el desabastecimiento imprevisto</strong>
                                        <span class="text-muted small">El sistema supervisa umbrales críticos de stock (<= 5 y <= 10 unidades) alertando oportunamente para evitar pérdidas de venta.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start gap-3 p-3 bg-light rounded-3 border h-100">
                                    <div class="badge-icon-box text-warning bg-warning bg-opacity-10">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </div>
                                    <div>
                                        <strong class="d-block text-dark mb-1">Trazabilidad de movimientos</strong>
                                        <span class="text-muted small">Cada entrada, salida o devolución queda registrada con su caja de origen, cantidad y fecha exacta.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start gap-3 p-3 bg-light rounded-3 border h-100">
                                    <div class="badge-icon-box text-success bg-success bg-opacity-10">
                                        <i class="bi bi-shield-lock-fill"></i>
                                    </div>
                                    <div>
                                        <strong class="d-block text-dark mb-1">Integridad matemática y prevención de errores</strong>
                                        <span class="text-muted small">No es posible despachar más unidades de las existentes en inventario, evitando saldos negativos.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start gap-3 p-3 bg-light rounded-3 border h-100">
                                    <div class="badge-icon-box text-primary bg-primary bg-opacity-10">
                                        <i class="bi bi-file-earmark-pdf-fill"></i>
                                    </div>
                                    <div>
                                        <strong class="d-block text-dark mb-1">Reportes instantáneos</strong>
                                        <span class="text-muted small">Generación automática de fichas de producto en PDF para inventario físico y auditoría.</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="fw-bold text-dark mb-2">Público Destinatario y Roles:</h6>
                        <ul class="text-secondary small mb-3">
                            <li><strong>Jefe de Bodega / Almacén:</strong> Supervisa el stock global, genera reportes y aprueba ingresos.</li>
                            <li><strong>Operador de Caja / Despachador:</strong> Registra movimientos diarios de salida o devoluciones en su punto de venta asignado.</li>
                            <li><strong>Área de Compras:</strong> Consulta productos críticos y gestiona el directorio de proveedores.</li>
                        </ul>
                    </div>
                </section>

                <!-- CAPÍTULO 3: ACCESO Y NAVEGACIÓN -->
                <section id="cap-3" class="manual-section card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill small">Capítulo 3</span>
                            <h5 class="fw-bold mb-0 text-dark">Acceso, Navegación y Entorno Visual</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-secondary">
                            La aplicación está diseñada con una arquitectura ligera de acceso web. La navegación se realiza a través de la <strong>Navbar Lateral Fija (Sidebar)</strong> y la <strong>Barra Superior (Topbar)</strong>.
                        </p>

                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-sm align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Elemento</th>
                                        <th>Ubicación</th>
                                        <th>Función Principal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Sidebar Fijo</strong></td>
                                        <td>Lateral izquierdo</td>
                                        <td>Menú principal persistente con acceso a todos los módulos funcionales.</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Botón Colapsar / Expandir</strong></td>
                                        <td>Cabecera Sidebar / Topbar</td>
                                        <td>Alterna el menú lateral entre modo expandido y modo iconos compactos (o menú flotante en móviles).</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Topbar Sticky</strong></td>
                                        <td>Parte superior</td>
                                        <td>Muestra el título de la página activa, fecha del sistema y botón de acceso rápido.</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Área de Trabajo</strong></td>
                                        <td>Centro / Derecha</td>
                                        <td>Espacio donde se despliegan las tablas, tarjetas de métricas y formularios.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="alert alert-warning bg-warning bg-opacity-10 border-warning border-opacity-25 rounded-3 d-flex align-items-center gap-2 mb-0">
                            <i class="bi bi-lightbulb-fill text-warning fs-5"></i>
                            <span class="small text-dark">
                                <strong>Consejo de uso en móviles:</strong> Al abrir el sistema desde un celular o tablet, toque el botón <i class="bi bi-list"></i> en la parte superior izquierda para abrir el menú, y toque fuera de él o presione <kbd>Esc</kbd> para cerrarlo.
                            </span>
                        </div>
                    </div>
                </section>

                <!-- CAPÍTULO 4: MÓDULO DASHBOARD -->
                <section id="cap-4" class="manual-section card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-2 py-1 rounded-pill small">Capítulo 4</span>
                            <h5 class="fw-bold mb-0 text-dark">Módulo Dashboard (Panel de Control)</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-secondary">
                            El <strong>Dashboard</strong> es el centro neurálgico de información. Permite una vista panorámica instantánea del estado de los inventarios clasificados por niveles de criticidad.
                        </p>

                        <h6 class="fw-bold text-dark mt-3 mb-2">Clasificación de Tarjetas Métricas:</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="card bg-dark text-white p-3 rounded-3 text-center">
                                    <i class="bi bi-boxes fs-3 mb-1"></i>
                                    <span class="small text-white-50">Total Productos</span>
                                    <p class="small mb-0">Suma total de referencias activas en el catálogo.</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="card bg-danger text-white p-3 rounded-3 text-center">
                                    <i class="bi bi-exclamation-octagon-fill fs-3 mb-1"></i>
                                    <span class="small text-white-50">Stock Crítico</span>
                                    <p class="small mb-0"><strong>Existencias &le; 5</strong> unidades. Urgencia de reposición.</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="card bg-warning text-dark p-3 rounded-3 text-center">
                                    <i class="bi bi-exclamation-triangle-fill fs-3 mb-1"></i>
                                    <span class="small text-muted">Stock Medio</span>
                                    <p class="small mb-0"><strong>Entre 6 y 30</strong> unidades. Nivel de precaución.</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="card bg-success text-white p-3 rounded-3 text-center">
                                    <i class="bi bi-check-circle-fill fs-3 mb-1"></i>
                                    <span class="small text-white-50">Stock Normal</span>
                                    <p class="small mb-0"><strong>Más de 30</strong> unidades. Existencia en nivel óptimo.</p>
                                </div>
                            </div>
                        </div>

                        <h6 class="fw-bold text-dark mb-2">Tabla de Productos con Stock Crítico:</h6>
                        <p class="text-secondary small">
                            En la parte inferior del Dashboard se lista únicamente el detalle de los productos que tienen <strong>5 o menos existencias</strong>. Esta tabla sirve como lista de compras prioritaria para contactar de inmediato al proveedor asignado.
                        </p>
                    </div>
                </section>

                <!-- CAPÍTULO 5: MÓDULO DE PRODUCTOS -->
                <section id="cap-5" class="manual-section card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1 rounded-pill small">Capítulo 5</span>
                            <h5 class="fw-bold mb-0 text-dark">Módulo de Productos (Catálogo y Operaciones CRUD)</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-secondary">
                            Este módulo gestiona la creación, consulta, edición, eliminación y exportación de productos. Se accede desde el menú lateral en la opción <strong>Productos</strong>.
                        </p>

                        <!-- Pestañas de Procedimientos paso a paso -->
                        <div class="card border rounded-3 p-3 mb-4 bg-light">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="bi bi-plus-circle me-1"></i> Procedimiento 1: Crear un Nuevo Producto
                            </h6>
                            <ol class="small text-secondary ps-3 mb-3">
                                <li>Haga clic en el botón <strong>"Agregar Producto"</strong> en la esquina superior derecha o en la Topbar.</li>
                                <li>Complete los campos obligatorios del formulario según las especificaciones técnicas:</li>
                            </ol>

                            <div class="table-responsive mb-3">
                                <table class="table table-bordered table-sm bg-white">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Campo</th>
                                            <th>Tipo de Dato</th>
                                            <th>Obligatorio</th>
                                            <th>Descripción / Ejemplo</th>
                                        </tr>
                                    </thead>
                                    <tbody class="small">
                                        <tr>
                                            <td><strong>Código</strong></td>
                                            <td>Texto alfanumérico</td>
                                            <td><span class="badge bg-danger">Sí</span></td>
                                            <td>Identificador único del artículo. Ej: <code>PROD-001</code>.</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nombre</strong></td>
                                            <td>Texto</td>
                                            <td><span class="badge bg-danger">Sí</span></td>
                                            <td>Denominación comercial del producto. Ej: <code>Laptop Gamer HP</code>.</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Cantidad Inicial</strong></td>
                                            <td>Numérico entero (&ge; 0)</td>
                                            <td><span class="badge bg-danger">Sí</span></td>
                                            <td>Saldo inicial de stock disponible al registrarlo.</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Unidad de Medida</strong></td>
                                            <td>Selección de lista</td>
                                            <td><span class="badge bg-danger">Sí</span></td>
                                            <td>Opciones: <code>Und</code>, <code>Kg</code>, <code>Gr</code>, <code>Pack</code>, <code>Lb</code>.</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Precio Unitario</strong></td>
                                            <td>Numérico decimal/entero</td>
                                            <td><span class="badge bg-danger">Sí</span></td>
                                            <td>Precio unitario de venta. Ej: <code>2500000</code>.</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Proveedor</strong></td>
                                            <td>Selección de lista</td>
                                            <td><span class="badge bg-secondary">Opcional</span></td>
                                            <td>Seleccione el proveedor comercial que suministra el artículo.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <ol start="3" class="small text-secondary ps-3 mb-0">
                                <li>Haga clic en <strong>"Guardar Producto"</strong>. El sistema validará los campos y lo redirigirá al listado principal.</li>
                            </ol>
                        </div>

                        <!-- Procedimientos de consulta y acciones -->
                        <h6 class="fw-bold text-dark mt-4 mb-2">Botones de Acción en la Tabla de Productos:</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Botón / Icono</th>
                                        <th>Acción</th>
                                        <th>Descripción del Funcionamiento</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    <tr>
                                        <td><button class="btn btn-outline-info btn-sm"><i class="bi bi-eye"></i></button></td>
                                        <td><strong>Ver Detalle (Modal)</strong></td>
                                        <td>Abre una ventana emergente instantánea con toda la ficha técnica (código, nombre, stock, precio formateado y proveedor) sin recargar la página.</td>
                                    </tr>
                                    <tr>
                                        <td><button class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil-square"></i></button></td>
                                        <td><strong>Editar Producto</strong></td>
                                        <td>Permite modificar los datos del producto (código, nombre, precio, proveedor). Al guardar, se actualiza el registro de inmediato.</td>
                                    </tr>
                                    <tr>
                                        <td><button class="btn btn-outline-secondary btn-sm"><i class="bi bi-file-earmark-pdf"></i></button></td>
                                        <td><strong>Ficha PDF</strong></td>
                                        <td>Abre en una nueva pestaña el documento oficial en formato PDF para imprimir o archivar.</td>
                                    </tr>
                                    <tr>
                                        <td><button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button></td>
                                        <td><strong>Eliminar Producto</strong></td>
                                        <td>Solicita confirmación mediante alerta de seguridad. Utiliza <em>SoftDeletes</em> (borrado lógico), preservando la integridad del historial de movimientos.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- CAPÍTULO 6: MÓDULO DE MOVIMIENTOS -->
                <section id="cap-6" class="manual-section card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill small">Capítulo 6</span>
                            <h5 class="fw-bold mb-0 text-dark">Módulo de Movimientos (Entradas, Salidas y Devoluciones)</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-secondary">
                            El módulo de <strong>Movimientos</strong> audita y modifica dinámicamente las cantidades de inventario. Cada transacción afecta directamente el saldo disponible del producto.
                        </p>

                        <h6 class="fw-bold text-dark mt-3 mb-2">Tipos de Movimiento Soportados:</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-4">
                                <div class="p-3 border rounded-3 bg-light h-100">
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill mb-2">
                                        <i class="bi bi-box-arrow-in-down"></i> ENTRADA
                                    </span>
                                    <strong class="d-block text-dark mb-1">Ingreso de Mercancía</strong>
                                    <p class="small text-muted mb-0"><strong>Suma</strong> automáticamente la cantidad al stock del producto. Usado para compras y recepciones.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="p-3 border rounded-3 bg-light h-100">
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill mb-2">
                                        <i class="bi bi-box-arrow-up-right"></i> SALIDA
                                    </span>
                                    <strong class="d-block text-dark mb-1">Despacho o Venta</strong>
                                    <p class="small text-muted mb-0"><strong>Resta</strong> la cantidad del producto. Cuenta con validación estricta de existencias suficientes.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="p-3 border rounded-3 bg-light h-100">
                                    <span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-2 py-1 rounded-pill mb-2">
                                        <i class="bi bi-arrow-repeat"></i> DEVOLUCIÓN
                                    </span>
                                    <strong class="d-block text-dark mb-1">Retorno a Almacén</strong>
                                    <p class="small text-muted mb-0"><strong>Reintegra</strong> la cantidad devuelta sumándola nuevamente al inventario del producto.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Regla de Validación de Salida -->
                        <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-25 rounded-3 d-flex align-items-start gap-3 mb-4">
                            <i class="bi bi-shield-slash-fill text-danger fs-4 mt-1"></i>
                            <div>
                                <h6 class="fw-bold text-danger mb-1">Regla de Negocio Crítica (Validación de Salida):</h6>
                                <p class="small text-secondary mb-0">
                                    Si un usuario intenta registrar una <strong>Salida</strong> por una cantidad mayor al saldo actual en inventario, el sistema rechaza la operación, cancela la transacción en la base de datos (<code>DB::rollBack()</code>) y emite el mensaje: <br>
                                    <strong class="text-danger">"La cantidad solicitada es mayor a la cantidad de inventario"</strong>.
                                </p>
                            </div>
                        </div>

                        <h6 class="fw-bold text-dark mb-2">Sistema Automático de Alerta de Stock Bajo:</h6>
                        <p class="text-secondary small mb-0">
                            Cada vez que una salida o modificación deja a un producto con <strong>10 unidades o menos</strong>, el sistema activa automáticamente un semáforo visual de campana roja (<i class="bi bi-bell-fill text-danger"></i>) y despacha una notificación por correo electrónico institucional al administrador.
                        </p>
                    </div>
                </section>

                <!-- CAPÍTULO 7: MÓDULO DE PROVEEDORES -->
                <section id="cap-7" class="manual-section card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1 rounded-pill small">Capítulo 7</span>
                            <h5 class="fw-bold mb-0 text-dark">Módulo de Proveedores (Directorio Comercial)</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-secondary">
                            El módulo de <strong>Proveedores</strong> administra las relaciones comerciales con las entidades que distribuyen los productos.
                        </p>

                        <div class="table-responsive mb-3">
                            <table class="table table-bordered table-sm align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Dato del Proveedor</th>
                                        <th>Propósito</th>
                                        <th>Comportamiento en el Sistema</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    <tr>
                                        <td><strong>NIT / Documento</strong></td>
                                        <td>Identificación tributaria</td>
                                        <td>Debe ser único en el sistema para evitar duplicidad de proveedores.</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Razón Social / Nombre</strong></td>
                                        <td>Nombre de la empresa</td>
                                        <td>Aparece en los desplegables de selección al crear o editar productos.</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Teléfono y Correo</strong></td>
                                        <td>Canales de contacto directo</td>
                                        <td>Permiten comunicación inmediata ante alertas de stock crítico.</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Productos Vinculados</strong></td>
                                        <td>Conteo automático</td>
                                        <td>Muestra cuántas referencias del catálogo suministra actualmente el proveedor.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- CAPÍTULO 8: REPORTES Y EXPORTACIÓN PDF -->
                <section id="cap-8" class="manual-section card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill small">Capítulo 8</span>
                            <h5 class="fw-bold mb-0 text-dark">Reportes y Exportación en Formato PDF</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-secondary">
                            La aplicación incorpora el motor de renderizado <strong>DomPDF</strong> para la emisión de reportes técnicos oficiales.
                        </p>

                        <div class="card border rounded-3 p-3 bg-light mb-3">
                            <h6 class="fw-bold text-dark mb-2">Cómo Generar la Ficha Técnica de un Producto:</h6>
                            <ol class="small text-secondary ps-3 mb-2">
                                <li>Vaya al módulo <strong>Productos</strong> en el menú lateral.</li>
                                <li>Ubique el producto que desea auditar en la tabla.</li>
                                <li>Haga clic en el botón de PDF (<i class="bi bi-file-earmark-pdf text-danger"></i>).</li>
                                <li>El sistema abrirá en una pestaña nueva el documento con cabecera institucional, fecha y hora de emisión, código, nombre, cantidad actual, unidad de medida, precio y proveedor asignado.</li>
                            </ol>
                        </div>
                    </div>
                </section>

                <!-- CAPÍTULO 9: PREGUNTAS FRECUENTES (FAQ) -->
                <section id="cap-9" class="manual-section card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-2 py-1 rounded-pill small">Capítulo 9</span>
                            <h5 class="fw-bold mb-0 text-dark">Preguntas Frecuentes (FAQ)</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item border rounded-3 mb-2">
                                <h2 class="accordion-header" id="faqHeading1">
                                    <button class="accordion-button collapsed fw-semibold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1">
                                        ¿Por qué el sistema no me permite registrar una salida de inventario?
                                    </button>
                                </h2>
                                <div id="faqCollapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body small text-secondary">
                                        El sistema valida que la cantidad a retirar no supere las existencias físicas registradas. Si intenta retirar por ejemplo 15 unidades de un producto que solo cuenta con 10, la transacción se cancelará y aparecerá un mensaje de alerta rojo en la parte superior. Verifique el saldo actual antes de solicitar el egreso.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border rounded-3 mb-2">
                                <h2 class="accordion-header" id="faqHeading2">
                                    <button class="accordion-button collapsed fw-semibold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2">
                                        ¿Qué significa la campana roja que aparece al lado de la cantidad?
                                    </button>
                                </h2>
                                <div id="faqCollapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body small text-secondary">
                                        Es un indicador visual de alerta de existencias. En el catálogo indica productos con cantidades inferiores a 100 unidades, y en movimientos indica existencias críticas inferiores o iguales a 10 unidades para proceder a su reaprovisionamiento.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border rounded-3 mb-2">
                                <h2 class="accordion-header" id="faqHeading3">
                                    <button class="accordion-button collapsed fw-semibold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3">
                                        ¿Qué sucede si elimino un producto por error?
                                    </button>
                                </h2>
                                <div id="faqCollapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body small text-secondary">
                                        El sistema utiliza <em>SoftDeletes</em> (borrado lógico). El producto se oculta de la interfaz activa pero sus datos permanecen intactos en la base de datos para no alterar los reportes históricos ni los movimientos previos. Un administrador puede restaurarlo si es necesario.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border rounded-3">
                                <h2 class="accordion-header" id="faqHeading4">
                                    <button class="accordion-button collapsed fw-semibold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4">
                                        ¿Cómo descargo este manual de usuario en formato PDF o para imprimir?
                                    </button>
                                </h2>
                                <div id="faqCollapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body small text-secondary">
                                        Haga clic en el botón <strong>"Imprimir / PDF"</strong> ubicado en la parte superior derecha de esta página o presione el atajo de teclado <kbd>Ctrl + P</kbd> (en Windows/Linux) o <kbd>Cmd + P</kbd> (en Mac). Seleccione "Guardar como PDF" como impresora de destino.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- CAPÍTULO 10: SOLUCIÓN DE PROBLEMAS (TROUBLESHOOTING) -->
                <section id="cap-10" class="manual-section card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-dark text-white px-2 py-1 rounded-pill small">Capítulo 10</span>
                            <h5 class="fw-bold mb-0 text-dark">Solución de Problemas (Troubleshooting)</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 30%;">Problema Observado</th>
                                        <th style="width: 35%;">Causa Probable</th>
                                        <th style="width: 35%;">Solución Recomendada</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    <tr>
                                        <td class="text-danger fw-semibold">Error al guardar un producto</td>
                                        <td>El código ingresado ya existe o faltan campos obligatorios.</td>
                                        <td>Verifique que el código no esté repetido y que todos los campos requeridos estén diligenciados.</td>
                                    </tr>
                                    <tr>
                                        <td class="text-danger fw-semibold">Alerta roja: "La cantidad solicitada es mayor..."</td>
                                        <td>Se intenta registrar una salida por encima del inventario real.</td>
                                        <td>Consulte el stock actual en el catálogo y ajuste la cantidad del despacho.</td>
                                    </tr>
                                    <tr>
                                        <td class="text-danger fw-semibold">El menú lateral no se visualiza completo en el móvil</td>
                                        <td>La resolución es pequeña y el menú está colapsado por defecto.</td>
                                        <td>Toque el botón de menú <i class="bi bi-list"></i> en la barra superior para desplegar el panel flotante.</td>
                                    </tr>
                                    <tr>
                                        <td class="text-danger fw-semibold">No se genera el archivo PDF</td>
                                        <td>El navegador tiene bloqueadas las ventanas emergentes (pop-ups).</td>
                                        <td>Permita las ventanas emergentes para la dirección del sistema en la barra de direcciones del navegador.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- CAPÍTULO 11: GLOSARIO DE TÉRMINOS -->
                <section id="cap-11" class="manual-section card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2 py-1 rounded-pill small">Capítulo 11</span>
                            <h5 class="fw-bold mb-0 text-dark">Glosario de Términos del Sistema</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <div class="p-3 bg-light rounded-3 border h-100">
                                    <strong class="text-dark d-block mb-1">Stock / Existencias</strong>
                                    <span class="text-secondary small">Cantidad física y real de artículos disponibles en bodega listos para comercialización o consumo.</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="p-3 bg-light rounded-3 border h-100">
                                    <strong class="text-dark d-block mb-1">Movimiento de Inventario</strong>
                                    <span class="text-secondary small">Transacción que modifica el balance de existencias por concepto de Entrada, Salida o Devolución.</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="p-3 bg-light rounded-3 border h-100">
                                    <strong class="text-dark d-block mb-1">SoftDeletes (Borrado Lógico)</strong>
                                    <span class="text-secondary small">Mecanismo de seguridad que oculta un registro sin destruirlo físicamente de la base de datos para no romper históricos.</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="p-3 bg-light rounded-3 border h-100">
                                    <strong class="text-dark d-block mb-1">Punto de Venta / Caja</strong>
                                    <span class="text-secondary small">Ubicación física o terminal desde donde se realiza la operación del movimiento (Caja 1, Caja 2, Caja 3).</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- CAPÍTULO 12: BUENAS PRÁCTICAS Y SEGURIDAD -->
                <section id="cap-12" class="manual-section card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill small">Capítulo 12</span>
                            <h5 class="fw-bold mb-0 text-dark">Buenas Prácticas y Seguridad de la Información</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <div class="p-3 border rounded-3 bg-light h-100 text-center">
                                    <i class="bi bi-shield-check text-success fs-1 d-block mb-2"></i>
                                    <strong class="text-dark d-block mb-1">Verificación de Cantidades</strong>
                                    <p class="small text-muted mb-0">Confirme físicamente las cantidades recibidas o entregadas antes de registrar movimientos en el sistema.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="p-3 border rounded-3 bg-light h-100 text-center">
                                    <i class="bi bi-person-badge text-primary fs-1 d-block mb-2"></i>
                                    <strong class="text-dark d-block mb-1">Responsabilidad de Terminal</strong>
                                    <p class="small text-muted mb-0">Cada operador debe registrar operaciones únicamente en la caja asignada a su turno laboral.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="p-3 border rounded-3 bg-light h-100 text-center">
                                    <i class="bi bi-printer text-info fs-1 d-block mb-2"></i>
                                    <strong class="text-dark d-block mb-1">Auditoría Periódica</strong>
                                    <p class="small text-muted mb-0">Genere reportes PDF periódicamente para contrastar con inventarios físicos de fin de mes.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <!-- BOTÓN FLOTANTE "VOLVER ARRIBA" -->
    <button type="button" id="backToTopBtn" class="btn btn-primary shadow-lg rounded-circle"
            title="Volver al inicio del manual" aria-label="Volver arriba">
        <i class="bi bi-arrow-up"></i>
    </button>
</div>

<!-- ESTILOS ESPECÍFICOS PARA EL MANUAL Y MODO IMPRESIÓN -->
<style>
.manual-toc-nav .nav-link {
    color: #475569;
    font-weight: 500;
    transition: all 0.2s ease;
}
.manual-toc-nav .nav-link:hover {
    background-color: #eff6ff;
    color: #2563eb;
    transform: translateX(3px);
}
.manual-toc-nav .nav-link.active {
    background-color: #2563eb !important;
    color: #ffffff !important;
    font-weight: 600;
}
.manual-toc-nav .nav-link.active i {
    color: #ffffff !important;
}

#backToTopBtn {
    position: fixed;
    bottom: 25px;
    right: 25px;
    width: 46px;
    height: 46px;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    z-index: 1050;
    transition: transform 0.2s ease, opacity 0.2s ease;
}
#backToTopBtn:hover {
    transform: scale(1.1);
}

/* ESTILOS PARA IMPRESIÓN LIMPIA (Guardar como PDF) */
@media print {
    #sidebar,
    .sidebar-overlay,
    .topbar,
    .manual-sidebar-toc,
    .search-input-group,
    .print-manual-btn,
    #backToTopBtn {
        display: none !important;
    }

    #main-wrapper {
        margin-left: 0 !important;
        padding: 0 !important;
    }

    .content-area {
        padding: 0 !important;
    }

    .manual-section {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
        page-break-inside: avoid;
        margin-bottom: 25px !important;
    }

    .accordion-collapse {
        display: block !important;
    }
}
</style>

<!-- SCRIPT DE INTERACTIVIDAD: Búsqueda en tiempo real, Scroll Spy y Botón Arriba -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('manualSearch');
    const clearBtn = document.getElementById('clearSearchBtn');
    const sections = document.querySelectorAll('.manual-section');
    const backToTopBtn = document.getElementById('backToTopBtn');
    const tocLinks = document.querySelectorAll('.manual-toc-nav .nav-link');

    // 1. Buscador en tiempo real de temas en el manual
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();

            if (query.length > 0) {
                clearBtn.classList.remove('d-none');
            } else {
                clearBtn.classList.add('d-none');
            }

            sections.forEach(section => {
                const text = section.innerText.toLowerCase();
                if (text.includes(query)) {
                    section.classList.remove('d-none');
                } else {
                    section.classList.add('d-none');
                }
            });
        });

        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
                searchInput.focus();
            });
        }
    }

    // 2. Botón Volver Arriba
    window.addEventListener('scroll', function () {
        if (window.scrollY > 300) {
            backToTopBtn.style.display = 'flex';
        } else {
            backToTopBtn.style.display = 'none';
        }

        // Resaltar elemento activo en la tabla de contenidos
        let currentSectionId = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 120;
            if (window.scrollY >= sectionTop) {
                currentSectionId = section.getAttribute('id');
            }
        });

        if (currentSectionId) {
            tocLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + currentSectionId) {
                    link.classList.add('active');
                }
            });
        }
    });

    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});
</script>

@endsection
