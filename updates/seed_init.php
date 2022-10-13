<?php namespace Avalonium\Feedback\Updates;

use App;
use Avalonium\Feedback\Seeders\RequestSeeder;

/**
 * Class SeedInitial
 */
class SeedInitial extends \October\Rain\Database\Updates\Seeder
{
    public function run()
    {
        if (App::environment() !== 'testing') {
            $this->call(RequestSeeder::class);
        }
    }
}
