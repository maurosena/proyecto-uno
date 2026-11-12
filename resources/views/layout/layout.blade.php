<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#0b1324">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Sistema de Gestión de Inventario')</title>

    <!-- Bootstrap 5 CSS -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons (contexto de la aplicación) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Font Awesome (compatibilidad con vistas existentes) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Estilos personalizados para Navbar / Sidebar lateral fijo y responsividad -->
    <link rel="stylesheet" href="'./css/sidebar.css'">

</head>

<body>
    <!-- Overlay para dispositivos móviles al abrir el menú lateral -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- NAVBAR / SIDEBAR FIJO A LA IZQUIERDA -->
    <aside id="sidebar" aria-label="Navegación Principal">
        <!-- Encabezado / Branding -->
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand" title="Sistema de Inventario">
                <div class="brand-icon-box">
                    <i class="bi bi-boxes"></i>
                </div>
                <div class="brand-details">
                    <span class="brand-title">InvStock Pro</span>
                    <span class="brand-badge">Control & Logística</span>
                </div>
            </a>
            <button type="button" class="sidebar-toggle-btn d-none d-lg-flex" id="sidebarCollapseBtn" title="Ocultar / Mostrar menú" aria-label="Colapsar menú">
                <i class="bi bi-layout-sidebar-inset" id="toggleIcon"></i>
            </button>
        </div>

        <!-- Cuerpo de Navegación con Iconos de Bootstrap -->
        <div class="sidebar-body">
            <span class="nav-section-title">Principal</span>

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="nav-item-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
               data-title="Dashboard">
                <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
                <span class="nav-text">Dashboard</span>
            </a>

            <span class="nav-section-title">Almacén & Existencias</span>

            <!-- Productos -->
            <a href="{{ route('productos.index') }}"
               class="nav-item-link {{ request()->routeIs('productos.*') ? 'active' : '' }}"
               data-title="Productos">
                <span class="nav-icon"><i class="bi bi-box-seam-fill"></i></span>
                <span class="nav-text">Productos</span>
                <span class="nav-pill-badge">Stock</span>
            </a>

            <!-- Movimientos -->
            <a href="{{ route('movimientos.index') }}"
               class="nav-item-link {{ request()->routeIs('movimientos.*') ? 'active' : '' }}"
               data-title="Movimientos">
                <span class="nav-icon"><i class="bi bi-arrow-left-right"></i></span>
                <span class="nav-text">Movimientos</span>
            </a>

            <span class="nav-section-title">Directorio</span>

            <!-- Proveedores -->
            <a href="{{ route('proveedores.index') }}"
               class="nav-item-link {{ request()->routeIs('proveedores.*') ? 'active' : '' }}"
               data-title="Proveedores">
                <span class="nav-icon"><i class="bi bi-truck"></i></span>
                <span class="nav-text">Proveedores</span>
            </a>

            <span class="nav-section-title">General</span>

            <!-- Home -->
            <a href="{{ route('home') }}"
               class="nav-item-link {{ request()->routeIs('home') ? 'active' : '' }}"
               data-title="Inicio">
                <span class="nav-icon"><i class="bi bi-house-door-fill"></i></span>
                <span class="nav-text">Inicio</span>
            </a>

            <span class="nav-section-title">Ayuda & Documentación</span>

            <!-- Manual de usuario -->
            <a href="{{ route('manual.index') }}"
               class="nav-item-link {{ request()->routeIs('manual.*') ? 'active' : '' }}"
               data-title="Manual de usuario">
                <span class="nav-icon"><i class="bi bi-journal-bookmark-fill"></i></span>
                <span class="nav-text">Manual de usuario</span>
                <span class="nav-pill-badge bg-info bg-opacity-25 text-info border-info border-opacity-50">Guía</span>
            </a>
        </div>

        <!-- Pie del Sidebar con Estado del Sistema -->
        <div class="sidebar-footer">
            <div class="system-status-card" title="Almacén central operativo">
                <span class="status-indicator"></span>
                <div class="status-info">
                    <span class="status-label">Servidor / Stock</span>
                    <span class="status-name">Almacén Central</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- ENVOLTORIO DEL CONTENIDO PRINCIPAL -->
    <div id="main-wrapper">
        <!-- Barra Superior (Topbar) con botón para Ocultar/Mostrar el Menú -->
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="topbar-toggle-btn" id="menuToggleBtn" title="Ocultar / Mostrar menú" aria-label="Alternar menú">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="topbar-title h5 mb-0">@yield('title', 'Panel de Control')</h1>
            </div>

            <div class="topbar-actions">
                <span class="badge bg-light text-dark border px-3 py-2 d-none d-sm-inline-flex align-items-center gap-2">
                    <i class="bi bi-calendar3 text-primary"></i>
                    {{ now()->translatedFormat('d M, Y') }}
                </span>
                <a href="{{ route('productos.create') }}" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-2 shadow-sm">
                    <i class="bi bi-plus-circle"></i>
                    <span class="d-none d-sm-inline">Nuevo Producto</span>
                </a>
            </div>
        </header>

        <!-- Área de Contenido de cada vista -->
        <main class="content-area">
            <div class="container-fluid px-0">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts de Bootstrap y Comportamiento del Menú -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    {{-- <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const body = document.body;
            const sidebarCollapseBtn = document.getElementById('sidebarCollapseBtn');
            const menuToggleBtn = document.getElementById('menuToggleBtn');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const toggleIcon = document.getElementById('toggleIcon');

            // Cargar preferencia guardada en localStorage (Desktop)
            const isCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';
            if (isCollapsed && window.innerWidth >= 992) {
                body.classList.add('sidebar-collapsed');
                if (toggleIcon) {
                    toggleIcon.classList.replace('bi-layout-sidebar-inset', 'bi-layout-sidebar');
                }
            }

            // Alternar sidebar en escritorio (modo colapsado/expandido)
            function toggleDesktopSidebar() {
                const collapsed = body.classList.toggle('sidebar-collapsed');
                localStorage.setItem('sidebar_collapsed', collapsed ? 'true' : 'false');
                if (toggleIcon) {
                    if (collapsed) {
                        toggleIcon.classList.replace('bi-layout-sidebar-inset', 'bi-layout-sidebar');
                    } else {
                        toggleIcon.classList.replace('bi-layout-sidebar', 'bi-layout-sidebar-inset');
                    }
                }
            }

            // Alternar sidebar en móviles (abrir/cerrar drawer)
            function toggleMobileSidebar() {
                body.classList.toggle('sidebar-mobile-open');
            }

            // Manejador del botón del sidebar (Desktop)
            if (sidebarCollapseBtn) {
                sidebarCollapseBtn.addEventListener('click', toggleDesktopSidebar);
            }

            // Manejador del botón de la barra superior (aplica según resolución)
            if (menuToggleBtn) {
                menuToggleBtn.addEventListener('click', function () {
                    if (window.innerWidth < 992) {
                        toggleMobileSidebar();
                    } else {
                        toggleDesktopSidebar();
                    }
                });
            }

            // Cerrar menú móvil al hacer clic en el overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function () {
                    body.classList.remove('sidebar-mobile-open');
                });
            }

            // Cerrar con la tecla Escape en móvil
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && body.classList.contains('sidebar-mobile-open')) {
                    body.classList.remove('sidebar-mobile-open');
                }
            });
        });
    </script>
</body>

</html>
