<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreignId('saas_product_id')
            ->after('account_id')  
            ->nullable()           
            ->constrained('products')  
            ->onDelete('cascade');
            $table->dropColumn('saas_product_name');
        });
    }

    
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['saas_product_id']);
            $table->dropColumn('saas_product_id');
            
        });
    }
};
