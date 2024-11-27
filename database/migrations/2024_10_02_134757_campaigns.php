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
        Schema::create('campaigns', function(Blueprint $table){

            $table->id();
            $table->string('name')->unique();      
            $table->date('start_date');        
            $table->date('end_date');        
            $table->integer('gross_clicks');
            $table->integer('unique_clicks');
            $table->integer('duplicate_clicks');
            $table->integer('cv');
            $table->decimal('cvr');
            $table->decimal('cpa_affiliate',8,3);
            $table->decimal('cpa_advertiser',8,3);
            $table->decimal('payout_affiliate');
            $table->decimal('payout_advertiser');
            $table->decimal('gross_profit');
            $table->enum('status',[0,1])->default(1); 
            $table->timestamps();        

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
