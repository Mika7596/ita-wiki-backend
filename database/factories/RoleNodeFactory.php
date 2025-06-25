<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\RoleNode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoleNode>
 */
class RoleNodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
            do {
            $nodeId  = $this->faker->unique()->regexify('MDQ6VXNlcj[0-9]{1,5}=');// faker->uuid;  //or  aunique string generator (unique()->regexify('[A-Za-z0-9]{10,15}');)
        } while (RoleNode::where('node_id', $nodeId )->exists());
        return [
            'node_id' => $nodeId,
            'role' => $this->faker->randomElement(['admin', 'mentor', 'student']),
        
        ];
    }
}
