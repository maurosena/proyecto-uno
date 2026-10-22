<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can render the user manual page successfully', function () {
    $response = $this->get(route('manual.index'));

    $response->assertStatus(200);
    $response->assertSee('Manual de Usuario');
    $response->assertSee('InvStock Pro');
    $response->assertSee('Módulo de Productos');
    $response->assertSee('Módulo de Movimientos');
    $response->assertSee('Tabla de Contenidos');
});

test('shows user manual link in sidebar navigation', function () {
    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertSee(route('manual.index'));
    $response->assertSee('Manual de usuario');
});
