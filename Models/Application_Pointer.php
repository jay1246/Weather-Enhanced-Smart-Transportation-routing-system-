<?php

namespace App\Models;

use CodeIgniter\Model;

class Application_Pointer extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'application_pointer';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id', 'stage', 'status', 'update_date', 'application_number', 'create_date', 'team_member'
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
    protected $beforeDelete   = ['alert'];
    protected $afterDelete    = [];

    function alert()
    {
        // print_r(parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET));
    }
}
