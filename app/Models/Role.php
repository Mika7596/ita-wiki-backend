<?php
declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;

    protected $table = 'roles';
    protected $fillable = [
        'github_id',
        'role'
    ];

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    // Since we have not implemented middleware, the following may be useful

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }


    public function isMentor(): bool
    {
        return $this->role === 'mentor';
    }

    public function isAnonymous(): bool
    {
        return $this->role === 'anonymous';
    }
}
