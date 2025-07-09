<?php

namespace App\Models;

use CodeIgniter\Model;
 
class Admin_account extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'admin_account';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'email', 
        'password',
        'security_string',
        'account_type',
        'inital_name',
        'first_name',
        'middle_name',
        'last_name',
        'color',
        'profileimg_path',
        'notification',
        'is_active',
        'is_active_timestamp',
        'mobile_code', 
        'mobile_no',
        'tel_code',
        'tel_area_code', 
        'tel_no', 
        'address', 
        'unit_flat', 
        'street_lot', 
        'street_name', 
        'suburb_city', 
        'state_province', 
        'postcode',
        'postal_ad_same_physical_ad_check',
        'postal_address', 
        'postal_unit_flat', 
        'postal_street_lot',
        'postal_street_name',
        'postal_suburb_city', 
        'postal_state_province', 
        'postal_postcode', 
        'status', 
        'update_date', 
        'create_date'];

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