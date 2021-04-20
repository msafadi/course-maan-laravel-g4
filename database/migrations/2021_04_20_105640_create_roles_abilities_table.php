<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesAbilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_abilities', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('roles', 'id')->cascadeOnDelete();
            $table->foreignId('ability_id')->constrained('abilities', 'id')->cascadeOnDelete();
            $table->primary(['role_id', 'ability_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_abilities');
    }
}
