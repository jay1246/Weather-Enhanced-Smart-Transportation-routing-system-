<?php

namespace App\Models;

use CodeIgniter\Model;

class Stage_1_contact_details extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'stage_1_contact_details';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id', 'pointer_id', 'country', 'unit_flat_number', 'street_lot_number', 'street_name', 'suburb', 'state_proviance', 'postcode', 'mobile_number_code', 'mobile_number', 'alter_mobile_code', 'alter_mobile', 'email', 'alternate_email', 'postal_address_is_different', 'Postal_country', 'postal_building_prop_name', 'postal_unit_flat_number', 'postal_street_lot_number', 'postal_street_name', 'postal_suburb', 'postal_state_proviance', 'postal_postcode', 'postal_email', 'postal_alter_email', 'postal_mobile', 'postal_alter_mobile', 'first_name', 'surname', 'relationship', 'emergency_mobile', 'emergency_mobile_code', 'status'
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
