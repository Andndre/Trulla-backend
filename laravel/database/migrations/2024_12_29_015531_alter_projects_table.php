<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // projects either have a team or a user
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['in_team']);
            $table->dropColumn('in_team');
            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // projects either have a team or a user
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn('team_id');
            $table->dropColumn('user_id');
            $table->foreignId('in_team')->constrained('teams')->onDelete('cascade');
        });
    }
};
