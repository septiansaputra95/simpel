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
        Schema::create('m_queue_lists', function (Blueprint $table) {
            $table->id();
            $table->string('queue_no')->nullable();
            $table->boolean('is_appointment')->default(false);
            $table->string('ar')->nullable();
            $table->string('queue_status')->nullable();
            $table->string('billing_no')->nullable();
            $table->timestamp('date')->nullable();

            $table->string('medical_record_no')->nullable();
            $table->string('episode_status')->nullable();
            $table->string('patient_name')->nullable();
            $table->string('tb')->nullable();
            $table->string('al')->nullable();
            $table->string('rf')->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('odc')->nullable();
            $table->date('date_of_birth')->nullable();

            $table->string('sep_no')->nullable();
            $table->string('bridging_control_information')->nullable();
            $table->string('condition_of_visit')->nullable();
            $table->string('booking_code')->nullable();
            $table->string('add_queue_information')->nullable();

            $table->string('guarantor')->nullable();
            $table->string('clinic')->nullable()->nullable();
            $table->string('examiner_name')->nullable();
            $table->string('doctor_initials', 10)->nullable();
            $table->string('clinic_schedule')->nullable();
            $table->string('schedule')->nullable();
            $table->string('consultation_assignment_room')->nullable();

            $table->timestamp('queue_pickup_time')->nullable();
            $table->string('waiting_time_registration')->nullable();
            $table->string('age')->nullable()->nullable();
            $table->string('mobile_phone_no')->nullable();
            $table->string('soap')->nullable();
            $table->string('forms')->nullable();
            $table->timestamp('process_time')->nullable();
            $table->timestamp('queue_call_time_nurse')->nullable();
            $table->string('queue_call_by_nurse')->nullable();
            $table->timestamp('queue_call_time')->nullable();
            $table->string('queue_call_by')->nullable();
            $table->timestamp('finish_time')->nullable();
            $table->string('finished_by')->nullable();
            $table->string('doctor_time')->nullable();
            $table->string('cancel_by')->nullable();
            $table->timestamp('cancel_time')->nullable();

            $table->text('notes')->nullable();

            $table->timestamp('check_in_datetime')->nullable();
            $table->string('check_in_by')->nullable();
            
            $table->string('appointment_key')->nullable();
            $table->boolean('waiting_list')->default(true);
            $table->string('clinic_id')->nullable();
            $table->string('doctor_id')->nullable();
            $table->integer('no')->nullable();
            $table->string('modified_by')->nullable();
            $table->dateTime('modified_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_queue_lists');
    }
};
