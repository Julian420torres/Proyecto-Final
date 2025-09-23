<?php

namespace Database\Factories;

use App\Models\Compra;
use App\Models\Comprobante; // ← Agregar este use
use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompraFactory extends Factory
{
    protected $model = Compra::class;

    public function definition(): array
    {
        return [
            // REMOVER esta línea:
            // 'tipo_comprobante' => $this->faker->randomElement(['Factura', 'Boleta']),

            // AGREGAR esta línea:
            'comprobante_id' => Comprobante::factory(),

            'numero_comprobante' => $this->faker->unique()->numerify('C-###'),
            'fecha_hora' => now(),
            'impuesto' => 19,
            'total' => 1000,
            'estado' => 1,
        ];
    }
}
