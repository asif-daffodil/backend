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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('applicationType');
            $table->string('highSchool')->default("No");
            $table->string('russain_citizen');
            $table->string('permanent_resident');
            $table->bigInteger('user_id')->foreignKey('user_id')->references('id')->on('users');
            $table->string('ssc')->nullable();
            $table->string('hsc')->nullable();
            $table->string('passport')->nullable();
            $table->string('photo')->nullable();
            $table->string('application_status')->default('Pending');
            $table->string('transection_details')->nullable();
            $table->string('screenshot')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
