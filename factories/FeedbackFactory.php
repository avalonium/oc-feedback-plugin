<?php namespace Avalonium\Feedback\Factories;

use Avalonium\Feedback\Models\Feedback;

/**
 * Feedback Model Factory
 */
class FeedbackFactory extends \Illuminate\Database\Eloquent\Factories\Factory
{
    /**
     * Factory Model
     */
    protected $model = Feedback::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text,
            'phone' => fake()->phoneNumber,
            'message' => fake()->paragraph
        ];
    }
}
