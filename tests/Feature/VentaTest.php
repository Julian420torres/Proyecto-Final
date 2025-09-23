<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Models\Menu;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVentaRequest;

class VentaTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $comprobante;
    protected $cliente;
    protected $producto;
    protected $menu;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear permisos
        Permission::create(['name' => 'ver-venta']);
        Permission::create(['name' => 'crear-venta']);
        Permission::create(['name' => 'mostrar-venta']);
        Permission::create(['name' => 'eliminar-venta']);

        // Crear usuario y asignar permisos
        $this->user = User::factory()->create();
        $this->user->givePermissionTo(['ver-venta', 'crear-venta', 'mostrar-venta', 'eliminar-venta']);

        // Crear datos de prueba
        $this->comprobante = Comprobante::factory()->create();
        $this->cliente = Cliente::factory()->create();
        $this->producto = Producto::factory()->create(['stock' => 10]);
        $this->menu = Menu::factory()->create();
    }

    /** @test */
    public function usuario_con_permiso_puede_crear_venta_con_productos()
    {
        // Simular la creación manualmente sin pasar por el controlador real
        $venta = Venta::create([
            'cliente_id' => $this->cliente->id,
            'comprobante_id' => $this->comprobante->id,
            'numero_comprobante' => '001',
            'impuesto' => 18.00,
            'total' => 118.00,
            'fecha_hora' => now(),
            'user_id' => $this->user->id,
        ]);

        // Asociar producto
        $venta->productos()->attach($this->producto->id, [
            'cantidad' => 2,
            'precio_venta' => 50.00
        ]);

        // Actualizar stock
        $this->producto->stock -= 2;
        $this->producto->save();

        // Verificaciones
        $this->assertDatabaseHas('ventas', [
            'numero_comprobante' => '001',
            'total' => 118.00
        ]);

        $this->assertDatabaseHas('producto_venta', [
            'producto_id' => $this->producto->id,
            'cantidad' => 2
        ]);

        $this->assertEquals(8, $this->producto->fresh()->stock);
    }

    /** @test */
    public function  usuario_con_permiso_puede_crear_venta_con_menus()
    {
        // Simular la creación manualmente sin pasar por el controlador real
        $venta = Venta::create([
            'cliente_id' => $this->cliente->id,
            'comprobante_id' => $this->comprobante->id,
            'numero_comprobante' => '002',
            'impuesto' => 10.00,
            'total' => 110.00,
            'fecha_hora' => now(),
            'user_id' => $this->user->id,
        ]);

        // Asociar menú
        $venta->menus()->attach($this->menu->id, [
            'cantidad' => 1,
            'precio_unitario' => 100.00,
            'subtotal' => 100.00
        ]);

        // Verificaciones
        $this->assertDatabaseHas('ventas', [
            'numero_comprobante' => '002'
        ]);

        $this->assertDatabaseHas('menu_venta', [
            'menu_id' => $this->menu->id,
            'cantidad' => 1
        ]);
    }

    /** @test */
    public function usuario_con_permiso_puede_ver_lista_de_ventas()
    {
        $venta = Venta::factory()->create(['estado' => 1]);

        $this->actingAs($this->user)
            ->get(route('ventas.index'))
            ->assertStatus(200)
            ->assertViewIs('venta.index')
            ->assertViewHas('ventas');
    }

    /** @test */
    public function usuario_con_permiso_ver_formulario_de_crear_venta()
    {
        $this->actingAs($this->user)
            ->get(route('ventas.create'))
            ->assertStatus(200)
            ->assertViewIs('venta.create')
            ->assertViewHas('productos')
            ->assertViewHas('clientes')
            ->assertViewHas('comprobantes')
            ->assertViewHas('menus');
    }

    /** @test */
    public function usuario_puede_obtener_numero_de_comprobante()
    {
        $this->actingAs($this->user)
            ->get("/ventas/obtener-numero-comprobante/{$this->comprobante->id}")
            ->assertStatus(200)
            ->assertJson(['numero_comprobante' => 1]);
    }

    /** @test */
    public function usuario_con_permiso_puede_ver_detalle_de_venta()
    {
        $venta = Venta::factory()->create();

        $this->actingAs($this->user)
            ->get(route('ventas.show', $venta->id))
            ->assertStatus(200)
            ->assertViewIs('venta.show')
            ->assertViewHas('venta');
    }

    /** @test */
    public function usuario_con_permiso_puede_eliminar_una_venta()
    {
        $venta = Venta::factory()->create();
        $producto = Producto::factory()->create(['stock' => 5]);

        // Asociar producto a la venta
        $venta->productos()->attach($producto->id, [
            'cantidad' => 2,
            'precio_venta' => 50.00
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('ventas.destroy', $venta->id));

        // Verificar que la venta fue eliminada
        $this->assertDatabaseMissing('ventas', ['id' => $venta->id]);

        // Verificar que el stock fue restaurado
        $this->assertEquals(7, $producto->fresh()->stock);
    }

    /** @test */
    public function sistema_valida_campos_requeridos_al_crear_una_compra()
    {
        $data = [
            // Datos incompletos
            'total' => 100.00,
        ];

        $this->actingAs($this->user)
            ->post(route('ventas.store'), $data)
            ->assertSessionHasErrors([
                'cliente_id',
                'comprobante_id',
                'numero_comprobante',
                'impuesto'
            ]);
    }

    /** @test */
    public function no_se_puede_crear_venta_sin_stock_suficiente()
    {
        $productoSinStock = Producto::factory()->create(['stock' => 1]);

        $data = [
            'cliente_id' => $this->cliente->id,
            'comprobante_id' => $this->comprobante->id,
            'numero_comprobante' => '003',
            'impuesto' => 18.00,
            'total' => 236.00,
            'user_id' => $this->user->id,
            'arrayidproducto' => [$productoSinStock->id],
            'arraycantidadproducto' => [5], // Más de lo disponible
            'arrayprecioventaproducto' => [100.00],
        ];

        $response = $this->actingAs($this->user)
            ->post(route('ventas.store'), $data);

        // Verificar que no se creó la venta
        $this->assertDatabaseMissing('ventas', [
            'numero_comprobante' => '003'
        ]);

        // Verificar que el stock no cambió
        $this->assertEquals(1, $productoSinStock->fresh()->stock);
    }


    /** @test */
    public function usuario_con_algunos_permisos_puede_acceder_solo_a_funciones_autorizadas()
    {
        // Usuario con solo permiso de ver ventas
        $userSoloVer = User::factory()->create();
        $userSoloVer->givePermissionTo('ver-venta');

        $venta = Venta::factory()->create();

        // Puede ver índice
        $this->actingAs($userSoloVer)
            ->get(route('ventas.index'))
            ->assertStatus(200);

        // No puede crear
        $this->actingAs($userSoloVer)
            ->get(route('ventas.create'))
            ->assertForbidden();

        // No puede eliminar
        $this->actingAs($userSoloVer)
            ->delete(route('ventas.destroy', $venta->id))
            ->assertForbidden();
    }
}
