<?php

declare (strict_types= 1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;

class RoleSelfAssignmentTest extends TestCase
{
    protected $student;

    public function setUp(): void
    {
        parent::setUp();
        $this->student = Role::factory()->create([
            'github_id' => 123456,
            'role' => 'student'
        ]);
    }

    public function testCanSelfAssignRole(): void
    {
        $this->putJson(route('feature-flags.role-self-assignment'), [
            'github_id' => $this->student->github_id,
            'role' => 'mentor'
        ])->assertStatus(200);

        $this->assertDatabaseHas('roles', [
            'github_id' => $this->student->github_id,
            'role' => 'mentor'
        ]);
    }

    public function testCannotSelfAssignANonExistentRole(): void
    {
        $this->putJson(route('feature-flags.role-self-assignment'), [
            'github_id' => $this->student->github_id,
            'role' => 'nonexistent'
        ])->assertStatus(422);

        $this->assertDatabaseMissing('roles', [
            'github_id' => $this->student->github_id,
            'role' => 'nonexistent'
        ]);

        $this->assertDatabaseHas('roles', [
            'github_id' => $this->student->github_id,
            'role' => 'student'
        ]);
    }
}
