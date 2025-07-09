<?php

namespace App\Models;

use CodeIgniter\Model;

class Stage_1 extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'stage_1';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pointer_id', 'unique_id', 'allocate_team_member_name', 'status',  'submitted_date',
        'lodged_date', 'in_progress_date', 'approved_date','approved_comment', 'omitted_date', 'omitted_deadline_date',  'withdraw_date', 'declined_date', 'declined_reason',
        'archive', 'archive_date', 'expiry_date','closure_date','date_reinstate','is_reinstated','reminder_email_send', 'archive_email_send', 'expiry_email_send', 'submitted_by', 'lodged_by', 'in_progress_by', 'approved_by', 'omitted_by', 'withdraw_by', 'declined_by', 'update_date', 'create_date',
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
