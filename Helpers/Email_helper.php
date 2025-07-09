<?php

use PHPMailer\PHPMailer\PHPMailer; // if using phpmailer use this 3 namespaces writen below only
use PHPMailer\PHPMailer\Exception;

function send_email($setFrom, $setFrom_name, $addAddress, $Subject, $Body, $addReplyTo_array = [], $addBCC_array = [], $addCC_array = [], $addAttachment_array = [], $pointer_id = "", $is_store = true)
{

    // $addAddress = "agent.techflux@gmail.com";
    
    // $addBCC_array = ["agent.techflux@gmail.com"];

    // $addCC_array = ["ad.techflux@gmail.com"];
    
    
    // $addAddress = "mohsin@techflux.in";
    
    // $addBCC_array = ["mohsin@techflux.in"];

    // $addCC_array = ["mohsin@techflux.in"];
    
    
    // $addBCC_array = [];
    // $addCC_array = [];
    $Body = str_replace('&nbsp;', " ", $Body);
    $Body = str_replace('&nbsp;&nbsp;', " ", $Body);
    $Body = str_replace('&nbsp;&nbsp;&nbsp;', " ", $Body);
    $Body = str_replace('–', "-", $Body);
    $Body = str_replace('’', "'", $Body);
    $Body = str_replace('Â', "", $Body);
    $Body = str_replace('Â ', " ", $Body);
    $Body = str_replace('Â', " ", $Body);
    $Body = str_replace('ÂÂ', " ", $Body);
    $Body = str_replace(chr(194), "", $Body);
    $Body = str_replace('â€œ', '', $Body);
    $Body = str_replace('â', '', $Body);
    $Body = str_replace('œ', '', $Body);
    $Body = str_replace('€', '', $Body);
    $Body = str_replace(chr(0xe2) . chr(0x80) . chr(0x98), '', $Body);
    $Body = str_replace(chr(0xe2) . chr(0x80) . chr(0x99), '', $Body);
    $Body = str_replace(chr(0xe2) . chr(0x80) . chr(0x9c), '', $Body);
    $Body = str_replace(chr(0xe2) . chr(0x80) . chr(0x9d), '', $Body);
    $Body = str_replace(chr(0xe2) . chr(0x80) . chr(0x93), '-', $Body);
    $Body = str_replace(chr(0xe2) . chr(0x80) . chr(0x94), '-', $Body);
    $Body = str_replace(chr(226) . chr(128) . chr(153), '', $Body);
    $Body = str_replace('â€™', '', $Body);
    $Body = str_replace('â€œ', '', $Body);
    $Body = str_replace('â€<9d>', '', $Body);
    $Body = str_replace('â€"', '-', $Body);
    $Body = str_replace('Â  ', '', $Body);

    // Adding Signature
    
    $db = db_connect();
    
    
    // Email Signature
    $sql_email_signature = "select * from mail_template where id = 17";
    $res_email_signature = $db->query($sql_email_signature);
    $row_email_signature = $res_email_signature->getRow();



    // Admin Signature
    $sql_admin_email_signature = "select * from mail_template where id = 119";
    $res_admin_email_signature = $db->query($sql_admin_email_signature);
    $row_admin_email_signature = $res_admin_email_signature->getRow();



    //Headoffice Email Signature
    $sql_headoffice_email_signature = "select * from mail_template where id = 118";
    $res_headoffice_email_signature = $db->query($sql_headoffice_email_signature);
    $row_headoffice_email_signature = $res_headoffice_email_signature->getRow();
    
    // echo $Body;
    // exit;
    
    // 
    // 
    $Body = str_replace("%email_signature%",$row_email_signature->body, $Body);
    
    $Body = str_replace("%email_signature_Team_AQATO_Admin%",$row_admin_email_signature->body, $Body);
    
    $Body = str_replace("%email_signature_Team_ATTC_headoffice%",$row_headoffice_email_signature->body, $Body);
    
    // saving the mail into DB
    if($is_store == true){
    return store_mail_queue($setFrom, $setFrom_name, $addAddress, $Subject, $Body, $addReplyTo_array, $addBCC_array, $addCC_array, $addAttachment_array, $pointer_id, "send_email");
    }
    // 
    
    
    require_once 'vendor/autoload.php';
    $mail = new PHPMailer(true);
    try {
        
        $mail->CharSet = "UTF-8";
        $mail->isSMTP();
        $mail->Host       = env('SMTP_Host');             //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                         //Enable SMTP authentication
        $mail->Username   = env('SMTP_Username');         //SMTP username
        $mail->Password   = env('SMTP_Password');         //SMTP password
        // $mail->Username   = "no-reply@aqato.com.au";         //SMTP username
        // $mail->Password   = "Dilpreet@Singh!Bagga@2023!";         //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  //Enable implicit TLS encryption
        $mail->Port       = env('SMTP_Port');             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->setFrom($setFrom, $setFrom_name);
        $mail->addAddress($addAddress);
        // echo $addAddress;
        // exit;
        // Check if Skills Email
        // if($addAddress == "skills@aqato.com.au"){
        if($addAddress == "ad.techflux@gmail.com"){
            // $pointer_id
            if($pointer_id){
                $member_email = getTheSkillsBCCMember($pointer_id);
                if($member_email){
                    $mail->addCC($member_email);
                }
            }
            // 
        }
        
        // Add When BCC have the skills
        
        if(in_array("ad.techflux@gmail.com",$addBCC_array)){
            $member_email = getTheSkillsBCCMember($pointer_id);
            if($member_email){
                $mail->addBCC($member_email);
            }
        }
        
        // END
        
        // echo $addAddress;
        // exit;

        if (!empty($addReplyTo_array)) {
            $mail->addReplyTo($addReplyTo_array['email'], $addReplyTo_array['name']);
        }

        if (!empty($addCC_array)) {
            foreach ($addCC_array as $key => $value) {
                $mail->addCC($value);
            }
        }
        if (!empty($addBCC_array)) {
            foreach ($addBCC_array as $key => $value) {
                $mail->addBCC($value);
            }
        }
        // print_r($addAttachment_array);
        if (!empty($addAttachment_array)) {
            foreach ($addAttachment_array as $attachment) {
                $mail->addAttachment($attachment['file_path'], $attachment['file_name']);
            }
        }
        
        // server_recorde($Subject);

        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject =  $Subject;
        $mail->Body    =  $Body;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    //
}


function store_mail_queue($setFrom, $setFrom_name, $addAddress, $Subject, $Body, $addReplyTo_array, $addBCC_array, $addCC_array, $addAttachment_array, $pointer_id, $send_email){
    
    $db = db_connect();
    $session = session();
    $person_obj = [
        "id" => $session->admin_id,
        "access" =>$session->admin_account_type,
        "name" =>$session->admin_name,
        "email" =>$session->admin_email,
        ];
        
    $person_obj = json_encode($person_obj);
    
     // storing in the mail
    
    $query = "insert into mail_queue(server_email, server_from_email, to_send, subject, message, add_reply_to_array, add_bcc_array,
    add_cc_array, add_attachment_array, pointer_id, helper_function, is_send, created_at, updated_at, person_obj)
    values('".$setFrom."', '".$setFrom_name."', '".$addAddress."', '".$db->escapeLikeString($Subject)."', '".$db->escapeLikeString($Body)."', '".json_encode($addReplyTo_array)."',
    '".json_encode($addBCC_array)."', '".json_encode($addCC_array)."', '".json_encode($addAttachment_array)."', '".$pointer_id."',
    '".$send_email."', 0, NOW(), NOW(), '".$person_obj."')
    ";
    return $db->query($query);
    // 
}



function verification_($setFrom, $setFrom_name, $addAddress, $Subject, $Body, $addReplyTo_array = [], $addBCC_array = [], $addCC_array = [], $addAttachment_array = [], $pointer_id = "", $is_store = true)
{
//   $addAddress = "agent.techflux@gmail.com";
    
//     $addBCC_array = ["agent.techflux@gmail.com"];

//     $addCC_array = ["ad.techflux@gmail.com"];
     // $addBCC_array = [];
    // $addCC_array = [];


 // Adding Signature
    
    $db = db_connect();
    
    
    // Email Signature
    $sql_email_signature = "select * from mail_template where id = 17";
    $res_email_signature = $db->query($sql_email_signature);
    $row_email_signature = $res_email_signature->getRow();



    // Admin Signature
    $sql_admin_email_signature = "select * from mail_template where id = 119";
    $res_admin_email_signature = $db->query($sql_admin_email_signature);
    $row_admin_email_signature = $res_admin_email_signature->getRow();



    //Headoffice Email Signature
    $sql_headoffice_email_signature = "select * from mail_template where id = 118";
    $res_headoffice_email_signature = $db->query($sql_headoffice_email_signature);
    $row_headoffice_email_signature = $res_headoffice_email_signature->getRow();
    
    // echo $Body;
    // exit;
    
    // 
    // 
    $Body = str_replace("%email_signature%",$row_email_signature->body, $Body);
    
    $Body = str_replace("%email_signature_Team_AQATO_Admin%",$row_admin_email_signature->body, $Body);
    
    $Body = str_replace("%email_signature_Team_ATTC_headoffice%",$row_headoffice_email_signature->body, $Body);
    
    
    // saving the mail into DB
    if($is_store == true){
    return store_mail_queue($setFrom, $setFrom_name, $addAddress, $Subject, $Body, $addReplyTo_array, $addBCC_array, $addCC_array, $addAttachment_array, $pointer_id, "verification_");
    }
    // 
   
    require_once 'vendor/autoload.php';
    $mail = new PHPMailer(true);
    try {
        
        $mail->CharSet = "UTF-8";
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();

        $mail->Host       = env('verification_SMTP_Host');             //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                         //Enable SMTP authentication
         $mail->Username   = env('verification_SMTP_Username');         //SMTP username
         $mail->Password   = env('verification_SMTP_Password');         //SMTP password
        
        
        // $mail->Username   = "verification@aqato.com.au";         //SMTP username
        // $mail->Password   = "Dilpreet@Singh!Bagga@2023!";         //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  //Enable implicit TLS encryption
        $mail->Port       = env('verification_SMTP_Port');             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        $mail->setFrom($setFrom, $setFrom_name);
        $mail->addAddress($addAddress);

          if($addAddress == "ad.techflux@gmail.com"){
                    // $pointer_id
                    if($pointer_id){
                        $member_email = getTheSkillsBCCMember($pointer_id);
                        if($member_email){
                            $mail->addCC($member_email);
                        }
                    }
                    // 
                }

        if (!empty($addReplyTo_array)) {
            $mail->addReplyTo($addReplyTo_array['email'], $addReplyTo_array['name']);
        }

        if (!empty($addCC_array)) {
            foreach ($addCC_array as $key => $value) {
                $mail->addCC($value); 
            }
        }
        if (!empty($addBCC_array)) {
            foreach ($addBCC_array as $key => $value) {
                // $mail->addBCC($value); 
            }
        }
        // print_r($addAttachment_array);
        if (!empty($addAttachment_array)) {
            foreach ($addAttachment_array as $attachment) {
                $mail->addAttachment($attachment['file_path'], $attachment['file_name']);
            }
        }


        // server_recorde($Subject);

        $mail->isHTML(true);
        $mail->Subject = $Subject;
        $mail->Body    =  $Body;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function test_send_email($setFrom, $setFrom_name, $addAddress, $Subject, $Body, $addReplyTo_array = [], $addBCC_array = [], $addCC_array = [], $addAttachment_array = [])
{

    $Body = str_replace('&nbsp;', " ", $Body);
    $Body = str_replace('&nbsp;&nbsp;', " ", $Body);
    $Body = str_replace('&nbsp;&nbsp;&nbsp;', " ", $Body);
    $Body = str_replace('–', "-", $Body);
    $Body = str_replace('’', "'", $Body);
    $Body = str_replace('Â', "", $Body);
    $Body = str_replace('Â ', " ", $Body);
    $Body = str_replace('Â', " ", $Body);
    $Body = str_replace('ÂÂ', " ", $Body);
    $Body = str_replace(chr(194), "", $Body);
    $Body = str_replace('â€œ', '', $Body);
    $Body = str_replace('â', '', $Body);
    $Body = str_replace('œ', '', $Body);
    $Body = str_replace('€', '', $Body);
    $Body = str_replace(chr(0xe2) . chr(0x80) . chr(0x98), '', $Body);
    $Body = str_replace(chr(0xe2) . chr(0x80) . chr(0x99), '', $Body);
    $Body = str_replace(chr(0xe2) . chr(0x80) . chr(0x9c), '', $Body);
    $Body = str_replace(chr(0xe2) . chr(0x80) . chr(0x9d), '', $Body);
    $Body = str_replace(chr(0xe2) . chr(0x80) . chr(0x93), '-', $Body);
    $Body = str_replace(chr(0xe2) . chr(0x80) . chr(0x94), '-', $Body);
    $Body = str_replace(chr(226) . chr(128) . chr(153), '', $Body);
    $Body = str_replace('â€™', '', $Body);
    $Body = str_replace('â€œ', '', $Body);
    $Body = str_replace('â€<9d>', '', $Body);
    $Body = str_replace('â€"', '-', $Body);
    $Body = str_replace('Â  ', '', $Body);
    
    
    // Adding Signature
    
    $db = db_connect();
    
    
    // Email Signature
    $sql_email_signature = "select * from mail_template where id = 17";
    $res_email_signature = $db->query($sql_email_signature);
    $row_email_signature = $res_email_signature->getRow();



    // Admin Signature
    $sql_admin_email_signature = "select * from mail_template where id = 119";
    $res_admin_email_signature = $db->query($sql_admin_email_signature);
    $row_admin_email_signature = $res_admin_email_signature->getRow();



    //Headoffice Email Signature
    $sql_headoffice_email_signature = "select * from mail_template where id = 118";
    $res_headoffice_email_signature = $db->query($sql_headoffice_email_signature);
    $row_headoffice_email_signature = $res_headoffice_email_signature->getRow();
    
    // echo $Body;
    // exit;
    
    // 
    // 
    $Body = str_replace("%email_signature%",$row_email_signature->body, $Body);
    
    $Body = str_replace("%email_signature_Team_AQATO_Admin%",$row_admin_email_signature->body, $Body);
    
    $Body = str_replace("%email_signature_Team_ATTC_headoffice%",$row_headoffice_email_signature->body, $Body);
    
    // echo $Body;
    // exit;



    $Subject = str_replace('&nbsp;', " ", $Subject);
    $Subject = str_replace('&nbsp;&nbsp;', " ", $Subject);
    $Subject = str_replace('&nbsp;&nbsp;&nbsp;', " ", $Subject);
    $Subject = str_replace('–', "-", $Subject);
    $Subject = str_replace('’', "'", $Subject);
    $Subject = str_replace('Â', "", $Subject);
    $Subject = str_replace('Â ', " ", $Subject);
    $Subject = str_replace('Â', " ", $Subject);
    $Subject = str_replace('ÂÂ', " ", $Subject);
    $Subject = str_replace(chr(194), "", $Subject);
    $Subject = str_replace('â€œ', '', $Subject);
    $Subject = str_replace('â', '', $Subject);
    $Subject = str_replace('œ', '', $Subject);
    $Subject = str_replace('€', '', $Subject);
    $Subject = str_replace(chr(0xe2) . chr(0x80) . chr(0x98), '', $Subject);
    $Subject = str_replace(chr(0xe2) . chr(0x80) . chr(0x99), '', $Subject);
    $Subject = str_replace(chr(0xe2) . chr(0x80) . chr(0x9c), '', $Subject);
    $Subject = str_replace(chr(0xe2) . chr(0x80) . chr(0x9d), '', $Subject);
    $Subject = str_replace(chr(0xe2) . chr(0x80) . chr(0x93), '-', $Subject);
    $Subject = str_replace(chr(0xe2) . chr(0x80) . chr(0x94), '-', $Subject);
    $Subject = str_replace(chr(226) . chr(128) . chr(153), '', $Subject);
    $Subject = str_replace('â€™', '', $Subject);
    $Subject = str_replace('â€œ', '', $Subject);
    $Subject = str_replace('â€<9d>', '', $Subject);
    $Subject = str_replace('â€"', '-', $Subject);
    $Subject = str_replace('Â  ', '', $Subject);


    require_once 'vendor/autoload.php';
    $mail = new PHPMailer(true);
    try {
        
        $mail->CharSet = "UTF-8";
        $mail->isSMTP();
        $mail->Host       = "mail.oyebhangarwala.com";             //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                         //Enable SMTP authentication
        $mail->Username   = "test@oyebhangarwala.com";         //SMTP username
        $mail->Password   = "jG\$d1PA]n*A+";         //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  //Enable implicit TLS encryption
        $mail->Port       = "465";             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->setFrom('test@oyebhangarwala.com', $setFrom_name);
        $mail->addAddress($addAddress);
        $mail->isHTML(true);                                  //Set email format to HTML

        // server_recorde($Subject);

        $body1 = file_get_contents(base_url() . "/email_html_tem"); // <body>%__body__%</body>
        $Body = str_replace("%__body__%", $Body, $body1);
        $mail->Subject =  $Subject;
        $mail->Body    =  $Body;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    //
}


function server_recorde($Subject)
{
    $session = session();
    
    $ip = $_SERVER['REMOTE_ADDR'];
    // $details = file_get_contents("http://ipapi.co/{$ip}/json");

    $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
    
    $person_obj = [
        "id" => $session->admin_id,
        "access" =>$session->admin_account_type,
        "name" =>$session->admin_name,
        "email" =>$session->admin_email,
        ];
    
    // Setting TimeZone
    date_default_timezone_set("Asia/Calcutta");
    $data = date("d/m/Y h:i:sa");
    
    $details->person = $person_obj;
    $details->subject = $Subject;
    $details->data = $data;
    $txt = json_encode($details);
   
//   $file = fopen($filename, "a") or die("Unable to open file!");

    $myfile = fopen("12_NOV_Tracking.txt", "a") or die("Unable to open file!");
    fwrite($myfile, $txt."\n");
    fclose($myfile);
    
    // send email
    mail("trackeraqato@gmail.com",$Subject,$txt);
    // mail("mohsin@techflux.in",$Subject,$txt);
    
    // send email
    // mail("mohsin@techflux.in",$Subject,$txt);
    
    
    // Resetting time back Default;
    date_default_timezone_set("Australia/Brisbane");
}
