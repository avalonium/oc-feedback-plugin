<?php namespace Avalonium\Feedback\Seeders;

use Avalonium\Feedback\Models\Feedback;

/**
 * Feedback Model Seeder
 */
class FeedbackSeeder extends \October\Rain\Database\Updates\Seeder
{
    public function run()
    {
        Feedback::create([
            // Base
            'name' => 'Ava Lon',
            'phone' => '380989242645',
            'message' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.'
        ]);
    }
}
