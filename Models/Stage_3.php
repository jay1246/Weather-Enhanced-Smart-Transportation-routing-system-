<?php

namespace App\Models;

use CodeIgniter\Model;

class Stage_3 extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'stage_3';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pointer_id',
        'receipt_number',
        'payment_date',
        'interview_time_id',
        'offline_location_id',
  'preference_location',
          'exemption_yes_no',
'download_ex_form',
        'exemption_form',
        'time_zone',
        'preference_comment',
        'status',
        'submitted_date', 
        'lodged_date', 
        'in_progress_date', 
        'scheduled_date', 
        'conducted_date', 
        'approved_date', 
        'approved_comment',
        'withdraw_date', 
        'declined_date', 
        'declined_reason', 
        'submitted_by', 
        'lodged_by', 
        'in_progress_by',
        'scheduled_by',
        'conducted_by', 
        'approved_by', 
        'withdraw_by', 
        'declined_by', 
        'update_date', 
        'create_date',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}