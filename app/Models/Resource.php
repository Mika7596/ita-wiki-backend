<?php
declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


    /**
     * @OA\Schema(
     *      schema="Resource",
     *      type="object",
     *      title="Resource",
     *      @OA\Property(property="id", type="integer", example=1),
     *      @OA\Property(property="github_id", type="integer", example=12345),
     *      @OA\Property(property="description", type="string", nullable=true, example="Lorem Ipsum ..."),
     *      @OA\Property(property="title", type="string", nullable=true, example="Lorem Ipsum ..."),
     *      @OA\Property(property="url", type="string", nullable=true, example="https://www.hola.com", format="url")
     * )
     */
class Resource extends Model
{
    /** @use HasFactory<\Database\Factories\ResourceFactory> */
    use HasFactory;

    protected $fillable = [
        'github_id',
        'description',
        'title',
        'url',
        'category',
        'theme',
        'type',
        'votes'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
