<?php

namespace App\Models;

use CodeIgniter\Model;

class Submitted_Application extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'submitted_application';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'user_id', 'application_id', 'passport', 'passport_photo', 'cv_resume', 'Information_Release_Form', 'Applicant_Declaration', 'Current_Visa_Grant_Notice', 'Qualification_Docs', 'Other_Documents', 'SAQ', 'submitted', 'updated_at', 'created_at', 'USI_Transcript', 'Certificate_&_Transcripts_or_Marksheets'];

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