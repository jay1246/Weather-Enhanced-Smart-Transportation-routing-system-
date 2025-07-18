<?php

namespace App\Models;

use CodeIgniter\Model;

class not_aqato_s3 extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'not_aqato_s3';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
  protected $allowedFields    = [
        'id',
        'full_name',
        'occupation_name',
        'unique_number',
        'interview_date',
        'interview_location',
         'dob',
        'pathway',
        'update_date',
        'create_date',
        'zoom_reminder_status'
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
