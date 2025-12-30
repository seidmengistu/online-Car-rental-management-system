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
        Schema::table('reservations', function (Blueprint $table) {
            if (!Schema::hasColumn('reservations', 'driver_id')) {
                $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            }
        });

        Schema::table('rentals', function (Blueprint $table) {
            if (!Schema::hasColumn('rentals', 'driver_id')) {
                $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['driver_id']);
            $table->dropColumn('driver_id');
        });

        Schema::table('rentals', function (Blueprint $table) {
            $table->dropForeign(['driver_id']);
            $table->dropColumn('driver_id');
        });
    }
};
