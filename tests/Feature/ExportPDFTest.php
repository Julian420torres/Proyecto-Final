<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Persona;
use App\Models\Comprobante;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExportPDFTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_usuario_puede_generar_un_comprobante_de_la_venta()
    {
        // Creamos los datos mínimos relacionados
        $user = User::factory()->create();

        $persona = Persona::factory()->create();
        $cliente = Cliente::factory()->create([
            'persona_id' => $persona->id,
        ]);

        $comprobante = Comprobante::factory()->create();

        $venta = Venta::factory()->create([
            'user_id' => $user->id,
            'cliente_id' => $cliente->id,
            'comprobante_id' => $comprobante->id,
        ]);

        // Simulamos la petición a la ruta
        $response = $this->get(route('export.pdf-comprobante-venta', ['id' => $venta->id]));

        // Aserciones
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
        $this->assertNotEmpty($response->getContent(), 'El PDF generado está vacío');
    }
}
