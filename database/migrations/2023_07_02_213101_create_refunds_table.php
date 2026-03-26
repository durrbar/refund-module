<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Refund\Enums\RefundStatus;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('refunds', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->double('amount')->default(0);
            $table->enum('status', RefundStatus::getValues())->default(RefundStatus::PENDING);
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->foreignUuid('order_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignUuid('customer_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('shop_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
