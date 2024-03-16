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
        Schema::create('sys_column', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('table_id');
            $table->foreign('table_id')->references('id')->on('sys_table')->cascadeOnDelete();

            $table->string('name');            
            $table->string('custom_name');            
            $table->string('description');            
            $table->string('is_active');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_column');
    }
};
