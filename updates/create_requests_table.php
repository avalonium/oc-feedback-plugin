<?php namespace Avalonium\Feedback\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateRequestsTable Migration
 */
class CreateRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('avalonium_feedback_requests', function (Blueprint $table) {
            // Base
            $table->id();
            $table->string('status', 10);
            $table->string('number', 10)->nullable();
            $table->string('ip_address')->nullable();
            $table->string('name', 50);
            $table->string('email', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('message')->nullable();
            $table->json('utm')->nullable();
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('avalonium_feedback_requests');
    }
}
