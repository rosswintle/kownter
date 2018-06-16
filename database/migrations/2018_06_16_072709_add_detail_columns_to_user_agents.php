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
            $table->boolean('is_bot')->default(false);
            $table->string('browser_type')->nullable();
            $table->string('browser_name')->nullable();
            $table->string('browser_version')->nullable();
            $table->string('os_name')->nullable();
            $table->string('os_version')->nullable();
            $table->string('os_platform')->nullable();
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
