<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

// stage 4 ---------------------------------------- 

class s4_receipt_upload extends BaseController
{
    
    
    public function comment_file_upload(){
        $pointer_id = $this->request->getPost("pointer_id");
        $id = $this->request->getPost("id");
        $file_exemption_uploaded = $this->request->getFile("file");
        // echo $pointer_id;
        // 
        
        $file_name_with_extention_of_exemption ="";
        if ($file_exemption_uploaded) {

            if($file_exemption_uploaded->getName()){
                // echo $file_exemption_uploaded->getName();
                // exit;
                $comment_store_documents_data = $this->comment_store_documents_model->find($id);
                $file_exemption_uploaded_extention = $file_exemption_uploaded->getClientExtension();
                // echo $file_exemption_uploaded_extention;
                // exit;
                // $file_exemption_required = $this->required_documents_list_model->where(["stage" =>"stage_3",'category'=>'exemption_form'])->first();
                
                $folder_path_exemption = 'public/application/'.$pointer_id .'/stage_4';
                // $document_name_exemption = $file_exemption_required["document_name"];
                $file_name_with_extention_of_exemption = $comment_store_documents_data["name"].".".$file_exemption_uploaded_extention;
                if (!is_dir($folder_path_exemption)) {
                    mkdir($folder_path_exemption);
                }
                // move file to folder
                $is_move_exemption_file = $file_exemption_uploaded->move($folder_path_exemption, $file_name_with_extention_of_exemption, true);
                // echo $is_move_exemption_file;
                // exit;
                
                 $file_exemption_document = [
                            'pointer_id' => $pointer_id,
                            'stage' => 'stage_4',
                            'required_document_id' => 0,
                            'name' => $comment_store_documents_data["name"],
                            'document_name' => $file_name_with_extention_of_exemption,
                            'document_path' => $folder_path_exemption,
                            'document_type' => '',
                            'status' => 1
                        ];
                  $last_update_record = $this->documents_model->insert($file_exemption_document);
                  $this->comment_store_documents_model->update($id, ["document_id" => $last_update_record]);
                  
                  echo json_encode([
                      'name' => $comment_store_documents_data["name"],
                      'document_name' => $file_name_with_extention_of_exemption,
                      'document_path' => $folder_path_exemption,
                      'document_id' => $last_update_record,
                      'full_path' => base_url()."/".$folder_path_exemption."/".$file_name_with_extention_of_exemption,
                      ]);
                    //   exit;
                }
        }
        // 
        // 
    }
    
    public function receipt_upload_page($ENC_pointer_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $stage_4 = $this->stage_4_model->where("pointer_id", $pointer_id)->first();
        // if (empty($stage_4)) {
        //     $this->stage_4_model->insert(['pointer_id' => $pointer_id, 'status' => 'Start']);
        // }
        // echo $pointer_id;
        // exit;
        $stage_4 = $this->stage_4_model->where("pointer_id", $pointer_id)->first();
        $status = (!empty($stage_4['status']) ? $stage_4['status'] : ""); 
        // echo $status;
        // exit;
        if ($status == "" || $status == "Start"|| $status=="Submitted") {
            $receipt_number = (!empty($stage_4['receipt_number']) ? $stage_4['receipt_number'] : "");
            $payment_date = "";
            if (!empty($stage_4['payment_date']) && $stage_4['payment_date'] != "0000-00-00 00:00:00") {
                $payment_date = (!empty($stage_4['payment_date']) ?  date("d/m/Y", strtotime($stage_4['payment_date'])) : "");
            }
            $preference_location =  (!empty($stage_4['preference_location']) ? $stage_4['preference_location'] : "");
            $preference_comment = (!empty($stage_4['preference_comment']) ? $stage_4['preference_comment'] : "");

            $documents = $this->documents_model->where(["pointer_id" => $pointer_id, 'stage' => 'stage_4'])->first();
            $document_full_name = (isset($documents['document_name']) ? $documents['document_name'] : "");
            $document_path = (isset($documents['document_path']) ? $documents['document_path'] : "");
            $document_name = (isset($documents['name']) ? $documents['name'] : "");
            if (!empty($document_name)) {
                $file_uploaded = true;
            } else {
                $file_uploaded = false;
            }


           $offline_locations = $this->stage_3_offline_location_model->where('pratical',1)->find();
            $country = array();
            foreach ($offline_locations as $key => $value) {
                if (!in_array($value['country'], $country)) {
                    $country[] = $value['country'];
                }
            }
            $location = array();
            foreach ($country as $key => $value) {
                $offline_location = $this->stage_3_offline_location_model->where(['country' => $value,'pratical'=>1])->find();
                $location[$value] = $offline_location;
            }


            
            // 
            $comment_store_documents = $this->comment_store_documents_model->where(["pointer_id" => $pointer_id, "stage" => "stage_3"])->findAll();
            // print_r($comment_store_documents);
            // exit;
            // 
            
            $data["comment_store_documents"] = $comment_store_documents;


            $data["page"] = 'TRA Payment Receipt Number';
            $data["pointer_id"] = $pointer_id;
            $data["ENC_pointer_id"] = $ENC_pointer_id;
            $data["receipt_number"] = $receipt_number;
            $data["payment_date"] = $payment_date;
            $data["preference_location"] = $preference_location;
            $data["preference_comment"] = $preference_comment;
            $data["document_name"] = $document_name;
            $data["document_full_name"] = $document_full_name;
            $data["document_path"] = $document_path;
            $data["file_uploaded"] = $file_uploaded;
            $data["location"] = $location;
            // echo "<pre>";
            // print_r($data);
            // exit;
            return view('user/stage_4/receipt_upload', $data);
        }
        // return view('user/dashboard');
        return redirect()->to('user/dashboard');
    }
    
    
    public function save_Preferred_info_($ENC_pointer_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        
        $data = $this->request->getVar();
            $preference_comment = $data['preference_comment'];
            $preference_location = $data['preference_location'];
            $recipt_number = $data['recipt_number'];
            $payment_date = $data['payment_date'];
            
        $stage_4 = $this->stage_4_model->where("pointer_id", $pointer_id)->first();
        if(!empty($data)){
            if (empty($stage_4)) {
                $this->stage_4_model->insert(['pointer_id' => $pointer_id, 'status' => 'Start']);
            }
        }
       
        if (!empty($payment_date)) {
            $payment_date =  date("Y-m-d h:i:s", strtotime($payment_date));
        }


        $details = [
            'preference_comment' => $preference_comment,
            'preference_location' => $preference_location,
            "receipt_number" => $recipt_number,
            "payment_date" => $payment_date,
            
        ];
        $stage_3 = $this->stage_4_model->where("pointer_id", $pointer_id)->set($details)->update();
        if ($stage_3) {
            echo "done";
        } else {
            echo "sorry";
        }
    }

    // ajax ----------
    public function get_addresh_()
    {
        $city_name = $_POST['city_name'];
        $offline_locations = $this->stage_3_offline_location_model->where('city_name', $city_name)->first();
        return json_encode($offline_locations);
    }
    

    // ajax ----------
    public function receipt_upload_action($ENC_pointer_id)
    {
        // Start Session
        $session = session();
        // 
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $recipt_number =  $this->request->getPost('recipt_number');

        $payment_date =  $this->request->getPost('payment_date');
        $preference_comment =  $this->request->getPost('preference_comment');

        $payment_date = str_replace('/', '-', $payment_date);
        if (!empty($payment_date)) {
            $payment_date =  date("Y-m-d h:i:s", strtotime($payment_date));
        }

        // file data and file name 
        $file =  $this->request->getFile('recipt');


        $File_extention = $file->getClientExtension();
        $docs_db = $this->required_documents_list_model->where("id", 44)->first();
        if(!empty($docs_db)){
             $folder_path = 'public/application/' . $pointer_id . '/stage_4';
        $document_name = $docs_db["document_name"];
        $file_name_with_extantion = $document_name . '.' . $File_extention;
        if (!is_dir($folder_path)) {
            mkdir($folder_path);
        }
        // move file to folder 
        $is_move = $file->move($folder_path, $file_name_with_extantion, true);
       
        }
        else{
            $is_move=true;
        }
        if ($is_move) {
            
            
        } else {
            $this->session->setFlashdata('error_msg', 'Sorry! File Not Uploaded.');
        }

            $data = [
                'preference_comment' => $preference_comment,
                // 'preference_location' => $preference_location,
                "receipt_number" => $recipt_number,
                "payment_date" => $payment_date,
                "submitted_by"  => $session->user_id,
            ];
            if ($this->stage_4_model->set($data)->where('pointer_id', $pointer_id)->update()) {
                $data_docs = [
                    "pointer_id" => $pointer_id,
                    "stage" => 'stage_4',
                    "required_document_id" => $docs_db["id"],
                    "name" => $docs_db["document_name"],
                    "document_name" => $file_name_with_extantion,
                    "document_path" => $folder_path,
                    "status" => 1,
                ];

                if ($this->documents_model->insert($data_docs)) {
                    $this->session->setFlashdata('msg', 'File Uploaded Successfully.');
                } else {
                    $this->session->setFlashdata('error_msg', 'File Uploading Error.');
                }
            }
       
        return redirect()->back();
    }

    public function receipt_upload_getData($ENC_pointer_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $stage_4__ = $this->stage_4_model->where("pointer_id", $pointer_id)->first();
        $docs = $this->documents_model->where([
            "pointer_id" => $pointer_id,
            "stage" => "stage_4",
        ])->first();
        $output = [];
        if ($docs) {
            $output = [
                "name" => $docs["name"],
                "path" => base_url() . "/" . $docs["document_path"] . "/" . $docs["document_name"],
                "pointer_id" => $docs["pointer_id"],
                "receipt_number" => $stage_4__["receipt_number"],
                "payment_date" => date("d/m/y", strtotime($stage_3__["payment_date"])),
            ];
        }
        echo json_encode($output);
    }

    // working
    function receipt_upload_delete($ENC_pointer_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        // $data = [
        //     'receipt_number' => '',
        //     'payment_date' => '',
        //     'preference_location' => '',
        //     'preference_comment' => '',
        // ];
        // if ($this->stage_4_model->where("pointer_id", $pointer_id)->set($data)->update()) {
            $documents = $this->documents_model->where(['stage' => 'stage_4', 'pointer_id' => $pointer_id])->first();
            if (!empty($documents)) {
                $file_path =  $documents['document_path'] . '/' . $documents['document_name'];
                if (file_exists($file_path)) {
                    if (unlink($file_path)) {
                        if ($this->documents_model->where(['stage' => 'stage_4', 'pointer_id' => $pointer_id])->delete()) {
                            $this->session->setFlashdata('msg', 'File Deleted Successfully.');
                        }
                    }
                } else {
                    if ($this->documents_model->where(['stage' => 'stage_4', 'pointer_id' => $pointer_id])->delete()) {
                        $this->session->setFlashdata('msg', 'File Deleted Successfully.');
                    }
                }
            } else {
                $this->session->setFlashdata('error_msg', 'Sorry! File Not Found.');
            }
        // }

        return redirect()->back();
    }



    function stage_4_submit_($ENC_pointer_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        // echo $pointer_id;
        $is_update = $this->stage_4_model->set([
            "status" => "Submitted",
            "submitted_date" => date("Y-m-d H:i:s"),
        ])->where("pointer_id", $pointer_id)->update();


        // email -----------------------------------------------------------------
        // no reply to applicant or agent  -------------------
        $email = "";
        $stage_1_contact_details_ = $this->stage_1_contact_details_model->where(['pointer_id' => $pointer_id])->first();
        if (!empty($stage_1_contact_details_)) {
            $email = $stage_1_contact_details_['email'];
        } // Applicant email

        $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->first();
        if (!empty($application_pointer)) {
            $user_id = $application_pointer['user_id'];
            $user_account = $this->user_account_model->where(['id' => $user_id])->first();
            if (!empty($user_account)) {
                $email = $user_account['email'];
            }
        } // agent email


        if (!empty($email)) {
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") { // Applicant
                // s3_submitted_agent
                $mail_temp_4 = $this->mail_template_model->where(['id' => '129'])->first();
                if (!empty($mail_temp_4)) {
                    $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                    $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                    $to =  $email;
                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], [], $pointer_id);
                    if ($check == 1) {
                        $email_send_agent_applicant = true;
                    }
                } // email template
            }
            if ($client_type == "Applicant") { // 
                // s3_submitted_applicant
                $mail_temp_4 = $this->mail_template_model->where(['id' => '142'])->first();
                if (!empty($mail_temp_4)) {
                    $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                    $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                    $to =  $email;
                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], [], $pointer_id);
                    if ($check == 1) {
                        $email_send_agent_applicant = true;
                    }
                } // email template
            }
        } // email


        //s3_submitted_admin
        $mail_temp_4 = $this->mail_template_model->where(['id' => '122'])->first();
        if (!empty($mail_temp_4)) {
            $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
            $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
            $stage_4_ = $this->stage_4_model->where(['pointer_id' => $pointer_id])->first();
                $preference_location_name ="";
            $preference_location_comment = "";
            if (!empty($stage_4_)) {
            //   echo $stage_4_['preference_location'];
                $location =find_one_row("stage_3_offline_location","city_name",$stage_4_['preference_location']);
                // print_r($location);
                //               exit;

                $preference_location = trim($location->city_name)." - ".trim($location->location);
                $preference_comment = trim($stage_4_['preference_comment']);
                $preference_comment = trim($preference_comment, "\xC2\xA0");
                $preference_comment = str_replace("&nbsp;", '', $preference_comment);
                // echo $preference_location;
                // exit;
                if (!empty($preference_location)) {
                    $preference_location_name .=  "Practical Assessment Venue : ".$preference_location;
                }
            }
            
            if (!empty($preference_comment)) {
                $preference_location_comment .= '<u> Comments: </u><br><i>\'"' . $preference_comment . '"\'</i></b>';
            }

            $stage_4_Docs = $this->documents_model->where(['pointer_id' => $pointer_id, 'required_document_id' => 44, 'stage' => "stage_4"])->first();
            $addAttachment = array(
                [
                    'file_path' => $stage_4_Docs['document_path'] . '/' . $stage_4_Docs['document_name'],
                    'file_name' => $stage_4_Docs['document_name'],
                ]
            );
                // echo $preference_location_comment;
                // echo $preference_location_name;
            $message= str_replace('%preference_comment%', $preference_location_comment, $message);
            $message = str_replace('%preference_location%', $preference_location_name, $message);
            $message = trim($message);
            // echo $message;
            // exit;
            
               $comment_store_documents=$this->comment_store_documents_model->where(['pointer_id' => $pointer_id])->findAll();
            
            $docs_ids[]="";
            $addAttachment_with_tra[]="";
            
            foreach ($comment_store_documents as $comment_store_documents_) {
                $docs_ids[]=$comment_store_documents_['document_id'];
                $documents = $this->documents_model->where(['id' => $comment_store_documents_['document_id'], 'stage' => "stage_4"])->first();
               
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
            
            
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'),  env('ADMIN_EMAIL'), $subject, $message, [], [], [], $addAttachment, $pointer_id);
            if ($check == 1) {
                $email_send_admin = true;
            }
        }

        if ($email_send_agent_applicant && $email_send_admin) {
            if ($is_update) {
                $is_pointer_update = $this->application_pointer_model->set([
                    "stage" => "stage_4",
                    "status" => "Submitted",
                ])->where("id", $pointer_id)->update();
                // Do here Mail Code
                // End Do here Mail Code
                if ($is_pointer_update) {
                    $json = [
                        "error" => 0,
                        "msg"   => "Submitted Successfully",
                    ];
                }
            }
        }

        return redirect()->to(base_url('user/view_application/' . $ENC_pointer_id));
    }

}
