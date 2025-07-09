<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class Finish_application extends BaseController
{

    public function Finish_application($ENC_pointer_id)
    {
        // Decode ------
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        
        $application_pointer = $this->application_pointer_model->asObject()->where('id', $pointer_id)->first();
        
        $user_account =  $this->user_account_model->asObject()->where('id',$application_pointer->user_id)->first();
        $stage_1 = $this->stage_1_model->where(['pointer_id' => $pointer_id])->first();
        $stage_2 = $this->stage_2_model->where(['pointer_id' => $pointer_id])->first();
        $stage_3 = $this->stage_3_model->where(['pointer_id' => $pointer_id])->first();
        $stage_3_R = $this->stage_3_reassessment_model->where(['pointer_id' => $pointer_id])->first();
        $stage_4 = $this->stage_4_model->where(['pointer_id' => $pointer_id])->first();
        
        $stage_3_R_documents = $this->documents_model->where(['pointer_id' => $pointer_id,'stage'=>'stage_3_R'])->whereIn('required_document_id', [19,29])->find();
        $documents = $this->documents_model->where(['pointer_id' => $pointer_id])->find();
        $additional_info_request = $this->additional_info_request_model->where(['pointer_id' => $pointer_id])->find();
        $stage_2_add_employment = $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id])->find();



        // company_organisation_name list for stage 2
        $total_employee = array();
        foreach ($stage_2_add_employment as $key => $value) {
            $data = [
                "id" => $value['id'],
                "company_organisation_name" => $value['company_organisation_name'],
            ];
            if (!in_array($data, $total_employee)) {
                $total_employee[] = $data;
            }
        }
        //Assessment Documents


        // all employ document list for stage 2 
        foreach ($stage_2_add_employment as $key => $value) {
        }

        // Application information  for all stage
        $Application_Details = array();
        $stage_1_occupation = $this->stage_1_occupation_model->where(['pointer_id' => $pointer_id])->first();
        $occupation_id =  $stage_1_occupation['occupation_id'];
        $occupation_name = $this->occupation_list_model->where(['id' => $occupation_id])->first();
        if (!empty($occupation_name)) {
            $Application_Details['occupation'] = $occupation_name['name'];
        } else {
            $Application_Details['occupation'] = "";
        }
        $Application_Details['program'] = $stage_1_occupation['program'];
        $Application_Details['pathway'] = $stage_1_occupation['pathway'];
        $Application_Details['unique_id'] = (!empty($stage_1['unique_id'])) ? "[#" . $stage_1['unique_id'] . "]" : "[#T.B.A]";
        $stage_1_personal_details = $this->stage_1_personal_details_model->where(['pointer_id' => $pointer_id])->first();
        $Application_Details['name'] = $stage_1_personal_details['first_or_given_name'] . " " . $stage_1_personal_details['middle_names'] . " " . $stage_1_personal_details['surname_family_name'];

        $stage_2_application_kit = array();
        $application_kit_file_available  = false;
        $offline_file = $this->offline_file_model->where(['use_for' => 'application_kit', 'occupation_id' => $occupation_id])->first();
        if (!empty($offline_file)) {
            $application_kit_file_available = true;
            $stage_2_application_kit['File_full_path'] = $offline_file['path_text'];
            $stage_2_application_kit['name'] = $offline_file['name'];
        }

        $stage_2_application_kit['application_kit_file_available'] = $application_kit_file_available;


        // set stapeer position for all stage
        $stage_index = application_stage_no($pointer_id);
        if ($stage_index >= 2 && $stage_index <= 10 && $stage_index != 5) {
            $is_active = "stage_1";
        } else if ($stage_index == 5 || ($stage_index >= 11 && $stage_index <= 14)) {
            $is_active = "stage_2";
        } else if ($stage_index == 15 || $stage_index == 29  || ($stage_index >= 21 && $stage_index <= 26)) {
            $is_active = "stage_3";
        }else if ($stage_index == 40 || ($stage_index >= 40 && $stage_index <= 48)) {
            $is_active = "stage_3_R";
        } else if ($stage_index == 27 || $stage_index == 28) {
            $is_active = "stage_4";
        } else {
            $is_active = "stage_1";
        }

        // stage 2 start or continu  Button for stage 2
        $is_employe_add = false;
        $stage_2_add_employment = $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id])->first();
        if (!empty($stage_2_add_employment)) {
            $is_employe_add = true;
        }


        $Interview_Schedule = array();
        $stage_3_interview_booking = $this->stage_3_interview_booking_model->where(['pointer_id' => $pointer_id])->first();
        if (!empty($stage_3_interview_booking)) {
            $date_time = $stage_3_interview_booking['date_time'];
            $Interview_Schedule['is_booked'] = $stage_3_interview_booking['is_booked'];
            $Interview_Schedule['tmsp'] = strtotime($date_time);
            $location_id = $stage_3_interview_booking['location_id'];
            $stage_3_offline_location = $this->stage_3_offline_location_model->where(['id' => $location_id])->first();
            $Interview_Schedule['date_time_zone']  = $stage_3_offline_location['date_time_zone'];
            $Interview_Schedule['office_address']  = $stage_3_offline_location['office_address'];
            $Interview_Schedule['country']  = $stage_3_offline_location['country'];
            $Interview_Schedule['venue']  = $stage_3_offline_location['venue'];
        }
        $practical_booking = array();
        $stage_4_interview_booking = $this->stage_4_practical_booking_model->where(['pointer_id' => $pointer_id])->first();
        // print_r($stage_4_interview_booking);
        // exit;
        if (!empty($stage_4_interview_booking)) {
            $date_time = $stage_4_interview_booking['date_time'];
            $practical_booking['is_booked'] = $stage_4_interview_booking['is_booked'];
            $practical_booking['tmsp'] = strtotime($date_time);
            $location_id = $stage_4_interview_booking['location_id'];
            $stage_4_offline_location = $this->stage_3_offline_location_model->where(['id' => $location_id])->first();
            $practical_booking['date_time_zone']  = $stage_4_offline_location['date_time_zone'];
            $practical_booking['office_address']  = $stage_4_offline_location['office_address'];
            $practical_booking['country']  = $stage_4_offline_location['country'];
            $practical_booking['venue']  = $stage_4_offline_location['venue'];
        }
       
        $portal_reference_no =  portal_reference_no($pointer_id);
        $TRA_Application_Form_url = base_url('public/application/' . $pointer_id . '/stage_1/TRA Application Form.pdf');
        $data =  [
            'page' => 'View Application Details',
            'ENC_pointer_id' => $ENC_pointer_id,
            'portal_reference_no' => $portal_reference_no,
            'pointer_id' => $pointer_id,
            'Application_Details' => $Application_Details,
            'is_active' => $is_active,
            'user_account' => $user_account,
            'stage_1' => $stage_1,
            'stage_2' => $stage_2,
            'stage_3' => $stage_3, 
            'stage_4' => $stage_4,
            'stage_3_R' =>$stage_3_R,
            'stage_3_R_documents' =>$stage_3_R_documents,
            'documents' => $documents,
            'occupation_id' =>$occupation_id,
            'additional_info_request' => $additional_info_request,
            'is_employe_add' => $is_employe_add,
            'TRA_Application_Form_url' => $TRA_Application_Form_url,
            'stage_index' => $stage_index,
            'stage_3_interview_booking' => $stage_3_interview_booking,
            'Interview_Schedule' => $Interview_Schedule,
            'practical_booking' => $practical_booking,
            'stage_2_application_kit' => $stage_2_application_kit,
            'Unique_number' => get_unique_number($pointer_id),
            'application_pointer' => $application_pointer,

        ];
         $pathway=$stage_1_occupation['pathway'];
        //$occupation=$stage_1_occupation['occupation'];

        if($pathway=="Pathway 1"){
            if($occupation_name=="Electrician (General)"||$occupation_name=="Plumber (General)"){
                
            }
        }



        return view('user/Finish_application', $data);
    }
}
