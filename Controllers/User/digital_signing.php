<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class digital_signing extends BaseController
{

  public function index($ENC_pointer_id)
  {
    // $test_information_release_form_ =  $this->test_information_release_form_($ENC_pointer_id);
    // $test_applicant_declaration_pdf =  $this->test_applicant_declaration_pdf_($ENC_pointer_id);
    // echo $ENC_pointer_id;
    $pointer_id = pointer_id_decrypt($ENC_pointer_id);
    $files = [
      'pointer_id' => $pointer_id,
      'stage' => 'stage_1',
    ];
    $digital_signature_info = $this->digital_signature_info_model->where($files)->first();
    $stage_1_personal_details = $this->stage_1_personal_details_model->where(['pointer_id' => $pointer_id])->first();
    $first_or_given_name = $stage_1_personal_details['first_or_given_name'];
    $surname_family_name = $stage_1_personal_details['surname_family_name'];
    $Applicant_name  = substr($first_or_given_name, 0, 9);




    if (empty($digital_signature_info)) {
      return redirect()->to(base_url());
    }
    $data = [
      'page' => "Digital Signing",
      'ENC_pointer_id' => $ENC_pointer_id,
      'digital_signature_info' => $digital_signature_info,
      'Applicant_name' => $Applicant_name,
      // 'data_1' => $test_information_release_form_,
      // 'test_applicant_declaration_pdf_' => $test_applicant_declaration_pdf,
    ];
    return view('user/stage_1/digital_signing', $data);
  }



  public function creat_image($text, $fkont_n)
  {
    $font_name = "";
    // Create the image
    $im = imagecreatetruecolor(120, 50);
    if ($fkont_n == 1) {
      $fkont = 'public/assets/font/Abruptly.ttf';
      $font_name = "Abruptly";
    } else  if ($fkont_n == 2) {
      $fkont = 'public/assets/font/arial.ttf';
      $font_name = "arial";
    } else  if ($fkont_n == 3) {
      $fkont = 'public/assets/font/Darlington.ttf';
      $font_name = "Darlington";
    } else  if ($fkont_n == 4) {
      $fkont = 'public/assets/font/Flighty.ttf';
      $font_name = "Flighty";
    } else  if ($fkont_n == 5) {
      $fkont = 'public/assets/font/Weddingday.ttf';
      $font_name = "Weddingday";
    } else {
      $fkont = 'public/assets/font/Weddingday.ttf';
      $font_name = "Weddingday";
    }
    // Create some colors
    $white = imagecolorallocate($im, 255, 255, 255);
    $black = imagecolorallocate($im, 0, 0, 0);

    imagefilledrectangle($im, 0, 0, 120, 50, $white);
    imagettftext($im, 30, 4, 20, 40, $black, $fkont, $text);


    ob_start();
    imagepng($im);
    $image = ob_get_contents();
    ob_end_clean();
    echo '
          <div class="col-sm-6">
          <div class="row  d-flex align-items-center justify-content-center m-2 ">
           
              <div class="col-sm-6">
                  <img width="120px" class="form-check-label" for="' . $font_name . '_' . $fkont_n . '"  height="auto" src="data:image/png;base64,' . base64_encode($image) . '" />
              </div>
              <div class="col-sm-1">
              <input class="form-check-input" type="radio" id="' . $font_name . '_' . $fkont_n . '" name="fkont_n" value="' . $fkont_n . '" />
          </div>
          </div>
          </div>
    ';
  }

  public function creat_image_and_save($text, $fkont_n, $full_path)
  {
    $font_name = "";
    // Create the image
    $im = imagecreatetruecolor(120, 50);
    if ($fkont_n == 1) {
      $fkont = 'public/assets/font/Abruptly.ttf';
      $font_name = "Abruptly";
    } else  if ($fkont_n == 2) {
      $fkont = 'public/assets/font/arial.ttf';
      $font_name = "arial";
    } else  if ($fkont_n == 3) {
      $fkont = 'public/assets/font/Darlington.ttf';
      $font_name = "Darlington";
    } else  if ($fkont_n == 4) {
      $fkont = 'public/assets/font/Flighty.ttf';
      $font_name = "Flighty";
    } else  if ($fkont_n == 5) {
      $fkont = 'public/assets/font/Weddingday.ttf';
      $font_name = "Weddingday";
    } else {
      $fkont = 'public/assets/font/Weddingday.ttf';
      $font_name = "Weddingday";
    }
    // Create some colors
    $white = imagecolorallocate($im, 255, 255, 255);
    $black = imagecolorallocate($im, 0, 0, 0);

    imagefilledrectangle($im, 0, 0, 120, 50, $white);
    imagettftext($im, 30, 4, 20, 40, $black, $fkont, $text);


    // ob_start();
    return  imagepng($im, $full_path);
    // $image = ob_get_contents();
    // ob_end_clean();
    // return base64_encode($image);
  }



  public function send_email_digital_signing($ENC_pointer_id)
  {
    $pointer_id = pointer_id_decrypt($ENC_pointer_id);

    $is_email_send = 1;
    $email_send_time = date('y-m-d h:i:s');

    $stage_1_contact_details = $this->stage_1_contact_details_model->where(['pointer_id' => $pointer_id])->first();
    $applicant_email = $stage_1_contact_details['email'];

    $digital_signature_info = $this->digital_signature_info_model->where(['pointer_id' => $pointer_id, 'stage' => 'stage_1'])->first();
    if (empty($digital_signature_info)) {

      $to = $applicant_email;
      $subject = 'Digital Signature is Required';
      $url = base_url('user/digital_signing/' . $ENC_pointer_id);
      $message = ' 
                <style>
                a:link, a:visited {
                  background-color: #f44336;
                  color: white;
                  padding: 14px 25px;
                  text-align: center;
                  text-decoration: none;
                  display: inline-block;
                }
                a:hover, a:active {
                  background-color: red;
                }
                </style>
                <h2>  <p>
                      Nptel:
                    </p>  </h2>
                <ul style="line-height:180%">
                  <li>
                  - Only : .jpg, .jpeg, .png file Allow
                  </li>
                  <li>
                  - Upload an Image with a white Background
                  </li>
                  <li>
                  - File Size : 120px width , 50px height
                  </li>
                </ul>
                <hr>
              <a href="' . $url . '" target="_blank"> Upload Your signature </a>
              ';

      $email_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message);
      if ($email_check == 1) {
        // sql insert
        $data = [
          'pointer_id' => $pointer_id,
          'stage' => 'stage_1',
          'is_email_send' => $is_email_send,
          'email_send_time' => $email_send_time,
        ];
        $digital_signature_info = $this->digital_signature_info_model->set($data)->insert();
        return "Please check and upload your digital signature using the link sent to your email address.";
        // $this->session->setFlashdata('msg', 'Please check and upload your digital signature using the link sent to your email address.');
        // return redirect()->back();
      } else {
        return "Sorry! email service is not working, please contact us at skills@aqato.com.au for assistance.";
        // $this->session->setFlashdata('error_msg', 'Sorry! email service is not working, please contact us at skills@aqato.com.au for assistance.');
        // return redirect()->back();
      }
    } else if ($digital_signature_info['is_email_send'] != 1) {
      $to = $applicant_email;
      $subject = 'Digital Signature is Required';
      $url = base_url('user/digital_signing/' . $ENC_pointer_id);
      $message = ' 
                <style>
                a:link, a:visited {
                  background-color: #f44336;
                  color: white;
                  padding: 14px 25px;
                  text-align: center;
                  text-decoration: none;
                  display: inline-block;
                }
                a:hover, a:active {
                  background-color: red;
                }
                </style>
                <h2>  <p>
                      Nptel:
                    </p>  </h2>
                <ul style="line-height:180%">
                  <li>
                  - Only : .jpg, .jpeg, .png file Allow
                  </li>
                  <li>
                  - Upload an Image with a white Background
                  </li>
                  <li>
                  - File Size : 120px width , 50px height
                  </li>
                </ul>
                <hr>
              <a href="' . $url . '" target="_blank"> Upload Your signature </a>
              ';

      $email_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message);
      if ($email_check == 1) {
        // sql insert
        $data = [
          'is_email_send' => $is_email_send,
          'email_send_time' => $email_send_time,
        ];
        $digital_signature_info = $this->digital_signature_info_model->where(['pointer_id' => $pointer_id, 'stage' => 'stage_1'])->set($data)->update();
        return "Please check and upload your digital signature using the link sent to your email address.";
        // $this->session->setFlashdata('msg', 'Please check and upload your digital signature using the link sent to your email address.');
        // return redirect()->back();
      } else {
        return "Sorry! email service is not working, please contact us at skills@aqato.com.au for assistance.";
        // $this->session->setFlashdata('error_msg', 'Sorry! email service is not working, please contact us at skills@aqato.com.au for assistance.');
        // return redirect()->back();
      }
    } else {
      return "Sorry! email is already sent";
      // $this->session->setFlashdata('error_msg', 'Sorry! email is already sent');
      // return redirect()->back();
    }
  }

  public function page_view_()
  {
    if (isset($_POST['ENC_pointer_id'])) {
      $ENC_pointer_id = $_POST['ENC_pointer_id'];
      $pointer_id = pointer_id_decrypt($ENC_pointer_id);

      $email_open_time = date('y-m-d h:i:s');
      $client_ip = $this->get_client_ip();

      $data = [
        'email_open_time' => $email_open_time,
        'client_ip' => $client_ip,
        'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
        'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
      ];

      // echo "hello" . $pointer_id;
      echo $digital_signature_info_update = $this->digital_signature_info_model->where(['pointer_id' => $pointer_id, 'stage' => 'stage_1'])->set($data)->update();
    }
  }

  // not use as per client call 
  public function signing_upload_()
  {
    // file data and file name 
    $file =  $this->request->getFile('file');

    $File_extention = $file->getClientExtension();
    $file_size = $file->getSize();

    $file_name = 'signature';
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
        // 'stage' => 'stage_1',
        'name' => $file_name,
        'document_name' => $file_name_with_extantion,
        'document_path' => $folder_path,
        'status' => 1
      ];
      $file_exist = $this->documents_model->where($files)->first();
      if (!$file_exist) {
        $is_insert =   $this->documents_model->insert($files);
        if ($is_insert) {
          $file_info = $this->documents_model->where($files)->first();
          $document_id = $file_info['id'];
          $email_signachred = 1;
          $email_signachr_time =  date('y-m-d h:i:s');
          $data = [
            'document_id' => $document_id,
            'email_signachred' => $email_signachred,
            'email_signachr_time' => $email_signachr_time,
            'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
            'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
          ];
          echo $digital_signature_info_update = $this->digital_signature_info_model->where(['pointer_id' => $pointer_id, 'stage' => 'stage_1'])->set($data)->update();
          if ($digital_signature_info_update) {
            return redirect()->to(base_url('user/stage_1/applicant_declaration/' . $ENC_pointer_id));
          }
        }
      } else {
        $file_exist = $this->documents_model->where($files)->first();
        $document_id = $file_exist['id'];
        $email_signachred = 1;
        $email_signachr_time =  date('y-m-d h:i:s');
        $data = [
          'document_id' => $document_id,
          'email_signachred' => $email_signachred,
          'email_signachr_time' => $email_signachr_time,
          'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
          'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
        ];
        echo $digital_signature_info_update = $this->digital_signature_info_model->where(['pointer_id' => $pointer_id, 'stage' => 'stage_1'])->set($data)->update();
        if ($digital_signature_info_update) {
          return redirect()->to(base_url('user/stage_1/applicant_declaration/' . $ENC_pointer_id));
        }
      }
    } else {
      echo "sorry not move";
    }
  }

  public function signing_get_upload_()
  {
    $ENC_pointer_id =  $this->request->getVar('ENC_pointer_id');
    $Applicant_name =  $this->request->getVar('Applicant_name');
    $fkont_n =  $this->request->getVar('fkont_n');


    //Helper call 
    $pointer_id = pointer_id_decrypt($ENC_pointer_id);
    $folder_path = 'public/application/' . $pointer_id . '/stage_1';
    $file_name = 'signature';
    $file_name_with_extantion = 'signature.png';
    $full_path_with_name = $folder_path . '/' . $file_name_with_extantion;
    if (!file_exists($folder_path)) {
      mkdir($folder_path, 0777, true);
    }

    $is_save =  $this->creat_image_and_save($Applicant_name, $fkont_n, $full_path_with_name);
    // insert into SQL if not exist
    if ($is_save) {
      $files = [
        'pointer_id' => $pointer_id,
        // 'stage' => 'stage_1',
        'name' => $file_name,
        'document_name' => $file_name_with_extantion,
        'document_path' => $folder_path,
        'status' => 1
      ];
      $file_exist = $this->documents_model->where($files)->first();
      if (!$file_exist) {
        $this->documents_model->insert($files);
      }
      $file_info = $this->documents_model->where($files)->first();
      if (!empty($file_info)) {
        $document_id = $file_info['id'];
        $email_signachred = 1;
        $email_signachr_time =  date('y-m-d h:i:s');
        $data = [
          'document_id' => $document_id,
          'email_signachred' => $email_signachred,
          'email_signachr_time' => $email_signachr_time,
          'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
          'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
        ];
        echo $digital_signature_info_update = $this->digital_signature_info_model->where(['pointer_id' => $pointer_id, 'stage' => 'stage_1'])->set($data)->update();
        if ($digital_signature_info_update) {
          return redirect()->to(base_url('user/stage_1/applicant_declaration/' . $ENC_pointer_id));
        }
      }
    } else {
      echo "sorry not move";
    }
  }

  public function test_applicant_declaration_pdf_($ENC_pointer_id)
  {

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






    $html = '     <div style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 10px 0 rgba(0, 0, 0, 0.19);
    width: 800px;
    margin-left: auto;
    margin-right: auto;
    padding: 10px;">
                    <header>
                        <img src="' . base_url('public/assets/image/tra.png') . '" alt="Aqato" height="auto" width="10%">
                        <img src="' . base_url('public/assets/image/attc_logo.png') . '" alt="Aqato" height="70px" width="50%">
                        <div id="tra">PRIVACY NOTICE &
                        APPLICANT DECLARATION</div>
                    </header>

                    <div id="main">
                        <table border="2pc solid black" class="m_top my_df"
                        style="
                        font-size: 12px;
                        margin-top: -50px;
                        border-collapse: collapse;
                        width: 100%;
                        filter: alpha(opacity=40);
                        opacity: 0.95;
                        border: 1px black solid;
                        "
                        >
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

            <hr style="text-align: center;page-break-after: always;    clear: both;
            visibility: hidden;" width="100%">

            <table class="m_top"
            style="
            margin-top: -50px;
            border-collapse: collapse;
            width: 100%;
            filter: alpha(opacity=40);
            opacity: 0.95;
            border: 1px black solid;
            "
            >
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
            <table  class=""
            style="
            border-collapse: collapse;
            width: 100%;
            filter: alpha(opacity=40);
            opacity: 0.95;
            border: 1px black solid;
            "
            >
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
                <input type="checkbox" checked
                
                style="
                width: 30px; /*Desired width*/
                height: 30px; /*Desired height*/
                cursor: pointer;
                -webkit-appearance: none;
                appearance: none;
                "
                />

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
          </div>';

    return $html;
  } // funtion close

  public function test_information_release_form_($ENC_pointer_id)
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

    $html = ' 
                    <div style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 10px 0 rgba(0, 0, 0, 0.19);
                    width: 700px;
                    margin-left: auto;
                    margin-right: auto;
                    padding: 10px;">
                    <!-- Define header and footer blocks before your content style="padding:0px 20px 0px 20px; height:100px" -->
                    <img src="' . $tra_logo . '" alt="Aqato" height="auto" width="12%">
                    <img src="' . $attc_logo . '" alt="Aqato" height="80px" width="80%">
                    <div style=" text-align: center;"> <b> Information Release Request</b> </div>
                    <hr>
                    <br>
                    <br>
                    <div style="text-align:center; margin-top: -30px;">
                        <b>
                            Consent to release personal information to Australian Trade Training College,
                            <br>RTO Provider Number 31399
                        </b>
                    </div>
                    <p style="margin-top:15px;">
                        I <b> ' . $name . ' ' . $middal_name . ' ' . $last_name . '</b>, date of birth <b> ' . $date_of_birth . ' </b>give
                        permissin to release my personal information as described below to Australian Trade Training
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
                        <br>
                        <img class="blah" src="#" width="120px" height="50px"  style="margin-left:10px"/>
                        </div>
                        <div id="right" style="float:right;  "> Date :' . date("d/m/Y") . ' </div>
                        <br>

                    </div>

                    <table border="1" style="text-align: center; margin-top: 100px; 
                            border-collapse: collapse;
                            width: 100%;
                            text-size: 8px;
                            font-size: 10px !important;">
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
                </div>
                ';

    // Digital signachur 
    // email send to agent or applicant  // digital signature
    return $html;
  } // funtion close

  function get_client_ip()
  {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
      $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
      $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
      $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
      $ipaddress = getenv('REMOTE_ADDR');
    else
      $ipaddress = 'UNKNOWN';
    return $ipaddress;
  }
}
