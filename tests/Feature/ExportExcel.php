<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ExportExcel extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function un_usuario_puede_exportar_todas_las_ventas_en_excel()
    {
        // Crear un usuario y autenticarlo
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear ventas de prueba
        Venta::factory()->count(3)->create();

        // Ejecutar la ruta
        $response = $this->get(route('export.excel-ventas-all'));

        // Validar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Validar headers de descarga Excel
        $this->assertStringContainsString(
            'ventas.xlsx',
            $response->headers->get('content-disposition')
        );

        $this->assertStringContainsString(
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            $response->headers->get('content-type')
        );
    }
}
