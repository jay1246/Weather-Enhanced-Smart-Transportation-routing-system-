<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use Dompdf\Dompdf;

class application_preview extends BaseController
{
    public function application_preview($ENC_pointer_id)
    {
        // Decode ------
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $register_user = $this->application_pointer_model->where('id', $pointer_id)->first();

        if (session()->has('user_id')) {
            $user_id = session()->get('user_id');
        } else {
            $user_id = $register_user['user_id'];
            $this->session->set('user_id', $user_id);
            $this->session->set('check_admin', "yes");
        }

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
            'ENC_pointer_id' => $ENC_pointer_id,
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
        return view('user/stage_1/application_preview', $data);
    } // funtion close


    //  on page load ajex call --------------
    // that funtion use to Applicant Declaration page also ---
    public function pdf_Download_check_()
    {
        $data = $this->request->getvar();

        $file_page = $data['file_page'];
        
        $ENC_pointer_id = $data['ENC_pointer_id'];
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);


        $is_add_update = false;
        $stage_1_review_confirm_model = $this->stage_1_review_confirm_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        if (empty($stage_1_review_confirm_model)) {
            $details = [
                $file_page => 1,
                'pointer_id' => $pointer_id,
            ];
            if ($this->stage_1_review_confirm_model->insert($details)) {
                $is_add_update = true;
            }
        } else {
            $check_1 =  $this->stage_1_review_confirm_model->where(['pointer_id' => $pointer_id])->set($file_page, 1)->update();
            if ($check_1) {
                $is_add_update = true;
            }
        }
        
        // Check if Chef and Cook is there for P2
        $stage_1_occupation_model = $this->stage_1_occupation_model->where(['pointer_id' => $pointer_id])->first();
        
        if(($stage_1_occupation_model["occupation_id"] == 5 || $stage_1_occupation_model["occupation_id"] == 6) && $stage_1_occupation_model["pathway"] == "Pathway 2"){
            $agent_details = $this->stage_1_review_confirm_model->where(['pointer_id' => $pointer_id, 'information_release_file_download' => 1, 'applicant_declaration_file_download' => 1, 'industry_experience_summary_file_download' => 1])->orderby('id', 'DESC')->first();
        }
        else{
           $agent_details = $this->stage_1_review_confirm_model->where(['pointer_id' => $pointer_id, 'information_release_file_download' => 1, 'applicant_declaration_file_download' => 1])->orderby('id', 'DESC')->first(); 
        }
        // 
        if ($agent_details) {
            return "ok";
        }



        return "sorry";
    }



    public function pdf_Download_check_only_()
    {
        $data = $this->request->getvar();

        $ENC_pointer_id = $data['ENC_pointer_id'];
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        // Check if Chef and Cook is there for P2
        $stage_1_occupation_model = $this->stage_1_occupation_model->where(['pointer_id' => $pointer_id])->first();
        
        if(($stage_1_occupation_model["occupation_id"] == 5 || $stage_1_occupation_model["occupation_id"] == 6) && $stage_1_occupation_model["pathway"] == "Pathway 2"){
            $agent_details = $this->stage_1_review_confirm_model->where(['pointer_id' => $pointer_id, 'information_release_file_download' => 1, 'applicant_declaration_file_download' => 1, 'industry_experience_summary_file_download' => 1])->orderby('id', 'DESC')->first();
        }
        else{
            $agent_details = $this->stage_1_review_confirm_model->where(['pointer_id' => $pointer_id, 'information_release_file_download' => 1, 'applicant_declaration_file_download' => 1])->orderby('id', 'DESC')->first();
        }
        
        if ($agent_details) {
            return "ok";
        }
        return "sorry";
    }

    //  on page load ajex call -------
    public function pdf_html_code_()
    {
        
        $pointer_id=15;
        $user_id=1;
        $database = $this->stage_1_education_and_employment_model->where(['pointer_id' => $pointer_id])->find();
        $perosnal_details = $this->stage_1_personal_details_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $occupation_details = $this->stage_1_occupation_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $contact_details = $this->stage_1_contact_details_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $identification_details = $this->stage_1_identification_details_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $usi_details = $this->stage_1_usi_avetmiss_model->orderby('id', 'DESC')->where(['pointer_id' => $pointer_id])->first();
        $education_and_employment = $this->stage_1_education_and_employment_model->orderby('id', 'DESC')->where(['pointer_id' => $pointer_id])->first();
        $register_user = $this->user_account_model->where('id',$user_id )->first();
        $stage_1_pdf_download = $this->stage_1_review_confirm_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();

    
   $html = '
                    <style>
                        .w-25 {
                            width: 25% !important;
                        }
                    
                        .w-10 {
                            width: 10% !important;
                        }
                    
                        .w-40 {
                            width: 40% !important;
                        }
                    
                        table.print-friendly tr td,
                        table.print-friendly tr th {
                            page-break-inside: avoid;
                        }
                    
                        td.w-40 {
                            padding-left: 20px;
                        }
                    </style>
                    <br>';
                    //occupation details
            $html .= '
            <h5 class="text-center text-success Occupation" style="font-size: 23px;">Occupation Details</h5>
            <div class="d-flex justify-content-center">
                <table class="table table-borderless table-hover w-80 table-striped print-friendly">
            ';
            
            if (!empty($occupation['occupation_id'])) {
                $html .= '
                    <tr>
                        <td class="w-40">Occupation</td>
                        <td class="w-10"><span>:</span></td>
                        <td class="w-25">'.find_one_row('occupation_list', 'id', $occupation['occupation_id'])->name.'</td>
                    </tr>
                ';
            }
            
            if (!empty($occupation['program'])) {
                $html .= '
                    <tr>
                        <td class="w-40">Skills Assessment Program</td>
                        <td class="w-10"><span>:</span></td>
                        <td class="w-25">'.$occupation['program'].'</td>
                    </tr>
                ';
            }
            
            if (!empty($occupation['pathway'])) {
                $html .= '
                    <tr>
                        <td class="w-40">Pathway</td>
                        <td class="w-10"><span>:</span></td>
                        <td class="w-25">'.$occupation['pathway'].'</td>
                    </tr>
                ';
            }
            
            $html .= '
                </table>
            </div>
            <hr style="text-align: center;" width="100%">
            ';
    //personal details
            $html .= '
        <div class="justify-content-center Personal_Details">
            <h5 class="text-center text-success" style="font-size: 23px;">Personal Details (As per Passport)</h5>
        
            <table class="table table-borderless table-hover w-100 table-striped print-friendly">
        ';
        
        if (!empty($personal_details['preferred_title'])) {
            $html .= '
                <tr>
                    <td class="w-40">Preferred Title</td>
                    <td class="w-10"><span>:</span></td>
                    <td class="w-25">'.$personal_details['preferred_title'].'</td>
                </tr>
            ';
        }
        
        if (!empty($personal_details['surname_family_name'])) {
            $html .= '
                <tr>
                    <td class="w-40">Surname or family Name</td>
                    <td class="w-10"><span>:</span></td>
                    <td class="w-25">'.(!empty($personal_details['surname_family_name']) ? m_name($personal_details['surname_family_name']) : "Not Applicable").'</td>
                </tr>
            ';
        }
        
        if (!empty($personal_details['first_or_given_name'])) {
            $html .= '
                <tr>
                    <td class="w-40">First or given Name</td>
                    <td class="w-10"><span>:</span></td>
                    <td class="w-25">'.$personal_details['first_or_given_name'].'</td>
                </tr>
            ';
        }
        
        if (!empty($personal_details['middle_names'])) {
            $html .= '
                <tr>
                    <td class="w-40">Middle Name</td>
                    <td class="w-10"><span>:</span></td>
                    <td class="w-25">'.$personal_details['middle_names'].'</td>
                </tr>
            ';
        }
        
        if (!empty($personal_details['known_by_any_name'])) {
            if ($personal_details['known_by_any_name'] == 'no') {
                $html .= '
                    <tr>
                        <td class="w-40">Are you known by any other Name</td>
                        <td class="w-10"><span>:</span></td>
                        <td class="w-25">'.$personal_details['known_by_any_name'].'</td>
                    </tr>
                ';
            } else {
                if (!empty($personal_details['previous_surname_or_family_name'])) {
                    $html .= '
                        <tr>
                            <td class="w-40">Previous Surname or Family Name</td>
                            <td class="w-10"><span>:</span></td>
                            <td class="w-25">'.$personal_details['previous_surname_or_family_name'].'</td>
                        </tr>
                    ';
                }
        
                if (!empty($personal_details['previous_names'])) {
                    $html .= '
                        <tr>
                            <td class="w-40">Previous First or given Name</td>
                            <td class="w-10"><span>:</span></td>
                            <td class="w-25">'.$personal_details['previous_names'].'</td>
                        </tr>
                    ';
                }
        
                if (!empty($personal_details['previous_Middle_names'])) {
                    $html .= '
                        <tr>
                            <td class="w-40">Previous Middle Name</td>
                            <td class="w-10"><span>:</span></td>
                            <td class="w-25">'.$personal_details['previous_Middle_names'].'</td>
                        </tr>
                    ';
                }
            }
        }
        
        if (!empty($personal_details['gender'])) {
            $html .= '
                <tr>
                    <td class="w-40">Gender</td>
                    <td class="w-10"><span>:</span></td>
                    <td class="w-25">'.$personal_details['gender'].'</td>
                </tr>
            ';
        }
        
        if (!empty($personal_details['date_of_birth'])) {
            $html .= '
                <tr>
                    <td class="w-40">Date of Birth</td>
                    <td class="w-10"><span>:</span></td>
                    <td class="w-25">'.m_date($personal_details['date_of_birth']).'</td>
                </tr>
            ';
        }
        
        $html .= '
            </table>
        </div>
        <hr style="text-align: center; page-break-after: always;" width="100%">
        ';
        //contact details
        $html .= '
        <h5 class="text-center text-success Contact_Details" style="font-size: 23px;">Contact Details</h5>
        <div class="d-flex justify-content-center mt">
            <table class="table table-borderless table-hover w-100 table-striped print-friendly">
                <tr>
                    <td class="w-40">Email</td>
                    <td class="w-10">:</td>
                    <td class="w-25">'.$contact_details['email'].'</td>
                </tr>
        ';
        
        if (!empty($contact_details['alternate_email'])) {
            $html .= '
                <tr>
                    <td class="w-40"> Alternate Email</td>
                    <td class="w-10">:</td>
                    <td class="w-25">'.$contact_details['alternate_email'].'</td>
                </tr>
            ';
        }
        
        $html .= '
                <tr>
                    <td class="w-40">Mobile Number</td>
                    <td class="w-10">:</td>
                    <td class="w-25">+'.country_phonecode($contact_details['mobile_number_code']).' '.$contact_details['mobile_number'].'</td>
                </tr>
        ';
        
        if (!empty($contact_details['alter_mobile'])) {
            $html .= '
                <tr>
                    <td class="w-40">Alternate Mobile Number</td>
                    <td class="w-10">:</td>
                    <td class="w-25">+'.country_phonecode($contact_details['alter_mobile_code']).' '.$contact_details['alter_mobile'].'</td>
                </tr>
            ';
        }
        
        $html .= '
                <tr>
                    <td colspan="3" class="w-40">
                        <h5><b> Residential Address </b></h5>
                    </td>
                </tr>
        ';
        
        if (!empty($contact_details['unit_flat_number'])) {
            $html .= '
                <tr>
                    <td class="w-40">Unit / Flat Number</td>
                    <td class="w-10"><span>:</span></td>
                    <td class="w-25">'.$contact_details['unit_flat_number'].'</td>
                </tr>
            ';
        }
        
        $html .= '
                <tr>
                    <td class="w-40">Street / lot Number </td>
                    <td class="w-10"><span>:</span></td>
                    <td class="w-25">'.$contact_details['street_lot_number'].'</td>
                </tr>
                <tr>
                    <td class="w-40">Street Name </td>
                    <td class="w-10"><span>:</span></td>
                    <td class="w-25">'.$contact_details['street_name'].'</td>
                </tr>
                <tr>
                    <td class="w-40"> Suburb / City</td>
                    <td class="w-10"><span>:</span></td>
                    <td class="w-25">'.$contact_details['suburb'].'</td>
                </tr>
                <tr>
                    <td class="w-40">Postcode</td>
                    <td class="w-10"><span>:</span></td>
                    <td class="w-25">'.$contact_details['postcode'].'</td>
                </tr>
                <tr>
                    <td class="w-40">State / Province </td>
                    <td class="w-10"><span>:</span></td>
                    <td class="w-25">'.$contact_details['state_proviance'].'</td>
                </tr>
                <tr>
                    <td class="w-40">Country </td>
                    <td class="w-10"><span>:</span></td>
                    <td class="w-25">'.$contact_details['country'].'</td>
                </tr>
        ';
        
        if ($contact_details['postal_address_is_different'] == "yes") {
            $html .= '
                <tr>
                    <td>Postal Address is same as Residential Address </td>
                    <td class="w-10"><span>:</span></td>
                    <td class="w-25">'.$contact_details['postal_address_is_different'].'</td>
                </tr>
            ';
        } else {
            $html .= '
                <tr>
                    <td colspan="3" class="w-40">
                        <h5><b> Postal Address </b></h5>
                    </td>
                </tr>
            ';
        
            if (!empty($contact_details['postal_unit_flat_number'])) {
                $html .= '
                    <tr>
                        <td class="w-40">Unit / Flat Number</td>
                        <td class="w-10"><span>:</span></td>
                        <td class="w-25">'.m_mobile($contact_details['postal_unit_flat_number']).'</td>
                    </tr>
                ';
            }
        
            if (!empty($contact_details['postal_street_lot_number'])) {
                $html .= '
                    <tr>
                        <td class="w-40">Street / lot Number </td>
                        <td class="w-10"><span>:</span></td>
                        <td class="w-25">'.m_mobile($contact_details['postal_street_lot_number']).'</td>
                    </tr>
                ';
            }
        
            // Add the remaining postal address fields here...
        
            $html .= '
                <tr>
                    <td class="w-40"> Suburb / City</td>
                    <td class="w-10"><span>:</span></td>
                    <td class="w-25">'.$contact_details['postal_suburb'].'</td>
                </tr>
            ';
        
        }
        
        $html .= '
            </table>
        </div>
        <hr style="text-align: center; page-break-after: always;" width="100%">
        ';
   //identifiation details
               $html .= '
            <h5 class="text-center text-success Identification_Details" style="font-size: 23px;">Identification Details</h5>
            <div class="d-flex justify-content-center mt">
                <table class="table table-borderless table-striped w-100 table-striped print-friendly">
                    <tr>
                        <td class="w-40">Passport Country</td>
                        <td class="w-10"><span class="">:</span></td>
                        <td class="w-25">'.$identification_details['passport_country'].'</td>
                    </tr>
                    <tr>
                        <td class="w-40">Place of Issue / Issuing Authority</td>
                        <td class="w-10"><span class="">:</span></td>
                        <td class="w-25">'.$identification_details['place_of_issue'].'</td>
                    </tr>
                    <tr>
                        <td class="w-40">Passport Number</td>
                        <td class="w-10"><span class="">:</span></td>
                        <td class="w-25">'.$identification_details['passport_number'].'</td>
                    </tr>
                    <tr>
                        <td class="w-40"> Passport Expiry Date </td>
                        <td class="w-10"><span class="">:</span></td>
                        <td class="w-25">'.$identification_details['expiry_date'].'</td>
                    </tr>
                </table>
            </div>
            <hr style="text-align: center;" width="100%">
            ';

             //ui avetme
                         $html .= '
            <h5 class="text-center text-success USI" style="font-size: 23px;">Unique Student Identifier (USI)</h5>
            <div class="d-flex justify-content-center mt">
                <table class="table table-borderless table-hover table-striped w-100 print-friendly">
            ';
            
            if (isset($usi_details['currently_have_usi'])) {
                if ($usi_details['currently_have_usi'] == "yes") {
                    if (!empty($usi_details['usi_no'])) {
                        $html .= '
                        <tr>
                            <td class="w-40">USI No.</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">'.$usi_details['usi_no'].'</td>
                        </tr>';
                    }
            
                    if (!empty($usi_details['have_usi_transcript'])) {
                        $html .= '
                        <tr>
                            <td class="w-40">Do you have a USI Transcript</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">'.$usi_details['have_usi_transcript'].'</td>
                        </tr>';
            
                        if ($usi_details['have_usi_transcript'] == 'no') {
                            $html .= '
                            <tr>
                                <td colspan="3" class="w-40">
                                    <div class="instruction col-lg-12 bg-warning rounded p-2">
                                        <b>Note:</b>
                                        It is a mandatory requirement to verify qualifications for any Skills Assessment Application. If the USI Transcripts are unavailable, we will have to manually verify the qualifications from the RTO which has awarded the qualification.
                                    </div>
                                </td>
                            </tr>';
                        }
                    }
            
                    if (!empty($usi_details['permission_access_usi_transcripts'])) {
                        $html .= '
                        <tr>
                            <td class="w-40">I have assigned ATTC permission to access USI Transcripts</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">'.$usi_details['permission_access_usi_transcripts'].'</td>
                        </tr>';
                    }
                } else {
                    $html .= '
                    <tr>
                        <td class="w-40">I am offshore (outside of Australia) - Do not need any USI</td>
                        <td class="w-10"><span class="">:</span></td>
                        <td class="w-25">'.($usi_details['currently_have_usi'] == "no" ? "Yes" : "").'</td>
                    </tr>';
                }
            }
            
            $html .= '
                </table>
            </div>
            <hr style="text-align: center;" width="100%">
            
            <h5 class="text-center text-success USI" style="font-size: 23px;">Marketing</h5>
            <div class="d-flex justify-content-center mt">
                <table class="table table-borderless table-hover table-striped w-100 print-friendly">
                    <tr>
                        <td class="w-40" style="text-align: justify;">I give Australian Trade Training College permission to use photos/images in public material and social media (including any photos/images where I may be recognized or participating in workplace activities) for current and future marketing and business purposes. I understand that I retain the right to withdraw my consent at any time via email to tra@attc.org.au.</td>
                        <td class="w-10"><span class="">:</span></td>
                        <td class="w-25">'.$usi_details['marketing'].'</td>
                    </tr>
                </table>
            </div>
            <hr style="text-align: center;page-break-after: always;" width="100%">
            
            ';
            
            if (!is_Agent()) {
                // Do something
            } else {
                $html .= '
                <h5 class="text-center text-success Representative_Details" style="font-size: 23px;">Representative Details</h5>
                <div class="d-flex justify-content-center mt">
                    <table class="table table-borderless table-striped w-100 table-striped print-friendly">
                ';
            
                if (!empty($register_user['name'])) {
                    $html .= '
                    <tr>
                        <td class="w-40">Name of Agent or Representative</td>
                        <td class="w-10"><span class="">:</span></td>
                        <td class="w-25">'.$register_user['name'].' '.$register_user['last_name'].'</td>
                    </tr>';
                }
            
                // Add more representative details here...
            
                $html .= '
                    </table>
                </div>
                ';
            }
            
                        $html .= '
            <h5 class="text-center text-success" style="font-size: 23px;">Avetmiss Details</h5>
            <div class="d-flex justify-content-center mt">
                <table class="table table-borderless table-hover table-striped w-100 print-friendly">
            ';
            
            if (!empty($identification_details['country_of_birth'])) {
                $html .= '
                <tr>
                    <td class="w-40">Country of birth</td>
                    <td class="w-10"><span class="">:</span></td>
                    <td class="w-25">'.$identification_details['country_of_birth'].'</td>
                </tr>';
            }
            
            if (!empty($usi_details['speak_english_at_home'])) {
                $html .= '
                <tr>
                    <td class="w-40">Do you speak a language other than English at home?</td>
                    <td class="w-10"><span class="">:</span></td>
                    <td class="w-25">'.$usi_details['speak_english_at_home'].'</td>
                </tr>';
            
                if ($usi_details['speak_english_at_home'] == 'yes') {
                    if (!empty($usi_details['specify_language'])) {
                        $html .= '
                        <tr>
                            <td class="w-40">Specify Language</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">'.$usi_details['specify_language'].'</td>
                        </tr>';
                    }
            
                    if (!empty($usi_details['proficiency_in_english'])) {
                        $html .= '
                        <tr>
                            <td class="w-40">Proficiency in Spoken English?</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">'.$usi_details['proficiency_in_english'].'</td>
                        </tr>';
                    }
                }
            }
            
            // Add more Avetmiss Details here...
            
            $html .= '
                </table>
            </div>
            <hr style="text-align: center;page-break-after: always;" width="100%">';
            
            $html .= '
    <h5 class="text-center text-success" style="font-size: 23px;">Education Details</h5>
    <div class="d-flex justify-content-center mt">
        <table class="table table-borderless table-hover table-striped w-100 print-friendly">
    ';
    
    if (!empty($education_and_employment['highest_completed_school_level'])) {
        $html .= '
        <tr>
            <td class="w-40">What is your highest COMPLETED school level?</td>
            <td class="w-10"><span class="">:</span></td>
            <td class="w-25">'.$education_and_employment['highest_completed_school_level'].'</td>
        </tr>
        <tr>
            <td class="w-40">Are you still enrolled in secondary or senior secondary education?</td>
            <td class="w-10"><span class="">:</span></td>
            <td class="w-25">'.$education_and_employment['still_enrolled_in_secondary_or_senior_secondary_education'].'</td>
        </tr>';
    
        if (!empty($education_and_employment['completed_any_qualifications'])) {
            $html .= '
            <tr>
                <td class="w-40">Have you SUCCESSFULLY completed any qualifications?</td>
                <td class="w-10"><span class="">:</span></td>
                <td class="w-25">'.$education_and_employment['completed_any_qualifications'].'</td>
            </tr>';
    
            if ($education_and_employment['completed_any_qualifications'] == 'yes' && !empty($education_and_employment['applicable_qualifications'])) {
                $html .= '
                <tr>
                    <td class="w-40">Applicable Qualifications</td>
                    <td class="w-10"><span class="">:</span></td>
                    <td class="w-25">'.str_replace('_', ' ', $education_and_employment['applicable_qualifications']).'</td>
                </tr>';
            }
        }
    
        // Additional logic can be added here if needed
    }
    
    $html .= '
        </table>
    </div>';

$html .= '
<h5 class="text-center text-success" style="font-size: 23px;">Employment Details</h5>
<div class="d-flex justify-content-center mt">
    <table class="table table-borderless table-hover table-striped w-100 print-friendly">
';

if (!empty($education_and_employment['current_employment_status'])) {
    $html .= '
    <tr>
        <td class="w-40">What is your current employment status?</td>
        <td class="w-10"><span class="">:</span></td>
        <td class="w-25">'.str_replace('_', ' ', $education_and_employment['current_employment_status']).'</td>
    </tr>';
}

if (!empty($education_and_employment['reason_for_undertaking_this_skills_assessment'])) {
    $html .= '
    <tr>
        <td class="w-40">What BEST describes your main reason for undertaking this skills assessment?</td>
        <td class="w-10"><span class="">:</span></td>
        <td class="w-25">'.str_replace('_', ' ', $education_and_employment['reason_for_undertaking_this_skills_assessment']).'</td>
    </tr>';

    if ($education_and_employment['reason_for_undertaking_this_skills_assessment'] == 'Other_reasons' && !empty($education_and_employment['other_reason_for_undertaking'])) {
        $html .= '
        <tr>
            <td class="w-40">Please specify the reason</td>
            <td class="w-10"><span class="">:</span></td>
            <td class="w-25">'.str_replace('_', ' ', $education_and_employment['other_reason_for_undertaking']).'</td>
        </tr>';
    }
}

$html .= '
    </table>
</div>
<hr style="text-align: center;" width="100%">
</div>
';
        $data = $this->request->getvar();
        // $pdf_html_code = $data['pdf_html_code'];
        
        //   $pointer_id = 1;
          $pdf_html_code = $html;
          $pdf_html_code =   str_replace('style="font-size: 23px;"', "", $pdf_html_code);
        // $ENC_pointer_id = $data['ENC_pointer_id'];
        // $pointer_id = pointer_id_decrypt($ENC_pointer_id);

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


    public function download_PDF_($ENC_pointer_id, $file_name)
    {



        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        $this->stage_1_education_and_employment_model->where(['pointer_id' => $pointer_id])->set('is_downloaded', 1)->update();

        $img_tag  = '<img src="' . base_url() . '/public/assets/image/profile_pic.jpg"   alt="" class="responsive" width="10%" height="40px" id="user_img">';

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
                                       <br> ' . $img_tag . '
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
        // -------------PDF creat Code  ----------
        require_once "dompdf/autoload.inc.php";
        $dompdf = new Dompdf();
        // echo "hi";
        // exit;
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




        if (!empty($file_name)) {
            $dompdf->stream($file_name);
        } else {
            $dompdf->stream('review & confirm');
        }

        $output = $dompdf->output();
        $sss = "public/application/" . $pointer_id . "/stage_1/";
        if (!is_dir($sss)) {
            // create the directory path if it does not exist
            mkdir($sss, 0777, true);
        }
        $sss .= "TRA Application Form.pdf";
        file_put_contents($sss, $output);


        // $sss = "public/" . $user_id . "_" . $application_id . ".pdf";
        // file_put_contents($sss, $output);
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


    public function auto_save_download_PDF_admin($ENC_pointer_id,  $file_name)
    {
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);


        $this->update_review_pdf_html_code__atadmin($ENC_pointer_id);
        
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
    

    // akanksha 22/6/2023 
    public function update_review_pdf_html_code($ENC_pointer_id)
    {
         $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $register_user = $this->application_pointer_model->where('id', $pointer_id)->first();

        if (session()->has('user_id')) {
            $user_id = session()->get('user_id');
        } else {
            $user_id = $register_user['user_id'];
            $this->session->set('user_id', $user_id);
            $this->session->set('check_admin', "yes");
        }

        $database = $this->stage_1_education_and_employment_model->where(['pointer_id' => $pointer_id])->find();
        $personal_details = $this->stage_1_personal_details_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $occupation = $this->stage_1_occupation_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $contact_details = $this->stage_1_contact_details_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $identification_details = $this->stage_1_identification_details_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $usi_details = $this->stage_1_usi_avetmiss_model->orderby('id', 'DESC')->where(['pointer_id' => $pointer_id])->first();
        $education_and_employment = $this->stage_1_education_and_employment_model->orderby('id', 'DESC')->where(['pointer_id' => $pointer_id])->first();
        $register_user = $this->user_account_model->where('id', $user_id)->first();
        $stage_1_pdf_download = $this->stage_1_review_confirm_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $occupation_id =  $occupation['occupation_id'];
        $occupation_list = find_one_row('occupation_list', 'id', $occupation_id);
        
        $html ='<style>
                    .w-25 {
                        width: 50% !important;
                    }

                    .w-10 {
                        width: 10% !important;
                    }

                    .w-40 {
                        width: 50% !important;

                    }

                    table.print-friendly tr td,
                    table.print-friendly tr th {
                        page-break-inside: avoid;
                    }

                    td.w-40 {
                        padding-left: 20px;
                    }
                </style>
                <br>
                <h5 class=" text-center text-success Occupation " style="font-size: 15px;">Occupation Details</h5>
                <div class="d-flex justify-content-center">
                    <table class="table table-borderless table-hover w-80 table-striped print-friendly">

                        ';
                        if (!empty($occupation['occupation_id'])) {
                            $html .= '
                                <tr>
                                    <td class="w-40" class="">Occupation</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($occupation_list->name) . '</td>
                                </tr>
                            ';
                        }
                        if (!empty($occupation['program'])) {
                            $html .= '
                                <tr>
                                    <td class="w-40">Skills Assessment Program</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($occupation['program']) . '</td>
                                </tr>
                            ';
                        } if (!empty($occupation['pathway'])) { 
                            $html .= '
                            <tr>
                                <td class="w-40">Pathway</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($occupation['pathway']).'</td>
                            </tr>
                            ';
                        } 
                        if (!empty($occupation['currently_in_australia'])) {                
                        $html .= '
                        <tr>
                            <td class="w-40">Are you currently in Australia ?</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($occupation['currently_in_australia']) .'</td>
                        </tr>
                        ';
                        } 
                        if (!empty($occupation['currently_on_bridging_visa'])) {                
                        $html .= '
                        <tr>
                            <td class="w-40">Are you currently on a bridging Visa ?</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($occupation['currently_on_bridging_visa']) .'</td>
                        </tr>
                        ';
                        } 
                        if (!empty($occupation['current_visa_category'])) {                
                        $html .= '
                        <tr>
                            <td class="w-40">Current Visa Category & Subclass</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($occupation['current_visa_category']) .'</td>
                        </tr>
                        ';
                        } 
                        if (!empty($occupation['visa_expiry'])) {                
                        $html .= '
                        <tr>
                            <td class="w-40">Visa Expiry Date </td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . date('d/m/Y', strtotime($occupation['visa_expiry']))  .'</td>
                        </tr>
                        ';
                        } 
                        if (isset($occupation['conjunction_with_skills_assessment'])) {                
                        $html .= '
                        <tr>
                            <td class="w-40">Which visa do you intend to apply for in conjunction with this skills assessment ?</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($occupation['conjunction_with_skills_assessment']) .'</td>
                        </tr>
                        ';
                        } 
                        $html .= '
                    </table>
                </div>
                <hr style="text-align: center;" width="100%">


                <!-- -------------table 2 personal ------------ -->
                <div class=" justify-content-center Personal_Details">
                    <h5 class="text-center text-success" style="font-size: 15px;">Personal Details (As per Passport)</h5>

                    <table class="table table-borderless table-hover w-100 table-striped print-friendly">
                    ';
                         if (!empty($personal_details['preferred_title'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Preferred Title</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($personal_details['preferred_title']) .'</td>
                            </tr>
                            ';
                         } 
                         if (!empty($personal_details['surname_family_name'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Surname or family Name</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">
                                ';
                                    if (!empty($personal_details['surname_family_name'])) {
                                        $html .=  ucwords($personal_details['surname_family_name']);
                                    } else {
                                        $html .=  "Not Applicable";
                                    }                                 
                                    $html .= '
                                    </td>
                            </tr>
                            ';
                         } 
                         if (!empty($personal_details['first_or_given_name'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">First or given Name</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25 ">' . ucwords($personal_details['first_or_given_name']) .'</td>
                            </tr>
                            ';
                         } 
                         if (!empty($personal_details['middle_names'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Middle Name</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25 ">' . ucwords($personal_details['middle_names']) .'</td>
                            </tr>
                            ';
                         } 
                         if (!empty($personal_details['known_by_any_name'])) {
                            if ($personal_details['known_by_any_name'] == 'no') {
                                $html .= '
                                <tr>
                                    <td class="w-40">Are you known by any other Name</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($personal_details['known_by_any_name']) .'</td>
                                </tr>
                                ';
                            } else {                                 
                                 if (!empty($personal_details['previous_surname_or_family_name'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40">Previous Surname or Family Name</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"> ' . ucwords($personal_details['previous_surname_or_family_name']) .'
                                        </td>
                                    </tr>
                                    ';
                                 } 
                                 if (!empty($personal_details['previous_names'])) {                                    
                                     $html .= '
                                    <tr>
                                        <td class="w-40">Previous First or given Name</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"> ' . ucwords($personal_details['previous_names']) .'
                                        </td>
                                    </tr>';
                                 } 
                                 if (!empty($personal_details['previous_Middle_names'])) {                                      
                                    $html .= '
                                    <tr>
                                        <td class="w-40">Previous Middle Name</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"> ' . ucwords($personal_details['previous_Middle_names']) .'
                                        </td>
                                    </tr>';
                                 } 
                            }
                        } 
                        if (!empty($personal_details['gender'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Gender</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($personal_details['gender']) .'</td>
                            </tr>
                            ';
                        } 
                        if (!empty($personal_details['date_of_birth'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Date of Birth</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . $personal_details['date_of_birth'] .'</td>
                            </tr>
                            ';
                        } 
                        $html .= '
                    </table>
                </div>
                <hr style="text-align: center;page-break-after: always;" width="100%">

                <!-- -----------table 3 contact-------- -->



                <h5 class=" text-center text-success Contact_Details" style="font-size: 15px;">Contact Details</h5>
                <div class="d-flex justify-content-center mt">
                    <table class="table table-borderless table-hover w-100  table-striped print-friendly">
                        <tr>
                            <td class="w-40">Email</td>
                            <td class="w-10">:</td>
                            <td class="w-25"> ' . $contact_details['email'] .'</td>
                        </tr>
                        ';
                         if (!empty($contact_details['alternate_email'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40"> Alternate Email</td>
                                <td class="w-10">:</td>
                                <td class="w-25"> ' . $contact_details['alternate_email'] .'</td>
                            </tr>';
                          } 
                          $html .= '
                        <tr>
                            <td class="w-40">Mobile Number</td>
                            <td class="w-10">:</td>
                            <td class="w-25"> +' . country_phonecode($contact_details['mobile_number_code']) . $contact_details['mobile_number'] .'</td>
                        </tr>
                        ';
                         if (!empty($contact_details['alter_mobile'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Alternate Mobile Number
                                </td>
                                <td class="w-10">:</td>
                                <td class="w-25"> +' . country_phonecode($contact_details['alter_mobile_code']) . $contact_details['alter_mobile'] .' </td>
                            </tr>';
                          } 
                          $html .= '
                        <tr>
                            <td colspan="3" class="w-40">
                                <h5><b> Residential Address </b></h5>
                            </td>
                        </tr>';
                         if (!empty($contact_details['unit_flat_number'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Unit / Flat Number</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($contact_details['unit_flat_number']) .'</td>
                            </tr>
                            ';
                         } 
                         $html .= '
                        <tr>
                            <td class="w-40">Street / lot Number </td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($contact_details['street_lot_number']) .'</td>
                        </tr> 
                        <tr>
                            <td class="w-40">Street Name </td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($contact_details['street_name']) .'</td>
                        </tr>

                        <tr>
                            <td class="w-40"> Suburb / City</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($contact_details['suburb']) .'</td>
                        </tr>
                        <tr>
                            <td class="w-40">Postcode</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($contact_details['postcode']) .'</td>
                        </tr>
                        <tr>
                            <td class="w-40">State / Province </td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($contact_details['state_proviance']) .'</td>
                        </tr>
                        <tr>
                            <td class="w-40">Country </td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($contact_details['country']) .'</td>
                        </tr>

                        ';
                         if ($contact_details['postal_address_is_different'] == "yes") {                
                            $html .= '
                            <tr>
                                <td class="">Postal Address is same as Residential Address </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($contact_details['postal_address_is_different']) .'</td>
                            </tr>';
                         } else {                
                            $html .= '
                            <tr>
                                <td colspan="3" class="w-40">
                                    <h5><b> Postal Address </b></h5>
                                </td>
                            </tr>
                            ';
                             if (!empty($contact_details['postal_unit_flat_number'])) {
                                $html .= '
                                <tr>
                                    <td class="w-40">Unit / Flat Number</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($contact_details['postal_unit_flat_number']) .'</td>
                                </tr>';
                             } 
                             if (!empty($contact_details['postal_street_lot_number'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">Street / lot Number </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($contact_details['postal_street_lot_number']) .'</td>
                                </tr>';
                             } 
                             if (!empty($contact_details['postal_street_name'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">Street Name </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($contact_details['postal_street_name']) .'</td>
                                </tr>';
                             } 

                             if (!empty($contact_details['postal_suburb'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40"> Suburb / City</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($contact_details['postal_suburb']) .'</td>
                                </tr>';
                             } 
                             if (!empty($contact_details['postal_postcode'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">Postcode</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($contact_details['postal_postcode']) .'</td>
                                </tr>';
                             } 
                             if (!empty($contact_details['postal_state_proviance'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">State / Province </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($contact_details['postal_state_proviance']) .'</td>
                                </tr>';
                             } 
                             if (!empty($contact_details['Postal_country'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">Country </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($contact_details['Postal_country']) .'</td>
                                </tr>';
                             } 


                         } 

                         if (!empty($contact_details['emergency_mobile']) or !empty($contact_details['first_name']) or !empty($contact_details['surname']) or !empty($contact_details['relationship'])) {                
                            $html .= '
                            <tr>
                                <td colspan="3" class="w-40">
                                    <h5><b> Emergency Contact Details </b></h5>
                                </td>
                            </tr>
                            ';
                         } 
                         if (!empty($contact_details['first_name'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">First Name </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . strtoupper($contact_details['first_name']) .'</td>
                            </tr>
                            ';
                         } 
                         if (!empty($contact_details['surname'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Surname </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . strtoupper($contact_details['surname']) .'</td>
                            </tr>
                            ';
                         } 
                         if (!empty($contact_details['relationship'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Relationship </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($contact_details['relationship']) .'</td>
                            </tr>
                            ';
                         } 
                         if (!empty($contact_details['emergency_mobile'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Mobile Number </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25"> +' . country_phonecode($contact_details['emergency_mobile_code']) . $contact_details['emergency_mobile'] .'</td>
                            </tr>
                            ';
                         } 
                         $html .= '
                    </table>
                </div>
                <hr style="text-align: center;page-break-after: always;" width="100%">


                <!-- -----------table 3 Identification Details ---------->
                <h5 class="text-center text-success Identification_Details" style="font-size: 15px;">Identification Details</h5>
                <div class="d-flex justify-content-center mt">
                    <table class="table table-borderless table-striped  w-100 table-striped print-friendly">

                        <tr>
                            <td class="w-40">Passport Country</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($identification_details['country_of_birth']) .'</td>
                        </tr>
                        <tr>
                            <td class="w-40">Place of Issue / Issuing Authority</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25"> ' . ucwords($identification_details['place_of_issue']) .'</td>
                        </tr>

                        <tr>
                            <td class="w-40">Passport Number</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . strtoupper($identification_details['passport_number']).'</td>
                        </tr>

                        <tr>
                            <td class="w-40"> Passport Expiry Date </td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25"> ' . $identification_details['expiry_date'] .'</td>
                        </tr>
                    </table>
                </div>
                <hr style="text-align: center;" width="100%">



                <!-- -----------table 3 Representative / Agent Details ---------->
                <h5 class=" text-center text-success USI" style="font-size: 15px;"> Unique Student Identifier (USI)</h5>
                <div class="d-flex justify-content-center mt">
                    <table class="table table-borderless table-hover  table-striped  w-100 print-friendly">

                        ';
                         if (isset($usi_details['currently_have_usi'])) {
                            if ($usi_details['currently_have_usi'] == "yes") { 
                                 if (!empty($usi_details['usi_no'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40">USI No.</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">' . strtoupper($usi_details['usi_no']) .'</td>
                                    </tr>';
                                 } 


                                 if (!empty($usi_details['have_usi_transcript'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40"> Do you have a USI Transcript </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">' . ucwords($usi_details['have_usi_transcript']) .'</td>
                                    </tr>';
                                     if ($usi_details['have_usi_transcript'] == 'no') { 
                                        $html .= '
                                        <tr>
                                            <td colspan="3" class="w-40">
                                                <style>
                                                    .bg-warning {
                                                        background-color: #ffc107 !important;
                                                    }

                                                    element.style {}

                                                    .p-2 {
                                                        padding: 0.5rem !important;
                                                    }

                                                    .mb-5,
                                                    .my-5 {
                                                        margin-bottom: 3rem !important;
                                                    }

                                                    .rounded {
                                                        border-radius: 0.25rem !important;
                                                    }
                                                </style>
                                                <div class=" instruction col-lg-12 bg-warning rounded p-2 ">
                                                    <b>Note:</b>
                                                    It is a mandatory requirement to verify qualifications for any Skills Assessment Application. If the USI Transcripts are unavailable, we will have to manually verify the qualifications from the RTO which has awarded the qualification.
                                                </div>
                                            </td>

                                        </tr>';


                                     } 
                                 } 



                                 if (!empty($usi_details['permission_access_usi_transcripts'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40"> I have assigned ATTC permission to access USI Transcripts </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">' . ucwords($usi_details['permission_access_usi_transcripts']) .'</td>
                                    </tr>';
                                 } 
                             } else {
                                $html .= '
                                <tr>
                                    <td class="w-40">I am offshore (outside of Australia) - Do not need any USI </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">';
                                                        if ($usi_details['currently_have_usi'] == "no") {
                                                            $html .= "Yes";
                                                        }                                     
                                                        $html .= '
                                                    </td>
                                </tr>';
                        
                            }
                        } 

                        $html .= '
                    </table>
                </div>
                <hr style="text-align: center;" width="100%">
                <h5 class=" text-center text-success USI" style="font-size: 15px;"> Marketing</h5>
                <div class="d-flex justify-content-center mt">
                    <table class="table table-borderless table-hover  table-striped  w-100 print-friendly">
                        <tr>
                            <td class="w-40" style="text-align: justify;"> I give Australian Trade Training College permission to use photos/ images in public material and social media (including any photos/ images where I may be recognised or participating in workplace activities) for current and future marketing and business purposes. I understand that I retain the right to withdraw my consent at any time via email to tra@attc.org.au. </td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($usi_details['marketing']) .'</td>
                        </tr>
                    </table>
                </div>
                <hr style="text-align: center;page-break-after: always;" width="100%">
                <!-- hide from applicant  --> ';
                // Old Bug Code
                //  if (!is_Agent()) { 
                // New Code By Mohsin 16 Feb
                 if ($register_user['account_type'] != "Agent") { 
                 } else { 
                     
                    $html .= '
                    <h5 class="text-center text-success Representative_Details" style="font-size: 15px;">Representative Details</h5>
                    <div class="d-flex justify-content-center mt">
                        <table class="table table-borderless table-striped  w-100 table-striped print-friendly">
                        ';
                             if (!empty($register_user['name'])) {                         
                                $html .= '
                                <tr>
                                    <td class="w-40">Name of Agent or Representative</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($register_user['name'])  ." ". ucwords($register_user['last_name']).' </td>
                                </tr>';
                             } 
                             if (!empty($register_user['business_name'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">Company Name (if applicable)</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($register_user['business_name']) .'</td>
                                </tr>';
                             } 
                             if (!empty($register_user['email'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">Email</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . $register_user['email'] .'</td>
                                </tr>';
                             } 
                             if (!empty($register_user['mobile_code'])) { 
                                 
                                $mobile_code = find_one_row("country", "id", $register_user['mobile_code']);
                                $html .= '
                                <tr>
                                    <td class="w-40">Mobile</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> +' . $mobile_code->phonecode  . $register_user['mobile_no'] .'</td>
                                </tr>';
                             } 
                             if (!empty($register_user['tel_code']) && !empty($register_user['tel_no'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">Telephone</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> +' . $register_user['tel_code'] ;
                                      if (!empty($register_user['area_code'])) {
                                        $html .= $register_user['tel_area_code'];
                                        }; 
                                        $html .=  $register_user['tel_no'] .'</td>
                                </tr>';
                             } 
                             if (!empty($register_user['unit_flat'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40"> Unit / Flat Number </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> ' . ucwords($register_user['unit_flat']) .'</td>
                                </tr>';
                             } 
                             if (!empty($register_user['street_lot'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40"> Street / Lot number </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> ' . ucwords($register_user['street_lot']) .'</td>
                                </tr>';
                             } 
                             if (!empty($register_user['street_name'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40"> Street Name </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> ' . ucwords($register_user['street_name']) .'</td>
                                </tr>';
                             } 

                             if (!empty($register_user['suburb_city'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40"> Suburb / City </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> ' . ucwords($register_user['suburb_city']) .'</td>
                                </tr>';
                             } 
                             if (!empty($register_user['state_province'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40"> State / Province </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> ' . ucwords($register_user['state_province']) .'</td>
                                </tr>';
                             } 
                             if (!empty($register_user['postcode'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40"> postcode </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> ' . ucwords($register_user['postcode']) .'</td>
                                </tr>';
                             } 

                             if (isset($register_user['postal_ad_same_physical_ad_check'])) { 
                                 if ($register_user['postal_ad_same_physical_ad_check'] == 1) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40">Postal Address Same As Physical Address </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"> Yes</td>
                                    </tr>';
                                 } else { 
                                    $html .= '
                                    <tr>
                                        <td colspan="3" class="w-40">
                                            <h5><b> Postal Address </b></h5>
                                        </td>
                                    </tr>';
                                     if (!empty($register_user['postal_unit_flat'])) { 
                                        $html .= '
                                        <tr>
                                            <td class="w-40"> Unit / Flat Number </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"> ' . ucwords($register_user['postal_unit_flat']) .'</td>
                                        </tr>';
                                     } 
                                     if (!empty($register_user['postal_street_lot'])) { 
                                        $html .= '
                                        <tr>
                                            <td class="w-40"> Street / Lot number </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"> ' . ucwords($register_user['postal_street_lot']) .'</td>
                                        </tr>';
                                     } 
                                     if (!empty($register_user['postal_street_name'])) { 
                                        $html .= '
                                        <tr>
                                            <td class="w-40"> Street Name </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"> ' . ucwords($register_user['postal_street_name']) .'</td>
                                        </tr>';
                                     } 

                                     if (!empty($register_user['postal_suburb_city'])) { 
                                        $html .= '
                                        <tr>
                                            <td class="w-40"> Suburb / City </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"> ' . ucwords($register_user['postal_suburb_city']) .'</td>
                                        </tr>';
                                     } 
                                     if (!empty($register_user['postal_state_province'])) { 
                                        $html .= '
                                        <tr>
                                            <td class="w-40"> State / Province </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"> ' . ucwords($register_user['postal_state_province']) .'</td>
                                        </tr>';
                                     } 
                                     if (!empty($register_user['postal_postcode'])) { 
                                        $html .= '
                                        <tr>
                                            <td class="w-40"> Postcode </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"> ' . ucwords($register_user['postal_postcode']) .'</td>
                                        </tr>';
                                     } 
                                }
                            } 
                            $html .= '
                        </table>
                    </div>
                    <hr style="text-align: center;page-break-after: always;" width="100%">
                    ';
                 } 
                 $html .= '
                <h5 class=" text-center text-success " style="font-size: 15px;"> Avetmiss Details </h5>
                <div class="d-flex justify-content-center mt">

                    <table class="table table-borderless table-hover  table-striped  w-100 print-friendly">
                    ';
                         if (!empty($identification_details['country_of_birth'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40"> Country of birth </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($identification_details['country_of_birth']) .'</td>
                            </tr>
                            ';
                         } 

                         if (!empty($usi_details['speak_english_at_home'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Do you speak a language other than English at home?</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($usi_details['speak_english_at_home']) .'</td>
                            </tr>';
                             if ($usi_details['speak_english_at_home'] == 'yes') { 
                                 if (!empty($usi_details['specify_language'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40"> Specify Language </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">' . ucwords($usi_details['specify_language']) .'</td>
                                    </tr>';
                                 } 
                                 if (!empty($usi_details['proficiency_in_english'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40">Proficiency in Spoken English?</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">' . ucwords($usi_details['proficiency_in_english']) .'</td>
                                    </tr>';
                                 } 


                             } 
                         } 

                         if (!empty($usi_details['are_you_aboriginal'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Are you of Aboriginal or Torres Strait Islander Origin?</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($usi_details['are_you_aboriginal']) .'</td>
                            </tr>';
                             if ($usi_details['are_you_aboriginal'] == 'yes') { 
                                 if (!empty($usi_details['choose_origin'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40"> Choose Origin Option </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">';  
                                                            if ($usi_details['choose_origin'] == "aboriginal") {
                                                                $html .= "Aboriginal";
                                                            }
                                                            if ($usi_details['choose_origin'] == "torres_strait_islander") {
                                                                $html .= "Torres strait islander";
                                                            }  ;'<td>
                                    </tr>';
                                 } 
                             } 
                         } 

                         if (!empty($usi_details['have_any_disability'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Do you consider yourself to have a disability, impairment or long-term condition?</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($usi_details['have_any_disability']) .'</td>
                            </tr>';
                             if ($usi_details['have_any_disability'] == 'yes') { 
                                if (!empty($usi_details['indicate_area'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40"> Please Indicate Area </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">' . ucwords($usi_details['indicate_area']) .'</td>
                                    </tr>';
                                 } 
                             } 
                         } 


                         if (!empty($usi_details['Please_indicate_area_NOTE'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40"> Please specify Indicate Area </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords(preg_replace('/[^A-Za-z0-9\-]/', ' ', $usi_details['Please_indicate_area_NOTE'], 255)) .'</td>
                            </tr>
                            ';
                         } 




                         if (!empty($usi_details['require_additional_support'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Will you require additional support to participate in this Skills Assessment?</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($usi_details['require_additional_support']) .'</td>
                            </tr>';
                             if ($usi_details['require_additional_support'] == 'yes') { 
                                $html .= '
                                <tr>
                                    <td class="w-40"> Please specify the support </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords(preg_replace('/[^A-Za-z0-9\-]/', ' ', $usi_details['note'], 255)) .'</td>
                                </tr>';
                             } 
                         } 



                         $html .= '
                    </table>
                </div>
                <hr style="text-align: center;page-break-after: always;" width="100%">



                <h5 class=" text-center text-success" style="font-size: 15px;"> Education Details </h5>
                <div class="d-flex justify-content-center mt">
                    <table class="table table-borderless table-hover  table-striped  w-100 print-friendly">
                        ';
                         if (!empty($education_and_employment['highest_completed_school_level'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40"> What is your highest COMPLETED school level ?</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($education_and_employment['highest_completed_school_level']) .'</td>
                            </tr>
                            <tr>
                                <td class="w-40">
                                    Are you still enrolled in secondary or senior secondary
                                    education ?
                                </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($education_and_employment['still_enrolled_in_secondary_or_senior_secondary_education']) .'</td>
                            </tr>';

                             if (!empty($education_and_employment['completed_any_qualifications'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">Have you SUCCESSFULLY completed any qualifications ?</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($education_and_employment['completed_any_qualifications']) .'</td>
                                </tr>';
                                 if ($education_and_employment['completed_any_qualifications'] == 'yes') { 
                                     if (!empty($education_and_employment['applicable_qualifications'])) { 
                                        $html .= '
                                        <tr>
                                            <td class="w-40"> Applicable Qualifications </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25">' . ucwords(str_replace('_', ' ', $education_and_employment['applicable_qualifications']))  .'</td>
                                        </tr>';
                                     } 
                                 } 
                             } 

                            
                         } 

                         $html .= '
                    </table>
                </div>



                <h5 class=" text-center text-success " style="font-size: 15px;"> Employment Details </h5>
                <div class="d-flex justify-content-center mt">
                    <table class="table table-borderless table-hover  table-striped  w-100 print-friendly">
                            ';
                         if (!empty($education_and_employment['current_employment_status'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40"> What is your current employment status ? </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords(str_replace('_', ' ', $education_and_employment['current_employment_status'])) .'</td>
                            </tr>
                            ';
                         } 

                         if (!empty($education_and_employment['reason_for_undertaking_this_skills_assessment'])) {   
                            $html .= '
                            <tr>
                                <td class="w-40"> What BEST describes your main reason for undertaking this skills assessment ? </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords(str_replace('_', ' ', $education_and_employment['reason_for_undertaking_this_skills_assessment'])) .'</td>
                            </tr>';
                             if ($education_and_employment['reason_for_undertaking_this_skills_assessment'] == 'Other_reasons') { 
                                 if (!empty($education_and_employment['other_reason_for_undertaking'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40"> Please specify the reason </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">' . ucwords(str_replace('_', ' ', $education_and_employment['other_reason_for_undertaking'])) .'</td>
                                    </tr>';
                                 } 
                             } 
                         } 

                         $html .= '
                    </table>
                </div>
                <hr style="text-align: center;" width="100%">';
            
            if($this->stage_1_review_confirm_model->where(['pointer_id' => $pointer_id])->set(['pdf_html_code' => $html])->update()){
                echo "update";
            }else{
                echo "fount some error";
            }

            // echo $html;
    }
    
    
    // Mohsin New 
    public function update_review_pdf_html_code__atadmin($ENC_pointer_id)
    {
         $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $register_user = $this->application_pointer_model->where('id', $pointer_id)->first();
        $user_id = $register_user['user_id'];
        // echo $this->application_pointer_model->getLastQuery();
        // print_r($register_user);
        // echo $pointer_id;
        // echo $user_id;
        // exit;

        $database = $this->stage_1_education_and_employment_model->where(['pointer_id' => $pointer_id])->find();
        $personal_details = $this->stage_1_personal_details_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $occupation = $this->stage_1_occupation_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $contact_details = $this->stage_1_contact_details_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $identification_details = $this->stage_1_identification_details_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $usi_details = $this->stage_1_usi_avetmiss_model->orderby('id', 'DESC')->where(['pointer_id' => $pointer_id])->first();
        $education_and_employment = $this->stage_1_education_and_employment_model->orderby('id', 'DESC')->where(['pointer_id' => $pointer_id])->first();
        $register_user = $this->user_account_model->where('id', $user_id)->first();
        $stage_1_pdf_download = $this->stage_1_review_confirm_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $occupation_id =  $occupation['occupation_id'];
        $occupation_list = find_one_row('occupation_list', 'id', $occupation_id);
        // print_r($register_user);
        // exit;
        $html ='<style>
                    .w-25 {
                        width: 50% !important;
                    }

                    .w-10 {
                        width: 10% !important;
                    }

                    .w-40 {
                        width: 50% !important;

                    }

                    table.print-friendly tr td,
                    table.print-friendly tr th {
                        page-break-inside: avoid;
                    }

                    td.w-40 {
                        padding-left: 20px;
                    }
                </style>
                <br>
                <h5 class=" text-center text-success Occupation " style="font-size: 15px;">Occupation Details</h5>
                <div class="d-flex justify-content-center">
                    <table class="table table-borderless table-hover w-80 table-striped print-friendly">

                        ';
                        if (!empty($occupation['occupation_id'])) {
                            $html .= '
                                <tr>
                                    <td class="w-40" class="">Occupation</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($occupation_list->name) . '</td>
                                </tr>
                            ';
                        }
                        if (!empty($occupation['program'])) {
                            $html .= '
                                <tr>
                                    <td class="w-40">Skills Assessment Program</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($occupation['program']) . '</td>
                                </tr>
                            ';
                        } if (!empty($occupation['pathway'])) { 
                            $html .= '
                            <tr>
                                <td class="w-40">Pathway</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($occupation['pathway']).'</td>
                            </tr>
                            ';
                        } 
                        if (!empty($occupation['currently_in_australia'])) {                
                        $html .= '
                        <tr>
                            <td class="w-40">Are you currently in Australia ?</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($occupation['currently_in_australia']) .'</td>
                        </tr>
                        ';
                        } 
                        if (!empty($occupation['currently_on_bridging_visa'])) {                
                        $html .= '
                        <tr>
                            <td class="w-40">Are you currently on a bridging Visa ?</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($occupation['currently_on_bridging_visa']) .'</td>
                        </tr>
                        ';
                        } 
                        if (!empty($occupation['current_visa_category'])) {                
                        $html .= '
                        <tr>
                            <td class="w-40">Current Visa Category & Subclass</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($occupation['current_visa_category']) .'</td>
                        </tr>
                        ';
                        } 
                        if (!empty($occupation['visa_expiry'])) {                
                        $html .= '
                        <tr>
                            <td class="w-40">Visa Expiry Date </td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . date('d/m/Y', strtotime($occupation['visa_expiry']))  .'</td>
                        </tr>
                        ';
                        } 
                        if (isset($occupation['conjunction_with_skills_assessment'])) {                
                        $html .= '
                        <tr>
                            <td class="w-40">Which visa do you intend to apply for in conjunction with this skills assessment ?</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($occupation['conjunction_with_skills_assessment']) .'</td>
                        </tr>
                        ';
                        } 
                        $html .= '
                    </table>
                </div>
                <hr style="text-align: center;" width="100%">


                <!-- -------------table 2 personal ------------ -->
                <div class=" justify-content-center Personal_Details">
                    <h5 class="text-center text-success" style="font-size: 15px;">Personal Details (As per Passport)</h5>

                    <table class="table table-borderless table-hover w-100 table-striped print-friendly">
                    ';
                         if (!empty($personal_details['preferred_title'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Preferred Title</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($personal_details['preferred_title']) .'</td>
                            </tr>
                            ';
                         } 
                         if (!empty($personal_details['surname_family_name'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Surname or family Name</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">
                                ';
                                    if (!empty($personal_details['surname_family_name'])) {
                                        $html .=  ucwords(strtolower(trim($personal_details['surname_family_name'])));
                                    } else {
                                        $html .=  "Not Applicable";
                                    }                                 
                                    $html .= '
                                    </td>
                            </tr>
                            ';
                         } 
                         if (!empty($personal_details['first_or_given_name'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">First or given Name</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25 ">' . ucwords(strtolower(trim($personal_details['first_or_given_name']))) .'</td>
                            </tr>
                            ';
                         } 
                         if (!empty($personal_details['middle_names'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Middle Name</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25 ">' . ucwords(strtolower(trim($personal_details['middle_names']))) .'</td>
                            </tr>
                            ';
                         } 
                         if (!empty($personal_details['known_by_any_name'])) {
                            if ($personal_details['known_by_any_name'] == 'no') {
                                $html .= '
                                <tr>
                                    <td class="w-40">Are you known by any other Name</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords(strtolower(trim($personal_details['known_by_any_name']))) .'</td>
                                </tr>
                                ';
                            } else {                                 
                                 if (!empty($personal_details['previous_surname_or_family_name'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40">Previous Surname or Family Name</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"> ' . ucwords(strtolower(trim($personal_details['previous_surname_or_family_name']))) .'
                                        </td>
                                    </tr>
                                    ';
                                 } 
                                 if (!empty($personal_details['previous_names'])) {                                    
                                     $html .= '
                                    <tr>
                                        <td class="w-40">Previous First or given Name</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"> ' . ucwords(strtolower(trim($personal_details['previous_names']))) .'
                                        </td>
                                    </tr>';
                                 } 
                                 if (!empty($personal_details['previous_Middle_names'])) {                                      
                                    $html .= '
                                    <tr>
                                        <td class="w-40">Previous Middle Name</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"> ' . ucwords(strtolower(trim($personal_details['previous_Middle_names']))) .'
                                        </td>
                                    </tr>';
                                 } 
                            }
                        } 
                        if (!empty($personal_details['gender'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Gender</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($personal_details['gender']) .'</td>
                            </tr>
                            ';
                        } 
                        if (!empty($personal_details['date_of_birth'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Date of Birth</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . $personal_details['date_of_birth'] .'</td>
                            </tr>
                            ';
                        } 
                        $html .= '
                    </table>
                </div>
                <hr style="text-align: center;page-break-after: always;" width="100%">

                <!-- -----------table 3 contact-------- -->



                <h5 class=" text-center text-success Contact_Details" style="font-size: 15px;">Contact Details</h5>
                <div class="d-flex justify-content-center mt">
                    <table class="table table-borderless table-hover w-100  table-striped print-friendly">
                        <tr>
                            <td class="w-40">Email</td>
                            <td class="w-10">:</td>
                            <td class="w-25"> ' . $contact_details['email'] .'</td>
                        </tr>
                        ';
                         if (!empty($contact_details['alternate_email'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40"> Alternate Email</td>
                                <td class="w-10">:</td>
                                <td class="w-25"> ' . $contact_details['alternate_email'] .'</td>
                            </tr>';
                          } 
                          $html .= '
                        <tr>
                            <td class="w-40">Mobile Number</td>
                            <td class="w-10">:</td>
                            <td class="w-25"> +' . country_phonecode($contact_details['mobile_number_code']) . $contact_details['mobile_number'] .'</td>
                        </tr>
                        ';
                         if (!empty($contact_details['alter_mobile'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Alternate Mobile Number
                                </td>
                                <td class="w-10">:</td>
                                <td class="w-25"> +' . country_phonecode($contact_details['alter_mobile_code']) . $contact_details['alter_mobile'] .' </td>
                            </tr>';
                          } 
                          $html .= '
                        <tr>
                            <td colspan="3" class="w-40">
                                <h5><b> Residential Address </b></h5>
                            </td>
                        </tr>';
                         if (!empty($contact_details['unit_flat_number'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Unit / Flat Number</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($contact_details['unit_flat_number']) .'</td>
                            </tr>
                            ';
                         } 
                         $html .= '
                        <tr>
                            <td class="w-40">Street / lot Number </td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($contact_details['street_lot_number']) .'</td>
                        </tr> 
                        <tr>
                            <td class="w-40">Street Name </td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($contact_details['street_name']) .'</td>
                        </tr>

                        <tr>
                            <td class="w-40"> Suburb / City</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($contact_details['suburb']) .'</td>
                        </tr>
                        <tr>
                            <td class="w-40">Postcode</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($contact_details['postcode']) .'</td>
                        </tr>
                        <tr>
                            <td class="w-40">State / Province </td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($contact_details['state_proviance']) .'</td>
                        </tr>
                        <tr>
                            <td class="w-40">Country </td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($contact_details['country']) .'</td>
                        </tr>

                        ';
                         if ($contact_details['postal_address_is_different'] == "yes") {                
                            $html .= '
                            <tr>
                                <td class="">Postal Address is same as Residential Address </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($contact_details['postal_address_is_different']) .'</td>
                            </tr>';
                         } else {                
                            $html .= '
                            <tr>
                                <td colspan="3" class="w-40">
                                    <h5><b> Postal Address </b></h5>
                                </td>
                            </tr>
                            ';
                             if (!empty($contact_details['postal_unit_flat_number'])) {
                                $html .= '
                                <tr>
                                    <td class="w-40">Unit / Flat Number</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($contact_details['postal_unit_flat_number']) .'</td>
                                </tr>';
                             } 
                             if (!empty($contact_details['postal_street_lot_number'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">Street / lot Number </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($contact_details['postal_street_lot_number']) .'</td>
                                </tr>';
                             } 
                             if (!empty($contact_details['postal_street_name'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">Street Name </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($contact_details['postal_street_name']) .'</td>
                                </tr>';
                             } 

                             if (!empty($contact_details['postal_suburb'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40"> Suburb / City</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($contact_details['postal_suburb']) .'</td>
                                </tr>';
                             } 
                             if (!empty($contact_details['postal_postcode'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">Postcode</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($contact_details['postal_postcode']) .'</td>
                                </tr>';
                             } 
                             if (!empty($contact_details['postal_state_proviance'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">State / Province </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($contact_details['postal_state_proviance']) .'</td>
                                </tr>';
                             } 
                             if (!empty($contact_details['Postal_country'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">Country </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($contact_details['Postal_country']) .'</td>
                                </tr>';
                             } 


                         } 

                         if (!empty($contact_details['emergency_mobile']) or !empty($contact_details['first_name']) or !empty($contact_details['surname']) or !empty($contact_details['relationship'])) {                
                            $html .= '
                            <tr>
                                <td colspan="3" class="w-40">
                                    <h5><b> Emergency Contact Details </b></h5>
                                </td>
                            </tr>
                            ';
                         } 
                         if (!empty($contact_details['first_name'])) {                
                            $html .= '      
                            <tr>
                                <td class="w-40">First Name </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords(strtolower(trim($contact_details['first_name']))) .'</td>
                            </tr>
                            ';
                         } 
                         if (!empty($contact_details['surname'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Surname </td>
                                <td class="w-10"><span class="">:</span></td>
                               <td class="w-25">' . ucwords(strtolower(trim($contact_details['surname']))) .'</td>
                            </tr>
                            ';
                         } 
                         if (!empty($contact_details['relationship'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Relationship </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords(strtolower(trim($contact_details['relationship']))) .'</td>
                            </tr>
                            ';
                         } 
                         if (!empty($contact_details['emergency_mobile'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Mobile Number </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25"> +' . country_phonecode($contact_details['emergency_mobile_code']) . $contact_details['emergency_mobile'] .'</td>
                            </tr>
                            ';
                         } 
                         $html .= '
                    </table>
                </div>
                <hr style="text-align: center;page-break-after: always;" width="100%">


                <!-- -----------table 3 Identification Details ---------->
                <h5 class="text-center text-success Identification_Details" style="font-size: 15px;">Identification Details</h5>
                <div class="d-flex justify-content-center mt">
                    <table class="table table-borderless table-striped  w-100 table-striped print-friendly">

                        <tr>
                            <td class="w-40">Passport Country</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($identification_details['country_of_birth']) .'</td>
                        </tr>
                        <tr>
                            <td class="w-40">Place of Issue / Issuing Authority</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25"> ' . ucwords($identification_details['place_of_issue']) .'</td>
                        </tr>

                        <tr>
                            <td class="w-40">Passport Number</td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . strtoupper($identification_details['passport_number']).'</td>
                        </tr>

                        <tr>
                            <td class="w-40"> Passport Expiry Date </td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25"> ' . $identification_details['expiry_date'] .'</td>
                        </tr>
                    </table>
                </div>
                <hr style="text-align: center;" width="100%">



                <!-- -----------table 3 Representative / Agent Details ---------->
                <h5 class=" text-center text-success USI" style="font-size: 15px;"> Unique Student Identifier (USI)</h5>
                <div class="d-flex justify-content-center mt">
                    <table class="table table-borderless table-hover  table-striped  w-100 print-friendly">

                        ';
                         if (isset($usi_details['currently_have_usi'])) {
                            if ($usi_details['currently_have_usi'] == "yes") { 
                                 if (!empty($usi_details['usi_no'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40">USI No.</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">' . strtoupper($usi_details['usi_no']) .'</td>
                                    </tr>';
                                 } 


                                 if (!empty($usi_details['have_usi_transcript'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40"> Do you have a USI Transcript </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">' . ucwords($usi_details['have_usi_transcript']) .'</td>
                                    </tr>';
                                     if ($usi_details['have_usi_transcript'] == 'no') { 
                                        $html .= '
                                        <tr>
                                            <td colspan="3" class="w-40">
                                                <style>
                                                    .bg-warning {
                                                        background-color: #ffc107 !important;
                                                    }

                                                    element.style {}

                                                    .p-2 {
                                                        padding: 0.5rem !important;
                                                    }

                                                    .mb-5,
                                                    .my-5 {
                                                        margin-bottom: 3rem !important;
                                                    }

                                                    .rounded {
                                                        border-radius: 0.25rem !important;
                                                    }
                                                </style>
                                                <div class=" instruction col-lg-12 bg-warning rounded p-2 ">
                                                    <b>Note:</b>
                                                    It is a mandatory requirement to verify qualifications for any Skills Assessment Application. If the USI Transcripts are unavailable, we will have to manually verify the qualifications from the RTO which has awarded the qualification.
                                                </div>
                                            </td>

                                        </tr>';


                                     } 
                                 } 



                                 if (!empty($usi_details['permission_access_usi_transcripts'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40"> I have assigned ATTC permission to access USI Transcripts </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">' . ucwords($usi_details['permission_access_usi_transcripts']) .'</td>
                                    </tr>';
                                 } 
                             } else {
                                $html .= '
                                <tr>
                                    <td class="w-40">I am offshore (outside of Australia) - Do not need any USI </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">';
                                                        if ($usi_details['currently_have_usi'] == "no") {
                                                            $html .= "Yes";
                                                        }                                     
                                                        $html .= '
                                                    </td>
                                </tr>';
                        
                            }
                        } 

                        $html .= '
                    </table>
                </div>
                <hr style="text-align: center;" width="100%">
                <h5 class=" text-center text-success USI" style="font-size: 15px;"> Marketing</h5>
                <div class="d-flex justify-content-center mt">
                    <table class="table table-borderless table-hover  table-striped  w-100 print-friendly">
                        <tr>
                            <td class="w-40" style="text-align: justify;"> I give Australian Trade Training College permission to use photos/ images in public material and social media (including any photos/ images where I may be recognised or participating in workplace activities) for current and future marketing and business purposes. I understand that I retain the right to withdraw my consent at any time via email to tra@attc.org.au. </td>
                            <td class="w-10"><span class="">:</span></td>
                            <td class="w-25">' . ucwords($usi_details['marketing']) .'</td>
                        </tr>
                    </table>
                </div>
                <hr style="text-align: center;page-break-after: always;" width="100%">
                <!-- hide from applicant  --> ';
                // Old Bug Code
                //  if (is_Agent()){ 
                    if ($register_user['account_type'] == "Agent") { 
                    $html .= '
                    <h5 class="text-center text-success Representative_Details" style="font-size: 15px;">Representative Details</h5>
                    <div class="d-flex justify-content-center mt">
                        <table class="table table-borderless table-striped  w-100 table-striped print-friendly">
                        ';
                             if (!empty($register_user['name'])) {                         
                                $html .= '
                                <tr>
                                    <td class="w-40">Name of Agent or Representative</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($register_user['name'])  ." ". ucwords($register_user['last_name']).' </td>
                                </tr>';
                             } 
                             if (!empty($register_user['business_name'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">Company Name (if applicable)</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($register_user['business_name']) .'</td>
                                </tr>';
                             } 
                             if (!empty($register_user['email'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">Email</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . $register_user['email'] .'</td>
                                </tr>';
                             } 
                             if (!empty($register_user['mobile_code'])) { 
                                $mobile_code = find_one_row("country", "id", $register_user['mobile_code']);
                                $html .= '
                                <tr>
                                    <td class="w-40">Mobile</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> +' . $mobile_code->phonecode  . $register_user['mobile_no'] .'</td>
                                </tr>';
                             } 
                             if (!empty($register_user['tel_code']) && !empty($register_user['tel_no'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">Telephone</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> +' . $register_user['tel_code'] ;
                                      if (!empty($register_user['area_code'])) {
                                        $html .= $register_user['tel_area_code'];
                                        }; 
                                        $html .=  $register_user['tel_no'] .'</td>
                                </tr>';
                             } 
                             if (!empty($register_user['unit_flat'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40"> Unit / Flat Number </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> ' . ucwords($register_user['unit_flat']) .'</td>
                                </tr>';
                             } 
                             if (!empty($register_user['street_lot'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40"> Street / Lot number </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> ' . ucwords($register_user['street_lot']) .'</td>
                                </tr>';
                             } 
                             if (!empty($register_user['street_name'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40"> Street Name </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> ' . ucwords($register_user['street_name']) .'</td>
                                </tr>';
                             } 

                             if (!empty($register_user['suburb_city'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40"> Suburb / City </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> ' . ucwords($register_user['suburb_city']) .'</td>
                                </tr>';
                             } 
                             if (!empty($register_user['state_province'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40"> State / Province </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> ' . ucwords($register_user['state_province']) .'</td>
                                </tr>';
                             } 
                             if (!empty($register_user['postcode'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40"> postcode </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> ' . ucwords($register_user['postcode']) .'</td>
                                </tr>';
                             } 

                             if (isset($register_user['postal_ad_same_physical_ad_check'])) { 
                                 if ($register_user['postal_ad_same_physical_ad_check'] == 1) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40">Postal Address Same As Physical Address </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"> Yes</td>
                                    </tr>';
                                 } else { 
                                    $html .= '
                                    <tr>
                                        <td colspan="3" class="w-40">
                                            <h5><b> Postal Address </b></h5>
                                        </td>
                                    </tr>';
                                     if (!empty($register_user['postal_unit_flat'])) { 
                                        $html .= '
                                        <tr>
                                            <td class="w-40"> Unit / Flat Number </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"> ' . ucwords($register_user['postal_unit_flat']) .'</td>
                                        </tr>';
                                     } 
                                     if (!empty($register_user['postal_street_lot'])) { 
                                        $html .= '
                                        <tr>
                                            <td class="w-40"> Street / Lot number </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"> ' . ucwords($register_user['postal_street_lot']) .'</td>
                                        </tr>';
                                     } 
                                     if (!empty($register_user['postal_street_name'])) { 
                                        $html .= '
                                        <tr>
                                            <td class="w-40"> Street Name </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"> ' . ucwords($register_user['postal_street_name']) .'</td>
                                        </tr>';
                                     } 

                                     if (!empty($register_user['postal_suburb_city'])) { 
                                        $html .= '
                                        <tr>
                                            <td class="w-40"> Suburb / City </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"> ' . ucwords($register_user['postal_suburb_city']) .'</td>
                                        </tr>';
                                     } 
                                     if (!empty($register_user['postal_state_province'])) { 
                                        $html .= '
                                        <tr>
                                            <td class="w-40"> State / Province </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"> ' . ucwords($register_user['postal_state_province']) .'</td>
                                        </tr>';
                                     } 
                                     if (!empty($register_user['postal_postcode'])) { 
                                        $html .= '
                                        <tr>
                                            <td class="w-40"> Postcode </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"> ' . ucwords($register_user['postal_postcode']) .'</td>
                                        </tr>';
                                     } 
                                }
                            } 
                            $html .= '
                        </table>
                    </div>
                    <hr style="text-align: center;page-break-after: always;" width="100%">
                    ';
                 } 
                 $html .= '
                <h5 class=" text-center text-success " style="font-size: 15px;"> Avetmiss Details </h5>
                <div class="d-flex justify-content-center mt">

                    <table class="table table-borderless table-hover  table-striped  w-100 print-friendly">
                    ';
                         if (!empty($identification_details['country_of_birth'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40"> Country of birth </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($identification_details['country_of_birth']) .'</td>
                            </tr>
                            ';
                         } 

                         if (!empty($usi_details['speak_english_at_home'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Do you speak a language other than English at home?</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($usi_details['speak_english_at_home']) .'</td>
                            </tr>';
                             if ($usi_details['speak_english_at_home'] == 'yes') { 
                                 if (!empty($usi_details['specify_language'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40"> Specify Language </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">' . ucwords($usi_details['specify_language']) .'</td>
                                    </tr>';
                                 } 
                                 if (!empty($usi_details['proficiency_in_english'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40">Proficiency in Spoken English?</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">' . ucwords($usi_details['proficiency_in_english']) .'</td>
                                    </tr>';
                                 } 


                             } 
                         } 

                         if (!empty($usi_details['are_you_aboriginal'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Are you of Aboriginal or Torres Strait Islander Origin?</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($usi_details['are_you_aboriginal']) .'</td>
                            </tr>';
                             if ($usi_details['are_you_aboriginal'] == 'yes') { 
                                 if (!empty($usi_details['choose_origin'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40"> Choose Origin Option </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">';  
                                                            if ($usi_details['choose_origin'] == "aboriginal") {
                                                                $html .= "Aboriginal";
                                                            }
                                                            if ($usi_details['choose_origin'] == "torres_strait_islander") {
                                                                $html .= "Torres strait islander";
                                                            }  ;'<td>
                                    </tr>';
                                 } 
                             } 
                         } 

                         if (!empty($usi_details['have_any_disability'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Do you consider yourself to have a disability, impairment or long-term condition?</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($usi_details['have_any_disability']) .'</td>
                            </tr>';
                             if ($usi_details['have_any_disability'] == 'yes') { 
                                if (!empty($usi_details['indicate_area'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40"> Please Indicate Area </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">' . ucwords($usi_details['indicate_area']) .'</td>
                                    </tr>';
                                 } 
                             } 
                         } 


                         if (!empty($usi_details['Please_indicate_area_NOTE'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40"> Please specify Indicate Area </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords(preg_replace('/[^A-Za-z0-9\-]/', ' ', $usi_details['Please_indicate_area_NOTE'], 255)) .'</td>
                            </tr>
                            ';
                         } 




                         if (!empty($usi_details['require_additional_support'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40">Will you require additional support to participate in this Skills Assessment?</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($usi_details['require_additional_support']) .'</td>
                            </tr>';
                             if ($usi_details['require_additional_support'] == 'yes') { 
                                $html .= '
                                <tr>
                                    <td class="w-40"> Please specify the support </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords(preg_replace('/[^A-Za-z0-9\-]/', ' ', $usi_details['note'], 255)) .'</td>
                                </tr>';
                             } 
                         } 



                         $html .= '
                    </table>
                </div>
                <hr style="text-align: center;page-break-after: always;" width="100%">


                <h5 class=" text-center text-success" style="font-size: 15px;"> Education Details </h5>
                <div class="d-flex justify-content-center mt">
                    <table class="table table-borderless table-hover  table-striped  w-100 print-friendly">
                        ';
                         if (!empty($education_and_employment['highest_completed_school_level'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40"> What is your highest COMPLETED school level ?</td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($education_and_employment['highest_completed_school_level']) .'</td>
                            </tr>
                            <tr>
                                <td class="w-40">
                                    Are you still enrolled in secondary or senior secondary
                                    education ?
                                </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords($education_and_employment['still_enrolled_in_secondary_or_senior_secondary_education']) .'</td>
                            </tr>';

                             if (!empty($education_and_employment['completed_any_qualifications'])) { 
                                $html .= '
                                <tr>
                                    <td class="w-40">Have you SUCCESSFULLY completed any qualifications ?</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25">' . ucwords($education_and_employment['completed_any_qualifications']) .'</td>
                                </tr>';
                                 if ($education_and_employment['completed_any_qualifications'] == 'yes') { 
                                     if (!empty($education_and_employment['applicable_qualifications'])) { 
                                        $html .= '
                                        <tr>
                                            <td class="w-40"> Applicable Qualifications </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25">' . ucwords(str_replace('_', ' ', $education_and_employment['applicable_qualifications']))  .'</td>
                                        </tr>';
                                     } 
                                 } 
                             } 

                            
                         } 

                         $html .= '
                    </table>
                </div>



                <h5 class=" text-center text-success " style="font-size: 15px;"> Employment Details </h5>
                <div class="d-flex justify-content-center mt">
                    <table class="table table-borderless table-hover  table-striped  w-100 print-friendly">
                            ';
                         if (!empty($education_and_employment['current_employment_status'])) {                
                            $html .= '
                            <tr>
                                <td class="w-40"> What is your current employment status ? </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords(str_replace('_', ' ', $education_and_employment['current_employment_status'])) .'</td>
                            </tr>
                            ';
                         } 

                         if (!empty($education_and_employment['reason_for_undertaking_this_skills_assessment'])) {   
                            $html .= '
                            <tr>
                                <td class="w-40"> What BEST describes your main reason for undertaking this skills assessment ? </td>
                                <td class="w-10"><span class="">:</span></td>
                                <td class="w-25">' . ucwords(str_replace('_', ' ', $education_and_employment['reason_for_undertaking_this_skills_assessment'])) .'</td>
                            </tr>';
                             if ($education_and_employment['reason_for_undertaking_this_skills_assessment'] == 'Other_reasons') { 
                                 if (!empty($education_and_employment['other_reason_for_undertaking'])) { 
                                    $html .= '
                                    <tr>
                                        <td class="w-40"> Please specify the reason </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">' . ucwords(str_replace('_', ' ', $education_and_employment['other_reason_for_undertaking'])) .'</td>
                                    </tr>';
                                 } 
                             } 
                         } 

                         $html .= '
                    </table>
                </div>
                <hr style="text-align: center;" width="100%">';
            
            if($this->stage_1_review_confirm_model->where(['pointer_id' => $pointer_id])->set(['pdf_html_code' => $html])->update()){
                echo "update";
            }else{
                echo "fount some error";
            }

            // echo $html;
    }
    
}
