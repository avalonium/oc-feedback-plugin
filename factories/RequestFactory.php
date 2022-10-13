<?php namespace Avalonium\Feedback\Factories;

use Avalonium\Feedback\Models\Request;

/**
 * Feedback Model Factory
 */
class RequestFactory extends \Illuminate\Database\Eloquent\Factories\Factory
{
    /**
     * Factory Model
     */
    protected $model = Request::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text,
            'email' => fake()->email,
            'phone' => fake()->phoneNumber,
            'message' => fake()->paragraph,
            'ip_address' => fake()->ipv4,
            'utm' => [
                'test' => 'Test'
            ]
        ];
    }
}
