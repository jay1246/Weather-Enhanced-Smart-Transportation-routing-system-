<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class applicant_declaration extends BaseController
{
    public function applicant_declaration($ENC_pointer_id)
    {
        // Decode ------
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        $stage_1_review_confirm = $this->stage_1_review_confirm_model->where(['pointer_id' =>  $pointer_id])->orderby('id', 'DESC')->first();
        $occupation_application = $this->stage_1_occupation_model->where(['pointer_id' =>  $pointer_id])->orderby('id', 'DESC')->first();
        $data_file_download = Applicant_Declaration($ENC_pointer_id, 'review_confirm_pdf_download');
        $occupation_list = $this->occupation_list_model->where('id', $occupation_application['occupation_id'])->first();
        $offline_file_model = $this->offline_file_model->where('occupation_id', $occupation_application['occupation_id'])->find();
        $digital_signature_info = $this->digital_signature_info_model->where('pointer_id', $pointer_id)->first();

        $data = [
            'page' => "Applicant Declaration",
            'occupation_application' => $occupation_application,
            'stage_1_review_confirm' => $stage_1_review_confirm,
            'data_file_download' => $data_file_download,
            'occupation_list' => $occupation_list,
            'ENC_pointer_id' => $ENC_pointer_id,
            'offline_file_model' => $offline_file_model,
            'digital_signature_info' => $digital_signature_info,
            'portal_reference_no' => portal_reference_no($pointer_id),

        ];


        return view('user/stage_1/applicant_declaration', $data);
    } // funtion close



    public function information_release_form_($ENC_pointer_id)
    {
        // Decode ------
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        $perosnal_details = $this->stage_1_personal_details_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();

        $tra_logo = base_url('public/assets/image/tra.png');
        $attc_logo =  base_url('public/assets/image/attc_logo.png');
        $name = $perosnal_details["first_or_given_name"];
        $middal_name = $perosnal_details["middle_names"];
        $last_name = $perosnal_details["surname_family_name"];
        $date_of_birth =  $perosnal_details["date_of_birth"];

        $html = '  <html>
                <head>
                    <title>Information Release Form</title>
                    <style>
                    
                        @page {
                            margin: 0cm 0cm;
                        }
            
                        /** Define now the real margins of every page in the PDF **/
                        body {
                            font-size: 90%;
                            font-family: Arial, Helvetica, sans-serif;
                            margin-top: 4.8cm;
                            margin-left: 2cm;
                            margin-right: 2cm;
                            margin-bottom: 1cm;
                        }
            
                        /** Define the header rules **/
                        header {
                            position: fixed;
                            top: 1cm;
                            left: 1cm;
                            right: 0cm;
                            height: 2cm;
                        }
            
                        /** Define the footer rules **/
                        footer {
                            position: fixed;
                            bottom: 0cm;
                            left: 1cm;
                            right: 0cm;
                            height: 2cm;
                        }
            
            
                        #tra {
                            position: absolute;
                            left: 70%;
                        }
            
                        table {
                            border-collapse: collapse;
                            width: 100%;
                            text-size:8px;
                        }
            
                        table td {
                            font-size: 10px !important;
                
                         }
                    </style>
                </head>
                <body>
                    <!-- Define header and footer blocks before your content style="padding:0px 20px 0px 20px; height:100px" -->
                    <header>
                        <img src="' . $tra_logo . '" alt="Aqato" height="auto" width="10%">
                        <img src="' . $attc_logo . '" alt="Aqato" height="100px" width="50%">
                        <div id="tra"> <b> Information Release Request</b> </div>
                    </header>
                    <div style="text-align:center; margin-top: -30px;">
                        <b>
                            Consent to release personal information to Australian Trade Training College,
                            <br>RTO Provider Number 31399
                        </b>
                    </div>
                    <p style="margin-top:15px;">
                        I <b> ' . $name . ' ' . $middal_name . ' ' . $last_name . '</b>, date of birth <b> ' . $date_of_birth . ' </b>give
                        permission to release my personal information as described below to Australian Trade Training
                        College for the purposes of verifying qualifications and/or employment for my Skills Assessment
                        application.
                    </p>
                    <p style="margin-top:20px;">
                        I request <b> my employer </b> provide to Australian Trade Training College:
                    <ul style="margin-top: 0px;">
                        <li style="margin-top: 0px;">
                            Verification of employment including:
                        </li>
                        - Position held <br>
                        - Duration of employment <br>
                        - Nature of employment i.e. fulltime, part time or casual <br>
                        - Tasks and duties undertaken <br>
                    </ul>
                    </p>
                    <p style="margin-top:20px;">
                        I request <b> my training organisation </b> provide to Australian Trade Training College:
                    <ul>
                        <li> Verification of qualifications and transcript </li>
                    </ul>
                    </p>
                    <p style="margin-top:15px;">
                        The information gathered by Australian Trade Training College is used solely for the purposes stated above on behalf of Trades Recognition Australia.
                    </p>
                    <p>
                        Further information on the requirements can be obtained by contacting:
                    </p>
                    <br>
                    <br>
                    <div style="text-align:center;"> Australian Trade Training College and its partners. </div>
                    <div style="text-align:center"> 294 Scarborough Road, Scarborough QLD 4020.</div>
            
                    <div style="text-align: center;">T: +61 7 3414 5997 &nbsp; &nbsp; &nbsp; &nbsp;Email: <a href="tra@attc.org.au">tra@attc.org.au</a> &nbsp; &nbsp; &nbsp; &nbsp; Web: <a href="attc.org.au">attc.org.au </a> </div>
            
                    <br>
                    <div style="text-align:center;margin-top:15px"> C/o The Down Under Centre.
                        <br>
                        Strathleven House, Vale of Leven Industrial Estate, Dumbarton G82 3PD UK
                    </div>
                    <div style="text-align: center;">T: +44 20 3376 1555 &nbsp; &nbsp; &nbsp; Email: <a href="Blakeburn@attc.org.au">Mars.Blakeburn@attc.org.au </a> </div>
                    <br>
            
            
            
                    <div style="text-align:center;margin-top:15px">C/o AQATO. <br>
                        Office No. S-04, Regus Harmony, Level 4, Tower-A, Godrej Eternia, Plot Number 70,<br>
                        Industrial Area 1, Chandigarh - 160002 INDIA</div>
            
                    <div style="text-align: center;">T: +91 172 4071505 &nbsp; &nbsp; &nbsp; &nbsp;M: +91 988 8286702 &nbsp; &nbsp; &nbsp; &nbsp;Email: <a href="Dilpreet.Bagga@attc.org.au">&nbsp;Dilpreet.Bagga@attc.org.au&nbsp;</a></div>
            
                    <div id="container" style="margin-top: 50px;">
                        <div id="left" style="float:left;"> Signature of Applicant: </div>
                        <div id="right" style="float:right;  "> Date :' . date("d/m/Y") . ' </div>
                        <div id="center"></div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <table border="1" style="text-align: center;">
                        <tr>
                            <td>
                                Document Name
                            </td>
                            <td colspan="2">
                                Information Release v4
                            </td>
                            <td>
                                Page 1
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Issue Date: March 2021
                            </td>
                            <td>
                                Review Date: May 2022
                            </td>
                            <td>
                                Next Review Date: November 2022
                            </td>
                            <td>
                                V2/2022
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                Document Control Management - Uncontrolled when Printed
                            </td>
                        </tr>
                    </table>
            
            
                </body>
            
                </html>
                ';

        // Digital signachur 
        // email send to agent or applicant  // digital signature
        // return $html;


        // start creat PDF 
        $html = "";
        require_once "dompdf/autoload.inc.php";
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->loadhtml($html);
        $dompdf->setpaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Information Release Form');
    } // funtion close

     public function applicant_declaration_pdf_($ENC_pointer_id)
    {
        // Decode ------
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->first();
        $user_id = $application_pointer['user_id'];

        $perosnal_details = $this->stage_1_personal_details_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $agent_details = $this->user_account_model->where(['id' => $user_id])->orderby('id', 'DESC')->first();

        $p_name = "";
        if (!empty($perosnal_details)) {
            $p_name =   $perosnal_details['first_or_given_name'] . " " . $perosnal_details["middle_names"] . " " . $perosnal_details['surname_family_name'];
        }


        $ag_name = "NA";
        $ag_business_name = "NA";
        $ag_mobile = "";
        $ag_email = "NA";
        $ag_tel_no = "";
        $tel_code = "NA";
        $tel_area_code = "";
        $mobile_code = "NA";

        //  agent info aupdate if agent login 
        if (is_Agent()) {
            if (!empty($agent_details)) {
                $ag_name =   $agent_details['name'] . " " . $agent_details['last_name'];
                $ag_business_name =  (!empty($agent_details['business_name'])) ? $agent_details['business_name'] : "";

                $mobile_code = "";
                if (!empty($agent_details['mobile_code'])) {
                    $mobile_code =  "+" . $agent_details['mobile_code'];
                } else {
                    $mobile_code = "";
                }

                $ag_mobile =  $agent_details['mobile_no'];
                $ag_email =   $agent_details['email'];

                $tel_code =  "";
                if (!empty($agent_details['tel_code']) && !empty($agent_details['tel_area_code']) && !empty($agent_details['tel_no'])) {
                    $tel_code =  "+" . $agent_details['tel_code'] . " " . $agent_details['tel_area_code'] . " " . $agent_details['tel_no'];
                } else {
                    $tel_code = "";
                }
            }
        }


if (is_Agent()) {
        $text_hide='<tr>
                <td colspan="3" style="background-color: #96b5e4;padding: 3px;padding-left: 10px;  ">
                  <b> APPOINTMENT OF AN AGENT /EMPLOYER </b>(optional)
                </td>
              <tr>
                <td colspan="1" width="30%">
                  <b> AGENT/EMPLOYER COMPANY NAME</b>
                </td>
                <td colspan="2">
                ' . $ag_business_name . '
                </td>
              </tr>
              <tr>
                <td colspan="1" width="30%">
                  <b> AGENT/EMPLOYER REPRESENTATIVE NAME </b>
                </td>
                <td colspan="2">
                ' . $ag_name . '
                </td>
              </tr>
              <tr>
                <td colspan="1" width="30%">
                  <b> CONTACT DETAILS </b>
                </td>
                <td colspan="2" style="  padding: 0px;">
                  <div width="30%" style="margin: 0px; padding:10px; padding-left: 10px; border-bottom: 1px solid;">
                    Email :  ' . $ag_email . '
                  </div>
                  <div width="30%" style="float: left;padding-left: 10px; padding:10px;">
                    Mobile :  ' . $mobile_code . ' ' . $ag_mobile . '
                  </div>
                  <div width="30%" style="margin-left: 50%;padding-left: 10px;padding:10px;">
                    Telephone: ' . $tel_code . ' 
                  </div>
                </td>
              </tr>
              <tr>
                <td colspan="3" style="background-color: #96b5e4;padding: 3px;padding-left: 10px;  ">
                  <b> AUTHORISATION </b>
                </td>
              </tr>
              <tr>
                <td colspan="1" width="30%" style="  text-align: center;  vertical-align: middle;">
                <input type="checkbox" checked/>

                </td>
                <td colspan="2">
                  I wish to have all correspondence directed to my Agent/Employer, including Outcome<br>
                  Letter and/or Qualifications. Further I approve Australian Trade Training College to make<br>
                  direct contact with my Agent or Employer to discuss my application, should the need arise.<br>
                </td>
              </tr>
            
      

              </tr>
              <tr>
              <td colspan="3" style="  background-color: #96b5e4;padding: 10px;padding-left: 10px;">
                <b> By signing this form I confirm I have read and understood both the Privacy Notice and Application Declaration above. </b>
              </td>
            </tr>';
}else{
    $text_hide="";
}


        $html = '<html>
                    <head>
                    <title>Applicant Declaration</title>
                    <style>
                        @page {
                        margin: 0cm 0cm;
                        }
                        #tra {
                        position: absolute;
                        left: 70%;
                        // margin-top: -10px;
                        }

                        body {
                        font-family: Arial, Helvetica, sans-serif;
                        margin-top: 3.8cm;
                        margin-left: 30px;
                        margin-right: 30px;
                        margin-bottom: 2cm;
                        }

                        header {
                        position: fixed;
                        top: 0.5cm;
                        left: 1cm;
                        right: 1cm;
                        height: 60px;
                        /*border-bottom: 1px solid;*/
                        }

                        table {
                        border-collapse: collapse;
                        width: 100%;
                        filter: alpha(opacity=40);
                        opacity: 0.95;
                        border: 1px black solid;
                        }

                        table td,
                        table th {
                        border: 1px black solid;
                        padding: 3px;
                        padding-left: 10px;
                        }

                        #main {
                        font-size: 12px;
                        
                        }

                            hr {
                                clear: both;
                                visibility: hidden;
                            }
                            .my_df{
                                font-size: 12px;
                            }
                            .m_top{
                                margin-top: -50px;
                            }
                            input[type="checkbox"]{
                                width: 30px; /*Desired width*/
                                height: 30px; /*Desired height*/
                                cursor: pointer;
                                -webkit-appearance: none;
                                appearance: none;
                            }
                    </style>
                    </head>
                    <body>
                    <header>
                        <img src="' . base_url('public/assets/image/tra.png') . '" alt="Aqato" height="auto" width="10%">
                        <img src="' . base_url('public/assets/image/attc_logo.png') . '" alt="Aqato" height="70px" width="50%">
                        <div id="tra">PRIVACY NOTICE &
                        APPLICANT DECLARATION</div>
                    </header>

                    <div id="main">
                        <table border="2pc solid black" class="m_top my_df">
                        <tr>
                            <td style="background-color: #96b5e4;padding: 3px;padding-left: 10px;">
                            <b> PRIVACY NOTICE</b>
                            </td>
                        <tr>
                            <td>
                            <b> WHY WE COLLECT YOUR PERSONAL INFORMATION</b><br>
                            As a registered training organisation (RTO), we collect your personal information so we can process and manage your
                            application for a skills assessment under a Trades Recognition Australia program and if applicable in a vocational education
                            and training (VET) qualification with us. Failing to provide the following information prior or at application will delay the
                            commencement of your skills assessment:
                            <ul style="margin: 0px;">
                                <li> Unique Student Identifier </li>
                                <li> Appropriate identification as listed on page 2 </li>
                                <li> A detailed current version of your CV / Resume </li>
                            </ul>
                            <br>
                            <b>HOW WE USE YOUR PERSONAL INFORMATION</b><br>
                            We use your personal information to enable us to undertake your skills assessment in line with our RTO obligations within our
                            Deed with Trades Recognition Australia and if applicable issue you with a VET qualification, and otherwise, as needed, to
                            comply with our obligations as an RTO.<br><br>
                            <b>HOW WE DISCLOSE YOUR PERSONAL INFORMATION</b><br>
                            In instances a qualification is issued we are required by law (under the National Vocational Education and Training Regulator
                            Act 2011 (Cth) (NVETR Act)) to disclose the personal information we collect about you to the National VET Data Collection
                            kept by the National Centre for Vocational Education Research Ltd (NCVER). The NCVER is responsible for collecting,
                            managing, analysing and communicating research and statistics about the Australian VET sector. We are also authorised by
                            law (under the NVETR Act) to disclose your personal information to the relevant state or territory training authority and other
                            government bodies such as Department Education, Skills and Employment<br>
                            <br>
                            <b>HOW THE NCVER ANOTHER BODIES HANDLE YOUR PERSONAL INFORMATION </b><br>
                            The NCVER will collect, hold, use and disclose your personal information in accordance with the law, including the Privacy Act
                            1988 (Cth) (Privacy Act) and the NVETR Act. Your personal information may be used and disclosed by NCVER for purposes that
                            include populating authenticated VET transcripts; administration of VET; facilitation of statistics and research relating to
                            education, including surveys and data linkage; and understanding the VET market.<br>
                            The NCVER is auhorised to disclose information to the Australian Government Department of Education, Skills and
                            Employment (DESE), Commonwealth authorities, State and Territory authorities (other than registered training organisations)
                            that deal with matters relating to VET and VET regulators for the purposes of those bodies, including to enable:
                            <ul style="margin: 0px;">
                            <li> administration of VET, including program administration, regulation, monitoring and evaluation </li>
                            <li>  facilitation of statistics and research relating to education, including surveys and data linkage </li>
                            <li> understanding how the VET market operates, for policy, workforce planning and consumer information. </li>
                            </ul>
            ';

        $html = $html . '
                  The NCVER may also disclose personal information to persons engaged by NCVER to conduct research on NCVER’s behalf.
                  The NCVER does not intend to disclose your personal information to any overseas recipients.
                  For more information about how the NCVER will handle your personal information please refer to the NCVER’s Privacy Policy
                  at <a href="www.ncver.edu.au/privacy">www.ncver.edu.au/privacy.</a><br>
                  If you would like to seek access to or correct your information, in the first instance, please contact your RTO using the contact
                  details listed below.<br>
                  DESE is authorised by law, including the Privacy Act and the NVETR Act, to collect, use and disclose your personal information
                  to fulfil specified functions and activities. For more information about how the DESE will handle your personal information,
                  please refer to the DESE VET Privacy Notice at<a href=" https://www.dese.gov.au/national-vet-data/vet-privacy-notice"> https://www.dese.gov.au/national-vet-data/vet-privacy-notice.</a><br><br>
                  Australian Trade Training College is an approved Skills Assure Supplier with Department of Employment, Small Business and
                  Training and are required to disclose personal information directly to them. Please refer to their Information Privacy Policy at
                  <a href="https://www.publications.qld.gov.au/dataset/desbt-corporate-documents/resource/6ddc87de-ef73-4baf-8ebd-3309da44fc6f">https://www.publications.qld.gov.au/dataset/desbt-corporate-documents/resource/6ddc87de-ef73-4baf-8ebd-3309da44fc6f</a>
                  <br><br>
                  In addition Australian Trade Training College will also disclose information about your training in the following circumstances:
                  <ul style="margin: 0px;">
                    <li> your employer or agent listed on this application form;</li>
                    <li> Registered Training Organisations who request to verify any training you have undertaken with Australian Trade</li>
                    Training College are valid and authentic.
                  </ul><br>
                  <b>SURVEYS</b><br>
                  You may receive a student survey which may be run by a government department or an NCVER employee, agent, third-party
                  contractor or another authorised agency. Please note you may opt out of the survey at the time of being contacted.<br>

                </td>
              </tr>
              </tr>
            </table>

            <hr style="text-align: center;page-break-after: always;" width="100%">

            <table class="m_top">
              <tr>
                <td colspan="3" style="background-color: #96b5e4;padding: 3px;padding-left: 10px;  ">
                  <b> PRIVACY NOTICE (continued) </b>
                </td>
              <tr>
                <td colspan="3">
                  <b>CONTACT INFORMATION</b><br>
                  At any time, you may contact Australian Trade Training College to:
                  <ul style="margin:0px;">
                    <li> request access to your personal information </li>
                    <li> correct your personal information </li>
                    <li> make a complaint about how your personal information has been handled </li>
                    <li> ask a question about this Privacy Notice </li>
                  </ul>
                  <br>
                  You can view Australian Trade Training College Privacy Policy, TRA Applicant Information Handbook at
                  <br>
                  <a href="https://attc.org.au/about-us/policies-and-procedures/">https://attc.org.au/about-us/policies-and-procedures/</a>
                  <br>
                  <br>
                  You can also view the forms and policies with Trades Recognition Australia at
                  <br>
                  <a href="https://www.tradesrecognitionaustralia.gov.au/forms-policy">https://www.tradesrecognitionaustralia.gov.au/forms-policy</a>
                  <br>
                  <br>
                  Phone: 1300 017 199<br>
                  Email: tra@attc.org.au<br>
                  <a href="https://attc.org.au">https://attc.org.au</a>
                  <br>
                  <br>
                </td>
              </tr>
              <tr>
                <td colspan="3" style="background-color: #96b5e4;padding: 3px;padding-left: 10px;  ">
                  <b> APPLICANT DECLARATION</b>
                </td>
              </tr>';
        $html = $html . '
              <tr>
                <td colspan="3">
                  <b>I declare that:</b><br>
                  <ul style="margin:0px;">
                    <li> I declare that the information I have provided to the best of my knowledge is true and correct. </li>
                    <li> I consent to the collection, use and disclosure of my personal information in accordance with the Privacy Notice above. </li>
                    <li> In making this application for a skills assessment, I am aware of the consequences that may arise from providing false, misleading or incomplete
                    information, including the cancellation of my skills assessment. </li>
                    <li> I have received and/or accessed and read the TRA Applicant Information Handbook and understand my rights and responsibilities as an applicant. </li>
                    <li> My decision to complete and submit this application form has been without coercion, </li>
                    <li> I have received and/or accessed the Trades Recognition Australia fee schedule, </li>
                    <li> I have read and I understand the Trades Recognition Australia refund policy, </li>
                    <li> I have been provided with sufficient information on Assessment arrangements, </li>
                    <li> I have read and I consent to the collection, use and disclosure of my personal information (which may include sensitive information) pursuant to the 
                    information detailed, and NCVER policies, procedures and protocols published on NCVER’s website at <a href="www.ncver.edu.au
                ">www.ncver.edu.au 
                    </a>
                    </li>
                  </ul>
                  <br>
                </td>
              </tr>
            
            </table>
         <br>
            <table  class="">
              ' . $text_hide . '
            <tr>
              <td style="padding: 20px;  " width="30%">
                <b> Applicant Signature</b>
              </td>
              <td style="padding: 20px;  " width="40%">

              </td>
              <td style="padding: 20px;  " width="30%">
                Date :  ' . date('d/m/Y') . '
              </td>
            </tr>
            <tr>
              <td colspan="1">
                <b>Applicant Name </b>
              </td>
              <td colspan="2">
                  ' . $p_name . '
              </td>
            </tr>
            </table>
          </div>
        </body>
        </html>';

        // return $html;
        // // echo $html;
        // // exit;
        $html = "";

        // -------------main code----------
        require_once "dompdf/autoload.inc.php";
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->loadhtml($html);
        $dompdf->setpaper('A4', 'portrait');
        // $dompdf->set_option("isPhpEnabled", true);
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

        $dompdf->stream('Applicant Declaration');
    } // funtion close





    public function DS_information_release_form_($ENC_pointer_id)
    {
        // Decode ------
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        $perosnal_details = $this->stage_1_personal_details_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();

        $tra_logo = base_url('public/assets/image/tra.png');
        $attc_logo =  base_url('public/assets/image/attc_logo.png');
        $name = $perosnal_details["first_or_given_name"];
        $middal_name = $perosnal_details["middle_names"];
        $last_name = $perosnal_details["surname_family_name"];
        $date_of_birth =  $perosnal_details["date_of_birth"];


        $digital_signing = "";
        $digital_signature_info = $this->digital_signature_info_model->where(['pointer_id' => $pointer_id, 'stage' => 'stage_1', 'email_signachred' => 1])->first();
        if (!empty($digital_signature_info)) {
            $documents = $this->documents_model->where(['pointer_id' => $pointer_id, 'name' => 'signature'])->first();
            if (!empty($documents)) {
                $full_umg_url_digital_signature = base_url($documents['document_path'] . '/' . $documents['document_name']);
                $digital_signing = '  <img width="120px"  height="auto" src="' . $full_umg_url_digital_signature . '" />';
            }
        }

        $html = '  <html>
                <head>
                    <title>Information Release Form</title>
                    <style>
                    
                        @page {
                            margin: 0cm 0cm;
                        }
            
                        /** Define now the real margins of every page in the PDF **/
                        body {
                            font-size: 90%;
                            font-family: Arial, Helvetica, sans-serif;
                            margin-top: 4.8cm;
                            margin-left: 2cm;
                            margin-right: 2cm;
                            margin-bottom: 1cm;
                        }
            
                        /** Define the header rules **/
                        header {
                            position: fixed;
                            top: 1cm;
                            left: 1cm;
                            right: 0cm;
                            height: 2cm;
                        }
            
                        /** Define the footer rules **/
                        footer {
                            position: fixed;
                            bottom: 0cm;
                            left: 1cm;
                            right: 0cm;
                            height: 2cm;
                        }
            
            
                        #tra {
                            position: absolute;
                            left: 70%;
                        }
            
                        table {
                            border-collapse: collapse;
                            width: 100%;
                            text-size:8px;
                        }
            
                        table td {
                            font-size: 10px !important;
                
                         }
                    </style>
                </head>
                <body>
                    <!-- Define header and footer blocks before your content style="padding:0px 20px 0px 20px; height:100px" -->
                    <header>
                        <img src="' . $tra_logo . '" alt="Aqato" height="auto" width="10%">
                        <img src="' . $attc_logo . '" alt="Aqato" height="100px" width="50%">
                        <div id="tra"> <b> Information Release Request</b> </div>
                    </header>
                    <div style="text-align:center; margin-top: -30px;">
                        <b>
                            Consent to release personal information to Australian Trade Training College,
                            <br>RTO Provider Number 31399
                        </b>
                    </div>
                    <p style="margin-top:15px;">
                        I <b> ' . $name . ' ' . $middal_name . ' ' . $last_name . '</b>, date of birth <b> ' . $date_of_birth . ' </b>give
                        permission to release my personal information as described below to Australian Trade Training
                        College for the purposes of verifying qualifications and/or employment for my Skills Assessment
                        application.
                    </p>
                    <p style="margin-top:20px;">
                        I request <b> my employer </b> provide to Australian Trade Training College:
                    <ul style="margin-top: 0px;">
                        <li style="margin-top: 0px;">
                            Verification of employment including:
                        </li>
                        - Position held <br>
                        - Duration of employment <br>
                        - Nature of employment i.e. fulltime, part time or casual <br>
                        - Tasks and duties undertaken <br>
                    </ul>
                    </p>
                    <p style="margin-top:20px;">
                        I request <b> my training organisation </b> provide to Australian Trade Training College:
                    <ul>
                        <li> Verification of qualifications and transcript </li>
                    </ul>
                    </p>
                    <p style="margin-top:15px;">
                        The information gathered by Australian Trade Training College is used solely for the purposes stated above on behalf of Trades Recognition Australia.
                    </p>
                    <p>
                        Further information on the requirements can be obtained by contacting:
                    </p>
                    <br>
                    <br>
                    <div style="text-align:center;"> Australian Trade Training College and its partners. </div>
                    <div style="text-align:center"> 294 Scarborough Road, Scarborough QLD 4020.</div>
            
                    <div style="text-align: center;">T: +61 7 3414 5997 &nbsp; &nbsp; &nbsp; &nbsp;Email: <a href="tra@attc.org.au">tra@attc.org.au</a> &nbsp; &nbsp; &nbsp; &nbsp; Web: <a href="attc.org.au">attc.org.au </a> </div>
            
                    <br>
                    <div style="text-align:center;margin-top:15px"> C/o The Down Under Centre.
                        <br>
                        Strathleven House, Vale of Leven Industrial Estate, Dumbarton G82 3PD UK
                    </div>
                    <div style="text-align: center;">T: +44 20 3376 1555 &nbsp; &nbsp; &nbsp; Email: <a href="Blakeburn@attc.org.au">Mars.Blakeburn@attc.org.au </a> </div>
                    <br>
            
            
            
                    <div style="text-align:center;margin-top:15px">C/o AQATO. <br>
                        Office No. S-04, Regus Harmony, Level 4, Tower-A, Godrej Eternia, Plot Number 70,<br>
                        Industrial Area 1, Chandigarh - 160002 INDIA</div>
            
                    <div style="text-align: center;">T: +91 172 4071505 &nbsp; &nbsp; &nbsp; &nbsp;M: +91 988 8286702 &nbsp; &nbsp; &nbsp; &nbsp;Email: <a href="Dilpreet.Bagga@attc.org.au">&nbsp;Dilpreet.Bagga@attc.org.au&nbsp;</a></div>
            
                    <div id="container" style="margin-top: 50px;">
                        <div id="left" style="float:left;"> Signature of Applicant: 
                        ' . $digital_signing . '
                        </div>
                        <div id="right" style="float:right;  "> Date :' . date("d/m/Y") . ' </div>
                        <div id="center"></div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <table border="1" style="text-align: center; ">
                        <tr>
                            <td>
                                Document Name
                            </td>
                            <td colspan="2">
                                Information Release v4
                            </td>
                            <td>
                                Page 1
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Issue Date: March 2021
                            </td>
                            <td>
                                Review Date: May 2022
                            </td>
                            <td>
                                Next Review Date: November 2022
                            </td>
                            <td>
                                V2/2022
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                Document Control Management - Uncontrolled when Printed
                            </td>
                        </tr>
                    </table>
            
            
                </body>
            
                </html>
                ';


        if (!empty($digital_signature_info)) {
            $html = $html . '
                                <table border="1"report as spam style="font-size: 20px;  margin-top: 120px; padding:50px">
                                    <tr>
                                        <td style="width: 220px;">
                                            Emal send
                                        </td>
                                        <td>
                                          ' . $digital_signature_info['email_send_time'] . '
                                        </td>
                                    </tr>
            
                                    <tr>
                                        <td>
                                          Emal Open
                                        </td>
                                        <td>
                                          ' . $digital_signature_info['email_open_time'] . ' &emsp; / &emsp;' . $digital_signature_info['client_ip'] . '
                                        </td>
                                    </tr>
            
                                    <tr>
                                        <td>
                                          Signature
                                        </td>
                                        <td>
                                          ' . $digital_signature_info['email_signachr_time']  . ' &emsp; / &emsp; ' . $digital_signature_info['REMOTE_ADDR']  . '
                                        </td>
                                    </tr>
            
                                    <tr>
                                        <td>
                                           System Information
                                        </td>
                                        <td>
                                          ' . $digital_signature_info['HTTP_USER_AGENT'] . '
                                        </td>
                                    </tr>
                                </table>
                           
                          ';
        }
        // Digital signachur 
        // email send to agent or applicant  // digital signature
        // return $html;


        // start creat PDF 
        // $html = "";
        require_once "dompdf/autoload.inc.php";
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->loadhtml($html);
        $dompdf->setpaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Information Release Form.pdf');
    } // funtion close

    public function DS_applicant_declaration_pdf_($ENC_pointer_id)
    {
        // Decode ------
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
        $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->first();
        $user_id = $application_pointer['user_id'];

        $perosnal_details = $this->stage_1_personal_details_model->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->first();
        $agent_details = $this->user_account_model->where(['id' => $user_id])->orderby('id', 'DESC')->first();

        $p_name = "";
        if (!empty($perosnal_details)) {
            $p_name =   $perosnal_details['first_or_given_name'] . " " . $perosnal_details["middle_names"] . " " . $perosnal_details['surname_family_name'];
        }


        $ag_name = "NA";
        $ag_business_name = "NA";
        $ag_mobile = "NA";
        $ag_email = "NA";
        $ag_tel_no = "NA";
        $tel_code = "NA";
        $tel_area_code = "";
        $mobile_code = "NA";

        //  agent info aupdate if agent login 
        $mobile_code = "";
        $checked = "";
        if (is_Agent()) {
            $checked = "checked";
            if (!empty($agent_details)) {
                $ag_name =   $agent_details['name'] . " " . $agent_details['last_name'];
                $ag_business_name =  (!empty($agent_details['business_name'])) ? $agent_details['business_name'] : "";
                if (!empty($agent_details['mobile_code'])) {

                    $mobile_code =  "+" . country_phonecode($agent_details['mobile_code']);
                } else {
                    $mobile_code = "";
                }

                $ag_mobile =  $agent_details['mobile_no'];
                $ag_email =   $agent_details['email'];

                $tel_code =  "";
                if (!empty($agent_details['tel_code']) && !empty($agent_details['tel_area_code']) && !empty($agent_details['tel_no'])) {
                    $tel_code =  "+" . country_phonecode($agent_details['tel_code']) . " " . $agent_details['tel_area_code'] . " " . $agent_details['tel_no'];
                } else {
                    $tel_code = "";
                }
            }
        }
        $digital_signing = "";
        $digital_signature_info = $this->digital_signature_info_model->where(['pointer_id' => $pointer_id, 'stage' => 'stage_1', 'email_signachred' => 1])->first();
        if (!empty($digital_signature_info)) {
            $documents = $this->documents_model->where(['pointer_id' => $pointer_id, 'name' => 'signature'])->first();
            if (!empty($documents)) {
                $full_umg_url_digital_signature = base_url($documents['document_path'] . '/' . $documents['document_name']);
                $digital_signing = '  <img width="120px"  height="auto" src="' . $full_umg_url_digital_signature . '" />';
            }
        }
        
         if (is_Agent()) {
$hide_show='
<tr>
                <td colspan="3" style="background-color: #96b5e4;padding: 3px;padding-left: 10px;  ">
                  <b> APPOINTMENT OF AN AGENT /EMPLOYER </b>(optional)
                </td>
              <tr>
                <td colspan="1" width="30%">
                  <b> AGENT/EMPLOYER COMPANY NAME</b>
                </td>
                <td colspan="2">
                ' . $ag_business_name . '
                </td>
              </tr>
              <tr>
                <td colspan="1" width="30%">
                  <b> AGENT/EMPLOYER REPRESENTATIVE NAME </b>
                </td>
                <td colspan="2">
                ' . $ag_name . '
                </td>
              </tr>
              <tr>
                <td colspan="1" width="30%">
                  <b> CONTACT DETAILS </b>
                </td>
                <td colspan="2" style="  padding: 0px;">
                  <div width="30%" style="margin: 0px; padding:10px; padding-left: 10px; border-bottom: 1px solid;">
                    Email :  ' . $ag_email . '
                  </div>
                  <div width="30%" style="float: left;padding-left: 10px; padding:10px;">
                    Mobile :  ' . $mobile_code . ' ' . $ag_mobile . '
                  </div>
                  <div width="30%" style="margin-left: 50%;padding-left: 10px;padding:10px;">
                    Telephone: ' . $tel_code . ' 
                  </div>
                </td>
              </tr>
              <tr>
                <td colspan="3" style="background-color: #96b5e4;padding: 3px;padding-left: 10px;  ">
                  <b> AUTHORISATION </b>
                </td>
              </tr>
              <tr>
                <td colspan="1" width="30%" style="  text-align: center;  vertical-align: middle;">
                <input type="checkbox" ' . $checked . '/>

                </td>
                <td colspan="2">
                  I wish to have all correspondence directed to my Agent/Employer, including Outcome<br>
                  Letter and/or Qualifications. Further I approve Australian Trade Training College to make<br>
                  direct contact with my Agent or Employer to discuss my application, should the need arise.<br>
                </td>
              </tr>
            
      

              </tr>
              <tr>';
         }else{
          $hide_show=" ";   
         } 
              
        $html = '<html>
                    <head>
                    <title>Applicant Declaration</title>
                    <style>
                        @page {
                        margin: 0cm 0cm;
                        }
                        #tra {
                        position: absolute;
                        left: 70%;
                        // margin-top: -10px;
                        }

                        body {
                        font-family: Arial, Helvetica, sans-serif;
                        margin-top: 3.8cm;
                        margin-left: 30px;
                        margin-right: 30px;
                        margin-bottom: 2cm;
                        }

                        header {
                        position: fixed;
                        top: 0.5cm;
                        left: 1cm;
                        right: 1cm;
                        height: 60px;
                        /*border-bottom: 1px solid;*/
                        }

                        table {
                        border-collapse: collapse;
                        width: 100%;
                        filter: alpha(opacity=40);
                        opacity: 0.95;
                        border: 1px black solid;
                        }

                        table td,
                        table th {
                        border: 1px black solid;
                        padding: 3px;
                        padding-left: 10px;
                        }

                        #main {
                        font-size: 12px;
                        
                        }

                            hr {
                                clear: both;
                                visibility: hidden;
                            }
                            .my_df{
                                font-size: 12px;
                            }
                            .m_top{
                                margin-top: -50px;
                            }
                            input[type="checkbox"]{
                                width: 30px; /*Desired width*/
                                height: 30px; /*Desired height*/
                                cursor: pointer;
                                -webkit-appearance: none;
                                appearance: none;
                            }
                    </style>
                    </head>
                    <body>
                    <header>
                        <img src="' . base_url('public/assets/image/tra.png') . '" alt="Aqato" height="auto" width="10%">
                        <img src="' . base_url('public/assets/image/attc_logo.png') . '" alt="Aqato" height="70px" width="50%">
                        <div id="tra">PRIVACY NOTICE &
                        APPLICANT DECLARATION</div>
                    </header>

                    <div id="main">
                        <table border="2pc solid black" class="m_top my_df">
                        <tr>
                            <td style="background-color: #96b5e4;padding: 3px;padding-left: 10px;">
                            <b> PRIVACY NOTICE</b>
                            </td>
                        <tr>
                            <td>
                            <b> WHY WE COLLECT YOUR PERSONAL INFORMATION</b><br>
                            As a registered training organisation (RTO), we collect your personal information so we can process and manage your
                            application for a skills assessment under a Trades Recognition Australia program and if applicable in a vocational education
                            and training (VET) qualification with us. Failing to provide the following information prior or at application will delay the
                            commencement of your skills assessment:
                            <ul style="margin: 0px;">
                                <li> Unique Student Identifier </li>
                                <li> Appropriate identification as listed on page 2 </li>
                                <li> A detailed current version of your CV / Resume </li>
                            </ul>
                            <br>
                            <b>HOW WE USE YOUR PERSONAL INFORMATION</b><br>
                            We use your personal information to enable us to undertake your skills assessment in line with our RTO obligations within our
                            Deed with Trades Recognition Australia and if applicable issue you with a VET qualification, and otherwise, as needed, to
                            comply with our obligations as an RTO.<br><br>
                            <b>HOW WE DISCLOSE YOUR PERSONAL INFORMATION</b><br>
                            In instances a qualification is issued we are required by law (under the National Vocational Education and Training Regulator
                            Act 2011 (Cth) (NVETR Act)) to disclose the personal information we collect about you to the National VET Data Collection
                            kept by the National Centre for Vocational Education Research Ltd (NCVER). The NCVER is responsible for collecting,
                            managing, analysing and communicating research and statistics about the Australian VET sector. We are also authorised by
                            law (under the NVETR Act) to disclose your personal information to the relevant state or territory training authority and other
                            government bodies such as Department Education, Skills and Employment<br>
                            <br>
                            <b>HOW THE NCVER ANOTHER BODIES HANDLE YOUR PERSONAL INFORMATION </b><br>
                            The NCVER will collect, hold, use and disclose your personal information in accordance with the law, including the Privacy Act
                            1988 (Cth) (Privacy Act) and the NVETR Act. Your personal information may be used and disclosed by NCVER for purposes that
                            include populating authenticated VET transcripts; administration of VET; facilitation of statistics and research relating to
                            education, including surveys and data linkage; and understanding the VET market.<br>
                            The NCVER is auhorised to disclose information to the Australian Government Department of Education, Skills and
                            Employment (DESE), Commonwealth authorities, State and Territory authorities (other than registered training organisations)
                            that deal with matters relating to VET and VET regulators for the purposes of those bodies, including to enable:
                            <ul style="margin: 0px;">
                            <li> administration of VET, including program administration, regulation, monitoring and evaluation </li>
                            <li>  facilitation of statistics and research relating to education, including surveys and data linkage </li>
                            <li> understanding how the VET market operates, for policy, workforce planning and consumer information. </li>
                            </ul>
            ';

        $html = $html . '
                  The NCVER may also disclose personal information to persons engaged by NCVER to conduct research on NCVER’s behalf.
                  The NCVER does not intend to disclose your personal information to any overseas recipients.
                  For more information about how the NCVER will handle your personal information please refer to the NCVER’s Privacy Policy
                  at <a href="www.ncver.edu.au/privacy">www.ncver.edu.au/privacy.</a><br>
                  If you would like to seek access to or correct your information, in the first instance, please contact your RTO using the contact
                  details listed below.<br>
                  DESE is authorised by law, including the Privacy Act and the NVETR Act, to collect, use and disclose your personal information
                  to fulfil specified functions and activities. For more information about how the DESE will handle your personal information,
                  please refer to the DESE VET Privacy Notice at<a href=" https://www.dese.gov.au/national-vet-data/vet-privacy-notice"> https://www.dese.gov.au/national-vet-data/vet-privacy-notice.</a><br><br>
                  Australian Trade Training College is an approved Skills Assure Supplier with Department of Employment, Small Business and
                  Training and are required to disclose personal information directly to them. Please refer to their Information Privacy Policy at
                  <a href="https://www.publications.qld.gov.au/dataset/desbt-corporate-documents/resource/6ddc87de-ef73-4baf-8ebd-3309da44fc6f">https://www.publications.qld.gov.au/dataset/desbt-corporate-documents/resource/6ddc87de-ef73-4baf-8ebd-3309da44fc6f</a>
                  <br><br>
                  In addition Australian Trade Training College will also disclose information about your training in the following circumstances:
                  <ul style="margin: 0px;">
                    <li> your employer or agent listed on this application form;</li>
                    <li> Registered Training Organisations who request to verify any training you have undertaken with Australian Trade</li>
                    Training College are valid and authentic.
                  </ul><br>
                  <b>SURVEYS</b><br>
                  You may receive a student survey which may be run by a government department or an NCVER employee, agent, third-party
                  contractor or another authorised agency. Please note you may opt out of the survey at the time of being contacted.<br>

                </td>
              </tr>
              </tr>
            </table>

            <hr style="text-align: center;page-break-after: always;" width="100%">

            <table class="m_top">
              <tr>
                <td colspan="3" style="background-color: #96b5e4;padding: 3px;padding-left: 10px;  ">
                  <b> PRIVACY NOTICE (continued) </b>
                </td>
              <tr>
                <td colspan="3">
                  <b>CONTACT INFORMATION</b><br>
                  At any time, you may contact Australian Trade Training College to:
                  <ul style="margin:0px;">
                    <li> request access to your personal information </li>
                    <li> correct your personal information </li>
                    <li> make a complaint about how your personal information has been handled </li>
                    <li> ask a question about this Privacy Notice </li>
                  </ul>
                  <br>
                  You can view Australian Trade Training College Privacy Policy, TRA Applicant Information Handbook at
                  <br>
                  <a href="https://attc.org.au/about-us/policies-and-procedures/">https://attc.org.au/about-us/policies-and-procedures/</a>
                  <br>
                  <br>
                  You can also view the forms and policies with Trades Recognition Australia at
                  <br>
                  <a href="https://www.tradesrecognitionaustralia.gov.au/forms-policy">https://www.tradesrecognitionaustralia.gov.au/forms-policy</a>
                  <br>
                  <br>
                  Phone: 1300 017 199<br>
                  Email: tra@attc.org.au<br>
                  <a href="https://attc.org.au">https://attc.org.au</a>
                  <br>
                  <br>
                </td>
              </tr>
              <tr>
                <td colspan="3" style="background-color: #96b5e4;padding: 3px;padding-left: 10px;  ">
                  <b> APPLICANT DECLARATION</b>
                </td>
              </tr>';
        $html = $html . '
              <tr>
                <td colspan="3">
                  <b>I declare that:</b><br>
                  <ul style="margin:0px;">
                    <li> I declare that the information I have provided to the best of my knowledge is true and correct. </li>
                    <li> I consent to the collection, use and disclosure of my personal information in accordance with the Privacy Notice above. </li>
                    <li> In making this application for a skills assessment, I am aware of the consequences that may arise from providing false, misleading or incomplete
                    information, including the cancellation of my skills assessment. </li>
                    <li> I have received and/or accessed and read the TRA Applicant Information Handbook and understand my rights and responsibilities as an applicant. </li>
                    <li> My decision to complete and submit this application form has been without coercion, </li>
                    <li> I have received and/or accessed the Trades Recognition Australia fee schedule, </li>
                    <li> I have read and I understand the Trades Recognition Australia refund policy, </li>
                    <li> I have been provided with sufficient information on Assessment arrangements, </li>
                    <li> I have read and I consent to the collection, use and disclosure of my personal information (which may include sensitive information) pursuant to the 
                    information detailed, and NCVER policies, procedures and protocols published on NCVER’s website at <a href="www.ncver.edu.au
                ">www.ncver.edu.au 
                    </a>
                    </li>
                  </ul>
                  <br>
                </td>
              </tr>
            
            </table>
         <br>
            <table  class="">
              '.$hide_show.'
              <td colspan="3" style="  background-color: #96b5e4;padding: 10px;padding-left: 10px;">
                <b> By signing this form I confirm I have read and understood both the Privacy Notice and Application Declaration above. </b>
              </td>
            </tr>
            <tr>
              <td style="padding: 20px;  " width="30%">
                <b> Applicant Signature</b>
              </td>
              <td style="padding: 20px;  " width="40%">
              ' . $digital_signing . '
              </td>
              <td style="padding: 20px;  " width="30%">
                Date :  ' . date('d/m/Y') . '
              </td>
            </tr>
            <tr>
              <td colspan="1">
                <b>Applicant Name </b>
              </td>
              <td colspan="2">
                  ' . $p_name . '
              </td>
            </tr>
            </table>
          </div>
        </body>
        </html>';

        // return $html;
        if (!empty($digital_signature_info)) {
            $html = $html . '
                    <table style="font-size: 20px;  margin-top: 120px; padding:50px">
                     
                        <tr>
                            <td style="width: 220px;">
                                Emal send
                            </td>
                            <td>
                              ' . $digital_signature_info['email_send_time'] . '
                            </td>
                        </tr>

                        <tr>
                            <td>
                              Emal Open
                            </td>
                            <td>
                              ' . $digital_signature_info['email_open_time'] . ' &emsp; / &emsp;' . $digital_signature_info['client_ip'] . '
                            </td>
                        </tr>

                        <tr>
                            <td>
                              Signature
                            </td>
                            <td>
                              ' . $digital_signature_info['email_signachr_time']  . ' &emsp; / &emsp; ' . $digital_signature_info['REMOTE_ADDR']  . '
                            </td>
                        </tr>

                        <tr>
                            <td>
                               System Information
                            </td>
                            <td>
                              ' . $digital_signature_info['HTTP_USER_AGENT'] . '
                            </td>
                        </tr>

                    </table>
              ';
        }
        // echo $html;
        // exit;
        // $html = "";

        // -------------main code----------
        require_once "dompdf/autoload.inc.php";
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->loadhtml($html);
        $dompdf->setpaper('A4', 'portrait');
        // $dompdf->set_option("isPhpEnabled", true);
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

        $dompdf->stream('Applicant Declaration.pdf');
    } // funtion close

    public function DS_get_digital_signing_HTML_Code($ENC_pointer_id)
    {
    }







    public function DS_applicant_declaration_pdf__()
    {
        // Decode ------
        $user_id = $this->session->get('user_id');
        $agent_details = $this->user_account_model->where(['id' => $user_id])->orderby('id', 'DESC')->first();

        $p_name = "";

        $ag_name = "NA";
        $ag_business_name = "NA";
        $ag_mobile = "";
        $ag_email = "NA";
        $ag_tel_no = "";
        $tel_code = "NA";
        $tel_area_code = "";
        $mobile_code = "NA";
           $checked=" ";
        //  agent info aupdate if agent login 
        $mobile_code = "";
        if (is_Agent()) {
             $checked="checked";
            if (!empty($agent_details)) {
                $ag_name =   $agent_details['name'] . " " . $agent_details['last_name'];
                $ag_business_name =  (!empty($agent_details['business_name'])) ? $agent_details['business_name'] : "";
                if (!empty($agent_details['mobile_code'])) {

                    $mobile_code =  "+" . country_phonecode($agent_details['mobile_code']);
                } else {
                    $mobile_code = "";
                }

                $ag_mobile =  $agent_details['mobile_no'];
                $ag_email =   $agent_details['email'];

                $tel_code =  "";
                if (!empty($agent_details['tel_code']) && !empty($agent_details['tel_area_code']) && !empty($agent_details['tel_no'])) {
                    $tel_code =  "+" . country_phonecode($agent_details['tel_code']) . " " . $agent_details['tel_area_code'] . " " . $agent_details['tel_no'];
                } else {
                    $tel_code = "";
                }
            }
        }
        $digital_signing = "";


        $html = '<html>
                    <head>
                    <title>Applicant Declaration</title>
                    <style>
                        @page {
                        margin: 0cm 0cm;
                        }
                        #tra {
                        position: absolute;
                        left: 70%;
                        // margin-top: -10px;
                        }

                        body {
                        font-family: Arial, Helvetica, sans-serif;
                        margin-top: 3.8cm;
                        margin-left: 30px;
                        margin-right: 30px;
                        margin-bottom: 2cm;
                        }

                        header {
                        position: fixed;
                        top: 0.5cm;
                        left: 1cm;
                        right: 1cm;
                        height: 60px;
                        /*border-bottom: 1px solid;*/
                        }

                        table {
                        border-collapse: collapse;
                        width: 100%;
                        filter: alpha(opacity=40);
                        opacity: 0.95;
                        border: 1px black solid;
                        }

                        table td,
                        table th {
                        border: 1px black solid;
                        padding: 3px;
                        padding-left: 10px;
                        }

                        #main {
                        font-size: 12px;
                        
                        }

                            hr {
                                clear: both;
                                visibility: hidden;
                            }
                            .my_df{
                                font-size: 12px;
                            }
                            .m_top{
                                margin-top: -50px;
                            }
                            input[type="checkbox"]{
                                width: 30px; /*Desired width*/
                                height: 30px; /*Desired height*/
                                cursor: pointer;
                                -webkit-appearance: none;
                                appearance: none;
                            }
                    </style>
                    </head>
                    <body>
                    <header>
                        <img src="' . base_url('public/assets/image/tra.png') . '" alt="Aqato" height="auto" width="10%">
                        <img src="' . base_url('public/assets/image/attc_logo.png') . '" alt="Aqato" height="70px" width="50%">
                        <div id="tra">PRIVACY NOTICE &
                        APPLICANT DECLARATION</div>
                    </header>

                    <div id="main">
                        <table border="2pc solid black" class="m_top my_df">
                        <tr>
                            <td style="background-color: #96b5e4;padding: 3px;padding-left: 10px;">
                            <b> PRIVACY NOTICE</b>
                            </td>
                        <tr>
                            <td>
                            <b> WHY WE COLLECT YOUR PERSONAL INFORMATION</b><br>
                            As a registered training organisation (RTO), we collect your personal information so we can process and manage your
                            application for a skills assessment under a Trades Recognition Australia program and if applicable in a vocational education
                            and training (VET) qualification with us. Failing to provide the following information prior or at application will delay the
                            commencement of your skills assessment:
                            <ul style="margin: 0px;">
                                <li> Unique Student Identifier </li>
                                <li> Appropriate identification as listed on page 2 </li>
                                <li> A detailed current version of your CV / Resume </li>
                            </ul>
                            <br>
                            <b>HOW WE USE YOUR PERSONAL INFORMATION</b><br>
                            We use your personal information to enable us to undertake your skills assessment in line with our RTO obligations within our
                            Deed with Trades Recognition Australia and if applicable issue you with a VET qualification, and otherwise, as needed, to
                            comply with our obligations as an RTO.<br><br>
                            <b>HOW WE DISCLOSE YOUR PERSONAL INFORMATION</b><br>
                            In instances a qualification is issued we are required by law (under the National Vocational Education and Training Regulator
                            Act 2011 (Cth) (NVETR Act)) to disclose the personal information we collect about you to the National VET Data Collection
                            kept by the National Centre for Vocational Education Research Ltd (NCVER). The NCVER is responsible for collecting,
                            managing, analysing and communicating research and statistics about the Australian VET sector. We are also authorised by
                            law (under the NVETR Act) to disclose your personal information to the relevant state or territory training authority and other
                            government bodies such as Department Education, Skills and Employment<br>
                            <br>
                            <b>HOW THE NCVER ANOTHER BODIES HANDLE YOUR PERSONAL INFORMATION </b><br>
                            The NCVER will collect, hold, use and disclose your personal information in accordance with the law, including the Privacy Act
                            1988 (Cth) (Privacy Act) and the NVETR Act. Your personal information may be used and disclosed by NCVER for purposes that
                            include populating authenticated VET transcripts; administration of VET; facilitation of statistics and research relating to
                            education, including surveys and data linkage; and understanding the VET market.<br>
                            The NCVER is auhorised to disclose information to the Australian Government Department of Education, Skills and
                            Employment (DESE), Commonwealth authorities, State and Territory authorities (other than registered training organisations)
                            that deal with matters relating to VET and VET regulators for the purposes of those bodies, including to enable:
                            <ul style="margin: 0px;">
                            <li> administration of VET, including program administration, regulation, monitoring and evaluation </li>
                            <li>  facilitation of statistics and research relating to education, including surveys and data linkage </li>
                            <li> understanding how the VET market operates, for policy, workforce planning and consumer information. </li>
                            </ul>
            ';

        $html = $html . '
                  The NCVER may also disclose personal information to persons engaged by NCVER to conduct research on NCVER’s behalf.
                  The NCVER does not intend to disclose your personal information to any overseas recipients.
                  For more information about how the NCVER will handle your personal information please refer to the NCVER’s Privacy Policy
                  at <a href="www.ncver.edu.au/privacy">www.ncver.edu.au/privacy.</a><br>
                  If you would like to seek access to or correct your information, in the first instance, please contact your RTO using the contact
                  details listed below.<br>
                  DESE is authorised by law, including the Privacy Act and the NVETR Act, to collect, use and disclose your personal information
                  to fulfil specified functions and activities. For more information about how the DESE will handle your personal information,
                  please refer to the DESE VET Privacy Notice at<a href=" https://www.dese.gov.au/national-vet-data/vet-privacy-notice"> https://www.dese.gov.au/national-vet-data/vet-privacy-notice.</a><br><br>
                  Australian Trade Training College is an approved Skills Assure Supplier with Department of Employment, Small Business and
                  Training and are required to disclose personal information directly to them. Please refer to their Information Privacy Policy at
                  <a href="https://www.publications.qld.gov.au/dataset/desbt-corporate-documents/resource/6ddc87de-ef73-4baf-8ebd-3309da44fc6f">https://www.publications.qld.gov.au/dataset/desbt-corporate-documents/resource/6ddc87de-ef73-4baf-8ebd-3309da44fc6f</a>
                  <br><br>
                  In addition Australian Trade Training College will also disclose information about your training in the following circumstances:
                  <ul style="margin: 0px;">
                    <li> your employer or agent listed on this application form;</li>
                    <li> Registered Training Organisations who request to verify any training you have undertaken with Australian Trade</li>
                    Training College are valid and authentic.
                  </ul><br>
                  <b>SURVEYS</b><br>
                  You may receive a student survey which may be run by a government department or an NCVER employee, agent, third-party
                  contractor or another authorised agency. Please note you may opt out of the survey at the time of being contacted.<br>

                </td>
              </tr>
              </tr>
            </table>

            <hr style="text-align: center;page-break-after: always;" width="100%">

            <table class="m_top">
              <tr>
                <td colspan="3" style="background-color: #96b5e4;padding: 3px;padding-left: 10px;  ">
                  <b> PRIVACY NOTICE (continued) </b>
                </td>
              <tr>
                <td colspan="3">
                  <b>CONTACT INFORMATION</b><br>
                  At any time, you may contact Australian Trade Training College to:
                  <ul style="margin:0px;">
                    <li> request access to your personal information </li>
                    <li> correct your personal information </li>
                    <li> make a complaint about how your personal information has been handled </li>
                    <li> ask a question about this Privacy Notice </li>
                  </ul>
                  <br>
                  You can view Australian Trade Training College Privacy Policy, TRA Applicant Information Handbook at
                  <br>
                  <a href="https://attc.org.au/about-us/policies-and-procedures/">https://attc.org.au/about-us/policies-and-procedures/</a>
                  <br>
                  <br>
                  You can also view the forms and policies with Trades Recognition Australia at
                  <br>
                  <a href="https://www.tradesrecognitionaustralia.gov.au/forms-policy">https://www.tradesrecognitionaustralia.gov.au/forms-policy</a>
                  <br>
                  <br>
                  Phone: 1300 017 199<br>
                  Email: tra@attc.org.au<br>
                  <a href="https://attc.org.au">https://attc.org.au</a>
                  <br>
                  <br>
                </td>
              </tr>
              <tr>
                <td colspan="3" style="background-color: #96b5e4;padding: 3px;padding-left: 10px;  ">
                  <b> APPLICANT DECLARATION</b>
                </td>
              </tr>';
        $html = $html . '
              <tr>
                <td colspan="3">
                  <b>I declare that:</b><br>
                  <ul style="margin:0px;">
                    <li> I declare that the information I have provided to the best of my knowledge is true and correct. </li>
                    <li> I consent to the collection, use and disclosure of my personal information in accordance with the Privacy Notice above. </li>
                    <li> In making this application for a skills assessment, I am aware of the consequences that may arise from providing false, misleading or incomplete
                    information, including the cancellation of my skills assessment. </li>
                    <li> I have received and/or accessed and read the TRA Applicant Information Handbook and understand my rights and responsibilities as an applicant. </li>
                    <li> My decision to complete and submit this application form has been without coercion, </li>
                    <li> I have received and/or accessed the Trades Recognition Australia fee schedule, </li>
                    <li> I have read and I understand the Trades Recognition Australia refund policy, </li>
                    <li> I have been provided with sufficient information on Assessment arrangements, </li>
                    <li> I have read and I consent to the collection, use and disclosure of my personal information (which may include sensitive information) pursuant to the 
                    information detailed, and NCVER policies, procedures and protocols published on NCVER’s website at <a href="www.ncver.edu.au
                ">www.ncver.edu.au 
                    </a>
                    </li>
                  </ul>
                  <br>
                </td>
              </tr>
            
            </table>
         <br>
            <table  class="">
              <tr>
                <td colspan="3" style="background-color: #96b5e4;padding: 3px;padding-left: 10px;  ">
                  <b> APPOINTMENT OF AN AGENT /EMPLOYER </b>(optional)
                </td>
              <tr>
                <td colspan="1" width="30%">
                  <b> AGENT/EMPLOYER COMPANY NAME</b>
                </td>
                <td colspan="2">
                ' . $ag_business_name . '
                </td>
              </tr>
              <tr>
                <td colspan="1" width="30%">
                  <b> AGENT/EMPLOYER REPRESENTATIVE NAME </b>
                </td>
                <td colspan="2">
                ' . $ag_name . '
                </td>
              </tr>
              <tr>
                <td colspan="1" width="30%">
                  <b> CONTACT DETAILS </b>
                </td>
                <td colspan="2" style="  padding: 0px;">
                  <div width="30%" style="margin: 0px; padding:10px; padding-left: 10px; border-bottom: 1px solid;">
                    Email :  ' . $ag_email . '
                  </div>
                  <div width="30%" style="float: left;padding-left: 10px; padding:10px;">
                    Mobile :  ' . $mobile_code . ' ' . $ag_mobile . '
                  </div>
                  <div width="30%" style="margin-left: 50%;padding-left: 10px;padding:10px;">
                    Telephone: ' . $tel_code . ' 
                  </div>
                </td>
              </tr>
              <tr>
                <td colspan="3" style="background-color: #96b5e4;padding: 3px;padding-left: 10px;  ">
                  <b> AUTHORISATION </b>
                </td>
              </tr>
              <tr>
                <td colspan="1" width="30%" style="  text-align: center;  vertical-align: middle;">
                <input type="checkbox" ' . $checked . '/>

                </td>
                <td colspan="2">
                  I wish to have all correspondence directed to my Agent/Employer, including Outcome<br>
                  Letter and/or Qualifications. Further I approve Australian Trade Training College to make<br>
                  direct contact with my Agent or Employer to discuss my application, should the need arise.<br>
                </td>
              </tr>
            
      

              </tr>
              <tr>
              <td colspan="3" style="  background-color: #96b5e4;padding: 10px;padding-left: 10px;">
                <b> By signing this form I confirm I have read and understood both the Privacy Notice and Application Declaration above. </b>
              </td>
            </tr>
            <tr>
              <td style="padding: 20px;  " width="30%">
                <b> Applicant Signature</b>
              </td>
              <td style="padding: 20px;  " width="40%">
              ' . $digital_signing . '
              </td>
              <td style="padding: 20px;  " width="30%">
                Date :  ' . date('d/m/Y') . '
              </td>
            </tr>
            <tr>
              <td colspan="1">
                <b>Applicant Name </b>
              </td>
              <td colspan="2">
                  ' . $p_name . '
              </td>
            </tr>
            </table>
          </div>
        </body>
        </html>';

        // return $html;
        if (!empty($digital_signature_info)) {
            $html = $html . '
                    <table style="font-size: 20px;  margin-top: 120px; padding:50px">
                     
                        <tr>
                            <td style="width: 220px;">
                                Emal send
                            </td>
                            <td>
                              ' . $digital_signature_info['email_send_time'] . '
                            </td>
                        </tr>

                        <tr>
                            <td>
                              Emal Open
                            </td>
                            <td>
                              ' . $digital_signature_info['email_open_time'] . ' &emsp; / &emsp;' . $digital_signature_info['client_ip'] . '
                            </td>
                        </tr>

                        <tr>
                            <td>
                              Signature
                            </td>
                            <td>
                              ' . $digital_signature_info['email_signachr_time']  . ' &emsp; / &emsp; ' . $digital_signature_info['REMOTE_ADDR']  . '
                            </td>
                        </tr>

                        <tr>
                            <td>
                               System Information
                            </td>
                            <td>
                              ' . $digital_signature_info['HTTP_USER_AGENT'] . '
                            </td>
                        </tr>

                    </table>
              ';
        }
        // echo $html;
        // exit;
        // $html = "";

        // -------------main code----------
        require_once "dompdf/autoload.inc.php";
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->loadhtml($html);
        $dompdf->setpaper('A4', 'portrait');
        // $dompdf->set_option("isPhpEnabled", true);
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

        $dompdf->stream('Applicant Declaration.pdf');
    } // funtion close



}
