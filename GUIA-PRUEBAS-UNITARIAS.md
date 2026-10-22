# Guía práctica: pruebas unitarias con PHPUnit

**Proyecto:** `D:\ficha3445530\laravel\proyecto-uno` (InvStock Pro)
**Stack:** Laravel 13 · PHP 8.3 · PHPUnit 12.5 · Pest 4.7 · Mockery 1.6
**Formato:** en esta guía se escribe en **sintaxis PHPUnit (clases)**. El proyecto además tiene
Pest, pero ambos comparten el mismo motor y el mismo `phpunit.xml`.

---

## Índice

1. [Antes de empezar](#1-antes-de-empezar)
2. [Crear un archivo de prueba con `php artisan make:test`](#2-crear-un-archivo-de-prueba-con-php-artisan-make:test)
3. [Las piezas de una prueba](#3-las-piezas-de-una-prueba)
4. [Práctica 1 — Una prueba sin Laravel](#4-práctica-1--una-prueba-sin-laravel)
5. [Práctica 2 — Una clase de negocio real](#5-práctica-2--una-clase-de-negocio-real)
6. [Práctica 3 — Un modelo y la base de datos](#6-práctica-3--un-modelo-y-la-base-de-datos)
7. [Práctica 4 — Un controlador HTTP (movimientos)](#7-práctica-4--un-controlador-http-movimientos)
8. [Práctica 5 — El dashboard](#8-práctica-5--el-dashboard)
9. [Práctica 6 — Productos y alertas](#9-práctica-6--productos-y-alertas)
10. [Extra (opcional) — Probar sin HTTP y simular el PDF](#10-extra-opcional--probar-sin-http-y-simular-el-pdf)
11. [Cómo leer un error rojo](#11-cómo-leer-un-error-rojo)
12. [Checklist y plan de la jornada](#12-checklist-y-plan-de-la-jornada)
13. [Anexo — Archivos](#13-anexo--archivos)

---

## 1. Antes de empezar

**Qué necesitas**

- El proyecto con `composer install` ya ejecutado.
- La base de datos de pruebas configurada (ya lo está en `phpunit.xml`: SQLite en memoria,
  no toca la base de desarrollo).

**El único comando que necesitas**

```powershell
cd D:\ficha3445530\laravel\proyecto-uno
php artisan test
```

Salida actual del proyecto:

```
   PASS  Tests\Unit\CalculadoraTest
   PASS  Tests\Unit\InventoryRulesTest
   PASS  Tests\Unit\ProductModelTest
   PASS  Tests\Unit\ProductControllerUnitTest
   PASS  Tests\Feature\DashboardControllerTest
   PASS  Tests\Feature\MovementControllerTest
   PASS  Tests\Feature\ProductControllerTest
   ...

  Tests:    36 passed (84 assertions)
  Duration: 1.19s
```

**Comandos útiles**

| Comando | Para qué |
|---|---|
| `php artisan test` | corre todo |
| `php artisan test --testsuite=Unit` | solo `tests/Unit` |
| `php artisan test --testsuite=Feature` | solo `tests/Feature` |
| `php artisan test --filter=MovementControllerTest` | solo un archivo |
| `php artisan test --filter=una_entrada` | solo una prueba por nombre |

> **Ojo:** `vendor/bin/phpunit` **no funciona** en este repositorio (los `ExampleTest.php`
> heredados están escritos en sintaxis Pest). Usen siempre `php artisan test`.

---

## 2. Crear un archivo de prueba con `php artisan make:test`

Laravel trae un generador de archivos de prueba. **No hay que crear los archivos a mano.**

### 2.1 El comando

```powershell
php artisan make:test --phpunit --unit CalculadoraTest
```

Salida:

```
  INFO  Test [D:\ficha3445530\laravel\proyecto-uno\tests\Unit\CalculadoraTest.php] created successfully.
```

### 2.2 Qué significan las banderas

| Bandera | Qué hace | Dónde queda el archivo |
|---|---|---|
| (ninguna) | crea una prueba de **Feature** (petición HTTP) | `tests/Feature/` |
| `--unit` | crea una prueba **unitaria** (sin base de datos) | `tests/Unit/` |
| `--phpunit` | escribe el archivo en **sintaxis PHPUnit (clases)** | — |
| `--pest` | escribe el archivo en **sintaxis Pest** (funciones) | — |

**¿Por qué `--phpunit`?** Porque este proyecto tiene Pest instalado, y sin esa bandera
`make:test` genera un archivo con la sintaxis de Pest:

```php
test('example', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});
```

En esta guía usamos clases, así que siempre `make:test --phpunit`.

### 2.3 La trampa: no escribas `Feature/` en el nombre

El comando **ya** coloca el archivo en `tests/Unit` o `tests/Feature`. Si además escribes la
carpeta en el nombre, se duplica:

```powershell
php artisan make:test --phpunit Feature/CosasTest
#  ->  tests/Feature/Feature/CosasTest.php   (¡carpeta duplicada!)
```

**Regla:** escribe **solo el nombre de la clase**, sin carpeta.

```powershell
php artisan make:test --phpunit --unit CalculadoraTest        # -> tests/Unit/CalculadoraTest.php
php artisan make:test --phpunit ProductControllerTest         # -> tests/Feature/ProductControllerTest.php
```

### 2.4 Qué archivo genera

Con `--phpunit --unit` (prueba unitaria pura):

```php
<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class CalculadoraTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
}
```

Con `--phpunit` (prueba de Feature):

```php
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    public function test_example(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
```

### 2.5 Un detalle del proyecto

`tests/Pest.php` tiene el trait `RefreshDatabase` **comentado** a nivel global, porque las
pruebas de Pest lo usan por su cuenta. Las pruebas de clase **no lo heredan**: si necesitas
base de datos, debes agregar el trait a mano:

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductModelTest extends TestCase
{
    use RefreshDatabase;   // <- base de datos limpia en cada prueba
}
```

---

## 3. Las piezas de una prueba

Toda prueba tiene tres momentos, siempre en el mismo orden:

```php
// Arrange — preparar los datos
$product = Product::factory()->create(['amount' => 10]);

// Act — ejecutar lo que se quiere probar
$response = $this->registrarMovimiento($product, 'salida', 3);

// Assert — verificar el resultado
$this->assertDatabaseHas('products', ['id' => $product->id, 'amount' => 7]);
```

### 3.1 Las aserciones que usaremos (chuleta)

| Aserción | Qué verifica | Ejemplo |
|---|---|---|
| `assertSame($esperado, $real)` | valor **y tipo** exactos | `assertSame(15.0, $stock)` |
| `assertTrue($x)` / `assertFalse($x)` | booleano | `assertTrue($rules->isLowStock(5))` |
| `assertNull($x)` | valor nulo | `assertNull(null)` |
| `assertCount($n, $coleccion)` | cuántos elementos hay | `assertCount(2, $productos)` |
| `assertContains($x, $coleccion)` | el elemento está dentro | `assertContains('P-002', $productos)` |
| `assertStringContainsString($texto, $cadena)` | la cadena contiene ese texto | `assertStringContainsString('Inventario', $titulo)` |
| `assertDatabaseHas($tabla, $datos)` | **la fila existe** en la BD | `assertDatabaseHas('products', ['amount' => 15])` |
| `assertDatabaseMissing($tabla, $datos)` | **la fila NO existe** | `assertDatabaseMissing('movements', [...])` |
| `assertSoftDeleted($tabla, $datos)` | la fila está eliminada lógicamente | `assertSoftDeleted('products', ['id' => 1])` |

En pruebas de HTTP (Feature) se usan las de respuesta:

| Aserción | Qué verifica |
|---|---|
| `assertStatus(200)` | la página respondió correctamente |
| `assertRedirect(route('x'))` | redirigió a otra página |
| `assertViewIs('vista.blade')` | renderizó la vista correcta |
| `assertViewHas('dato', $valor)` | la vista recibió ese dato |
| `assertSessionHas('error')` | quedó un mensaje en sesión (flash) |
| `assertSee('texto')` | el texto aparece en el HTML |

### 3.2 `Unit` o `Feature`?

| | `tests/Unit` | `tests/Feature` |
|---|---|---|
| Arranca Laravel | a veces | siempre |
| Toca la base de datos | a veces | sí |
| Hace peticiones HTTP | no | sí |
| Velocidad | milisegundos | décimas de segundo |
| Ejemplo | `InventoryRules`, `Calculadora` | `MovementController` |

Regla rápida: **si la prueba necesita base de datos o una URL, va en `Feature`.**

---

## 4. Práctica 1 — Una prueba sin Laravel

**Objetivo:** escribir la primera prueba y entender `assertSame` y `expectException`.

### Paso 1 — Crear el archivo

```powershell
php artisan make:test --phpunit --unit CalculadoraTest
```

### Paso 2 — Pegar el código completo

```php
<?php

namespace Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * PRÁCTICA 1 — Una prueba unitaria "de verdad", sin Laravel.
 *
 * Hereda de PHPUnit\Framework\TestCase (NO de Tests\TestCase), por lo que
 * Laravel NO se arranca: la prueba corre en milisegundos y sin base de datos.
 */
class CalculadoraTest extends TestCase
{
    public function test_la_suma_devuelve_el_resultado_correcto(): void
    {
        // Arrange (preparar)
        $a = 3;
        $b = 4;

        // Act (ejecutar)
        $resultado = $a + $b;

        // Assert (verificar)
        $this->assertSame(7, $resultado);
    }

    public function test_verificaciones_de_booleano_y_nulo(): void
    {
        $this->assertTrue(true);
        $this->assertFalse(false);
        $this->assertNull(null);
    }

    public function test_verificaciones_de_colecciones_y_texto(): void
    {
        $productos = ['P-001', 'P-002', 'P-003'];

        $this->assertCount(3, $productos);
        $this->assertContains('P-002', $productos);
        $this->assertStringContainsString('Inventario', 'Sistema de Gestion de Inventario');
    }

    public function test_se_espera_una_excepcion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('mayor que cero');

        throw new InvalidArgumentException('La cantidad del movimiento debe ser mayor que cero.');
    }
}
```

### Paso 3 — Qué hace cada parte

| Parte | Qué significa |
|---|---|
| `namespace Tests\Unit;` | debe coincidir con la carpeta (`tests/Unit`). |
| `extends TestCase` | aquí `TestCase` es `PHPUnit\Framework\TestCase`: **no** hay Laravel. Por eso el archivo va en `tests/Unit`. |
| `use InvalidArgumentException;` | importa la excepción de PHP que se va a probar. |
| `test_la_suma_devuelve_el_resultado_correcto()` | el nombre del método **es** la prueba. Empieza por `test_` y se lee como una frase. |
| `$this->assertSame(7, $resultado)` | verifica que `$resultado` sea exactamente `7` (mismo tipo, mismo valor). El primero es el **esperado**, el segundo el **real**. |
| `$this->expectException(...)` | le dice a PHPUnit: "esta prueba **debe** fallar lanzando esta excepción". Si no se lanza, la prueba falla. |

### Paso 4 — Ejecutar

```powershell
php artisan test --filter=CalculadoraTest
```

### Paso 5 — Qué se espera ver

```
   PASS  Tests\Unit\CalculadoraTest
  ✓ la suma devuelve el resultado correcto                                                                       0.01s
  ✓ verificaciones de booleano y nulo
  ✓ verificaciones de colecciones y texto
  ✓ se espera una excepcion

  Tests:    4 passed (9 assertions)
  Duration: 0.20s
```

Si ves `FAIL`, casi siempre es que el valor esperado no coincide con el real: la línea
`Failed asserting that 7 matches 6` te dice exactamente cuál de los dos falló.

---

## 5. Práctica 2 — Una clase de negocio real

**Objetivo:** probar `App\Support\InventoryRules`, que es código del proyecto (no un ejemplo
inventado). Esta clase se creó extrayendo las reglas que estaban metidas dentro del
`MovementController`, y por eso hoy se puede probar sola.

### Paso 1 — Crear el archivo

```powershell
php artisan make:test --phpunit --unit InventoryRulesTest
```

### Paso 2 — Pegar el código completo

```php
<?php

namespace Tests\Unit;

use App\Support\InventoryRules;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * PRÁCTICA 2 — Una clase de negocio real del proyecto, probada sola.
 *
 * App\Support\InventoryRules no toca la base de datos, por eso se puede
 * probar como una unidad pura.
 */
class InventoryRulesTest extends TestCase
{
    private InventoryRules $rules;

    protected function setUp(): void
    {
        $this->rules = new InventoryRules;
    }

    public function test_clasifica_el_stock_segun_la_cantidad(): void
    {
        $this->assertSame('critico', $this->rules->level(5));
        $this->assertSame('advertencia', $this->rules->level(20));
        $this->assertSame('normal', $this->rules->level(100));
    }

    public function test_detecta_el_stock_bajo(): void
    {
        $this->assertTrue($this->rules->isLowStock(10));
        $this->assertFalse($this->rules->isLowStock(11));
    }

    public function test_una_entrada_aumenta_y_una_salida_resta(): void
    {
        $this->assertSame(15.0, $this->rules->applyMovement(10, 'entrada', 5));
        $this->assertSame(7.0, $this->rules->applyMovement(10, 'salida', 3));
    }

    public function test_una_salida_mayor_al_inventario_lanza_excepcion(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('mayor a la cantidad de inventario');

        $this->rules->applyMovement(5, 'salida', 10);
    }
}
```

### Paso 3 — Qué hace cada parte

| Parte | Qué significa |
|---|---|
| `private InventoryRules $rules;` | una propiedad que guardará el objeto bajo prueba. |
| `setUp()` | se ejecuta **antes de cada prueba**. Aquí se crea el objeto limpio. Si la clase del proyecto necesitara dependencias, se pasarían por el constructor. |
| `$this->rules->level(5)` | se llama al método y se compara el resultado. `level()` devuelve `'critico'` si hay 5 o menos, `'advertencia'` hasta 30 y `'normal'` por encima. |
| `assertSame(15.0, ...)` | el resultado es `float` (por eso `15.0` y no `15`). `assertSame` distingue `15` de `15.0`. |
| `expectException(Exception::class)` | se espera que el código lance la excepción. Aquí es el caso de negocio "no se puede sacar másmercancía de la que hay". |

**Dato útil:** `assertSame` es estricto con el tipo. Si el código devolviera `15` (int) en lugar
de `15.0` (float), la prueba fallaría aunque "sean el mismo número". Eso es intencional: avisa
de cambios accidentales en el tipo de dato.

### Paso 4 — Ejecutar

```powershell
php artisan test --filter=InventoryRulesTest
```

### Paso 5 — Qué se espera ver

```
   PASS  Tests\Unit\InventoryRulesTest
  ✓ clasifica el stock segun la cantidad                                                                         0.01s
  ✓ detecta el stock bajo
  ✓ una entrada aumenta y una salida resta                                                                       0.01s
  ✓ una salida mayor al inventario lanza excepcion

  Tests:    4 passed (9 assertions)
  Duration: 0.19s
```

---

## 6. Práctica 3 — Un modelo y la base de datos

**Objetivo:** probar el modelo `Product`: creación, relaciones, tipos de dato y borrado lógico.

### Paso 1 — Crear el archivo

```powershell
php artisan make:test --phpunit --unit ProductModelTest
```

### Paso 2 — Pegar el código completo

```php
<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * PRÁCTICA 3 — Un modelo y la base de datos.
 *
 * Aquí Laravel sí se arranca (hereda de Tests\TestCase) porque los modelos
 * necesitan base de datos. Se usa RefreshDatabase para que cada prueba
 * empiece con la base de datos limpia.
 */
class ProductModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_se_puede_crear_un_producto(): void
    {
        $product = Product::factory()->create([
            'code' => 'P-1001',
            'name' => 'Tableta Grafica',
            'amount' => 20,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'code' => 'P-1001',
            'name' => 'Tableta Grafica',
            'amount' => 20,
        ]);
    }

    public function test_un_producto_pertenece_a_un_proveedor(): void
    {
        $proveedor = Provider::factory()->create();
        $product = Product::factory()->create(['provider_id' => $proveedor->id]);

        $this->assertTrue($product->provider->is($proveedor));
    }

    public function test_el_precio_se_guarda_como_numero(): void
    {
        $product = Product::factory()->create(['price' => 850000]);

        $this->assertSame(850000.0, (float) $product->fresh()->price);
    }

    public function test_un_producto_eliminado_no_aparece_en_el_listado(): void
    {
        $product = Product::factory()->create();
        $product->delete();

        $this->assertSoftDeleted('products', ['id' => $product->id]);
        $this->assertCount(0, Product::all());
    }
}
```

### Paso 3 — Qué hace cada parte

| Parte | Qué significa |
|---|---|
| `extends Tests\TestCase` | ahora sí arranca Laravel (contenedor, rutas, base de datos). |
| `use RefreshDatabase;` | antes de cada prueba se migra la base de datos de pruebas y después se limpia. Gracias a esto una prueba no ve lo que dejó otra. |
| `Product::factory()->create([...])` | crea un producto con datos **falsos** y lo guarda en la base de datos. Los datos que se pasan entre corchetes sobrescriben los generados. |
| `assertDatabaseHas('products', [...])` | consulta la tabla `products` y verifica que exista una fila con esos valores. Esta es la aserción clave cuando se prueban modelos. |
| `$product->provider->is($proveedor)` | verifica la relación. `is()` compara el modelo con la instancia, no solo el id. |
| `$product->fresh()` | vuelve a leer el producto **desde la base de datos** (sin el caché del objeto en memoria). Necesario para comprobar qué quedó realmente guardado. |
| `assertSoftDeleted(...)` | `Product` usa `SoftDeletes`: el registro no se borra, se marca como eliminado. Por eso el listado normal ya no lo muestra (`assertCount(0, Product::all())`). |

> **Dato importante:** la base de datos de pruebas es SQLite en memoria
> (`phpunit.xml` → `DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`). Por eso las pruebas
> nunca tocan la base de datos de desarrollo y se pueden borrar sin riesgo.

### Paso 4 — Ejecutar

```powershell
php artisan test --filter=ProductModelTest
```

### Paso 5 — Qué se espera ver

```
   PASS  Tests\Unit\ProductModelTest
  ✓ se puede crear un producto                                                                                   0.31s
  ✓ un producto pertenece a un proveedor                                                                         0.02s
  ✓ el precio se guarda como numero                                                                              0.02s
  ✓ un producto eliminado no aparece en el listado                                                               0.02s

  Tests:    4 passed (5 assertions)
  Duration: 0.58s
```

---

## 7. Práctica 4 — Un controlador HTTP (movimientos)

**Objetivo:** la prueba más importante del proyecto. Aquí vive la lógica de inventario:
entradas, salidas, stock insuficiente y aviso de existencias bajas.

### Paso 1 — Crear el archivo

```powershell
php artisan make:test --phpunit MovementControllerTest
```

### Paso 2 — Pegar el código completo

```php
<?php

namespace Tests\Feature;

use App\Models\Movement;
use App\Models\Product;
use App\Notifications\StockProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * PRÁCTICA 4 — Un controlador HTTP: el corazón del inventario.
 *
 * Estas pruebas hacen una petición HTTP real (como si un usuario escribiera
 * en el formulario), por eso van en tests/Feature.
 */
class MovementControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Atajo: envía el formulario de movimiento de un producto.
     */
    private function registrarMovimiento(Product $product, string $type, float $amount)
    {
        return $this->post(route('movimientos.store'), [
            'type' => $type,
            'amount' => $amount,
            'sale_point' => 'Caja 1',
            'producto' => $product->id,
        ]);
    }

    public function test_el_listado_de_movimientos_se_muestra(): void
    {
        $product = Product::factory()->create();
        Movement::factory()->count(2)->create(['product_id' => $product->id]);

        $response = $this->get(route('movimientos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('movements.index');
    }

    public function test_una_entrada_aumenta_el_stock_del_producto(): void
    {
        $product = Product::factory()->create(['amount' => 10]);

        $response = $this->registrarMovimiento($product, Movement::MOVEMENT_TYPE_IN, 5);

        $response->assertRedirect(route('movimientos.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'amount' => 15,
        ]);
    }

    public function test_una_salida_resta_el_stock_del_producto(): void
    {
        $product = Product::factory()->create(['amount' => 10]);

        $this->registrarMovimiento($product, Movement::MOVEMENT_TYPE_OUT, 3);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'amount' => 7,
        ]);
    }

    public function test_una_salida_mayor_al_inventario_no_modifica_el_stock(): void
    {
        $product = Product::factory()->create(['amount' => 5]);

        $response = $this->registrarMovimiento($product, Movement::MOVEMENT_TYPE_OUT, 10);

        // El usuario recibe el error del negocio...
        $response->assertSessionHas('error');

        // ...no se registra el movimiento...
        $this->assertDatabaseMissing('movements', ['product_id' => $product->id]);

        // ...y el stock queda intacto.
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'amount' => 5,
        ]);
    }

    public function test_se_avisa_cuando_el_producto_queda_con_pocas_existencias(): void
    {
        Notification::fake();

        $product = Product::factory()->create(['amount' => 12]);

        $this->registrarMovimiento($product, Movement::MOVEMENT_TYPE_OUT, 5);

        Notification::assertSentOnDemand(
            StockProduct::class,
            fn (StockProduct $notification) => $notification->product->id === $product->id
        );
    }
}
```

### Paso 3 — Qué hace cada parte

| Parte | Qué significa |
|---|---|
| `$this->post(route('movimientos.store'), [...])` | simula el envío del formulario. `route('...')` evita escribir la URL a mano: si cambia la ruta, la prueba se actualiza sola. |
| `'producto' => $product->id` | **ojo con el nombre del campo**: el formulario del proyecto manda el producto en el campo `producto` (no `product_id`). Si se manda mal, la prueba falla y esa es justo la información útil. |
| `assertRedirect(route('movimientos.index'))` | después de guardar, el usuario debe volver al listado. |
| `assertDatabaseHas('products', ['amount' => 15])` | la aserción de negocio: el stock **quedó** en 15 (10 + 5). |
| `assertDatabaseMissing(...)` | verifica lo que **no** pasó: en este caso, que no quedó registrado ningún movimiento. |
| `assertSessionHas('error')` | el controlador guardó un mensaje de error en la sesión para mostrarlo al usuario. |
| `Notification::fake()` | **intercepta** el envío de notificaciones: no se manda ningún correo de verdad, solo se registra que se habría enviado. |
| `assertSentOnDemand(...)` | comprueba que se envió la notificación `StockProduct` y que corresponde al producto esperado. `OnDemand` es porque el código la manda a un correo fijo, no a un usuario del sistema. |

### Paso 4 — Ejecutar

```powershell
php artisan test --filter=MovementControllerTest
```

### Paso 5 — Qué se espera ver

```
   PASS  Tests\Feature\MovementControllerTest
  ✓ el listado de movimientos se muestra                                                                         0.37s
  ✓ una entrada aumenta el stock del producto                                                                    0.02s
  ✓ una salida resta el stock del producto                                                                       0.10s
  ✓ una salida mayor al inventario no modifica el stock                                                          0.03s
  ✓ se avisa cuando el producto queda con pocas existencias                                                      0.02s

  Tests:    5 passed (10 assertions)
  Duration: 0.72s
```

**Prueba viva (muy recomendada en la jornada):** cambia `5` por `50` en
`test_una_entrada_aumenta_el_stock_del_producto` y vuelve a correr. La prueba falla y te
muestra que el stock **no** se actualizó como se esperaba. Eso es una prueba trabajando.

---

## 8. Práctica 5 — El dashboard

**Objetivo:** comprobar que la pantalla principal separa los productos por nivel de stock.

### Paso 1 — Crear el archivo

```powershell
php artisan make:test --phpunit DashboardControllerTest
```

### Paso 2 — Pegar el código completo

```php
<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * PRÁCTICA 5 — El dashboard: la pantalla que resume el inventario.
 */
class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_el_dashboard_se_muestra_correctamente(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.dashboard');
    }

    public function test_el_dashboard_separa_los_productos_por_nivel_de_stock(): void
    {
        $critico = Product::factory()->critical()->create(['name' => 'Cable HDMI']);
        $normal = Product::factory()->normal()->create(['name' => 'Monitor 24 pulgadas']);

        $response = $this->get(route('dashboard'));

        // El producto con poco stock va en el grupo "crítico"...
        $response->assertViewHas('criticalProducts', fn ($productos) => $productos->first()->id === $critico->id);

        // ...y el que tiene stock de sobra va en "normal".
        $response->assertViewHas('normalProducts', fn ($productos) => $productos->first()->id === $normal->id);
    }

    public function test_el_dashboard_muestra_los_contadores_correctos(): void
    {
        Product::factory()->count(2)->critical()->create();
        Product::factory()->count(3)->normal()->create();

        $response = $this->get(route('dashboard'));

        $response->assertViewHas('criticalCount', 2);
        $response->assertViewHas('normalCount', 3);
        $response->assertViewHas('totalProducts', 5);
    }
}
```

### Paso 3 — Qué hace cada parte

| Parte | Qué significa |
|---|---|
| `Product::factory()->critical()` | la **factory** trae "estados" listos: `critical()` (≤ 5 unidades), `warning()` (6 a 30), `normal()` (> 30), `lowStock()`, `healthyStock()`. Ahorra tener que escribir el número cada vez. |
| `->count(2)` | crea 2 productos de una sola vez. |
| `assertViewHas('criticalCount', 2)` | verifica el dato que el controlador le pasó a la vista. Es la forma correcta de probar un controlador que solo arma variables para el HTML. |
| `fn ($productos) => ...` | una función flecha que recibe el valor de la vista y devuelve `true` si la condición se cumple. Evita revisar el HTML completo. |

### Paso 4 — Ejecutar

```powershell
php artisan test --filter=DashboardControllerTest
```

### Paso 5 — Qué se espera ver

```
   PASS  Tests\Feature\DashboardControllerTest
  ✓ el dashboard se muestra correctamente                                                                        0.33s
  ✓ el dashboard separa los productos por nivel de stock                                                         0.04s
  ✓ el dashboard muestra los contadores correctos                                                                0.04s

  Tests:    3 passed (7 assertions)
  Duration: 0.59s
```

---

## 9. Práctica 6 — Productos y alertas

**Objetivo:** probar el CRUD de productos y el aviso de existencias bajas.

### Paso 1 — Crear el archivo

```powershell
php artisan make:test --phpunit ProductControllerTest
```

### Paso 2 — Pegar el código completo

```php
<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Provider;
use App\Notifications\StockProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * PRÁCTICA 6 — El CRUD de productos y la alerta de stock bajo.
 */
class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_el_listado_de_productos_se_muestra(): void
    {
        Product::factory()->count(3)->create();

        $response = $this->get(route('productos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('products.index');
    }

    public function test_se_puede_crear_un_producto(): void
    {
        Notification::fake();
        $proveedor = Provider::factory()->create();

        $response = $this->post(route('productos.store'), [
            'code' => 'P-5001',
            'name' => 'Tableta Grafica',
            'amount' => 50,
            'unit' => 'und',
            'price' => 850000,
            'provider_id' => $proveedor->id,
        ]);

        $response->assertRedirect(route('productos.index'));
        $this->assertDatabaseHas('products', [
            'code' => 'P-5001',
            'name' => 'Tableta Grafica',
        ]);
    }

    public function test_se_avisa_cuando_el_producto_nace_con_pocas_existencias(): void
    {
        Notification::fake();
        $proveedor = Provider::factory()->create();

        $this->post(route('productos.store'), [
            'code' => 'P-5002',
            'name' => 'Cable de Red',
            'amount' => 5,
            'unit' => 'und',
            'price' => 25000,
            'provider_id' => $proveedor->id,
        ]);

        Notification::assertSentOnDemand(
            StockProduct::class,
            fn (StockProduct $notification) => $notification->product->name === 'Cable de Red'
        );
    }

    public function test_se_puede_eliminar_un_producto(): void
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('productos.destroy', $product));

        $response->assertRedirect(route('productos.index'));
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}
```

### Paso 3 — Qué hace cada parte

| Parte | Qué significa |
|---|---|
| `$this->post(route('productos.store'), [...])` | simula el envío del formulario de creación. Los nombres de los campos deben coincidir con los que usa el controlador. |
| `Notification::fake()` | se coloca **antes** de la acción. A partir de ahí, ninguna notificación se envía de verdad. |
| `assertSentOnDemand(StockProduct::class, fn ($n) => ...)` | verifica que se envió la notificación `StockProduct` y que su producto es el esperado. |
| `$this->delete(route('productos.destroy', $product))` | simula el borrado. |
| `assertSoftDeleted(...)` | como `Product` usa `SoftDeletes`, el registro queda marcado, no borrado. |

### Paso 4 — Ejecutar

```powershell
php artisan test --filter=ProductControllerTest
```

### Paso 5 — Qué se espera ver

```
   PASS  Tests\Feature\ProductControllerTest
  ✓ el listado de productos se muestra                                                                           0.35s
  ✓ se puede crear un producto                                                                                   0.02s
  ✓ se avisa cuando el producto nace con pocas existencias                                                       0.03s
  ✓ se puede eliminar un producto                                                                                0.02s

  Tests:    4 passed (9 assertions)
  Duration: 0.61s
```

---

## 10. Extra (opcional) — Probar sin HTTP y simular el PDF

**Objetivo:** dos técnicas que conviene conocer, pero que no son necesarias para empezar.

### 10.1 Llamar al controlador sin pasar por HTTP

En las prácticas 4 a 6 la petición entra por la URL. También se puede llamar al método
directamente:

```php
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;

$request = Request::create('/productos', 'POST', [
    'code' => 'P-7001',
    'name' => 'Router WiFi',
    'amount' => 12,
    'unit' => 'und',
    'price' => 150000,
    'provider_id' => $proveedor->id,
]);

$response = (new ProductController)->store($request);

$this->assertTrue($response->isRedirect(route('productos.index')));
$this->assertDatabaseHas('products', ['code' => 'P-7001']);
```

### 10.2 Simular el PDF con Mockery

`barryvdh/laravel-dompdf` v3 **no** trae un `PDF::fake()`. Se simula con Mockery:

```php
use Barryvdh\DomPDF\Facade\PDF;
use Mockery;

$pdfSimulado = Mockery::mock(\Barryvdh\DomPDF\PDF::class);
$pdfSimulado->shouldReceive('stream')
    ->once()
    ->andReturn(response('PDF-SIMULADO', 200, ['Content-Type' => 'application/pdf']));

PDF::shouldReceive('loadView')
    ->once()
    ->with('products.pdf', Mockery::on(
        fn (array $datos) => $datos['product']->id === $product->id
    ))
    ->andReturn($pdfSimulado);

$response = (new ProductController)->pdf($product->id);

$this->assertSame('PDF-SIMULADO', $response->getContent());
```

El archivo completo de esta práctica está en
`tests/Unit/ProductControllerUnitTest.php`:

```
   PASS  Tests\Unit\ProductControllerUnitTest
  ✓ el controlador crea el producto sin pasar por http                                                           0.33s
  ✓ el pdf se puede simular con mockery                                                                          0.05s

  Tests:    2 passed (5 assertions)
  Duration: 0.57s
```

---

## 11. Cómo leer un error rojo

Una prueba falla. El mensaje dice exactamente qué pasa. Estos son los más comunes:

### 11.1 "Failed asserting that X matches Y"

El valor real no es el esperado. La línea dice cuál es cuál:

```
  Failed asserting that 15.0 matches 14.0
         esperado ↑    real ↑
```

### 11.2 "Call to a member function ... on null"

Algo devolvió `null`. Casi siempre es una factory o una relación que no se creó.

### 11.3 "Table 'products' has no column named 'nombre'"

El nombre del campo está mal. Copiar **exactamente** el nombre que usa el controlador o el
formulario (por ejemplo, el campo del producto es `producto`, no `product_id`).

### 11.4 "SQLSTATE ... no such table"

Falta el trait en la clase:

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class MiTest extends TestCase
{
    use RefreshDatabase;
}
```

### 11.5 "Class 'App\Support\InventoryRules' not found"

El `use` está mal escrito o el archivo no está en `app/Support/`. Revisa que coincida
exactamente con la ruta, incluida la mayúscula inicial.

### 11.6 "Undefined array key 'producto'"

El formulario no mandó ese campo. Revisa los nombres de campo del formulario real.

### 11.7 La prueba pasa pero no debería

O el código está mal, o **la prueba está mal escrita**. Un error común: olvidar el
`assertDatabaseHas`, escribir el valor esperado igual al valor real sin querer, o no
comprobar nada en realidad.

---

## 12. Checklist y plan de la jornada

### 12.1 Checklist antes de dar por buena una prueba

- [ ] El nombre del método dice **qué** se está probando, en una frase.
- [ ] Hay al menos una aserción. (Una prueba sin aserciones siempre "pasa" y no sirve.)
- [ ] La prueba falla si el código está mal. *(Pruébalo: rompe el código un momento y
      comprueba que la prueba se pone roja.)*
- [ ] No hay datos reales del negocio metidos a mano: se usan factories.
- [ ] La prueba no depende de otra prueba (el orden no debe importar).
- [ ] El nombre del archivo y el `namespace` coinciden con la carpeta.

### 12.2 Plan de la jornada (2 horas)

| Tiempo | Qué se hace |
|---|---|
| 0:00 – 0:15 | Sección 1, 2 y 3: `make:test`, cómo corre, piezas de una prueba. Todos crean `CalculadoraTest` con `make:test`. |
| 0:15 – 0:35 | Práctica 1 y 2: unidad pura. Se ejecutan y se lee la salida real. |
| 0:35 – 0:55 | Práctica 3: modelo + base de datos + `RefreshDatabase`. |
| 0:55 – 1:25 | Práctica 4: `MovementController` (la importante). Rotar: cada quien escribe una prueba y la explica. |
| 1:25 – 1:40 | Práctica 5 y 6: dashboard y productos. |
| 1:40 – 2:00 | Sección 10 (extra), sección 11 (errores) y cierre: cada quien escribe una prueba de su propio código. |

### 12.3 Lo que hay que llevarse

1. El archivo se crea con `php artisan make:test --phpunit [--unit] NombreTest`.
2. El nombre del método **es** la prueba.
3. `assertDatabaseHas` es la aserción clave cuando hay base de datos.
4. `Notification::fake()` evita correos de verdad.
5. `php artisan test` corre todo en ~1 segundo.

---

## 13. Anexo — Archivos

### 13.1 Archivos que hay que crear en el proyecto

| Archivo | Qué es |
|---|---|
| `app/Support/InventoryRules.php` | Clase **nueva** con las reglas de inventario (umbrales de stock). Se extrajo del `MovementController` para poder probarla sola. |
| `database/factories/ProductFactory.php` | Factory **nueva** (el repositorio solo tenía `Provider` y `User`). Incluye los estados `critical()`, `warning()`, `normal()`, `lowStock()`, `healthyStock()`. |
| `database/factories/MovementFactory.php` | Factory **nueva**. Incluye los estados `entrada()`, `salida()`, `devolucion()`. |

### 13.2 Archivos de prueba

| Archivo | Práctica | Tipo | Pruebas |
|---|---|---|---|
| `tests/Unit/CalculadoraTest.php` | 1 | PHPUnit puro | 4 |
| `tests/Unit/InventoryRulesTest.php` | 2 | PHPUnit puro | 4 |
| `tests/Unit/ProductModelTest.php` | 3 | Laravel + BD | 4 |
| `tests/Feature/MovementControllerTest.php` | 4 | Laravel + HTTP | 5 |
| `tests/Feature/DashboardControllerTest.php` | 5 | Laravel + HTTP | 3 |
| `tests/Feature/ProductControllerTest.php` | 6 | Laravel + HTTP | 4 |
| `tests/Unit/ProductControllerUnitTest.php` | Extra | Mocks | 2 |

### 13.3 Cambios en el código de producción

Para que la suite quedara en verde hubo que corregir dos cosas:

1. **`app/Models/Movement.php`** — se agregó `$fillable`. En Laravel 11+ la lista por defecto es
   `$guarded = ['*']`: sin `$fillable`, ninguna asignación masiva funciona.
2. **`app/Http/Controllers/MovementController.php`** — `store()` se reescribió: todo el trabajo
   queda dentro de un `try/catch`, `DB::commit()` solo se ejecuta si todo salió bien (si no,
   `DB::rollBack()`), se valida que el producto exista y la lógica de stock se delega a
   `InventoryRules`.

### 13.4 Resultado final

```
  Tests:    36 passed (84 assertions)
  Duration: 1.19s
```
