<?php

namespace App\Models;

use CodeIgniter\Model;

class Stage_1_education_and_employment extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'stage_1_education_and_employment';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pointer_id', 'highest_completed_school_level', 'still_enrolled_in_secondary_or_senior_secondary_education', 'completed_any_qualifications', 'applicable_qualifications', 'specify_doc_name', 'current_employment_status', 'reason_for_undertaking_this_skills_assessment', 'other_reason_for_undertaking', 'for_applicant_declaration', 'is_downloaded', 'path_of_review_conform', 'review_conform_pdf_data', 'status', 'update_date', 'create_date',
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
