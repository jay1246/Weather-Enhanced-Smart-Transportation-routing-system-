<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class incomplete_application extends BaseController
{

    public function incomplete_application()
    {
        $data["page_name"] = "Incomplete Applications";
        $user_id = session()->get("user_id");
        $application_pointer = $this->application_pointer_model->where(['stage' => 'stage_1', 'status' => 'start', "user_id" => $user_id])->orderby('create_date', 'DESC')->findall();


        $table_data = array();
        foreach ($application_pointer as $res) {
            $pointer_id = $res['id'];

            $singal_table_data = array();
            $singal_table_data['pointer_id'] = $pointer_id;

            $singal_table_data['ENC_pointer_id'] =  pointer_id_encrypt($res['id']);
            // helper call
            $singal_table_data['portal_reference_no'] =  portal_reference_no($pointer_id);

            // date format
            $created_at = $res['create_date'];
            $singal_table_data['created_at'] = $created_at;

            $created_at = strtotime($created_at);
            $created_at =  date("d/m/Y", $created_at);
            $singal_table_data['created_at_format'] =  empty($created_at) ? '--//--' : $created_at;



            // table 1
            $personal_details = $this->stage_1_personal_details_model->where(['pointer_id' => $pointer_id])->first();
            $singal_table_data['first_or_given_name'] = empty($personal_details['first_or_given_name']) ? '--//--' : $personal_details['first_or_given_name'];
            $singal_table_data['surname_family_name'] = empty($personal_details['surname_family_name']) ? '' : $personal_details['surname_family_name'];
            $singal_table_data['date_of_birth'] = empty($personal_details['date_of_birth']) ? '--//--' : $personal_details['date_of_birth'];
            // table 2 
            $occupation_application = $this->stage_1_occupation_model->where(['pointer_id' => $pointer_id])->first();

            $occupation_id = isset($occupation_application['occupation_id']);

            $occupation_list = $this->occupation_list_model->where(['id' => $occupation_id])->first();

            $singal_table_data['occupation'] =   (empty($occupation_list['name']) ? '--//--' : $occupation_list['name']);
            // creat mainaray 

            $table_data[] = $singal_table_data;
        }

        $data['table_data'] = $table_data;
        $data['page'] = "Incomplete Applications";

        return view('user/incomplete_application', $data);
    }


    public function incomplete_application_($ENC_pointer_id)
    {
        $table_name = 'stage_1_occupation';
        $occupation_check = helper_Stepper($ENC_pointer_id, $table_name);
        if (!$occupation_check) {
            return redirect()->to(base_url("user/stage_1/occupation/" . $ENC_pointer_id));
        }

        $table_name = 'stage_1_personal_details';
        $personal_details_check = helper_Stepper($ENC_pointer_id, $table_name);
        if (!$personal_details_check) {
            return redirect()->to(base_url("user/stage_1/personal_details/" . $ENC_pointer_id));
        }

        $table_name = 'stage_1_contact_details';
        $contact_details_check = helper_Stepper($ENC_pointer_id, $table_name);
        if (!$contact_details_check) {
            return redirect()->to(base_url("user/stage_1/contact_details/" . $ENC_pointer_id));
        }

        $table_name = 'stage_1_identification_details';
        $identification_details_check = helper_Stepper($ENC_pointer_id, $table_name);
        if (!$identification_details_check) {
            return redirect()->to(base_url("user/stage_1/identification_details/" . $ENC_pointer_id));
        }

        $table_name = 'stage_1_usi_avetmiss';
        $usi_details_check = helper_Stepper($ENC_pointer_id, $table_name);
        if (!$usi_details_check) {
            return redirect()->to(base_url("user/stage_1/usi_avetmiss/" . $ENC_pointer_id));
        }

        $table_name = 'stage_1_education_and_employment';
        $education_and_employment_check = helper_Stepper($ENC_pointer_id, $table_name);
        if (!$education_and_employment_check) {
            return redirect()->to(base_url("user/stage_1/education_employment_details/" . $ENC_pointer_id));
        }

        $colum_name = 'review_confirm_pdf_download';
        $Review_Confirm_check = Stepper_Applicant_Declaration($ENC_pointer_id, $colum_name);
        if (!$Review_Confirm_check) {
            return redirect()->to(base_url("user/stage_1/application_preview/" . $ENC_pointer_id));
        }

        $colum_name = 'applicant_declaration_file_download';
        $Applicant_Declaration_check = Stepper_Applicant_Declaration($ENC_pointer_id, $colum_name);
        if (!$Applicant_Declaration_check) {
            return redirect()->to(base_url("user/stage_1/applicant_declaration/" . $ENC_pointer_id));
        }

        // $colum_name = 'Applicant_Declaration';
        // $Applicant_Declaration_check = Stepper_Applicant_Declaration($ENC_pointer_id, $colum_name);
        // if (!$Applicant_Declaration_check) {
        //     return redirect()->to(base_url("user/stage_1/applicant_declaration/" . $ENC_pointer_id));
        // }

        return redirect()->to(base_url("user/stage_1/upload_documents/" . $ENC_pointer_id));
    } // funtion close


    public function incomplete_application_delete($ENC_pointer_id)
    {
        // Decode ------
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $details = [
            'pointer_id' => $pointer_id,
        ];
        $this->stage_1_occupation_model->where($details)->delete();
        $this->stage_1_personal_details_model->where($details)->delete();
        $this->stage_1_contact_details_model->where($details)->delete();
        $this->stage_1_education_and_employment_model->where($details)->delete();
        $this->stage_1_identification_details_model->where($details)->delete();
        $this->stage_1_usi_avetmiss_model->where($details)->delete();
        $this->stage_1_model->where($details)->delete();
        $this->application_pointer_model->where([
            'id' => $pointer_id,
        ])->delete();


        $this->session->setFlashdata('msg', 'Application Deleted successfully');
        return redirect()->back();
    } // funtion close


}
