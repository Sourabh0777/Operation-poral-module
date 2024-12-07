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
        Schema::create('employeeprofiles', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->date('doj'); 
            $table->string('mob'); 
            $table->string('type_speed')->nullable();            
            $table->text('area_of_exp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employeeprofiles');
    }
};
