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
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            $table->foreignId('vendor_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');

            $table->string('slug')->unique();

            $table->text('description')->nullable();

            $table->string('sku')->unique();

            $table->decimal('price', 10, 2);

            $table->unsignedInteger('stock')->default(0);

            $table->enum('status', [
                'draft',
                'pending',
                'approved',
                'rejected',
            ])->default('draft');

            $table->boolean('is_featured')->default(false);

            $table->timestamp('approved_at')->nullable();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
