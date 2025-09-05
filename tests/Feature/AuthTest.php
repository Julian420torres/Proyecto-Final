<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_usuario_puede_iniciar_sesion()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Debe redirigir al panel (/)
        $response->assertRedirect(route('panel'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function un_usuario_no_puede_iniciar_sesion_con_credenciales_invalidas()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        // Debe volver al login con errores
        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /** @test */
    public function un_usuario_autenticado_puede_cerrar_sesion()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        $response = $this->get('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
