<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Routing\Controller;
use App\Models\Medicamento;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Muestra la página del carrito
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $id => $details) {
            $total += $details['precio'] * $details['cantidad'];
        }

        return view('cart', compact('cart', 'total'));
    }

    // Añade un producto al carrito
    public function add(Request $request, $id)
    {
        $medicamento = Medicamento::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['cantidad']++;
        } else {
            $cart[$id] = [
                "nombre" => $medicamento->nombre,
                "cantidad" => 1,
                "precio" => $medicamento->precio,
                "imagen" => $medicamento->imagen
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', '¡Producto añadido al carrito!');
    }

    // Actualiza la cantidad de un producto
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            $cart[$id]['cantidad'] = $request->cantidad;
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Carrito actualizado.');
    }

    // Elimina un producto del carrito
    public function remove($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Producto eliminado del carrito.');
    }

    // Procesa la compra
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('catalogo.index')->with('error', 'Tu carrito está vacío.');
        }

        try {
            DB::beginTransaction();

            // 1. Calcular el total
            $total = 0;
            foreach ($cart as $id => $details) {
                $total += $details['precio'] * $details['cantidad'];
            }

            // 2. Crear la Venta
            // Usamos el primer usuario que exista como vendedor por defecto,
            // ya que no hay un sistema de login de clientes.
            // En un sistema real, aquí iría el ID del cliente autenticado.
            $venta = Venta::create([
                'user_id' => Auth::id() ?? 1, // Si no hay login, se asigna al usuario 1 (Admin)
                'total' => $total,
            ]);

            // 3. Crear los Detalles de la Venta y Actualizar Stock
            foreach ($cart as $id => $details) {
                $medicamento = Medicamento::find($id);

                // Verificación de stock
                if ($medicamento->stock < $details['cantidad']) {
                    throw new \Exception('No hay stock suficiente para ' . $medicamento->nombre);
                }

                VentaDetalle::create([
                    'venta_id' => $venta->id,
                    'medicamento_id' => $id,
                    'cantidad' => $details['cantidad'],
                    'precio_unitario' => $details['precio'],
                ]);

                // Descontar stock
                $medicamento->decrement('stock', $details['cantidad']);
            }

            DB::commit();

            // 4. Vaciar el carrito
            session()->forget('cart');

            // 5. Redirigir con mensaje de éxito
            return redirect()->route('catalogo.index')->with('success', '¡Gracias por tu compra! Tu pedido ha sido procesado.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Redirigir con un mensaje de error
            return redirect()->route('cart.index')->with('error', 'Error al procesar la compra: ' . $e->getMessage());
        }
    }
}
