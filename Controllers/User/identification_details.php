<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class identification_details extends BaseController
{
    public function identification_details($ENC_pointer_id)
    {
        // Decode ------
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);


        $identification_details = $this->stage_1_identification_details_model->where(['pointer_id' => $pointer_id])->first();
        $country_list = $this->country_model->findAll();
        $data = [
            'page' => "Identification Details",
            'country_list' => $country_list,
            'identification_details' => $identification_details,
            'ENC_pointer_id' => $ENC_pointer_id,
            'portal_reference_no' => portal_reference_no($pointer_id),

        ];

        if (empty($identification_details)) {
            echo "Identification details Page Not Found.";
            exit;
        }


        return view('user/stage_1/identification_details', $data);
    } // funtion close


    public function identification_details_()
    {
        $data = $this->request->getvar();

        // Decode ------
        $ENC_pointer_id = $data['ENC_pointer_id'];
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        // array list for Update
        $details = [

            'country_of_birth' => (isset($data['country_of_birth'])) ? $data['country_of_birth'] : '',
            'passport_country' => (isset($data['passport_country'])) ? $data['passport_country'] : '',
            'place_of_birth' => (isset($data['place_of_birth'])) ? $data['place_of_birth'] : '',
            'current_citizenship' => (isset($data['current_citizenship'])) ? $data['current_citizenship'] : '',
            'passport_number' => (isset($data['passport_number'])) ? $data['passport_number'] : '',
            'place_of_issue' => (isset($data['place_of_issue'])) ? $data['place_of_issue'] : '',
            'expiry_date' => (isset($data['expiry_date'])) ? $data['expiry_date'] : '',
        ];

        // Stepper update if new form is open 
        if (isset($data['submit'])) {
            $details['status'] = '1';
        }
        $this->stage_1_identification_details_model->where(['pointer_id' => $pointer_id])->set($details)->update();

        if (isset($data['submit'])) {  //for next button 
            if ($data['submit'] == 'Next') {
                return redirect()->to(base_url("user/stage_1/usi_avetmiss/" . $ENC_pointer_id));
            } else if ($data['submit'] == 'Save & Exit') {
                return redirect()->to(base_url('user/dashboard'));
            }
        }  // On button click else Auto update

    } // Funtion close
}
