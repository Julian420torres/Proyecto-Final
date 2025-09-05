<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $userRole;
    protected $adminRole;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');

        Permission::create(['name' => 'ver-user']);
        Permission::create(['name' => 'crear-user']);
        Permission::create(['name' => 'editar-user']);
        Permission::create(['name' => 'eliminar-user']);

        $this->userRole = Role::create(['name' => 'User']);
        $this->adminRole = Role::create(['name' => 'Admin']);

        $this->adminRole->givePermissionTo(Permission::all());

        $this->adminUser = User::factory()->create([
            'email' => 'admin@ejemplo.com',
            'password' => bcrypt('password123')
        ]);
        $this->adminUser->assignRole('Admin');
    }

    public function test_administrador_puede_crear_usuario()
    {
        $userData = [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@ejemplo.com',
            'password' => 'password123',
            'password_confirm' => 'password123',
            'role' => 'User'
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('users.store'), $userData);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@ejemplo.com'
        ]);
    }

    public function test_administrador_puede_actualizar_usuario_con_nueva_contraseña()
    {
        $user = User::factory()->create();
        $user->assignRole('User');

        $updateData = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'nuevapassword123',
            'password_confirm' => 'nuevapassword123',
            'role' => 'User'
        ];

        $response = $this->actingAs($this->adminUser)
            ->put(route('users.update', $user->id), $updateData);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email
        ]);

        $response->assertRedirect();
    }

    public function test_administrador_puede_listar_usuarios()
    {
        User::factory()->count(3)->create();

        $response = $this->actingAs($this->adminUser)
            ->get(route('users.index'));

        $response->assertStatus(200);
        $response->assertViewHas('users');
    }

    public function test_administrador_puede_ver_formulario_crear_usuario()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('users.create'));

        $response->assertStatus(200);
    }

    public function test_administrador_puede_ver_formulario_editar_usuario()
    {
        $user = User::factory()->create();
        $user->assignRole('User');

        $response = $this->actingAs($this->adminUser)
            ->get(route('users.edit', $user->id));

        $response->assertStatus(200);
    }

    public function test_administrador_puede_actualizar_usuario()
    {
        $user = User::factory()->create();
        $user->assignRole('User');

        $updateData = [
            'name' => 'Usuario Actualizado',
            'email' => 'actualizado@ejemplo.com',
            'role' => 'User'
        ];

        $response = $this->actingAs($this->adminUser)
            ->put(route('users.update', $user->id), $updateData);

        $this->assertDatabaseHas('users', [
            'name' => 'Usuario Actualizado',
            'email' => 'actualizado@ejemplo.com'
        ]);

        $response->assertRedirect();
    }

    public function test_administrador_puede_eliminar_usuario()
    {
        $user = User::factory()->create();
        $user->assignRole('User');

        $response = $this->actingAs($this->adminUser)
            ->delete(route('users.destroy', $user->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_usuario_creado_puede_iniciar_sesion()
    {
        $user = User::factory()->create([
            'name' => 'Usuario de Prueba',
            'email' => 'prueba@ejemplo.com',
            'password' => bcrypt('password123')
        ]);
        $user->assignRole('User');

        $response = $this->post('/login', [
            'email' => 'prueba@ejemplo.com',
            'password' => 'password123'
        ]);

        $response->assertRedirect();
        $this->assertAuthenticated();
    }

    public function test_usuario_sin_permisos_no_puede_acceder_a_usuarios()
    {
        $normalUser = User::factory()->create();
        $normalUser->assignRole('User');

        $response = $this->actingAs($normalUser)
            ->get(route('users.index'));

        $response->assertStatus(403);
    }

    public function test_validacion_funciona_al_crear_usuario()
    {
        $invalidData = [
            'name' => '',
            'email' => 'email-invalido',
            'password' => 'short',
            'password_confirm' => 'different',
            'role' => 'RolInexistente'
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('users.store'), $invalidData);

        $response->assertSessionHasErrors(['name', 'email', 'password', 'role']);
    }
}
