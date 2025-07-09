<?php

namespace App\Models;

use CodeIgniter\Model;

class Email_verification extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'email_verification';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'pointer_id',
        'verification_type',
        'employer_id',
        'email_cc_id',
        'verification_email_id',
        'verification_email_subject',
        'verification_email_send',
        'verification_email_send_date',
        'verification_email_received',
        'is_verification_done',
        'document_ids',
        'update_date',
        'create_date',
        'email_reminder_date'
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
