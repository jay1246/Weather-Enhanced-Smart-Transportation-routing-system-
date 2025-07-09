<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

// stage 2 -------------------------------- 

class add_employment_document extends BaseController
{
    public function add_employment_document_page($ENC_pointer_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->first();
        if (!empty($application_pointer)) {
            $required_documents_list = $this->required_documents_list_model->where(['stage' => 'stage_2'])->find();
            $documents = $this->documents_model->where(['stage' => 'stage_2', 'pointer_id' => $pointer_id])->find();
            $add_employment_TB = $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id])->find();

            $data =  [
                'add_employment_TB' => $add_employment_TB,
                'documents_TB' => $documents,
                'page' => 'Add Employe Document',
                'ENC_pointer_id' => $ENC_pointer_id,
            ];
            return view('user/stage_2/add_employment_document', $data);
        }
    }

    // Employment Documents start
    public function add_employment_document_list_($ENC_pointer_id)
    {
        $html = "";
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->first();
        if (!empty($application_pointer)) {
            $employer_id = $_POST['employer_id'];
            $add_employment_TB = $this->stage_2_add_employment_model->where(['id' => $employer_id, 'pointer_id' => $pointer_id])->first();
            $employe_type = $add_employment_TB['employment_type'];
            if($employe_type =="Self employed"){
                $required_documents_list = $this->required_documents_list_model->where(['stage' => 'stage_2', 'category' => 'self_employment_documents'])->find();
                if(!empty($required_documents_list)) {
                    $html .= '<select class="form-select" name="employment_document_list" onchange="GET_employment_document_info(this.value,' . $employer_id . ')">
                    <option selected > Choose Document </option>';
                    
                    foreach ($required_documents_list as $key => $value) {
                         if($value["id"] == 18){
                            
                                $is_required = $value['is_required'];
                                $is_required = ($is_required) ? ' *' : '';
                                $html .= '<option value="' . $value['id'] . '">' . $value['document_name'] . '' . $is_required . '</option>';
                                continue;
                        }
                        $file_exist = $this->documents_model->where(['pointer_id' => $pointer_id, 'stage' => 'stage_2', 'employee_id' => $employer_id, 'required_document_id' => $value['id']])->first();
                        if (!$file_exist) {
                            $publish = $value['publish'];
                            if ($publish) {
                                $is_required = $value['is_required'];
                                $is_required = ($is_required) ? ' *' : '';
                                $html .= '<option value="' . $value['id'] . '">' . $value['document_name'] . '' . $is_required . '</option>';
                            }
                        }
                    }
                    $html .= '</select>';
                }   
            }else{
            $required_documents_list = $this->required_documents_list_model->where(['stage' => 'stage_2', 'category' => 'employment_documents'])->find();
                //   echo $this->required_documents_list_model->getLastQuery();
                if(!empty($required_documents_list)) {
                    $html .= '<select class="form-select" name="employment_document_list" onchange="GET_employment_document_info(this.value,' . $employer_id . ')">
                    <option selected > Choose Document </option>';
                    // print_r($required_documents_list);
                    foreach ($required_documents_list as $key => $value) {
                        
                        // print_r($value);
                        // For Other Docs
                        if($value["id"] == 18){
                            
                                $is_required = $value['is_required'];
                                $is_required = ($is_required) ? ' *' : '';
                                $html .= '<option value="' . $value['id'] . '">' . $value['document_name'] . '' . $is_required . '</option>';
                                continue;
                        }
                        
                        $file_exist = $this->documents_model->where(['pointer_id' => $pointer_id, 'stage' => 'stage_2', 'employee_id' => $employer_id, 'required_document_id' => $value['id']])->first();
                        if (!$file_exist) {
                            $publish = $value['publish'];
                            if ($publish) {
                                $is_required = $value['is_required'];
                                $is_required = ($is_required) ? ' *' : '';
                                $html .= '<option value="' . $value['id'] . '">' . $value['document_name'] . '' . $is_required . '</option>';
                            }
                        }
                        
                        
                    }
                    $html .= '</select>';
                }
            }
        }


        // echo $html;
        // exit;
        return json_encode($html);
    }

    // Employment Documents inpud foerm
    public function add_employment_document_info_($ENC_pointer_id)
    {
        $html = "";
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->first();
        if (!empty($application_pointer)) {
            $document_id = $_POST['document_id'];
            $employer_id = $_POST['employer_id'];

            // get company_organisation_name for understand 
            $stage_2_add_employment_model = $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id, 'id' => $employer_id])->first();
            $company_organisation_name = $stage_2_add_employment_model['company_organisation_name'];
            $add_employment_TB = $this->stage_2_add_employment_model->where(['id' => $employer_id, 'pointer_id' => $pointer_id])->first();
            $employe_type = $add_employment_TB['employment_type'];
            if($employe_type =="Self employed"){
                $employment_type = 'self_employment_documents';
            }else{
                $employment_type = 'employment_documents';
            }
                $required_documents_list = $this->required_documents_list_model->where(['id' => $document_id, 'stage' => 'stage_2', 'category' => $employment_type])->first();
                if (!empty($required_documents_list)) {
                    $required_document_id = $required_documents_list['id'];
                    $stage = $required_documents_list['stage'];
                    $category = $required_documents_list['category'];
                    $document_name = $required_documents_list['document_name'];
                    $allowed_type = json_decode($required_documents_list['allowed_type']);
                    $is_multiple = $required_documents_list['is_multiple'];
                    $is_required = $required_documents_list['is_required'];
                    $is_required = ($is_required) ? 'require' : '';
                    
                     if($document_name == 'Other'){
                         $other_required='required';
                     }
    
                    $accept = "";
                    $accept_note = "";
                    $CHECK_LOOP = 0;
                    $brack_point = count($allowed_type) - 1;
                    foreach ($allowed_type as $key => $value) {
                        $accept .= '.' . $value . ',';
                        $accept_note .= ' .' . $value;
                        $CHECK_LOOP++;
                        if ($CHECK_LOOP <= $brack_point) {
                            $accept_note .=   ' /';
                        }
                    }
    
    
                    $note = $required_documents_list['note'];
                    $publish = $required_documents_list['publish'];
                    if ($publish) {
                        // for singal file 
                        if (!$is_multiple) {
                            if (!empty($note)) {
                                $html .= '<div class="bg-warning rounded mt-3 mb-2 p-1">
                                        <p style="font-size: 13px; padding-left:5px; " > <b> Note : </b> </p>
                                        <ul style="padding: 0px; padding-left:25px; margin-top: -14px;">
                                            <li style="font-size: 13px;"> 
                                            ' . $note . '
                                            </li> <!-- 29-Aug-2022 / vishal h patel  -->
                                        </ul>
                                    </div>';
                            }
    
                            $html .= '<form  onsubmit="submit()" id="stage_2_employe_form" action="' . base_url('user/stage_2/employe_document_upload_/' . $ENC_pointer_id) . '" method="post" enctype="multipart/form-data">';
                            $html .= ' <input class="form-control" onchange="file_select_(this)" type="file"  name="file" accept="' . $accept . '" ' . $is_required . '  />';
                            $html .= ' <input type="hidden"  name="file_name" value="' . $document_name . '"  />';
                            $html .= ' <input type="hidden"  name="employer_id" value="' . $employer_id . '" />';
                            $html .= ' <input type="hidden"  name="company_organisation_name" value="' . $company_organisation_name . '" />';
                            $html .= ' <input type="hidden"  name="required_document_id" value="' . $required_document_id . '" />';
                            // $html .= ' <input type="hidden"  name="ENC_pointer_id" value="' . $ENC_pointer_id . '" />';
    
    
                            $html .= '<div class="text-danger">
                                                 Only : ' . $accept_note . '
                                            </div>';
    
                            $html .= ' <div class="col-sm-12 mt-3 text-center" id="employe_document_btn" style="display: none;">
                                                <button type="submit" class="btn btn_green_yellow" onclick="submit()"> Upload Document </button>
                                             </div>';
                            $html .= '</form>';
    
                            return json_encode($html);
                        }
    
                        // for Multi file 
                        if ($is_multiple) {
                            if (!empty($note)) {
                                $html .= '<div class="bg-warning rounded mt-3 mb-2 p-1">
                                            <p style="font-size: 13px; padding-left:5px; ">Note:</p>
                                            <ul style="padding: 0px; padding-left:25px; margin-top: -14px;">
                                                <li style="font-size: 13px;"> 
                                                ' . $note . '
                                                </li> <!-- 29-Aug-2022 / vishal h patel  -->
                                            </ul>
                                        </div>';
                            }
    
                            $html .= '<form  onsubmit="submit()"   id="stage_2_employe_form" action="' . base_url('user/stage_2/employe_document_multiple_upload_/' . $ENC_pointer_id) . '" method="post" enctype="multipart/form-data">';
                            $html .= '<div class="row">';
                            $html .=    '<div class="col-sm-6">
                                            <input class="form-control " type="text"  name="file_name[]" required />
                                        </div>';
                            $html .=    '<div class="col-sm-5">
                            <!-- onchange="file_select_(this)"  -->
                                             <input class="form-control col-sm-4"  onchange="file_select_(this)" type="file"   name="files[]" accept="' . $accept . '" required  />
                                        </div>';
                            $html .=    '<div class="col-sm-1">
                                            <button type="button" onclick="add_more_input_(\'add_more_input_for_multiple\')" class="btn btn-danger delete_button ml-3">
                                                <i class="bi bi-plus-lg"></i>
                                            </button>
                                        </div>';
                            $html .= '</div> <!-- row -->';
                            $html .= '<div  class="row" id="add_more_input_for_multiple">';
                            $html .= '</div> <!-- row add_more_input_for_multiple -->';
    
                            $html .= '<div class="row">
                                        <div class="col-sm-6">
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="text-danger"> 
                                                Only : ' . $accept_note . '  
                                            </div>
                                        </div>
                                    </div>';
    
                            $html .= ' <input type="hidden"  name="employer_id" value="' . $employer_id . '" />';
                            $html .= ' <input type="hidden"  name="company_organisation_name" value="' . $company_organisation_name . '" />';
                            $html .= ' <input type="hidden"  name="required_document_id" value="' . $required_document_id . '" />';
                            // $html .= ' <input type="hidden"  name="ENC_pointer_id" value="' . $ENC_pointer_id . '" />';
    
                            $html .= ' <div class="col-sm-12 mt-3 text-center" id="employe_document_btn" style="display: none;">
                                <button type="submit" class="btn btn_green_yellow" onclick="submit()"> Upload Document </button>
                             </div>';
                            $html .= '</form>';
    
    
    
    
                            return json_encode($html);
                        }
                    }
                } else { // stage 2 document list not found
                    $html = "";
                } 
                      

            
        } // pinter invalid 
    }

    public function employe_document_upload_($ENC_pointer_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        // echo $pointer_id;
        // exit;
        $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->first();
        if (!empty($application_pointer)) {
            // file data and file name 
            $file =  $this->request->getFile('file');
            $file_name =  $this->request->getVar('file_name');
            $employer_id =  $this->request->getVar('employer_id');
            $required_document_id = $this->request->getVar('required_document_id');
            $company_organisation_name =  $this->request->getVar('company_organisation_name');
            $company_organisation_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $company_organisation_name); // Removes special chars.
            $company_organisation_name = trim(str_replace(' ', '_', $company_organisation_name));

            $File_extention = $file->getClientExtension();
            $file_size = $file->getSize();

            $document_name = clean_URL($file_name);
            $file_name_with_extantion = $document_name . '.' . $File_extention;  // file.jpg

            $folder_path = 'public/application/' . $pointer_id . '/stage_2/' . $company_organisation_name;

            // move file to folder 
            $is_move = $file->move($folder_path, $file_name_with_extantion, true);
            if ($is_move) {

                // insert into SQL if not exist
                $files = [
                    'pointer_id' => $pointer_id,
                    'stage' => 'stage_2',
                    'employee_id' => $employer_id,
                    'required_document_id' => trim($required_document_id),
                    'name' => $file_name,
                    'document_name' => $file_name_with_extantion,
                    'document_path' => $folder_path,
                    'document_type' => '',
                    'status' => 1
                ];
                $file_exist = $this->documents_model->where($files)->first();
                if (!$file_exist) {
                    $is_insert =   $this->documents_model->insert($files);
                    if ($is_insert) {
                        $this->session->setFlashdata('msg', ' Documents Uploaded Successfully.');
                        return redirect()->back();
                    } else {
                        $this->session->setFlashdata('error_msg', 'Sorry!  Document Not Uploaded.');
                        return redirect()->back();
                    }
                } else {
                    return redirect()->back();
                }
            } else {
                $this->session->setFlashdata('error_msg', 'Sorry!  Document Not Uploaded.');
                return redirect()->back();
            }
        }
    }

    public function employe_document_multiple_upload_($ENC_pointer_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        
        $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->first();
        if (!empty($application_pointer)) {


            $required_document_id = $this->request->getVar('required_document_id');
            $All_file_name =  $this->request->getVar('file_name'); // in array
            $All_file =  $this->request->getFileMultiple('files'); // in array
            // file data and file name 
            $employer_id =  $this->request->getVar('employer_id');
            $company_organisation_name =  $this->request->getVar('company_organisation_name');
            $company_organisation_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $company_organisation_name); // Removes special chars.
            $company_organisation_name = trim(str_replace(' ', '_', $company_organisation_name));


            // return response to ajax
            $array = [
                'status' => '0',
                'msg' => "Sorry File Not Uploaded.",
            ];

            // print_r(count($All_file));
            // exit;

            foreach ($All_file as $key => $res) {
                
                $file_name = $All_file_name[$key];
                // echo $file_name;
                // exit;
                $file = $All_file[$key];
                $File_extention = $file->getClientExtension();  // .jpg, .png
                $file_size = $file->getSize();
                if (empty($file_size)) {
                    $this->session->setFlashdata('msg', 'Sorry! File not Found, Please select valid File.');
                    return redirect()->back();
                }
                // 20 MB allow
                if ($file_size > 20485760) {
                    $this->session->setFlashdata('msg', '"File size is too Big, please select a file less than 5mb."');
                    return redirect()->back();
                }
                // create file name if not exist 
                if (isset($File_name) && empty($File_name)) {
                    $File_name = 'employe_document_' . $key;
                }

                $document_name = clean_URL($file_name);
                $file_name_with_extantion = $document_name . '.' . $File_extention;  // file.jpg

                $folder_path = 'public/application/' . $pointer_id . '/stage_2/' . $company_organisation_name;
                // echo $folder_path.$file_name_with_extantion;
                // exit;
                // move file to folder 
                echo $is_move = $file->move($folder_path, $file_name_with_extantion, true);
                
                if ($is_move) {
                    // insert into SQL if not exist
                    $files = [
                        'pointer_id' => $pointer_id,
                        'stage' => 'stage_2',
                        'employee_id' => $employer_id,
                        'required_document_id' => trim($required_document_id),
                        'name' => $file_name,
                        'document_name' => $file_name_with_extantion,
                        'document_path' => $folder_path,
                        'document_type' => '',
                        'status' => 1
                    ];
                    $file_exist = $this->documents_model->where($files)->first();
                    if (!$file_exist) {
                        $is_insert =   $this->documents_model->insert($files);
                        if ($is_insert) {
                            echo "Uploaded <br> ";
                            $this->session->setFlashdata('msg', ' Documents Uploaded Successfully.');
                            // return redirect()->back();
                        } else {
                            echo "Not Uploaded <br>";
                            $this->session->setFlashdata('error_msg', 'Sorry!  Document Not Uploaded.');
                            // return redirect()->back();
                        }
                    } else {
                        echo "file exist <br> ";
                        return redirect()->back();
                    }
                } else {
                    echo "not move <br> ";

                    $this->session->setFlashdata('error_msg', 'Sorry!  Document Not Uploaded.');
                    return redirect()->back();
                }
            } // for loop
            // exit;
            echo "ok  <br> ";

            return redirect()->back();
        } // invalid pointer 
    }

    // Assessment Documents start 
    public function assessment_documents_list_($ENC_pointer_id)
    {
        $html = "";
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $stage_1_occupation = $this->stage_1_occupation_model->where(['pointer_id' => $pointer_id])->first();
        if (!empty($stage_1_occupation)) {
            $pathway = $stage_1_occupation['pathway'];
            $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->first();
            if (!empty($application_pointer)) {
                $required_documents_list = $this->required_documents_list_model->where(['stage' => 'stage_2', 'category' => 'assessment_documents'])->find();
                if (!empty($required_documents_list)) {
                    // print_r($required_documents_list);
                    //     die;
                    
                    
                    $html .= '<select class="form-select" id="assessment_docs_type" onchange="GET_assessment_documents_info(this.value)">
                   <option selected > Choose Document </option>';
                    $other__html = "";
                    // print_r($required_documents_list);
                    
                    foreach ($required_documents_list as $key => $value) {
                        $file_show = true;
                        
                         $dispaly_document_name = '';  
                        // hide Suporting Avidans For Application Kit from pathway 1 
                        $occupation_id = $stage_1_occupation['occupation_id'];
                        // echo $occupation_id;
                                           if($occupation_id == 18 && $occupation_id == 7)
                        {
                            if ($value['id'] == 16) {
                                $dispaly_document_name = "display:none";
                               
                            }
                            if ($value['id'] == 34) {
                                $dispaly_document_name = "display:none";
                                
                            }
                        }else{
                            $dispaly_document_name = '';
                            
                            if ($value['id'] == 53) {
                                $dispaly_document_name = "display:none";
                                
                            }
                        }
                        
                         if($occupation_id == 7 && $pathway == "Pathway 1")
                        {
                            if ($value['id'] == 16) {
                                $dispaly_document_name = "display:none";
                                
                            }
                            if ($value['id'] == 34) {
                                $dispaly_document_name = "display:none";
                                
                            }
                            if ($value['id'] == 53) {
                                $dispaly_document_name = "";
                            }
                            
                        }
                        else if($occupation_id == 18){
                            if ($value['id'] == 16) {
                                $dispaly_document_name = "display:none";
                                
                            }
                            if ($value['id'] == 34) {
                                $dispaly_document_name = "display:none";
                               
                            }
                            if ($value['id'] == 53) {
                                $dispaly_document_name = "display:none";
                                
                            }
                        }
                        else{
                            $dispaly_document_name = '';
                            
                            if ($value['id'] == 53) {
                                $dispaly_document_name = "display:none";
                                
                            }
                        }
                        // hide Suporting Avidans For Application Kit from pathway 2
                        if ($pathway != "Pathway 1") {
                            if ($value['id'] == 16) {
                                $file_show = false;
                            }
                            if ($value['id'] == 34) {
                                $file_show = false;
                            }
                        }
     

                        if ($file_show) {
                            if ($value['id'] == 30) {
                                // $publish = $value['publish'];
                                // if ($publish) {
                                //     $is_required = $value['is_required'];
                                //     $is_required = ($is_required) ? ' *' : '';
                                //     $html .= '<option value="' . $value['id'] . '">' . $value['document_name'] . '' . $is_required . '</option>';
                                // }
                            } else {
                                $file_exist = $this->documents_model->where(['pointer_id' => $pointer_id, 'stage' => 'stage_2', 'required_document_id' => $value['id']])->first();
                                if (!$file_exist || $value["id"] == 16) {
                                    $publish = $value['publish'];
                                    if($value["id"] == 56 || $value["id"] == 57){
                                        // exit;
                                        if($occupation_id == 5 && $pathway == "Pathway 1"){
                                            $publish = "";
                                        }
                                        else{
                                            $publish = "";
                                        }
                                    }
                                    
                                    if($value["id"] == 34){
                                        if($occupation_id == 5 && $pathway == "Pathway 1"){
                                            $publish = "yes";
                                        }
                                        else{
                                            $publish = "yes";
                                        }
                                    }
                                    
                                    if ($publish) {
                                        $is_required = $value['is_required'];
                                        $is_required = ($is_required) ? ' *' : '';
                                        // 

                                        $is_required = ($file_exist) ? "" : $is_required;
                                        if($dispaly_document_name != ""){
                                            continue;
                                        }
                                        // 
                                        $html .= '<option style="'. $dispaly_document_name .'" value="' . $value['id'] . '">' . $value['document_name'] . '' . $is_required . '</option>';
                                        
                                    }
                                }
                            }
                            if ($value['id'] == 30) {
                                $publish = $value['publish'];
                                if ($publish) {
                                    $is_required = $value['is_required'];
                                    $is_required = ($is_required) ? ' *' : '';
                                    $other__html = '<option style="'. $dispaly_document_name .'" value="' . $value['id'] . '">' . $value['document_name'] . '' . $is_required . '</option>';
                                }
                            }
                        }
                    }
                    $html .= $other__html.'</select>';
                }
            }
        } // stage_1_occupation pathway not found
        return json_encode($html);
    }

    public function assessment_documents_info_($ENC_pointer_id)
    {
        $html = "";
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->first();
        if (!empty($application_pointer)) {
            $document_id = $_POST['document_id'];
            $required_documents_list = $this->required_documents_list_model->where(['id' => $document_id, 'stage' => 'stage_2', 'category' => 'assessment_documents'])->first();

            if (!empty($required_documents_list)) {

                $required_document_id = $required_documents_list['id'];
                $stage = $required_documents_list['stage'];
                $category = $required_documents_list['category'];
                $document_name = $required_documents_list['document_name'];
                $allowed_type = json_decode($required_documents_list['allowed_type']);
                $is_multiple = $required_documents_list['is_multiple'];
                $is_required = $required_documents_list['is_required'];
                $is_required = ($is_required) ? 'required' : '';

                $accept = "";
                $accept_note = "";
                $CHECK_LOOP = 0;
                $brack_point = count($allowed_type) - 1;
                foreach ($allowed_type as $key => $value) {
                    $accept .= '.' . $value . ',';
                    $accept_note .= ' .' . $value;
                    $CHECK_LOOP++;
                    if ($CHECK_LOOP <= $brack_point) {
                        $accept_note .=   ' /';
                    }
                }

                $note = $required_documents_list['note'];
                $publish = $required_documents_list['publish'];
                if ($publish) {

                    // for singal file 
                    if (!$is_multiple) {

                        if (!empty($note)) {
                            $html .= '<div class="bg-warning rounded mt-3 mb-2 p-1">
                                    <p style="font-size: 13px;text-decoration: underline;">Note:</p>
                                    <ul style="padding: 0px; padding-left:20px; margin-top: -14px;">
                                        <li style="font-size: 13px;"><b>
                                        ' . $note . '
                                        </b></li> <!-- 29-Aug-2022 / vishal h patel  -->
                                    </ul>
                                </div>';
                        }

                        $html .= '<form  onsubmit="submit()" id="Assessment_Documents_form" action="' . base_url('user/stage_2/assessment_documents_upload_/' . $ENC_pointer_id) . '" method="post" enctype="multipart/form-data">';
                        $html .= ' <input class="form-control" onchange="file_select_(this)" type="file"  name="file" accept="' . $accept . '" ' . $is_required . '  />';
                        $html .= ' <input type="hidden"  name="file_name" value="' . $document_name . '" />';
                        $html .= ' <input type="hidden"  name="required_document_id" value="' . $required_document_id . '" />';
                        // $html .= ' <input type="hidden"  name="ENC_pointer_id" value="' . $ENC_pointer_id . '" />';


                        $html .= '<div class="text-danger">
                                             Only : ' . $accept_note . '
                                        </div>';

                        $html .= ' <div class="col-sm-12 mt-3 text-center" id="employe_document_btn" style="display: none;">
                                            <button type="submit" class="btn btn_green_yellow" onclick="submit()"> Upload Document </button>
                                         </div>';
                        $html .= '</form>';
                    }

                    // for multiple file 
                    if ($is_multiple) {

                        if (!empty($note)) {
                            $html .= '<div class="bg-warning rounded mt-3 mb-2 p-1">
                                    <p style="font-size: 13px;text-decoration: underline;"><b>Note :</b></p>
                                    <!-- <ul style="padding: 0px; padding-left:20px; margin-top: -14px;">
                                        <li style="font-size: 13px;"> -->
                                        <b>' . $note . '</b>
                                        <!-- </li> 
                                    </ul> -->
                                </div>';
                        }
                        // Random Strings
                        $random_string = rand();
                        $limit = 20;
                        if($required_document_id == 16){
                            $limit = 100;
                        }
                        $html .= '<form method="post" enctype="multipart/form-data" id="support_evidence_form_id">';
                        $html .= '  <div class=" add_more_input_for_multiple_Assessment"> ' ;
                        $html .='<div id="wrapper-0"> <div class="row ">';
                        $html .=    '<div class="col-sm-6" >
                                        <input class="form-control " type="text" id="support_evidence_label_'.$random_string.'"  name="file_name[]" required />
                                    </div>';
                        $html .=    '<div class="col-sm-5"  style="    padding-left: 0px;">
                        <!-- onchange="file_select_()" -->
                                         <input class="form-control col-sm-4" onchange="checkSupportEvidenceFileSize(\'support_evidence_file_'.$random_string.'\','.$limit.')"  type="file" id="support_evidence_file_'.$random_string.'"  name="support_evidence_file" accept="' . $accept . '" required  />
                                    
                                    </div>';
                        $html .=    '
                                        <div class="col-sm-1 my-auto" style="padding-left: 0px;">
                                            <button type="button" title="Upload" onclick="__addSupportEvidenceForm(\'support_evidence_label_'.$random_string.'\', \'support_evidence_file_'.$random_string.'\','.$required_document_id.')"  class="btn btn_green_yellow btn-sm" id="btn-plus" value="addbtn">
                                                <i class="bi bi-upload mohsin"></i>
                                            </button>
                                        </div>
                                    
                                    ';

                        $html .= ' </div> </div> </div> <!-- row -->';
                        $html .= '<div  class="row " id="add_more_input_for_multiple_Assessment">';
                        $html .= '</div> <!-- row add_more_input_for_multiple_Assessment -->';

                        $html .= ' <input type="hidden"  name="required_document_id" value="' . $required_document_id . '" />';
                        

                        $html .= '<div class="row">
                                        <div class="col-sm-6">
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="text-danger"> 
                                                Only : ' . $accept_note . '  
                                            </div>
                                        </div>
                                    </div>';
                        
                        
                        // Loader
                        $html .= '
                                <div class="row my-2">
                                    <div class="col-12">
                                        <div class="progress" style="display: none;">
                                            <div class="progress-bar" role="progressbar" id="a4-progressbar" style="width: 100%;" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                ';
                        // End Loader

                        
                        // Loader
                        $html .= '
                                <div class="row my-2">
                                    <div class="col-12">
                                        <ol id="render_support_evidence_output">
                                            
                                        </ol>
                                    </div>
                                </div>
                                ';
                        // End Loader

                        
                        $html .= ' <div class="col-sm-12 mt-3 text-center" id="attach_support_evidence_btn" style="display: none;">
                                            <button type="button" class="btn btn_green_yellow" onclick="__attach_the_files()">Attach Files</button>
                                         </div>';
                        $html .= '</form>';
                    }
                }
            } else {
                $html = "";
            }
        }
        return json_encode($html);
    }
    
    public function upload_support_evidence_docs()
    {
        
        // file data and file name 
        $file =  $this->request->getFile('file');
        $file_name =  $this->request->getVar('name');
        $required_document_id = $this->request->getVar('required_document_id');

        $File_extention = $file->getClientExtension();
        $file_size = $file->getSize();

        $document_name = clean_URL($file_name);
        $file_name_with_extantion = $document_name . '.' . $File_extention;  // file.jpg

        //Helper call 
        $ENC_pointer_id =  $this->request->getVar('ENC_pointer_id');
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        $folder_path = 'public/application/' . $pointer_id . '/stage_2/assessment_documents';
        $folder_path_pre = 'public/application/' . $pointer_id . '/stage_2';
        
        // If not dir
        if(!is_dir($folder_path_pre)){
            mkdir($folder_path_pre);
        }
        // END
        
        
        // If not dir
        if(!is_dir($folder_path)){
            mkdir($folder_path);
        }
        // END

        // move file to folder 
        $is_move = $file->move($folder_path, $file_name_with_extantion, true);
        if ($is_move) {

            // insert into SQL if not exist
            $files = [
                'pointer_id' => $pointer_id,
                'stage' => 'stage_2',
                'required_document_id' => trim($required_document_id),
                'name' => $file_name,
                'document_name' => $file_name_with_extantion,
                'document_path' => $folder_path,
                'document_type' => '',
                'status' => 1
            ];
            $file_exist = $this->documents_model->where($files)->first();
            if (!$file_exist) {
                $is_insert =   $this->documents_model->insert($files);
                if ($is_insert) {
                    // get index id 
                    $get_data = $this->documents_model->where($files)->first();
                    if (!empty($get_data)) {
                        $index_id =  $get_data['id'];
                    }
                }
            } else {
                $index_id  = $file_exist['id'];
            }
        }

        if (isset($index_id) || !empty($index_id)) {
            $array = [
                'status' => '1',
                'msg' => "Uploaded Done",
                'file_name' => $file_name,
                'file_url' => base_url($folder_path . "/" . $file_name_with_extantion),
                'file_id' => $index_id,
            ];
        } else {
            $array = [
                'status' => '0',
                'msg' => "Sorry File Not Uploaded.",
            ];
        }
        echo json_encode($array);
    }
    
    public function assessment_documents_upload_($ENC_pointer_id)
    {
    //   echo "Her4e";
    //   exit;
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->first();
        if (!empty($application_pointer)) {

            // file data and file name 
            $file =  $this->request->getFile('file');
            $file_name =  $this->request->getVar('file_name');
            $required_document_id = $this->request->getVar('required_document_id');

            $File_extention = $file->getClientExtension();
            $file_size = $file->getSize();

            $document_name = clean_URL($file_name);
            $file_name_with_extantion = $document_name . '.' . $File_extention;  // file.jpg

            $folder_path = 'public/application/' . $pointer_id . '/stage_2/assessment_documents';

            // move file to folder 
            $is_move = $file->move($folder_path, $file_name_with_extantion, true);
            if ($is_move) {

                // insert into SQL if not exist
                $files = [
                    'pointer_id' => $pointer_id,
                    'stage' => 'stage_2',
                    'required_document_id' => trim($required_document_id),
                    'name' => $file_name,
                    'document_name' => $file_name_with_extantion,
                    'document_path' => $folder_path,
                    'document_type' => '',
                    'status' => 1
                ];
                $file_exist = $this->documents_model->where($files)->first();
                if (!$file_exist) {
                    $is_insert =   $this->documents_model->insert($files);
                    if ($is_insert) {
                        $this->session->setFlashdata('msg', 'Documents uploaded successfully.');
                        return redirect()->back();
                    } else {
                        $this->session->setFlashdata('error_msg', 'Sorry!  Document Not Uploaded.');
                        return redirect()->back();
                    }
                } else {
                    return redirect()->back();
                }
            } else {
                $this->session->setFlashdata('error_msg', 'Sorry!  Document Not Uploaded.');
                return redirect()->back();
            }
        }
    }

    public function assessment_documents_multiple_upload_($ENC_pointer_id)
    {
         $pointer_id = pointer_id_decrypt($ENC_pointer_id);
     //  die;
        $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->first();
        if (!empty($application_pointer)) {

            // file data and file name 
            $required_document_id = $this->request->getVar('required_document_id');
            
            $All_file_name =  $this->request->getVar('file_name'); // in array
            $All_file =  $this->request->getFileMultiple('files'); // in arrayile->getClientExtension();
//echo "<pre>";
//print_r($All_file);


            // return response to ajax
            $array = [
                'status' => '0',
                'msg' => "Sorry File Not Uploaded.",
            ];


            $c=0;

            foreach ($All_file as $key => $res) {
               echo  $c++;
                $file_name = $All_file_name[$key];
                $file = $All_file[$key];
                $File_extention = $file->getClientExtension();  // .jpg, .png
                $file_size = $file->getSize();
                
                // echo "hey";
                // print_r($file_size);
                // exit;

                if (empty($file_size)) {
                    $this->session->setFlashdata('msg', 'Sorry! File not Found, Please select valid File.');
                    return redirect()->back();
                }
                // 100 MB allow
                if ($file_size > 1024 * 1024 * 100) {
                    $this->session->setFlashdata('msg', '"File size is too Big, please select a file less than 5mb."');
                     
                    return redirect()->back();
                }
                // create file name if not exist 
                if (isset($File_name) && empty($File_name)) {
                    $File_name = 'assessment_documents_' . $key;
                }


                $document_name = clean_URL($file_name);
                $file_name_with_extantion = $document_name . '.' . $File_extention;  // file.jpg

                $folder_path = 'public/application/' . $pointer_id . '/stage_2/assessment_documents';

                // move file to folder 
                $is_move = $file->move($folder_path, $file_name_with_extantion, true);
                if ($is_move) {

                    // insert into SQL if not exist
                    $files = [
                        'pointer_id' => $pointer_id,
                        'stage' => 'stage_2',
                        'required_document_id' => trim($required_document_id),
                        'name' => $file_name,
                        'document_name' => $file_name_with_extantion,
                        'document_path' => $folder_path,
                        'document_type' => '',
                        'status' => 1
                    ];
                    $file_exist = $this->documents_model->where($files)->first();
                    if (!$file_exist) {
                        $is_insert =   $this->documents_model->insert($files);
                        if ($is_insert) {
                            $this->session->setFlashdata('msg', ' Documents uploaded successfully.');
                            //  return redirect()->back();
                        } else {
                            $this->session->setFlashdata('error_msg', 'Sorry!  Document Not Uploaded.');
                            //  return redirect()->back();
                        }
                    } else {
                        //  return redirect()->back();
                    }
                } else {
                    $this->session->setFlashdata('error_msg', 'Sorry!  Document Not Uploaded.');
                     return redirect()->back();
                }
            }

            return redirect()->back();
        }
    }

    // delet file for stage 2 
    public function documents_info_delete_file_($ENC_pointer_id)
    {
        // file data and file name 
        $ENC_pointer_id =  $this->request->getVar('ENC_pointer_id');
        $file_id = $this->request->getVar('document_id');

        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        $documents_list = $this->documents_model->where(['id' => $file_id, 'pointer_id' => $pointer_id])->first();

        $document_name = $documents_list['document_name'];
        $document_path = $documents_list['document_path'];
        $full_path = $document_path . '/' . $document_name;
        if (file_exists($full_path)) {
            if (unlink($full_path)) {
                $is_delet = $this->documents_model->where(['id' => $file_id, 'pointer_id' => $pointer_id])->delete();
                if ($is_delet) {
                    echo "ok";
                }
            }
        }
    }

public function add_employment_document_verify_($ENC_pointer_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        // echo $pointer_id;
        // exit;
        $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->first();
        if (!empty($application_pointer)) {
            // insert into SQL if not exist

            $stage_1_occupation = $this->stage_1_occupation_model->where(['pointer_id' => $pointer_id])->first();
            $pathway  = "";
            if (!empty($stage_1_occupation)) {
                $pathway = $stage_1_occupation['pathway'];
            }

            $documents_ = $this->documents_model->where(['pointer_id' => $pointer_id,   'stage' => 'stage_2',  'status' => 1])->find();
            $required_documents_list_ = $this->required_documents_list_model->whereIn('category', ['employment_documents'])->where(['stage' => 'stage_2', 'is_required' => 1])->find();
            $Assessment_required_documents_list_ = $this->required_documents_list_model->whereIn('category', ['assessment_documents'])->where(['stage' => 'stage_2', 'is_required' => 1])->find();

            $stage_2_add_employment = $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id])->find();
            
          
            if (count($required_documents_list_) > 0) {
                // Employment Documents -----------------------------------------------------
                // create array for type
           if(count($stage_2_add_employment)>0){
                $count=1;
                foreach($stage_2_add_employment as $employes){
                    $required_ = 0;
                    $required_documents_list_ = "";
                    // echo $employes['employment_type'];
                    if($employes['employment_type'] == 'Self employed'){
                        $required_documents_list_ = $this->required_documents_list_model->whereIn('category', ['self_employment_documents'])->where(['stage' => 'stage_2', 'is_required' => 1])->first();
                    }else{
                        $required_documents_list_ = $this->required_documents_list_model->whereIn('category', ['employment_documents'])->where(['stage' => 'stage_2', 'is_required' => 1])->first();
                    }
                    //  print_r($required_documents_list_);
                    $employment_documnets =  $this->documents_model->where(['stage' => 'stage_2', 'pointer_id' => $pointer_id,'employee_id'=>$employes['id']])->find();
                    $employment_documnets =  $this->documents_model->where(['stage' => 'stage_2', 'pointer_id' => $pointer_id,'employee_id'=>$employes['id']])->find();
                    $employment_documnet_required =  $this->documents_model->where(['stage' => 'stage_2', 'pointer_id' => $pointer_id,'employee_id'=>$employes['id'],'required_document_id'=>$required_documents_list_['id']])->first();
                    // $lastQuery = $this->documents_model->getLastQuery();
                    // print_r($lastQuery);
                    // print_r($employment_documnet_required);
                    // exit;
                    if($employment_documnet_required){
                        $required_ = 1;
                    }else{
                        $json = [
                            "msg" => "Please upload all the required documents",
                            "error" => 1,
                        ];
                        echo json_encode($json);
                        exit;
                                
                    }
                    // echo $employes['company_organisation_name'];
                    // echo $required_;
                    if(count($employment_documnets) >= 3){
                    } else {
                    $json = [
                        "msg" => "Please upload a minimum of 3 documents for all employers",
                        "error" => 1,
                    ];
                      echo json_encode($json);
                        exit;
                    }
                $count++;
                } 
            }         
                


                // Assessment Documents ------------------------------------------------
                $Total_Assessment_docs = 0;
                $Total_Assessment_docs_upload = 0;
                foreach ($Assessment_required_documents_list_ as $key => $value) {
                    // print_r($value['id']);
                    // echo "</br>";
                    $file_show = true;

                    if ($pathway != "Pathway 1") {
                        if ($value['id'] == 16) {
                            $file_show = false;
                        }
                        if ($value['id'] == 34) {
                            $file_show = false;
                        }
                    }
                    if($stage_1_occupation["occupation_id"] != 7){
                        if ($value['id'] == 53) {
                            $file_show = false;
                        }
                    }
                    if ($file_show) {
                        $required_document_id = $value['id'];
                        $Total_Assessment_docs++;
                        // print_r($value);
                        // print_r($documents_);
                        // echo "Dos";
                        $set_sixtheen = false;
                     //$Total_Assessment_docs_upload = 0;
                // print_r($documents_);  
                        
                        // echo $Total_Assessment_docs_upload;
                    }
                }
                
                if($stage_1_occupation["occupation_id"] == 7 && $pathway == "Pathway 1"){
                    $Total_Assessment_docs = 2;
                    // echo "testing...1";
                }
                else if($stage_1_occupation["occupation_id"] == 7 && $pathway == "Pathway 2"){
                    $Total_Assessment_docs = 1;
                    // echo "testing...2";
                }
                else if($stage_1_occupation["occupation_id"] == 5 && $pathway == "Pathway 2"){
                    $Total_Assessment_docs = 1;
                    // echo "testing...3";
                }
                else if($stage_1_occupation["occupation_id"] == 5 && $pathway == "Pathway 1"){
                    $Total_Assessment_docs = 3;
                    // echo "testing...4";
                }elseif($stage_1_occupation["occupation_id"] == 6 && $pathway == "Pathway 1"){
                    $Total_Assessment_docs = 3;
                    // echo "testing...5";
                }elseif($stage_1_occupation["occupation_id"] == 6 && $pathway == "Pathway 2"){
                    $Total_Assessment_docs = 1;
                    // echo "testing...6";
                }elseif($stage_1_occupation["occupation_id"] == 18 && $pathway == "Pathway 2"){
                    $Total_Assessment_docs = 1;
                    // echo "testing...7";
                }
                else{
                    if($pathway == "Pathway 2"){
                        $Total_Assessment_docs = 1;
                        //  echo "testing...8";
                    }else{
                  $Total_Assessment_docs = 3;
                //   echo "testing...9";
                    }
                      
                }
                
                foreach ($documents_ as $key => $value_1) {
                             $upload_document_id = $value_1['required_document_id'];
                            
                            if($upload_document_id == 16){
                                $set_sixtheen = true;        
                                continue;
                            }
                            if ($upload_document_id == 15) {
                                
                                // echo $upload_document_id . $required_document_id."<br/>";
                             $Total_Assessment_docs_upload++;
                            }
                            if($upload_document_id==34){
                                
                                $Total_Assessment_docs_upload++;
                            }
                            if($upload_document_id==53){
                               
                                $Total_Assessment_docs_upload++;
                            }
                            // if($upload_document_id==56){
                                
                            //     $Total_Assessment_docs_upload++;
                            // }
                            // if($upload_document_id==57){
                               
                            //     $Total_Assessment_docs_upload++;
                            // }
                            
                        }
                        if($set_sixtheen == true){
                            $Total_Assessment_docs_upload++;
                            $set_sixtheen = false;
                        }
                        
                // "<br>";
                // echo $Total_Assessment_docs."-";
                // // echo "<br"> $stage_1_occupation
                // echo $Total_Assessment_docs_upload;
                // exit;
            
                
                
                if ($Total_Assessment_docs == $Total_Assessment_docs_upload) {
                    
                    if($stage_1_occupation["occupation_id"] == 7 && $pathway == "Pathway 1"){
                        
                        $check__third__party = $this->documents_model->where(["pointer_id" => $stage_1_occupation["pointer_id"], "required_document_id" => 53, "stage" => "stage_2"])->first();
                        // echo $this->documents_model->getLastQuery();
                        // print_r($check__third__party);
                        // exit;
                        if(!$check__third__party){
                            goto errorFlow;
                        }
                    }
                    
                    
                    OutFlow:
                    $json = [
                        "msg" => "Procced",
                        "error" => 0,
                    ];
                    echo json_encode($json);
                    //exit;
                } else {
                    // $Total_Assessment_docs." ".$Total_Assessment_docs_upload
                    
                    if($stage_1_occupation["pathway"] == "Pathway 1" && $stage_1_occupation["occupation_id"] == 18 && $Total_Assessment_docs_upload == 1){
                        goto OutFlow;        
                    }
                    else{
                    errorFlow:    
                    
                    $json = [
                        "msg" => "Please upload Assessment Documents",
                        "error" => 1,
                    ];
                    echo json_encode($json);
                    exit;
                    }
                    // echo "upload Assessment Documents";

                }
                
                
                
                
                
                // if ($Total_Assessment_docs == $Total_Assessment_docs_upload) {
                //     $json = [
                //         "msg" => "Procced",
                //         "error" => 0,
                //     ];
                //     echo json_encode($json);
                //     exit;
                // } else {
                //     // $Total_Assessment_docs." ".$Total_Assessment_docs_upload
                //     $json = [
                //         "msg" => "Please upload Assessment Documents",
                //         "error" => 1,
                //     ];
                //     echo json_encode($json);
                //     exit;
                //     // echo "upload Assessment Documents";

                // }

                // p2 
                // return "Please upload  Employment Documents Files. (Minimum 3 files required)";
                // p1 
                // return "Please upload  Employment Documents Files. (Minimum 3 files required)";

                // echo "<pre>";
                // print_r($documents_);
                // echo "</pre><hr>";

            }
        }
    }
   
    // stage 2 submit and email
    public function submit_application_($ENC_pointer_id)
    {
        $user_id = $this->session->get('user_id');
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id, 'user_id' => $user_id])->first();


        if (!empty($application_pointer)) {
            // dont change database if email not send 
            $email_send_agent_applicant = false;
            $email_send_admin = false;

            // no reply to applicant or agent  ------------------- 
            $stage_1_contact_details_ = $this->stage_1_contact_details_model->where(['pointer_id' => $pointer_id])->first();
            if (!empty($stage_1_contact_details_)) {
                $email = $stage_1_contact_details_['email'];
            }
            // agent email
            $user_account = $this->user_account_model->asObject()->where('id', $user_id)->first();
            if (isset($user_account->email)) {
                $email = $user_account->email;
            }


            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") { // Applicant
                //s2_submit_server_to_agent
                $mail_temp_14 = $this->mail_template_model->where(['id' => '14'])->first();
                if (!empty($mail_temp_14)) {
                    $subject = mail_tag_replace($mail_temp_14['subject'], $pointer_id);
                    $message = mail_tag_replace($mail_temp_14['body'], $pointer_id);
                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $email, $subject, $message);
                    if ($check == 1) {
                        $email_send_agent_applicant = true;
                    }
                } // email template check
            }
            if ($client_type == "Applicant") {
                //s2_submitted_applicant
                $mail_temp_14 = $this->mail_template_model->where(['id' => '66'])->first();
                if (!empty($mail_temp_14)) {
                    $subject = mail_tag_replace($mail_temp_14['subject'], $pointer_id);
                    $message = mail_tag_replace($mail_temp_14['body'], $pointer_id);
                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $email, $subject, $message);
                    if ($check == 1) {
                        $email_send_agent_applicant = true;
                    }
                } // email template check
            }

            // s2_submit_server_to_admin
            $s2_submit_server_to_admin = $this->mail_template_model->where(['id' => '15'])->first();
            if (!empty($s2_submit_server_to_admin)) {
                $subject = mail_tag_replace($s2_submit_server_to_admin['subject'], $pointer_id);
                $message = mail_tag_replace($s2_submit_server_to_admin['body'], $pointer_id);
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), env('ADMIN_EMAIL'), $subject, $message,[],[],[],[],$pointer_id);
                if ($check == 1) {
                    $email_send_admin = true;
                } // email is send
            } // admin email



            // sql update after email send  ---------------
            if ($email_send_admin && $email_send_agent_applicant) {
                $stage_2_tb = $this->stage_2_model->where(['pointer_id' => $pointer_id])->first();
                if (empty($stage_2_tb)) {
                    // Insert 
                    $data = [
                        'pointer_id' => $pointer_id,
                        'status' => 'Submitted',
                        'submitted_date' => date('y-m-d H:i:s'),
                        'submitted_by' => $user_id,
                    ];
                    $stage_2_ = $this->stage_2_model->set($data)->insert();
                    $application_pointer = $this->application_pointer_model->where(['id ' => $pointer_id, 'user_id' => $user_id])->set(['stage' => 'stage_2', 'status' => 'Submitted'])->update();
                    if ($application_pointer && $stage_2_) {
                        return "1";
                    }
                } else {
                    // Update 
                    $data = [
                        'status' => 'Submitted',
                        'submitted_date' => date('y-m-d H:i:s'),
                        'submitted_by' => $user_id,
                    ];
                    $stage_2_ = $this->stage_2_model->where(['pointer_id' => $pointer_id])->set($data)->update();
                    $application_pointer = $this->application_pointer_model->where(['id ' => $pointer_id, 'user_id' => $user_id])->set(['stage' => 'stage_2', 'status' => 'Submitted'])->update();
                    if ($application_pointer && $stage_2_) {
                        return "1";
                    }
                }
            } else {
                return "Sorry email not send";
            } // sql update after email send 
            //
            //
        } // pointer check
    } // funtion close
}
