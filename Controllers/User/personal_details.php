<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class personal_details extends BaseController
{
    public function personal_details($ENC_pointer_id)
    {
        // Decode ------
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        $personal_details = $this->stage_1_personal_details_model->where(['pointer_id' => $pointer_id])->first();

        $user_id = $this->session->get('user_id');
        $account_info = $this->user_account_model->where(['id' => $user_id])->first();
        $account_type = $account_info['account_type'];
        $account_data = array();
        if ($account_type == 'Applicant') {
            $account_data['name'] = $account_info['name'];
            $account_data['middle_name'] = $account_info['middle_name'];
            $account_data['last_name'] = $account_info['last_name'];
        } else {
            $account_data['name'] = "";
            $account_data['middle_name'] = "";
            $account_data['last_name'] = "";
        }


        $data = [
            'page' => "Personal Details",
            'account_data' => $account_data,
            'personal_details' => $personal_details,
            'ENC_pointer_id' => $ENC_pointer_id,
            'portal_reference_no' => portal_reference_no($pointer_id),

        ];
        return view('user/stage_1/personal_details', $data);
    } // funtion close


    // public function personal_details_()
    // {

    //     $data = $this->request->getvar();
    //     // Decode ------
    //     $ENC_pointer_id = $data['ENC_pointer_id'];
    //     $pointer_id = pointer_id_decrypt($ENC_pointer_id);

    //     // hide show 
    //     if (isset($data['known_by_any_name'])) {
    //         if ($data['known_by_any_name'] == "no") {
    //             $previous_names =  "";
    //             $previous_middle_names = "";
    //             $previous_surname_or_family_name = "";
    //             $checkbox_only_had_name = "";
    //         } else {
    //             $previous_names = (isset($data['previous_names'])) ? $data['previous_names'] : '';
    //             $previous_middle_names = (isset($data['previous_middle_names'])) ? $data['previous_middle_names'] : '';
    //             $previous_surname_or_family_name = (isset($data['previous_surname_or_family_name'])) ? $data['previous_surname_or_family_name'] : '';
    //             $checkbox_only_had_name = (isset($data['checkbox_only_had_name'])) ? $data['checkbox_only_had_name'] : '';




    //             if (isset($data['checkbox_only_had_name'])) {
    //                 if ($data['checkbox_only_had_name'] == "checked") {
    //                     $previous_surname_or_family_name = "";
    //                     $previous_middle_names = "";
    //                 } else {
    //                     $previous_middle_names = (isset($data['previous_middle_names'])) ? $data['previous_middle_names'] : '';
    //                     $previous_surname_or_family_name = (isset($data['previous_surname_or_family_name'])) ? $data['previous_surname_or_family_name'] : '';
    //                 }
    //             } else {
    //                 $previous_middle_names = (isset($data['previous_middle_names'])) ? $data['previous_middle_names'] : '';
    //                 $previous_surname_or_family_name = (isset($data['previous_surname_or_family_name'])) ? $data['previous_surname_or_family_name'] : '';
    //             }
    //         }
    //     } else {
    //         $previous_names = (isset($data['previous_names'])) ? $data['previous_names'] : '';
    //         $previous_middle_names = (isset($data['previous_middle_names'])) ? $data['previous_middle_names'] : '';
    //         $previous_surname_or_family_name = (isset($data['previous_surname_or_family_name'])) ? $data['previous_surname_or_family_name'] : '';
    //         $checkbox_only_had_name = (isset($data['checkbox_only_had_name'])) ? $data['checkbox_only_had_name'] : '';
    //     }

    //     // hide show 
    //     if (isset($data['other_name'])) {
    //         if ($data['other_name'] == "checked") {
    //             $surname_family_name = "";
    //             $middle_names = "";
    //         } else {
    //             $middle_names = (isset($data['middle_names'])) ? $data['middle_names'] : '';
    //             $surname_family_name = (isset($data['surname_family_name'])) ? $data['surname_family_name'] : '';
    //         }
    //     } else {
            
    //         $middle_names = (isset($data['middle_names'])) ? $data['middle_names'] : '';
    //         $surname_family_name = (isset($data['surname_family_name'])) ? $data['surname_family_name'] : '';
    //     }

    //     // array list for Update
    //     $data['date_of_birth'] = trim($data['date_of_birth']);
    //     $details = [
    //         'pointer_id' => $pointer_id,
    //         'preferred_title' => (isset($data['preferred_title'])) ? $data['preferred_title'] : '',
    //         'surname_family_name' => ucwords(strtolower(trim($surname_family_name))),
    //         'first_or_given_name' => (isset($data['first_or_given_name'])) ? ucwords(strtolower(trim($data['first_or_given_name']))) : '',
    //         'middle_names' => ucwords(strtolower(trim($middle_names))),
    //         'known_by_any_name' => (isset($data['known_by_any_name'])) ? $data['known_by_any_name'] : '',
    //         'other_name' => (isset($data['other_name'])) ? $data['other_name'] : '',
    //         'previous_names' => ucwords(strtolower($previous_names)),
    //         'previous_middle_names' => ucwords(strtolower($previous_middle_names)),
    //         'previous_surname_or_family_name' => ucwords(strtolower($previous_surname_or_family_name)),
    //         'checkbox_only_had_name' => $checkbox_only_had_name,
    //         'gender' => (isset($data['gender'])) ? $data['gender'] : '',
    //         'date_of_birth' => (isset($data['date_of_birth'])) ? $data['date_of_birth'] : '',
    //     ];
    //     // Stepper update if new form is open 
    //     if (isset($data['submit'])) {
    //         $details['status'] = '1';
    //     }


    //     $this->stage_1_personal_details_model->where('pointer_id', $pointer_id)->set($details)->update();

    //     if (isset($data['submit'])) {  //for next button
    //         if ($data['submit'] == 'Next') {
    //             return redirect()->to(base_url('user/stage_1/contact_details/' . $ENC_pointer_id));
    //         } else if ($data['submit'] == 'Save & Exit') {
    //             return redirect()->to(base_url('user/dashbord'));
    //         }
    //     }  // On button click else Auto update


    //     return redirect()->back();
    // }
     public function personal_details_()
    {

        $data = $this->request->getvar();
        // Decode ------
        $ENC_pointer_id = $data['ENC_pointer_id'];
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        // hide show 
        if (isset($data['known_by_any_name'])) {
            if ($data['known_by_any_name'] == "no") {
                $previous_names =  "";
                $previous_middle_names = "";
                $previous_surname_or_family_name = "";
                $checkbox_only_had_name = "";
            } else {
                $previous_names = (isset($data['previous_names'])) ? $data['previous_names'] : '';
                $previous_middle_names = (isset($data['previous_middle_names'])) ? $data['previous_middle_names'] : '';
                $previous_surname_or_family_name = (isset($data['previous_surname_or_family_name'])) ? $data['previous_surname_or_family_name'] : '';
                $checkbox_only_had_name = (isset($data['checkbox_only_had_name'])) ? $data['checkbox_only_had_name'] : '';




                if (isset($data['checkbox_only_had_name'])) {
                    if ($data['checkbox_only_had_name'] == "checked") {
                        $previous_surname_or_family_name = "";
                        $previous_middle_names = "";
                    } else {
                        $previous_middle_names = (isset($data['previous_middle_names'])) ? $data['previous_middle_names'] : '';
                        $previous_surname_or_family_name = (isset($data['previous_surname_or_family_name'])) ? $data['previous_surname_or_family_name'] : '';
                    }
                } else {
                    $previous_middle_names = (isset($data['previous_middle_names'])) ? $data['previous_middle_names'] : '';
                    $previous_surname_or_family_name = (isset($data['previous_surname_or_family_name'])) ? $data['previous_surname_or_family_name'] : '';
                }
            }
        } else {
            $previous_names = (isset($data['previous_names'])) ? $data['previous_names'] : '';
            $previous_middle_names = (isset($data['previous_middle_names'])) ? $data['previous_middle_names'] : '';
            $previous_surname_or_family_name = (isset($data['previous_surname_or_family_name'])) ? $data['previous_surname_or_family_name'] : '';
            $checkbox_only_had_name = (isset($data['checkbox_only_had_name'])) ? $data['checkbox_only_had_name'] : '';
        }

        // hide show 
        if (isset($data['other_name'])) {
            if ($data['other_name'] == "checked") {
                $surname_family_name = "";
                $middle_names = "";
            } else {
                $middle_names = (isset($data['middle_names'])) ? $data['middle_names'] : '';
                $surname_family_name = (isset($data['surname_family_name'])) ? $data['surname_family_name'] : '';
            }
        } else {
            
            $middle_names = (isset($data['middle_names'])) ? $data['middle_names'] : '';
            $surname_family_name = (isset($data['surname_family_name'])) ? $data['surname_family_name'] : '';
        }

    $first_name = (isset($data['first_or_given_name'])) ? ucwords(strtolower(trim($data['first_or_given_name']))) : '';
    $middle_name_=trim($middle_names);
    $middle_name__=ucwords(strtolower($middle_name_));
    $surname_family_name = trim($surname_family_name);
    $surname_family_name_ = ucwords(strtolower($surname_family_name));
        // array list for Update
        $data['date_of_birth'] = trim($data['date_of_birth']);
        $details = [
            'pointer_id' => $pointer_id,
            'preferred_title' => (isset($data['preferred_title'])) ? $data['preferred_title'] : '',
            'surname_family_name' => $surname_family_name_,
            'first_or_given_name' => $first_name,
            'middle_names' => $middle_name__,
            'known_by_any_name' => (isset($data['known_by_any_name'])) ? $data['known_by_any_name'] : '',
            'other_name' => (isset($data['other_name'])) ? $data['other_name'] : '',
            'previous_names' => $previous_names,
            'previous_middle_names' => $previous_middle_names,
            'previous_surname_or_family_name' => $previous_surname_or_family_name,
            'checkbox_only_had_name' => $checkbox_only_had_name,
            'gender' => (isset($data['gender'])) ? $data['gender'] : '',
            'date_of_birth' => (isset($data['date_of_birth'])) ? $data['date_of_birth'] : '',
        ];
        //print_r($details);
        // Stepper update if new form is open 
        if (isset($data['submit'])) {
            $details['status'] = '1';
        }


        $this->stage_1_personal_details_model->where('pointer_id', $pointer_id)->set($details)->update();

        if (isset($data['submit'])) {  //for next button
            if ($data['submit'] == 'Next') {
                return redirect()->to(base_url('user/stage_1/contact_details/' . $ENC_pointer_id));
            } else if ($data['submit'] == 'Save & Exit') {
                return redirect()->to(base_url('user/dashbord'));
            }
        }  // On button click else Auto update


        return redirect()->back();
    }
}
