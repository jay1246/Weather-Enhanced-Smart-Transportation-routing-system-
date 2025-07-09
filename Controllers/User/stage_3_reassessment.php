<?php

namespace App\Controllers\User;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Controllers\BaseController;

// stage 3 reassessment ---------------------------------------- 

class stage_3_reassessment extends BaseController
{
    public function start($ENC_pointer_id){
        // exit;
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
    
        $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->first();
    
        $user_account = $this->user_account_model->where(['id' => $application_pointer['user_id']])->first();
    
        $mail_temp_1 = "";
        
        $s1_occupation = $this->stage_1_occupation_model->asObject()->where('pointer_id', $pointer_id)->first();

        $client_type =  is_Agent_Applicant($pointer_id);

        if ($client_type == "Agent") { 
    
            if ($s1_occupation->pathway == 'Pathway 1') {
    
                if($s1_occupation->program == "OSAP" ){
    
                    $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '155'])->first();
    
                }else if($s1_occupation->program == "TSS" ){
    
                    $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '153'])->first();   
                }
            }else if($s1_occupation->pathway == 'Pathway 2'){
    
                if($s1_occupation->program == "OSAP" ){
    
                    $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '156'])->first(); 
    
                }else if($s1_occupation->program == "TSS" ){
    
                    $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '154'])->first();   
                }
    
            }
        }else if ($client_type == "Applicant") {
    
            if ($s1_occupation->pathway == 'Pathway 1') {
    
                if($s1_occupation->program == "OSAP" ){
    
                    $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '157'])->first();
    
                }else if($s1_occupation->program == "TSS" ){
    
                    $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '160'])->first();   
                }
            }else if($s1_occupation->pathway == 'Pathway 2'){
    
                if($s1_occupation->program == "OSAP" ){
    
                    $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '158'])->first(); 
    
                }else if($s1_occupation->program == "TSS" ){
    
                    $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '159'])->first();   
                }
    
            }
            
        }
        if (!empty($user_account)) {
            $email = $user_account['email'];
        }
        $mail_send = false;
        if (!empty($mail_temp_1)) {
    
            $subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
    
            $message = mail_tag_replace($mail_temp_1->body, $pointer_id);
            
            $to =  $email;
    
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], [], $pointer_id);
            
            if ($check) {
                $mail_send = true;
            }
    
        }
        $insert_reassessment = false;
        if($this->stage_3_reassessment_model->insert(['pointer_id' => $pointer_id, 'status' => 'reassessment'])){
            $insert_reassessment = true;
        };
    
        if($mail_send || $insert_reassessment){
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
    
    public function save_back($ENC_pointer_id){
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $stage_3_R = $this->stage_3_reassessment_model->asObject()->where("pointer_id", $pointer_id)->first();
        if($stage_3_R->status == 'reassessment'){
            $data = [
                        'status' => 'start',
                    ];
            if($this->stage_3_reassessment_model->set($data)->where('pointer_id', $pointer_id)->update()){
                $result = "updated";
            }
            
        }else{
            $result = "nothing to updated";
        }
        if($result){
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
    public function receipt_upload_page($ENC_pointer_id)
    {
        // exit;
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $stage_3_R = $this->stage_3_reassessment_model->where("pointer_id", $pointer_id)->first();
        $stage_1_occupation = $this->stage_1_occupation_model->where("pointer_id", $pointer_id)->first();
        $stage_3_R = $this->stage_3_reassessment_model->where("pointer_id", $pointer_id)->first();
        $status = (!empty($stage_3_R['status']) ? $stage_3_R['status'] : "");
            // print_r($stage_3_R);
            // exit;
        if ($status == "reassessment" || $status == "start") {
            $receipt_number = (!empty($stage_3_R['receipt_number']) ? $stage_3_R['receipt_number'] : "");
            $payment_date = "";
            if (!empty($stage_3_R['payment_date']) && $stage_3_R['payment_date'] != "0000-00-00 00:00:00") {
                $payment_date = (!empty($stage_3_R['payment_date']) ?  date("d/m/Y", strtotime($stage_3_R['payment_date'])) : "");
            }
            $preference_location =  (!empty($stage_3_R['preference_location']) ? $stage_3_R['preference_location'] : "");
            $preference_comment = (!empty($stage_3_R['preference_comment']) ? $stage_3_R['preference_comment'] : "");
            $exemption_yes_no = (!empty($stage_3_R['exemption_yes_no']) ? $stage_3_R['exemption_yes_no'] : "");
            $documents = $this->documents_model->where(["pointer_id" => $pointer_id, 'required_document_id' => 19, 'stage' => 'stage_3_R'])->first();
            $document_full_name = (isset($documents['document_name']) ? $documents['document_name'] : "");
            $document_path = (isset($documents['document_path']) ? $documents['document_path'] : "");
            $document_id = (isset($documents['id']) ? $documents['id'] : "");
            $document_name = (isset($documents['name']) ? $documents['name'] : "");
            if (!empty($document_name)) {
                $file_uploaded = true;
            } else {
                $file_uploaded = false;
            }
            
            // Excemption Form Code
             $document_full_name_ex = $document_path_ex = $document_name_ex = $document_id_ex ="";
            // echo "ffdfdnxbcbcb";
                $file_uploaded_ex = false;
                if(!empty($stage_3_R['download_ex_form'])){
                    $value_of_download_ex_form = $stage_3_R['download_ex_form'];
                }else {
                    $value_of_download_ex_form = 0;
                }
                // echo $exemption_yes_no;
                 if($exemption_yes_no == 'yes'){
                $download_ex_form = (!empty($stage_3_R['download_ex_form']) ? $stage_3_R['download_ex_form'] : "");
                $file_uploaded_ex = true;
                }else{
                    $file_uploaded_ex = false;
                    $download_ex_form =1;
                }
                      $documents_exception = $this->documents_model->where(["pointer_id" => $pointer_id, 'required_document_id' => 43, 'stage' => 'stage_3_R'])->first();
            // print_r($documents_exception);
            if($documents_exception){
                $document_full_name_ex = (isset($documents_exception['document_name']) ? $documents_exception['document_name'] : "");
                $document_path_ex = (isset($documents_exception['document_path']) ? $documents_exception['document_path'] : "");
                $document_name_ex = (isset($documents_exception['name']) ? $documents_exception['name'] : "");
                $document_id_ex = (isset($documents_exception['id']) ? $documents_exception['id'] : "");
                if (!empty($document_name_ex)) {
                    $file_uploaded_ex = true;
                } else {
                    $file_uploaded_ex = false;
                }
                 
            }
           
            $offline_locations = $this->stage_3_offline_location_model->find();
            $country = array();
            foreach ($offline_locations as $key => $value) {
                // akanksha 7 july 2023
                if (!in_array($value['country'], $country)) {
                    // echo $stage_1_occupation['occupation_id'];
                    if($stage_1_occupation['occupation_id']!=5 && $stage_1_occupation['occupation_id']!=6){
                        // echo "here";
                        // exit;
                        if($value['id'] != 17){
                            $country[] = $value['country'];
                        }
                    }else{
                        $country[] = $value['country'];
                    }
                }
            }
            $location = array();
            foreach ($country as $key => $value) {
                $offline_location = $this->stage_3_offline_location_model->where(['country' => $value, 'pratical'=>"0"])->find();
                $location[$value] = $offline_location;
            }



            // Get the Occupation
             $enroll_stage_4 = false;
            $occupation = $this->stage_1_occupation_model->where("pointer_id", $pointer_id)->asObject()->first();
            if($occupation->pathway == "Pathway 1"){
                if($occupation->occupation_id == 7 || $occupation->occupation_id == 18){
                    $enroll_stage_4 = true;
                }
            }
            // echo $occupation->pathway;
            // echo $occupation->occupation_id;
            // print_r($enroll_stage_4);
            // exit;
            // end


            $data["page"] = 'TRA Payment Receipt Number';
            $data["pointer_id"] = $pointer_id;
            $data["exemption_yes_no"] = $exemption_yes_no;
            $data["ENC_pointer_id"] = $ENC_pointer_id;
            $data["receipt_number"] = $receipt_number;
            $data["payment_date"] = $payment_date;
            $data["preference_location"] = $preference_location;
            $data["preference_comment"] = $preference_comment;
            $data["document_name"] = $document_name;
            $data["document_full_name"] = $document_full_name;
            $data["document_path"] = $document_path;
            $data["document_id"] = $document_id;
            $data["file_uploaded"] = $file_uploaded;
            $data["location"] = $location;
            $data["document_name_ex"] = $document_name_ex;
            $data["document_full_name_ex"] = $document_full_name_ex;
            $data["document_path_ex"] = $document_path_ex;
            $data["document_id_ex"] = $document_id_ex;
            $data["file_uploaded_ex"] = $file_uploaded_ex;
            $data['download_ex_form'] =$download_ex_form;
            $data['value_of_download_ex_form'] = $value_of_download_ex_form;
            $data["enroll_stage_4"] = $enroll_stage_4;
            // echo "<pre>";
            // print_r($data);
            // exit;
            return view('user/stage_3_reassessment/receipt_upload', $data);
        }
        // return view('user/dashboard');
        return redirect()->to('user/dashboard');
    }
    public function receipt_upload_page__($ENC_pointer_id)
    {
        
        
        // echo $ENC_pointer_id;
        // die;
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $stage_3_R = $this->stage_3_reassessment_model->where("pointer_id", $pointer_id)->first();
        $stage_1_occupation = $this->stage_1_occupation_model->where("pointer_id", $pointer_id)->first();
        $stage_3_R = $this->stage_3_reassessment_model->where("pointer_id", $pointer_id)->first();
        $status = (!empty($stage_3_R['status']) ? $stage_3_R['status'] : "");
            // print_r($stage_3_R);
            // exit;
        if ($status == "reassessment" || $status == "start") {
            $receipt_number = (!empty($stage_3_R['receipt_number']) ? $stage_3_R['receipt_number'] : "");
            $payment_date = "";
            if (!empty($stage_3_R['payment_date']) && $stage_3_R['payment_date'] != "0000-00-00 00:00:00") {
                $payment_date = (!empty($stage_3_R['payment_date']) ?  date("d/m/Y", strtotime($stage_3_R['payment_date'])) : "");
            }
            $preference_location =  (!empty($stage_3_R['preference_location']) ? $stage_3_R['preference_location'] : "");
            $preference_comment = (!empty($stage_3_R['preference_comment']) ? $stage_3_R['preference_comment'] : "");
            $exemption_yes_no = (!empty($stage_3_R['exemption_yes_no']) ? $stage_3_R['exemption_yes_no'] : "");
            $documents = $this->documents_model->where(["pointer_id" => $pointer_id, 'required_document_id' => 19, 'stage' => 'stage_3_R'])->first();
            $document_full_name = (isset($documents['document_name']) ? $documents['document_name'] : "");
            $document_path = (isset($documents['document_path']) ? $documents['document_path'] : "");
            $document_id = (isset($documents['id']) ? $documents['id'] : "");
            $document_name = (isset($documents['name']) ? $documents['name'] : "");
            if (!empty($document_name)) {
                $file_uploaded = true;
            } else {
                $file_uploaded = false;
            }
            
            // Excemption Form Code
             $document_full_name_ex = $document_path_ex = $document_name_ex = $document_id_ex ="";
            // echo "ffdfdnxbcbcb";
                $file_uploaded_ex = false;
                if(!empty($stage_3_R['download_ex_form'])){
                    $value_of_download_ex_form = $stage_3_R['download_ex_form'];
                }else {
                    $value_of_download_ex_form = 0;
                }
                // echo $exemption_yes_no;
                 if($exemption_yes_no == 'yes'){
                $download_ex_form = (!empty($stage_3_R['download_ex_form']) ? $stage_3_R['download_ex_form'] : "");
                $file_uploaded_ex = true;
                }else{
                    $file_uploaded_ex = false;
                    $download_ex_form =1;
                }
                      $documents_exception = $this->documents_model->where(["pointer_id" => $pointer_id, 'required_document_id' => 43, 'stage' => 'stage_3_R'])->first();
            // print_r($documents_exception);
            if($documents_exception){
                $document_full_name_ex = (isset($documents_exception['document_name']) ? $documents_exception['document_name'] : "");
                $document_path_ex = (isset($documents_exception['document_path']) ? $documents_exception['document_path'] : "");
                $document_name_ex = (isset($documents_exception['name']) ? $documents_exception['name'] : "");
                $document_id_ex = (isset($documents_exception['id']) ? $documents_exception['id'] : "");
                if (!empty($document_name_ex)) {
                    $file_uploaded_ex = true;
                } else {
                    $file_uploaded_ex = false;
                }
                 
            }
           
            $offline_locations = $this->stage_3_offline_location_model->find();
            $country = array();
            foreach ($offline_locations as $key => $value) {
                // akanksha 7 july 2023
                if (!in_array($value['country'], $country)) {
                    // echo $stage_1_occupation['occupation_id'];
                    if($stage_1_occupation['occupation_id']!=5 && $stage_1_occupation['occupation_id']!=6){
                        // echo "here";
                        // exit;
                        if($value['id'] != 17){
                            $country[] = $value['country'];
                        }
                    }else{
                        $country[] = $value['country'];
                    }
                }
            }
            $location = array();
            foreach ($country as $key => $value) {
                $offline_location = $this->stage_3_offline_location_model->where(['country' => $value])->find();
                $location[$value] = $offline_location;
            }



            // Get the Occupation
             $enroll_stage_4 = false;
            $occupation = $this->stage_1_occupation_model->where("pointer_id", $pointer_id)->asObject()->first();
            if($occupation->pathway == "Pathway 1"){
                if($occupation->occupation_id == 7 || $occupation->occupation_id == 18){
                    $enroll_stage_4 = true;
                }
            }
            // echo $occupation->pathway;
            // echo $occupation->occupation_id;
            // print_r($enroll_stage_4);
            // exit;
            // end


            $data["page"] = 'TRA Payment Receipt Number';
            $data["pointer_id"] = $pointer_id;
            $data["exemption_yes_no"] = $exemption_yes_no;
            $data["ENC_pointer_id"] = $ENC_pointer_id;
            $data["receipt_number"] = $receipt_number;
            $data["payment_date"] = $payment_date;
            $data["preference_location"] = $preference_location;
            $data["preference_comment"] = $preference_comment;
            $data["document_name"] = $document_name;
            $data["document_full_name"] = $document_full_name;
            $data["document_path"] = $document_path;
            $data["document_id"] = $document_id;
            $data["file_uploaded"] = $file_uploaded;
            $data["location"] = $location;
            $data["document_name_ex"] = $document_name_ex;
            $data["document_full_name_ex"] = $document_full_name_ex;
            $data["document_path_ex"] = $document_path_ex;
            $data["document_id_ex"] = $document_id_ex;
            $data["file_uploaded_ex"] = $file_uploaded_ex;
            $data['download_ex_form'] =$download_ex_form;
            $data['value_of_download_ex_form'] = $value_of_download_ex_form;
            $data["enroll_stage_4"] = $enroll_stage_4;
            // echo "<pre>";
            // print_r($data);
            // exit;
            return view('user/stage_3_reassessment/receipt_upload__aus', $data);
        }
        // return view('user/dashboard');
        return redirect()->to('user/dashboard');
    }
    public function valication($ENC_pointer_id){
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
         $stage_3_R = $this->stage_3_reassessment_model->where('pointer_id', $pointer_id)->first();
        //  print_r($stage_3_R);
        $exemption_type = $stage_3_R['exemption_yes_no'];
        if($exemption_type =='no'){
            
            $documents = $this->documents_model->where(['pointer_id'=> $pointer_id,'required_document_id'=>43])->first();
            // print_r($documents);
            // exit;
            if (!empty($documents)) {
                $file_path =  $documents['document_path'] . '/' . $documents['document_name'];
                
                if (file_exists($file_path)) {
                    if (unlink($file_path)) {
                        echo "unlink";
                    }else{
                        echo "not unlink";
                    }
                }
                    $data = [
                        "exemption_form"=>'',
                    ];
                    
                $this->stage_3_reassessment_model->set($data)->where('pointer_id', $pointer_id)->update();
                
                $this->documents_model->where('id',$documents['id'])->delete();
            }
        }
        if($stage_3_R['receipt_number']!=""){
            if($stage_3_R['payment_date'] !="0000-00-00 00:00:00" || $stage_3_R['payment_date'] !="" || $stage_3_R['payment_date'] !=null ){
                  $json = [
                        "msg" => "Procced",
                        "error" => 0,
                    ];
                    echo json_encode($json);
                    exit;
                
            }else{
                  $json = [
                            "msg" => "Payment Date is Required",
                            "error" => 1,
                        ];
                        echo json_encode($json);
                        exit;
                      
            }
        }else{
              $json = [
                            "msg" => "TRA Payment Receipt Number is Required",
                            "error" => 1,
                        ];
                        echo json_encode($json);
                        exit;
                      
        }
    }
    // ajax ----------
    public function get_addresh_()
    {
        $city_name = $_POST['city_name'];
        $offline_locations = $this->stage_3_offline_location_model->where('city_name', $city_name)->first();
        return json_encode($offline_locations);
    }
    public function exemption_form($ENC_pointer_id){
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
    
        $session = session();

          $file_exemption_uploaded =  $this->request->getFile('file_exemption');
        
        // print_r($file_exemption_uploaded);
        // echo "sdgdgf";
        // exit;
        $file_name_with_extention_of_exemption ="";
        if ($file_exemption_uploaded) {

            if($file_exemption_uploaded->getName()){
                $file_exemption_uploaded_extention = $file_exemption_uploaded->getClientExtension();

                $file_exemption_required = $this->required_documents_list_model->where(["stage" =>"stage_3",'category'=>'exemption_form'])->first();
                
                $folder_path_exemption = 'public/application/'.$pointer_id .'/stage_3_R';
                $document_name_exemption = $file_exemption_required["document_name"];
                $file_name_with_extention_of_exemption = $document_name_exemption . '.' . $file_exemption_uploaded_extention;
                if (!is_dir($folder_path_exemption)) {
                    mkdir($folder_path_exemption);
                }
                // move file to folder 
                $is_move_exemption_file = $file_exemption_uploaded->move($folder_path_exemption, $file_name_with_extention_of_exemption, true);
                // echo $is_move_exemption_file;
                // exit;
                 $file_exemption_document = [
                            'pointer_id' => $pointer_id,
                            'stage' => 'stage_3_R',
                            'required_document_id' => $file_exemption_required['id'],
                            'name' => $file_exemption_required["document_name"],
                            'document_name' => $file_name_with_extention_of_exemption,
                            'document_path' => $folder_path_exemption,
                            'document_type' => '',
                            'status' => 1
                        ];
                      $this->documents_model->insert($file_exemption_document);
                    //   exit;
                }
        }
                      $data=[  
                          "exemption_form"=>$file_name_with_extention_of_exemption,
                          'exemption_yes_no'=>'yes',
                          ];
            if ($this->stage_3_reassessment_model->set($data)->where('pointer_id', $pointer_id)->update()) {
               $this->session->setFlashdata('msg', 'File Uploaded Successfully.');
                } else {
                    $this->session->setFlashdata('error_msg', 'File Uploading Error.');
                }    
                 return redirect()->back();
      
    }
    public function exemption_data($ENC_pointer_id){
        // echo "dfgfdg";
        // exit;
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        $session = session();

        $exemption_yes_no =  $this->request->getPost('exemption_yes_no');
        $download_ex_form =  $this->request->getPost('download_ex_form');
        $stage_3_R = $this->stage_3_reassessment_model->where("pointer_id", $pointer_id)->first();
            // echo $download_ex_form;
            // exit;
        if (!empty($exemption_yes_no)) {
            if (empty($stage_3_R)) {
                    $this->stage_3_reassessment_model->insert(['pointer_id' => $pointer_id, 'status' => 'start']);

                // $this->stage_3_reassessment_model->where('pointer_id',$pointer_id)->set(['pointer_id' => $pointer_id, 'status' => 'Start'])->update();
            }
        }
        $preference_location ="";
        if($exemption_yes_no =='yes'){
         $preference_location = "Online (Via Zoom)";
        }else{
            $preference_location =  $this->request->getPost('preference_location');
        }
        $preference_comment =  $this->request->getPost('preference_comment');
        $recipt_number =  $this->request->getPost('recipt_number');
        $payment_date_get =  $this->request->getPost('payment_date');
        
        $payment_date_ = str_replace('/', '-', $payment_date_get);
        $payment_date ="";
        if (!empty($payment_date_)) {
            $payment_date =  date("Y-m-d h:i:s", strtotime($payment_date_));
        }
        // echo $preference_location;
        // exit;
        
         $data = [
                'download_ex_form'=>$download_ex_form,
                "receipt_number" => $recipt_number,
                "payment_date" => $payment_date,
                "submitted_by"  => $session->user_id,
                'exemption_yes_no'=>$exemption_yes_no,
                "preference_location"=>$preference_location,
                'preference_comment' => $preference_comment,

            ];
            if ($this->stage_3_reassessment_model->set($data)->where('pointer_id', $pointer_id)->update()) {
                 $this->session->setFlashdata('msg', 'File Uploaded Successfully.');
                } else {
                    $this->session->setFlashdata('error_msg', 'File Uploading Error.');
                }    
                 return redirect()->back();
           
    }
    // ajax ----------
    public function receipt_upload_action($ENC_pointer_id)
    {
          $exemption_yes_no =  $this->request->getPost('exemption_yes_no');
    //   echo $exemption_yes_no;
    //   exit;
      
        // Start Session
        $session = session();
        // 
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $recipt_number =  $this->request->getPost('recipt_number');


        $payment_date =  $this->request->getPost('payment_date');
        $preference_location =  $this->request->getPost('preference_location');
            $cmnt =  $this->request->getPost('preference_comment');
        // echo $recipt_number;
        // echo $payment_date;
        // 
        $preference_location ="";
        if($exemption_yes_no == "yes"){
            $preference_location = "Online (Via Zoom)";
        }else{
            $preference_location =  $this->request->getPost('preference_location');
        }
        
        $payment_date = str_replace('/', '-', $payment_date);
        if (!empty($payment_date)) {
            $payment_date =  date("Y-m-d h:i:s", strtotime($payment_date));
        }

        // file data and file name 
        $file =  $this->request->getFile('recipt');
        
         if ($file) {

             if($file->getName()){

            $File_extention = $file->getClientExtension();
            
            $docs_db = $this->required_documents_list_model->where("id", "19")->first();
            $folder_path = 'public/application/'.$pointer_id .'/stage_3_R';
            $document_name = $docs_db["document_name"];
            $file_name_with_extantion = $document_name . '.' . $File_extention;
            // echo $folder_path;
            // exit;
            if (!is_dir($folder_path)) {
                mkdir($folder_path);
            }
            // move file to folder 
            $is_move = $file->move($folder_path, $file_name_with_extantion, true);
        
        }
         }
        // if ($is_move) {
            $data = [
                "receipt_number" => $recipt_number,
                "payment_date" => $payment_date,
                "submitted_by"  => $session->user_id,
                'exemption_yes_no'=>$exemption_yes_no,
                "preference_location"=>$preference_location,
                "download_ex_form" => 1,
                'preference_comment'=>$cmnt
                
            ];
            if ($this->stage_3_reassessment_model->set($data)->where('pointer_id', $pointer_id)->update()) {
                $data_docs = [
                    "pointer_id" => $pointer_id,
                    "stage" => 'stage_3_R',
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
            // }
            } else {
                $this->session->setFlashdata('error_msg', 'Sorry! File Not Uploaded.');
            }

        return redirect()->back();
    }

    public function receipt_upload_getData($ENC_pointer_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $stage_3_R__ = $this->stage_3_reassessment_model->where("pointer_id", $pointer_id)->first();
        $docs = $this->documents_model->where([
            "pointer_id" => $pointer_id,
            "stage" => "stage_3_R",
        ])->first();
        $output = [];
        if ($docs) {
            $output = [
                "name" => $docs["name"],
                "path" => base_url() . "/" . $docs["document_path"] . "/" . $docs["document_name"],
                "pointer_id" => $docs["pointer_id"],
                "receipt_number" => $stage_3_R__["receipt_number"],
                "payment_date" => date("d/m/y", strtotime($stage_3_R__["payment_date"])),
            ];
        }
        echo json_encode($output);
    }

    // working
    function receipt_upload_delete($ENC_pointer_id,$documnet_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $documnet_id  = $documnet_id;
            $documents = $this->documents_model->where('id',$documnet_id)->first();
            // print_r($documents);
            // exit;
            if (!empty($documents)) {
                $file_path =  $documents['document_path'] . '/' . $documents['document_name'];
                
                    if (file_exists($file_path)) {
                        if (unlink($file_path)) {
                            echo "unlink";
                        }else{
                            echo "not unlink";
                        }
                    }
                    // if($documents['required_document_id'] == 19){
                    //     $data = [
                    //         "receipt_number" => '',
                    //         "payment_date" => '',

                    //     ];
                    //       $this->stage_3_reassessment_model->set($data)->where('pointer_id', $pointer_id)->update();
  
                    // }
                    if($documents['required_document_id'] == 43){
                        $data = [
                            "exemption_form"=>'',
                        ];
                    $this->stage_3_reassessment_model->set($data)->where('pointer_id', $pointer_id)->update();
                    }
                    if ($this->documents_model->where('id',$documnet_id)->delete()) {
                        $this->session->setFlashdata('msg', 'File Deleted Successfully.');
                        echo "delete";
                    }else{
                    $this->session->setFlashdata('error_msg', 'File Uploading Error.');
                    echo "not delete";
                    }
               
            }
        // echo json_encode($callback);
            return redirect()->back();

       }



    function stage_3_submit_($ENC_pointer_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        // echo $pointer_id;


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
                $mail_temp_4 = $this->mail_template_model->where(['id' => '162'])->first();
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
                $mail_temp_4 = $this->mail_template_model->where(['id' => '174'])->first();
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
        $mail_temp_4 = $this->mail_template_model->where(['id' => '182'])->first();
        if (!empty($mail_temp_4)) {
            $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
            $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
            $stage_3_R_ = $this->stage_3_reassessment_model->where(['pointer_id' => $pointer_id])->first();

            $preference_location_comment = "";
            if (!empty($stage_3_R_)) {
                $preference_location = trim($stage_3_R_['preference_location']);
                $preference_comment = trim($stage_3_R_['preference_comment']);
                $preference_comment = trim($preference_comment, "\xC2\xA0");
                $preference_comment = str_replace("&nbsp;", '', $preference_comment);
                if (!empty($preference_location)) {
                    $preference_location_comment .= "<b>Applicant's Preferred Venue: " . $preference_location;
                }
                if (!empty($preference_comment)) {
                    // $preference_location_comment .= "<br><br><u> Comments: </u><br>" . $preference_comment . "</b>";
                    $preference_location_comment .= "<br><br><u> Comments: </u><br><i>\"" . $preference_comment . "\"</i></b>";
                }
            }

            $stage_3_R_Docs = $this->documents_model->where(['pointer_id' => $pointer_id, 'required_document_id' => 19, 'stage' => "stage_3_R"])->first();
            
            
            
            $addAttachment = array(
                [
                    'file_path' => $stage_3_R_Docs['document_path'] . '/' . $stage_3_R_Docs['document_name'],
                    'file_name' => $stage_3_R_Docs['document_name'],
                ]
            );
            
            
            // If Online Via Zoom then add Exception Form
            // Get the Occupation
            $enroll_stage_4 = false;
            $occupation = $this->stage_1_occupation_model->where("pointer_id", $pointer_id)->asObject()->first();
            if($occupation->pathway == "Pathway 1"){
                if($occupation->occupation_id == 7 || $occupation->occupation_id == 18){
                    $enroll_stage_4 = true;
                }
            }
            // end
            
            if($enroll_stage_4 == false){
                if($preference_location == "Online (Via Zoom)"){
                    $stage_3_R_Docs_ex = $this->documents_model->where(['pointer_id' => $pointer_id, 'required_document_id' => 43, 'stage' => "stage_3_R"])->first();
                     $addAttachment_ex = array(
                        [
                            'file_path' => $stage_3_R_Docs_ex['document_path'] . '/' . $stage_3_R_Docs_ex['document_name'],
                            'file_name' => $stage_3_R_Docs_ex['document_name'],
                        ]
                    );
                    array_push($addAttachment, ...$addAttachment_ex);
                }
            }
            // print_r($addAttachment);
            // exit;
            
            $message = str_replace('%preference_location_comment%', $preference_location_comment, $message);
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'),  env('ADMIN_EMAIL'), $subject, $message, [], [], [], $addAttachment, $pointer_id);
            if ($check == 1) {
                $email_send_admin = true;
            }
        }
        // echo "First = ".$email_send_agent_applicant."Second = ".$email_send_admin;
        // exit;

        if ($email_send_agent_applicant && $email_send_admin) {
            $is_update = $this->stage_3_reassessment_model->set([
                "status" => "Submitted",
                "submitted_date" => date("Y-m-d H:i:s"),
            ])->where("pointer_id", $pointer_id)->update();
            
            if ($is_update) {
                $is_pointer_update = $this->application_pointer_model->set([
                    "stage" => "stage_3_R",
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
    public function storepdf($pointer_id)
    {
    //   echo $pointer_id;
    //   die;
      $stage_3_checkin__ = find_one_row('stage_3_reassessment','pointer_id',$pointer_id);
    //   if($stage_3_checkin__->exemption_yes_no  == "no"){
    //       return 0;
    //       exit;
    //   }
      
    $data__3 = [
            "exemption_form" => "Agent TI Declaration.pdf"
            ];
        $this->stage_3_reassessment_model->set($data__3)->where('pointer_id', $pointer_id)->update();
      $user_id = $this->session->get('user_id');
      //agent data fetch
      $agent=find_one_row('user_account','id',$user_id);
      $acount_type=$agent->account_type;
      
     // $agent_name=$agent->name.$agent->last_name;
     //applicant data fetch
      
      $applicant=find_one_row('stage_1_personal_details','pointer_id',$pointer_id);
      $applicant_name=$applicant->first_or_given_name." ".$applicant->surname_family_name;
     //fetch data in application pointer for applicant name
      $applicant_no=find_one_row('stage_1','pointer_id',$pointer_id)->unique_id;
      $imageUrl=base_url().'/public/assets/image/img.png' ;
      $imageUrl2=base_url().'/public/assets/image/ATTC_CMYK.png';
      $current_date=date('d-m-Y');

     if($acount_type=="Applicant"){
          $agent_name="N/A";
         $important = '<h3 class="text"><mark>If you are unsure of meeting the above criteria, it is highly recommended you opt to attend an
            </mark><a href="https://attc.org.au/wp-content/uploads/2023/07/ATTC-Assesssment-Location-List_v3.1.pdf"><mark style="color: blue;">Approved Assessment Centre</mark></a> <mark>to complete their Technical
            Interview.</mark></h3>';
         $do_you=' <h3 class="h33">
                Do you wish to proceed with the option of completing the technical interview from your 
                preferred location instead of attending an Approved Assessment Centre ?
            </h3>';
            $pdf_name="Applicant TI Declaration.pdf";
            $document_name__= "Applicant TI Declaration";
     }else{
          $agent_name=$agent->name." ".$agent->last_name; 
          $important = '<h3 class="text"><mark>If the Applicant is unsure of meeting the above criteria, it is highly
            recommended they opt to
            attend an</mark><a href="https://attc.org.au/wp-content/uploads/2023/07/ATTC-Assesssment-Location-List_v3.1.pdf"><mark style="color: blue;">Approved Assessment Centre</mark></a> <mark>to complete their Technical
            Interview.</mark></h3>';
           $do_you=' <h3 class="h33">
             Does the applicant wish to proceed with the option of completing the technical interview from their
             preferred location instead of attending an Approved Assessment Centre ?
            </h3>';
            $pdf_name="Agent TI Declaration.pdf";
            $document_name__= "Agent TI Declaration";
     }

         $locations=$_GET['locations'];
             
             if($locations == 'Online (Via Zoom)'){
                $radio = 'checked';
                $checked = '<input type="radio" ' . $radio . '>';
                $checked2='<input type="radio"';
             }else{
                 $checked='<input type="radio"';
                $radio = 'checked';
              $checked2 = '<input type="radio" ' . $radio . '>';
              
            
             }


$html = '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .body {
            border: 1px solid black;
            width: 90%;
            margin: auto;
        }

        .note {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            background-color: #96b5e4;
            text-align:center;
            height:35px;
         font-weight:bold;
        }

        .notes{
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            background-color: #96b5e4;
            line-height:1rem;
           font-weight:bold;
            
            
            
        }

        /* table td{
            padding:30px;
            width: 70%;
        
           
        } */
        .tbldata {
            border: 1px solid black;
             width: 30%;
             padding: 20px;
            // border: 1px solid black;
        }

        table {
            width: 100%;
        }
        .tmp{
             border: 1px solid black;
        }
        // td {
        //     padding: 20px;
        //     border: 1px solid black;
        // }
        table, th, td {
           
            border-collapse: collapse;
          }
          .list{
          line-height:20px;
            font-family: sans-serif;
            font-size: 16px;
          }
          .list1{
          line-height:20px;
            font-family: sans-serif;
            font-size: 16px;
          }
          .h33{
            font-style: italic;
            text-align:center;
            font-size:17px;
            padding:5px;
        }
        .text{
            font-family: sans-serif;
            font-size: 16px;
            text-align:center;
            font-style: italic;
            font-weight: bold;
        }
        .border{
            border: none;
        }
.p-2{
    border:none;
}
.head.p-2{
    line-height:20px;
    text-align:center;
}
input[type="radio"] {
    margin-left: 25px;
}
    </style>
</head>

<body>

    <div class="body">
            <table >
                <tr class="border">
                    <td class="p-2" colspan="2">
                       <img src="' . $imageUrl . '" alt="" style="width: 100;">
                    </td>
                    <td class="p-2" colspan="3">
                         <img src="' . $imageUrl2 . '" alt="" style="width: 450px;">
                    </td>
                   
                </tr>
                
            </table>
            <table> <tr colspan="5">
            <td class="note" >AGENT / APPLICANT DECLARATION</td>
            </tr>
            </table>
           
        <div>
           <ul class="list" style=" list-style: none;">
                <li>As per the recent changes in the TRA guidelines, applicants in Australia
                    can now choose to complete the Technical Interview from their own preferred 
                    location such as their
                    home or their agent’s office etc. conditional to the following terms:</li>
            </ul>
            <ul class="list1">
                <li>
                    The location has consistent internet signal (preferably WIFI and not mobile Data).
                </li>
                <li>
                    The location is quiet and private (applicant’s need to be alone throughout the interview).
                </li>
                <li>
                    Their device has high quality audio and video capabilities <b>and has been tested prior to the
                        interview session.</b>
                </li>
            </ul>
             ' . $important . '     
            
            <h3 class="text"><mark>
                If the Technical Interview cannot proceed due to poor audio or video quality or connection issues,
                applicants will be recommended “Unsuccessful” and they will need to apply for a reassessment
                    for their technical interview at a cost of $450.00 (Pathway 2) or $1,000 (Pathway 1). There may
                    also be a 2-4 week wait for another appointment, depending on assessor’s availability.</mark>
            </h3>
            <br>
            ' . $do_you . '  
            <div style="text-align: center;margin-top:15px;margin-bottom:15px;">
             ' . $checked .'
                <label>Yes</label>
                  ' . $checked2 .'
                <label>No</label>
            </div>
            
            
             <table> <tr colspan="5">
            <td class="notes" >By submitting the Stage 3 application, I confirm that I have discussed the above-mentioned  criteria & the consequences with the applicant.</td>
            </tr>
            </table>
            <table class="table-responsive">
                <tr>
                    <td class="tbldata"> <b>Agent Name</b></td>
                     <td class="tmp">' . $agent_name . '</td>
                </tr>
                <tr>
                    <td class="tbldata"><b>Applicant Name</b></td>
                     <td class="tmp">' . $applicant_name . '</td>
                </tr>
                <tr>
                    <td class="tbldata"> <b>Application No.</b></td>
                    <td class="tmp">[#' . $applicant_no . ']</td>
                </tr>
                <tr>
                    <td class="tbldata"><b>Date Submitted</b></td>
                     <td class="tmp">' . $current_date . '</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
';
 require_once "dompdf/autoload.inc.php";
        $dompdf = new Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->loadhtml($html);
        $dompdf->setpaper('A4', 'portrait');
        $dompdf->set_option("isPhpEnabled", true); //
        $dompdf->render();
        
        // if (!empty($file_name)) {
        //     $dompdf->stream($file_name);
        // } else {
        //     $dompdf->stream('review & confirm');
        // }
    //  $pointer_id=10;
        // $output = $dompdf->output();
        $sss = "public/application/" . $pointer_id . "/stage_3_R/";
        if (!is_dir($sss)) {
            // create the directory path if it does not exist
            mkdir($sss, 0777, true);
        }
        
        $sss__path = "public/application/" . $pointer_id . "/stage_3_R";
        $sss = "public/application/" . $pointer_id . "/stage_3_R/".$pdf_name;
        file_put_contents($sss, $dompdf->output());
      $isAlreadyThere = $this->documents_model->where(["pointer_id" => $pointer_id, "stage" => "stage_3_R", "required_document_id" => 55])->first();
       if(!$isAlreadyThere){
         $data = array(
                                    'pointer_id' => $pointer_id,
                                    'stage' => 'stage_3_R',
                                    'required_document_id' => 55,
                                    'employee_id' => 0,
                                    'name' => $document_name__,
                                    'document_name' => $pdf_name,
                                    'document_path' => $sss__path,
                                    'status' => 1,
                                    'update_date' => date("Y-m-d H:i:s"),
                                    'create_date' => date("Y-m-d H:i:s")
                                );
                                
                             // print_r($data);
                                $this->documents_model->insert($data);
                   
    }
   
    } 
   function submit_pageseconds3($ENC_pointer_id)
    {
        
          $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        
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
                $stage_3__= $this->stage_3_reassessment_model->where(['pointer_id' => $pointer_id])->first();
              
              $preference_location_comment = "";
            if (!empty($stage_3__)) {
                $preference_location = trim($stage_3__['preference_location']);
                $preference_comment = trim($stage_3__['preference_comment']);
                $preference_comment = trim($preference_comment, "\xC2\xA0");
                $preference_comment = str_replace("&nbsp;", '', $preference_comment);
                if (!empty($preference_location)) {
                    $preference_location_comment .= "<b>Applicant's Preferred Venue: " . $preference_location;
                }
                if (!empty($preference_comment)) {
                    // $preference_location_comment .= "<br><br><u> Comments: </u><br>" . $preference_comment . "</b>";
                    $preference_location_comment .= "<br><br><u> Comments: </u><br><i>\"" . $preference_comment . "\"</i></b>";
                }
            }
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") { // Applicant
                // s3_submitted_agent
                $mail_temp_4 = $this->mail_template_model->where(['id' => '162'])->first();
                if (!empty($mail_temp_4)) {
                    $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                    $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                    $message = str_replace('%preference_location_comment%', $preference_location_comment, $message);
                    // echo $message;
                    // exit;
                    $to =  $email;
                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], [], $pointer_id);
                    if ($check == 1) {
                        $email_send_agent_applicant = true;
                    }
                } // email template
            }
            if ($client_type == "Applicant") { // 
                // s3_submitted_applicant
                $mail_temp_4 = $this->mail_template_model->where(['id' => '174'])->first();
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
        $mail_temp_4 = $this->mail_template_model->where(['id' => '91'])->first();
        if (!empty($mail_temp_4)) {
            $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
            $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
            $stage_3_ = $this->stage_3_reassessment_model->where(['pointer_id' => $pointer_id])->first();

            $preference_location_comment = "";
            if (!empty($stage_3_)) {
                $preference_location = trim($stage_3_['preference_location']);
                $preference_comment = trim($stage_3_['preference_comment']);
                $preference_comment = trim($preference_comment, "\xC2\xA0");
                $preference_comment = str_replace("&nbsp;", '', $preference_comment);
                if (!empty($preference_location)) {
                    $preference_location_comment .= "<b>Applicant's Preferred Venue: " . $preference_location;
                }
                if (!empty($preference_comment)) {
                    // $preference_location_comment .= "<br><br><u> Comments: </u><br>" . $preference_comment . "</b>";
                    $preference_location_comment .= "<br><br><u> Comments: </u><br><i>\"" . $preference_comment . "\"</i></b>";
                }
            }

            $stage_3_Docs = $this->documents_model->where(['pointer_id' => $pointer_id, 'required_document_id' => 19, 'stage' => "stage_3_R"])->first();
            $addAttachment = array(
                [
                    'file_path' => $stage_3_Docs['document_path'] . '/' . $stage_3_Docs['document_name'],
                    'file_name' => $stage_3_Docs['document_name'],
                ]
            );
            
            
            // If Online Via Zoom then add Exception Form
            // Get the Occupation
            $enroll_stage_4 = false;
            $occupation = $this->stage_1_occupation_model->where("pointer_id", $pointer_id)->asObject()->first();
            if($occupation->pathway == "Pathway 1"){
                if($occupation->occupation_id == 7 || $occupation->occupation_id == 18){
                    $enroll_stage_4 = true;
                }
            }
            // end
            // echo $enroll_stage_4;
            // exit;
            
            if($enroll_stage_4 == false){
                if($preference_location == "Online (Via Zoom)"){
                    $stage_3_Docs_ex = $this->documents_model->where(['pointer_id' => $pointer_id, 'required_document_id' => 55, 'stage' => "stage_3_R"])->first();
                     $addAttachment_ex = array(
                        [
                            'file_path' => $stage_3_Docs_ex['document_path'] . '/' . $stage_3_Docs_ex['document_name'],
                            'file_name' => $stage_3_Docs_ex['document_name'],
                        ]
                    );
                    array_push($addAttachment, ...$addAttachment_ex);
                }
            }
            // print_r($addAttachment);
            // exit;
            
            $message = str_replace('%preference_location_comment%', $preference_location_comment, $message);
            // echo $messege;
            // die;
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'),  env('ADMIN_EMAIL'), $subject, $message, [], [], [], $addAttachment, $pointer_id);
            // echo $check;
            // exit;
            if ($check == 1) {
                $email_send_admin = true;
            }
        }
        // echo "First = ".$email_send_agent_applicant."Second = ".$email_send_admin;
        // exit;
    //  $stage_3__= $this->documents_model->where(['pointer_id' => $pointer_id,'required_document_id'=>55])->first();
    
   //  $stage_3_data__ = $this->documents_model->where('pointer_id', $pointer_id)->where('required_document_id', 55)->first();
      if($stage_3_['exemption_form'] == 'Agent TI Declaration.pdf'){
          $agennt="yes";
      }else{
          $agennt=null;
      }
 
        if ($email_send_agent_applicant && $email_send_admin) {
            $is_update = $this->stage_3_reassessment_model->set([
                "status" => "Submitted",
                "submitted_date" => date("Y-m-d H:i:s"),
                "agent_applicant"=>$agennt,
                "exemption_yes_no"=>'no'
            ])->where("pointer_id", $pointer_id)->update();
            
            if ($is_update) {
                $is_pointer_update = $this->application_pointer_model->set([
                    "stage" => "stage_3_R",
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
