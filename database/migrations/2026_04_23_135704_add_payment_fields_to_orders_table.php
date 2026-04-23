<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->default('cash_on_delivery')->after('status');
            $table->string('payment_status')->default('unpaid')->after('payment_method');
            $table->string('payment_provider')->nullable()->after('payment_status');
            $table->string('provider_payment_id')->nullable()->after('payment_provider');
            $table->timestamp('paid_at')->nullable()->after('provider_payment_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'payment_status',
                'payment_provider',
                'provider_payment_id',
                'paid_at',
            ]);
        });
    }
};