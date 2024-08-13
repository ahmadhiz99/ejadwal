<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_menu', function (Blueprint $table) {
            $table->id(); // Ini otomatis membuat kolom 'id' sebagai primary key
            $table->string('name');
            $table->string('code');
            $table->string('parent')->nullable();
            $table->string('icon')->nullable();
            $table->string('route')->nullable();
            $table->string('activeRoute')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_menu');
    }
};

