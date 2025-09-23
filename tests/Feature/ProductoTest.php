<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Caracteristica;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Permission;

class ProductoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();


        foreach (['ver-producto', 'crear-producto', 'editar-producto', 'eliminar-producto'] as $permiso) {
            Permission::firstOrCreate(['name' => $permiso, 'guard_name' => 'web']);
        }
    }

    /** @test */
    public function un_usuario_con_permiso_puede_ver_la_lista_de_productos()
    {
        $user = User::factory()->create();
        $user->givePermissionTo(['ver-producto']);
        $this->actingAs($user);

        $caracteristica = Caracteristica::factory()->create();
        $categoria = Categoria::factory()->create([
            'caracteristica_id' => $caracteristica->id,
        ]);
        $producto = Producto::factory()->create();
        $producto->categorias()->attach($categoria->id);

        $response = $this->get(route('productos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('producto.index');
        $response->assertSee($producto->nombre);
    }

    /** @test */
    public function un_usuario_con_permiso_puede_crear_un_producto()
    {
        $user = User::factory()->create();
        $user->givePermissionTo(['ver-producto', 'crear-producto']);
        $this->actingAs($user);

        $caracteristica = Caracteristica::factory()->create();
        $categoria = Categoria::factory()->create([
            'caracteristica_id' => $caracteristica->id,
        ]);

        $data = [
            'codigo' => 'P001',
            'nombre' => 'Producto Test',
            'descripcion' => 'Descripcion test',
            'fecha_vencimiento' => now()->addYear()->toDateString(),
            'categorias' => [$categoria->id],
        ];

        $response = $this->post(route('productos.store'), $data);

        $response->assertRedirect(route('productos.index'));
        $this->assertDatabaseHas('productos', ['nombre' => 'Producto Test']);
        $this->assertDatabaseHas('categoria_producto', [
            'categoria_id' => $categoria->id,
        ]);
    }

    /** @test */
    public function un_usuario_con_permiso_puede_actualizar_un_producto()
    {
        $user = User::factory()->create();
        $user->givePermissionTo(['ver-producto', 'editar-producto']);
        $this->actingAs($user);

        $caracteristica = Caracteristica::factory()->create();
        $categoria = Categoria::factory()->create([
            'caracteristica_id' => $caracteristica->id,
        ]);

        $producto = Producto::factory()->create();
        $producto->categorias()->attach($categoria->id);

        $data = [
            'codigo' => 'P002',
            'nombre' => 'Producto Editado',
            'descripcion' => 'Descripcion editada',
            'fecha_vencimiento' => now()->addYear()->toDateString(),
            'categorias' => [$categoria->id],
        ];

        $response = $this->put(route('productos.update', $producto), $data);

        $response->assertRedirect(route('productos.index'));
        $this->assertDatabaseHas('productos', ['nombre' => 'Producto Editado']);
    }

    /** @test */
    public function un_usuario_con_permiso_puede_eliminar_y_restaurar_un_producto()
    {
        $user = User::factory()->create();
        $user->givePermissionTo(['ver-producto', 'eliminar-producto']);
        $this->actingAs($user);

        $producto = Producto::factory()->create();

        // Eliminar
        $response = $this->delete(route('productos.destroy', $producto->id));
        $response->assertRedirect(route('productos.index'));
        $this->assertDatabaseHas('productos', [
            'id' => $producto->id,
            'estado' => 0
        ]);

        // Restaurar
        $response = $this->delete(route('productos.destroy', $producto->id));
        $response->assertRedirect(route('productos.index'));
        $this->assertDatabaseHas('productos', [
            'id' => $producto->id,
            'estado' => 1
        ]);
    }
    /** @test */
    public function un_usuario_sin_permisos_no_puede_acceder_al_modulo_de_productos()
    {
        $user = User::factory()->create();
        // No le damos ningún permiso
        $this->actingAs($user);

        $producto = Producto::factory()->create();

        // Intentar acceder al index
        $this->get(route('productos.index'))->assertStatus(403);

        // Intentar crear
        $this->get(route('productos.create'))->assertStatus(403);
        $this->post(route('productos.store'), [])->assertStatus(403);

        // Intentar editar
        $this->get(route('productos.edit', $producto))->assertStatus(403);
        $this->put(route('productos.update', $producto), [])->assertStatus(403);

        // Intentar eliminar
        $this->delete(route('productos.destroy', $producto))->assertStatus(403);
    }
    /** @test */
    public function el_sistema_valida_los_campos_del_formulario()
    {
        $user = User::factory()->create()->givePermissionTo('editar-producto');
        $this->actingAs($user);

        $producto = Producto::factory()->create();

        // Enviamos datos inválidos
        $response = $this->put(route('productos.update', $producto), [
            'codigo' => '', // requerido
            'nombre' => '', // requerido
            'categorias' => '', // requerido
        ]);

        $response->assertSessionHasErrors([
            'codigo',
            'nombre',
            'categorias',
        ]);
    }
}
