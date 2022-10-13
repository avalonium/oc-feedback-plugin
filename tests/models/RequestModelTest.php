<?php namespace Avalonium\Shop\Tests\Models;

use PluginTestCase;
use Avalonium\Feedback\Models\Request;

/**
 * Feedback Model Test
 */
class RequestModelTest extends PluginTestCase
{
    /**
     * Create Model Test
     */
    public function test_create_feedback(): void
    {
        Request::truncate();

        $model = Request::factory()->create();

        // Check Model
        $this->assertInstanceOf(Request::class, $model);
        $this->assertDatabaseCount($model->getTable(), 1);
        $this->assertDatabaseHas($model->getTable(), $model->getAttributes());
    }
}