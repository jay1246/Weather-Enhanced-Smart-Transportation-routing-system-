<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use stdClass;

use DateTimeZone;
use DateTime;

class chat_system extends BaseController
{
function chat_system()
{
 //   print_r($_POST);
    //die;
    //$this->chat_system
    $chat = $this->request->getVar('chat');
    $reply_id = $this->request->getVar('reply_id');
    $reply_msg = $this->request->getVar('reply_msg_update');
    $admin_id = $this->request->getVar('admin_id');
    $reply_user_name = $this->request->getVar('reply_user_name');
    $documents_ids_string = $this->request->getPost('docs_ids');
    $documents_ids = json_decode($documents_ids_string, true);
    $reply_documets = $this->request->getVar('reply_documets');
    $reply_documets_path = $this->request->getVar('reply_documets_path');

    $admin_ac = $this->admin_account_model
        ->where('id', $admin_id)
        ->get()
        ->getRow();
    if ($admin_ac->id == 1 || $admin_ac->id == 2) {
        $user_name = $admin_ac->first_name;
    } else {
        $user_name = $admin_ac->first_name . $admin_ac->last_name;
    }
    $reply_color = $this->request->getVar('reply_color');
    $color = $admin_ac->color;
    $profileimg_path = $admin_ac->profileimg_path;
    // print_r($documents_ids);

    $lastInsertedIds_afterinsert[] = "";
    $lastInsertedIds_data[] = "";
    $last_message_data[] = "";
    $last_id_message_id_message="";
    $json_response_all=[];
 
 //when message is not empty
   if (!empty($chat)) {
        $insert_data = [
            'message' => $chat,
            'user_id' => $admin_id,
            'user_name' => $user_name,
            'reply_id' => $reply_id,
            'reply_msg' => $reply_msg,
            'reply_user_name' => $reply_user_name,
            'reply_color' => $reply_color,
            'color' => $color,
            'profileimg_path' => $profileimg_path,
            'reply_documents'=>$reply_documets,
            'reply_documents_path' =>$reply_documets_path,        
            'created_at' => date('Y-m-d-H-i'),
            'updated_at' => date('Y-m-d-H-i'),
        ];
        $insert = $this->chat_system->insert($insert_data);
        $last_id_message_id_message = $this->chat_system->insertID();
        // $lastQuery = $this->chat_system->getLastQuery();
        if ($insert) {
            //$data['insert']=$admin_ac;
            $update = $this->admin_account_model
                ->where('id !=', $admin_id)
                ->set('notification', 'notification+1', false)
                ->update();

             $data_message = ['message' => true];
             $json_response_all[] = $data_message;
            //$json_response_all=array_push($data);
            //array_push($json_response_all,$data);
            //echo $jsonResponse = json_encode($data);
        }
    }
 
//  echo $last_id_message_id_message;
    
    if(is_array($documents_ids) && $last_id_message_id_message) {
        $first_id_data = $documents_ids[0];
       // echo $first_id_data;
        array_shift($documents_ids);   
        //for update record with message data
        $first_chat_docs = $this->chats_documents
            ->where('id', $first_id_data)
            ->first();
        $update_data = [
            'documents' => $first_chat_docs['documents'],
            'documents_path' => $first_chat_docs['documents_path'],
        ];
        $update = $this->chat_system
            ->where('id', $last_id_message_id_message)
            ->set($update_data)
            ->update();
            $data_docs = ['documents' => true];
            $json_response_all[] = $data_docs;
             //array_push($json_response_all,$data);
             //echo $jsonResponse = json_encode($data);
        // $first_notes_docs_updated = $this->chat_system
        //     ->where('id', $last_id_message_id_message)
        //     ->first();
        // $last_message_data = $first_notes_docs_updated;
    }

  //when insert documents
    if (!empty($documents_ids)) {
        
        foreach ($documents_ids as $document_id) {
            $data_notes_docs = $this->chats_documents
                ->where('id', $document_id)
                ->first();
            $data_docs = [
                'message' => '',
                'documents' => $data_notes_docs['documents'],
                'documents_path' => $data_notes_docs['documents_path'],
                'user_id' => $admin_id,
                'document_id' => $document_id,
                'user_name' => $user_name,
                'color' => $color,
                'reply_id' => $reply_id,
                'reply_msg' => $reply_msg,
                'profileimg_path' => $profileimg_path,
                'reply_documents'=>$reply_documets,
                'reply_user_name'=>$reply_user_name,
                'reply_documents_path' =>$reply_documets_path,
                //'reply_admin_id'=>$reply_admin_id,
                'reply_color' => $reply_color,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $insert_docs = $this->chat_system->insert($data_docs);
             $lastQuery = $this->chat_system->getLastQuery();
           //  echo $lastQuery;
            $last_id_message_id = $this->chat_system->insertID();
            $lastInsertedIds_afterinsert[] = $last_id_message_id;
           
        }
         $data = ['documents' => true];
         $json_response_all[] = $data;
         //array_push($json_response_all,$data);
         
    }    
    //print_r($json_response_all);
    echo $jsonResponse = json_encode($json_response_all);
    
}
function chat_system_fetch(){
    
$offset_ = $this->request->getPost("userTimezone");
$record_fetch_cnt = $this->request->getPost("record_fetch");
$offset_record = $this->request->getPost("offset_record");
$single_record = $this->request->getPost("single_record");
$admin_id=$this->request->getPost("admin_id");
$admin_ac = $this->admin_account_model->where('id', $admin_id)->get()->getRow();
if($record_fetch_cnt == 0){
    $record_fetch=($admin_ac->notification > 10) ? $admin_ac->notification : 10;
}else{
    $record_fetch=$record_fetch_cnt;
    
}
$timezone = new DateTimeZone($offset_);
$date = new DateTime('now', $timezone);
//echo 'Current time in ' . $offset_ . ': ' . $date->format('Y-m-d H:i:s');
$data = $this->chat_system->limit($record_fetch, $offset_record)->orderBy('id', 'DESC')->find();
if(isset($single_record)){
    $data = $this->chat_system->limit(1)->orderBy('id', 'DESC')->find();
}

// echo $this->chat_system->getLastQuery();
// exit;
$json = [];
$last_data=null;
//$item=['label']="";
foreach ($data as $key => $item) {
    $createdDate = new DateTime($item['created_at']);
    $createdDate->setTimezone($timezone);
    $new_date = $createdDate->format('Y-m-d');
    $new_date_time=$createdDate->format('Y-m-d H:i:s');
    $item['created_at'] = $new_date_time;
    //for give check labels today and tomorrow
    $currentDate = new DateTime('now', $timezone);
    $currentDateFormatted = $currentDate->format('Y-m-d');
    $interval = $createdDate->diff($currentDate);
    $daysDifference = $interval->days;
    
    
    // 
    
    $chat_date_temp = strtotime($new_date);
    $todays_date = strtotime($currentDateFormatted);  // sempal
    // $todays_date = strtotime('2023-02-16');  // sempal
    $timeleft = $todays_date - $chat_date_temp;
    $daysDifference = round((($timeleft / 86400)));
    
    if ($daysDifference == 0) {
         $item['date_label']="Today";
    } elseif ($daysDifference == 1) {
        $item['date_label']="Yesterday";
    } else {
        $item['date_label']=$createdDate->format('M j Y');
    }
    
    array_push($json, $item);
}

$last_data = end($json);

$last_id = '';
if ($last_data !== null && is_array($last_data)) {
    $last_id = isset($last_data['id']) ? $last_data['id'] - 1 : '';
} else {
    // Handle the case where $last_data is not an array or is null
}

//--------

$data_last = $this->chat_system->where('id',$last_id)->first();
//print_r($data_last);

if($data_last !== null){
$data_last_created_at =new DateTime($data_last['created_at']); 
$data_last_created_at->setTimezone($timezone);
$new_date = $data_last_created_at->format('Y-m-d');
$data_last_created_at_format=$data_last_created_at->format('M j Y');
//$data_last_created_at_format;
  //--------
    $currentDate = new DateTime('now', $timezone);
   // $currentDate = new DateTime('now');
    $currentDateFormatted = $currentDate->format('Y-m-d');
    $interval = $data_last_created_at->diff($currentDate);
    $daysDifference = $interval->days;
    
    
    
    $chat_date_temp = strtotime($new_date);
    $todays_date = strtotime($currentDateFormatted);  // sempal
    // $todays_date = strtotime('2023-02-16');  // sempal
    $timeleft = $todays_date - $chat_date_temp;
    $daysDifference = round((($timeleft / 86400)));
    

  if($daysDifference == 0) {
         $data_last_created_at_format="Today";
    } elseif ($daysDifference ==1) {
        $data_last_created_at_format="Yesterday";
    } else {
       $data_last_created_at_format=$data_last_created_at_format;
    }
//echo $data_last_created_at_format;
$modified_json = [];
foreach($json as $json_){
    //echo $json_["date_label"]."-->".$data_last_created_at_format;
    if($json_["date_label"] === $data_last_created_at_format){
        $json_['date_label']="";
        //echo 'matched';
    }else{
       //echo "not match";
    }
    //array_push($json, $json_);
    //print_r($json_);
    $modified_json[] = $json_;
}


//print_r($modified_json);


//echo $last_created_at_format."--".$data_last_created_at_format;
// if ($last_created_at_format === $data_last_created_at_format) {
//      $json[$key]['date_label'] = '';
//   // echo "The 'created_at' values are equal.";
// } else {
//     //echo "The 'created_at' values are not equal.";
// } 
}
// }else{
//   $modified_json['date_label']= "Today";
// }


//print_r($data_last);
if(isset($modified_json)){
  $json = $modified_json;  
}
  
  return $this->response->setJSON($json);

}
function chat_system_fetch_reply(){
  $id=$this->request->getVar('id');
  $data = $this->chat_system->where('id', $id)->first(); 
  return $this->response->setJSON($data);
}
function notification_store(){
     $session = \Config\Services::session();
     $admin_id=$session->admin_id;
     $data = $this->admin_account_model->where('id', $admin_id)->first(); 
     $notification=$data['notification'];
    //  return $this->response->setJSON($data);
    
    echo $notification;
}
//for update chat
function update_chat_aftershownotification(){
    
    $admin_id=$this->request->getVar('admin_id');
    $update = $this->admin_account_model->where('id', $admin_id)->set('notification', '0')->update();
    $response = array('notification' => 'notification is updated for id=>' . $admin_id, 'success' => $update);
    return $this->response->setJSON($response);
}
function chat_system_checksession(){
    $session = \Config\Services::session();
    $operation = $this->request->getVar('operation');
    $session->set('operation', $operation);
      
}

function chat_system_getsession(){
    $session = \Config\Services::session();
    $operationValue = $session->get('operation');
    return $this->response->setJSON(['operation' => $operationValue]);
    
}

// function last_one_data_fetch(){
    
//     $offset_ = $this->request->getPost("userTimezone");
//     //$offset_='America/Edmonton';
//     $timezone = new DateTimeZone($offset_);
//     $date = new DateTime('now', $timezone);
//     $today=$date->format('Y-m-d'); //today date
//     $data = $this->chat_system->orderBy('id', 'DESC')->first(); 
//     //print_r($data);
//     if($data){
//          //check previous recoed
//     $last_id=$data['id'] - 1;
//     $check_previous_date = $this->chat_system->where('id', $last_id)->first();
//     $createdDate = new DateTime($data['created_at']);
//     //$last_msg_date= $createdDate->format('Y-m-d');//last msg date
//     $createdDate->setTimezone($timezone);
//     $new_date = $createdDate->format('Y-m-d H:i:s');
//     $new_date_frmt=$createdDate->format('Y-m-d');
//     $data['created_at'] = $new_date;
//     if($check_previous_date != null){
//      $check_previous_date_db=$check_previous_date['created_at'];
//      $create_check_date = new DateTime($check_previous_date_db);
//      $create_check_date->setTimezone($timezone);
//      $new_date_previous = $createdDate->format('Y-m-d');
//       if($new_date_frmt == $new_date_previous){
//           $data['date_label']=''; 
//       }else{
//           $data['date_label']='Today';
//       }
//     }else{
//         $data['date_label']='Today';
//     }
//     return $this->response->setJSON($data);
//     }else{
//         $data=null;
//         return $this->response->setJSON($data);
//     }
// }

function last_one_data_fetch(){
    
    $offset_ = $this->request->getPost("userTimezone");
    
    $last_msg__id = $this->request->getPost("last_msg__id") ?? 0;
    
    $timezone = new DateTimeZone($offset_);
    $date = new DateTime('now', $timezone);
    $today=$date->format('Y-m-d'); //today date
    $data = $this->chat_system->where("id > ", $last_msg__id)->orderBy('id', 'DESC')->findAll(); 
    // print_r($data);
    // die;
    if($data){
    // Mohsin Coding Here
    $check_previous_date = null;
    if($last_msg__id){
        $check_previous_date = $this->chat_system->where('id', $last_msg__id)->first();
    }
    // End
    $json = [];
    foreach ($data as $item) {
        // print_r($item);
        // continue;
        $createdDate = new DateTime($item['created_at']);
        $createdDate->setTimezone($timezone);
        $new_date = $createdDate->format('Y-m-d');
        $new_date_time=$createdDate->format('Y-m-d H:i:s');
        $item['created_at'] = $new_date_time;
        //for give check labels today and tomorrow
        $currentDate = new DateTime('now', $timezone);
        $currentDateFormatted = $currentDate->format('Y-m-d');
        $interval = $createdDate->diff($currentDate);
        $daysDifference = $interval->days;
        $chat_date_temp = strtotime($new_date);
        $todays_date = strtotime($currentDateFormatted);  // sempal
        // $todays_date = strtotime('2023-02-16');  // sempal
        $timeleft = $todays_date - $chat_date_temp;
        $daysDifference = round((($timeleft / 86400)));
        
        // if ($daysDifference == 0) {
        //      $item['date_label']="Today";
        // } elseif ($daysDifference == 1) {
        //     $item['date_label']="Yesterday";
        // } else {
        //     $item['date_label']=$createdDate->format('M j Y');
        // }

        if($check_previous_date != null){
            // Sort
            $createdDate = new DateTime($check_previous_date['created_at']);
            //$last_msg_date= $createdDate->format('Y-m-d');//last msg date
            $createdDate->setTimezone($timezone);
            $new_date = $createdDate->format('Y-m-d H:i:s');
            $new_date_frmt=$createdDate->format('Y-m-d');
            $check_previous_date['created_at'] = $new_date;

            // End

            $check_previous_date_db=$item['created_at'];
            $create_check_date = new DateTime($check_previous_date_db);
            $create_check_date->setTimezone($timezone);
            $new_date_previous = $create_check_date->format('Y-m-d');
            //$data['check_date']=$new_date_frmt."<--->".$new_date_previous;
            if($new_date_frmt == $new_date_previous){
                $item['date_label']=''; 
            }else{
                $item['date_label']='Today';
            }
        }else{
            $item['date_label']='Today';
        }

        // 
        
        array_push($json, $item);
    }
    
    return $this->response->setJSON($json);
    // print_r($json);

    exit;





    //check previous recoed
    $last_id=$data['id'] - 1;
    $check_previous_date = $this->chat_system->where('id', $last_id)->first();
    $createdDate = new DateTime($data['created_at']);
    //$last_msg_date= $createdDate->format('Y-m-d');//last msg date
    $createdDate->setTimezone($timezone);
    $new_date = $createdDate->format('Y-m-d H:i:s');
    $new_date_frmt=$createdDate->format('Y-m-d');
    $data['created_at'] = $new_date;
    if($check_previous_date != null){
     $check_previous_date_db=$check_previous_date['created_at'];
     $create_check_date = new DateTime($check_previous_date_db);
     $create_check_date->setTimezone($timezone);
     $new_date_previous = $create_check_date->format('Y-m-d');
     //$data['check_date']=$new_date_frmt."<--->".$new_date_previous;
       if($new_date_frmt == $new_date_previous){
           $data['date_label']=''; 
       }else{
           $data['date_label']='Today';
       }
    }else{
        $data['date_label']='Today';
    }
    return $this->response->setJSON($data);
    }else{
        $data=null;
        return $this->response->setJSON($data);
    }
}

function check_active(){
    //$admin_id =  session()->get('admin_id');
    $admin_data=admin_data();
    //$admin_data['count']=count($admin_data);
  return $this->response->setJSON($admin_data); 
}

public function check_date_view(){
    return view('admin/check_date');
}

function store_doc_files_chat(){
    //  echo "<pre>";
    //   print_r($_POST);
    //   print_r($_FILES);
    //   die;
     $admin_id=$this->request->getVar('admin_id');
     $admin_ac = $this->admin_account_model->where('id', $admin_id)->get()->getRow();
     if($admin_ac->id == 1 ){
          $user_name = $admin_ac->first_name;
     }else{
          $user_name = $admin_ac->first_name. " " .$admin_ac->last_name; 
     }
     
     $lastInsertedIds[]="";
     $last_id='';
     $file = $this->request->getFile('file');
     if (!empty($file)) {
       if ($file->isValid() && !$file->hasMoved()) {
        $path = FCPATH . 'public/assets/chat_documents/';
        $filename = $file->getClientName();
        $file->move($path, $filename);
        $data = [
            'documents' => $filename,
            'documents_path'=>'public/assets/chat_documents/'.$filename,
            'admin_id' => $admin_id,
            'user_name'=>$user_name,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $insert = $this->chats_documents->insert($data);
        $lastQuery = $this->chats_documents->getLastQuery();
        $last_id=$this->chats_documents->insertID();
        $lastInsertedIds[]=$last_id;
         }
      array_shift($lastInsertedIds);
      $data = $this->chats_documents->whereIn('id', $lastInsertedIds)->orderBy('id', 'ASC')->findAll(); 
      //$lastInsertedIds=array_reverse($lastInsertedIds);
      $responseData=array(
          'data'=>$data,
          'lastinsertedids_chat'=>$last_id
          );
      $jsonResponse = json_encode($responseData);
      return $this->response->setJSON($jsonResponse);
    }
    
}



//old
// function store_doc_files_chat(){
    
//      $admin_id=$this->request->getVar('admin_id');
//      $admin_ac = $this->admin_account_model->where('id', $admin_id)->get()->getRow();
//      if($admin_ac->id == 1 ){
//           $user_name = $admin_ac->first_name;
//      }else{
//           $user_name = $admin_ac->first_name. " " .$admin_ac->last_name; 
//      }
//      $uploadedFiles = $this->request->getFiles();
//      $fileName = $uploadedFiles['chat_file'][0]->getName();
     
//      $lastInsertedIds[]="";
//     // print_r($uploadedFiles);
//     // die;
//     if (!empty($fileName) && empty($notes)) {
//      foreach ($uploadedFiles['chat_file'] as $file) {
//         // echo "i am here";
//         // die;
//      if ($file->isValid() && !$file->hasMoved()) {
//         $path = FCPATH . 'public/assets/chat_documents/';
//         $filename = $file->getClientName();
//         $file->move($path, $filename);

//         $data = [
//             'documents' => $filename,
//             'documents_path'=>'public/assets/chat_documents/'.$filename,
//             'admin_id' => $admin_id,
//             'user_name'=>$user_name,
//             'created_at' => date('Y-m-d H:i:s'),
//             'updated_at' => date('Y-m-d H:i:s'),
//         ];
//         $insert = $this->chats_documents->insert($data);
//         $lastQuery = $this->chats_documents->getLastQuery();
//         $last_id=$this->chats_documents->insertID();
//         $lastInsertedIds[]=$last_id;
//          }
    
//       }

//       array_shift($lastInsertedIds);
//       $data = $this->chats_documents->whereIn('id', $lastInsertedIds)->orderBy('id', 'ASC')->findAll(); 
//       //$lastInsertedIds=array_reverse($lastInsertedIds);
//       $responseData=array(
//           'data'=>$data,
//           'lastinsertedids_chat'=>$lastInsertedIds
//           );
//       $jsonResponse = json_encode($responseData);
//       return $this->response->setJSON($jsonResponse);
//     }
    
// }

function delete_chat_single(){
   $id=$this->request->getVar('id');
    $files = $this->chats_documents->where('id', $id)->first();
    $file=isset($files['documents']) ? $files['documents'] : "" ;
    $path = FCPATH . 'public/assets/chat_documents/';
    $filePath = $path . $file;
    if (is_file($filePath)) {
    if (unlink($filePath)) {
    } 
}
    $delete = $this->chats_documents->where('id', $id)->delete();
    $data=array('msg'=>'Record delete Successfully -->'.$id);
    return $this->response->setJSON($data);
    
}
//END THE CHAT MODULE CODE
//START THE  NOTE MODULE
// function notes()
// {
//      //for reply
//     $reply_id=$this->request->getVar('reply_id_note');
//     $reply_msg=$this->request->getVar('reply_msg_note');
//     $reply_color=$this->request->getVar('reply_color_note');
//     $reply_user_name=$this->request->getVar('reply_user_name_note');
//     $reply_documents=$this->request->getVar('reply_docs_files');
//     $reply_docs_path=$this->request->getVar('reply_docs_path');
//     $reply_admin_id=$this->request->getVar('reply_admin_id');
    
//     //for regular msg/files
//     $offset_ = $this->request->getPost("userTimezone");
//     $timezone = new DateTimeZone($offset_);
//     $date = new DateTime('now', $timezone);
    
    
//     $notes = $this->request->getPost('message');
//     $pointer_id = $this->request->getPost('pointer_id');
//     $admin_id = $this->request->getPost('admin_id');
//     $documents_ids_string = $this->request->getPost('docs_ids');
//     $documents_ids = json_decode($documents_ids_string, true);
//     $uploadedFiles = $this->request->getFiles();
//     $fileName = $uploadedFiles['note_file'][0]->getName();
//     $admin_ac = $this->admin_account_model->where('id', $admin_id)->get()->getRow();
//      if($admin_ac->id == 1 ){
//           $user_name = $admin_ac->first_name;
//      }else{
//           $user_name = $admin_ac->first_name. " " .$admin_ac->last_name; 
//      }
//     $color=$admin_ac->color; 
//     $count=0;
//     $lastInsertedIds[]="";
//     $last_message_data[]="";
//     $last_id_message_id="";
//     $lastInsertedIds_data[]="";
//     if(!empty($notes)){
//          $data = [
//             'message' => $notes,
//             'documents' => "",
//             'pointer_id' => $pointer_id,
//             'admin_id' => $admin_id,
//             'user_name'=>$user_name,
//             'color'=>$color,
//             'reply_id'=>$reply_id,
//             'reply_msg'=>$reply_msg,
//             'reply_documents'=>$reply_documents,
//             'reply_user_name'=>$reply_user_name,
//             'reply_documents_path' =>$reply_docs_path,
//             'reply_admin_id'=>$reply_admin_id,
//             'reply_color'=>$reply_color,
//             'created_at' => date('Y-m-d H:i:s'),
//             'updated_at' => date('Y-m-d H:i:s'),
//         ];
//      $insert = $this->notes->insert($data);
//      $last_id_message_id = $this->notes->insertID();
//      $last_id_message_id;
//      $last_message_data = $this->notes->where('id', $last_id_message_id)->first();
//      if ($last_message_data) {
//      $createdDate = new DateTime($last_message_data['created_at']);
//      $createdDate->setTimezone($timezone);
//      $last_message_data['created_at'] = $createdDate->format('Y-m-d H:i:s');
//      }
//         $responseData=array(
//           'last_message_data'=>$last_message_data
//           );
       
//       if(empty($documents_ids)){
//           $jsonResponse = json_encode($responseData);
//           return $this->response->setJSON($jsonResponse);
//         }else{
//           $last_message_data=$last_message_data;
//         }
       
//       }
    
    
//     //for upload documents and upload files name/path in notes table by rohit
//     if (!empty($fileName) && empty($notes)) {
//      foreach ($uploadedFiles['note_file'] as $file) {
//          $count++;
//      if ($file->isValid() && !$file->hasMoved()) {
//         $path = FCPATH . 'public/assets/notes_documents/';
//         $filename = $file->getClientName();
//         $file->move($path, $filename);

//         $data = [
//             'documents' => $filename,
//             'documents_path'=>'public/assets/notes_documents/'.$filename,
//             'pointer_id' => $pointer_id,
//             'admin_id' => $admin_id,
//             'user_name'=>$user_name,
//             'created_at' => date('Y-m-d H:i:s'),
//             'updated_at' => date('Y-m-d H:i:s'),
//         ];
//         $insert = $this->notes_documents->insert($data);
//         $last_id=$this->notes_documents->insertID();
//         $lastInsertedIds[]=$last_id;
//          }
    
//       }

//       array_shift($lastInsertedIds);
//       $data = $this->notes_documents->whereIn('id', $lastInsertedIds)->orderBy('id', 'ASC')->findAll(); 
//       $responseData=array(
//           'data'=>$data,
//           'lastInsertedIds'=>$lastInsertedIds
//           );
//       $jsonResponse = json_encode($responseData);
//       return $this->response->setJSON($jsonResponse);
      
// }else{
    
//       $response=[];
//     //   echo $notes;
//       // print_r($documents_ids);
      
//  if(is_array($documents_ids)){
//      $lastInsertedIds_afterinsert[]="";
     
//      if(!empty($notes)){
//          $first_id_data=$documents_ids[0];
//          array_shift($documents_ids);
//          //for update record with message data
//           $first_notes_docs = $this->notes_documents->where('id', $first_id_data)->first(); 
//           $update_data=array(
//               'documents' => $first_notes_docs['documents'],
//               'documents_path' => $first_notes_docs['documents_path'],
//               );
//           $update = $this->notes->where('id',$last_id_message_id)->set($update_data)->update();
//           $first_notes_docs_updated = $this->notes->where('id', $last_id_message_id)->first();
//         //   echo "dsknfhljdzbvf";
//         //   die;
//              if ($first_notes_docs_updated) {
//                  $createdDate = new DateTime($first_notes_docs_updated['created_at']);
//                  $createdDate->setTimezone($timezone);
//                  $first_notes_docs_updated['created_at'] = $createdDate->format('Y-m-d H:i:s');
//                  }
//                  $last_message_data=$first_notes_docs_updated;
//         }
     
//             //   print_r($documents_ids);
//             //   die;
//                  if(!empty($documents_ids)){
//                  foreach ($documents_ids as $document_id) {
//                     $data_notes_docs = $this->notes_documents->where('id', $document_id)->first(); 
//                     $data_docs = [
//                         'message' => '',
//                         'documents' => $data_notes_docs['documents'],
//                         'documents_path' => $data_notes_docs['documents_path'],
//                         'pointer_id' => $pointer_id,
//                         'admin_id' => $admin_id,
//                         'document_id' => $document_id,
//                         'user_name' => $user_name,
//                         'color' => $color,
//                         'reply_id'=>$reply_id,
//                         'reply_msg'=>$reply_msg,
//                         'reply_documents'=>$reply_documents,
//                         'reply_user_name'=>$reply_user_name,
//                         'reply_documents_path' =>$reply_docs_path,
//                         'reply_admin_id'=>$reply_admin_id,
//                         'reply_color'=>$reply_color,
//                         'created_at' => date('Y-m-d H:i:s'), 
//                         'updated_at' => date('Y-m-d H:i:s'), 
//                     ];
//                     $insert_docs = $this->notes->insert($data_docs);
//                     $last_id_message_id = $this->notes->insertID();
//                     $lastInsertedIds_afterinsert[]=$last_id_message_id;
            
//                 }
                
//                   array_shift($lastInsertedIds_afterinsert);
//                   $lastInsertedIds_data = $this->notes->whereIn('id', $lastInsertedIds_afterinsert)->orderBy('id', 'DESC')->findAll(); 
//                   foreach ($lastInsertedIds_data as &$data) {
//                   $createdDate = new DateTime($data['created_at']);
//                   $createdDate->setTimezone($timezone);
//                   $data['created_at'] = $createdDate->format('Y-m-d H:i:s');
//                       }
//                   }
                  
//             $responseData = array(
//                 'last_docs_data' => $lastInsertedIds_data,
//                 'last_message_data'=>$last_message_data
//             );
//           $jsonResponse = json_encode($responseData);
//           return $this->response->setJSON($jsonResponse);
        
//       }
      
// }



     
// }
function notes()
{
    $session = \Config\Services::session();
    
     //for reply
    $reply_id=$this->request->getVar('reply_id_note');
    $reply_msg=$this->request->getVar('reply_msg_note');
    $reply_color=$this->request->getVar('reply_color_note');
    $reply_user_name=$this->request->getVar('reply_user_name_note');
    $reply_documents=$this->request->getVar('reply_docs_files');
    $reply_docs_path=$this->request->getVar('reply_docs_path');
    $reply_admin_id=$this->request->getVar('reply_admin_id');
    
    //for regular msg/files
    $offset_ = $this->request->getPost("userTimezone");
    $timezone = new DateTimeZone($offset_);
    $date = new DateTime('now', $timezone);
    
    
    $notes = $this->request->getPost('message');
    $pointer_id = $this->request->getPost('pointer_id');
    $admin_id = $this->request->getPost('admin_id');
    $documents_ids_string = $this->request->getPost('docs_ids');
    $documents_ids = json_decode($documents_ids_string, true);
    $uploadedFiles = $this->request->getFiles();
    $fileName = $uploadedFiles['note_file'][0]->getName();
    $admin_ac = $this->admin_account_model->where('id', $admin_id)->get()->getRow();
     if($admin_ac->id == 1 ){
          $user_name = $admin_ac->first_name;
     }else{
          $user_name = $admin_ac->first_name. " " .$admin_ac->last_name; 
     }
    $color=$admin_ac->color; 
    $count=0;
    $lastInsertedIds[]="";
    $last_message_data[]="";
    $last_id_message_id="";
    $lastInsertedIds_data[]="";
    if (!empty(trim($notes))) {
         $data = [
            'message' => $notes,
            'documents' => "",
            'pointer_id' => $pointer_id,
            'admin_id' => $admin_id,
            'user_name'=>$user_name,
            'color'=>$color,
            'reply_id'=>$reply_id,
            'reply_msg'=>$reply_msg,
            'reply_documents'=>$reply_documents,
            'reply_user_name'=>$reply_user_name,
            'reply_documents_path' =>$reply_docs_path,
            'reply_admin_id'=>$reply_admin_id,
            'reply_color'=>$reply_color,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
     $insert = $this->notes->insert($data);
     $last_id_message_id = $this->notes->insertID();
     $last_id_message_id;
     $last_message_data = $this->notes->where('id', $last_id_message_id)->first();
     if ($last_message_data) {
     $createdDate = new DateTime($last_message_data['created_at']);
     $createdDate->setTimezone($timezone);
     $last_message_data['created_at'] = $createdDate->format('Y-m-d H:i:s');
     }
        $responseData=array(
          'last_message_data'=>$last_message_data
          );
       
       if(empty($documents_ids)){
           $jsonResponse = json_encode($responseData);
           return $this->response->setJSON($jsonResponse);
        }else{
          $last_message_data=$last_message_data;
        }
       
       }
    
    
    //for upload documents and upload files name/path in notes table by rohit
    if (!empty($fileName) && empty($notes)) {
     foreach ($uploadedFiles['note_file'] as $file) {
         $count++;
         $path = FCPATH . 'public/assets/notes_documents/'.$pointer_id;
            if (!file_exists($path)) {
                if (!mkdir($path, 0777, true)) {
                    die('Failed to create folder...');
                }
            }
            
        if ($file->isValid() && !$file->hasMoved()) {
            $filename = $file->getClientName();
            $random_filename = $file->getRandomName();
            $file->move($path, $filename);
        }

        $data = [
            'documents' => $filename,
            'random_documents' => $random_filename,
            'documents_path'=>'public/assets/notes_documents/'.$pointer_id.'/'.$filename,
            'pointer_id' => $pointer_id,
            'admin_id' => $admin_id,
            'user_name'=>$user_name,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $insert = $this->notes_documents->insert($data);
        $last_id=$this->notes_documents->insertID();
        $lastInsertedIds[]=$last_id;
         }
    
      //}

       array_shift($lastInsertedIds);
       $session->set('session_inserted_ids', $lastInsertedIds);
      $data = $this->notes_documents->whereIn('id', $lastInsertedIds)->orderBy('id', 'ASC')->findAll(); 
      $responseData=array(
          'data'=>$data,
          'lastInsertedIds'=>$lastInsertedIds
          );
      $jsonResponse = json_encode($responseData);
      return $this->response->setJSON($jsonResponse);
      
}else{
    
      $response=[];
    //   echo $notes;
      // print_r($documents_ids);
      
 if(is_array($documents_ids)){
     $lastInsertedIds_afterinsert[]="";
     
     if (!empty(trim($notes))) {
         $first_id_data=$documents_ids[0];
         array_shift($documents_ids);
         //for update record with message data
           $first_notes_docs = $this->notes_documents->where('id', $first_id_data)->first(); 
           $update_data=array(
               'documents' => $first_notes_docs['documents'],
               'documents_path' => $first_notes_docs['documents_path'],
              );
           $update = $this->notes->where('id',$last_id_message_id)->set($update_data)->update();
           $first_notes_docs_updated = $this->notes->where('id', $last_id_message_id)->first();
        //   echo "dsknfhljdzbvf";
        //   die;
             if ($first_notes_docs_updated) {
                 $createdDate = new DateTime($first_notes_docs_updated['created_at']);
                 $createdDate->setTimezone($timezone);
                 $first_notes_docs_updated['created_at'] = $createdDate->format('Y-m-d H:i:s');
                 }
                 $last_message_data=$first_notes_docs_updated;
        }
     
            //   print_r($documents_ids);
            //   die;
                 if(!empty($documents_ids)){
                 foreach ($documents_ids as $document_id) {
                    $data_notes_docs = $this->notes_documents->where('id', $document_id)->first(); 
                    $data_docs = [
                        'message' => '',
                        'documents' => $data_notes_docs['documents'],
                        'random_documents' => $data_notes_docs['random_documents'],
                        'documents_path' => $data_notes_docs['documents_path'],
                        'pointer_id' => $pointer_id,
                        'admin_id' => $admin_id,
                        'document_id' => $document_id,
                        'user_name' => $user_name,
                        'color' => $color,
                        'reply_id'=>$reply_id,
                        'reply_msg'=>$reply_msg,
                        'reply_documents'=>$reply_documents,
                        'reply_user_name'=>$reply_user_name,
                        'reply_documents_path' =>$reply_docs_path,
                        'reply_admin_id'=>$reply_admin_id,
                        'reply_color'=>$reply_color,
                        'created_at' => date('Y-m-d H:i:s'), 
                        'updated_at' => date('Y-m-d H:i:s'), 
                    ];
                    $insert_docs = $this->notes->insert($data_docs);
                    $last_id_message_id = $this->notes->insertID();
                    $lastInsertedIds_afterinsert[]=$last_id_message_id;
            
                }
                
                  array_shift($lastInsertedIds_afterinsert);
                  $lastInsertedIds_data = $this->notes->whereIn('id', $lastInsertedIds_afterinsert)->orderBy('id', 'DESC')->findAll(); 
                  foreach ($lastInsertedIds_data as &$data) {
                  $createdDate = new DateTime($data['created_at']);
                  $createdDate->setTimezone($timezone);
                  $data['created_at'] = $createdDate->format('Y-m-d H:i:s');
                      }
                  }
                  
            $responseData = array(
                'last_docs_data' => $lastInsertedIds_data,
                'last_message_data'=>$last_message_data
            );
          $jsonResponse = json_encode($responseData);
          return $this->response->setJSON($jsonResponse);
        
      }
      
}



     
}
function delete_notes_single(){
    $id=$this->request->getPost('id');
    $files = $this->notes_documents->where('id', $id)->first();
    $file=isset($files['documents']) ? $files['documents'] : "" ;
    $path = FCPATH . 'public/assets/notes_documents/';
    $filePath = $path . $file;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
    $delete = $this->notes_documents->where('id', $id)->delete();
    $data=array('msg'=>'Record delete Successfully -->'.$id);
   return $this->response->setJSON($data);
    
}

//for fetch last messages 
function last_one_data_fetch_notes(){
    
     $last_msg__id = $this->request->getPost("last_msg__id_note");
     $pointer_id=$this->request->getPost('pointer_id_global');
     $offset_ = $this->request->getPost("userTimezone");
     $timezone = new DateTimeZone($offset_);
     $date = new DateTime('now', $timezone);
     $where=[
         'id >'=>$last_msg__id,
         'pointer_id'=>$pointer_id
         ];
     //$data=$this->notes->where($where)->first();
     $data = $this->notes->where($where)->orderBy('id', 'DESC')->findAll(); 
     $notes_count=$count = $this->notes->where('pointer_id', $pointer_id)->countAllResults();
    //  echo $this->notes->getLastQuery();
      $json_data = [];
    foreach ($data as $item) {
     $createdDate = new DateTime($item['created_at']);
     $createdDate->setTimezone($timezone);
     $item['created_at'] = $createdDate->format('Y-m-d H:i:s');
     $item['notes_count']=$notes_count;
     array_push($json_data, $item);   
    }
    //  print_r($json_data);
    //  echo $this->notes
     return $this->response->setJSON($json_data);
}

//for fetch fetch_notes

function fetch_notes(){
    
 $offset_=$this->request->getPost('userTimezone');
 $pointer_id=$this->request->getPost('pointer_id_global');
 $timezone = new DateTimeZone($offset_);
 $date = new DateTime('now', $timezone);
 $record_fetch_cnt = $this->request->getPost("record_fetch_note");
 $offset_record = $this->request->getPost("offset_record_note");
 //echo 'offset' . $offset_record . 'limit' .$record_fetch_cnt;
 $data = $this->notes->where('pointer_id', $pointer_id)->limit($record_fetch_cnt, $offset_record)->orderBy('id', 'DESC')->find();
 foreach ($data as &$data_) {
    $createdDate = new DateTime($data_['created_at']);
    $createdDate->setTimezone($timezone);
    $data_['created_at'] = $createdDate->format('Y-m-d H:i:s');
    
    $deleted_at = new DateTime($data_['deleted_at']);
    $deleted_at->setTimezone($timezone);
    $data_['deleted_at'] = $deleted_at->format('Y-m-d H:i:s'); 
    
}
 //echo $this->notes->getLastQuery();
 // print_r($data);
    return $this->response->setJSON($data);
}

function for_update_message(){
    
    //print_r($_POST);
    $id = $this->request->getPost('id');
    $message = $this->request->getPost('message_update');
    $admin_id = $this->request->getPost('admin_id_note');
    $old_message = $this->request->getPost('old_message');
   // echo $old_message;
    $data=[
         'message'=>$message,
         'old_message'=>$old_message,
         'edited_by_id'=>$admin_id,
         'updated_at'=>date('Y-m-d H:i:s'),
        ];
        
       
     $update = $this->notes->where('id',$id)->set($data)->update();
     $data_updated=$this->notes->where('id',$id)->first();
     $jsonResponse = json_encode($data_updated);
    return $this->response->setJSON($data_updated); 
     
    
    
}

function for_delete_message(){
    $offset_=$this->request->getPost('userTimezone');
    $timezone = new DateTimeZone($offset_);
    $date = new DateTime('now', $timezone);
    $id = $this->request->getPost('id');
    $admin_id = $this->request->getPost('admin_id_note');
    $data=[
         'isdeleted'=>1,
         'deleted_by_id'=>$admin_id,
         'deleted_at'=>date('Y-m-d H:i:s'),
         ];
     $update = $this->notes->where('id',$id)->set($data)->update();
     $data_deleted=$this->notes->where('id',$id)->first();
     $createdDate = new DateTime($data_deleted['deleted_at']);
     $createdDate->setTimezone($timezone);
     $data_deleted['deleted_at'] = $createdDate->format('Y-m-d H:i:s');
     $jsonResponse = json_encode($data_deleted);
     return $this->response->setJSON($data_deleted);   
}


function for_delete_all_trash_files(){
     $session = \Config\Services::session();
     $session_inserted_ids = $session->get('session_inserted_ids');
  if(isset($session_inserted_ids)){
    foreach ($session_inserted_ids as $session_inserted_id) {
    $data_deleted = $this->notes_documents->where('id', $session_inserted_id)->first();
    if ($data_deleted) {
        $this->notes_documents->where('id', $session_inserted_id)->delete();
         $path = FCPATH . 'public/assets/notes_documents/';
        $file_path = $path . $data_deleted['documents']; 
        if (file_exists($file_path)) {
            unlink($file_path); 
        } 
    
        }
        
    }
    $session->remove('session_inserted_ids');
     $data=array(
         'response'=>'files Deleted Successfully'
         );
  }else{
      $data=array(
         'response'=>'files not uploaded'
         );
  }

     return $this->response->setJSON($data);
}

function chat_system_fetch_reply_note(){
  $id=$this->request->getVar('id');
  $data = $this->notes->where('id', $id)->first(); 
  return $this->response->setJSON($data);
}

}
