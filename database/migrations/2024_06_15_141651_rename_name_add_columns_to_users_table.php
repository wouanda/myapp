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
        Schema::table('users', function (Blueprint $table) {
            
            $table->string('phoneNumber')->nullable();
            $table->string('role')->nullable();
            $table->renameColumn('name', 'username')->nullable();
           

    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       
    }
};
