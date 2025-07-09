<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class dashboard extends BaseController
{


    public function create_new_application()
    {
        $user_id = $this->session->get('user_id');
        $account_type = $this->session->get('account_type');

        $random_number = "";
        // Insert new application id ----
        $details = [
            'user_id' => $user_id,
            'stage' => 'stage_1',
            'status' => 'Start',
        ];
        $Pointer_add =  $this->application_pointer_model->insert($details);

        if ($Pointer_add) {
            $pointer_id = $this->application_pointer_model->getInsertID();

            // AP 
            $getyear = date('Y') - 2000; 
            $random_number = $getyear."AQ0" . $pointer_id;
            if ($account_type != "Agent") {
                $random_number = $getyear."AP0" . $pointer_id;
            }

            $this->application_pointer_model->set(['application_number' => $random_number])->where(['id' => $pointer_id])->update();

            $details = [
                'pointer_id' => $pointer_id
            ];

            $this->stage_1_model->save($details);
            $this->stage_1_occupation_model->save($details);
            $this->stage_1_personal_details_model->save($details);
            $this->stage_1_contact_details_model->save($details);
            $this->stage_1_education_and_employment_model->save($details);
            $this->stage_1_identification_details_model->save($details);
            $this->stage_1_usi_avetmiss_model->save($details);
            $this->stage_1_review_confirm_model->save($details);

            // $this->submitted_application_model->save($details);
            // $this->db->table('stage2employer')->insert($details);

            // $pointer_id = urlencode(bin2hex($pointer_id));
            $ENC_pointer_id = pointer_id_encrypt($pointer_id);
            return redirect()->to(base_url("user/stage_1/occupation/" . $ENC_pointer_id));
        }
    }

    public function Account_type_change()
    {
        $user_id = $this->session->get('user_id');
        $data = $this->user_account_model->where('id', $user_id)->first(); //to increment application id
        $account_type = $data['account_type'];
        if ($account_type == "Agent") {
            $details = [
                'account_type' => "Applicant",
                'are_u_mara_agent' => "No",
            ];
            $this->session->set('account_type', 'Applicant');
        } else {
            $details = [
                'account_type' => "Agent",
                'are_u_mara_agent' => "",
                'business_name' => "",
                'mara_no' => "",
            ];
            $this->session->set('account_type', 'Agent');
        }


        // echo "<pre>";
        // print_r($details);
        // exit;
        $this->user_account_model->where('id', $user_id)->set($details)->update();
        return redirect()->back();
    }
}
