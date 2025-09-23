<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use App\Models\User;

class RolesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $adminRole;

    protected function setUp(): void
    {
        parent::setUp();

        // Ejecutar migraciones de Spatie
        $this->artisan('migrate');

        // Crear permisos de prueba
        Permission::create(['name' => 'ver-role']);
        Permission::create(['name' => 'crear-role']);
        Permission::create(['name' => 'editar-role']);
        Permission::create(['name' => 'eliminar-role']);

        // Crear rol de administrador y asignar todos los permisos
        $this->adminRole = Role::create(['name' => 'Admin']);
        $this->adminRole->givePermissionTo([
            'ver-role',
            'crear-role',
            'editar-role',
            'eliminar-role'
        ]);

        // Crear usuario con factory (como en tu AuthTest)
        $this->user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        // Asignar rol de administrador al usuario
        $this->user->assignRole('Admin');
    }

    /** @test */
    public function un_usuario_con_permiso_puede_listar_roles()
    {
        Role::create(['name' => 'Editor']);

        $response = $this->actingAs($this->user) // ← Usuario autenticado con rol Admin
            ->get(route('roles.index'));

        $response->assertStatus(200);
        $response->assertSee('Editor');
    }

    /** @test */
    public function un_usuario_con_permiso_puede_crear_un_rol()
    {
        $permission = Permission::first();

        $response = $this->actingAs($this->user)
            ->post(route('roles.store'), [
                'name' => 'Editor',
                'permission' => [$permission->id],
            ]);

        $response->assertRedirect(route('roles.index'));
        $this->assertDatabaseHas('roles', ['name' => 'Editor']);
    }

    /** @test */
    public function valida_que_el_nombre_y_permiso_sean_obligatorios()
    {
        $response = $this->actingAs($this->user)
            ->post(route('roles.store'), []);

        $response->assertSessionHasErrors(['name', 'permission']);
    }

    /** @test */
    public function usuario_con_permiso_puede_actualizar_un_rol()
    {
        $role = Role::create(['name' => 'Vendedor']);
        $permission = Permission::first();

        $response = $this->actingAs($this->user)
            ->put(route('roles.update', $role->id), [
                'name' => 'Supervisor',
                'permission' => [$permission->id],
            ]);

        $response->assertRedirect(route('roles.index'));
        $this->assertDatabaseHas('roles', ['name' => 'Supervisor']);
    }

    /** @test */
    public function usuario_con_permiso_puede_eliminar_un_rol()
    {
        $role = Role::create(['name' => 'Temporal']);

        $response = $this->actingAs($this->user)
            ->delete(route('roles.destroy', $role->id));

        $response->assertRedirect(route('roles.index'));
        $this->assertDatabaseMissing('roles', ['name' => 'Temporal']);
    }

    /** @test */
    public function usuario_sin_permisos_no_puede_acceder_a_roles()
    {
        // Crear usuario sin permisos
        $userWithoutPermissions = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($userWithoutPermissions)
            ->get(route('roles.index'));

        // Debe recibir 403 (Forbidden) o redirigir
        $response->assertStatus(403); // o assertRedirect si tu app redirige
    }
}
