<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MQueueList extends Model
{
    //

    protected $table = 'm_queue_lists';
    protected $primaryKey = 'id';

    protected $fillable = [
        'queue_no',
        'is_appointment',
        'ar',
        'queue_status',
        'billing_no',
        'date',

        'medical_record_no',
        'episode_status',
        'patient_name',
        'tb',
        'al',
        'rf',
        'gender',
        'odc',
        'date_of_birth',

        'sep_no',
        'bridging_control_information',
        'condition_of_visit',
        'booking_code',
        'add_queue_information',

        'guarantor',
        'clinic',
        'examiner_name',
        'doctor_initials',
        'clinic_schedule',
        'schedule',
        'consultation_assignment_room',

        'queue_pickup_time',
        'waiting_time_registration',
        'age',
        'mobile_phone_no',
        'soap',
        'forms',
        'process_time',
        'queue_call_time_nurse',
        'queue_call_by_nurse',
        'queue_call_time',
        'queue_call_by',
        'finish_time',
        'finished_by',
        'doctor_time',
        'cancel_by',
        'cancel_time',

        'notes',
        'check_in_datetime',
        'check_in_by',
        'appointment_key',
        'waiting_list',
        'clinic_id',
        'doctor_id',
        'no',
        'modified_by',
        'modified_date',
    ];
}
