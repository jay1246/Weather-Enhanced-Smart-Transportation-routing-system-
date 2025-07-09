<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

// stage 1 ---------------------------------------

class upload_documents extends BaseController
{

    // view page 
    public function upload_documents($ENC_pointer_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        $stage_1_1 = $this->stage_1_model->where(['pointer_id' => $pointer_id, 'status' => 'Submitted'])->first();
        if (!empty($stage_1_1)) {
            return redirect()->to(base_url('user/view_application/' . $ENC_pointer_id));
        }


        $personal_details = $this->stage_1_personal_details_model->where(['pointer_id' => $pointer_id])->get()->getRowArray();
        $data = [
            'page' => "Personal Details",
            'personal_details' => $personal_details,
            'ENC_pointer_id' => $ENC_pointer_id,
        ];
        return view('user/stage_1/upload_documents', $data);
    }

    public function required_documents_list_($ENC_pointer_id)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        $html_code = "";
        $stage_1_occupation = $this->stage_1_occupation_model->where(['pointer_id' => $pointer_id])->first();
        $stage_1_usi_avetmiss = $this->stage_1_usi_avetmiss_model->where(['pointer_id' => $pointer_id])->first();



        $documents_list = $this->required_documents_list_model->where(['stage' => 'stage_1', 'category' => 'upload_documents'])->orderBy("ordering", "ASC")->find();
        foreach ($documents_list as $key => $value) {
            $required_document_id = $value['id'];
            $document_name = $value['document_name'];
            $is_required = $value['is_required'];

            $is_required_html = ($is_required == 1) ? "required" : "";
            $is_required_star = ($is_required == 1) ? "*" : "";

            $show_file = true;
            if ($document_name == "SAQ" || $required_document_id == 5) {
                $show_file = false;
                if ($stage_1_occupation['pathway'] == "Pathway 1") {
                    $show_file = true;
                }
            }
            
            // Check for Industry Experience Summary
            // For Chef and Cook P2
            if ($document_name == "Industry Experience Summary" || $required_document_id == 58) {
                $show_file = false;
                if (($stage_1_occupation['occupation_id'] == 5 || $stage_1_occupation['occupation_id'] == 6) && $stage_1_occupation['pathway'] == "Pathway 2") {
                    $show_file = true;
                }
            }
            
            
            if ($document_name == "USI Transcript" || $required_document_id == 8) {
                $show_file = false;
                if ($stage_1_usi_avetmiss['have_usi_transcript'] == 'yes') {
                    $show_file = true;
                }
            }
            $placeholder = "";
            if ($document_name == "Qualification Docs (Certificate and Transcripts / Marksheets)" || $required_document_id == 4) {
                $placeholder = 'Enter Qualification Name';
            }
            if ($show_file) {
                $id = $value['id'];
                $document_name = $value['document_name'];
                $allowed_type = json_decode($value['allowed_type']); // array data
                $is_multiple = $value['is_multiple'];
                $is_required = $value['is_required'];
                $note = $value['note'];

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

                // singal file upload 
                if ($is_multiple != 1) {
                    $file_info = check_document_uploaded('stage_1', $pointer_id, $id);
                    // show file link with delet buttun 
                    if (!empty($file_info)) {
                        $html_code .= '
                        <div class="accordion-item">  <!--- and in last --->
                                    <h2 class="accordion-header" id="h' . $id . 'eadingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a' . $id . '-collaps" aria-expanded="false" aria-controls="a' . $id . '-collaps">
                                    <span class="file_icon" id="a' . $id . '-file_icon" style="text-decoration: none !important;">
                                
                                    <i class="bi bi-check-circle-fill"></i>
                                    </span> 
                                    ' . $document_name . '
                                    </button>
                                    </h2>';
                        // colaps start
                        $html_code .= '<div class="collapse_box  accordion-collapse collapse" aria-labelledby="h' . $id . 'eadingOne" id="a' . $id . '-collaps" data-bs-parent="#accordionExample">';
                        $html_code .= '<input type="hidden" name="a' . $id . '-required_document" value="' . $id . '" readonly />';
                        // Note
                        if (!empty($note)) {
                            $html_code .= '<!-- Note  -->
                            <div class="bg-warning rounded p-2 mb-2" id="a' . $id . '-Note" style="display: none;">
                                    ' . $note . '
                            </div>';
                        }

                        foreach ($file_info as $key => $my_file) {
                            $Uploaded_file_id = $my_file['id'];
                            $required_document_id = $my_file['required_document_id'];
                            $Uploaded_name = $my_file['name'];
                            $Uploaded_document_name = $my_file['document_name'];
                            $Uploaded_document_path = $my_file['document_path'];
                            if ($id == $required_document_id) {
                                $html_code .=  ' <!-- View file  -->
                                                    <div class="row align-items-center_ pb-3" id="a' . $id . '-View_file" style="">
                                                        <!-- file view link auto add by js  -->
                                                        <div class="col-sm-11" id="a' . $id . '-File_link"> 
                                                            <a href="' . base_url($Uploaded_document_path . '/' . $Uploaded_document_name) . '" target="_blank" class="p-3">
                                                            ' . $Uploaded_name . '
                                                            </a>
                                                            <br>
                                                        </div>
                                                        <div class="col-sm-1 text-end">
                                                            <!-- file delet button  -->
                                                            <!-- Delet_file_singal pass  Uploaded_file_id  -->
                                                            <button type="button" id="a' . $id . '-BTN_delet" onclick="Delet_file_singal(\'a' . $id . '\',\'' . $Uploaded_file_id . '\')" class="btn btn-danger">
                                                                <i class="bi bi-x-lg"></i>
                                                            </button>
                                                        </div>
                                               
                                        </div>  <!-- View file  -->
                                        </div>  
                                        ';
                            }
                        }

                        $html_code .= '  <!-- select file  -->
                                        <div class="row align-items-center_" id="a' . $id . '-select" style="display: none;">
                                            <div class="col-sm-11">
                                                <input type="hidden" name="a' . $id . '-file_name" value="' . $document_name . '" readonly="">
                                                <input class="form-control" accept="' . $accept . '"  placeholder="' . $placeholder . '" type="file" name="a' . $id . '-file" ' . $is_required_html . '>
                                                <div class="text-danger col-sm-6 ">
                                                    Only : ' . $accept_note . '
                                                </div>
                                            </div>
                                            <div class="col-sm-1 text-end">
                                                <button type="button" id="a' . $id . '-BTN_upload" onclick="upload_file(\'a' . $id . '\')" class="btn btn_green_yellow">
                                                    <!-- <i class="bi bi-x-lg"></i> -->
                                                    <i class="bi bi-upload"></i>
                                                </button>
                                            </div>
                                        </div> <!-- select file  -->';
                        $html_code .= '  <!-- on upload show prograse bar  -->
                                        <div class="row align-items-center mt-3" id="a' . $id . '-File_uploading" style="display: none;" data-bs-parent="#accordionExample">
                                            <div class="col-sm-2">
                                            </div>
                                            <div class="col-sm-8">
                                                <span id="a' . $id . '-progressbar_text"> File Uploaded. </span>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" id="a' . $id . '-progressbar" style="width: 100%;" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                            </div>
                                        </div> 
                                        <!-- on upload show prograse bar  -->';

                        $html_code .= ' </div>';
                        $html_code .= ' </div>';
                    } else {
                        // show Upload File Option

                        $html_code .= '
                        <div class="accordion-item">  <!--- and in last --->
                                    <h2 class="accordion-header" id="h' . $id . 'eadingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a' . $id . '-collaps" aria-expanded="true" aria-controls="a' . $id . '-collaps">
                                    <span class="file_icon" id="a' . $id . '-file_icon" style="text-decoration: none !important;">
                                    <i class="bi bi-circle"></i>
                                    </span> 
                                    ' . $document_name . '
                                    </button>
                                    </h2>';

                        // collaps start 
                        $html_code .= '<div class="collapse_box collapse " data-bs-parent="#accordion" id="a' . $id . '-collaps" data-bs-parent="#accordionExample">';
                        $html_code .= '<input type="hidden" name="a' . $id . '-required_document" value="' . $id . '" readonly />';
                        $html_code .= ' <!-- View file  -->
                                            <div class="row align-items-center_ pb-3" id="a' . $id . '-View_file" style="display: none;">
                                                <!-- file view link auto add by js  -->
                                                <div class="col-sm-11" id="a' . $id . '-File_link">
                                                </div>
                                                <!-- file delet button  -->
                                                <div class="col-sm-1  text-end">
                                                <button type="button" id="a' . $id . '-BTN_delet" onclick="Delet_file_singal(\'a' . $id . '\',\'' . $id . '\')" class="btn btn-danger">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </div>
                                            </div> <!-- View file  -->';


                        // Note
                        if (!empty($note)) {
                            $html_code .= '<!-- Note  -->
                                        <div  class="bg-warning rounded p-2 mb-2" id="a' . $id . '-Note">
                                        ' . $note . '
                                        </div>';
                        }
                        $html_code .= ' <!-- select file  -->
                                        <div class="row align-items-center_" id="a' . $id . '-select">
                                            <div class="col-sm-11">
                                                <input type="hidden" name="a' . $id . '-file_name" value="' . $document_name . '" readonly="">
                                                <input type="hidden" name="a' . $id . '-required_document" value="1" readonly="">
                                                <input class="form-control" accept="' . $accept . '" type="file" name="a' . $id . '-file" ' . $is_required_html . '>
                                                <div class="text-danger col-sm-6">
                                                Only : ' . $accept_note . '
                                                </div>
                                            </div>
                                            <div class="col-sm-1 text-end">
                                                <button type="button" onclick="upload_file(\'a' . $id . '\')" id="a' . $id . '-BTN_upload" class="btn btn_green_yellow ml-3">
                                                    <i class="bi bi-upload"></i>
                                                </button>
                                            </div>
                                        </div> <!-- select file  -->

                                        <!-- on upload show prograse bar  -->
                                        <div class="row align-items-center" id="a' . $id . '-File_uploading" style="display: none;">
                                            <div class="col-sm-2">
                                            </div>
                                            <div class="col-sm-8">
                                                <span id="a' . $id . '-progressbar_text"> Uploading file .... </span>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" id="a' . $id . '-progressbar" style="width: 25%" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                            </div>
                                        </div> <!-- on upload show prograse bar  -->
                                    ';

                        // collaps close 
                        $html_code .= ' </div>';
                        $html_code .= ' </div>';
                    }
                }

                // singal file upload 
                if ($is_multiple == 1) {

                    $file_info = check_document_uploaded('stage_1', $pointer_id, $id);

                    // show file link with delet buttun 
                    $is_file_availabale = false;
                    if (!empty($file_info)) {
                        $is_file_availabale = true;
                    }
                    $html_code .= '
                    <div class="accordion-item">  <!--- and in last --->
                                <h2 class="accordion-header" id="h' . $id . 'eadingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a' . $id . '-collaps" aria-expanded="false" aria-controls="a' . $id . '-collaps">
                                <span class="file_icon" id="a' . $id . '-file_icon" style="text-decoration: none !important;">
                             ';

                    // $html_code .= ' <a data-bs-toggle="collapse" class="file_name_link border-not-uploaded" href="#a' . $id . '-collaps" role="button" aria-expanded="true" aria-controls="a' . $id . '-collaps">
                    //                     <span class="file_icon" id="a' . $id . '-file_icon">';

                    if ($is_file_availabale) {
                        $html_code .= '<i class="bi bi-check-circle-fill"></i>';
                    } else {
                        $html_code .= '    <i class="bi bi-circle"></i>';
                    }
                    $html_code .= ' </span>
                                        ' . $document_name . ' <span class="text-danger">' . $is_required_star . '</span>
                                    </button>
                                    </h2>';

                    // colaps start
                    $html_code .= '<div class="collapse_box collapse" data-bs-parent="accordion" id="a' . $id . '-collaps" style="" data-bs-parent="#accordionExample">';
                    // Note
                    if (!$is_file_availabale) {
                        if (!empty($note)) {
                            $html_code .= '<!-- Note  -->
                                <div class="bg-warning rounded p-2 mb-2" id="a' . $id . '-Note" >
                                        ' . $note . '
                                </div>';
                        }
                    }
                    $html_code .= '<!-- View file  -->
                                        <div class="row align-items-center_ pb-3"  id="a' . $id . '-all_link_div"> ';
                    foreach ($file_info as $key => $my_file) {
                        $Uploaded_file_id = $my_file['id'];
                        $required_document_id = $my_file['required_document_id'];
                        $Uploaded_name = $my_file['name'];
                        $Uploaded_document_name = $my_file['document_name'];
                        $Uploaded_document_path = $my_file['document_path'];
                        if ($id == $required_document_id) {
                            $html_code .=  ' 
                                        <!-- file view link auto add by js  -->
                                    <div class="row m-1" id="' . $Uploaded_file_id . '-link_div"> 
                                        <div class="col-sm-11" id="a' . $id . '-File_link"> 
                                            <a href="' . base_url($Uploaded_document_path . '/' . $Uploaded_document_name) . '" target="_blank" class="p-3">
                                            ' . $Uploaded_name . '
                                            </a>
                                            <br>
                                        </div>
                                        <div class="col-sm-1  text-end">
                                            <!-- file delet button  -->
                                            <!-- Delet_file_singal pass  Uploaded_file_id  -->
                                            <button type="button" id="a' . $id . '-BTN_delet" onclick="Delet_file_multy_file(\'a' . $id . '\',\'' . $Uploaded_file_id . '\')" class="btn btn-danger">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>';
                        }
                    }

                    $html_code .= '</div>  <!-- View file  -->';
                    $html_code .= '<input type="hidden" name="a' . $id . '-required_document" value="' . $id . '" readonly />';

                    $html_code .= '  <!-- select file  -->
                                            <div class="row align-items-center_" id="a' . $id . '-select" >
                                                <div class="col-sm-11">
                                                    <div class="row">
                                                            <div class="col-sm-6">
                                                                <input class="form-control a' . $id . '_multy_file_name" type="test" placeholder="' . $placeholder . '" name="a' . $id . '-file_name" ' . $is_required_html . ' />
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <input class="form-control a' . $id . '_multy_file" accept="' . $accept . '" type="file" name="a' . $id . '-file"  ' . $is_required_html . ' />
                                                            </div>
                                                    </div>
                                                    <div class="text-danger col-sm-6 ">
                                                        Only : ' . $accept_note . '
                                                    </div>
                                                </div>
                                                <div class="col-sm-1  text-end">
                                                    <button type="button" id="a' . $id . '-BTN_upload" onclick="upload_file_multy_file(\'a' . $id . '\')" class="btn btn_green_yellow">
                                                        <!-- <i class="bi bi-x-lg"></i> -->
                                                        <i class="bi bi-upload"></i>
                                                    </button>
                                                </div>
                                            </div> <!-- select file  -->';
                    $html_code .= '  <!-- on upload show prograse bar  -->
                                            <div class="row align-items-center mt-3" id="a' . $id . '-File_uploading" style="display: none;">
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-8">
                                                    <span id="a' . $id . '-progressbar_text"> File Uploaded. </span>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" id="a' . $id . '-progressbar" style="width: 100%;" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                            </div> 
                                            <!-- on upload show prograse bar  -->';

                    $html_code .= ' </div>';
                    $html_code .= ' </div>';
                }




                // multy file
                if ($is_multiple == 11) {
                    $file_info = check_document_uploaded('stage_1', $pointer_id, $id);

                    // show file link with delet buttun 
                    if (!empty($file_info)) {
                        // show Upload File Option
                        $html_code .= ' <a data-bs-toggle="collapse" class="file_name_link border-not-uploaded" href="#a' . $id . '-collaps" role="button" aria-expanded="true" aria-controls="a' . $id . '-collaps">
                          <span class="file_icon" id="a' . $id . '-file_icon">
                          <i class="bi bi-circle"></i>
                          </span>
                          ' . $document_name . '
                          <span class="text-danger">' . $is_required_star . '</span>
                      </a>';

                        $html_code .= '<div class="collapse_box collapse show " data-bs-parent="#accordion" id="a' . $id . '-collaps" style="">
                          <!-- Note  -->';

                        $html_code .= '<!-- View file  -->
                          <div class="row align-items-center_ pb-2" id="a' . $id . '-View_file" ">';

                        foreach ($file_info as $key => $my_file) {

                            $Uploaded_file_id = $my_file['id'];
                            $required_document_id = $my_file['required_document_id'];
                            $Uploaded_name = $my_file['name'];
                            $Uploaded_document_name = $my_file['document_name'];
                            $Uploaded_document_path = $my_file['document_path'];
                            if ($id == $required_document_id) {
                                // $html_code = json_encode($file_info);
                                $html_code .= ' <!-- file view link auto add by js  -->
                                    <div class="col-sm-11 p-2" id="a' . $id . '-File_link"> 
                                        <a href="' . base_url($Uploaded_document_path . '/' . $Uploaded_document_name) . '" target="_blank" class="p-3">
                                        ' . $Uploaded_name . '
                                        </a>
                                        <br>
                                    </div>
                                    <div class="col-sm-1 text-end">
                                        <!-- file delet button  -->
                                        <!-- Delet_file_singal pass  Uploaded_file_id  -->
                                        <button type="button" id="a' . $id . '-BTN_delet" onclick="Delet_file_multy(\'a' . $id . '\',\'' . $Uploaded_file_id . '\')" class="btn btn-danger">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>';
                            }
                        }
                        $html_code .= '  </div>
                                <!-- View file  -->';

                        $html_code .= '  <!-- select file  -->
                          <div id="a' . $id . '-select">
                                 <!--   <form class="row align-items-center pt-2"  method="post" enctype="multipart/form-data"   id="a' . $id . '-multy_file_form">  --> 
                                          <form class="row align-items-center pt-2" action="' . base_url('user/stage_1/upload_documents/multy_file_upload_') . '" method="post" enctype="multipart/form-data"   id="a' . $id . '-multy_file_form">
                                            <input type="hidden" name="ENC_pointer_id" value="' . $ENC_pointer_id . '" readonly ' . $is_required_html . ' />
                                            <input type="hidden" name="required_document_id" value="' . $id . '" readonly ' . $is_required_html . '>
                                            <div class="col-sm-11">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <input class="form-control a' . $id . '_multy_file_name" type="test" name="file_name[]" required />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input class="form-control a' . $id . '_multy_file" accept="' . $accept . '" type="file" name="files[]" ' . $is_required_html . ' />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1 text-end">
                                                <button type="button" onclick="add_more_input(\'a' . $id . '\')" id="a' . $id . '-BTN_add" class="btn btn-danger ml-3">
                                                    <i class="bi bi-plus-lg"></i>
                                                </button>
                                            </div>';
                        $html_code .= '       <script>
                                      // reload_page_show_agent();

                                      var count = 0;

                                      function add_more_input(doc_name) {
                                          var add_more_input = doc_name + \'-add_more_input\'; // div for add input div
                                          var Note_div = doc_name + \'-Note\';

                                          var data = `<div id="wrapper-${count}" class="row pt-2">
                                          <div class="col-sm-11">
                                              <div class="row">
                                                  <div class="col-sm-6">
                                                      <input class="form-control" type="text" name="file_name[]" required />
                                                  </div>
                                                  <div class="col-sm-6">
                                                      <input class="form-control" accept="' . $accept . '" type="file" name="files[]" required />
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-sm-1 text-end">
                                              <button type="button" onclick="delete_div(\'#wrapper-${count}\')"  id="a' . $id . '-BTN_add" class="btn btn-danger ml-3">
                                              <i class="bi bi-x-lg"></i>
                                              </button>
                                          </div>
                                  </div>`;
                                      count++;
                                      $("#" + add_more_input).append(data);
                                  }

                                  function delete_div(element) {
                                      count = count - 1;
                                      $(element).remove();
                                  }
                              </script>';


                        $html_code .= '         <div id="a' . $id . '-add_more_input"> 
                                                </div>
                                                <div class="text-danger col-sm-6">
                                                    Only : ' . $accept_note . '
                                                </div>
                                                <div class=" text-center mt-3 text-end">
                                                    <button type="button" onclick="multy_upload_file(\'a' . $id . '\')" id="a' . $id . '-BTN_upload" class="btn btn_green_yellow ml-3 col-sm-3">
                                                        <i class="bi bi-upload"></i> Upload
                                                    </button>
                                                </div>
                                        </form>
                                    </div>
                                    <!-- select file  -->';



                        // collaps close 
                        $html_code .= ' </div>';
                    } else {
                        // show Upload File Option
                        $html_code .= ' <a data-bs-toggle="collapse" class="file_name_link border-not-uploaded" href="#a' . $id . '-collaps" role="button" aria-expanded="true" aria-controls="a' . $id . '-collaps">
                                        <span class="file_icon" id="a' . $id . '-file_icon">
                                        <i class="bi bi-check-circle-fill"></i>
                                        </span>
                                        ' . $document_name . '
                                        <span class="text-danger">*</span>
                                    </a>';

                        $html_code .= '<div class="collapse_box collapse show " data-bs-parent="#accordion" id="a' . $id . '-collaps" style="">
                                        <!-- Note  -->';

                        $html_code .= '<!-- View file  -->
                                        <div class="row align-items-center_ pb-3" id="a' . $id . '-View_file" style="display: none;">
                                            <!-- file view link auto add by js  -->
                                            <div class="col-sm-11" id="a' . $id . '-File_link">
                                            </div>
                                            <!-- file delet button  -->
                                            <div class="col-sm-1 text-end">
                                                <button type="button" id="a' . $id . '-BTN_delet" onclick="Delet_file_singal(\'a' . $id . '\',\'a' . $id . '\')" class="btn btn-danger">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    <!-- View file  -->';

                        $html_code .= '  <!-- select file  -->
                                        <div id="a' . $id . '-select" >
                                        <!--   <form class="row align-items-center pt-2"  method="post" enctype="multipart/form-data"   id="a' . $id . '-multy_file_form">  --> 
                                        <form class="row align-items-center pt-2" action="' . base_url('user/stage_1/upload_documents/multy_file_upload_') . '" method="post" enctype="multipart/form-data"   id="a' . $id . '-multy_file_form">

                                        <input type="hidden" name="ENC_pointer_id" value="' . $ENC_pointer_id . '" readonly ' . $is_required_html . ' />
                                        <input type="hidden" name="required_document_id" value="' . $id . '" readonly required>
                                            <div class="col-sm-11">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <input class="form-control a' . $id . '_multy_file_name" type="test" name="file_name[]" ' . $is_required_html . ' />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input class="form-control a' . $id . '_multy_file" accept="' . $accept . '" type="file" name="files[]" ' . $is_required_html . ' />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1 text-end">
                                                <button type="button" onclick="add_more_input(\'a' . $id . '\')" id="a' . $id . '-BTN_add" class="btn btn-danger ml-3">
                                                    <i class="bi bi-plus-lg"></i>
                                                </button>
                                            </div>';


                        $html_code .= '       <script>
                                                    // reload_page_show_agent();

                                                    var count = 0;

                                                    function add_more_input(doc_name) {
                                                        var add_more_input = doc_name + \'-add_more_input\'; // div for add input div
                                                        var Note_div = doc_name + \'-Note\';

                                                        var data = `<div id="wrapper-${count}" class="row pt-2">
                                                        <div class="col-sm-11">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <input class="form-control" type="text" name="file_name[]" ' . $is_required_html . ' />
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input class="form-control" accept="' . $accept . '" type="file" name="files[]" ' . $is_required_html . ' />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-1 text-end">
                                                            <button type="button" onclick="delete_div(\'#wrapper-${count}\')"  id="a' . $id . '-BTN_add" class="btn btn-danger ml-3">
                                                            <i class="bi bi-x-lg"></i>
                                                            </button>
                                                        </div>
                                                </div>`;
                                                    count++;
                                                    $("#" + add_more_input).append(data);
                                                }

                                                function delete_div(element) {
                                                    count = count - 1;
                                                    $(element).remove();
                                                }
                                            </script>';


                        $html_code .= '      <div id="a' . $id . '-add_more_input">
                                            </div>

                                            <div class="text-danger col-sm-6">
                                                Only : ' . $accept_note . '
                                            </div>
                                            <div class=" text-center mt-3 text-end">
                                                <button type="button" onclick="multy_upload_file(\'a' . $id . '\')" id="a' . $id . '-BTN_upload" class="btn btn_green_yellow ml-3 col-sm-3">
                                                    <i class="bi bi-upload"></i> Upload
                                                </button>
                                             </div>
                                       </div>

                                    </form>
                                     </div>
                                    <!-- select file  -->';



                        // collaps close 
                        $html_code .= ' </div>';
                    }
                }
            }
        }

        // echo "<pre>";
        // print_r($file_info);
        // exit;


        return json_encode($html_code);
    }

    // not use 
    public function multy_file_upload_()
    {


        $ENC_pointer_id =  $this->request->getVar('ENC_pointer_id');
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        $required_document_id = $this->request->getVar('required_document_id');
        $All_file_name =  $this->request->getVar('file_name'); // in array
        $All_file =  $this->request->getFileMultiple('files'); // in array

        // return response to ajax
        $array = [
            'status' => '0',
            'msg' => "Sorry File Not Uploaded.",
        ];

        foreach ($All_file as $key => $res) {
            $file_name = $All_file_name[$key];
            $file = $All_file[$key];
            $File_extention = $file->getClientExtension();  // .jpg, .png
            $file_size = $file->getSize();



            if (empty($file_size)) {
                $this->session->setFlashdata('msg', 'Sorry! File not Found, Please select valid File.');
                return redirect()->back();
            }
            // 10 MB allow
            if ($file_size > 10485760) {
                $this->session->setFlashdata('msg', '"File size is too Big, please select a file less than 5mb."');
                return redirect()->back();
            }
            // create file name if not exist 
            if (isset($File_name) && empty($File_name)) {
                $File_name = 'qualification_file_' . $key;
            }
            // clean file name to URL
            $document_name = clean_URL($file_name);
            $file_name_with_extantion = $document_name . '.' . $File_extention;  // file.jpg
            $folder_path = 'public/application/' . $pointer_id . '/stage_1';
            // move file to folder 
            $is_move = $file->move($folder_path, $file_name_with_extantion, true);
            $array_files = array();
            if ($is_move) {

                // insert into SQL if not exist
                $files = [
                    'pointer_id' => $pointer_id,
                    'stage' => 'stage_1',
                    'required_document_id' => trim($required_document_id),
                    'name' => $file_name,
                    'document_name' => $file_name_with_extantion,
                    'document_path' => $folder_path,
                    'document_type' => '',
                    'status' => 1
                ];
                $file_exist = $this->documents_model->where($files)->first();
                if (empty($file_exist)) {
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

                if (isset($index_id) || !empty($index_id)) {
                    $array_file = [
                        'file_name' => $file_name,
                        'file_url' => base_url($folder_path . "/" . $file_name_with_extantion),
                        'file_id' => $index_id,
                    ];
                    $array_files[] = $array_file;
                }

                //.........
            }

            if (count($array_files) > 0) {
                $array = [
                    'status' => '1',
                    'msg' => "Uploaded Done",
                    'data' => $array_files,
                ];
            } else {
                $array = [
                    'status' => '0',
                    'msg' => "Sorry File Not Uploaded.",
                ];
            }
        }

        return json_encode($array);
    }

    public function upload_documents_()
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

        $folder_path = 'public/application/' . $pointer_id . '/stage_1';

        // move file to folder 
        $is_move = $file->move($folder_path, $file_name_with_extantion, true);
        if ($is_move) {

            // insert into SQL if not exist
            $files = [
                'pointer_id' => $pointer_id,
                'stage' => 'stage_1',
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
        return json_encode($array);
    }

    public function delet_file_()
    {
        // file data and file name 
        $ENC_pointer_id =  $this->request->getVar('ENC_pointer_id');
        $file_id = $this->request->getVar('file_id');

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

    public function file_validate_($ENC_pointer_id)
    {

        // return  print_r($ENC_pointer_id);
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $is_availebal = $this->application_pointer_model->where(['id' => $pointer_id])->first();

        $stage_1_occupation = $this->stage_1_occupation_model->where(['pointer_id' => $pointer_id])->first();
        $stage_1_usi_avetmiss = $this->stage_1_usi_avetmiss_model->where(['pointer_id' => $pointer_id])->first();

        if (!empty($is_availebal)) {

            $documents_list = $this->required_documents_list_model->where(['stage' => 'stage_1', 'category' => 'upload_documents'])->find();
            $total_required_file = 0;
            $total_upload_file = 0;

            foreach ($documents_list as $key => $value) {
                $required_document_id = $value['id'];
                $is_required = $value['is_required'];
                $document_name = $value['document_name'];

                $show_file = true;
                if ($document_name == "SAQ" || $required_document_id == 5) {
                    $show_file = false;
                    if ($stage_1_occupation['pathway'] == "Pathway 1") {
                        $show_file = true;
                    }
                }
                
                // Check for Industry Experience Summary
                // For Chef and Cook P2
                if ($document_name == "Industry Experience Summary" || $required_document_id == 58) {
                    $show_file = false;
                    if (($stage_1_occupation['occupation_id'] == 5 || $stage_1_occupation['occupation_id'] == 6) && $stage_1_occupation['pathway'] == "Pathway 2") {
                        $show_file = true;
                    }
                }
                
                
                if ($document_name == "USI Transcript" || $required_document_id == 8) {
                    $show_file = false;
                    if ($stage_1_usi_avetmiss['have_usi_transcript'] == 'yes') {
                        $show_file = true;
                    }
                }

                if ($show_file) {
                    if ($is_required == 1) {
                        $total_required_file++;
                        $files = [
                            'pointer_id' => $pointer_id,
                            'stage' => 'stage_1',
                            'required_document_id' => trim($required_document_id),
                            'status' => 1
                        ];
                        $file_exist = $this->documents_model->where($files)->first();
                        if (!empty($file_exist)) {
                            $total_upload_file++;
                        }
                    }
                }
            }

            if ($total_upload_file == $total_required_file) {
                return "1";
            } else {
                return "0";
            }
        }

        return "0";
    }

    public function submit_stage_1_($ENC_pointer_id)
    {

        $user_id = $this->session->get('user_id');
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);



        $stage_1_1 = $this->stage_1_model->where(['pointer_id' => $pointer_id, 'status' => 'Submitted'])->first();
        if (!empty($stage_1_1)) {
            return "1";
        }

        $team_member_id = getTheAbsoluteTeamMemberID();

        $application_pointer = $this->application_pointer_model->where(['id ' => $pointer_id, 'user_id' => $user_id])->set(['status' => 'Submitted', 'team_member' => $team_member_id])->update();
        
        $email_send_agent_applicant = false;
        $email_send_admin = false;

        // no reply to applicant or agent  -------------------
        $email = "";
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
            if ($client_type == "Agent") {
                // s1_submitted_agent
                $mail_temp_4 = $this->mail_template_model->where(['id' => '1'])->first();
                if (!empty($mail_temp_4)) {
                    $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                    $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                    $to =  $email;
                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], []);
                    if ($check == 1) {
                        $email_send_agent_applicant = true;
                    }
                } // email template
            }
            if ($client_type == "Applicant") {
                // s1_submitted_applicant
                $mail_temp_4 = $this->mail_template_model->where(['id' => '56'])->first();
                if (!empty($mail_temp_4)) {
                    $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
                    $message = mail_tag_replace($mail_temp_4['body'], $pointer_id);
                    $to =  $email;
                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], []);
                    if ($check == 1) {
                        $email_send_agent_applicant = true;
                    }
                } // email template check
            }
        } // email ID check

        //s1_submitted_admin
        $mail_temp_4 = $this->mail_template_model->where(['id' => '2'])->first();
        if (!empty($mail_temp_4)) {
            $subject = mail_tag_replace($mail_temp_4['subject'], $pointer_id);
            $message =  mail_tag_replace($mail_temp_4['body'], $pointer_id);  // work is pending-------------------------------------------
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), env('ADMIN_EMAIL'), $subject, $message, [], [], [], [], $pointer_id);
            if ($check == 1) {
                $email_send_admin = true;
            }
        }


        if ($email_send_admin && $email_send_agent_applicant) {
            $data = [
                'status' => 'Submitted',
                'submitted_date' => date('Y-m-d H:i:s'),
            ];
            $stage_1_update = $this->stage_1_model->where(['pointer_id' => $pointer_id])->set($data)->update();
            $application_pointer = $this->application_pointer_model->where(['id ' => $pointer_id, 'user_id' => $user_id])->set(['status' => 'Submitted'])->update();
            if ($application_pointer && $stage_1_update) {
                return "1";
            }
        }
    }
}
