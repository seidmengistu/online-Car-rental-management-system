<?php

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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->after('id')->constrained('roles')->onDelete('cascade');
            $table->string('phone')->nullable()->after('email');
            $table->string('address')->nullable()->after('phone');
            $table->string('city')->nullable()->after('address');
            $table->string('state')->nullable()->after('city');
            $table->string('zip_code')->nullable()->after('state');
            $table->string('country')->nullable()->after('zip_code');
            $table->date('date_of_birth')->nullable()->after('country');
            $table->string('driving_license_number')->nullable()->after('date_of_birth');
            $table->date('driving_license_expiry')->nullable()->after('driving_license_number');
            $table->boolean('is_active')->default(true)->after('driving_license_expiry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn([
                'role_id', 'phone', 'address', 'city', 'state', 
                'zip_code', 'country', 'date_of_birth', 
                'driving_license_number', 'driving_license_expiry', 'is_active'
            ]);
        });
    }
}; 