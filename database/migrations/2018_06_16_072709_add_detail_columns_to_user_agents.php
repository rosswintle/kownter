<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDetailColumnsToUserAgents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_agents', function (Blueprint $table) {
            $table->boolean('is_bot');
            $table->string('browser_type');
            $table->string('browser_name');
            $table->string('browser_version');
            $table->string('os_name');
            $table->string('os_version');
            $table->string('os_platform');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_agents', function (Blueprint $table) {
            $table->dropColumn('is_bot');
            $table->dropColumn('browser_type');
            $table->dropColumn('browser_name');
            $table->dropColumn('browser_version');
            $table->dropColumn('os_name');
            $table->dropColumn('os_version');
            $table->dropColumn('os_platform');
        });
    }
}
