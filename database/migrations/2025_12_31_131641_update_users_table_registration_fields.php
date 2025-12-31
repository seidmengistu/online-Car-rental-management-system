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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['zip_code', 'date_of_birth', 'address']);
            $table->string('id_document_path')->nullable()->after('driving_license_expiry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->dropColumn('id_document_path');
        });
    }
};
