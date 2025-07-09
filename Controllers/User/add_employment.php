<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class add_employment extends BaseController
{
    public function add_employment_page($ENC_pointer_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->first();
        if (!empty($application_pointer)) {

            // $data = [
            //     'stage' => 'stage_2',
            //     'status' => 'Start',
            // ];
            // $this->application_pointer_model->where(['id ' => $pointer_id])->set($data)->update();

            // $stage_2_tb = $this->stage_2_model->where(['pointer_id' => $pointer_id])->first();
            // if (empty($stage_2_tb)) {
            //     $data = [
            //         'pointer_id' => $pointer_id,
            //         'status' => 'Start',
            //     ];
            //     $this->stage_2_model->set($data)->insert();
            // }



            $country_TB = $this->country_model->find();
            $add_employment_TB = $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id])->find();
            $data =  [
                'add_employment_TB' => $add_employment_TB,
                'country_TB' => $country_TB,
                'page' => ' Add Employment\'s',
                'ENC_pointer_id' => $ENC_pointer_id,
                'Unique_number' => get_unique_number($pointer_id),
            ];

            return view('user/stage_2/add_employment', $data);
        }
    }

    public function stage_2_add_employment_($ENC_pointer_id)
    {

        $ENC_pointer_id = $_POST['ENC_pointer_id'];
        $pointer_id = $pointer_id = pointer_id_decrypt($ENC_pointer_id);


        $data = [
            'stage' => 'stage_2',
            'status' => 'Start',
        ];
        $this->application_pointer_model->where(['id ' => $pointer_id])->set($data)->update();



        $company_organisation_name = $_POST['company_organisation_name'];
        $employment_type = $_POST['employment_type'];
        $referee_name = $referee_name =ucwords(strtolower($_POST['referee_name']));//$_POST['referee_name'];
        $referee_email = $_POST['referee_email'];
        $Confirm_referee_email = $_POST['Confirm_referee_email'];
        $referee_mobile_number_code = $_POST['referee_mobile_number_code'];
        $referee_mobile_number = $_POST['referee_mobile_number'];

        $data = [
            'pointer_id' => $pointer_id,
            'company_organisation_name' => $company_organisation_name,
            'employment_type' => $employment_type,
            'referee_name' => $referee_name,
            'referee_email' => $referee_email,
            'referee_mobile_number_code' => $referee_mobile_number_code,
            'referee_mobile_number' => $referee_mobile_number,
        ];
        $application_pointer = $this->stage_2_add_employment_model->where($data)->first();
        if (empty($application_pointer)) {
            $is_insert =  $this->stage_2_add_employment_model->set($data)->insert();
            if ($is_insert) {
                $this->session->setFlashdata('msg', 'Successfully Add Employment Details');
                return redirect()->back();
            } else {
                $this->session->setFlashdata('error_msg', 'Sorry! Employment Details Not Add ');
                return redirect()->back();
            }
        } else {
            $this->session->setFlashdata('error_msg', 'Sorry! Employment Details Already available');
            return redirect()->back();
        }
    }

    public function stage_2_delete_employe_($ENC_pointer_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $employe_id = $_POST['employe_id'];
        $is_employment_TB = $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id, 'id' => $employe_id])->first();
        if (!empty($is_employment_TB)) {
            $is_employment_delet = $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id, 'id' => $employe_id])->delete();
            if ($is_employment_delet) {
                return "1";
            }
        }
        return "0";
    }
    public function stage_2_employe_Docs_check($ENC_pointer_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $employee_id = $_POST['employe_id'];
        $file_exist = $this->documents_model->where(['pointer_id' => $pointer_id, 'stage' => 'stage_2', 'employee_id' => $employee_id])->first();
        if (empty($file_exist)) {
            return "1";
        }
        return "0";
    }

    public function stage_2_edite_employment_($ENC_pointer_id)
    {
        // print_r($_POST);
        // exit;
        $ENC_pointer_id = $_POST['ENC_pointer_id'];
        $employe_id = $_POST['employe_id'];

        $pointer_id = $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        $referee_name = $referee_name =ucwords(strtolower($_POST['referee_name']));//$_POST['referee_name'];
        $referee_email = $_POST['referee_email'];
        $referee_mobile_number_code = $_POST['referee_mobile_number_code'];
        $referee_mobile_number = $_POST['referee_mobile_number'];

        $data = [
            'referee_name' => $referee_name,
            'referee_email' => $referee_email,
            'referee_mobile_number_code' => $referee_mobile_number_code,
            'referee_mobile_number' => $referee_mobile_number,
        ];
        $application_pointer = $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id, 'id' => $employe_id])->set($data)->first();
        if (!empty($application_pointer)) {
            $is_insert =  $this->stage_2_add_employment_model->where("id", $employe_id)->set($data)->update();
            if ($is_insert) {
                $this->session->setFlashdata('msg', 'Successfully Updated Employment Details');
                return redirect()->back();
            } else {
                $this->session->setFlashdata('error_msg', 'Sorry! Employment Details Not Updated ');
                return redirect()->back();
            }
        } else {
            $this->session->setFlashdata('error_msg', 'Sorry! Employment Details Not available. ');
            return redirect()->back();
        }
    }
}
