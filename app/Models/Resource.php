<?php
declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    /** @use HasFactory<\Database\Factories\ResourceFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'github_id',
        'description',
        'title',
        'url',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
