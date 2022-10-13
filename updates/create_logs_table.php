<?php namespace Avalonium\Feedback\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateLogsTable Migration
 */
class CreateLogsTable extends Migration
{
    public function up()
    {
        Schema::create('avalonium_feedback_logs', function (Blueprint $table) {
            // Base
            $table->id();
            $table->string('type')->index();
            $table->text('message')->nullable();
            $table->text('details')->nullable();
            $table->integer('author_id')->unsigned()->nullable();
            $table->numericMorphs('loggable');
            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('avalonium_feedback_logs');
    }
}
