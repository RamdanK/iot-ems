<?php

use App\Models\Device;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('device_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->date('date');
            $table->time('time');
            $table->decimal('voltage1', 10)->nullable();
            $table->decimal('current1', 10)->nullable();
            $table->decimal('power1', 10)->nullable();
            $table->decimal('energy1', 10)->nullable();
            $table->decimal('freq1', 10)->nullable();
            $table->decimal('pf1', 10)->nullable();
            $table->decimal('voltage2', 10)->nullable();
            $table->decimal('current2', 10)->nullable();
            $table->decimal('power2', 10)->nullable();
            $table->decimal('energy2', 10)->nullable();
            $table->decimal('freq2', 10)->nullable();
            $table->decimal('pf2', 10)->nullable();
            $table->decimal('temp')->nullable();
            $table->decimal('battery')->nullable();
            $table->timestamps();

            $table->foreign('device_id')->references('id')->on('devices')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_statuses');
    }
};
