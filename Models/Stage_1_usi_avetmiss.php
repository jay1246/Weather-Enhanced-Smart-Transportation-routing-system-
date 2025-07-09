<?php

namespace App\Models;

use CodeIgniter\Model;

class Stage_1_usi_avetmiss extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'stage_1_usi_avetmiss';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pointer_id', 'currently_have_usi', 'usi_no', 'have_usi_transcript', 'permission_access_usi_transcripts', 'i_do_not_intend', 'i_intend', 'speak_english_at_home', 'proficiency_in_english',
        'specify_language', 'are_you_aboriginal', 'choose_origin', 'have_any_disability', 'indicate_area', 'please_indicate_area_note', 'require_additional_support', 'note', 'marketing', 'status', 'update_date', 'create_date',
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
