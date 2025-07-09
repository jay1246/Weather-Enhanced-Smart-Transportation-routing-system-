<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class occupation extends BaseController
{

    public function occupation_page($ENC_pointer_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        // $pointer_id = decrypt_pointer_id($ENC_pointer_id);
        $occupation_list = $this->occupation_list_model->findAll();

        $stage_1_occupation = $this->stage_1_occupation_model->where(['pointer_id' => $pointer_id])->first();
        $data =  [
            'occupation_list' => $occupation_list,
            'stage_1_occupation' => $stage_1_occupation,
            'ENC_pointer_id' => $ENC_pointer_id,
            'page' => 'Occupation',
            'portal_reference_no' => portal_reference_no($pointer_id),

        ];
        // echo "<pre>";
        // print_r($stage_1_occupation);
        // exit;
        return view('user/stage_1/occupation', $data);
    }



    public function occupation_()
    {
        $data = $this->request->getvar();
        // Decode ------
        $ENC_pointer_id = $data['ENC_pointer_id'];
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        // hide show funtion 
        if (isset($data['currently_in_australia'])) {
            if ($data['currently_in_australia'] == "no") {
                $currently_on_bridging_visa = '';
                $current_visa_category = "";
                $visa_expiry = "";
            } else {
                $currently_on_bridging_visa = (isset($data['currently_on_bridging_visa'])) ? $data['currently_on_bridging_visa'] : '';
                if ($currently_on_bridging_visa == "no") {
                    $visa_expiry =  (isset($data['visa_expiry'])) ? $data['visa_expiry'] : '';
                    $current_visa_category = (isset($data['current_visa_category'])) ? $data['current_visa_category'] : '';
                } else {
                    $current_visa_category = "";
                    $visa_expiry = "";
                }
            }
        } else {
            $currently_on_bridging_visa = (isset($data['currently_on_bridging_visa'])) ? $data['currently_on_bridging_visa'] : '';
            if ($currently_on_bridging_visa == "no") {
                $visa_expiry =  (isset($data['visa_expiry'])) ? $data['visa_expiry'] : '';
                $current_visa_category = (isset($data['current_visa_category'])) ? $data['current_visa_category'] : '';
            } else {
                $current_visa_category = "";
                $visa_expiry = "";
            }
        }

        if (!empty($visa_expiry)) {
            $parts = explode("/", $visa_expiry);
            $visa_expiry = $parts[2] . "-" . $parts[1] . "-" . $parts[0];
        }

        $details = [
            'occupation_id' => (isset($data['occupation_id'])) ? $data['occupation_id'] : '',
            'program' => (isset($data['program'])) ? $data['program'] : '',
            'pathway' => (isset($data['pathway'])) ? str_replace('_', ' ', $data['pathway']) : '',
            'currently_in_australia' => (isset($data['currently_in_australia'])) ? $data['currently_in_australia'] : '',
            'currently_on_bridging_visa' => $currently_on_bridging_visa,
            'current_visa_category' => $current_visa_category,
            'visa_expiry' => $visa_expiry,
            'conjunction_with_skills_assessment' => (isset($data['conjunction_with_skills_assessment'])) ? $data['conjunction_with_skills_assessment'] : '',
        ];

        // Stepper update if new form is open 
        if (isset($data['submit'])) {
            $details['status'] = '1';
        }

        $this->stage_1_occupation_model->where('pointer_id', $pointer_id)->set($details)->update();


        if (isset($data['submit'])) {  //for next button
            if ($data['submit'] == 'Next') {
                return redirect()->to(base_url("user/stage_1/personal_details/" . $ENC_pointer_id));
            }
            if ($data['submit'] == 'Save & Exit') {
                return redirect()->to(base_url("user/dashboard"));
            }
        } // On button click else Auto update


    } // funtion
}
