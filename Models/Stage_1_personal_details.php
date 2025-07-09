<?php

namespace App\Models;

use CodeIgniter\Model;

class Stage_1_personal_details extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'stage_1_personal_details';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pointer_id', 'preferred_title', 'first_or_given_name', 'middle_names', 'surname_family_name', 'checkbox_only_had_name', 'previous_names', 'previous_middle_names', 'previous_surname_or_family_name', 'known_by_any_name', 'other_name', 'gender', 'date_of_birth', 'status', 'update_date', 'create_date',
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
