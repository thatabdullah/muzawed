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
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('SAR');
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->enum('pricing_model', ['subscription', 'one-time', 'pay-as-you-go']);
            $table->integer('trial_period_days')->nullable(); // Days for free trial
            $table->boolean('active')->default(true);
            $table->boolean('featured')->default(false);
            $table->text('detailed_description')->nullable();
            $table->text('key_features')->nullable();
            $table->string('documentation_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('main_image')->nullable();
            $table->json('media_gallery')->nullable(); // Store URLs for images or videos
            $table->string('version')->nullable(); // e.g., 'v1.0', 'v2.0'
            $table->text('version_features')->nullable(); // Features in each version
            $table->boolean('api_supported')->default(false);
            $table->json('integration_partners')->nullable(); // Store list of integrations
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('review_count')->default(0);
            $table->string('support_email')->nullable();
            $table->boolean('live_chat_available')->default(false);
            $table->string('support_hours')->nullable();
            $table->integer('renewal_period_days')->nullable();
            $table->date('expiry_date')->nullable();
            $table->json('supported_languages')->nullable(); // e.g., ['en', 'ar]
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
