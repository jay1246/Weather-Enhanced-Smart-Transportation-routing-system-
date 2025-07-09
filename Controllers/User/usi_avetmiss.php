<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class usi_avetmiss extends BaseController
{

    public function usi_avetmiss($ENC_pointer_id)
    {
        // Decode ------
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        $usi_details = $this->stage_1_usi_avetmiss_model->where(['pointer_id' => $pointer_id])->first();

        $data =  [
            'page' => 'USI, Avetmiss Details',
            'usi_details' => $usi_details,
            'ENC_pointer_id' => $ENC_pointer_id,
            'portal_reference_no' => portal_reference_no($pointer_id),

        ];

        return view('user/stage_1/usi_avetmiss', $data);
    } // funtion close



    public function usi_avetmiss_()
    {
        $data = $this->request->getvar();
        // Decode ------
        $ENC_pointer_id = $data['ENC_pointer_id'];
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        // hide show 
        $i_do_not_intend =  "";
        $i_intend =  "";
        if (isset($data['i_intend'])) {
            if ($data['i_intend'] == 'yes') {
                $i_do_not_intend = '';
                $i_intend =  "yes";
            }
        }
        if (isset($data['i_do_not_intend'])) {
            if ($data['i_do_not_intend'] == 'yes') {
                $i_intend = '';
                $i_do_not_intend = 'yes';
            }
        }

        // hide show 
        if (isset($data['currently_have_usi'])) {
            if ($data['currently_have_usi'] == "no") {
                $usi_no = "";
                $have_usi_transcript = "";
                $permission_access_usi_transcripts = "";
            } else {
                $usi_no = (isset($data['usi_no'])) ? $data['usi_no'] : '';
                $have_usi_transcript = (isset($data['have_usi_transcript'])) ? $data['have_usi_transcript'] : '';
                $permission_access_usi_transcripts = (isset($data['permission_access_usi_transcripts'])) ? $data['permission_access_usi_transcripts'] : '';
            }
        }
        if (isset($data['have_usi_transcript'])) {
            if ($data['have_usi_transcript'] == "no") {
                $permission_access_usi_transcripts = "";
            }
        }


        // hide show 
        $please_indicate_area_note = "";
        if (isset($data['indicate_area'])) {
            if ($data['indicate_area'] == "Other") {
                $please_indicate_area_note = (isset($data['please_indicate_area_note'])) ? $data['please_indicate_area_note'] : '';
            } else {
                $please_indicate_area_note = "";
            }
        }

        // array list 
        $details = [

            'currently_have_usi' => (isset($data['currently_have_usi'])) ? $data['currently_have_usi'] : '',
            'usi_no' =>  $usi_no,
            'i_intend' => $i_intend,
            'i_do_not_intend' =>  $i_do_not_intend,
            'speak_english_at_home' => (isset($data['speak_english_at_home'])) ? $data['speak_english_at_home'] : '',
            'proficiency_in_english' => (isset($data['proficiency_in_english'])) ? $data['proficiency_in_english'] : '',
            'specify_language' => (isset($data['specify_language'])) ? $data['specify_language'] : '',
            'are_you_aboriginal' => (isset($data['are_you_aboriginal'])) ? $data['are_you_aboriginal'] : '',
            'choose_origin' => (isset($data['choose_origin'])) ? $data['choose_origin'] : '',

            'indicate_area' => (isset($data['indicate_area'])) ? $data['indicate_area'] : '',
            'please_indicate_area_note' => $please_indicate_area_note,

            'have_any_disability' => (isset($data['have_any_disability'])) ? $data['have_any_disability'] : '',
            'require_additional_support' => (isset($data['require_additional_support'])) ? $data['require_additional_support'] : '',
            'marketing' => (isset($data['marketing'])) ? $data['marketing'] : '',
            'have_usi_transcript' => $have_usi_transcript,
            'permission_access_usi_transcripts' => $permission_access_usi_transcripts,
            'note' => (isset($data['note'])) ? $data['note'] : '',
        ];

        // Stepper update if new form is open 
        if (isset($data['submit'])) {
            $details['status'] = '1';
        }

        $this->stage_1_usi_avetmiss_model->where(['pointer_id' => $pointer_id])->set($details)->update();

        if (isset($data['submit'])) {  //for next button
            if ($data['submit'] == 'Next') {
                return redirect()->to(base_url('user/stage_1/education_employment_details/' . $ENC_pointer_id));
            } else if ($data['submit'] == 'Save & Exit') {
                return redirect()->to('user/dashboard');
            }
        }  // On button click else Auto update

        return redirect()->back();
    } // Funtion close
}
