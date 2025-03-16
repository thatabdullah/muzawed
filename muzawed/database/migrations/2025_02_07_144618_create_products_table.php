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
            $table->foreignId('account_id')->constrained()->onDelete('cascade'); // SaaS provider that owns the product
            $table->string('name');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('currency', 3)->default('SAR');
            $table->enum('pricing_model', ['subscription', 'one-time', 'pay-as-you-go']);
            $table->boolean('active')->default(true);
            $table->boolean('featured')->default(false);
            $table->string('documentation_url')->nullable();
            $table->string('version')->nullable(); // e.g., 'v1.0', 'v2.0'
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('review_count')->default(0);
            $table->string('support_email')->nullable();
            $table->string('support_hours')->nullable();
            $table->string('product_link')->nullable();
            $table->json('key_features_en')->nullable();
            $table->json('version_features_en')->nullable();
            $table->json('key_features_ar')->nullable();
            $table->json('version_features_ar')->nullable();
            $table->text('detailed_description_en')->nullable();
            $table->text('description_en')->nullable();
            $table->text('detailed_description_ar')->nullable();
            $table->text('description_ar')->nullable();
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
