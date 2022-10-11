<?php namespace Avalonium\Feedback\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateFeedbackTable Migration
 */
class CreateFeedbackTable extends Migration
{
    public function up()
    {
        Schema::create('avalonium_feedback', function (Blueprint $table) {
            // Base
            $table->id();
            $table->string('number', 10)->nullable();
            $table->string('status', 10);
            $table->string('name', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('message');
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('avalonium_feedback');
    }
}
