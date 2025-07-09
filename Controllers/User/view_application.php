<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class view_application extends BaseController
{

    public function view_application($ENC_pointer_id)
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
        // print_r($stage_3_R);
        // exit;
        $documents = $this->documents_model->where(['pointer_id' => $pointer_id])->orderby('is_additional', 'ASC')->find();
        $additional_info_request = $this->additional_info_request_model->where(['pointer_id' => $pointer_id])->find();
        $stage_2_add_employment = $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id])->find();
        $email_verification = $this->email_verification_model->where(['pointer_id' => $pointer_id])->find();
        $qualification_verification_stage_1 = $this->email_verification_model->where(['pointer_id' => $pointer_id,'verification_type'=>'Verification - Qualification'])->first();

        $stage_2_decline_documnets = $this->documents_model->where(['pointer_id' => $pointer_id, 'stage'=>'stage_2'])->whereIn('required_document_id', [52,51])->orderby('id', 'ASC')->find();
        $stage_3_decline_documnets = $this->documents_model->where(['pointer_id' => $pointer_id, 'stage'=>'stage_3'])->whereIn('required_document_id', [23,24])->orderby('id', 'ASC')->find();
        $stage_3_reassement_decline_documnets = $this->documents_model->where(['pointer_id' => $pointer_id, 'stage'=>'stage_3_R'])->whereIn('required_document_id', [23,24])->orderby('id', 'ASC')->find();
        
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
            // $stage_2_application_kit['name'] = $offline_file['name'];
            $file_name = $offline_file['file_name'];
            // vishal patel 28-04-2023
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_name_without_extension = str_replace('.' . $extension, '', $file_name);
            $stage_2_application_kit['name'] = $file_name_without_extension;
        }

        $stage_2_application_kit['application_kit_file_available'] = $application_kit_file_available;

            
        // set stapeer position for all stage
        $stage_index = application_stage_no($pointer_id);
                    // echo $stage_index;

        if ($stage_index >= 2 && $stage_index <= 10 && $stage_index != 5) {
            $is_active = "stage_1";
            // vishal 29-05-2023 
        } else if ($stage_index == 5 || $stage_index == 17 ||  ($stage_index >= 11 && $stage_index <= 16)) {
            $is_active = "stage_2";
        } else if ($stage_index == 29  ||$stage_index == 39  || ($stage_index >= 21 && $stage_index <= 30)) {
            $is_active = "stage_3";
        } else if ($stage_index == 31 || ($stage_index >= 31 && $stage_index <= 38)) {
            $is_active = "stage_4";
            // akanksha 10 july 2023
        }else if ($stage_index == 40 || ($stage_index >= 40 && $stage_index <= 48)) {
            $is_active = "stage_3_R";
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
            if ($location_id == 9) {
                $Interview_Schedule['date_time_zone']  = $stage_3_interview_booking['time_zone'];
            }
        }
        
        //Cancle Interview Booking Stage_3
           $Interview_Schedule_cancle = array();
        $Interview_Schedule_cancle = $this->stage3_cancle_interview_booking->where(['pointer_id' => $pointer_id])->first();
        if (!empty($Interview_Schedule_cancle)) {
            $date_time = $Interview_Schedule_cancle['date_time'];
            $Interview_Schedule_cancle['is_booked'] = $Interview_Schedule_cancle['is_booked'];
             $cancle_date=$Interview_Schedule_cancle['interview_cancle_date'];
            $Interview_Schedule_cancle['tmsp'] = strtotime($date_time);
            $Interview_Schedule_cancle['cancle'] = $Interview_Schedule_cancle['interview_cancle_date'];;
            $location_id = $Interview_Schedule_cancle['location_id'];
            $reason=$Interview_Schedule_cancle['interview_comment'];
            $stage_3_offline_location = $this->stage_3_offline_location_model->where(['id' => $location_id])->first();
            $Interview_Schedule_cancle['date_time_zone']  = $stage_3_offline_location['date_time_zone'];
            $Interview_Schedule_cancle['office_address']  = $stage_3_offline_location['office_address'];
            $Interview_Schedule_cancle['country']  = $stage_3_offline_location['country'];
            $Interview_Schedule_cancle['venue']  = $stage_3_offline_location['venue'];
            if ($location_id == 9) {
                $Interview_Schedule_cancle['date_time_zone']  = $Interview_Schedule_cancle['time_zone'];
            }
        }
        
        $Interview_Schedule_R = array();
        $stage_3_reassessment_interview_booking = $this->stage_3_reassessment_interview_booking_model->where(['pointer_id' => $pointer_id])->first();
        if (!empty($stage_3_reassessment_interview_booking)) {
            $date_time_r = $stage_3_reassessment_interview_booking['date_time'];
            $Interview_Schedule_R['is_booked'] = $stage_3_reassessment_interview_booking['is_booked'];
            $Interview_Schedule_R['tmsp'] = strtotime($date_time_r);
            $location_id = $stage_3_reassessment_interview_booking['location_id'];
            $stage_3_offline_location = $this->stage_3_offline_location_model->where(['id' => $location_id])->first();
            $Interview_Schedule_R['date_time_zone']  = $stage_3_offline_location['date_time_zone'];
            $Interview_Schedule_R['office_address']  = $stage_3_offline_location['office_address'];
            $Interview_Schedule_R['country']  = $stage_3_offline_location['country'];
            $Interview_Schedule_R['venue']  = $stage_3_offline_location['venue'];
            if ($location_id == 9) {
                $Interview_Schedule_R['date_time_zone']  = $stage_3_reassessment_interview_booking['time_zone'];
            }
        }
        
         //Cancle Interview Booking Stage_3_R
           $Interview_Schedule_cancle_reass = array();
        $Interview_Schedule_cancle_reass = $this->stage3_reass_cancle_interview_booking->where(['pointer_id' => $pointer_id])->first();
        if (!empty($Interview_Schedule_cancle_reass)) {
            $date_time = $Interview_Schedule_cancle_reass['date_time'];
            $Interview_Schedule_cancle_reass['is_booked'] = $Interview_Schedule_cancle_reass['is_booked'];
            $Interview_Schedule_cancle_reass['tmsp'] = strtotime($date_time);
            $location_id = $Interview_Schedule_cancle_reass['location_id'];
            $reason=$Interview_Schedule_cancle_reass['interview_comment'];
            $cancle_date=$Interview_Schedule_cancle_reass['interview_cancle_date'];
            $Interview_Schedule_cancle_reass['cancle'] =$cancle_date;
            $stage_3_offline_location = $this->stage_3_offline_location_model->where(['id' => $location_id])->first();
            $Interview_Schedule_cancle_reass['date_time_zone']  = $stage_3_offline_location['date_time_zone'];
            $Interview_Schedule_cancle_reass['office_address']  = $stage_3_offline_location['office_address'];
            $Interview_Schedule_cancle_reass['country']  = $stage_3_offline_location['country'];
            $Interview_Schedule_cancle_reass['venue']  = $stage_3_offline_location['venue'];
            if ($location_id == 9) {
                $Interview_Schedule_cancle_reass['date_time_zone']  = $Interview_Schedule_cancle_reass['time_zone'];
            }
        }
        $portal_reference_no =  portal_reference_no($pointer_id);
// print_r($Interview_Schedule_cancle_reass);
// die;
            // stage_4
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
            $practical_booking['location_id__']  = $location_id;
        }
        // print_r($practical_booking);
        // exit;
       
        $TRA_Application_Form_url = base_url('public/application/' . $pointer_id . '/stage_1/TRA Application Form.pdf');
        // echo $TRA_Application_Form_url;
        // exit;

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
            'stage_3_R' =>$stage_3_R,
            'stage_4' => $stage_4,
            'documents' => $documents,
            'email_verification' => $email_verification,
            'qualification_verification_stage_1' =>$qualification_verification_stage_1,
            'additional_info_request' => $additional_info_request,
            'is_employe_add' => $is_employe_add,
            'TRA_Application_Form_url' => $TRA_Application_Form_url,
            'stage_index' => $stage_index,
            'stage_3_interview_booking' => $stage_3_interview_booking,
            'stage_3_reassessment_interview_booking' => $stage_3_reassessment_interview_booking,
            'Interview_Schedule' => $Interview_Schedule,
            'Interview_Schedule_R' => $Interview_Schedule_R,
            'practical_booking' => $practical_booking,
            'stage_2_application_kit' => $stage_2_application_kit,
            'Unique_number' => get_unique_number($pointer_id),
            'stage_2_decline_documnets' =>$stage_2_decline_documnets,
            'stage_3_decline_documnets'=>$stage_3_decline_documnets,
            'stage_3_reassement_decline_documnets'=>$stage_3_reassement_decline_documnets,
            'Interview_Schedule_cancle'=>$Interview_Schedule_cancle,
            'Interview_Schedule_cancle_reass'=>$Interview_Schedule_cancle_reass
             
        ];

            // Setting Popup at the once time only
            $session = session();
            $session->set('__show_popup', true);
            // End 

        return view('user/view_application', $data);
    }

    // user -> view_application -> all stages -> additional_information_request
    public function additional_information_request($stage, $ENC_pointer_id)
    {
        // print_r($_POST);
        //                 exit;
        
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $add_req_ids = $this->request->getPost("add_req_id");
        $doc_names = $this->request->getPost("doc_name");
        $document_ids = $this->request->getPost("document_id");
        $employee_ids = $this->request->getPost("employee_id");
        $send_by = $this->request->getPost("send_by");  // dont send array
       
        $stage = $this->request->getPost("stage");

        $required_document_id = "";
        if ($stage == "stage_1") {
            $required_document_id = 28;
        } else   if ($stage == "stage_2") {
            $required_document_id = 17;
        } else   if ($stage == "stage_3") {
            $required_document_id = 29;
        }else   if ($stage == "stage_3_R") {
            $required_document_id = 29;
        }else   if ($stage == "stage_4") {
            $required_document_id = 49;
        }

        $files = $this->request->getFileMultiple("file");
        if ($this->request->getFileMultiple('file')) {

            // move file to folder
            foreach ($files as $key => $value) {
                if ($value) {
                    $file = $files[$key];
                    $file_extention = $file->getClientExtension();
                    $add_req_id = $add_req_ids[$key];
                    if (isset($employee_ids[$key])) {
                        if ($employee_ids[$key] != "") {
                            $employee_id = $employee_ids[$key];
                        } else {
                            $employee_id = " ";
                        }
                    } else {
                        $employee_id = " ";
                    }

                    $document_id = "";
                    
                    if ($document_ids[$key]) {
                        $document_id =  $document_ids[$key];
                        $old_doc = find_one_row('documents', 'id', $document_id);
                        $old_doc_name = explode('.', $old_doc->document_name);
                        
                        // Find Whether File Exist
                        if(file_exists($old_doc->document_path . '/' . $old_doc->document_name)){
                            unlink($old_doc->document_path . '/' . $old_doc->document_name);
                        }
                        
                        
                        $final_file_name = $old_doc_name[0] . '.' . $file_extention;
                        $check =    $file->move($old_doc->document_path, $final_file_name);
                        if ($check) {
                            $data = array(
                                // 'required_document_id' => $required_document_id,
                                'employee_id' => $employee_id,
                                'document_name' => $final_file_name,
                                'status' => 1,
                                'update_date' => date("Y-m-d H:i:s"),
                            );
                            $this->documents_model->update($document_id, $data);
                            //   echo "move sql update";
                            
                            //for insert docs in note module
                             $is_additional_data = $this->additional_info_request_model->where('document_id', $document_id)->get()->getRow();
                             //$admin_ac = $this->admin_account_model->where('id', $send_by)->get()->getRow();
                            //  if($admin_ac->id == 1 ){
                            //       $user_name = $admin_ac->first_name;
                            //  }else{
                            //       $user_name = $admin_ac->first_name. " " .$admin_ac->last_name; 
                            //  }
                              //$color=$admin_ac->color; 
                              
                              $data_insert_check = [
                                        'message' => $is_additional_data->reason,
                                        'documents' => $final_file_name,
                                        'is_send_doc_request'=>'upload',
                                        'documents_path'=>$old_doc->document_path.'/'.$final_file_name,
                                        'pointer_id' => $pointer_id,
                                        'admin_id' => $send_by,
                                        'user_name'=>'Server',
                                        'color'=>'black',
                                        'updated_at' => date('Y-m-d H:i:s'),
                                    ];
                                    
                            // Check Data Already Exist
                              if(!$this->notes->where($data_insert_check)->first()){
                              
                                  $data_insert = [
                                            'message' => $is_additional_data->reason,
                                            'documents' => $final_file_name,
                                            'is_send_doc_request'=>'upload',
                                            'documents_path'=>$old_doc->document_path.'/'.$final_file_name,
                                            'pointer_id' => $pointer_id,
                                            'admin_id' => $send_by,
                                            'user_name'=>'Server',
                                            'color'=>'black',
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'updated_at' => date('Y-m-d H:i:s'),
                                        ];
                                        
                                    
                                    $insert = $this->notes->insert($data_insert);
                              }
                            //   END Conditon 
                        }
                    } else {
                        // echo "<hr>";
                      
                        
                        if (isset($doc_names)) {
                            $doc_name = preg_replace('/[^A-Za-z0-9\-]/', ' ', $doc_names[$key]);
                            $is_additional__ = NULL;
                            if($stage == "stage_2"){
                                $is_additional__ = "yes";
                            }
                            $folder_path = 'public/application/' . $pointer_id . '/' . $stage;
                            $final_file_name = trim($doc_name, " ") . '.' . $file_extention;
                            $check =    $file->move($folder_path, $final_file_name);
                            
                            $required_document_id__alter = $required_document_id;
                            if ($check) {
                                if($stage == "stage_2"){
                                    $required_document_id__alter = ($this->request->getPost("support_evidance_status")[$key] == "yes") ? 16 : $required_document_id;
                                }
                                $data = array(
                                    'pointer_id' => $pointer_id,
                                    'stage' => $stage,
                                    'required_document_id' => $required_document_id__alter,
                                    'employee_id' => $employee_id,
                                    'is_additional' => $is_additional__,
                                    'name' => $doc_name,
                                    'document_name' => $final_file_name,
                                    'document_path' => $folder_path,
                                    'status' => 1,
                                    'update_date' => date("Y-m-d H:i:s"),
                                    'create_date' => date("Y-m-d H:i:s")
                                );
                                
                            //   print_r($data);
                                $this->documents_model->insert($data);
                                $document_id = $this->documents_model->getInsertID();

                                echo "move sql insert";
                            }
                          
                        }
                    }

                    $data_req = array(
                        'document_id' => $document_id,
                        'status' => 'upload',
                        'update_date' => date("Y-m-d H:i:s"),
                    );
                    $this->additional_info_request_model->update($add_req_id, $data_req);
                    
                        //for insert docs in note module
                             $is_additional_data = $this->additional_info_request_model->where('document_id', $document_id)->get()->getRow();
                             $is_documents_data = $this->documents_model->where('id', $document_id)->get()->getRow();
                            //  $admin_ac = $this->admin_account_model->where('id', $send_by)->get()->getRow();
                            //  if($admin_ac->id == 1 ){
                            //       $user_name = $admin_ac->first_name;
                            //  }else{
                            //       $user_name = $admin_ac->first_name. " " .$admin_ac->last_name; 
                            //  }
                            //  $color=$admin_ac->color; 
                            // 
                            
                            $data_insert_check = [
                                            'message' => $is_additional_data->reason,
                                            'documents' => $final_file_name,
                                            'is_send_doc_request'=>'upload',
                                            'documents_path'=>$is_documents_data->document_path.'/'.$is_documents_data->document_name,
                                            'pointer_id' => $pointer_id,
                                            'admin_id' => $send_by,
                                            'user_name'=>'Server',
                                            'color'=>'black',
                                            'updated_at' => date('Y-m-d H:i:s'),
                                            ];
                                            
                            
                            // 
                            // Check Data Already Exist
                              if(!$this->notes->where($data_insert_check)->first()){
                            
                                // 
                                  $data_insert = [
                                            'message' => $is_additional_data->reason,
                                            'documents' => $final_file_name,
                                            'is_send_doc_request'=>'upload',
                                            'documents_path'=>$is_documents_data->document_path.'/'.$is_documents_data->document_name,
                                            'pointer_id' => $pointer_id,
                                            'admin_id' => $send_by,
                                            'user_name'=>'Server',
                                            'color'=>'black',
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'updated_at' => date('Y-m-d H:i:s'),
                                        ];
                                  $insert = $this->notes->insert($data_insert);
                              }
                     
                } else {
                    echo "value not found <br>";
                }
                $key++;
            }


            // send email -----------
            $user_account_ = $this->admin_account_model->where('id', $send_by)->first();
            if (!empty($user_account_)) {
                $role = $user_account_['account_type'];
                $admin = false;
                if ($role == "admin") {
                    $admin = true;
                }
                $head_office = false;
                if ($role == "head_office") {
                    $admin = true;
                    $head_office = true;
                }

                $application_pointer_model = $this->application_pointer_model->asObject()->where('id', $pointer_id)->first();
                $user_id = (isset($application_pointer_model->user_id) ? $application_pointer_model->user_id : "");
                $user_account = $this->user_account_model->asObject()->where('id', $user_id)->first();
                $user_mail = (isset($user_account->email) ? $user_account->email : "");

                if ($stage == "stage_1") {

                    if (!empty($user_mail)) {
                        $client_type =  is_Agent_Applicant($pointer_id);
                        if ($client_type == "Agent") { // Applicant
                            // s1_Additional_info_received_send_to_agent
                            $mail_temp_4 = $this->mail_template_model->where(['id' => '54'])->first();
                            if (!empty($mail_temp_4)) {
                                $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                                $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $user_mail, $subject, $message, [],[],[],[],$pointer_id);
                                if ($check == 1) {
                                } // email send check
                            }
                        }
                        if ($client_type == "Applicant") {
                            // s1_additional_information_received_applicant
                            $mail_temp_4 = $this->mail_template_model->where(['id' => '60'])->first();
                            if (!empty($mail_temp_4)) {
                                $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                                $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $user_mail, $subject, $message, [],[],[],[],$pointer_id);
                                if ($check == 1) {
                                } // email send check
                            }
                        }
                    }





                    if ($head_office) {
                        // s1_request_additional_admin
                        $mail_temp_4 = $this->mail_template_model->where(['id' => '50'])->first();
                        if (!empty($mail_temp_4)) {
                            $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                            $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), env('HEADOFFICE_EMAIL'), $subject, $message,[],[],[],[],$pointer_id);
                            if ($check == 1) {
                            } // email send check
                        }
                    }
                    if ($admin) {
                        // s1_request_additional_admin
                        $mail_temp_4 = $this->mail_template_model->where(['id' => '50'])->first();
                        if (!empty($mail_temp_4)) {
                            $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                            $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), env('ADMIN_EMAIL'), $subject, $message,[],[],[],[],$pointer_id);
                            if ($check == 1) {
                            } // email send check
                        }
                    }
                } // stage 1 email

                if ($stage == "stage_2") {

                    if (!empty($user_mail)) {
                        $client_type =  is_Agent_Applicant($pointer_id);
                        if ($client_type == "Agent") { // Applicant
                            // s2_Additional_info_received_send_to_agent
                            $mail_temp_4 = $this->mail_template_model->where(['id' => '87'])->first();
                            if (!empty($mail_temp_4)) {
                                $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                                $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $user_mail, $subject, $message, [],[],[],[],$pointer_id);
                                if ($check == 1) {
                                } // email send check
                            }
                        }
                        if ($client_type == "Applicant") {
                            // s2_Additional_info_received_send_to_applicant
                            $mail_temp_4 = $this->mail_template_model->where(['id' => '71'])->first();
                            if (!empty($mail_temp_4)) {
                                $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                                $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $user_mail, $subject, $message, [],[],[],[],$pointer_id);
                                if ($check == 1) {
                                } // email send check
                            }
                        }
                    }


                    if ($head_office) {
                        //s2_request_additional_admin
                        $mail_temp_4 = $this->mail_template_model->where(['id' => '51'])->first();
                        if (!empty($mail_temp_4)) {
                            $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                            $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), env('HEADOFFICE_EMAIL'), $subject, $message,[],[],[],[],$pointer_id);
                            if ($check == 1) {
                            } // email send check
                        }
                    }
                    if ($admin) {
                        // s2_request_additional_admin
                        $mail_temp_4 = $this->mail_template_model->where(['id' => '51'])->first();
                        if (!empty($mail_temp_4)) {
                            $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                            $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), env('ADMIN_EMAIL'), $subject, $message,[],[],[],[],$pointer_id);
                            if ($check == 1) {
                            } // email send check
                        }
                    }
                } // stage 2 email

                if ($stage == "stage_3") {

                    if (!empty($user_mail)) {
                        $client_type =  is_Agent_Applicant($pointer_id);
                        if ($client_type == "Agent") {
                            // s3_Additional_info_received_send_to_agent
                            $mail_temp_4 = $this->mail_template_model->where(['id' => '103'])->first();
                            if (!empty($mail_temp_4)) {
                                $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                                $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $user_mail, $subject, $message, [],[],[],[],$pointer_id);
                                if ($check == 1) {
                                } // email send check
                            }
                        }
                        if ($client_type == "Applicant") {
                            // s3_Additional_info_received_send_to_applicant
                            $mail_temp_4 = $this->mail_template_model->where(['id' => '74'])->first();
                            if (!empty($mail_temp_4)) {
                                $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                                $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $user_mail, $subject, $message, [],[],[],[],$pointer_id);
                                if ($check == 1) {
                                } // email send check
                            }
                        }
                    }



                    if ($head_office) {
                        // s3_request_additional_admin
                        $mail_temp_4 = $this->mail_template_model->where(['id' => '52'])->first();
                        if (!empty($mail_temp_4)) {
                            $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                            $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), env('HEADOFFICE_EMAIL'), $subject, $message,[],[],[],[],$pointer_id);
                            if ($check == 1) {
                            } // email send check
                        }
                    }
                    if ($admin) {
                        // s3_request_additional_admin
                        $mail_temp_4 = $this->mail_template_model->where(['id' => '52'])->first();
                        if (!empty($mail_temp_4)) {
                            $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                            $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), env('ADMIN_EMAIL'), $subject, $message,[],[],[],[],$pointer_id);
                            if ($check == 1) {
                            } // email send check
                        }
                    }
                } // stage 3 email
                if ($stage == "stage_3_R") {

                    if (!empty($user_mail)) {
                        $client_type =  is_Agent_Applicant($pointer_id);
                        if ($client_type == "Agent") {
                            // s3_Additional_info_received_send_to_agent
                            $mail_temp_4 = $this->mail_template_model->where(['id' => '172'])->first();
                            if (!empty($mail_temp_4)) {
                                $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                                $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $user_mail, $subject, $message, [],[],[],[],$pointer_id);
                                if ($check == 1) {
                                } // email send check
                            }
                        }
                        if ($client_type == "Applicant") {
                            // s3_Additional_info_received_send_to_applicant
                            $mail_temp_4 = $this->mail_template_model->where(['id' => '175'])->first();
                            if (!empty($mail_temp_4)) {
                                $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                                $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $user_mail, $subject, $message, [],[],[],[],$pointer_id);
                                if ($check == 1) {
                                } // email send check
                            }
                        }
                    }



                    if ($head_office) {
                        // s3_request_additional_admin
                        $mail_temp_4 = $this->mail_template_model->where(['id' => '190'])->first();
                        if (!empty($mail_temp_4)) {
                            $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                            $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), env('HEADOFFICE_EMAIL'), $subject, $message,[],[],[],[],$pointer_id);
                            if ($check == 1) {
                            } // email send check
                        }
                    }
                    if ($admin) {
                        // s3_request_additional_admin
                        $mail_temp_4 = $this->mail_template_model->where(['id' => '190'])->first();
                        if (!empty($mail_temp_4)) {
                            $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                            $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), env('ADMIN_EMAIL'), $subject, $message,[],[],[],[],$pointer_id);
                            if ($check == 1) {
                            } // email send check
                        }
                    }
                } // stage 3 email
                
                if ($stage == "stage_4") {

                    if (!empty($user_mail)) {
                        $client_type =  is_Agent_Applicant($pointer_id);
                        if ($client_type == "Agent") { // Applicant
                            // s4_Additional_info_received_send_to_agent
                            $mail_temp_4 = $this->mail_template_model->where(['id' => '151'])->first();
                            if (!empty($mail_temp_4)) {
                                $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                                $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $user_mail, $subject, $message, [],[],[],[],$pointer_id);
                                if ($check == 1) {
                                } // email send check
                            }
                        }
                        if ($client_type == "Applicant") {
                            // s4_additional_information_received_applicant
                            $mail_temp_4 = $this->mail_template_model->where(['id' => '150'])->first();
                            if (!empty($mail_temp_4)) {
                                $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                                $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $user_mail, $subject, $message, [],[],[],[],$pointer_id);
                                if ($check == 1) {
                                } // email send check
                            }
                        }
                    }

                    if ($head_office) {
                        // s4_request_additional_admin
                        $mail_temp_4 = $this->mail_template_model->where(['id' => '152'])->first();
                        if (!empty($mail_temp_4)) {
                            $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                            $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), env('HEADOFFICE_EMAIL'), $subject, $message,[],[],[],[],$pointer_id);
                            if ($check == 1) {
                            } // email send check
                        }
                    }
                    if ($admin) {
                        // s4_request_additional_admin
                        $mail_temp_4 = $this->mail_template_model->where(['id' => '152'])->first();
                        if (!empty($mail_temp_4)) {
                            $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                            $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), env('ADMIN_EMAIL'), $subject, $message,[],[],[],[],$pointer_id);
                            if ($check == 1) {
                            } // email send check
                        }
                    }
                } // stage 4 email

            }
            // send email ----------- Done


            return redirect()->back();
        } else {
            echo "sorry file is empty <br>";
        }
    }
}
