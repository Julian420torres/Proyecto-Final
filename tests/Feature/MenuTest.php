<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Menu;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_usuario_con_permiso_puede_crear_un_nuevo_menu()
    {
        Storage::fake('public');

        $imagen = UploadedFile::fake()->image('menu.jpg');

        $data = [
            'nombre' => 'Menu Test',
            'descripcion' => 'Descripción del menu',
            'precio' => 25.50,
            'imagen' => $imagen
        ];

        $response = $this->post(route('menus.store'), $data);

        $response->assertRedirect(route('menus.index'));
        $this->assertDatabaseHas('menus', ['nombre' => 'Menu Test']);
    }

    /** @test */
    public function un_usuario_con_permiso_puede_actualizar_un_menu_existente()
    {
        $menu = Menu::create([
            'nombre' => 'Menu Original',
            'descripcion' => 'Descripción original',
            'precio' => 20.00,
            'imagen' => 'menus/default.jpg' // Imagen por defecto
        ]);

        $data = [
            'nombre' => 'Menu Actualizado',
            'descripcion' => 'Descripción actualizada',
            'precio' => 30.00
        ];

        $response = $this->put(route('menus.update', $menu), $data);

        $response->assertRedirect(route('menus.index'));
        $this->assertDatabaseHas('menus', ['nombre' => 'Menu Actualizado']);
    }

    /** @test */
    public function un_usuario_con_permiso_puede_eliminar_un_menu()
    {
        $menu = Menu::create([
            'nombre' => 'Menu a Eliminar',
            'descripcion' => 'Descripción',
            'precio' => 15.00,
            'imagen' => 'menus/default.jpg'
        ]);

        $response = $this->delete(route('menus.destroy', $menu));

        $response->assertRedirect(route('menus.index'));
        $this->assertDatabaseMissing('menus', ['id' => $menu->id]);
    }

    /** @test */
    public function formulario_valida_los_campos_obligatorios_al_crear_menu()
    {
        $response = $this->post(route('menus.store'), []);

        $response->assertSessionHasErrors(['nombre', 'precio']);
    }


    /** @test */
    public function un_usuario_con_permiso_puede_ver_los_menus()
    {
        $this->withoutExceptionHandling();

        // Crear usuario autenticado
        $this->actingAs(\App\Models\User::factory()->create());

        // Crear menús de prueba
        $menus = [
            Menu::create([
                'nombre' => 'Menu 1',
                'descripcion' => 'Descripción 1',
                'precio' => 25.50,
                'imagen' => null
            ]),
            Menu::create([
                'nombre' => 'Menu 2',
                'descripcion' => 'Descripción 2',
                'precio' => 30.00,
                'imagen' => null
            ]),
        ];

        $response = $this->get(route('menus.index'));

        $response->assertStatus(200);
        $response->assertViewIs('menus.index');
        $response->assertViewHas('menus');
    }
}
