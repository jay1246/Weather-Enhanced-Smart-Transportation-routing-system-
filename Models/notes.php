<?php

namespace App\Models;

use CodeIgniter\Model;

class notes extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'notes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','admin_id','pointer_id','message','old_message','edited_by_id','isdeleted','deleted_by_id','documents','random_documents','documents_path','document_id','user_name','color','reply_id','reply_msg','reply_user_name','reply_color','reply_documents','reply_documents_path','reply_admin_id','is_send_doc_request','created_at','updated_at','deleted_at'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

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