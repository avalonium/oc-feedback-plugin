<?php namespace Avalonium\Shop\Tests\Models;

use PluginTestCase;
use Avalonium\Feedback\Models\Feedback;

/**
 * Feedback Model Test
 */
class FeedbackModelTest extends PluginTestCase
{
    /**
     * Create Model Test
     */
    public function test_create_feedback(): void
    {
        Feedback::truncate();

        $model = Feedback::factory()->create();

        // Check Model
        $this->assertInstanceOf(Feedback::class, $model);
        $this->assertDatabaseCount($model->getTable(), 1);
        $this->assertDatabaseHas($model->getTable(), $model->getAttributes());
    }
}