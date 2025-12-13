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
        Schema::table('rentals', function (Blueprint $table) {
            $table->decimal('overdue_fee', 10, 2)->default(0)->after('additional_charges');
            $table->enum('overdue_payment_status', ['not_required', 'pending', 'paid'])->default('not_required')->after('overdue_fee');
            $table->string('overdue_payment_method')->nullable()->after('overdue_payment_status');
            $table->string('overdue_payment_reference')->nullable()->after('overdue_payment_method');
            $table->string('overdue_receipt_path')->nullable()->after('overdue_payment_reference');
            $table->text('overdue_payment_notes')->nullable()->after('overdue_receipt_path');
            $table->timestamp('overdue_paid_at')->nullable()->after('overdue_payment_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn([
                'overdue_fee',
                'overdue_payment_status',
                'overdue_payment_method',
                'overdue_payment_reference',
                'overdue_receipt_path',
                'overdue_payment_notes',
                'overdue_paid_at',
            ]);
        });
    }
};

