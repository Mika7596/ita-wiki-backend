<?php

declare (strict_types= 1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;

class UpdateRoleTest extends TestCase
{
    protected $student;
    protected $mentor;
    protected $admin;
    protected $superadmin;

    public function setUp(): void
    {
        parent::setUp();
        $this->student = Role::factory()->create([
            'github_id' => 123456,
            'role' => 'student'
        ]);
        $this->mentor = Role::factory()->create([
            'github_id' => 234567,
            'role' => 'mentor'
        ]);
        $this->admin = Role::factory()->create([
            'github_id' => 345678,
            'role' => 'admin'
        ]);
        $this->superadmin = Role::factory()->create([
            'github_id' => 456789,
            'role' => 'superadmin'
        ]);
    }

    public function testCanUpdateRoleToLower(): void
    {
        $this->putJson(route('roles.update'), [
            'authorized_github_id' => $this->admin->github_id,
            'github_id' => $this->student->github_id,
            'role' => 'mentor'
        ])->assertStatus(200);

        $this->assertDatabaseHas('roles', [
            'github_id' => $this->student->github_id,
            'role' => 'mentor'
        ]);
    }

    public function testCannotUpdateRoleToEqual(): void
    {
        $this->putJson(route('roles.update'), [
            'authorized_github_id' => $this->superadmin->github_id,
            'github_id' => $this->student->github_id,
            'role' => 'superadmin'
        ])->assertStatus(403);

        $this->assertDatabaseMissing('roles', [
            'github_id' => $this->student->github_id,
            'role' => 'superadmin'
        ]);
    }

    public function testCannotUpdateRoleToHigher(): void
    {
        $this->putJson(route('roles.update'), [
            'authorized_github_id' => $this->mentor->github_id,
            'github_id' => $this->student->github_id,
            'role' => 'admin'
        ])->assertStatus(403);

        $this->assertDatabaseMissing('roles', [
            'github_id' => $this->student->github_id,
            'role' => 'admin'
        ]);
    }

    public function testCannotUpdateRoleToNonExistent(): void
    {
        $this->putJson(route('roles.update'), [
            'authorized_github_id' => $this->admin->github_id,
            'github_id' => $this->student->github_id,
            'role' => 'nonexistent'
        ])->assertStatus(422);

        $this->assertDatabaseMissing('roles', [
            'github_id' => $this->student->github_id,
            'role' => 'nonexistent'
        ]);
    }

    public function testCannotUpdateRoleWithNonExistentAuthorized(): void
    {
        $this->putJson(route('roles.update'), [
            'authorized_github_id' => 999999,
            'github_id' => $this->student->github_id,
            'role' => 'mentor'
        ])->assertStatus(422);

        $this->assertDatabaseMissing('roles', [
            'github_id' => $this->student->github_id,
            'role' => 'mentor'
        ]);
    }
}
