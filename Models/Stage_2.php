<?php

namespace App\Models;

use CodeIgniter\Model;

class Stage_2 extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'stage_2'; 
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pointer_id', 'status', 'submitted_date', 'lodged_date', 'lodged_comment', 'in_progress_date', 'approved_date','approved_comment', 'withdraw_date', 'declined_date','closed_date','declined_reason', 'archive', 'archive_date', 'submitted_by', 'lodged_by', 'in_progress_by', 'approved_by', 'withdraw_by', 'declined_by','closed_by','update_date', 'create_date','email_reminder_date','email_status_cronjob'
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
