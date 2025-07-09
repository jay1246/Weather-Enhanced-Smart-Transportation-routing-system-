<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class verification extends BaseController
{
    public function index($tab = "")
    {
        
        
        $data['title'] = "verification";
        $data["tab"] = $tab;
        $data['page']="Verification";

        $data['applications'] = $this->application_pointer_model->asObject()->where(['stage' => 'stage_2', 'status' => 'Submitted'])->findAll();
        $data['qualification_applications'] = $this->application_pointer_model->asObject()->where(['stage' => 'stage_1', 'status' => 'Submitted'])->findAll();
        $data['stage_2_documents'] = $this->documents_model->asObject()->where(['status' => 1])->findAll();
           
        return view('admin/verification/index', $data);
    }
    public function view($pointer_id)
    {
        $data['title'] = "verification view";
        $applicant = find_one_row('application_pointer', 'id', $pointer_id);
        $data['applicant'] = $this->application_pointer_model->asObject()->where(['id' => $pointer_id])->first();
        $data['stage_1'] = $this->stage_1_model->asObject()->where(['pointer_id' => $pointer_id])->findAll();
        $data['s1_personal_details'] =  $this->stage_1_personal_details_model->asObject()->where(['pointer_id' => $pointer_id])->first();
        $data['s1_contact_details'] =  $this->stage_1_contact_details_model->asObject()->where(['pointer_id' => $pointer_id])->first();
        $data['user_account'] =  $this->user_account_model->asObject()->where('id', $applicant->user_id)->first();
        $data['employs'] =  $this->stage_2_add_employment_model->asObject()->where(['pointer_id' => $pointer_id])->findAll();
        $data['pointer_id'] = $pointer_id;
        $data['stage_1_documents'] = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'status' => 1, 'stage' => 'stage_1'])->findAll();
        // vishal patel 28-04-2023 
        $data['documents'] = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'stage' => 'stage_2'])->findAll();
        
        // print_r($data['employs']);
        // exit;
        
        return view('admin/verification/view', $data);
    }



    public function Change_status($pointer_id, $employer_id, $status)
    { // v
        $sql =  $this->email_verification_model->where(['pointer_id' => $pointer_id, 'employer_id' => $employer_id])->first();
        if (!empty($sql)) {
            if ($status == "Pending") {
                $data = [
                    'is_verification_done' => 1,
                    'verification_email_received' => 1
                ];
            } else {
                $data = [
                    'is_verification_done' => 0,
                    'verification_email_received' => 0
                ];
            }
            // print_r($data);
            // exit;
            $this->email_verification_model->where(['pointer_id' => $pointer_id, 'employer_id' => $employer_id])->set($data)->update();
            $this->session->setFlashdata('msg', 'Status Change Successfully.');
            // return redirect()->back();
            return redirect()->to('admin/verification/view_application/'.$pointer_id); 
        }
        $this->session->setFlashdata('error_msg', 'Sorry! Status Not Change.');
        return redirect()->to('admin/verification/view_application/'.$pointer_id); 
    }

//CODE BY ROHIT 4OCT
     public function edite_and_email_send($pointer_id, $employer_id)
    {
        // echo "test";
        // exit;
         $pointer_id = $_POST['pointer_id'];
         $employer_id = $_POST['employer_id'];
      
        $referee_name = $_POST['referee_name'];
        $referee_email = $_POST['referee_email'];
   //for email Reminder by Rohit
        $stage_2_reminder=find_one_row('stage_2', 'pointer_id', $pointer_id);
        //print_r($stage_2_reminder);
        //for update stage_2 1 refree
    if ($stage_2_reminder->email_reminder_date === null) {
           echo  $currentDateTime = date("Y-m-d H:i:s");
              $data = [
                    'email_reminder_date' => $currentDateTime,
                    
                  ];
                  
               $update_reminder =  $this->stage_2_model->where(['id' => $stage_2_reminder->id,'pointer_id'=>$pointer_id])->set($data)->update();
    
        }
        // vishal patel 28-04-2023
        $addAttachment = [];
        $document_ids = "";
        if (isset($_POST['document_ids'])) {
            $document_ids = json_encode($_POST['document_ids']);
            foreach (json_decode($document_ids) as $key => $value) {
                $documents = $this->documents_model->asObject()->where(['id' => $value, 'stage' => 'stage_2'])->first();
                if (!empty($documents)) {
                    $document_name = $documents->document_name;
                    $document_path = $documents->document_path;
                    // $document_name =  "header_logo.jpg";
                    // $document_path =  "public/assets/image/";
                    $file_name = $documents->name;
                    if (file_exists($document_path . "/" . $document_name)) {
                        $addAttachment[] =
                            [
                                'file_path' => $document_path . "/" . $document_name,
                                'file_name' => $document_name
                            ];
                    }
                }
            }
            $document_ids = json_encode($_POST['document_ids']);
        }
        // ---/---vishal patel 28-04-2023
        
        

        // get data 
        $get_data =  $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id, 'id' => $employer_id])->first();
        if (!empty($get_data)) {
            // update data 
            $data = [
                'referee_name' => $referee_name,
                'referee_email' => $referee_email,
            ];
            $update_check =  $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id, 'id' => $employer_id])->set($data)->update();
            // print_r($update_check);exit;
            if ($update_check) {
                // get data 
                $get_data =  $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id, 'id' => $employer_id])->first();
                // print_r($get_data);exit;
                $referee_name = $get_data['referee_name'];
                $referee_email = $get_data['referee_email'];
                $company_organisation_name = $get_data['company_organisation_name'];

                // email send ------------ s2_send_email_employee
                // $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '45'])->first();
                
                $email_verification = find_one_row('email_verification', 'employer_id', $employer_id);
                 //print_r($email_verification);exit;
                 
                 
            //  if(empty($email_verification))
            //  {
            //      echo "empty";
            //  }else{
            //      echo "data here";
            //  }
            //  exit;
             
            if(!empty($email_verification))
            {
                if($email_verification->is_verification_done == 1)
                {
                     $data = [
                    'verification_email_received' => 0,
                    'is_verification_done' => 0,
                  ];
                  $update_email_verify =  $this->email_verification_model->where(['employer_id' => $employer_id])->set($data)->update();
    
                }
                
            }
             
        //when refree status is TBA then send this below email        
            //if($email_verification->is_verification_done == 0)
            if(empty($email_verification))
            {
                
               $applicant = $this->application_pointer_model->asObject()->where(['id' => $pointer_id])->first();
              
               $user_account =  $this->user_account_model->asObject()->where('id', $applicant->user_id)->first();
                // print_r($user_account);exit;
                 $account_type = $user_account->account_type;
                
                    // $stage_2_reminder->email_reminder_date;
                
              if ($stage_2_reminder->email_reminder_date ==='0000-00-00 00:00:00.000000' || $stage_2_reminder->email_reminder_date == NULL) {
                
                if($account_type == 'Applicant'){
                    
                    //Application mail sending
                        $mail_temp_3_ = $this->mail_template_model->asObject()->where(['id' => '200'])->first();
                        // print_r($mail_temp_3_);exit;
                        $mail_subject_ref = mail_tag_replace($mail_temp_3_->subject, $pointer_id);
                        $mail_body_ref = mail_tag_replace($mail_temp_3_->body, $pointer_id);
                        
                        // $employes_ref = find_one_row('stage_2_add_employment', 'pointer_id', $pointer_id);
                        $employes_ref = find_one_row('application_pointer','id',$pointer_id);
                        
                        $applicant_data = find_one_row('user_account','id',$employes_ref->user_id);
                        // print_r($applicant_data);exit;
                        $to_ref = $applicant_data->email;
                        // $to_ref = $employes_ref->referee_email;
                        // $to_ref =  $referee_email;
                         
                        $check_reff = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to_ref, $mail_subject_ref, $mail_body_ref, [], [], [], []);
                }   
                
                if($account_type == 'Agent'){
        
                    $mail_temp_agent_ = $this->mail_template_model->asObject()->where(['id' => '199'])->first();
                    $mail_subject_agent = mail_tag_replace($mail_temp_agent_->subject, $pointer_id);
                    $mail_body_agent = mail_tag_replace($mail_temp_agent_->body, $pointer_id);
                    
                    $employes_ref = find_one_row('application_pointer','id',$pointer_id);
                        
                        $applicant_data = find_one_row('user_account','id',$employes_ref->user_id);
                        // print_r($applicant_data);exit;
                        $to_agent = $applicant_data->email;
                    
                    // $to_agent = $user_account->email;
                    //  $to_agent =  $referee_email;
                    $check_agent = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to_agent, $mail_subject_agent, $mail_body_agent, [], [], [], []);
                }   
                
            }
            }
            
               
                
                
                
                $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '102'])->first();
                $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
                $mail_body = mail_tag_replace($mail_temp_1->body, $pointer_id);



                $documents = $this->documents_model->asObject()->where(['employee_id' => $employer_id, 'pointer_id' => $pointer_id, 'required_document_id' => 10])->first();
                if (!empty($documents)) {
                    $document_name = $documents->document_name;
                    $document_path = $documents->document_path;
                    $file_name = $documents->name;
                    if (file_exists($document_path . "/" . $document_name)) {
                        // vishal patel 28-04-2023
                        $addAttachment[] = [
                            'file_path' => $document_path . "/" . $document_name,
                            'file_name' => $document_name
                        ];
                    }
                }
                $document_2 = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'required_document_id' => 6])->first();
                    if (!empty($document_2)) {
                        $document_name = $document_2->document_name;
                        $document_path = $document_2->document_path;
                        $file_name = $document_2->name;
                        if (file_exists($document_path . "/" . $document_name)) {
                            $addAttachment[] = [
                                'file_path' => $document_path . "/" . $document_name,
                                'file_name' => $document_name
                            ];
                        }
                    }
                
                $subject = str_replace('%add_employment_company_name%', $company_organisation_name, $mail_subject);
                $message = str_replace('%add_employment_referee_name%', $referee_name, $mail_body);
                $to = $referee_email;
                $check = verification_(env('SERVER_EMAIL'), env('verification_SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment, $pointer_id);
                // after email send 
                if ($check == 1) {
                    // update data 
                    // vishal 17-04-2023
                    $check_table =  $this->email_verification_model->where(['pointer_id' => $pointer_id, 'employer_id' => $employer_id])->first();
                    if (!empty($check_table)) {
                        // $this->email_verification_model->asObject()->where('pointer_id', $pointer_id)->findAll();
                        // vishal patel 28-04-2023
                        $data = array(
                            'verification_email_id' => $referee_email,
                            'verification_email_send' => 1,
                            'verification_email_send_date' => date("Y-m-d H:i:s"),
                            'document_ids' => $document_ids,
                            'update_date' => date("Y-m-d H:i:s"),
                            'email_reminder_date'=>date("Y-m-d H:i:s")
                        );
                        $update_email_verify =  $this->email_verification_model->where(['pointer_id' => $pointer_id, 'employer_id' => $employer_id])->set($data)->update();
                    } else {
                        // vishal 17-04-2023
                        // vishal patel 28-04-2023
                        
                        $data = array(
                            'pointer_id' => $pointer_id,
                            'verification_type' => 'Verification Email - Employment',
                            'employer_id' => $employer_id,
                            'verification_email_id' => $referee_email,
                            'verification_email_subject' => $subject,
                            'verification_email_send' => 1,
                            'verification_email_send_date' => date("Y-m-d H:i:s"),
                            'document_ids' => $document_ids,
                            'update_date' => date("Y-m-d H:i:s"),
                            'create_date' => date("Y-m-d H:i:s"),
                            'email_reminder_date'=>date("Y-m-d H:i:s")
                        );
                        $update_email_verify = $this->email_verification_model->insert($data);
                    }


                    if ($update_email_verify) {
                        $this->session->setFlashdata('error_msg', 'Information is updated and Email sent to ' . $referee_name);
                        return redirect()->to('admin/verification/view_application/'.$pointer_id);
                        // return redirect()->back();
                    }
                } else {

                    $this->session->setFlashdata('error_msg', 'Sorry! email service is not working,');
                }
            
               
                
                
            } else {
                $this->session->setFlashdata('error_msg', 'Sorry! Referee Info Not Update.');
            }
        } else {
            $this->session->setFlashdata('error_msg', 'Sorry! Referee Not Find');
        }

        return redirect()->to('admin/verification/view_application/'.$pointer_id);
        // return redirect()->back();
    }
    
    
    public function edite_and_email_send_old($pointer_id, $employer_id)
    {
        // echo "test";
        // exit;
        $pointer_id = $_POST['pointer_id'];
        $employer_id = $_POST['employer_id'];
        $referee_name = $_POST['referee_name'];
        $referee_email = $_POST['referee_email'];

        // vishal patel 28-04-2023
        $addAttachment = [];
        $document_ids = "";
        if (isset($_POST['document_ids'])) {
            $document_ids = json_encode($_POST['document_ids']);
            foreach (json_decode($document_ids) as $key => $value) {
                $documents = $this->documents_model->asObject()->where(['id' => $value, 'stage' => 'stage_2'])->first();
                if (!empty($documents)) {
                    $document_name = $documents->document_name;
                    $document_path = $documents->document_path;
                    // $document_name =  "header_logo.jpg";
                    // $document_path =  "public/assets/image/";
                    $file_name = $documents->name;
                    if (file_exists($document_path . "/" . $document_name)) {
                        $addAttachment[] =
                            [
                                'file_path' => $document_path . "/" . $document_name,
                                'file_name' => $document_name
                            ];
                    }
                }
            }
            $document_ids = json_encode($_POST['document_ids']);
        }
        // ---/---vishal patel 28-04-2023


        // get data 
        $get_data =  $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id, 'id' => $employer_id])->first();
        if (!empty($get_data)) {
            // update data 
            $data = [
                'referee_name' => $referee_name,
                'referee_email' => $referee_email,
            ];
            $update_check =  $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id, 'id' => $employer_id])->set($data)->update();
            if ($update_check) {
                // get data 
                $get_data =  $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id, 'id' => $employer_id])->first();
                $referee_name = $get_data['referee_name'];
                $referee_email = $get_data['referee_email'];
                $company_organisation_name = $get_data['company_organisation_name'];

                // email send ------------ s2_send_email_employee
                // $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '45'])->first();
                $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '102'])->first();
                $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
                $mail_body = mail_tag_replace($mail_temp_1->body, $pointer_id);



                $documents = $this->documents_model->asObject()->where(['employee_id' => $employer_id, 'pointer_id' => $pointer_id, 'required_document_id' => 10])->first();
                if (!empty($documents)) {
                    $document_name = $documents->document_name;
                    $document_path = $documents->document_path;
                    $file_name = $documents->name;
                    if (file_exists($document_path . "/" . $document_name)) {
                        // vishal patel 28-04-2023
                        $addAttachment[] = [
                            'file_path' => $document_path . "/" . $document_name,
                            'file_name' => $document_name
                        ];
                    }
                }
                $document_2 = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'required_document_id' => 6])->first();
                    if (!empty($document_2)) {
                        $document_name = $document_2->document_name;
                        $document_path = $document_2->document_path;
                        $file_name = $document_2->name;
                        if (file_exists($document_path . "/" . $document_name)) {
                            $addAttachment[] = [
                                'file_path' => $document_path . "/" . $document_name,
                                'file_name' => $document_name
                            ];
                        }
                    }
                
                $subject = str_replace('%add_employment_company_name%', $company_organisation_name, $mail_subject);
                $message = str_replace('%add_employment_referee_name%', $referee_name, $mail_body);
                $to = $referee_email;
                $check = verification_(env('SERVER_EMAIL'), env('verification_SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment, $pointer_id);
                // after email send 
                if ($check == 1) {
                    // update data 
                    // vishal 17-04-2023
                    $check_table =  $this->email_verification_model->where(['pointer_id' => $pointer_id, 'employer_id' => $employer_id])->first();
                    if (!empty($check_table)) {
                        // $this->email_verification_model->asObject()->where('pointer_id', $pointer_id)->findAll();
                        // vishal patel 28-04-2023
                        $data = array(
                            'verification_email_id' => $referee_email,
                            'verification_email_send' => 1,
                            'verification_email_send_date' => date("Y-m-d H:i:s"),
                            'document_ids' => $document_ids,
                            'update_date' => date("Y-m-d H:i:s")
                        );
                        $update_email_verify =  $this->email_verification_model->where(['pointer_id' => $pointer_id, 'employer_id' => $employer_id])->set($data)->update();
                    } else {
                        // vishal 17-04-2023
                        // vishal patel 28-04-2023
                        $data = array(
                            'pointer_id' => $pointer_id,
                            'verification_type' => 'Verification Email - Employment',
                            'employer_id' => $employer_id,
                            'verification_email_id' => $referee_email,
                            'verification_email_subject' => $subject,
                            'verification_email_send' => 1,
                            'verification_email_send_date' => date("Y-m-d H:i:s"),
                            'document_ids' => $document_ids,
                            'update_date' => date("Y-m-d H:i:s"),
                            'create_date' => date("Y-m-d H:i:s")
                        );
                        $update_email_verify = $this->email_verification_model->insert($data);
                    }


                    if ($update_email_verify) {
                        $this->session->setFlashdata('error_msg', 'Information is updated and Email sent to ' . $referee_name);
                        return redirect()->back();
                    }
                } else {

                    $this->session->setFlashdata('error_msg', 'Sorry! email service is not working,');
                }
            } else {
                $this->session->setFlashdata('error_msg', 'Sorry! Referee Info Not Update.');
            }
        } else {
            $this->session->setFlashdata('error_msg', 'Sorry! Referee Not Find');
        }

        return redirect()->back();
    }
    
    public function edit_qualification_verification_form()
    {
        $pointer_id = $this->request->getPost('pointer_id');
        $email_id = $this->request->getPost('email_id');
        $prn =portal_reference_no($pointer_id);
        $email_to = $this->request->getPost('email');
        $email_cc = $this->request->getPost('email_cc');
        $post_document_ids = $this->request->getPost('document_ids');
        // $file = $this->request->getFile('extra_file');
        // echo $prn;
        // exit;
        $addAttachment = [];
        // echo "SDSfds";
        $array_documnet_id = [];
        if($post_document_ids){
        foreach($post_document_ids as $document_id){
           $array_documnet_id[] = $document_id;
        }
        }
            // echo "fdzd";
            // if($file['error'] === UPLOAD_ERR_OK) {
            // if ($file && $file->isValid()) {

        // if($file){
            // echo "sdvgdv";
        //     $uploaded_filename =  $file->getName();
        //     $File_extention = $file->getClientExtension();
        //     // $original_file_name = str_replace($uploaded_filename, 'Verification - Employment.' . $File_extention, $uploaded_filename);
        //     $target = 'public/application/' . $pointer_id . '/stage_1';
        //     $extra_doc = find_one_row_2_field('documents','pointer_id',$pointer_id,'required_document_id',50);
        //     if($extra_doc){
        //         unlink($extra_doc->document_path.'/'.$extra_doc->document_name);
        //         $id = $extra_doc->id;
        //         $file->move($target, $uploaded_filename, true);
        //         $addition_data = array(
        //             'document_name' => $uploaded_filename,
        //             'document_path' => $target,
        //             'update_date' => date("Y-m-d H:i:s"),
        //         );
        //         if ($this->documents_model->update($id,$addition_data)) {
        //              $addAttachment[] =
        //                 [
        //                     'file_path' => $target . "/" . $uploaded_filename,
        //                     'file_name' => $uploaded_filename
        //                 ];
        //         }
        //     }else{
        //         $file->move($target, $uploaded_filename, true);
                
        //         $addition_data = array(
        //             'pointer_id' => $pointer_id,
        //             'stage' => 'stage_1',
        //             'required_document_id' => 50,
        //             'employee_id' => 0,
        //             'name' => 'Extra file with email qualification',
        //             'document_name' => $uploaded_filename,
        //             'document_path' => $target,
        //             'status' => 1,
        //             'update_date' => date("Y-m-d H:i:s"),
        //             'create_date' => date("Y-m-d H:i:s")
        //         );
        //         if ($this->documents_model->insert($addition_data)) {
        //             $lastInsertedId = $this->documents_model->insertID();
        //             // echo "Last inserted ID: " . $lastInsertedId;
        //             $array_documnet_id[] =  $lastInsertedId;
        //             $addAttachment[] =
        //                 [
        //                     'file_path' => $target . "/" . $uploaded_filename,
        //                     'file_name' => $uploaded_filename
        //                 ];
        //         }
        //     }
        // }
        $user = find_one_row('application_pointer', 'id', $pointer_id);

        // email send data ------------
        $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '149'])->first();
        $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
        $mail_body = mail_tag_replace($mail_temp_1->body, $pointer_id);
        $mail_check = 0;
        $database_check = 0;
            // email send ------------
            $subject = str_replace('%PRN%', $prn, $mail_subject);
            $message = $mail_body;
            $to = $email_to;
            if (isset($post_document_ids)) {
                foreach ($post_document_ids as $post_doc_id) {
                    $document = $this->documents_model->asObject()->where(['id' => $post_doc_id, 'stage' => 'stage_1'])->first();
                    if (!empty($document)) {
                        $document_name = $document->document_name;
                        $document_path = $document->document_path;
                        $file_name = $document->name;
                        if (file_exists($document_path . "/" . $document_name)) {
                            $addAttachment[] =
                            [
                                'file_path' => $document_path . "/" . $document_name,
                                'file_name' => $document_name
                            ];
                        }
                    }
                }
            }
            $extra_files = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'required_document_id' => 50,'stage' => 'stage_1'])->findAll();
            foreach ($extra_files as $extra_file) {
                    if (!empty($extra_file)) {
                        $document_name = $extra_file->document_name;
                        $document_path = $extra_file->document_path;
                        $file_name = $extra_file->name;
                        if (file_exists($document_path . "/" . $document_name)) {
                            $addAttachment[] =
                            [
                                'file_path' => $document_path . "/" . $document_name,
                                'file_name' => $document_name
                            ];
                        }
                    }
                }
            $fix_document = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'required_document_id' => 6])->first();
            if (!empty($fix_document)) {
                $document_name = $fix_document->document_name;
                $document_path = $fix_document->document_path;
                $file_name = $fix_document->name;
                if (file_exists($document_path . "/" . $document_name)) {
                    $array_documnet_id[] = $fix_document->id;
                    $addAttachment[] = [
                        'file_path' => $document_path . "/" . $document_name,
                        'file_name' => $document_name
                    ];
                }
            }
            // print_r($array_documnet_id);
            // $result .= implode(', ', $array1);

           
            $string_documnet_ids = implode(', ', $array_documnet_id);
            $array = explode(", ", $string_documnet_ids);  // Convert string to array
            $uniqueArray = array_unique($array);  // Remove duplicates from the array
            $unique_string_documnet_ids = implode(", ", $uniqueArray);  // Convert array back to a string

            $string_email_cc = implode(', ', $email_cc);
            $array_cc = explode(", ", $string_email_cc);  // Convert string to array
            $uniqueArray_cc = array_unique($array_cc);  // Remove duplicates from the array
            $unique_string_email_cc = implode(", ", $uniqueArray_cc);  // Convert array back to a string
            
            if(empty($string_email_cc)){
                // echo "fhfdh";
                $uniqueArray_cc = [];
            }
           
            $check = verification_(env('SERVER_EMAIL'), env('verification_SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $uniqueArray_cc, $addAttachment, $pointer_id);
            $database_entry = 0;
            if ($check == 1) {
                $data_verf = array(
                    'verification_email_id' => $email_to,
                    'verification_email_subject' => $subject,
                    'email_cc_id'=>$unique_string_email_cc,
                    'verification_email_send' => 1,
                    'document_ids' => $unique_string_documnet_ids,
                    'verification_email_send_date' => date("Y-m-d H:i:s"),
                    'update_date' => date("Y-m-d H:i:s"),
                );
                // print_r($data_verf);
                // exit;
                if ($this->email_verification_model->update($email_id,$data_verf)) {
                    $database_entry = 1;
                }
            }// check email send
            if($database_entry == 1){
                $callback = array(
                        'mail_check' => $mail_check,
                        'database_check' => $database_check,
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
     public function change_status_quali()
    { 
        
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Retrieve data from the $_POST superglobal
//     print_r($_POST);
//     exit;
//     $id = $_POST['id'];
//     $status = $_POST['status'];
// echo $id;
// echo $status;
//     // Process the data
//     // ...
// }
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
            // echo $status; 
            // echo $id;
            // exit;
        $sql =  $this->email_verification_model->where(['id' => $id])->first();
        $database_entry = 0;
        if (!empty($sql)) {
            if ($status == "Pending") {
                $data = [
                    'is_verification_done' => 1,
                    'verification_email_received' => 1
                ];
            } else {
                $data = [
                    'is_verification_done' => 0,
                    'verification_email_received' => 0
                ];
            }
            // where(['id' => $id])->set($data)->
            // print_r($data);
            if($this->email_verification_model->update($id,$data)){
               $database_entry = 1; 
            };
        }
            
            if($database_entry == 1){
                $callback = array(
                        "color" => "success",
                        "msg" => "database updated succesfully",
                        "response" => true,
                    );
            } else {
                $callback = array(
                    "color" => "danger",
                    "msg" => "database not updated ",
                    "response" => false,
                );
            }
        echo json_encode($callback);

        }
   

}
