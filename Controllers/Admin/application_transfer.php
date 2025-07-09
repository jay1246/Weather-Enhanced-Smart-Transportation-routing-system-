<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Dompdf\Dompdf;

class application_transfer extends BaseController
{
    public function application_transfer($pointer_id)
    {
        $data = [];
        $application_pointer = find_one_row('application_pointer', 'id', $pointer_id);
        $stage_1_personal_details = find_one_row('stage_1_personal_details', 'pointer_id', $pointer_id);
        $data['application_preferred_title'] = $stage_1_personal_details->preferred_title;
        $data['application_first_or_given_name'] = $stage_1_personal_details->first_or_given_name;
        $data['application_middle_names'] = $stage_1_personal_details->middle_names;
        $data['application_surname_family_name'] = $stage_1_personal_details->surname_family_name;
        $stage_1_contact_details = find_one_row('stage_1_contact_details', 'pointer_id', $pointer_id);
        $data['application_email'] = $stage_1_contact_details->email;
        $data['application_mobile_number_code'] = country_phonecode($stage_1_contact_details->mobile_number_code);
        $data['application_mobile_number'] = $stage_1_contact_details->mobile_number;
        $stage_1_occupation = find_one_row('stage_1_occupation', 'pointer_id', $pointer_id);
        $data['application_program'] = $stage_1_occupation->program;
        $data['application_pathway'] = $stage_1_occupation->pathway;
        $occupation_list = find_one_row('occupation_list', 'id', $stage_1_occupation->occupation_id);
        $data['application_occupation_id'] = $occupation_list->name;

        $application_pointer = find_one_row('application_pointer', 'id', $pointer_id);
        $user_id =  $application_pointer->user_id;
        $user_account = find_one_row('user_account', 'id', $user_id);
        $list_of_user = $this->user_account_model->where('status', 'active')->find();
        $data['list_of_user'] =    $list_of_user;
        $data['show_said_bar'] =    false;

        $data['pointer_id'] = $pointer_id;      
        $data['old_user_account_id'] =  $old_user_account_email = $user_account->id;
        $data['old_user_account_email'] =  $old_user_account_email = $user_account->email;
        $data['old_user_account_account_type'] =   $old_user_account_account_type = $user_account->account_type;
        $data['old_user_account_name'] =   $old_user_account_name = $user_account->name;
        $data['old_user_account_middle_name'] =   $old_user_account_middle_name = $user_account->middle_name;
        $data['old_user_account_last_name'] =    $old_user_account_last_name = $user_account->last_name;
        $data['old_user_account_mobile_code'] =    $old_user_account_mobile_code = $user_account->mobile_code;
        $data['old_user_account_mobile_no'] =    $old_user_account_mobile_no = $user_account->mobile_no;
        $data['old_user_account_business_name'] =    $old_user_account_business_name = $user_account->business_name;
        $data['old_user_account_mara_no'] =     $old_user_account_mara_no = $user_account->mara_no;
        $data['old_user_account_status'] =    $old_user_account_status = $user_account->status;

        $files = [
            'pointer_id' => $pointer_id,
            'required_document_id' => 33
        ];
        $file_exist = $this->documents_model->where($files)->first();
        if (!empty($file_exist)) {
            $data['File_check'] = true;
            $data['File_id'] = $file_exist['id'];
            $data['File_required_document_id'] = $file_exist['required_document_id'];
            $data['File_name'] = $file_exist['name'];
            $data['File_document_name'] = $file_exist['document_name'];
            $data['File_document_path'] = $file_exist['document_path'];
        } else {
            $data['File_check'] = false;
        }



        return view('admin/application_transfer/application_transfer', $data);
    }

    public function application_transfer_()
    {
        echo "ok";
    }

    public function get_agent_data($pointer_id)
    {
        echo "<pre>";
        echo "<br>application_transfer:- " . $pointer_id;
        $application_pointer = find_one_row('application_pointer', 'id', $pointer_id);
        echo "<br>";
        print_r($application_pointer);
        $user_id =  $application_pointer->user_id;
        $user_account = find_one_row('user_account', 'id', $user_id);
        echo "<br>";
        print_r($user_account);
        $old_user_account_email = $user_account->email;
        $old_user_account_account_type = $user_account->account_type;
        $old_user_account_name = $user_account->name;
        $old_user_account_middle_name = $user_account->middle_name;
        $old_user_account_last_name = $user_account->last_name;
        $old_user_account_mobile_code = $user_account->mobile_code;
        $old_user_account_mobile_no = $user_account->mobile_no;
        $old_user_account_business_name = $user_account->business_name;
        $old_user_account_mara_no = $user_account->mara_no;
        $old_user_account_status = $user_account->status;


        echo "<br>";
        print_r($user_account);
    }

    public function Create_new_TRA_file($pointer_id, $user_id)
    {

        $register_user = $this->application_pointer_model->where('id', $pointer_id)->first();
        $database = $this->stage_1_education_and_employment_model->where(['pointer_id' => $pointer_id])->find();
        $perosnal_details = $this->stage_1_personal_details_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $occupation_details = $this->stage_1_occupation_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $contact_details = $this->stage_1_contact_details_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $identification_details = $this->stage_1_identification_details_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $usi_details = $this->stage_1_usi_avetmiss_model->orderby('id', 'DESC')->where(['pointer_id' => $pointer_id])->first();
        $education_and_employment = $this->stage_1_education_and_employment_model->orderby('id', 'DESC')->where(['pointer_id' => $pointer_id])->first();
        $register_user = $this->user_account_model->where('id', $user_id)->first();
        $stage_1_pdf_download = $this->stage_1_review_confirm_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();

        $data = [
            'ENC_pointer_id' => pointer_id_encrypt($pointer_id),
            'pointer_id' => $pointer_id,
            'user_id' => $user_id,
            'show_said_bar' => false,
            'page' => "Application Preview",
            'education_and_employment' => $education_and_employment,
            'database' => $database,
            'register_user' => $register_user,
            'personal_details' => $perosnal_details,
            'identification_details' => $identification_details,
            'occupation' => $occupation_details,
            'usi_details' => $usi_details,
            'contact_details' => $contact_details,
            'stage_1_pdf_download' => $stage_1_pdf_download,
        ];
        return view('admin/application_transfer/Create_new_TRA_file', $data);
    }


    // Create_new_TRA_file_pdf_html_code_
    public function pdf_html_code_()
    {
        $data = $this->request->getvar();
        $pdf_html_code = $data['pdf_html_code'];

        $pdf_html_code =   str_replace('style="font-size: 23px;"', "", $pdf_html_code);
        $ENC_pointer_id = $data['ENC_pointer_id'];
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        if (!empty($pointer_id)) {
            $check = $this->stage_1_review_confirm_model->where(['pointer_id' => $pointer_id])->first();
            if (!empty($check)) {
                $this->stage_1_review_confirm_model->where(['pointer_id' => $pointer_id])->set(['pdf_html_code' => $pdf_html_code])->update();
            } else {
                $details = [
                    'pdf_html_code' => $pdf_html_code,
                ];
                $this->stage_1_review_confirm_model->save($details);
            }
            echo "done";
        }
    }



    public function auto_save_download_PDF_($ENC_pointer_id,  $file_name)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        $this->stage_1_education_and_employment_model->where(['pointer_id' => $pointer_id])->set('is_downloaded', 1)->update();

        $img_tag  = '<img src="' . base_url() . '/public/assets/image/profile_pic.jpg"   alt="" class="responsive" width="10%" height="35px" id="user_img">';

        $document = $this->documents_model->where(['pointer_id' => $pointer_id, 'required_document_id' => 1, 'stage' => 'stage_1'])->first();
        if (!empty($document)) {
            $document_name = $document['document_name'];
            $document_path = $document['document_path'];
            $full_path = $document_path . '/' . $document_name;
            if (file_exists($full_path)) {
                $img_tag  = '  <img src="' . base_url() . '/' . $full_path . '"  alt="" class="responsive" width="10%" height="75px" id="user_img">';
            }
        }

        $stage_1_ = $this->stage_1_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $status = $stage_1_['status'];
        $submitted_date = $stage_1_['submitted_date'];

        $date = '<DIV class="date">Date : ' . date("d/m/Y") . '</DIV> ';
        if (!empty($status)) {
            if ($status == 'submitted') {
                if (!empty($submitted_date)) {
                    $date = '<DIV class="date">Submitted Date : ' . $submitted_date . '</DIV> ';
                }
            }
        }

        if (!empty($file_name)) {
            $file_name = $file_name;
        } else {
            $file_name = 'review & confirm';
        }

        $perosnal_details = $this->stage_1_personal_details_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $first_or_given_name = (!empty($perosnal_details['first_or_given_name'])) ? $perosnal_details['first_or_given_name'] : '';
        $middle_names = (!empty($perosnal_details['middle_names'])) ? $perosnal_details['middle_names'] : '';
        $surname_family_name = (!empty($perosnal_details['surname_family_name'])) ? $perosnal_details['surname_family_name'] : '';

        $aqato_logo = base_url('public/assets/image/aqato_logo.png');
        $attc_logo = base_url('public/assets/image/attc_logo.png');


        $a = '<html>
                    <head>
                        <title>
                        ' . $file_name . '
                        </title>
                        <style>
                
                            @page {
                                margin: 0cm 0cm;
                            }
                            body {
                                margin-top: 5cm;
                                margin-left: 2cm;
                                margin-right: 2cm;
                                margin-bottom: 2cm;
                            }
                            header {
                                position: fixed;
                                top: 0.9cm;
                                left: 1cm;
                                right: 1cm;
                                height: 80px;
                                border-bottom: 1px solid;

                            }
                            footer {
                            border-top: 1px solid;
                            padding-top: 5px;
                                position: fixed;
                                bottom: 0cm;
                                left: 1cm;
                                right: 1cm;
                                height: 2cm;
                            }
                            table {
                            
                                border-collapse: collapse;
                                width: 100%;
                            filter: alpha(opacity=40); 
                            opacity: 0.95;
                            border:1px black solid;"
                            }
                            hr {
                            clear: both;
                            visibility: hidden;
                        }
                            table td,
                            table th {
                            
                                padding: 8px;
                            }
                            table tr:nth-child(even) {
                                background-color: #f2f2f2;
                            }
                            table tr:hover {
                                background-color: #ddd;
                            }
                            table th {
                                padding-top: 12px;
                                padding-bottom: 12px;
                                text-align: left;
                                background-color: #f2f2f2;
                            }
                            #tra {
                            position:absolute;
                            left:70%;
                            margin-top: 20px;
                            margin-left: 10px;
                            }
                            .table {
                                margin-bottom: 20px;
                            }
                        .Personal_Details{
                        margin-top:-30px;
                        }
                        .Occupation{
                        margin-top:-20px;
                        }
                        .Contact_Details{
                        margin-top:-60px; 
                        }
                        .Identification_Details{
                        margin-top:-60px; 
                        }
                        .Representative_Details{
                        margin-top:-60px; 
                        }
                        .USI{
                        margin-top:-60px; 
                        }

                            .date { margin-top:-30px; margin-left:40%; font-size: 14px;  }
                            .name {  margin-left:40%;  margin-top: -30px !important; }
                            #user_img { margin-top: -34px; margin-left:86.5%; border:1px solid black; padding: 20px 10px 20px 10px; }
                        
                        </style>
                    </head>
                    
                    <body>';
        $b = '<header>
                     <img src="' . base_url() . '/public/assets/image/tra.png" alt="Aqato" height="auto" width="10%">
                     <img src="' . $attc_logo . '" alt="Attc" height="80px" width="60%">
                     <div id="tra">TRA Application Form</div>
             </header>
             <footer>
                   <img src="' . $aqato_logo . '" alt="Aqato" height="30px" width="15%">
                   ' . $date . '
              </footer>
                <div id="list"">
                       <h4 class="name ">Name :- ' . $first_or_given_name . ' ' . $middle_names . " " . $surname_family_name . '</h4> 
                      <br>   ' . $img_tag . '
                </div>
             ';



        $data =   $this->stage_1_review_confirm_model->where(['pointer_id' => $pointer_id])->first();

        if (!isset($data['pdf_html_code']) || empty($data['pdf_html_code'])) {
            $this->session->setFlashdata('error_msg', 'PDF pdf_html_code empty ');
            return redirect()->back();
        }

        if ($data['pdf_html_code']) {
            $html = $a . ' ' . $b . ' ' . $data['pdf_html_code'];
        } else {
            $html = $a . ' ' . $b;
        }



        // echo $html;
        // exit;
        // -------------PDF  creat Code  ----------
        require_once "dompdf/autoload.inc.php";
        $dompdf = new Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->loadhtml($html);
        $dompdf->setpaper('A4', 'portrait');
        $dompdf->set_option("isPhpEnabled", true); //
        $dompdf->render();
        $x          = 505;
        $y          = 790;
        $text       = "{PAGE_NUM} of {PAGE_COUNT}";
        $font       = $dompdf->getFontMetrics()->get_font('Helvetica', 'normal');
        $size       = 10;
        $color      = array(0, 0, 0);
        $word_space = 0.0;
        $char_space = 0.0;
        $angle      = 0.0;
        $dompdf->getCanvas()->page_text(
            $x,
            $y,
            $text,
            $font,
            $size,
            $color,
            $word_space,
            $char_space,
            $angle
        );

        // if (!empty($file_name)) {
        //     $dompdf->stream($file_name);
        // } else {
        //     $dompdf->stream('review & confirm');
        // }

        // $output = $dompdf->output();
        $sss = "public/application/" . $pointer_id . "/stage_1/";
        if (!is_dir($sss)) {
            // create the directory path if it does not exist
            mkdir($sss, 0777, true);
        }
        $sss = "public/application/" . $pointer_id . "/stage_1/TRA Application Form.pdf";
        file_put_contents($sss, $dompdf->output());
        // return redirect()->back();
    }


    public function file_Upload_()
    {
        
        $file =  $this->request->getFile('file');
        $pointer_id =  $this->request->getVar('pointer_id');
        $file_name =  "Agent_Authorisation_Form";
        $new_agent = $this->request->getVar("new_agent");
        // print_r($new_agent);
        // echo $pointer_id;
        // print_r($file);
        // exit;
        // $current_stage = $this->application_pointer_model->asObject()->where(['id' =>$pointer_id])->first();    $current_stage->stage;
        $required_document_id = 33; // Agent Authorisation Form
        $File_extention = $file->getClientExtension();

        $document_name = clean_URL($file_name);
        $file_name_with_extantion = $document_name . '.' . $File_extention;  // file.jpg

        // $folder_path = 'public/application/' . $pointer_id . '/'.$current_stage->stage.'/';
        
        $folder_path = 'public/application/' . $pointer_id . '/';

        $is_move = $file->move($folder_path, $file_name_with_extantion, true);
        $this->application_pointer_model->update($pointer_id,['user_id'=>$new_agent]); // agent change i.e updated the id of agent
    
        if ($is_move) {

            // insert into SQL if not exist
            $files = [
                'pointer_id' => $pointer_id,
                // 'stage' => $current_stage->stage,
                'required_document_id' => trim($required_document_id),
                'name' => $file_name,
                'document_name' => $file_name_with_extantion,
                'document_path' => $folder_path,
                'document_type' => '',
                'status' => 1
            ];
            // $file_exist = $this->documents_model->where($files)->first();
            // if (!$file_exist) {
                $is_insert =   $this->documents_model->insert($files);
                if ($is_insert) {
                   $callback = array(
                "color" => "success",
                "msg" => "update recode",
                "response" => true,
                 );
                }else{
                    $callback = array(
                        "msg" => "unable to update record",
                        "color" => "danger",
                        "response" => false,
                    );
            
                }
                echo json_encode($callback);
                        // get index id 
                    // $get_data = $this->documents_model->where($files)->first();
                    // if (!empty($get_data)) {
                    //     $index_id =  $get_data['id'];
                    //     echo "ok";
                    // }
                // }
            // } else {
            //     $index_id  = $file_exist['id'];
                // echo "ok";
            // }
        }
        //
    }


    public function delete_file_($document_id)
    {

        $file_id = $document_id;
        $documents_list = $this->documents_model->where(['id' => $file_id])->first();
        if (!empty($documents_list)) {
            $document_name = $documents_list['document_name'];
            $document_path = $documents_list['document_path'];
            $full_path = $document_path . '/' . $document_name;
            if (file_exists($full_path)) {
                unlink($full_path);
                    $is_delet = $this->documents_model->where(['id' => $file_id])->delete();
              }
                $callback = array(
                "color" => "success",
                "msg" => "update recode",
                "response" => true,
                 );
                    
            }
            else{
                    $callback = array(
                        "msg" => "unable to update record",
                        "color" => "danger",
                        "response" => false,
                    );
            
                }
                echo json_encode($callback);
        }
    

    public function Send_email_($pointer_id, $user_id)
    {
        $addAttachment=[];

        $database_check =  $this->application_pointer_model->set(['user_id' => $user_id])->where('id', $pointer_id)->update();

            $agent_auth_form = $this->documents_model->where(['pointer_id' => $pointer_id, 'required_document_id' => 33])->first();

               
        $user_account = $this->user_account_model->asObject()->where('id', $user_id)->first();
        
        if (!empty($user_account)) {
            $user_mail = (isset($user_account->email) ? $user_account->email : '');
            $account_type = (isset($user_account->account_type) ? $user_account->account_type : '');

            $send_total = 0;
            if ($account_type == "Agent") {
                // application_transfer_Agent
                $mail_temp_2 = $this->mail_template_model->asObject()->where(['id' => '112'])->first();
                if (!empty($mail_temp_2)) {
                    $subject = mail_tag_replace($mail_temp_2->subject, $pointer_id);
                    $message = mail_tag_replace($mail_temp_2->body, $pointer_id);
                    $to = $user_mail;
            $mail_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [],[], $pointer_id);
                    if ($mail_check) {
                        $send_total++;
                    }
                }
                
            } else {
                // application_transfer_Applicant
                $mail_temp_2 = $this->mail_template_model->asObject()->where(['id' => '113'])->first();
                if (!empty($mail_temp_2)) {
                    $subject = mail_tag_replace($mail_temp_2->subject, $pointer_id);
                    $message = mail_tag_replace($mail_temp_2->body, $pointer_id);
                    $to = $user_mail;
            $mail_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [],[], $pointer_id);
                    if ($mail_check) {
                        $send_total++;
                    }
                }
            }
        }
        
        
                     $form_path='public/application/'. $pointer_id ."/".$agent_auth_form['document_name'];

        $addAttachment_1 = array(
                [
                    'file_path' => $form_path,
                    'file_name' => $agent_auth_form['document_name']
                ],
                [
                    'file_path' =>  'public/application/'. $pointer_id .'/stage_1/TRA Application Form.pdf' ,

                    'file_name' => "TRA Application Form.pdf"
                ]
                );
     
            
        // application_transfer_Admin_and_Head_Office
        $mail_temp_2 = $this->mail_template_model->asObject()->where(['id' => '110'])->first();
        // if(!empty($mail_temp_2)) {
            
            $subject = mail_tag_replace($mail_temp_2->subject, $pointer_id);
            $message = mail_tag_replace($mail_temp_2->body, $pointer_id);
            $to =  env('HEADOFFICE_EMAIL');

            $mail_check_head = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment_1, $pointer_id);
            if ($mail_check_head) {
                // echo "mail_check_head";
                $send_total++;
            }
            $subject = mail_tag_replace($mail_temp_2->subject, $pointer_id);
            $message = mail_tag_replace($mail_temp_2->body, $pointer_id);
            $to =  env('ADMIN_EMAIL');

            $mail_check_admin = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[], [], [], $addAttachment_1, $pointer_id);
            if ($mail_check_admin) {
                $send_total++;
            }
        // }
        // echo $send_total;
            if($send_total == 3){
              $callback = array(
                        "color" => "success",
                        "msg" => "mail send",
                        "response" => true,
                         );
                 }else{
                    $callback = array(
                        "msg" => "unable to update record",
                        "color" => "danger",
                        "response" => false,
                    );
                }
                echo json_encode($callback);
    }
}
