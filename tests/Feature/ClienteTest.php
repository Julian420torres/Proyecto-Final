<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Persona;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Role $role;

    protected function setUp(): void
    {
        parent::setUp();

        // Creamos permisos
        Permission::create(['name' => 'ver-cliente']);
        Permission::create(['name' => 'crear-cliente']);
        Permission::create(['name' => 'editar-cliente']);
        Permission::create(['name' => 'eliminar-cliente']);

        // Rol con permisos
        $this->role = Role::create(['name' => 'admin']);
        $this->role->givePermissionTo(Permission::all());

        // Usuario con rol
        $this->user = User::factory()->create();
        $this->user->assignRole($this->role);
    }

    /** @test */
    public function un_usuario_con_permiso_puede_ver_la_lista_de_clientes()
    {
        $this->actingAs($this->user)
            ->get(route('clientes.index'))
            ->assertStatus(200)
            ->assertViewIs('cliente.index');
    }

    /** @test */
    public function un_usuario_sin_permiso_no_puede_ver_la_lista_de_clientes()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->get(route('clientes.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function un_usuario_con_permiso_puede_crear_un_cliente()
    {
        $doc = Documento::forceCreate([
            'tipo_documento' => 'CC',
        ]);


        $data = [
            'razon_social' => 'Cliente Prueba',
            'direccion' => 'Calle Falsa 123',
            'tipo_persona' => 'Natural',
            'documento_id' => $doc->id,
            'numero_documento' => '12345678',
        ];

        $this->actingAs($this->user)
            ->post(route('clientes.store'), $data)
            ->assertRedirect(route('clientes.index'));

        $this->assertDatabaseHas('personas', [
            'razon_social' => 'Cliente Prueba',
        ]);
        $this->assertDatabaseHas('clientes', [
            'persona_id' => Persona::first()->id,
        ]);
    }

    /** @test */
    public function no_se_puede_crear_cliente_con_datos_invalidos()
    {
        $this->actingAs($this->user)
            ->post(route('clientes.store'), [])
            ->assertSessionHasErrors(['razon_social', 'direccion', 'documento_id', 'numero_documento']);
    }

    /** @test */
    public function un_usuario_con_permiso_puede_actualizar_cliente()
    {
        $doc = Documento::forceCreate([
            'tipo_documento' => 'CC',
        ]);


        $persona = Persona::create([
            'razon_social' => 'Cliente Viejo',
            'direccion' => 'Calle 1',
            'tipo_persona' => 'Juridico',
            'documento_id' => $doc->id,
            'numero_documento' => '9999',
        ]);

        $cliente = Cliente::create(['persona_id' => $persona->id]);

        $updateData = [
            'razon_social' => 'Cliente Nuevo',
            'direccion' => 'Calle 2',
            'documento_id' => $doc->id,
            'numero_documento' => '8888',
        ];

        $this->actingAs($this->user)
            ->put(route('clientes.update', $cliente), $updateData)
            ->assertRedirect(route('clientes.index'));

        $this->assertDatabaseHas('personas', [
            'razon_social' => 'Cliente Nuevo',
        ]);
    }

    /** @test */
    public function un_usuario_con_permiso_puede_eliminar_y_restaurar_cliente()
    {
        $doc = Documento::forceCreate([
            'tipo_documento' => 'CC',
        ]);


        $persona = Persona::create([
            'razon_social' => 'Cliente Eliminar',
            'direccion' => 'Calle X',
            'tipo_persona' => 'Natural',
            'documento_id' => $doc->id,
            'numero_documento' => '7777',
        ]);

        $cliente = Cliente::create(['persona_id' => $persona->id]);

        // Eliminar
        $this->actingAs($this->user)
            ->delete(route('clientes.destroy', $persona->id))
            ->assertRedirect(route('clientes.index'));

        $this->assertDatabaseHas('personas', [
            'id' => $persona->id,
            'estado' => 0,
        ]);

        // Restaurar
        $this->actingAs($this->user)
            ->delete(route('clientes.destroy', $persona->id));

        $this->assertDatabaseHas('personas', [
            'id' => $persona->id,
            'estado' => 1,
        ]);
    }
}
