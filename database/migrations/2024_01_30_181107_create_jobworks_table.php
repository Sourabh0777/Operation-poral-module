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
        Schema::create('jobworks', function (Blueprint $table) {
            $table->id();
            $table->string('jobnumber');
            $table->enum('jobtype',['Fresh','Rework']);
            $table->string('category');
            $table->string('client_id');
            $table->date('receive_date');
            $table->date('deadline');
            $table->string('words');
            $table->text('requirement');
            $table->string('drive_link');
            $table->integer('user_id');
            $table->enum('status',['pending','Approve','Rejected']);
            $table->text('extra_notes');
            $table->softDeletes();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobworks');
    }
};
