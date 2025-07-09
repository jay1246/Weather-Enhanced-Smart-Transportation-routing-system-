<?php

namespace App\Models;

use CodeIgniter\Model;

class Employers extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'add_employers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id',
        'user_id',
        'application_id',
        'employer_id',
        'employer_name',
        'employer_type',
        'Assessment',
        'Email',
        'mobile_code',
        'mobile_no',
        'stage_2_status',
        'verify_status',
        'email_send',
        'email_subject',
        'email_received',
        'verification_donee',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];
}
