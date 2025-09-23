<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Categoria;
use App\Models\Caracteristica;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;

class CategoriaTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear permisos específicos para este test
        Permission::create(['name' => 'ver-categoria', 'guard_name' => 'web']);
        Permission::create(['name' => 'crear-categoria', 'guard_name' => 'web']);
        Permission::create(['name' => 'editar-categoria', 'guard_name' => 'web']);
        Permission::create(['name' => 'eliminar-categoria', 'guard_name' => 'web']);
    }

    /** @test */
    public function un_usuario_con_permiso_puede_crear_una_nueva_categoria()
    {
        $user = \App\Models\User::factory()->create();
        $permission = Permission::findByName('crear-categoria');
        $user->givePermissionTo($permission);
        $this->actingAs($user);

        $data = [
            'nombre' => 'Electrónicos',
            'descripcion' => 'Productos electrónicos varios',
            'estado' => 1
        ];

        $response = $this->post(route('categorias.store'), $data);

        $response->assertRedirect(route('categorias.index'));
        $this->assertDatabaseHas('caracteristicas', ['nombre' => 'Electrónicos']);
    }

    /** @test */
    public function un_usuario_con_permiso_puede_actualizar_una_categoria_existente()
    {
        $user = \App\Models\User::factory()->create();
        $permission = Permission::findByName('editar-categoria');
        $user->givePermissionTo($permission);
        $this->actingAs($user);

        // Crear categoría existente
        $caracteristica = Caracteristica::create([
            'nombre' => 'Original',
            'descripcion' => 'Descripción original',
            'estado' => 1
        ]);

        $categoria = Categoria::create([
            'caracteristica_id' => $caracteristica->id
        ]);

        $data = [
            'nombre' => 'Nombre Actualizado',
            'descripcion' => 'Descripción actualizada',
            'estado' => 1
        ];

        $response = $this->put(route('categorias.update', $categoria), $data);

        $response->assertRedirect(route('categorias.index'));
        $this->assertDatabaseHas('caracteristicas', [
            'id' => $caracteristica->id,
            'nombre' => 'Nombre Actualizado'
        ]);
    }

    /** @test */
    public function usuario_con_permiso_puede_eliminar_una_categoria_cambiando_su_estado_a_inactivo()
    {
        $user = \App\Models\User::factory()->create();
        $permission = Permission::findByName('eliminar-categoria');
        $user->givePermissionTo($permission);
        $this->actingAs($user);

        $caracteristica = Caracteristica::create([
            'nombre' => 'Test Categoria',
            'descripcion' => 'Test Descripción',
            'estado' => 1
        ]);

        $categoria = Categoria::create([
            'caracteristica_id' => $caracteristica->id
        ]);

        $response = $this->delete(route('categorias.destroy', $categoria));

        $response->assertRedirect(route('categorias.index'));
        $this->assertDatabaseHas('caracteristicas', [
            'id' => $caracteristica->id,
            'estado' => 0
        ]);
    }
    /** @test */
    /** @test */
    /** @test */
    /** @test */
    public function usuario_con_permiso_puede_reactivar_una_categoria_inactiva()
    {
        $user = \App\Models\User::factory()->create();
        $permission = Permission::findByName('eliminar-categoria');
        $user->givePermissionTo($permission);
        $this->actingAs($user);

        // Crear una característica INACTIVA directamente
        $caracteristica = Caracteristica::create([
            'nombre' => 'Categoria Reactivar',
            'descripcion' => 'Descripción para reactivar',
            'estado' => 0 // Ahora sí se guardará correctamente
        ]);

        // Crear una categoría asociada
        $categoria = Categoria::create([
            'caracteristica_id' => $caracteristica->id
        ]);

        // Verificar que está inactiva ANTES de reactivar
        $this->assertDatabaseHas('caracteristicas', [
            'id' => $caracteristica->id,
            'estado' => 0
        ]);

        // Reactivar
        $response = $this->delete(route('categorias.destroy', $categoria->id));
        $response->assertRedirect(route('categorias.index'));

        // Verificar que el estado cambió a activo (1)
        $this->assertDatabaseHas('caracteristicas', [
            'id' => $caracteristica->id,
            'estado' => 1
        ]);
    }





    /** @test */
    public function valida_los_campos_obligatorios_al_crear_una_categoria()
    {
        $user = \App\Models\User::factory()->create();
        $permission = Permission::findByName('crear-categoria');
        $user->givePermissionTo($permission);
        $this->actingAs($user);

        $response = $this->post(route('categorias.store'), []);

        $response->assertSessionHasErrors(['nombre']);
    }

    /** @test */
    public function usuario_con_permiso_puede_ver_la_lista_de_categorias()
    {
        $user = \App\Models\User::factory()->create();
        $permission = Permission::findByName('ver-categoria');
        $user->givePermissionTo($permission);
        $this->actingAs($user);

        $response = $this->get(route('categorias.index'));

        $response->assertStatus(200);
        $response->assertViewIs('categoria.index');
    }

    /** @test */
    public function muestra_el_formulario_de_creacion_de_categoria()
    {
        $user = \App\Models\User::factory()->create();
        $permission = Permission::findByName('crear-categoria');
        $user->givePermissionTo($permission);
        $this->actingAs($user);

        $response = $this->get(route('categorias.create'));

        $response->assertStatus(200);
        $response->assertViewIs('categoria.create');
    }

    /** @test */
    public function muestra_el_formulario_de_edicion_de_categoria()
    {
        $user = \App\Models\User::factory()->create();
        $permission = Permission::findByName('editar-categoria');
        $user->givePermissionTo($permission);
        $this->actingAs($user);

        $caracteristica = Caracteristica::create([
            'nombre' => 'Categoria a Editar',
            'descripcion' => 'Descripción para editar',
            'estado' => 1
        ]);

        $categoria = Categoria::create([
            'caracteristica_id' => $caracteristica->id
        ]);

        $response = $this->get(route('categorias.edit', $categoria));

        $response->assertStatus(200);
        $response->assertViewIs('categoria.edit');
        $response->assertViewHas('categoria', $categoria);
    }
}
