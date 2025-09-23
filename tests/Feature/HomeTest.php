<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_usuario_autenticado_puede_ver_el_panel_principal()
    {
        // Crear un usuario
        $user = User::factory()->create();

        // Autenticarse
        $this->actingAs($user);

        // Hacer la petición al home
        $response = $this->get(route('panel'));

        // Validar que carga correctamente
        $response->assertStatus(200);

        // Validar la vista que realmente retorna tu controlador
        $response->assertViewIs('panel.index');
    }
}
