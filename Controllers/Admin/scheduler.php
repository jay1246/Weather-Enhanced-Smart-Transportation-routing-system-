<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class scheduler extends BaseController
{
    public function index()
    {
        $data['title'] = 'Scheduler';

        $data['scheduler'] = $this->admin_account_model->asObject()->findAll();

        return view('admin/scheduler/index', $data);
    }
}