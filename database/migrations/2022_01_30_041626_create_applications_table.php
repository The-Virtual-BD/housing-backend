<?php

use App\Constants;
use App\Models\Application;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('subdivision_id')->nullable()->constrained();
            $table->foreignId('housing_model_id')->nullable()->constrained();
            $table->nullableMorphs('forwardable');
            $table->nullableMorphs('approvable');
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('nib_no')->nullable();
            $table->string('email')->nullable();
            $table->dateTime('dob')->nullable();
            $table->string('phone')->nullable();
            $table->enum('gender', Constants::GENDERS )->nullable();
            $table->string('country_of_birth')->nullable();
            $table->string('island_of_birth')->nullable();
            $table->string('country_of_citizenship')->nullable();
            $table->string('house_no')->nullable();
            $table->string('street_address')->nullable();
            $table->string('po_box')->nullable();
            $table->string('island')->nullable();
            $table->string('country')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('passport_no')->nullable();
            $table->date('passport_expiry')->nullable();
            $table->string('driving_licence_no')->nullable();
            $table->string('employer')->nullable();
            $table->string('industry')->nullable();
            $table->string('position')->nullable();
            $table->string('work_phone')->nullable();
            $table->enum('status', Constants::APPLICATION_STATUSES)->default(Application::STATUS_SUBMITTED);
            $table->text('comments')->nullable();
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
        Schema::dropIfExists('applications');
    }
}
