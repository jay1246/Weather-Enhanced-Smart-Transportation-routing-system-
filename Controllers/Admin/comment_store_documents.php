<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class comment_store_documents extends BaseController
{
    
    // Comment Logic
    public function show_s1_s2_s3_comments(){
        $pointer_id = $this->request->getPost("pointer_id");
        // Make STD Class
        
        $json = [];
        // echo $pointer_id;
        // get the personal details
        
        
        $stage_1_comment = $this->stage_1_model->where("pointer_id", $pointer_id)->first();
        $application_pointer_ = $this->application_pointer_model->where("id", $pointer_id)->first();
        
        $json["current_stage"] = $application_pointer_["stage"];
        $json["current_status"] = $application_pointer_["status"];
        $json["pointer_id"] = $pointer_id;
        $json["stage_1_comment_msg"] = "";
        $json["application_no"] = "[#T.B.A]";
        $json["occupation"] = "";
        $json["applicant_name"] = "";
        if($stage_1_comment){
            // Check for S1 option
            $json["stage_1_comment_msg"] = $stage_1_comment["approved_comment"];
            $json["application_no"] = ($stage_1_comment["unique_id"]) ? "[#".$stage_1_comment["unique_id"]."]" : "[#T.B.A]";
            $stage_1_occupation = $this->stage_1_occupation_model->where("pointer_id", $pointer_id)->first();
            if($stage_1_occupation){
                $occupation_list_model = $this->occupation_list_model->where("id", $stage_1_occupation["occupation_id"])->first();
                $json["occupation"] = $occupation_list_model["name"];    
            }
            
            // s1_p.first_or_given_name, s1_p.middle_names, s1_p.surname_family_name
            $stage_1_personal_details = $this->stage_1_personal_details_model->where("pointer_id", $pointer_id)->first();
            if($stage_1_personal_details){
                $full_name = "";
                if($stage_1_personal_details["first_or_given_name"]){
                    $full_name = $stage_1_personal_details["first_or_given_name"];
                }
                
                if($stage_1_personal_details["middle_names"]){
                    $full_name .= " ".$stage_1_personal_details["middle_names"];
                }
                
                
                if($stage_1_personal_details["surname_family_name"]){
                    $full_name .= " ".$stage_1_personal_details["surname_family_name"];
                }
                
                // print_r($stage_1_personal_details);
                $json["applicant_name"] = $full_name;
            }
            
        }
        
        // Check for S2 option
        $stage_2_comment = $this->stage_2_model->where("pointer_id", $pointer_id)->first();
        $json["stage_2_comment_msg"] = "";
        $json["stage_2_comment_docs"] = "";
        if($stage_2_comment){
            $json["stage_2_comment_msg"] = $stage_2_comment["approved_comment"];
            $json["stage_2_comment_docs"] = $this->getStageWiseData($pointer_id, "stage_2");
        }
        
        // Check for S3 option
        $stage_3_comment = $this->stage_3_model->where("pointer_id", $pointer_id)->first();
        $json["stage_3_comment_msg"] = "";
        $json["stage_3_comment_docs"] = "";
        if($stage_3_comment){
            $json["stage_3_comment_msg"] = $stage_3_comment["approved_comment"];
            $json["stage_3_comment_docs"] = $this->getStageWiseData($pointer_id, "stage_3");
        }
        
        
        // Passing Role in Session
        $json["admin_account_type"] = session()->get('admin_account_type');
        
        // print_r($json);
        echo json_encode($json);
        
    }
    
    public function getStageWiseData($pointer_id, $stage){
        $stage_datas = $this->comment_store_documents_model->where(["pointer_id"=> $pointer_id, "stage" => $stage])->findAll();
        $json = [];
        foreach($stage_datas as $stage_data){
            if($stage_data["document_id"] != 0){
                $docs = $this->documents_model->find($stage_data["document_id"]);
                $docs["full_path"] = base_url()."/".$docs["document_path"]."/".$docs["document_name"];
                $stage_data["documents_full_link"] = $docs["full_path"];
            }
            array_push($json, $stage_data);
        }
        
        return $json;
        
    }
    
    public function show_s1_s2_s3_comments_single_delete(){
        $pointer_id = $this->request->getPost("pointer_id");
        $table_name = $this->request->getPost("table_name");
        
        $this->delete_comments_kernel__($pointer_id, [$table_name]);
        
        echo getTheCurrentMessageStatusThere($pointer_id);
        
    }
    
    public function show_s1_s2_s3_comments_all_delete(){
        $pointer_id = $this->request->getPost("pointer_id");
        
        echo $this->delete_comments_kernel__($pointer_id, ["stage_1","stage_2","stage_3"]);
        
    }
    
    public function delete_comments_kernel__($pointer_id, $delete_array){
        
        $callback = false;
        if(in_array("stage_1", $delete_array)){
            if($this->stage_1_model->where("pointer_id", $pointer_id)->first()){
                $callback = $this->stage_1_model->where("pointer_id", $pointer_id)->set(["approved_comment" => ""])->update();
                $callback = $this->comment_store_documents_model->where(["pointer_id"=> $pointer_id, "stage" => "stage_1"])->delete();
            }
        }
        if(in_array("stage_2", $delete_array)){
            if($this->stage_2_model->where("pointer_id", $pointer_id)->first()){
                $callback = $this->stage_2_model->where("pointer_id", $pointer_id)->set(["approved_comment" => ""])->update();
                $ap = $this->application_pointer_model->find($pointer_id);
                if($ap["stage"] == "stage_2" && $ap["status"] == "Approved"){
                    $this->delete_docs_comment($pointer_id, "stage_2");
                }
                $callback = $this->comment_store_documents_model->where(["pointer_id"=> $pointer_id, "stage" => "stage_2"])->delete();
            }
        }
        if(in_array("stage_3", $delete_array)){
            if($this->stage_3_model->where("pointer_id", $pointer_id)->first()){
                $callback = $this->stage_3_model->where("pointer_id", $pointer_id)->set(["approved_comment" => ""])->update();
                $ap = $this->application_pointer_model->find($pointer_id);
                if($ap["stage"] == "stage_3" && $ap["status"] == "Approved"){
                    $this->delete_docs_comment($pointer_id, "stage_3");
                }
                $callback = $this->comment_store_documents_model->where(["pointer_id"=> $pointer_id, "stage" => "stage_3"])->delete();
            }
        }
        return $callback;
    }
    
    public function delete_docs_comment($pointer_id, $stage){
        $docs = $this->comment_store_documents_model->where(["pointer_id"=> $pointer_id, "stage" => $stage, "document_id<>" => 0])->findAll();
        $docs = array_column($docs, "document_id");
        return $this->documents_model->whereIn("id", $docs)->delete();
    }
    
    // End Comment Logic
    
   public function insertTheFile(){

        $pointer_id = $this->request->getPost("pointer_id");
        $table_name = $this->request->getPost("table_name");
        $input_data = $this->request->getPost("input_data");
        $id = $this->request->getPost("id");
        
        $data_fetch = [
            "pointer_id" =>  $pointer_id,
            "stage" => $table_name,
            "name" => $input_data,
            "send_by" => session()->get('admin_id'),
            ];
        
        if($id != ""){
            $return_data = $this->comment_store_documents_model->update($id, $data_fetch);
                
            $fetch_data = $this->comment_store_documents_model->find($id);
        }
        else{
        
            $return_data = $this->comment_store_documents_model->insert($data_fetch);
                
            $fetch_data = $this->comment_store_documents_model->find($return_data);
        }
        echo json_encode($fetch_data);
        // echo $table_name;
        // exit;
   }
   
   public function deleteTheRecord(){
       $id = $this->request->getPost("id");
       echo $this->comment_store_documents_model->delete($id);
   }
}
