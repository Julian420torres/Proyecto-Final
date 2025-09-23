<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompraRequest;
use App\Models\Compra;
use App\Models\Comprobante;
use App\Models\Producto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-compra|crear-compra|mostrar-compra|eliminar-compra', ['only' => ['index']]);
        $this->middleware('permission:crear-compra', ['only' => ['create', 'store']]);
        $this->middleware('permission:mostrar-compra', ['only' => ['show']]);
        $this->middleware('permission:eliminar-compra', ['only' => ['destroy']]);
    }

    /**
     * Mostrar listado de compras.
     */
    public function index()
    {
        $compras = Compra::with('comprobante')
            ->latest()
            ->get();

        return view('compra.index', compact('compras'));
    }

    /**
     * Formulario de creación de compra.
     */
    public function create()
    {
        $comprobantes = Comprobante::where('tipo_comprobante', 'Factura')->get();
        $productos = Producto::where('estado', 1)->get();
        return view('compra.create', compact('comprobantes', 'productos'));
    }

    /**
     * Guardar una nueva compra.
     */
    public function store(StoreCompraRequest $request)
    {
        try {
            DB::beginTransaction();

            // Crear la compra
            $compra = Compra::create($request->validated());

            // Recuperar arrays del request
            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioCompra = $request->get('arraypreciocompra');
            $arrayPrecioVenta = $request->get('arrayprecioventa');

            // Guardar en compra_producto
            $sizeArray = count($arrayProducto_id);
            for ($i = 0; $i < $sizeArray; $i++) {
                $compra->productos()->attach($arrayProducto_id[$i], [
                    'cantidad' => $arrayCantidad[$i],
                    'precio_compra' => $arrayPrecioCompra[$i],
                    'precio_venta' => $arrayPrecioVenta[$i]
                ]);

                // Actualizar stock
                $producto = Producto::findOrFail($arrayProducto_id[$i]);
                $producto->increment('stock', intval($arrayCantidad[$i]));
            }

            DB::commit();

            return redirect()->route('compras.index')->with('success', 'Compra registrada');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('compras.index')->with('success', 'Error al registrar la compra');
        }
    }

    /**
     * Mostrar detalle de una compra.
     */
    public function show(Compra $compra)
    {
        return view('compra.show', compact('compra'));
    }

    /**
     * Eliminar compra y revertir stock.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $compra = Compra::findOrFail($id);

            // Revertir stock
            foreach ($compra->productos as $producto) {
                $cantidadComprada = $producto->pivot->cantidad;
                $producto->decrement('stock', $cantidadComprada);
            }

            // Eliminar relación en pivote
            $compra->productos()->detach();

            // Eliminar compra definitivamente
            $compra->forceDelete();

            DB::commit();

            return redirect()->route('compras.index')->with('success', 'Compra eliminada');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('compras.index')->with('success', 'No se pudo eliminar la compra, productos utilizados');
        }
    }
}
