<?php namespace Avalonium\Feedback\Seeders;

use Avalonium\Feedback\Models\Request;

/**
 * Feedback Model Seeder
 */
class RequestSeeder extends \October\Rain\Database\Updates\Seeder
{
    public function run()
    {
        Request::create([
            // Base
            'name' => 'Ava Lon',
            'email' => 'test@localhost',
            'phone' => '380980000000',
            'message' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            'ip_address' => '127.0.0.1',
            'utm' => [
                'utm_source' => 'source',
                'utm_medium' => 'medium',
                'utm_campaign' => 'campaign',
                'utm_content' => 'content',
                'utm_term' => 'term'
            ]
        ]);
    }
}
