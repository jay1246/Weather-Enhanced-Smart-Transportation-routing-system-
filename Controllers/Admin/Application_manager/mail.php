<?php

namespace App\Controllers\Admin\Application_manager;

use App\Controllers\BaseController;

class mail extends BaseController
{
    // ----------------admin Application Manager -> view/update ->stage 1 self assessment ---------------
    public function stage_1_change_status()
    {
        $user_id = $this->request->getPost('user_id');
        $pointer_id = $this->request->getPost('pointer_id');
        $reason = $this->request->getPost('reason');
        $stage_1_id = $this->request->getPost('stage_1_id');
        $status = $this->request->getPost('status');
        $unique_id = $this->request->getPost("unique_id");
        $approval_comment = trim($this->request->getPost("approval_comment"));

        $date = $this->additional_info_request_model->where(['stage' => "stage_1", 'pointer_id' => $pointer_id])->find();
        $check_if_file = true;
        foreach ($date as $key => $value) {
            if ($value['status'] == "send") {
                $check_if_file = false;
            }
        }
        if ($check_if_file) {
            $this->additional_info_request_model->where(['stage' => "stage_1", 'pointer_id' => $pointer_id])->set(['status' => 'verified'])->update();
        }

        $allocate_team_member_name = "";
        if (isset($_POST['allocate_team_member_name'])) {
            $allocate_team_member_name = $_POST['allocate_team_member_name'];
        }

        $data_unique_id = ['unique_id' => $unique_id];
        $this->stage_1_model->update($stage_1_id, $data_unique_id);

        $s1_occupation = $this->stage_1_occupation_model->asObject()->where('pointer_id', $pointer_id)->first();
        $user_account = $this->user_account_model->asObject()->where('id', $user_id)->first();
        $user_mail = $user_account->email;
        $mail_check = 0;
        $database_check = 0;



        if ($status == 'Lodged') {
            // s1_lodged_head_office
            $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '3'])->first();
            $subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
            $message = $mail_temp_1->body;
            $to = env('HEADOFFICE_EMAIL');
            $mail_check =  send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);

            //database record for mail 1
            $admin_status = [
                'status' => $status,
                'allocate_team_member_name' => $allocate_team_member_name,
                'lodged_date' =>  date("Y-m-d H:i:s"),
                'lodged_by' => session()->get('admin_id'),
                'update_date' => date("Y-m-d H:i:s")
            ];
            $database_check =  $this->stage_1_model->update($stage_1_id, $admin_status);

            $pointer_data = [
                'stage' => 'stage_1',
                'status' => $status,
                'update_date' => date("Y-m-d H:i:s")
            ];
            $database_check =  $this->application_pointer_model->update($pointer_id, $pointer_data);
             delete_by_pointer_id__($pointer_id,'stage_1');
        } elseif ($status == 'In Progress') {

            // s1_in_progress_admin
            $mail_temp_2 = $this->mail_template_model->asObject()->where(['id' => '4'])->first();
            $subject = mail_tag_replace($mail_temp_2->subject, $pointer_id);
            $message =  $mail_temp_2->body;
            $to =  env('DIPREET_EMAIL');
            // $mail_check =   send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);

            //database record for mail 2
            $admin_status = [
                'status' => $status,
                'allocate_team_member_name' => $allocate_team_member_name,
                'in_progress_date' => date("Y-m-d H:i:s"),
                'in_progress_by' => session()->get('admin_id'),
                'update_date' => date("Y-m-d H:i:s")
            ];
            $database_check =  $this->stage_1_model->update($stage_1_id, $admin_status);
           
            $pointer_data = [
                'stage' => 'stage_1',
                'status' => $status,
                'update_date' => date("Y-m-d H:i:s"),
                'approved_date' => NULL,
                'approved_comment' => NULL,
                'withdraw_date' => NULL,
                'declined_date' => NULL,
                'declined_reason' => NULL,
                'archive' => NULL,
                'archive_date' => NULL,
                'expiry_date' => NULL,
                'closure_date' => NULL,
                'date_reinstate' => NULL,
                'omitted_date' => NULL,
                'omitted_deadline_date' => NULL,
                'is_reinstated' => 0,
                'reminder_email_send' => 0,
                'archive_email_send' => 0,
                'expiry_email_send' => 0,
                
            ];
            $database_check =  $this->application_pointer_model->update($pointer_id, $pointer_data);
            delete_by_pointer_id__($pointer_id,'stage_1');
        } elseif ($status == 'Approved' && $s1_occupation->program == 'TSS') {
            $mail_check = 0;
            $assessors_comment = '';
            if($approval_comment){
                $assessors_comment = '<br/><br/><p dir="ltr" id="gmail-isPasted" style="box-sizing: border-box; margin-top: 0pt; margin-bottom: 0pt; line-height: 1;"><span style="font-family: sans-serif; text-align: var(--bs-body-text-align); font-size: 11pt; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space-collapse: preserve;"><b><span style="background-color: rgb(255,214,99);">ASSESSOR’S COMMENTS: "'.$approval_comment.'"</span></b></span></p>';
            }
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") { // Applicant
                //s1_approved_tss_agent
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '5'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $message = str_replace("%assessors_comment%",$assessors_comment,$message);
                $to = $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            if ($client_type == "Applicant") {
                // s1_approved_tss_application
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '58'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $message = str_replace("%assessors_comment%",$assessors_comment,$message);
                $to = $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            
            // If Comment is there then send message
            if($approval_comment){
                
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '217'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $message = str_replace("%assessors_comment%",$approval_comment,$message);
                $to = $user_mail;
                $bcc_mail = env("ADMIN_EMAIL");
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[$bcc_mail],[],[],$pointer_id);
            }
            // End
            

            //-------------------- stage 1 Approved Admin mail  -- TSS -------------------
            $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '6'])->first();
            $subject = mail_tag_replace($mail_temp_4->subject, $pointer_id);
            $message = $mail_temp_4->body;
            // new add on 04-04-2023 by vishal as par clint call
            $to =   env('DIPREET_EMAIL');
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            $mail_check_2 = 0;
            if ($check == 1) {
                $mail_check_2 = 1;
            }
            if ($mail_check == 1 && $mail_check_2 == 1) {
                $admin_status = [
                    'status' => $status,
                    'expiry_date' => date('Y-m-d H:i:s', strtotime('+30 days', strtotime(date('Y-m-d H:i:s')))),
                    'approved_date' => date("Y-m-d H:i:s"),
                    'approved_comment' => $approval_comment,
                    'approved_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $database_check = $this->stage_1_model->update($stage_1_id, $admin_status);

                $pointer_data = [
                    'stage' => 'stage_1',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $database_check =  $this->application_pointer_model->update($pointer_id, $pointer_data);
                delete_by_pointer_id__($pointer_id,'stage_1');
            }
        } elseif ($status == 'Approved' && $s1_occupation->program == 'OSAP') {
            $mail_check = 0; 
            $assessors_comment = '';
            if($approval_comment){
                $assessors_comment = '<br/><br/><p dir="ltr" id="gmail-isPasted" style="box-sizing: border-box; margin-top: 0pt; margin-bottom: 0pt; line-height: 1;"><span style="font-family: sans-serif; text-align: var(--bs-body-text-align); font-size: 11pt; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space-collapse: preserve;"><b><span style="background-color: rgb(255,214,99);">ASSESSOR’S COMMENTS: "'.$approval_comment.'"</span></b></span></p>';
            }
            $client_type =  is_Agent_Applicant($pointer_id);
            // Applicant Agent
            if ($client_type == "Agent") {
                //-------------------- stage 1 Approved Agent mail OSAP -------------------
                $mail_temp_5 = $this->mail_template_model->asObject()->where(['id' => '7'])->first();
                $subject = mail_tag_replace($mail_temp_5->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_5->body, $pointer_id);
                $message = str_replace("%assessors_comment%",$assessors_comment,$message);
                $to =  $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            if ($client_type == "Applicant") {
                //-------------------- stage 1 Approved Applicants mail OSAP -------------------
                $mail_temp_5 = $this->mail_template_model->asObject()->where(['id' => '59'])->first();
                $subject = mail_tag_replace($mail_temp_5->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_5->body, $pointer_id);
                $message = str_replace("%assessors_comment%",$assessors_comment,$message);
                $to =  $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            
            // If Comment is there then send message
            if($approval_comment){
                
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '217'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $message = str_replace("%assessors_comment%",$approval_comment,$message);
                $to = $user_mail;
                $bcc_mail = env("ADMIN_EMAIL");
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[$bcc_mail],[],[],$pointer_id);
            }
            // End


            // -----------------------------------------stage 1 Approved admin mail OSAP-------------------      
            $mail_check_2 = 0;
            $mail_temp_8 = $this->mail_template_model->asObject()->where(['id' => '8'])->first();
            $subject = mail_tag_replace($mail_temp_8->subject, $pointer_id);
            $message = $mail_temp_8->body;
            // new add on 04-04-2023 by vishal as par clint call
            $to =   env('DIPREET_EMAIL');
            $check_2 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            if ($check_2 == 1) {
                $mail_check_2 = 1;
            }

            if ($mail_check == 1 && $mail_check_2 == 1) {
                //database record for mail 6 
                $admin_status = [
                    'status' => $status,
                    'approved_date' => date("Y-m-d H:i:s"),
                    'approved_comment' => $approval_comment,
                    'expiry_date' => date('Y-m-d H:i:s', strtotime('+30 days', strtotime(date('Y-m-d H:i:s')))),
                    'approved_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $database_check = $this->stage_1_model->update($stage_1_id, $admin_status);
                $pointer_data = [
                    'stage' => 'stage_1',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $database_check =  $this->application_pointer_model->update($pointer_id, $pointer_data);
                delete_by_pointer_id__($pointer_id,'stage_1');
            }
        }
        // Omitted Start
         elseif ($status == 'Omitted' && $s1_occupation->program == 'TSS') {
            $omitted_deadline_date = $this->request->getPost('omitted_deadline_date');
            $mail_check = 0;
            $assessors_comment = '';
            if($approval_comment){
                $assessors_comment = '<br/><br/><p dir="ltr" id="gmail-isPasted" style="box-sizing: border-box; margin-top: 0pt; margin-bottom: 0pt; line-height: 1;"><span style="font-family: sans-serif; text-align: var(--bs-body-text-align); font-size: 11pt; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space-collapse: preserve;"><b><span style="background-color: rgb(255,214,99);">ASSESSOR’S COMMENTS: "'.$approval_comment.'"</span></b></span></p>';
            }
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") { // Applicant
                //s1_approved_tss_agent
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '224'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $message = str_replace("%omitted_deadline_date%", date("d/m/Y", strtotime($omitted_deadline_date)),$message);
                $to = $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            if ($client_type == "Applicant") {
                // s1_approved_tss_application
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '227'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $message = str_replace("%omitted_deadline_date%", date("d/m/Y", strtotime($omitted_deadline_date)),$message);
                $to = $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            
            

            //-------------------- stage 1 Approved Admin mail  -- TSS -------------------
            $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '228'])->first();
            $subject = mail_tag_replace($mail_temp_4->subject, $pointer_id);
            $message = $mail_temp_4->body;
            // new add on 04-04-2023 by vishal as par clint call
            $to =   env('DIPREET_EMAIL');
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            $mail_check_2 = 0;
            if ($check == 1) {
                $mail_check_2 = 1;
            }
            if ($mail_check == 1 && $mail_check_2 == 1) {
                $admin_status = [
                    'status' => $status,
                    'omitted_date' => date("Y-m-d H:i:s"),
                    'omitted_deadline_date' => $omitted_deadline_date,
                    'omitted_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $database_check = $this->stage_1_model->update($stage_1_id, $admin_status);

                $pointer_data = [
                    'stage' => 'stage_1',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $database_check =  $this->application_pointer_model->update($pointer_id, $pointer_data);
                delete_by_pointer_id__($pointer_id,'stage_1');
            }
        } elseif ($status == 'Omitted' && $s1_occupation->program == 'OSAP') {
            $omitted_deadline_date = $this->request->getPost('omitted_deadline_date');
            $mail_check = 0; 
            $assessors_comment = '';
            if($approval_comment){
                $assessors_comment = '<br/><br/><p dir="ltr" id="gmail-isPasted" style="box-sizing: border-box; margin-top: 0pt; margin-bottom: 0pt; line-height: 1;"><span style="font-family: sans-serif; text-align: var(--bs-body-text-align); font-size: 11pt; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space-collapse: preserve;"><b><span style="background-color: rgb(255,214,99);">ASSESSOR’S COMMENTS: "'.$approval_comment.'"</span></b></span></p>';
            }
            $client_type =  is_Agent_Applicant($pointer_id);
            // Applicant Agent
            if ($client_type == "Agent") {
                //-------------------- stage 1 Approved Agent mail OSAP -------------------
                $mail_temp_5 = $this->mail_template_model->asObject()->where(['id' => '225'])->first();
                $subject = mail_tag_replace($mail_temp_5->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_5->body, $pointer_id);
                $message = str_replace("%omitted_deadline_date%", date("d/m/Y", strtotime($omitted_deadline_date)),$message);
                $to =  $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            if ($client_type == "Applicant") {
                //-------------------- stage 1 Approved Applicants mail OSAP -------------------
                $mail_temp_5 = $this->mail_template_model->asObject()->where(['id' => '226'])->first();
                $subject = mail_tag_replace($mail_temp_5->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_5->body, $pointer_id);
                $message = str_replace("%omitted_deadline_date%", date("d/m/Y", strtotime($omitted_deadline_date)),$message);
                $to =  $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            


            // -----------------------------------------stage 1 Approved admin mail OSAP-------------------      
            $mail_check_2 = 0;
            $mail_temp_8 = $this->mail_template_model->asObject()->where(['id' => '228'])->first();
            $subject = mail_tag_replace($mail_temp_8->subject, $pointer_id);
            $message = $mail_temp_8->body;
            // new add on 04-04-2023 by vishal as par clint call
            $to =   env('DIPREET_EMAIL');
            $check_2 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            if ($check_2 == 1) {
                $mail_check_2 = 1;
            }

            if ($mail_check == 1 && $mail_check_2 == 1) {
                //database record for mail 6 
                $admin_status = [
                    'status' => $status,
                    'omitted_date' => date("Y-m-d H:i:s"),
                    'omitted_deadline_date' => $omitted_deadline_date,
                    'omitted_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $database_check = $this->stage_1_model->update($stage_1_id, $admin_status);
                $pointer_data = [
                    'stage' => 'stage_1',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $database_check =  $this->application_pointer_model->update($pointer_id, $pointer_data);
                delete_by_pointer_id__($pointer_id,'stage_1');
            }
        }
        // Omitted END
        elseif ($status == 'Declined') {




            $mail_check_2 = 0;
            // s1_declined_admin
            $mail_temp_9 = $this->mail_template_model->asObject()->where(['id' => '26'])->first();
            $subject = mail_tag_replace($mail_temp_9->subject, $pointer_id);
            $message = $mail_temp_9->body;
            // new add on 04-04-2023 by vishal as par clint call
            $to =   env('DIPREET_EMAIL');
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            
            if ($check == 1) {
                $mail_check_2 = 1;
            }
            // new add on 28-06-2023 by akanksha as per client call
            // If $unique_id is there then headoffice trigger email -> 01/02/2024
            if ($unique_id) {
                
                // if(session()->get('admin_account_type') == 'head_office'){
                $to =    env('HEADOFFICE_EMAIL');
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                // }
            }
            // as per moshin suggestion 
            // if(session()->get('admin_account_type') == 'head_office'){
            //     $to =    env('HEADOFFICE_EMAIL');
            //     $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            // }
            
            
            $mail_check = 0;
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") {
                // s1_declined_agent
                $mail_temp_10 = $this->mail_template_model->asObject()->where(['id' => '10'])->first();
                $subject = mail_tag_replace($mail_temp_10->subject, $pointer_id);

                $message = $mail_temp_10->body;
                $message = str_replace('%occupation_reason_for_decline_stage_1%', $reason, $message);
                $message = mail_tag_replace($message, $pointer_id);

                // $message = mail_tag_replace($mail_temp_10->body, $pointer_id);
                $to =  $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            if ($client_type == "Applicant") {
                // s1_declined_applicant
                $mail_temp_10 = $this->mail_template_model->asObject()->where(['id' => '57'])->first();

                $subject = mail_tag_replace($mail_temp_10->subject, $pointer_id);

                $message = $mail_temp_10->body;
                $message = str_replace('%occupation_reason_for_decline_stage_1%', $reason, $message);
                $message = mail_tag_replace($message, $pointer_id);
                $to =  $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }


            if ($mail_check_2 == 1 && $mail_check == 1) {
                //database record for mail 10       
                $admin_status = [
                    'status' => $status,
                    'declined_date' => date("Y-m-d H:i:s"),
                    'declined_reason' => $reason,
                    'declined_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $database_check = $this->stage_1_model->update($stage_1_id, $admin_status);
                $pointer_data = [
                    'stage' => 'stage_1',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $database_check =  $this->application_pointer_model->update($pointer_id, $pointer_data);
                delete_by_pointer_id__($pointer_id,'stage_1');
            }
        } elseif ($status == 'Withdrawn') {
            // s1_withdrawn_admin
            $mail_temp_11 = $this->mail_template_model->asObject()->where(['id' => '11'])->first();
            $subject = mail_tag_replace($mail_temp_11->subject, $pointer_id);
            $message = $mail_temp_11->body;
            // new add on 04-04-2023 by vishal as par clint call
            $to =   env('DIPREET_EMAIL');
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            // if ($unique_id) {
            //     $to =    env('HEADOFFICE_EMAIL');
            //     $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            // }
            // as per moshin suggestion 
            // if(session()->get('admin_account_type') == 'head_office'){
            if($unique_id){
                $to =    env('HEADOFFICE_EMAIL');
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            }
            
            $mail_check = 0;
            if ($check == 1) {
                $mail_check = 1;
            }

            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") {
                //s1_withdrawn_agent
                $mail_temp_12 = $this->mail_template_model->asObject()->where(['id' => '12'])->first();
                $subject = mail_tag_replace($mail_temp_12->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_12->body, $pointer_id);
                $to =    $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            if ($client_type == "Applicant") {
                //s1_withdrawn_applicant
                $mail_temp_12 = $this->mail_template_model->asObject()->where(['id' => '55'])->first();
                $subject = mail_tag_replace($mail_temp_12->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_12->body, $pointer_id);
                $to =    $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            if ($mail_check == 1) {
                //database record for mail 12 
                $admin_status = [
                    'status' => $status,
                    'withdraw_date' => date("Y-m-d H:i:s"),
                    'withdraw_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                if ($this->stage_1_model->update($stage_1_id, $admin_status)) {
                    $database_check = 1;
                }
                delete_by_pointer_id__($pointer_id,'stage_1');
                $pointer_data = [
                    'stage' => 'stage_1',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $this->application_pointer_model->update($pointer_id, $pointer_data);
            }
        } elseif ($status == 'Reinstate') {
            // s1_reinstate_agent
            
            $date_expiry = $this->request->getPost('date_expiry');
            
            
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") {
            // 13 -> Agent
            $mail_temp_13 = $this->mail_template_model->asObject()->where(['id' => '13'])->first();
            }
            
            
            if ($client_type == "Applicant") {
            // 214 -> Applicant
            $mail_temp_13 = $this->mail_template_model->asObject()->where(['id' => '214'])->first();
            }
            
            $subject = mail_tag_replace($mail_temp_13->subject, $pointer_id);
            $message = mail_tag_replace($mail_temp_13->body, $pointer_id);
            $message = str_replace("%Expiry_Date%", date("d/m/Y", strtotime($date_expiry)), $message);
            
            $to =   $user_mail;
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            if ($check == 1) {
                $mail_check = 1;
            }

            //database record for mail 13 
            $admin_status = [
                'status' => 'Approved',
                'update_date' => date("Y-m-d H:i:s"),
                'is_reinstated'=>1,
                 'date_reinstate'=> date("Y-m-d H:i:s"),
                 'closure_date' => $date_expiry,
            ];
            if ($this->stage_1_model->update($stage_1_id, $admin_status)) {
                $database_check = 1;
            }
            $pointer_data = [
                'stage' => 'stage_1',
                'status' => 'Approved',
                'update_date' => date("Y-m-d H:i:s")
            ];
            $database_check =   $this->application_pointer_model->update($pointer_id, $pointer_data);

            //database record for mail 13 end
            // return redirect()->back();
            // mail 13 
        }

        if ($mail_check == 1 || $database_check == 1) {
            // if ($database_check == 1) {

            $callback = array(
                "color" => "success",
                "msg" => "mail send succesfully",
                "response" => true,
                'pointer_id' => $pointer_id,
            );
        } else {
            $callback = array(
                "msg" => "mail not send",
                "color" => "danger",
                "response" => false,
                'pointer_id' => $pointer_id,
            );
        }
        // exit;
        echo json_encode($callback);
    }

    // ----------------admin Application Manager -> view/update ->stage 2 documentary evidence ---------------
    public function stage_2_change_status()
    {
        $user_id = $this->request->getPost('user_id');
        $pointer_id = $this->request->getPost('pointer_id');
        $declined_reason = $this->request->getPost('reason');
        $stage_2_id = $this->request->getPost('stage_2_id');
        $status = $this->request->getPost('status');
        
        $approval_comment = trim($this->request->getPost('approval_comment_stage_2'));
        
        
        $s1_occupation = $this->stage_1_occupation_model->asObject()->where('pointer_id', $pointer_id)->first();
        $user_account = $this->user_account_model->asObject()->where('id', $user_id)->first();
        $user_mail = $user_account->email;
        $mail_check = 0;
        $database_check = 0;

        $s1_personal_details = $this->stage_1_personal_details_model->asObject()->where('pointer_id', $pointer_id)->first();

        $date = $this->additional_info_request_model->where(['stage' => "stage_2", 'pointer_id' => $pointer_id])->find();
        $check_if_file = true;
        foreach ($date as $key => $value) {
            if ($value['status'] == "send") {
                $check_if_file = false;
            }
        }
        if ($check_if_file) {
            $this->additional_info_request_model->where(['stage' => "stage_2", 'pointer_id' => $pointer_id])->set(['status' => 'verified'])->update();
        }


        if ($status == 'Lodged') {
            // s2_lodged_head_office
            $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '19'])->first();
            $subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
            $message = $mail_temp_1->body;
            $to = env('HEADOFFICE_EMAIL');
            $mail_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            if ($mail_check == 1) {
                //database record for mail 1
                $admin_status = [
                    'status' => $status,
                    'lodged_date' =>  date("Y-m-d H:i:s"),
                    'lodged_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                if ($this->stage_2_model->update($stage_2_id, $admin_status)) {
                    $database_check = 1;
                }
                $pointer_data = [
                    'stage' => 'stage_2',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $this->application_pointer_model->update($pointer_id, $pointer_data);
                delete_by_pointer_id__($pointer_id,'stage_2');
            }
        } elseif ($status == 'In Progress') {
            /// s2_in_progress_admin
            $mail_temp_2 = $this->mail_template_model->asObject()->where(['id' => '20'])->first();
            $subject = mail_tag_replace($mail_temp_2->subject, $pointer_id);
            $message =  $mail_temp_2->body;
            // new add on 04-04-2023 by vishal as par clint call
            $to =   env('DIPREET_EMAIL');
            // $mail_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            $mail_check = 1;
            if ($mail_check == 1) {
                $admin_status = [
                    'status' => $status,
                    'in_progress_date' => date("Y-m-d H:i:s"),
                    'in_progress_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                if ($this->stage_2_model->update($stage_2_id, $admin_status)) {
                    $database_check = 1;
                }
                $pointer_data = [
                    'stage' => 'stage_2',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $this->application_pointer_model->update($pointer_id, $pointer_data);
                delete_by_pointer_id__($pointer_id,'stage_2');
            }
        } elseif ($status == 'Approved' && $s1_occupation->pathway == 'Pathway 1' && $s1_occupation->program == 'TSS') {
            $mail_check = 0;
            $mail_check_1 = 0;
            $assessors_comment = '';
            if($approval_comment){
                $assessors_comment = '<br/><br/><p dir="ltr" id="gmail-isPasted" style="box-sizing: border-box; margin-top: 0pt; margin-bottom: 0pt; line-height: 1;"><span style="font-family: sans-serif; text-align: var(--bs-body-text-align); font-size: 11pt; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space-collapse: preserve;"><b><span style="background-color: rgb(255,214,99);">ASSESSOR’S COMMENTS: "'.$approval_comment.'"</span></b></span></p>';
            }

            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") {
                // s2_approved_tss_p1_agent
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '21'])->first(); //21
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_3->body, $pointer_id);
                
                $message = str_replace("%assessors_comment%",$assessors_comment,$message);
                
                $to = $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            if ($client_type == "Applicant") {
                // s2_approved_tss_p1_applicant
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '62'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_3->body, $pointer_id);
                
                $message = str_replace("%assessors_comment%",$assessors_comment,$message);
                
                $to = $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            
            // If Comment is there then send message
            if($approval_comment){
                
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '217'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $message = str_replace("%assessors_comment%",$approval_comment,$message);
                $to = $user_mail;
                $bcc_mail = env("ADMIN_EMAIL");
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[$bcc_mail],[],[],$pointer_id);
            }
            // End



            //-------------------- stage 2 Approved -- Admin mail -- P1 -- TSS -------------------
            $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '22'])->first();
            $subject = mail_tag_replace($mail_temp_4->subject, $pointer_id);
            $message = $mail_temp_4->body;
            // new add on 04-04-2023 by vishal as par clint call
            $to =   env('DIPREET_EMAIL');
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            if ($check == 1) {
                $mail_check_1 = 1;
            }
            if ($mail_check_1 == 1 && $mail_check == 1) {
                //database record for mail 4 
                $admin_status = [
                    'status' => $status,
                    'approved_date' => date("Y-m-d H:i:s"),
                    'approved_comment' => $approval_comment,
                    'approved_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                if ($this->stage_2_model->update($stage_2_id, $admin_status)) {
                    $database_check = 1;
                }
                $pointer_data = [
                    'stage' => 'stage_2',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $this->application_pointer_model->update($pointer_id, $pointer_data);
                delete_by_pointer_id__($pointer_id,'stage_2');
            }
        } elseif ($status == 'Approved' && $s1_occupation->pathway == 'Pathway 2' && $s1_occupation->program == 'TSS') {

            $mail_check_1 = 0;
            $mail_check = 0;
            
            $assessors_comment = '';
            if($approval_comment){
                $assessors_comment = '<br/><br/><p dir="ltr" id="gmail-isPasted" style="box-sizing: border-box; margin-top: 0pt; margin-bottom: 0pt; line-height: 1;"><span style="font-family: sans-serif; text-align: var(--bs-body-text-align); font-size: 11pt; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space-collapse: preserve;"><b><span style="background-color: rgb(255,214,99);">ASSESSOR’S COMMENTS: "'.$approval_comment.'"</span></b></span></p>';
            }
            
            $client_type =  is_Agent_Applicant($pointer_id);
            // Applicant Agent
            if ($client_type == "Agent") {
                // s2_approved_tss_p2_agent 
                $mail_temp_5 = $this->mail_template_model->asObject()->where(['id' => '23'])->first();
                $subject = mail_tag_replace($mail_temp_5->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_5->body, $pointer_id);
                $message = str_replace("%assessors_comment%",$assessors_comment,$message);
                $to = $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            if ($client_type == "Applicant") {
                // s2_tss_approved_p2_applicant
                $mail_temp_5 = $this->mail_template_model->asObject()->where(['id' => '63'])->first();
                $subject = mail_tag_replace($mail_temp_5->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_5->body, $pointer_id);
                $message = str_replace("%assessors_comment%",$assessors_comment,$message);
                $to = $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }

            
            // If Comment is there then send message
            if($approval_comment){
                
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '217'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $message = str_replace("%assessors_comment%",$approval_comment,$message);
                $to = $user_mail;
                $bcc_mail = env("ADMIN_EMAIL");
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[$bcc_mail],[],[],$pointer_id);
            }
            // End

            //-------------------- stage 2 Approved -- Admin mail -- P2 -- TSS -------------------
            $mail_temp_6 = $this->mail_template_model->asObject()->where(['id' => '22'])->first();
            $subject = mail_tag_replace($mail_temp_6->subject, $pointer_id);
            $message = $mail_temp_6->body;
            // new add on 04-04-2023 by vishal as par clint call
            $to =   env('DIPREET_EMAIL');
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            if ($check == 1) {
                $mail_check_1 = 1;
            }


            if ($mail_check == 1 && $mail_check_1) {
                $admin_status = [
                    'status' => $status,
                    'approved_date' => date("Y-m-d H:i:s"),
                    'approved_comment' => $approval_comment,
                    'approved_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                if ($this->stage_2_model->update($stage_2_id, $admin_status)) {
                    $database_check = 1;
                }
                $pointer_data = [
                    'stage' => 'stage_2',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $this->application_pointer_model->update($pointer_id, $pointer_data);
                delete_by_pointer_id__($pointer_id,'stage_2');
            }
        } elseif ($status == 'Approved' && $s1_occupation->pathway == 'Pathway 1' && $s1_occupation->program == 'OSAP') {

            $mail_check_1 = 0;
            $mail_check = 0;
            $assessors_comment = '';
            if($approval_comment){
                $assessors_comment = '<br/><br/><p dir="ltr" id="gmail-isPasted" style="box-sizing: border-box; margin-top: 0pt; margin-bottom: 0pt; line-height: 1;"><span style="font-family: sans-serif; text-align: var(--bs-body-text-align); font-size: 11pt; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space-collapse: preserve;"><b><span style="background-color: rgb(255,214,99);">ASSESSOR’S COMMENTS: "'.$approval_comment.'"</span></b></span></p>';
            }
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") {
                // s2_approved_osap_p1_agent
                $mail_temp_7 = $this->mail_template_model->asObject()->where(['id' => '25'])->first();
                $subject = mail_tag_replace($mail_temp_7->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_7->body, $pointer_id);
                $message = str_replace("%assessors_comment%",$assessors_comment,$message);
                $to =  $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            if ($client_type == "Applicant") {
                // s2_osap_approved_p1_applicant
                $mail_temp_7 = $this->mail_template_model->asObject()->where(['id' => '65'])->first();
                $subject = mail_tag_replace($mail_temp_7->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_7->body, $pointer_id);
                $message = str_replace("%assessors_comment%",$assessors_comment,$message);
                $to =  $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            
            // If Comment is there then send message
            if($approval_comment){
                
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '217'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $message = str_replace("%assessors_comment%",$approval_comment,$message);
                $to = $user_mail;
                $bcc_mail = env("ADMIN_EMAIL");
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[$bcc_mail],[],[],$pointer_id);
            }
            // End

            //-------------------- stage 2 Approved -- Admin mail -- P1 -- OSAP -------------------
            $mail_temp_8 = $this->mail_template_model->asObject()->where(['id' => '22'])->first();
            $subject = mail_tag_replace($mail_temp_8->subject, $pointer_id);
            $message = $mail_temp_8->body;
            // new add on 04-04-2023 by vishal as par clint call
            $to =   env('DIPREET_EMAIL');
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            if ($check == 1) {
                $mail_check_1 = 1;
            }


            if ($mail_check == 1 && $mail_check_1 == 1) {
                $admin_status = [
                    'status' => $status,
                    'approved_date' => date("Y-m-d H:i:s"),
                    'approved_comment' => $approval_comment,
                    'approved_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                if ($this->stage_2_model->update($stage_2_id, $admin_status)) {
                    $database_check = 1;
                }
                $pointer_data = [
                    'stage' => 'stage_2',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $this->application_pointer_model->update($pointer_id, $pointer_data);
                delete_by_pointer_id__($pointer_id,'stage_2');
            }
        } elseif ($status == 'Approved' && $s1_occupation->pathway == 'Pathway 2' && $s1_occupation->program == 'OSAP') {
            $mail_check_1 = 0;
            $mail_check = 0;
            $assessors_comment = '';
            if($approval_comment){
                $assessors_comment = '<br/><br/><p dir="ltr" id="gmail-isPasted" style="box-sizing: border-box; margin-top: 0pt; margin-bottom: 0pt; line-height: 1;"><span style="font-family: sans-serif; text-align: var(--bs-body-text-align); font-size: 11pt; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space-collapse: preserve;"><b><span style="background-color: rgb(255,214,99);">ASSESSOR’S COMMENTS: "'.$approval_comment.'"</span></b></span></p>';
            }
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") {
                // s2_approved_osap_p2_agent
                $mail_temp_9 = $this->mail_template_model->asObject()->where(['id' => '27'])->first();
                $subject = mail_tag_replace($mail_temp_9->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_9->body, $pointer_id);
                $message = str_replace("%assessors_comment%",$assessors_comment,$message);
                $to =  $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            if ($client_type == "Applicant") {
                // s2_osap_approved_p2_applicant
                $mail_temp_9 = $this->mail_template_model->asObject()->where(['id' => '64'])->first();
                $subject = mail_tag_replace($mail_temp_9->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_9->body, $pointer_id);
                $message = str_replace("%assessors_comment%",$assessors_comment,$message);
                $to =  $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            
            
            // If Comment is there then send message
            if($approval_comment){
                
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '217'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $message = str_replace("%assessors_comment%",$approval_comment,$message);
                $to = $user_mail;
                $bcc_mail = env("ADMIN_EMAIL");
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[$bcc_mail],[],[],$pointer_id);
            }
            // End
            
            // s2_approved_admin
            $mail_temp_10 = $this->mail_template_model->asObject()->where(['id' => '22'])->first();
            $subject = mail_tag_replace($mail_temp_10->subject, $pointer_id);
            $message = $mail_temp_10->body;
            // new add on 04-04-2023 by vishal as par clint call
            $to =   env('DIPREET_EMAIL');
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            if ($check == 1) {
                $mail_check_1 = 1;
            }


            if ($mail_check == 1 && $mail_check_1 == 1) {
                $admin_status = [
                    'status' => $status,
                    'approved_date' => date("Y-m-d H:i:s"),
                    'approved_comment' => $approval_comment,
                    'approved_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                if ($this->stage_2_model->update($stage_2_id, $admin_status)) {
                    $database_check = 1;
                }
                $pointer_data = [
                    'stage' => 'stage_2',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $this->application_pointer_model->update($pointer_id, $pointer_data);
                delete_by_pointer_id__($pointer_id,'stage_2');
            }
          } elseif ($status == 'Declined') {
            //-------------------- upload Documnets ---------------------

            $middle_name__ = "";
            if($s1_personal_details->middle_names){
                $middle_name__ = " ".$s1_personal_details->middle_names;
            }

           $name = $s1_personal_details->first_or_given_name.$middle_name__." ".$s1_personal_details->surname_family_name;             
            $target_file =  'public/application/' . $pointer_id . '/stage_2/declined';

            //-------------------- Statement of Reasons	Documnets ---------------------

            $reason_file = $this->request->getFile('reason_file');

            $reason_file_basename = $reason_file->getName();
            
            if($reason_file->getName()){
                
            $reason_file_extension = explode(".", $reason_file_basename);

            $reason_file_type = $reason_file_extension[count($reason_file_extension) - 1];

            $reason_file_name = 'Statement of Reasons - ' . $name . "." . $reason_file_type;

            $reason_file->move($target_file, $reason_file_name);

            // file path need to send with email for applicant and agent

            $reason_path = $target_file . '/' . $reason_file_name;

            $reason_data = array(

                'pointer_id' => $pointer_id,

                'stage' => 'stage_2',

                'required_document_id' => 52,

                'name' => 'Statement of Reasons',

                'document_name' => $reason_file_name,

                'document_path' => $target_file,

                'status' => 1,

                'update_date' => date("Y-m-d H:i:s"),

                'create_date' => date("Y-m-d H:i:s")

            );
            
            
                $this->documents_model->where([
                    "pointer_id" => $pointer_id, 
                    "stage" => "stage_2", 
                    'required_document_id' => 52
                    ])->delete();



            $this->documents_model->insert($reason_data);
            }else{
                $resone_file = find_one_row_3_field('documents','stage','stage_2','pointer_id',$pointer_id,'required_document_id',52);
            
                $reason_path = $resone_file->document_path."/".$resone_file->document_name;
                $reason_file_name = $resone_file->name;
        
            }
            //-------------------- Outcome Letter Documnets ---------------------

            $outcome_file = $this->request->getFile('outcome_file');

            $outcome_file_basename = $outcome_file->getName();

            if($outcome_file->getName()){
                
            $outcome_file_extension = explode(".", $outcome_file_basename);

            $outcome_file_type = $outcome_file_extension[count($outcome_file_extension) - 1];

            $outcome_file_name = 'Skills Assessment Result - '.$name.'.'. $outcome_file_type;

            $outcome_file->move($target_file, $outcome_file_name);

            // file path need to send with email for applicant and agent

            $outcome_path = $target_file . '/' . $outcome_file_name;

            $outcome_data = array(

                'pointer_id' => $pointer_id,

                'stage' => 'stage_2',

                'required_document_id' => 51,

                'name' => 'Skills Assessment Result',

                'document_name' => $outcome_file_name,

                'document_path' => $target_file,

                'status' => 1,

                'update_date' => date("Y-m-d H:i:s"),

                'create_date' => date("Y-m-d H:i:s")

            );

            
                $this->documents_model->where([
                    "pointer_id" => $pointer_id, 
                    "stage" => "stage_2", 
                    'required_document_id' => 51
                    ])->delete();

            $this->documents_model->insert($outcome_data);
            
            }else{
                $outcome_letter = find_one_row_3_field('documents','stage','stage_2','pointer_id',$pointer_id,'required_document_id',51);
            
                $outcome_path = $outcome_letter->document_path."/".$outcome_letter->document_name;
                $outcome_file_name = $outcome_letter->name;
            }

            //-------------------- upload Documnets end ---------------------        
                $addAttachment = array(

                    [

                        'file_path' => $outcome_path,

                        'file_name' => $outcome_file_name

                    ], [

                        'file_path' => $reason_path,

                        'file_name' => $reason_file_name

                    ]

                );


            $mail_check_1 = 0;
            $mail_check = 0;
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") { // Applicant
                // s2_declined_agent
                $mail_temp_11 = $this->mail_template_model->asObject()->where(['id' => '30'])->first();
                $subject = mail_tag_replace($mail_temp_11->subject, $pointer_id);

                $message = $mail_temp_11->body;
                $message = str_replace('%occupation_reason_for_decline_stage_2%', $declined_reason, $message);
                $message = mail_tag_replace($message, $pointer_id);

                // $message = mail_tag_replace($mail_temp_11->body, $pointer_id);
                $to =  $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            if ($client_type == "Applicant") {
                // s2_declined_applicant
                $mail_temp_11 = $this->mail_template_model->asObject()->where(['id' => '69'])->first();
                $subject = mail_tag_replace($mail_temp_11->subject, $pointer_id);
                $message = $mail_temp_11->body;
                $message = str_replace('%occupation_reason_for_decline_stage_2%', $declined_reason, $message);
                $message = mail_tag_replace($message, $pointer_id);

                $to =  $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[], [], [], $addAttachment);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
             
            //s2_declined_admin
            $mail_temp_12 = $this->mail_template_model->asObject()->where(['id' => '29'])->first();
            $subject = mail_tag_replace($mail_temp_12->subject, $pointer_id);
            $message = $mail_temp_12->body;
            // new add on 04-04-2023 by vishal as par clint call
            $to =   env('DIPREET_EMAIL');
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            if ($check == 1) {
                $mail_check_1 = 1;
            }




            if ($mail_check_1 == 1 && $mail_check == 1) {
                $admin_status = [
                    'status' => $status,
                    'declined_date' => date("Y-m-d H:i:s"),
                    'declined_reason' => $declined_reason,
                    'declined_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                if ($this->stage_2_model->update($stage_2_id, $admin_status)) {
                    $database_check = 1;
                }
                delete_by_pointer_id__($pointer_id,'stage_2');
                $pointer_data = [
                    'stage' => 'stage_2',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $this->application_pointer_model->update($pointer_id, $pointer_data);
            }
        } elseif ($status == 'Withdrawn') {
            $mail_check = 0;
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") {
                // s2_withdrawn_agent
                $mail_temp_13 = $this->mail_template_model->asObject()->where(['id' => '32'])->first();
                $subject = mail_tag_replace($mail_temp_13->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_13->body, $pointer_id);
                $to =  $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            if ($client_type == "Applicant") {
                // s2_withdrawn_applicant
                $mail_temp_13 = $this->mail_template_model->asObject()->where(['id' => '67'])->first();
                $subject = mail_tag_replace($mail_temp_13->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_13->body, $pointer_id);
                $to =  $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }

            // s2_withdrawn_admin
            $mail_temp_14 = $this->mail_template_model->asObject()->where(['id' => '31'])->first();
            $subject = mail_tag_replace($mail_temp_14->subject, $pointer_id);
            $message = $mail_temp_14->body;
            // new add on 04-04-2023 by vishal as par clint call
            $to =   env('DIPREET_EMAIL');
            $check_1 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            $to =    env('HEADOFFICE_EMAIL');
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            $mail_check_1 = 0;
            if ($check == 1 && $check_1 == 1) {
                $mail_check_1 = 1;
            }

            if ($mail_check_1 == 1 && $mail_check == 1) {
                $admin_status = [
                    'status' => $status,
                    'withdraw_date' => date("Y-m-d H:i:s"),
                    'withdraw_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                if ($this->stage_2_model->update($stage_2_id, $admin_status)) {
                    $database_check = 1;
                }
                $pointer_data = [
                    'stage' => 'stage_2',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $this->application_pointer_model->update($pointer_id, $pointer_data);
                delete_by_pointer_id__($pointer_id,'stage_2');
            }
        } elseif ($status == 'Reinstate') {
            // new add on 04-04-2023 by vishal as par clint call
            // client say stage 1 have only Reinstate  Not for stage 2 and stage 3


            // $client_type =  is_Agent_Applicant($pointer_id);
            // if ($client_type == "Agent") {
            //     // s2_reinstated_submission_agent
            //     $mail_temp_15 = $this->mail_template_model->asObject()->where(['id' => '80'])->first();
            //     $mail_temp_15 = $this->mail_template_model->asObject()->where()->first();
            //     $subject = mail_tag_replace($mail_temp_15->subject, $pointer_id);
            //     $message = mail_tag_replace($mail_temp_15->body, $pointer_id);
            //     $to =    $user_mail;
            //     $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
            //     if ($check == 1) {
            //         $mail_check = 1;
            //     }
            // }


            //database record for mail 15 
            $admin_status = [
                'update_date' => date("Y-m-d H:i:s")
            ];
            if ($this->stage_2_model->update($stage_2_id, $admin_status)) {
                $database_check = 1;
            }
        }elseif($status == 'Closed'){
                    $stage_1_approve=$this->stage_2_model->asObject()->where('pointer_id', $pointer_id)->first();
                    $approval_date=date("d-m-Y", strtotime($stage_1_approve->approved_date) );
                $mail_check= " ";
              $client_type =  is_Agent_Applicant($pointer_id);
            // Applicant Agent
            if ($client_type == "Agent") {
                $mail_temp_5 = $this->mail_template_model->asObject()->where(['id' => '211'])->first();
                $subject = mail_tag_replace($mail_temp_5->subject, $pointer_id);
                 $approval_msg = mail_tag_replace($mail_temp_5->body, $pointer_id);
                 $message =  str_replace('%approval_date%', $approval_date, $approval_msg);
                $to = $user_mail;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
            if ($client_type == "Applicant") {
                $mail_temp_5 = $this->mail_template_model->asObject()->where(['id' => '212'])->first();
                $subject = mail_tag_replace($mail_temp_5->subject, $pointer_id);
                 $approval_msg = mail_tag_replace($mail_temp_5->body, $pointer_id);
                 $message =  str_replace('%approval_date%', $approval_date, $approval_msg);
                 $to = $user_mail;
                 $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }
              //$mail_check = 1;
              
              //skill teams mail
              $mail_temp_5 = $this->mail_template_model->asObject()->where(['id' => '213'])->first();
              $subject = mail_tag_replace($mail_temp_5->subject, $pointer_id);
              $message = mail_tag_replace($mail_temp_5->body, $pointer_id);
                 $to =env('ADMIN_EMAIL');
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
                // echo $mail_check;
                // die;
            if ($mail_check == 1) {
                $admin_status = [
                    'status' => $status,
                    'closed_date' => date("Y-m-d H:i:s"),
                    'closed_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                if ($this->stage_2_model->update($stage_2_id, $admin_status)) {
                    $database_check = 1;
                }
                $pointer_data = [
                    'stage' => 'stage_2',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $this->application_pointer_model->update($pointer_id, $pointer_data);
               // delete_by_pointer_id__($pointer_id,'stage_2');
                //echo "status changes success";
            }
        }

        if ($database_check == 1) {
            $callback = array(
                "color" => "success",
                "msg" => "mail send succesfully",
                "response" => true,
                'pointer_id' => $pointer_id,
            );
        } else {
            $callback = array(
                "msg" => "mail not send",
                "color" => "danger",
                "response" => false,
                'pointer_id' => $pointer_id,
            );
        }
        echo json_encode($callback);
    }

    // ----------------admin Application Manager -> view/update ->stage 3 technical interview ---------------
    
    public function stage_3_change_status()

    {
    // echo "hey";
    // exit;
    
    // print_r($_POST);
    // exit;

        $user_id = $this->request->getPost('user_id');
        
        $pointer_id = $this->request->getPost('pointer_id');

        $reason = $this->request->getPost('reason');

        $stage_3_id = $this->request->getPost('stage_3_id');

        $status = $this->request->getPost('status');
        
        $preference_location = $this->request->getPost('preference_location');
        
        $time_zone = $this->request->getPost('time_zone');
        $approval_comment = trim($this->request->getPost('approval_comment_stage_3'));
        
        
        // print_r($_POST);
        // die;
        
        if (empty($status)) {

            $callback = array(

                "msg" => "Select Status First.",

                "color" => "danger",

                "response" => false,

                'pointer_id' => $pointer_id,

            );

            echo json_encode($callback);

            exit;
        }
        
        // print_r($time_zone);
        // exitl
        
        // if(empty($time_zone)){
            
        //     $callback = array(

        //         "msg" => "Select Timezone.",

        //         "color" => "danger",

        //         "response" => false,

        //         'pointer_id' => $pointer_id,

        //     );

        //     echo json_encode($callback);

        //     exit;
        // }
        
        
        


        $comment = "";
        // echo "heye";

        if (isset($_POST['comment'])) {
            // echo "theere";

            $comment = trim($_POST['comment']);

            $comment = trim($comment, "\xC2\xA0");

            $comment = str_replace("&nbsp;", '', $comment);

        }

        
            $comment_update = $this->stage_3_model->where(['pointer_id' => $pointer_id])->set(['preference_comment' => $comment])->update();
            $stage_3_model__data = $this->stage_3_model->where(['pointer_id' => $pointer_id])->asObject()->first();
            // print_r($comment_update);
            // exit;
            // AISH -> Update
            if(isset($_POST['preference_location'])){
                $preference_location = $_POST['preference_location'];    
            }
            else{
                $preference_location = $stage_3_model__data->preference_location;
            }
            
            
            // Exit
            $update_location = $this->stage_3_model->where(['pointer_id' => $pointer_id])->set(['preference_location' => $preference_location])->update();
            if ($update_location) {
                if ($preference_location == "Online (Via Zoom)") {
                    if (isset($_POST['time_zone'])) {
                        $time_zone = $_POST['time_zone'];
                        $update_zone = $this->stage_3_model->where(['pointer_id' => $pointer_id])->set(['time_zone' => $time_zone])->update();
                    }
                }
            }
            
            // 
    // exit;

        $s1_occupation = $this->stage_1_occupation_model->asObject()->where('pointer_id', $pointer_id)->first();

        $s1_personal_details = $this->stage_1_personal_details_model->asObject()->where('pointer_id', $pointer_id)->first();

        $user_account = $this->user_account_model->asObject()->where('id', $user_id)->first();

        $user_mail = $user_account->email;

        $mail_check = 0;

        $database_check = 0;





        $date = $this->additional_info_request_model->where(['stage' => "stage_3", 'pointer_id' => $pointer_id])->find();

        $check_if_file = true;
        
        

        foreach ($date as $key => $value) {

            if ($value['status'] == "send") {

                $check_if_file = false;
            }
        }
        
        

        if ($check_if_file) {

            $this->additional_info_request_model->where(['stage' => "stage_3", 'pointer_id' => $pointer_id])->set(['status' => 'verified'])->update();
        }




            $name = $s1_personal_details->first_or_given_name;
            // echo 

        
            // Get the Occupation
            $enroll_stage_4 = false;
            $occupation = $this->stage_1_occupation_model->where("pointer_id", $pointer_id)->asObject()->first();
            if($occupation->pathway == "Pathway 1"){
                if($occupation->occupation_id == 7 || $occupation->occupation_id == 18){
                    $enroll_stage_4 = true;
                }
            }
            // end

        if ($status == 'Lodged') {


           $stage_3_online_ = find_one_row('stage_3', 'pointer_id', $pointer_id);
           $stage_1_usi_avetmiss=find_one_row('stage_1_usi_avetmiss','pointer_id',$pointer_id);
           
           
            //  //if any extra docswith tra_receipt
             $comment_store_documents=$this->documents_model->where(['pointer_id' => $pointer_id, "stage" => "stage_3",  "required_document_id" => "0", "employee_id" => "0"])->findAll();
             
             
             $comment_store_documents = $this->documents_model
                ->where([
                    'pointer_id' => $pointer_id,
                    'stage' => 'stage_3',
                    'employee_id' => '0' // Assuming employee_id is integer type
                ])
                ->groupStart()
                    ->where('required_document_id', 0)
                    ->orWhere('required_document_id', 29)
                ->groupEnd()
                ->findAll();
             
             
            //  print_r($comment_store_documents);
            //  die;
            $addAttachment=[];
             
           
           
          
            // s3_lodged_head_office
           
           
            if ($preference_location == "Online (Via Zoom)") {
                
                // This is for OnShore Application 
                if($stage_1_usi_avetmiss->currently_have_usi=='yes' && $preference_location == "Online (Via Zoom)"){
                if($comment_store_documents){
                     $mail_temp_1 =  $this->mail_template_model->asObject()->where(['id' => '220'])->first();
                }else{
                $client_type =  is_Agent_Applicant($pointer_id);

                if ($client_type == "Agent") {
                
                   $mail_temp_1 =  $this->mail_template_model->asObject()->where(['id' => '28'])->first();
                }
                else{
                   $mail_temp_1 =  $this->mail_template_model->asObject()->where(['id' => '165'])->first(); 
                }
                
                }
                }
                else{
                
                    if($enroll_stage_4 == true){
                        if($comment_store_documents){
                             $mail_temp_1 =  $this->mail_template_model->asObject()->where(['id' => '218'])->first();
                        }else{
                            $mail_temp_1 =  $this->mail_template_model->asObject()->where(['id' => '137'])->first();
                        }
                    }
                    else{
                       if($comment_store_documents){
                            $mail_temp_1 =  $this->mail_template_model->asObject()->where(['id' => '219'])->first(); 
                        }else{
                            $mail_temp_1 =  $this->mail_template_model->asObject()->where(['id' => '116'])->first(); 
                        }
                               
                    }
                }
            
                
            }
            else{
             if($comment_store_documents){
             $mail_temp_1 =  $this->mail_template_model->asObject()->where(['id' => '218'])->first();
             }else{
            $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '117'])->first();
            }
            }

// print_r($mail_temp_1);
// die;

            $stage_3_ = $this->stage_3_model->where(['pointer_id' => $pointer_id])->first();
            
            $preference_location_comment = "";
            if (!empty($stage_3_)) {
                $preference_location = trim($stage_3_['preference_location']);
                $preference_comment = trim($stage_3_['preference_comment']);
             
                // $preference_comment = trim($preference_comment, "\xC2\xA0");
                $time_zone = trim($stage_3_['time_zone']);
                // $preference_comment = str_replace("&nbsp;", '', $preference_comment);
                if (!empty($preference_location)) {
                    $preference_location_comment .= "<br><br><span style='background-color: rgb(255, 255, 0);'><b>Applicant's Preferred Venue: " . $preference_location."</b><span>";
                }
                
                if ($preference_location == "Online (Via Zoom)") {
                    
                    $preference_location_comment .= "<br><br><span style='background-color: rgb(255, 255, 0);'><b>Time Zone: " . $time_zone."</b><span><br><br>";
                }
                else{
                    $preference_location_comment .= "<br><br>";
                }
            //     print_r($preference_comment);
            // exit;
                if (!empty($preference_comment)) {
                    $preference_location_comment .= "<span style='background-color: rgb(255, 255, 0);'><b>Comments: <br> &ldquo;" . $preference_comment . "&rdquo;</b><span><br><br>";
                }
                   
        // print_r($preference_location_comment);
        // exit;
            }

            $to = env('HEADOFFICE_EMAIL');
            $subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
            $message = $mail_temp_1->body;
            $message = str_replace('%data%', $preference_location_comment, $message);
            
            // IF
            //$addAttachment = [];
            if ($preference_location == "Online (Via Zoom)") {
            if($stage_1_usi_avetmiss->currently_have_usi=='yes' && $preference_location == "Online (Via Zoom)"){
                $applicant_agent='public/application/' . $pointer_id .'/stage_3/'.'/'.$stage_3_online_->exemption_form;
             $stage_3_Docs_ = $this->documents_model->where(['pointer_id' => $pointer_id, 'required_document_id' => 55, 'stage' => "stage_3"])->first();
                $addAttachment = [];
                 $addAttachment_applicant = array(
    
                    [
    
                        'file_path' => $stage_3_Docs_['document_path'] . '/' . $stage_3_Docs_['document_name'],
                        'file_name' => $stage_3_Docs_['document_name'],
    
                    ]
                    );
                  array_push($addAttachment, ...$addAttachment_applicant);
            }
            else{ 
                if($enroll_stage_4 == false){
                    $stage_3_online = find_one_row('stage_3', 'pointer_id', $pointer_id);
                    $exemption_form_name=$stage_3_online->exemption_form;
                    
                    if (empty($exemption_form_name)) {
    
                        $callback = array(
            
                            "msg" => "Please select exemption form.",
            
                            "color" => "danger",
            
                            "response" => false,
            
                            'pointer_id' => $pointer_id,
            
                        );
            
                        echo json_encode($callback);
            
                        exit;
                    }
                    
                    
                    $exemption_form_path='public/application/' . $pointer_id .'/stage_3/assessment_documents'.'/'.$stage_3_online->exemption_form;
                    $stage_3_Docs = $this->documents_model->where(['pointer_id' => $pointer_id, 'required_document_id' => 43, 'stage' => "stage_3"])->first();
                            
                            
                     $addAttachment__ = array(
        
                        [
        
                            'file_path' => $stage_3_Docs['document_path'] . '/' . $stage_3_Docs['document_name'],
                            'file_name' => $stage_3_Docs['document_name'],
        
                        ]
                        );
                        array_push($addAttachment, ...$addAttachment__);
                }
                }
                
            }
            
            // END
            
            // TRA FORM
            $stage_3_Docs = $this->documents_model->where(['pointer_id' => $pointer_id, 'required_document_id' => 19, 'stage' => "stage_3"])->first();
            if(!empty($stage_3_Docs)){
                 $addAttachment__ = array(
                [
                    'file_path' => $stage_3_Docs['document_path'] . '/' . $stage_3_Docs['document_name'],
                    'file_name' => $stage_3_Docs['document_name'],
                ]
            );
            }else{
                $addAttachment__=array();
            }
           
            array_push($addAttachment, ...$addAttachment__);
            
            $docs_ids[]="";
            $addAttachment_with_tra[]="";
            
            foreach ($comment_store_documents as $comment_store_documents_) {
                $docs_ids[]=$comment_store_documents_['id'];
                $documents = $this->documents_model->where(['id' => $comment_store_documents_['id'], 'stage' => "stage_3"])->first();
               
                if(!empty($documents)){
                $addAttachment_with_tra = array(
                [
                    'file_path' => $documents['document_path'] . '/' . $documents['document_name'],
                    'file_name' => $documents['document_name'],
                ]
                     );
                 array_push($addAttachment, ...$addAttachment_with_tra);
                
                    }
            }
            
        //     print_r($addAttachment);
        //     exit;
            // function send_email($setFrom, $setFrom_name, $addAddress, $Subject, $Body, $addReplyTo_array = [], $addBCC_array = [], $addCC_array = [], $addAttachment_array = [])

            $mail_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                // print_r($message);
                // die;
            if ($mail_check == 1) {
                $admin_status = [
                    'status' => $status,
                    'lodged_date' =>  date("Y-m-d H:i:s"),
                    'lodged_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                if ($this->stage_3_model->update($stage_3_id, $admin_status)) {
                    $database_check = 1;
                }
                $pointer_data = [
                    'stage' => 'stage_3',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $this->application_pointer_model->update($pointer_id, $pointer_data);
                delete_by_pointer_id__($pointer_id,'stage_3');
            }
        } elseif ($status == 'Conducted') {

            $admin_status = [

                'status' => $status,

                'conducted_date' => date("Y-m-d H:i:s"),

                'conducted_by' => session()->get('admin_id'),

                'update_date' => date("Y-m-d H:i:s")

            ];

            if ($this->stage_3_model->update($stage_3_id, $admin_status)) {

                $database_check = 1;
            }
          delete_by_pointer_id__($pointer_id,'stage_2');
            $pointer_data = [

                'stage' => 'stage_3',

                'status' => $status,

                'update_date' => date("Y-m-d H:i:s")

            ];

            $this->application_pointer_model->update($pointer_id, $pointer_data);
        } elseif ($status == 'Approved') {



            //-------------------- upload Documnets ---------------------


            $target_file =  'public/application/' . $pointer_id . '/stage_3/approved';

            //-------------------- Qualifications Documnets ---------------------

            if ($s1_occupation->pathway == 'Pathway 1') {
                $upload_qualification_file="";
                $upload_outcome_path="";
                $qualification_file_path="";
                $upload_qualification_file = $this->request->getFile('upload_qualification_file');

                $qualification_file_basename = $upload_qualification_file->getName();

                $qualification_file_extension = explode(".", $qualification_file_basename);

                $qualification_file_type = $qualification_file_extension[count($qualification_file_extension) - 1];

                $qualification_file_name = 'Qualification Documents - '.$name.'.'. $qualification_file_type;
                
            if($upload_qualification_file !=""){
                 $upload_qualification_file->move($target_file, $qualification_file_name);

                // file path need to send with email for applicant and agent

                $qualification_file_path = $target_file . '/' . $qualification_file_name;

                $qualification_data = array(

                    'pointer_id' => $pointer_id,

                    'stage' => 'stage_3',

                    'required_document_id' => 26,

                    'name' => 'Qualification Documents',

                    'document_name' => $qualification_file_name,

                    'document_path' => $target_file,

                    'status' => 1,

                    'update_date' => date("Y-m-d H:i:s"),

                    'create_date' => date("Y-m-d H:i:s")

                );



                $this->documents_model->insert($qualification_data);

                
            }
                           }

            //-------------------- Qualifications Documnets end---------------------

            //-------------------- Outcome Letter Documnets ---------------------
            $upload_outcome_file="";
            $upload_outcome_path="";
            $addAttachment=array();
            $upload_outcome_file = $this->request->getFile('upload_outcome_file');

            $outcome_file_basename = $upload_outcome_file->getName();

            $outcome_file_extension = explode(".", $outcome_file_basename);

            $outcome_file_type = $outcome_file_extension[count($outcome_file_extension) - 1];

            $outcome_file_name = 'Skills Assessment Result - ' . $name . "." . $outcome_file_type;


            // file path need to send with email for applicant and agent
        if($upload_outcome_file !=""){
                        $upload_outcome_file->move($target_file, $outcome_file_name);

      $upload_outcome_path = $target_file . '/' . $outcome_file_name;

            $outcome_data = array(

                'pointer_id' => $pointer_id,

                'stage' => 'stage_3',

                'required_document_id' => 25,

                'name' => 'Skills Assessment Result',

                'document_name' => $outcome_file_name,

                'document_path' => $target_file,

                'status' => 1,

                'update_date' => date("Y-m-d H:i:s"),

                'create_date' => date("Y-m-d H:i:s")

            );

            $this->documents_model->insert($outcome_data);

          
}
            //-------------------- Outcome Letter Documnets end ---------------------

            //-------------------- upload Documnets end ---------------------        



            $mail_check = 0;

            if ($s1_occupation->pathway == 'Pathway 1') {
                $occupation_id = $s1_occupation->occupation_id;
                if($occupation_id == 7 || $occupation_id == 18){ 
                    
                    $mail_check=1;
                    
               $assessors_comment = '';
             if($approval_comment){
                $assessors_comment = '<br/><br/><p dir="ltr" id="gmail-isPasted" style="box-sizing: border-box; margin-top: 0pt; margin-bottom: 0pt; line-height: 1;"><span style="font-family: sans-serif; text-align: var(--bs-body-text-align); font-size: 11pt; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space-collapse: preserve;"><b><span style="background-color: rgb(255,214,99);">ASSESSOR’S COMMENTS: "'.$approval_comment.'"</span></b></span></p>';
              }
                    
                   
                   // If Comment is there then send message
            if($approval_comment){
                
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '217'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $message = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $message = str_replace("%assessors_comment%",$approval_comment,$message);
                $to = $user_mail;
                $bcc_mail = env("ADMIN_EMAIL");
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[$bcc_mail],[],[],$pointer_id);
                
                if($check == 1){
                    
                $admin_status_ = ['approved_comment' => $approval_comment];
                $database_check_ =  $this->stage_3_model->update($stage_3_id, $admin_status_);                
                }
                
            }
            // End
            
            
            
            
                      $client_type =  is_Agent_Applicant($pointer_id);

                if ($client_type == "Agent") { // Applicant

                    // s3_agent_p1_approved
                    if($s1_occupation->program == "OSAP"){
                     $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '136'])->first();   
                    }
                    else{
                        $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '135'])->first();   
                    }

                    $subject = mail_tag_replace($mail_temp_4->subject, $pointer_id);

                    $message = mail_tag_replace($mail_temp_4->body, $pointer_id);
                    
                    $message = str_replace("%assessors_comment%",$assessors_comment,$message);
                    
                if($upload_outcome_path !=""){
                    $addAttachment = array(

                        [

                            'file_path' => $upload_outcome_path,

                            'file_name' => $outcome_file_name

                        ]
                        );

                }else{
                    $addAttachment=array();
                }
                    
                

                    if ($s1_occupation->pathway == 'Pathway 1') {
                        if($qualification_file_path !=""){
                                                    array_push($addAttachment, array('file_path' => $qualification_file_path, 'file_name' => $qualification_file_name));

                        }

                    }

                    $to =  $user_mail;

                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                    if ($check == 1) {

                        $mail_check = 1;
                    }
                }

                if ($client_type == "Applicant") {

                    // s3_applicant_p1_approved
                    if($s1_occupation->program == "OSAP"){
                     $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '140'])->first();
                    }
                    else{
                        $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '141'])->first();   
                    }

                    

                    $subject = mail_tag_replace($mail_temp_4->subject, $pointer_id);

                    $message = mail_tag_replace($mail_temp_4->body, $pointer_id);
                    $message = str_replace("%assessors_comment%",$assessors_comment,$message);
                    if($upload_outcome_path !=""){

                    $addAttachment = array(

                        [

                            'file_path' => $upload_outcome_path,

                            'file_name' => $outcome_file_name

                        ]

                    );
                        
                    }
                    

                    if ($s1_occupation->pathway == 'Pathway 1') {
                        if($qualification_file_path !=""){
                                                    array_push($addAttachment, array('file_path' => $qualification_file_path, 'file_name' => $qualification_file_name));

                        }

                    }

                    $to =  $user_mail;

                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                    if ($check == 1) {

                        $mail_check = 1;
                    }
                
                }
            
                }else{

                $client_type =  is_Agent_Applicant($pointer_id);

                if ($client_type == "Agent") { // Applicant

                    // s3_agent_p1_approved

                    $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '94'])->first();

                    $subject = mail_tag_replace($mail_temp_4->subject, $pointer_id);

                    $message = mail_tag_replace($mail_temp_4->body, $pointer_id);

                    $addAttachment = array(

                        [

                            'file_path' => $upload_outcome_path,

                            'file_name' => $outcome_file_name

                        ]

                    );

                    if ($s1_occupation->pathway == 'Pathway 1') {

                        array_push($addAttachment, array('file_path' => $qualification_file_path, 'file_name' => $qualification_file_name));
                    }

                    $to =  $user_mail;

                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                    if ($check == 1) {

                        $mail_check = 1;
                    }
                }

                if ($client_type == "Applicant") {

                    // s3_applicant_p1_approved

                    $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '37'])->first();

                    $subject = mail_tag_replace($mail_temp_4->subject, $pointer_id);

                    $message = mail_tag_replace($mail_temp_4->body, $pointer_id);

                    $addAttachment = array(

                        [

                            'file_path' => $upload_outcome_path,

                            'file_name' => $outcome_file_name

                        ]

                    );

                    if ($s1_occupation->pathway == 'Pathway 1') {

                        array_push($addAttachment, array('file_path' => $qualification_file_path, 'file_name' => $qualification_file_name));
                    }

                    $to =  $user_mail;

                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                    if ($check == 1) {

                        $mail_check = 1;
                    }
                }
                }
            } else {

                $client_type =  is_Agent_Applicant($pointer_id);

                if ($client_type == "Agent") { // Applicant

                    // s3_agent_p2_approved

                    $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '92'])->first();

                    $subject = mail_tag_replace($mail_temp_4->subject, $pointer_id);

                    $message = mail_tag_replace($mail_temp_4->body, $pointer_id);
                    if($upload_outcome_path!=""){

                    $addAttachment = array(

                        [

                            'file_path' => $upload_outcome_path,

                            'file_name' => $outcome_file_name

                        ]

                    );
}


                    $to =  $user_mail;

                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                    if ($check == 1) {

                        $mail_check = 1;
                    }
                }

                if ($client_type == "Applicant") {

                    // s3_applicant_p2_approved

                    $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '77'])->first();

                    $subject = mail_tag_replace($mail_temp_4->subject, $pointer_id);

                    $message = mail_tag_replace($mail_temp_4->body, $pointer_id);
                    if($upload_outcome_path!=""){

                    $addAttachment = array(

                        [

                            'file_path' => $upload_outcome_path,

                            'file_name' => $outcome_file_name

                        ]

                    );

}

                    $to =  $user_mail;

                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                    if ($check == 1) {

                        $mail_check = 1;
                    }
                }
            }



            $mail_check_1 = 0;

            // s3_approved_admin

            $mail_temp_5 = $this->mail_template_model->asObject()->where(['id' => '38'])->first();

            $subject = mail_tag_replace($mail_temp_5->subject, $pointer_id);

            $message = $mail_temp_5->body;

            // new add on 04-04-2023 by vishal as par clint call

            $to =   env('DIPREET_EMAIL');

            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

            if ($check == 1) {

                $mail_check_1 = 1;
            }



            if ($mail_check_1 == 1 && $mail_check == 1) {

                //database record for mail 5 

                $admin_status = [
                    'status' => $status,
                    'approved_date' => date("Y-m-d H:i:s"),
                    'approved_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")

                ];





                $database_check =  $this->stage_3_model->update($stage_3_id, $admin_status);
                delete_by_pointer_id__($pointer_id,'stage_3');
                $pointer_data = [

                    'stage' => 'stage_3',

                    'status' => $status,

                    'update_date' => date("Y-m-d H:i:s")

                ];

                $database_check =  $this->application_pointer_model->update($pointer_id, $pointer_data);
            }
        } elseif ($status == 'Declined') {

            //-------------------- upload Documnets ---------------------

    $middle_name__ = "";
            if($s1_personal_details->middle_names){
                $middle_name__ = " ".$s1_personal_details->middle_names;
            }

           $name = $s1_personal_details->first_or_given_name.$middle_name__." ".$s1_personal_details->surname_family_name;
            $target_file =  'public/application/' . $pointer_id . '/stage_3/declined';

            //-------------------- Statement of Reasons	Documnets ---------------------

            $reason_file = $this->request->getFile('reason_file');

            $reason_file_basename = $reason_file->getName();
            
            if($reason_file->getName()){
                
            $reason_file_extension = explode(".", $reason_file_basename);

            $reason_file_type = $reason_file_extension[count($reason_file_extension) - 1];

            $reason_file_name = 'Statement of Reasons - '.$name.'.'. $reason_file_type;

            $reason_file->move($target_file, $reason_file_name);

            // file path need to send with email for applicant and agent

            $reason_path = $target_file . '/' . $reason_file_name;

            $reason_data = array(

                'pointer_id' => $pointer_id,

                'stage' => 'stage_3',

                'required_document_id' => 24,

                'name' => 'Statement of Reasons',

                'document_name' => $reason_file_name,

                'document_path' => $target_file,

                'status' => 1,

                'update_date' => date("Y-m-d H:i:s"),

                'create_date' => date("Y-m-d H:i:s")

            );



            $this->documents_model->insert($reason_data);
            
            }else{
                $resone = find_one_row_3_field('documents','stage','stage_3','pointer_id',$pointer_id,'required_document_id',24);
            
                $reason_path = $resone->document_path."/".$resone->document_name;
                $reason_file_name = $resone->name;
                
            }            //-------------------- Outcome Letter Documnets ---------------------

            $outcome_file = $this->request->getFile('outcome_file');

            $outcome_file_basename = $outcome_file->getName();

            if($outcome_file->getName()){
            
            $outcome_file_extension = explode(".", $outcome_file_basename);

            $outcome_file_type = $outcome_file_extension[count($outcome_file_extension) - 1];

            $outcome_file_name = 'Skills Assessment Result - '.$name.'.'. $outcome_file_type;

            $outcome_file->move($target_file, $outcome_file_name);

            // file path need to send with email for applicant and agent

            $outcome_path = $target_file . '/' . $outcome_file_name;

            $outcome_data = array(

                'pointer_id' => $pointer_id,

                'stage' => 'stage_3',

                'required_document_id' => 23,

                'name' => 'Skills Assessment Result',

                'document_name' => $outcome_file_name,

                'document_path' => $target_file,

                'status' => 1,

                'update_date' => date("Y-m-d H:i:s"),

                'create_date' => date("Y-m-d H:i:s")

            );

            $this->documents_model->insert($outcome_data);
            
            }else{
                $outcome_letter = find_one_row_3_field('documents','stage','stage_3','pointer_id',$pointer_id,'required_document_id',23);
            
                $outcome_path = $outcome_letter->document_path."/".$outcome_letter->document_name;
                $outcome_file_name = $outcome_letter->name;
            }
            //-------------------- upload Documnets end ---------------------        



            $mail_check = 0;

            $client_type =  is_Agent_Applicant($pointer_id);

            if ($client_type == "Agent") { // Applicant

                //s3_declined_agent

                $mail_temp_6 = $this->mail_template_model->asObject()->where(['id' => '39'])->first();

                $subject = mail_tag_replace($mail_temp_6->subject, $pointer_id);

                $message = $mail_temp_6->body;

                $message = str_replace('%occupation_reason_for_decline_stage_3%', $reason, $message);

                $message = mail_tag_replace($message, $pointer_id);

                $to =  $user_mail;

                $addAttachment = array(

                    [

                        'file_path' => $outcome_path,

                        'file_name' => $outcome_file_name

                    ], [

                        'file_path' => $reason_path,

                        'file_name' => $reason_file_name

                    ]

                );

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                if ($check == 1) {

                    $mail_check = 1;
                }
            }

            if ($client_type == "Applicant") {

                //s3_declined_applicant

                $mail_temp_6 = $this->mail_template_model->asObject()->where(['id' => '73'])->first();

                $subject = mail_tag_replace($mail_temp_6->subject, $pointer_id);

                $message = $mail_temp_6->body;

                $message = str_replace('%occupation_reason_for_decline_stage_3%', $reason, $message);

                $message = mail_tag_replace($message, $pointer_id);

                $to =  $user_mail;

                $addAttachment = array(

                    [

                        'file_path' => $outcome_path,

                        'file_name' => $outcome_file_name

                    ], [

                        'file_path' => $reason_path,

                        'file_name' => $reason_file_name

                    ]

                );

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                if ($check == 1) {

                    $mail_check = 1;
                }
            }



            $mail_check_1 = 0;

            // s3_declined_admin

            $mail_temp_7 = $this->mail_template_model->asObject()->where(['id' => '40'])->first();

            $subject = mail_tag_replace($mail_temp_7->subject, $pointer_id);

            $message = $mail_temp_7->body;

            // new add on 04-04-2023 by vishal as par clint call

            $to =   env('DIPREET_EMAIL');

            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

            if ($check == 1) {

                $mail_check_1 = 1;
            }



            if ($mail_check == 1 && $mail_check_1 == 1) {

                //database record for mail 7       

                $admin_status = [

                    'status' => $status,

                    'declined_date' => date("Y-m-d H:i:s"),

                    'declined_reason' => $reason,

                    'declined_by' => session()->get('admin_id'),

                    'update_date' => date("Y-m-d H:i:s")

                ];

                $database_check = $this->stage_3_model->update($stage_3_id, $admin_status);

                $pointer_data = [

                    'stage' => 'stage_3',

                    'status' => $status,

                    'update_date' => date("Y-m-d H:i:s")

                ];

                $database_check =  $this->application_pointer_model->update($pointer_id, $pointer_data);
            }
        } elseif ($status == 'Withdrawn') {

            $mail_check = 0;

            $mail_check_1 = 0;

            $client_type =  is_Agent_Applicant($pointer_id);

            if ($client_type == "Agent") { // Applicant

                // s3_withdrawn_agent

                $mail_temp_7 = $this->mail_template_model->asObject()->where(['id' => '41'])->first();

                $subject = mail_tag_replace($mail_temp_7->subject, $pointer_id);

                $message = mail_tag_replace($mail_temp_7->body, $pointer_id);

                $to =  $user_mail;

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

                if ($check == 1) {

                    $mail_check = 1;
                }
            }

            if ($client_type == "Applicant") {

                // s3_withdrawn_applicant

                $mail_temp_7 = $this->mail_template_model->asObject()->where(['id' => '85'])->first();

                $subject = mail_tag_replace($mail_temp_7->subject, $pointer_id);

                $message = mail_tag_replace($mail_temp_7->body, $pointer_id);

                $to =  $user_mail;

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

                if ($check == 1) {

                    $mail_check = 1;
                }
            }



            // s3_withdrawn_admin

            $mail_temp_8 = $this->mail_template_model->asObject()->where(['id' => '42'])->first();

            $subject = mail_tag_replace($mail_temp_8->subject, $pointer_id);

            $message = $mail_temp_8->body;

            // new add on 04-04-2023 by vishal as par clint call

            $to =   env('DIPREET_EMAIL');

            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

            $to =    env('HEADOFFICE_EMAIL');

            $check_1 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

            if ($check == 1 && $check_1 == 1) {

                $mail_check_1 = 1;
            }



            if ($mail_check_1 == 1 && $mail_check == 1) {

                $admin_status = [

                    'status' => $status,

                    'withdraw_date' => date("Y-m-d H:i:s"),

                    'withdraw_by' => session()->get('admin_id'),

                    'update_date' => date("Y-m-d H:i:s")

                ];

                if ($this->stage_3_model->update($stage_3_id, $admin_status)) {

                    $database_check = 1;
                }
           delete_by_pointer_id__($pointer_id,'stage_3');
                $pointer_data = [

                    'stage' => 'stage_3',

                    'status' => $status,

                    'update_date' => date("Y-m-d H:i:s")

                ];

                $database_check =    $this->application_pointer_model->update($pointer_id, $pointer_data);
            }
        }





        if ($mail_check == 1 || $database_check == 1) {

            $callback = array(

                "color" => "success",

                "msg" => "mail send succesfully",

                "response" => true,

                'pointer_id' => $pointer_id,

            );
        } else {

            $callback = array(

                "msg" => "mail not send",

                "color" => "danger",

                "response" => false,

                'pointer_id' => $pointer_id,

            );
        }

        echo json_encode($callback);
    
    }
    
    public function stage_3_reassessment_change_status()
    {
        $user_id = $this->request->getPost('user_id');

        $pointer_id = $this->request->getPost('pointer_id');

        $reason = $this->request->getPost('reason');

        $stage_3_r_id = $this->request->getPost('stage_3_r_id');

        $status = $this->request->getPost('status');
        
        $preference_location = $this->request->getPost('preference_location');
        
        $time_zone = $this->request->getPost('time_zone');
        
        if (empty($status)) {

            $callback = array(

                "msg" => "Select Status First.",

                "color" => "danger",

                "response" => false,

                'pointer_id' => $pointer_id,

            );

            echo json_encode($callback);

            exit;
        }
       
        $comment = "";
        // echo "heye";

        if (isset($_POST['comment'])) {
            // echo "theere";

            $comment = trim($_POST['comment']);

            $comment = trim($comment, "\xC2\xA0");

            $comment = str_replace("&nbsp;", '', $comment);

        }

        
            $comment_update = $this->stage_3_reassessment_model->where(['pointer_id' => $pointer_id])->set(['preference_comment' => $comment])->update();
            $stage_3_model__data = $this->stage_3_reassessment_model->where(['pointer_id' => $pointer_id])->asObject()->first();
            // print_r($comment_update);
            // exit;
            // AISH -> Update
            if(isset($_POST['preference_location'])){
                $preference_location = $_POST['preference_location'];    
            }
            else{
                $preference_location = $stage_3_model__data->preference_location;
            }
            
            
            // Exit
            $update_location = $this->stage_3_reassessment_model->where(['pointer_id' => $pointer_id])->set(['preference_location' => $preference_location])->update();
            if ($update_location) {
                if ($preference_location == "Online (Via Zoom)") {
                    if (isset($_POST['time_zone'])) {
                        $time_zone = $_POST['time_zone'];
                        $update_zone = $this->stage_3_reassessment_model->where(['pointer_id' => $pointer_id])->set(['time_zone' => $time_zone])->update();
                    }
                }
            }
            
            // 
    // exit;

        $s1_occupation = $this->stage_1_occupation_model->asObject()->where('pointer_id', $pointer_id)->first();

        $s1_personal_details = $this->stage_1_personal_details_model->asObject()->where('pointer_id', $pointer_id)->first();

        $user_account = $this->user_account_model->asObject()->where('id', $user_id)->first();

        $user_mail = $user_account->email;

        $mail_check = 0;

        $database_check = 0;





        $date = $this->additional_info_request_model->where(['stage' => "stage_3_R", 'pointer_id' => $pointer_id])->find();

        $check_if_file = true;
        
        

        foreach ($date as $key => $value) {

            if ($value['status'] == "send") {

                $check_if_file = false;
            }
        }
        
        

        if ($check_if_file) {

            $this->additional_info_request_model->where(['stage' => "stage_3_R", 'pointer_id' => $pointer_id])->set(['status' => 'verified'])->update();
        }




            $name = $s1_personal_details->first_or_given_name;
            // echo 

        
            // Get the Occupation
            $enroll_stage_4 = false;
            $occupation = $this->stage_1_occupation_model->where("pointer_id", $pointer_id)->asObject()->first();
            if($occupation->pathway == "Pathway 1"){
                if($occupation->occupation_id == 7 || $occupation->occupation_id == 18){
                    $enroll_stage_4 = true;
                }
            }
            // end

        if ($status == 'Lodged') {


            $stage_3_online_ = find_one_row('stage_3_reassessment', 'pointer_id', $pointer_id);
            $stage_1_usi_avetmiss=find_one_row('stage_1_usi_avetmiss','pointer_id',$pointer_id);
           
        //   print_r($preference_location);
            // s3_lodged_head_office
            if ($preference_location == "Online (Via Zoom)") {
                
                // This is for OnShore Application 
                if($stage_1_usi_avetmiss->currently_have_usi=='yes' && $preference_location == "Online (Via Zoom)"){
                
                $client_type =  is_Agent_Applicant($pointer_id);

                if ($client_type == "Agent") {
                
                   $mail_temp_1 =  $this->mail_template_model->asObject()->where(['id' => '111'])->first();
                }
                else{
                   $mail_temp_1 =  $this->mail_template_model->asObject()->where(['id' => '68'])->first(); 
                }
                }
                else{
                
                    if($enroll_stage_4 == true){
                        $mail_temp_1 =  $this->mail_template_model->asObject()->where(['id' => '137'])->first();
                        
                    }
                    else{
                        $mail_temp_1 =  $this->mail_template_model->asObject()->where(['id' => '116'])->first();        
                    }
                }
                
            }
            else{
            
            $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '191'])->first();
            }



            $stage_3_ = $this->stage_3_reassessment_model->where(['pointer_id' => $pointer_id])->first();
            
            $preference_location_comment = "";
            if (!empty($stage_3_)) {
               // print_r($stage_3_);
                $preference_location = trim($stage_3_['preference_location']);
                $preference_comment = trim($stage_3_['preference_comment']);
             
                // $preference_comment = trim($preference_comment, "\xC2\xA0");
                $time_zone = trim($stage_3_['time_zone']);
                // $preference_comment = str_replace("&nbsp;", '', $preference_comment);
                if (!empty($preference_location)) {
                    $preference_location_comment .= "<br><br><span style='background-color: rgb(255, 255, 0);'><b>Applicant's Preferred Venue: " . $preference_location."</b><span>";
                }
                
                if ($preference_location == "Online (Via Zoom)") {
                    
                    $preference_location_comment .= "<br><br><span style='background-color: rgb(255, 255, 0);'><b>Time Zone: " . $time_zone."</b><span><br><br>";
                }
                else{
                    $preference_location_comment .= "<br><br>";
                }
            //     print_r($preference_comment);
            // exit;
                if (!empty($preference_comment)) {
                    $preference_location_comment .= "<span style='background-color: rgb(255, 255, 0);'><b>Comments: <br> &ldquo;" . $preference_comment . "&rdquo;</b><span><br><br>";
                }
                   
            //print_r($preference_location_comment);
            // exit;
            }

            $to = env('HEADOFFICE_EMAIL');
            $subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
            $message = $mail_temp_1->body;
            $message = str_replace('%data%', $preference_location_comment, $message);
             
          
            // IF
            $addAttachment = [];
            if ($preference_location == "Online (Via Zoom)") {
              if($stage_1_usi_avetmiss->currently_have_usi=='yes' && $preference_location == "Online (Via Zoom)"){
                $applicant_agent='public/application/' . $pointer_id .'/stage_3_R'.'/'.$stage_3_online_->applicant_agent_form;
             $stage_3_Docs_ = $this->documents_model->where(['pointer_id' => $pointer_id, 'required_document_id' => 55, 'stage' => "stage_3_R"])->first();
                $addAttachment = [];
                 $addAttachment_applicant = array(     
    
                    [
    
                        'file_path' => $stage_3_Docs_['document_path'] . '/' . $stage_3_Docs_['document_name'],
                        'file_name' => $stage_3_Docs_['document_name'],
    
                    ]
                    );
                  array_push($addAttachment, ...$addAttachment_applicant);
                 // print_r($addAttachment_applicant);
            }
          
            if($enroll_stage_4 == false){
                // print_r($stage_3_online_);
                // die;
                if($stage_3_online_->exemption_yes_no == 'yes'){
                   
                $stage_3_online = find_one_row('stage_3_reassessment', 'pointer_id', $pointer_id);
                $exemption_form_name=$stage_3_online->exemption_form;
                 $exemption_form_path='public/application/' . $pointer_id .'/stage_3_R/assessment_documents'.'/'.$stage_3_online->exemption_form;
                $stage_3_Docs = $this->documents_model->where(['pointer_id' => $pointer_id, 'required_document_id' => 43, 'stage' => "stage_3_R"])->first();
                    
                 $addAttachment__ = array(
    
                    [
    
                        'file_path' => $stage_3_Docs['document_path'] . '/' . $stage_3_Docs['document_name'],
                        'file_name' => $stage_3_Docs['document_name'],
    
                    ]
                    );
                    array_push($addAttachment, ...$addAttachment__);
                   // print_r($addAttachment);
                    
            }
            }
            }
            // END
            $stage_3_Docs = $this->documents_model->where(['pointer_id' => $pointer_id, 'required_document_id' => 19, 'stage' => "stage_3_R"])->first();
            if(!empty($stage_3_Docs)){
                 $addAttachment__ = array(
                [
                    'file_path' => $stage_3_Docs['document_path'] . '/' . $stage_3_Docs['document_name'],
                    'file_name' => $stage_3_Docs['document_name'],
                ]
            );
            }else{
                $addAttachment__=array();
            }
           
            array_push($addAttachment, ...$addAttachment__);
            // print_r($addAttachment_applicant);
            // exit;
            //     print_r($addAttachment);
            //     exit;
            // function send_email($setFrom, $setFrom_name, $addAddress, $Subject, $Body, $addReplyTo_array = [], $addBCC_array = [], $addCC_array = [], $addAttachment_array = [])

            $mail_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

           
            
            if ($mail_check == 1) {
                $admin_status = [
                    'status' => $status,
                    'lodged_date' =>  date("Y-m-d H:i:s"),
                    'lodged_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                if ($this->stage_3_reassessment_model->update($stage_3_r_id, $admin_status)) {
                    $database_check = 1;
                }
                $pointer_data = [
                    'stage' => 'stage_3_R',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $this->application_pointer_model->update($pointer_id, $pointer_data);
            }
        } elseif ($status == 'Conducted') {

            $admin_status = [

                'status' => $status,

                'conducted_date' => date("Y-m-d H:i:s"),

                'conducted_by' => session()->get('admin_id'),

                'update_date' => date("Y-m-d H:i:s")

            ];

            if ($this->stage_3_reassessment_model->update($stage_3_r_id, $admin_status)) {

                $database_check = 1;
            }

            $pointer_data = [

                'stage' => 'stage_3_R',

                'status' => $status,

                'update_date' => date("Y-m-d H:i:s")

            ];

            $this->application_pointer_model->update($pointer_id, $pointer_data);
        } elseif ($status == 'Approved') {



            //-------------------- upload Documnets ---------------------


            $target_file =  'public/application/' . $pointer_id . '/stage_3_R/approved';

            //-------------------- Qualifications Documnets ---------------------

            if ($s1_occupation->pathway == 'Pathway 1') {
                $upload_qualification_file="";
                $upload_outcome_path="";
                $qualification_file_path="";
                $upload_qualification_file = $this->request->getFile('upload_qualification_file');

                $qualification_file_basename = $upload_qualification_file->getName();

                $qualification_file_extension = explode(".", $qualification_file_basename);

                $qualification_file_type = $qualification_file_extension[count($qualification_file_extension) - 1];

                $qualification_file_name = 'Qualification Documents - '.$name.'.'. $qualification_file_type;
                
                if($upload_qualification_file !=""){
                    $upload_qualification_file->move($target_file, $qualification_file_name);

                    // file path need to send with email for applicant and agent

                    $qualification_file_path = $target_file . '/' . $qualification_file_name;

                    $qualification_data = array(

                        'pointer_id' => $pointer_id,

                        'stage' => 'stage_3_R',

                        'required_document_id' => 26,

                        'name' => 'Qualification Documents',

                        'document_name' => $qualification_file_name,

                        'document_path' => $target_file,

                        'status' => 1,

                        'update_date' => date("Y-m-d H:i:s"),

                        'create_date' => date("Y-m-d H:i:s")

                    );



                    $this->documents_model->insert($qualification_data);

                    
                }
            }

            //-------------------- Qualifications Documnets end---------------------

            //-------------------- Outcome Letter Documnets ---------------------
            $upload_outcome_file="";
            $upload_outcome_path="";
            $addAttachment=array();
            $upload_outcome_file = $this->request->getFile('upload_outcome_file');

            $outcome_file_basename = $upload_outcome_file->getName();

            $outcome_file_extension = explode(".", $outcome_file_basename);

            $outcome_file_type = $outcome_file_extension[count($outcome_file_extension) - 1];

            $outcome_file_name = 'Skills Assessment Result - ' . $name . "." . $outcome_file_type;


            // file path need to send with email for applicant and agent
            if($upload_outcome_file !=""){
                $upload_outcome_file->move($target_file, $outcome_file_name);

                $upload_outcome_path = $target_file . '/' . $outcome_file_name;

                $outcome_data = array(

                'pointer_id' => $pointer_id,

                'stage' => 'stage_3_R',

                'required_document_id' => 25,

                'name' => 'Skills Assessment Result',

                'document_name' => $outcome_file_name,

                'document_path' => $target_file,

                'status' => 1,

                'update_date' => date("Y-m-d H:i:s"),

                'create_date' => date("Y-m-d H:i:s")

                );

                $this->documents_model->insert($outcome_data);

          
            }
            //-------------------- Outcome Letter Documnets end ---------------------

            //-------------------- upload Documnets end ---------------------        



            $mail_check = 0;

            if ($s1_occupation->pathway == 'Pathway 1') {
                $occupation_id = $s1_occupation->occupation_id;
                if($occupation_id == 7 || $occupation_id == 18){ 
                    
                    $mail_check=1;
                    
                      $client_type =  is_Agent_Applicant($pointer_id);

                    if ($client_type == "Agent") { // Applicant

                        // s3_agent_p1_approved
                        if($s1_occupation->program == "OSAP"){
                        $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '193'])->first();   
                        }
                        else{
                            $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '194'])->first();   
                        }

                        $subject = mail_tag_replace($mail_temp_4->subject, $pointer_id);

                        $message = mail_tag_replace($mail_temp_4->body, $pointer_id);
                        
                        if($upload_outcome_path !=""){
                            $addAttachment = array(

                                [

                                    'file_path' => $upload_outcome_path,

                                    'file_name' => $outcome_file_name

                                ]
                                );

                        }else{
                            $addAttachment=array();
                        }
                        
                    

                        if ($s1_occupation->pathway == 'Pathway 1') {
                            if($qualification_file_path !=""){
                                                        array_push($addAttachment, array('file_path' => $qualification_file_path, 'file_name' => $qualification_file_name));

                            }

                        }

                        $to =  $user_mail;

                        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                        if ($check == 1) {

                            $mail_check = 1;
                        }
                    }

                    if ($client_type == "Applicant") {

                        // s3_applicant_p1_approved
                        if($s1_occupation->program == "OSAP"){
                        $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '195'])->first();
                        }
                        else{
                            $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '196'])->first();   
                        }

                        

                        $subject = mail_tag_replace($mail_temp_4->subject, $pointer_id);

                        $message = mail_tag_replace($mail_temp_4->body, $pointer_id);
                        if($upload_outcome_path !=""){

                        $addAttachment = array(

                            [

                                'file_path' => $upload_outcome_path,

                                'file_name' => $outcome_file_name

                            ]

                        );
                            
                        }
                        

                        if ($s1_occupation->pathway == 'Pathway 1') {
                            if($qualification_file_path !=""){
                                                        array_push($addAttachment, array('file_path' => $qualification_file_path, 'file_name' => $qualification_file_name));

                            }

                        }

                        $to =  $user_mail;

                        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                        if ($check == 1) {

                            $mail_check = 1;
                        }
                    
                    }
            
                }else{

                $client_type =  is_Agent_Applicant($pointer_id);

                if ($client_type == "Agent") { // Applicant

                    // s3_agent_p1_approved

                    $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '168'])->first();

                    $subject = mail_tag_replace($mail_temp_4->subject, $pointer_id);

                    $message = mail_tag_replace($mail_temp_4->body, $pointer_id);

                    $addAttachment = array(

                        [

                            'file_path' => $upload_outcome_path,

                            'file_name' => $outcome_file_name

                        ]

                    );

                    if ($s1_occupation->pathway == 'Pathway 1') {

                        array_push($addAttachment, array('file_path' => $qualification_file_path, 'file_name' => $qualification_file_name));
                    }

                    $to =  $user_mail;

                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                    if ($check == 1) {

                        $mail_check = 1;
                    }
                }

                if ($client_type == "Applicant") {

                    // s3_applicant_p1_approved

                    $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '181'])->first();

                    $subject = mail_tag_replace($mail_temp_4->subject, $pointer_id);

                    $message = mail_tag_replace($mail_temp_4->body, $pointer_id);

                    $addAttachment = array(

                        [

                            'file_path' => $upload_outcome_path,

                            'file_name' => $outcome_file_name

                        ]

                    );

                    if ($s1_occupation->pathway == 'Pathway 1') {

                        array_push($addAttachment, array('file_path' => $qualification_file_path, 'file_name' => $qualification_file_name));
                    }

                    $to =  $user_mail;

                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                    if ($check == 1) {

                        $mail_check = 1;
                    }
                }
                }
            } else {

                $client_type =  is_Agent_Applicant($pointer_id);

                if ($client_type == "Agent") { // Applicant

                    // s3_agent_p2_approved

                    $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '169'])->first();

                    $subject = mail_tag_replace($mail_temp_4->subject, $pointer_id);

                    $message = mail_tag_replace($mail_temp_4->body, $pointer_id);
                    if($upload_outcome_path!=""){

                        $addAttachment = array(

                            [

                                'file_path' => $upload_outcome_path,

                                'file_name' => $outcome_file_name

                            ]

                        );
                    }


                    $to =  $user_mail;

                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                    if ($check == 1) {

                        $mail_check = 1;
                    }
                }

                if ($client_type == "Applicant") {

                    // s3_applicant_p2_approved

                    $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '177'])->first();

                    $subject = mail_tag_replace($mail_temp_4->subject, $pointer_id);

                    $message = mail_tag_replace($mail_temp_4->body, $pointer_id);
                    if($upload_outcome_path!=""){

                        $addAttachment = array(

                            [

                                'file_path' => $upload_outcome_path,

                                'file_name' => $outcome_file_name

                            ]

                        );

                    }

                    $to =  $user_mail;

                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                    if ($check == 1) {

                        $mail_check = 1;
                    }
                }
            }



            $mail_check_1 = 0;

            // s3_approved_admin

            $mail_temp_5 = $this->mail_template_model->asObject()->where(['id' => '188'])->first();

            $subject = mail_tag_replace($mail_temp_5->subject, $pointer_id);

            $message = $mail_temp_5->body;

            // new add on 04-04-2023 by vishal as par clint call

            $to =   env('DIPREET_EMAIL');

            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

            if ($check == 1) {

                $mail_check_1 = 1;
            }



            if ($mail_check_1 == 1 && $mail_check == 1) {

                //database record for mail 5 

                $admin_status = [

                    'status' => $status,

                    'approved_date' => date("Y-m-d H:i:s"),

                    'approved_by' => session()->get('admin_id'),

                    'update_date' => date("Y-m-d H:i:s")

                ];





                $database_check =  $this->stage_3_reassessment_model->update($stage_3_r_id, $admin_status);

                $pointer_data = [

                    'stage' => 'stage_3_R',

                    'status' => $status,

                    'update_date' => date("Y-m-d H:i:s")

                ];

                $database_check =  $this->application_pointer_model->update($pointer_id, $pointer_data);
            }
        } elseif ($status == 'Declined') {

            //-------------------- upload Documnets ---------------------

            $middle_name__ = "";
            if($s1_personal_details->middle_names){
                $middle_name__ = " ".$s1_personal_details->middle_names;
            }

           $name = $s1_personal_details->first_or_given_name.$middle_name__." ".$s1_personal_details->surname_family_name;

            $target_file =  'public/application/' . $pointer_id . '/stage_3_R/declined';

            //-------------------- Statement of Reasons	Documnets ---------------------

            $reason_file = $this->request->getFile('reason_file');

            $reason_file_basename = $reason_file->getName();
            
            if($reason_file->getName()){
                
            $reason_file_extension = explode(".", $reason_file_basename);

            $reason_file_type = $reason_file_extension[count($reason_file_extension) - 1];

            $reason_file_name = 'Statement of Reasons - '.$name.'.'. $reason_file_type;

            $reason_file->move($target_file, $reason_file_name);

            // file path need to send with email for applicant and agent

            $reason_path = $target_file . '/' . $reason_file_name;

            $reason_data = array(

                'pointer_id' => $pointer_id,

                'stage' => 'stage_3_R',

                'required_document_id' => 24,

                'name' => 'Statement of Reasons',

                'document_name' => $reason_file_name,

                'document_path' => $target_file,

                'status' => 1,

                'update_date' => date("Y-m-d H:i:s"),

                'create_date' => date("Y-m-d H:i:s")

            );



            $this->documents_model->insert($reason_data);
            
            }else{
                $resone = find_one_row_3_field('documents','stage','stage_3_R','pointer_id',$pointer_id,'required_document_id',24);
            
                $reason_path = $resone->document_path."/".$resone->document_name;
                $reason_file_name = $resone->name;
                
            }            //-------------------- Outcome Letter Documnets ---------------------

            $outcome_file = $this->request->getFile('outcome_file');

            $outcome_file_basename = $outcome_file->getName();

            if($outcome_file->getName()){
            
            $outcome_file_extension = explode(".", $outcome_file_basename);

            $outcome_file_type = $outcome_file_extension[count($outcome_file_extension) - 1];

            $outcome_file_name = 'Skills Assessment Result - '.$name.'.'. $outcome_file_type;

            $outcome_file->move($target_file, $outcome_file_name);

            // file path need to send with email for applicant and agent

            $outcome_path = $target_file . '/' . $outcome_file_name;

            $outcome_data = array(

                'pointer_id' => $pointer_id,

                'stage' => 'stage_3_R',

                'required_document_id' => 23,

                'name' => 'Skills Assessment Result',

                'document_name' => $outcome_file_name,

                'document_path' => $target_file,

                'status' => 1,

                'update_date' => date("Y-m-d H:i:s"),

                'create_date' => date("Y-m-d H:i:s")

            );

            $this->documents_model->insert($outcome_data);
            
            }else{
                $outcome_letter = find_one_row_3_field('documents','stage','stage_3_R','pointer_id',$pointer_id,'required_document_id',23);
            
                $outcome_path = $outcome_letter->document_path."/".$outcome_letter->document_name;
                $outcome_file_name = $outcome_letter->name;
            }
            //-------------------- upload Documnets end ---------------------        



            $mail_check = 0;

            $client_type =  is_Agent_Applicant($pointer_id);

            if ($client_type == "Agent") { // Applicant

                //s3_declined_agent

                $mail_temp_6 = $this->mail_template_model->asObject()->where(['id' => '170'])->first();

                $subject = mail_tag_replace($mail_temp_6->subject, $pointer_id);

                $message = $mail_temp_6->body;

                $message = str_replace('%occupation_reason_for_decline_stage_3%', $reason, $message);

                $message = mail_tag_replace($message, $pointer_id);

                $to =  $user_mail;

                $addAttachment = array(

                    [

                        'file_path' => $outcome_path,

                        'file_name' => $outcome_file_name

                    ], [

                        'file_path' => $reason_path,

                        'file_name' => $reason_file_name

                    ]

                );

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                if ($check == 1) {

                    $mail_check = 1;
                }
            }

            if ($client_type == "Applicant") {

                //s3_declined_applicant

                $mail_temp_6 = $this->mail_template_model->asObject()->where(['id' => '176'])->first();

                $subject = mail_tag_replace($mail_temp_6->subject, $pointer_id);

                $message = $mail_temp_6->body;

                $message = str_replace('%occupation_reason_for_decline_stage_3%', $reason, $message);

                $message = mail_tag_replace($message, $pointer_id);

                $to =  $user_mail;

                $addAttachment = array(

                    [

                        'file_path' => $outcome_path,

                        'file_name' => $outcome_file_name

                    ], [

                        'file_path' => $reason_path,

                        'file_name' => $reason_file_name

                    ]

                );

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                if ($check == 1) {

                    $mail_check = 1;
                }
            }



            $mail_check_1 = 0;

            // s3_declined_admin

            $mail_temp_7 = $this->mail_template_model->asObject()->where(['id' => '189'])->first();

            $subject = mail_tag_replace($mail_temp_7->subject, $pointer_id);

            $message = $mail_temp_7->body;

            // new add on 04-04-2023 by vishal as par clint call

            $to =   env('DIPREET_EMAIL');

            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

            if ($check == 1) {

                $mail_check_1 = 1;
            }



            if ($mail_check == 1 && $mail_check_1 == 1) {

                //database record for mail 7       

                $admin_status = [

                    'status' => $status,

                    'declined_date' => date("Y-m-d H:i:s"),

                    'declined_reason' => $reason,

                    'declined_by' => session()->get('admin_id'),

                    'update_date' => date("Y-m-d H:i:s")

                ];

                $database_check = $this->stage_3_reassessment_model->update($stage_3_r_id, $admin_status);

                $pointer_data = [

                    'stage' => 'stage_3_R',

                    'status' => $status,

                    'update_date' => date("Y-m-d H:i:s")

                ];

                $database_check =  $this->application_pointer_model->update($pointer_id, $pointer_data);
            }
        } elseif ($status == 'Withdrawn') {

            $mail_check = 0;

            $mail_check_1 = 0;

            $client_type =  is_Agent_Applicant($pointer_id);

            if ($client_type == "Agent") { // Applicant

                // s3_withdrawn_agent

                $mail_temp_7 = $this->mail_template_model->asObject()->where(['id' => '41'])->first();

                $subject = mail_tag_replace($mail_temp_7->subject, $pointer_id);

                $message = mail_tag_replace($mail_temp_7->body, $pointer_id);

                $to =  $user_mail;

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

                if ($check == 1) {

                    $mail_check = 1;
                }
            }

            if ($client_type == "Applicant") {

                // s3_withdrawn_applicant

                $mail_temp_7 = $this->mail_template_model->asObject()->where(['id' => '85'])->first();

                $subject = mail_tag_replace($mail_temp_7->subject, $pointer_id);

                $message = mail_tag_replace($mail_temp_7->body, $pointer_id);

                $to =  $user_mail;

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

                if ($check == 1) {

                    $mail_check = 1;
                }
            }



            // s3_withdrawn_admin

            $mail_temp_8 = $this->mail_template_model->asObject()->where(['id' => '42'])->first();

            $subject = mail_tag_replace($mail_temp_8->subject, $pointer_id);

            $message = $mail_temp_8->body;

            // new add on 04-04-2023 by vishal as par clint call

            $to =   env('DIPREET_EMAIL');

            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

            $to =    env('HEADOFFICE_EMAIL');

            $check_1 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

            if ($check == 1 && $check_1 == 1) {

                $mail_check_1 = 1;
            }



            if ($mail_check_1 == 1 && $mail_check == 1) {

                $admin_status = [

                    'status' => $status,

                    'withdraw_date' => date("Y-m-d H:i:s"),

                    'withdraw_by' => session()->get('admin_id'),

                    'update_date' => date("Y-m-d H:i:s")

                ];

                if ($this->stage_3_reassessment_model->update($stage_3_r_id, $admin_status)) {

                    $database_check = 1;
                }

                $pointer_data = [

                    'stage' => 'stage_3_R',

                    'status' => $status,

                    'update_date' => date("Y-m-d H:i:s")

                ];

                $database_check =    $this->application_pointer_model->update($pointer_id, $pointer_data);
            }
        }





        if ($mail_check == 1 || $database_check == 1) {

            $callback = array(

                "color" => "success",

                "msg" => "mail send succesfully",

                "response" => true,

                'pointer_id' => $pointer_id,

            );
        } else {

            $callback = array(

                "msg" => "mail not send",

                "color" => "danger",

                "response" => false,

                'pointer_id' => $pointer_id,

            );
        }

        echo json_encode($callback);
    
    }
    
    
// Stage 4 status

public function stage_4_change_status(){
    // echo "hey";
    // exit;

        $user_id = $this->request->getPost('user_id');

        $pointer_id = $this->request->getPost('pointer_id');

        $reason = $this->request->getPost('reason');

        $stage_4_id = $this->request->getPost('stage_4_id');

        $status = $this->request->getPost('status');
        
        
        $preference_location = $this->request->getPost('preference_location_stage_4');

        
        if (empty($status)) {

            $callback = array(

                "msg" => "Select Status First.",

                "color" => "danger",

                "response" => false,

                'pointer_id' => $pointer_id,

            );

            echo json_encode($callback);

            exit;
        }
  

            
            // 
    // exit;

        $s1_occupation = $this->stage_1_occupation_model->asObject()->where('pointer_id', $pointer_id)->first();

        $s1_personal_details = $this->stage_1_personal_details_model->asObject()->where('pointer_id', $pointer_id)->first();

        $user_account = $this->user_account_model->asObject()->where('id', $user_id)->first();

        $user_mail = $user_account->email;

        $mail_check = 0;

        $database_check = 0;





        $date = $this->additional_info_request_model->where(['stage' => "stage_4", 'pointer_id' => $pointer_id])->find();

        $check_if_file = true;
        
        

        foreach ($date as $key => $value) {

            if ($value['status'] == "send") {

                $check_if_file = false;
            }
        }
        
        

        if ($check_if_file) {

            $this->additional_info_request_model->where(['stage' => "stage_4", 'pointer_id' => $pointer_id])->set(['status' => 'verified'])->update();
        }


        $comment = $comment_html_mail = "";
        //
        if (isset($_POST['comment'])) {
            // echo "theere";

            $comment = trim($_POST['comment']);

            $comment = trim($comment, "\xC2\xA0");

            $comment = str_replace("&nbsp;", '', $comment);
            
            
        }
        if($comment != ""){
            $comment_html_mail = '<p><span style="font-family: Calibri, sans-serif; text-align: var(--bs-body-text-align);background-color: rgb(255, 255, 0);font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;"><u>Comments:</u><br>'.$comment.'<br></spa></p>';

        }
        
        $stage_4 = $this->stage_4_model->where(['pointer_id' => $pointer_id])->asObject()->first();
        $preference_array = $this->stage_3_offline_location_model->where(["city_name" => $stage_4->preference_location, "pratical" => 1])->asObject()->first();
        $preference_location = $preference_array->city_name." - ".$preference_array->location;
        // print_r($preference_location);
        // exit;
        // echo $comment_html_mail;
        // exit;
        
              
            if(isset($_POST['preference_location_stage_4'])){
                $preference_location = $_POST['preference_location_stage_4'];    
            }
            else{
                $preference_location = $stage_4->preference_location;
            }
        // echo $preference_location;
        // exit;
        $comment_update = $this->stage_4_model->where(['pointer_id' => $pointer_id])->set(['preference_location' => $preference_location, 'preference_comment' => $comment])->update();
        
        //
        $name = $s1_personal_details->first_or_given_name;

        if ($status == 'Lodged') {


            
            //  //if any extra docswith tra_receipt
             $comment_store_documents=$this->documents_model->where(['pointer_id' => $pointer_id, "stage" => "stage_4",  "required_document_id" => "0", "employee_id" => "0"])->findAll();
            
            $comment_store_documents = $this->documents_model
            ->where([
                'pointer_id' => $pointer_id,
                'stage' => 'stage_4',
                'employee_id' => 0 // Assuming employee_id is integer type
            ])
            ->groupStart()
                ->where('required_document_id', 0)
                ->orWhere('required_document_id', 49)
            ->groupEnd()
            ->findAll(); 
            
            
            // print_r($comment_store_documents);
            // exit;
            
            // s3_lodged_head_office
            
            if($comment_store_documents){
                $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '223'])->first();    
            }
            else{
                $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '120'])->first();
            }
            
            
            

            $stage_4_ = $this->stage_4_model->where(['pointer_id' => $pointer_id])->first();
           
            $to = env('HEADOFFICE_EMAIL');
            $subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
            
            $message = str_replace("%data%", $comment_html_mail, $mail_temp_1->body);
            
            $message = str_replace("%preference_location%", $preference_location, $message);
            // echo $message;
            // exit;
            // END
            $stage_4_Docs = $this->documents_model->where(['pointer_id' => $pointer_id, 'required_document_id' => 44, 'stage' => "stage_4"])->first();
            $addAttachment__ = array(
                [
                    'file_path' => $stage_4_Docs['document_path'] . '/' . $stage_4_Docs['document_name'],
                    'file_name' => $stage_4_Docs['document_name'],
                ]
            );
            
            
            
            $docs_ids[]="";
            $addAttachment_with_tra[]="";
            
            foreach ($comment_store_documents as $comment_store_documents_) {
                $docs_ids[]=$comment_store_documents_['id'];
                $documents = $this->documents_model->where(['id' => $comment_store_documents_['id'], 'stage' => "stage_4"])->first();
               
                if(!empty($documents)){
                $addAttachment_with_tra = array(
                [
                    'file_path' => $documents['document_path'] . '/' . $documents['document_name'],
                    'file_name' => $documents['document_name'],
                ]
                     );
                 array_push($addAttachment__, ...$addAttachment_with_tra);
                
                    }
            }
            
            
            
            
            // print_r($addAttachment__);
            // exit;
            $mail_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment__);


            if ($mail_check == 1) {
                $admin_status = [
                    'status' => $status,
                    'lodged_date' =>  date("Y-m-d H:i:s"),
                    'lodged_by' => session()->get('admin_id'),
                    'update_date' => date("Y-m-d H:i:s")
                ];
                if ($this->stage_4_model->update($stage_4_id, $admin_status)) {
                    $database_check = 1;
                }
                  delete_by_pointer_id__($pointer_id,'stage_4');
                $pointer_data = [
                    'stage' => 'stage_4',
                    'status' => $status,
                    'update_date' => date("Y-m-d H:i:s")
                ];
                $this->application_pointer_model->update($pointer_id, $pointer_data);
            }
        } elseif ($status == 'Conducted') {

            $admin_status = [

                'status' => $status,

                'conducted_date' => date("Y-m-d H:i:s"),

                'conducted_by' => session()->get('admin_id'),

                'update_date' => date("Y-m-d H:i:s")

            ];

            if ($this->stage_4_model->update($stage_4_id, $admin_status)) {

                $database_check = 1;
            }
             delete_by_pointer_id__($pointer_id,'stage_4');
            $pointer_data = [

                'stage' => 'stage_4',

                'status' => $status,

                'update_date' => date("Y-m-d H:i:s")

            ];

            $this->application_pointer_model->update($pointer_id, $pointer_data);
        } elseif ($status == 'Approved') {



            //-------------------- upload Documnets ---------------------


            $target_file =  'public/application/' . $pointer_id . '/stage_4/approved';

            //-------------------- Qualifications Documnets ---------------------

            if ($s1_occupation->pathway == 'Pathway 1') {

                $upload_qualification_file = $this->request->getFile('upload_qualification_file');

                $qualification_file_basename = $upload_qualification_file->getName();

                $qualification_file_extension = explode(".", $qualification_file_basename);

                $qualification_file_type = $qualification_file_extension[count($qualification_file_extension) - 1];

                $qualification_file_name = 'OTSR - '.$name.'.'. $qualification_file_type;

                $upload_qualification_file->move($target_file, $qualification_file_name);

                // file path need to send with email for applicant and agent

                $qualification_file_path = $target_file . '/' . $qualification_file_name;

                $qualification_data = array(

                    'pointer_id' => $pointer_id,

                    'stage' => 'stage_4',

                    'required_document_id' => 48,

                    'name' => 'OTSR',

                    'document_name' => $qualification_file_name,

                    'document_path' => $target_file,

                    'status' => 1,

                    'update_date' => date("Y-m-d H:i:s"),

                    'create_date' => date("Y-m-d H:i:s")

                );

                $this->documents_model->where([
                    "pointer_id" => $pointer_id, 
                    "stage" => "stage_4", 
                    'required_document_id' => 48
                    ])->delete();

                $this->documents_model->insert($qualification_data);
            }

            //-------------------- Qualifications Documnets end---------------------

            //-------------------- Outcome Letter Documnets ---------------------

            $upload_outcome_file = $this->request->getFile('upload_outcome_file');

            $outcome_file_basename = $upload_outcome_file->getName();

            $outcome_file_extension = explode(".", $outcome_file_basename);

            $outcome_file_type = $outcome_file_extension[count($outcome_file_extension) - 1];

            $outcome_file_name = 'Skills Assessment Result - ' . $name . "." . $outcome_file_type;

            $upload_outcome_file->move($target_file, $outcome_file_name);

            // file path need to send with email for applicant and agent

            $upload_outcome_path = $target_file . '/' . $outcome_file_name;

            $outcome_data = array(

                'pointer_id' => $pointer_id,

                'stage' => 'stage_4',

                'required_document_id' => 47,

                'name' => 'Skills Assessment Result',

                'document_name' => $outcome_file_name,

                'document_path' => $target_file,

                'status' => 1,

                'update_date' => date("Y-m-d H:i:s"),

                'create_date' => date("Y-m-d H:i:s")

            );
            
            
                $this->documents_model->where([
                    "pointer_id" => $pointer_id, 
                    "stage" => "stage_4", 
                    'required_document_id' => 47
                    ])->delete();

            $this->documents_model->insert($outcome_data);

            //-------------------- Outcome Letter Documnets end ---------------------

            //-------------------- upload Documnets end ---------------------        



            $mail_check = 0;

            if ($s1_occupation->pathway == 'Pathway 1') {

                $client_type =  is_Agent_Applicant($pointer_id);

                if ($client_type == "Agent") { // Applicant

                    // s3_agent_p1_approved

                    $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '130'])->first();

                    $subject = mail_tag_replace($mail_temp_4->subject, $pointer_id);

                    $message = mail_tag_replace($mail_temp_4->body, $pointer_id);

                    $addAttachment = array(

                        [

                            'file_path' => $upload_outcome_path,

                            'file_name' => $outcome_file_name

                        ]

                    );

                    if ($s1_occupation->pathway == 'Pathway 1') {

                        array_push($addAttachment, array('file_path' => $qualification_file_path, 'file_name' => $qualification_file_name));
                    }

                    $to =  $user_mail;

                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                    if ($check == 1) {

                        $mail_check = 1;
                    }
                }

                if ($client_type == "Applicant") {

                    // s3_applicant_p1_approved

                    $mail_temp_4 = $this->mail_template_model->asObject()->where(['id' => '147'])->first();

                    $subject = mail_tag_replace($mail_temp_4->subject, $pointer_id);

                    $message = mail_tag_replace($mail_temp_4->body, $pointer_id);

                    $addAttachment = array(

                        [

                            'file_path' => $upload_outcome_path,

                            'file_name' => $outcome_file_name

                        ]

                    );

                    if ($s1_occupation->pathway == 'Pathway 1') {

                        array_push($addAttachment, array('file_path' => $qualification_file_path, 'file_name' => $qualification_file_name));
                    }

                    $to =  $user_mail;

                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                    if ($check == 1) {

                        $mail_check = 1;
                    }
                }
            }

            $mail_check_1 = 0;

            // s4_approved_admin

            $mail_temp_5 = $this->mail_template_model->asObject()->where(['id' => '121'])->first();

            $subject = mail_tag_replace($mail_temp_5->subject, $pointer_id);

            $message = $mail_temp_5->body;

            // new add on 04-04-2023 by vishal as par clint call

            $to =   env('DIPREET_EMAIL');

            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

            if ($check == 1) {

                $mail_check_1 = 1;
            }



            if ($mail_check_1 == 1 && $mail_check == 1) {

                //database record for mail 5 

                $admin_status = [

                    'status' => $status,

                    'approved_date' => date("Y-m-d H:i:s"),

                    'approved_by' => session()->get('admin_id'),

                    'update_date' => date("Y-m-d H:i:s")

                ];





                $database_check =  $this->stage_4_model->update($stage_4_id, $admin_status);
          delete_by_pointer_id__($pointer_id,'stage_4');
                $pointer_data = [

                    'stage' => 'stage_4',

                    'status' => $status,

                    'update_date' => date("Y-m-d H:i:s")

                ];
                
                // Start Here Mohsin

                $database_check =  $this->application_pointer_model->update($pointer_id, $pointer_data);
            }
        } elseif ($status == 'Declined') {

            //-------------------- upload Documnets ---------------------
            $middle_name__ = "";
            if($s1_personal_details->middle_names){
                $middle_name__ = " ".$s1_personal_details->middle_names;
            }

           $name = $s1_personal_details->first_or_given_name.$middle_name__." ".$s1_personal_details->surname_family_name;
            $target_file =  'public/application/' . $pointer_id . '/stage_4/declined';

            //-------------------- Statement of Reasons	Documnets ---------------------

            $reason_file = $this->request->getFile('reason_file');

            $reason_file_basename = $reason_file->getName();
            
            if($reason_file->getName()){
                
             $this->documents_model->where([
                    "pointer_id" => $pointer_id, 
                    "stage" => "stage_4", 
                    'required_document_id' => 46
                    ])->delete();

            $reason_file_extension = explode(".", $reason_file_basename);

            $reason_file_type = $reason_file_extension[count($reason_file_extension) - 1];

            $reason_file_name = 'Statement of Reasons - ' . $name . "." . $reason_file_type;

            $reason_file->move($target_file, $reason_file_name);

            // file path need to send with email for applicant and agent

            $reason_path = $target_file . '/' . $reason_file_name;

            $reason_data = array(

                'pointer_id' => $pointer_id,

                'stage' => 'stage_4',

                'required_document_id' => 46,

                'name' => 'Statement of Reasons',

                'document_name' => $reason_file_name,

                'document_path' => $target_file,

                'status' => 1,

                'update_date' => date("Y-m-d H:i:s"),

                'create_date' => date("Y-m-d H:i:s")

            );
            
            
            $this->documents_model->insert($reason_data);
 
        }else{
                $reason_file = find_one_row_3_field('documents','stage','stage_4','pointer_id',$pointer_id,'required_document_id',46);
            
                $reason_path = $reason_file->document_path."/".$reason_file->document_name;
                $reason_file_name = $reason_file->name;
        
            }
        


            //-------------------- Outcome Letter Documnets ---------------------

            $outcome_file = $this->request->getFile('outcome_file');

            $outcome_file_basename = $outcome_file->getName();

            if($outcome_file->getName()){
                
                 $this->documents_model->where([
                    "pointer_id" => $pointer_id, 
                    "stage" => "stage_4", 
                    'required_document_id' => 45
                    ])->delete();
        
            $outcome_file_extension = explode(".", $outcome_file_basename);

            $outcome_file_type = $outcome_file_extension[count($outcome_file_extension) - 1];

            $outcome_file_name = 'Skills Assessment Result - '.$name.'.'. $outcome_file_type;

            $outcome_file->move($target_file, $outcome_file_name);

            // file path need to send with email for applicant and agent

            $outcome_path = $target_file . '/' . $outcome_file_name;

            $outcome_data = array(

                'pointer_id' => $pointer_id,

                'stage' => 'stage_4',

                'required_document_id' => 45,

                'name' => 'Skills Assessment Result',

                'document_name' => $outcome_file_name,

                'document_path' => $target_file,

                'status' => 1,

                'update_date' => date("Y-m-d H:i:s"),

                'create_date' => date("Y-m-d H:i:s")

            );
            
                        $this->documents_model->insert($outcome_data);

        }else{
                $outcome = find_one_row_3_field('documents','stage','stage_4','pointer_id',$pointer_id,'required_document_id',45);
            
                $outcome_path = $outcome->document_path."/".$outcome->document_name;
                $outcome_file_name = $outcome->name;
        
            }
            

            //-------------------- upload Documnets end ---------------------        



            $mail_check = 0;

            $client_type =  is_Agent_Applicant($pointer_id);

            if ($client_type == "Agent") { // Applicant

                //s3_declined_agent

                $mail_temp_6 = $this->mail_template_model->asObject()->where(['id' => '133'])->first();

                $subject = mail_tag_replace($mail_temp_6->subject, $pointer_id);

                $message = $mail_temp_6->body;

                $message = str_replace('%occupation_reason_for_decline_stage_3%', $reason, $message);

                $message = mail_tag_replace($message, $pointer_id);

                $to =  $user_mail;

                $addAttachment = array(

                    [

                        'file_path' => $outcome_path,

                        'file_name' => $outcome_file_name

                    ], [

                        'file_path' => $reason_path,

                        'file_name' => $reason_file_name

                    ]

                );

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                if ($check == 1) {

                    $mail_check = 1;
                }
            }

            if ($client_type == "Applicant") {

                //s3_declined_applicant

                $mail_temp_6 = $this->mail_template_model->asObject()->where(['id' => '146'])->first();

                $subject = mail_tag_replace($mail_temp_6->subject, $pointer_id);

                $message = $mail_temp_6->body;

                $message = str_replace('%occupation_reason_for_decline_stage_3%', $reason, $message);

                $message = mail_tag_replace($message, $pointer_id);

                $to =  $user_mail;

                $addAttachment = array(

                    [

                        'file_path' => $outcome_path,

                        'file_name' => $outcome_file_name

                    ], [

                        'file_path' => $reason_path,

                        'file_name' => $reason_file_name

                    ]

                );

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);

                if ($check == 1) {

                    $mail_check = 1;
                }
            }



            $mail_check_1 = 0;

            // s4_declined_admin

            $mail_temp_7 = $this->mail_template_model->asObject()->where(['id' => '128'])->first();

            $subject = mail_tag_replace($mail_temp_7->subject, $pointer_id);

            $message = $mail_temp_7->body;

            // new add on 04-04-2023 by vishal as par clint call

            $to =   env('DIPREET_EMAIL');

            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

            if ($check == 1) {

                $mail_check_1 = 1;
            }



            if ($mail_check == 1 && $mail_check_1 == 1) {

                //database record for mail 7       

                $admin_status = [

                    'status' => $status,

                    'declined_date' => date("Y-m-d H:i:s"),

                    'declined_reason' => $reason,

                    'declined_by' => session()->get('admin_id'),

                    'update_date' => date("Y-m-d H:i:s")

                ];

                $database_check = $this->stage_4_model->update($stage_4_id, $admin_status);
                delete_by_pointer_id__($pointer_id,'stage_4');
                $pointer_data = [

                    'stage' => 'stage_4',

                    'status' => $status,

                    'update_date' => date("Y-m-d H:i:s")

                ];

                $database_check =  $this->application_pointer_model->update($pointer_id, $pointer_data);
            }
        } elseif ($status == 'Withdrawn') {

            $mail_check = 0;

            $mail_check_1 = 0;

            $client_type =  is_Agent_Applicant($pointer_id);

            if ($client_type == "Agent") { // Applicant

                // s3_withdrawn_agent

                $mail_temp_7 = $this->mail_template_model->asObject()->where(['id' => '138'])->first();

                $subject = mail_tag_replace($mail_temp_7->subject, $pointer_id);

                $message = mail_tag_replace($mail_temp_7->body, $pointer_id);

                $to =  $user_mail;

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

                if ($check == 1) {

                    $mail_check = 1;
                }
            }

            if ($client_type == "Applicant") {

                // s3_withdrawn_applicant

                $mail_temp_7 = $this->mail_template_model->asObject()->where(['id' => '143'])->first();

                $subject = mail_tag_replace($mail_temp_7->subject, $pointer_id);

                $message = mail_tag_replace($mail_temp_7->body, $pointer_id);

                $to =  $user_mail;

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

                if ($check == 1) {

                    $mail_check = 1;
                }
            }



            // s3_withdrawn_admin

            $mail_temp_8 = $this->mail_template_model->asObject()->where(['id' => '128'])->first();

            $subject = mail_tag_replace($mail_temp_8->subject, $pointer_id);

            $message = $mail_temp_8->body;

            // new add on 04-04-2023 by vishal as par clint call

            $to =   env('DIPREET_EMAIL');

            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

            $to =    env('HEADOFFICE_EMAIL');

            $check_1 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

            if ($check == 1 && $check_1 == 1) {

                $mail_check_1 = 1;
            }



            if ($mail_check_1 == 1 && $mail_check == 1) {

                $admin_status = [

                    'status' => $status,

                    'withdraw_date' => date("Y-m-d H:i:s"),

                    'withdraw_by' => session()->get('admin_id'),

                    'update_date' => date("Y-m-d H:i:s")

                ];

                if ($this->stage_4_model->update($stage_4_id, $admin_status)) {

                    $database_check = 1;
                }
            delete_by_pointer_id__($pointer_id,'stage_4');
                $pointer_data = [

                    'stage' => 'stage_4',

                    'status' => $status,

                    'update_date' => date("Y-m-d H:i:s")

                ];

                $database_check =    $this->application_pointer_model->update($pointer_id, $pointer_data);
            }
        
        }elseif ($status == 'Scheduled') {

            $mail_check = 0;

            $mail_check_1 = 0;

            $client_type =  is_Agent_Applicant($pointer_id);

            if ($client_type == "Agent") { // Applicant

                // s3_withdrawn_agent

                $mail_temp_7 = $this->mail_template_model->asObject()->where(['id' => '131'])->first();

                $subject = mail_tag_replace($mail_temp_7->subject, $pointer_id);

                $message = mail_tag_replace($mail_temp_7->body, $pointer_id);

                $to =  $user_mail;

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

                if ($check == 1) {

                    $mail_check = 1;
                }
            }

            if ($client_type == "Applicant") {

                // s3_withdrawn_applicant

                $mail_temp_7 = $this->mail_template_model->asObject()->where(['id' => '144'])->first();

                $subject = mail_tag_replace($mail_temp_7->subject, $pointer_id);

                $message = mail_tag_replace($mail_temp_7->body, $pointer_id);

                $to =  $user_mail;

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

                if ($check == 1) {

                    $mail_check = 1;
                }
            }



            // s3_withdrawn_admin

            $mail_temp_8 = $this->mail_template_model->asObject()->where(['id' => '128'])->first();

            $subject = mail_tag_replace($mail_temp_8->subject, $pointer_id);

            $message = $mail_temp_8->body;

            // new add on 04-04-2023 by vishal as par clint call

            $to =   env('DIPREET_EMAIL');

            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

            $to =    env('HEADOFFICE_EMAIL');

            $check_1 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

            if ($check == 1 && $check_1 == 1) {

                $mail_check_1 = 1;
            }



            if ($mail_check_1 == 1 && $mail_check == 1) {

                $admin_status = [

                    'status' => $status,

                    'withdraw_date' => date("Y-m-d H:i:s"),

                    'withdraw_by' => session()->get('admin_id'),

                    'update_date' => date("Y-m-d H:i:s")

                ];

                if ($this->stage_4_model->update($stage_4_id, $admin_status)) {

                    $database_check = 1;
                }
            delete_by_pointer_id__($pointer_id,'stage_4');
                $pointer_data = [

                    'stage' => 'stage_4',

                    'status' => $status,

                    'update_date' => date("Y-m-d H:i:s")

                ];

                $database_check =    $this->application_pointer_model->update($pointer_id, $pointer_data);
            }
        
        }elseif ($status == 'Rescheduled') {

            $mail_check = 0;

            $mail_check_1 = 0;

            $client_type =  is_Agent_Applicant($pointer_id);

            if ($client_type == "Agent") { // Applicant

                // s3_withdrawn_agent

                $mail_temp_7 = $this->mail_template_model->asObject()->where(['id' => '132'])->first();

                $subject = mail_tag_replace($mail_temp_7->subject, $pointer_id);

                $message = mail_tag_replace($mail_temp_7->body, $pointer_id);

                $to =  $user_mail;

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

                if ($check == 1) {

                    $mail_check = 1;
                }
            }

            if ($client_type == "Applicant") {

                // s3_withdrawn_applicant

                $mail_temp_7 = $this->mail_template_model->asObject()->where(['id' => '145'])->first();

                $subject = mail_tag_replace($mail_temp_7->subject, $pointer_id);

                $message = mail_tag_replace($mail_temp_7->body, $pointer_id);

                $to =  $user_mail;

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

                if ($check == 1) {

                    $mail_check = 1;
                }
            }



            // s4_shedu_admin

            $mail_temp_8 = $this->mail_template_model->asObject()->where(['id' => '128'])->first();

            $subject = mail_tag_replace($mail_temp_8->subject, $pointer_id);

            $message = $mail_temp_8->body;

            // new add on 04-04-2023 by vishal as par clint call

            $to =   env('DIPREET_EMAIL');

            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

            $to =    env('HEADOFFICE_EMAIL');

            $check_1 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [],[],[],[],$pointer_id);

            if ($check == 1 && $check_1 == 1) {

                $mail_check_1 = 1;
            }



            if ($mail_check_1 == 1 && $mail_check == 1) {

                $admin_status = [

                    'status' => $status,

                    'withdraw_date' => date("Y-m-d H:i:s"),

                    'withdraw_by' => session()->get('admin_id'),

                    'update_date' => date("Y-m-d H:i:s")

                ];

                if ($this->stage_4_model->update($stage_4_id, $admin_status)) {

                    $database_check = 1;
                }

                $pointer_data = [

                    'stage' => 'stage_4',

                    'status' => $status,

                    'update_date' => date("Y-m-d H:i:s")

                ];

                $database_check =    $this->application_pointer_model->update($pointer_id, $pointer_data);
            }
        }





        if ($mail_check == 1 || $database_check == 1) {

            $callback = array(

                "color" => "success",

                "msg" => "mail send succesfully",

                "response" => true,

                'pointer_id' => $pointer_id,

            );
        } else {

            $callback = array(

                "msg" => "mail not send",

                "color" => "danger",

                "response" => false,

                'pointer_id' => $pointer_id,

            );
        }

        echo json_encode($callback);
    
    }
    
}
