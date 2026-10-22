<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Product;
use App\Notifications\StockProduct;
use App\Support\InventoryRules;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class MovementController extends Controller
{
    public function __construct(private InventoryRules $rules) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movements = Movement::simplePaginate(10);

        return view('movements.index', ['movements' => $movements]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::orderBy('name', 'asc')->get();

        return view('movements.create', [
            'products' => $products,
            'movements_type' => [
                Movement::MOVEMENT_TYPE_IN,
                Movement::MOVEMENT_TYPE_DEVOLUTION,
                Movement::MOVEMENT_TYPE_OUT,
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $movement = new Movement;
            $movement->type = $request->type;
            $movement->amount = $request->amount;
            $movement->sale_point = $request->sale_point;
            $movement->product_id = $request->producto;
            $movement->save();

            $product = Product::find($request->producto);

            if (! $product instanceof Product) {
                throw new Exception('El producto seleccionado no existe.');
            }

            // Las reglas de inventario viven en App\Support\InventoryRules,
            // una clase sin dependencias que se puede probar de forma aislada.
            $product->amount = $this->rules->applyMovement(
                $product->amount,
                $movement->type,
                $movement->amount
            );
            $product->save();

            $this->checkLowStock($product);

            // Solo se confirma la transacción si todo salió bien.
            DB::commit();
        } catch (\Throwable $ex) {
            DB::rollBack();
            Log::error('Error al tratar de realizar el movimiento: '.$ex->getMessage());
            Session::flash('error', $ex->getMessage());
        }

        return redirect()->route('movimientos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Movement $movement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movement $movement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movement $movement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movement $movement)
    {
        //
    }

    private function checkLowStock($product)
    {
        if ($product->amount <= 10) {
            Notification::route('mail', 'mvalenciaz@sena.edu.co')
                ->notify(new StockProduct($product));
        }
    }
}
