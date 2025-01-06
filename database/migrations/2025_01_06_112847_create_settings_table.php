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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->mediumText('logo')->nullable();
            $table->mediumText('footer_logo')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('email_2')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('order_link')->nullable();
            $table->string('price')->nullable();
            $table->string('razor_pay_key')->nullable();
            $table->string('razor_pay_secret')->nullable();
            $table->string('whatsapp_link')->nullable();
            $table->string('webinar_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
