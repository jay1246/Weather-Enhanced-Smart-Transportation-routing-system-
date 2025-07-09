<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class applicant_agent extends BaseController
{
    public function index($tab = "")
    {
        $data["tab"] = $tab;
        // echo $tab;
        // exit;
        $data['title'] = "applicant_agent";
        $data['agents'] = $this->user_account_model->where("account_type", "Agent")->orderby('create_date', 'ASC')->asObject()->findAll();
        $data['applicants'] = $this->user_account_model->where("account_type", "Applicant")->orderby('create_date', 'ASC')->asObject()->findAll();
        $data['page']= ucfirst($tab);
        return view('admin/applicant_agent/index', $data);
    }
    public function delete($id)
    {
        if ($this->user_account_model->where('id', $id)->delete()) {
            $callback = array(
                "color" => "success",
                "msg" => "Delete recode",
                "response" => true,
            );
        } else {
            $callback = array(
                "msg" => "unable to delete record",
                "color" => "danger",
                "response" => false,
            );
        }
        echo json_encode($callback);
    }
    public function view($id)
    {
        $data['title'] = "applicant_agent view";

        // echo $id;
        // exit;
        $data['user'] = $this->user_account_model->where('id', $id)->asObject()->first();
        $data['countries'] = $this->country_model->asObject()->findAll();

        return view('admin/applicant_agent/view', $data);
    }
    public function update()
    {
        $id = $this->request->getPost("id");
        $posts = $this->request->getPost();

        if ($this->user_account_model->update($id, $posts)) {
            $callback = array(
                "color" => "success",
                "msg" => "update recode",
                "response" => true,
            );
        } else {
            $callback = array(
                "msg" => "unable to update record",
                "color" => "danger",
                "response" => false,
            );
        }
        echo json_encode($callback);
    }
}
