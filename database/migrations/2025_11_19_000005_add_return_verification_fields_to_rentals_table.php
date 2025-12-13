<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->timestamp('return_verified_at')->nullable()->after('returned_by');
            $table->foreignId('return_verified_by')->nullable()->after('return_verified_at')->constrained('users')->nullOnDelete();
            $table->text('return_verification_notes')->nullable()->after('return_verified_by');
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropConstrainedForeignId('return_verified_by');
            $table->dropColumn(['return_verified_at', 'return_verification_notes']);
        });
    }
};

