<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_usuario_autenticado_puede_ver_su_perfil()
    {
        // Crear el permiso necesario
        Permission::create(['name' => 'ver-perfil']);

        // Crear el usuario
        $user = User::factory()->create();

        // Asignar el permiso
        $user->givePermissionTo('ver-perfil');

        // Autenticar al usuario
        $this->actingAs($user);

        // Hacer la petición
        $response = $this->get('/profile');

        // Validar respuesta
        $response->assertStatus(200);
    }
}
