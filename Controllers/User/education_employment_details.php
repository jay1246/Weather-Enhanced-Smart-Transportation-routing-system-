<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class education_employment_details extends BaseController
{

    public function education_employment_details($ENC_pointer_id)
    {
        // Decode ------
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        $education_and_employment = $this->stage_1_education_and_employment_model->where(['pointer_id' => $pointer_id])->first();

        $data =  [
            'page' => 'Education, Employment Details',
            'education_and_employment' => $education_and_employment,
            'ENC_pointer_id' => $ENC_pointer_id,
            'portal_reference_no' => portal_reference_no($pointer_id),

        ];

        return view('user/stage_1/education_employment_details', $data);
    } // funtion close


    public function education_employment_details_()
    {
        $data = $this->request->getVar();
        // Decode ------
        $ENC_pointer_id = $data['ENC_pointer_id'];
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        // array list with hide show 
        $details = [

            'highest_completed_school_level' => (isset($data['highest_completed_school_level'])) ? $data['highest_completed_school_level'] : '',
            'still_enrolled_in_secondary_or_senior_secondary_education' => (isset($data['are_you_still_enrolled'])) ? $data['are_you_still_enrolled'] : '',
            'completed_any_qualifications' => (isset($data['completed_qualifications'])) ? $data['completed_qualifications'] : '',
            'applicable_qualifications' => (isset($data['applicable_qualifications'])) ? $data['applicable_qualifications'] : '',
            'specify_doc_name' => (isset($data['specify_doc_name'])) ? $data['specify_doc_name'] : '',
            'current_employment_status' => (isset($data['current_employment_status'])) ? $data['current_employment_status'] : '',
            'reason_for_undertaking_this_skills_assessment' => (isset($data['reason_for_undertaking_this_skills_assessment'])) ? $data['reason_for_undertaking_this_skills_assessment'] : '',
            'other_reason_for_undertaking' => (isset($data['other_reason_for_undertaking'])) ? $data['other_reason_for_undertaking'] : '',
        ];

        // Stepper update if new form is open 
        if (isset($data['submit'])) {
            $details['status'] = '1';
        }

        $this->stage_1_education_and_employment_model->where('pointer_id', $pointer_id)->set($details)->update();

        if (isset($data['submit'])) {  //for next button
            if ($data['submit'] == 'Next') {
                return redirect()->to(base_url("user/stage_1/application_preview/" . $ENC_pointer_id));
            } else if ($data['submit'] == 'Save & Exit') {
                return redirect()->to('user/dashboard');
            }
        }  // On button click else Auto update

        return redirect()->back();
    } // Funtion close
}
