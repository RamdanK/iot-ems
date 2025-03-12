<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('device_statuses', function (Blueprint $table) {
            $table->boolean('relay1')->default(0);
            $table->boolean('relay2')->default(0);
            $table->boolean('relay3')->default(0);
            $table->boolean('relay4')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('device_statuses', function (Blueprint $table) {
            $table->dropColumn('relay1');
            $table->dropColumn('relay2');
            $table->dropColumn('relay3');
            $table->dropColumn('relay4');
        });
    }
};
