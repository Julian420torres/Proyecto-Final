<?php

namespace Tests\Feature;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CompraTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $comprobante;
    protected $userSinPermisos;

    protected function setUp(): void
    {
        parent::setUp();

        $this->comprobante = Comprobante::factory()->create();

        foreach (['ver-compra', 'crear-compra', 'mostrar-compra', 'eliminar-compra'] as $permiso) {
            Permission::firstOrCreate(['name' => $permiso, 'guard_name' => 'web']);
        }

        $rol = Role::firstOrCreate(['name' => 'admin-test']);
        $rol->givePermissionTo(Permission::all());

        $this->user = User::factory()->create();
        $this->user->assignRole($rol);

        $this->userSinPermisos = User::factory()->create();

        $this->actingAs($this->user);
    }

    protected function logout()
    {
        auth()->logout();
        session()->flush();
    }

    /** @test */
    public function usuario_con_permisos_puede_crear_una_nueva_compra()
    {
        $producto = Producto::factory()->create(['stock' => 5]);

        $data = [
            'comprobante_id' => $this->comprobante->id,
            'numero_comprobante' => 'C-001',
            'fecha_hora' => now()->toDateTimeString(),
            'impuesto' => 19,
            'total' => 1000,
            'arrayidproducto' => [$producto->id],
            'arraycantidad' => [3],
            'arraypreciocompra' => [200],
            'arrayprecioventa' => [300],
        ];

        $response = $this->post(route('compras.store'), $data);

        $response->assertRedirect(route('compras.index'));

        $this->assertDatabaseHas('compras', ['numero_comprobante' => 'C-001']);

        $this->assertDatabaseHas('compra_producto', [
            'producto_id' => $producto->id,
            'cantidad' => 3,
            'precio_compra' => 200,
            'precio_venta' => 300,
        ]);

        $this->assertEquals(8, $producto->fresh()->stock);
    }

    /** @test */
    public function usuario_con_permisos_puede_visualizar_los_detalles_de_una_compra()
    {
        $compra = Compra::factory()->create([
            'comprobante_id' => $this->comprobante->id
        ]);

        $response = $this->get(route('compras.show', $compra->id));

        $response->assertStatus(200);
        $response->assertViewHas('compra', $compra);
    }

    /** @test */
    public function usuario_con_permisos_puede_eliminar_una_compra_definitivamente()
    {
        $compra = Compra::factory()->create([
            'comprobante_id' => $this->comprobante->id,
            'estado' => 1
        ]);

        $response = $this->delete(route('compras.destroy', $compra->id));

        $response->assertRedirect(route('compras.index'));

        // ✅ Verificar que la compra fue eliminada de la base de datos
        $this->assertDatabaseMissing('compras', [
            'id' => $compra->id,
        ]);
    }

    /** @test */
    public function usuario_con_permiso_puede_visualizar_las_compras()
    {
        $compraActiva = Compra::factory()->create([
            'comprobante_id' => $this->comprobante->id,
            'estado' => 1
        ]);
        $compraInactiva = Compra::factory()->create([
            'comprobante_id' => $this->comprobante->id,
            'estado' => 0
        ]);

        $response = $this->get(route('compras.index'));

        $response->assertStatus(200);

        // ✅ Tu controlador muestra todas las compras
        $response->assertViewHas('compras', function ($compras) use ($compraActiva, $compraInactiva) {
            return $compras->contains($compraActiva) && $compras->contains($compraInactiva);
        });
    }

    /** @test */
    public function sistema_valida_campos_requeridos_al_crear_una_compra()
    {
        $response = $this->post(route('compras.store'), []);

        $response->assertSessionHasErrors([
            'comprobante_id',
            'numero_comprobante',
            'impuesto',
            'fecha_hora',
            'total',
        ]);
    }

    /** @test */
    public function sistema_crea_compra_correctamente_y_actualiza_el_stock_de_productos()
    {
        $producto = Producto::factory()->create(['stock' => 5]);

        $data = [
            'comprobante_id' => $this->comprobante->id,
            'numero_comprobante' => 'C-001',
            'impuesto' => 19,
            'fecha_hora' => now()->toDateTimeString(),
            'total' => 1000,
            'arrayidproducto' => [$producto->id],
            'arraycantidad' => [3],
            'arraypreciocompra' => [200],
            'arrayprecioventa' => [300],
        ];

        $response = $this->post(route('compras.store'), $data);

        $response->assertRedirect(route('compras.index'));

        $this->assertDatabaseHas('compras', ['numero_comprobante' => 'C-001']);

        $this->assertDatabaseHas('compra_producto', [
            'producto_id' => $producto->id,
            'cantidad' => 3,
            'precio_compra' => 200,
            'precio_venta' => 300,
        ]);

        $this->assertEquals(8, $producto->fresh()->stock);
    }

    /** @test */
    public function usuario_sin_permisos_no_puede_acceder_al_modulo_de_compras()
    {
        $this->logout();

        $this->actingAs($this->userSinPermisos);

        $responseIndex = $this->get(route('compras.index'));
        $responseCreate = $this->get(route('compras.create'));

        $compra = Compra::factory()->create(['comprobante_id' => $this->comprobante->id]);

        $responseShow = $this->get(route('compras.show', $compra->id));
        $responseDestroy = $this->delete(route('compras.destroy', $compra->id));

        $responseIndex->assertForbidden();
        $responseCreate->assertForbidden();
        $responseShow->assertForbidden();
        $responseDestroy->assertForbidden();
    }
}
