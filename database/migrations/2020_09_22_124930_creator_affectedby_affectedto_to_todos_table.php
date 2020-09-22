<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatorAffectedbyAffectedtoToTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->bigInteger('creator_id')->default(0)->after('done');
            $table->bigInteger('affectedto_id')->default(0)->after('creator_id');
            $table->bigInteger('affectedby_id')->default(0)->after('affectedto_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->dropColumn('creator_id');
            $table->dropColumn('affectedto_id');
            $table->dropColumn('affectedby_id');
        });
    }
}
