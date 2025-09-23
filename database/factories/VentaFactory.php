<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Comprobante;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venta>
 */
class VentaFactory extends Factory
{
    protected $model = Venta::class;

    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::factory(),
            'comprobante_id' => Comprobante::factory(),
            'user_id' => User::factory(), // si tienes UserFactory, sino pon un ID fijo
            'fecha_hora' => $this->faker->dateTime(),
            'impuesto' => $this->faker->randomFloat(2, 1, 20),
            'numero_comprobante' => $this->faker->unique()->numerify('COMP-#####'),
            'total' => $this->faker->randomFloat(2, 100, 1000),
            'estado' => 1,
        ];
    }
}
