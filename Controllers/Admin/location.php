<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class location extends BaseController
{

// -------------- interview_location end ----------------
    public function index($tab="")
    {
        $data["tab"]= $tab;
        //   echo "$tab";
        //   exit;
        $data['interview_locations'] = $this->stage_3_offline_location_model->where('pratical',0)->asObject()->orderby('country', 'ASC')->findAll();
        $data['praticals'] = $this->stage_3_offline_location_model->where('pratical',1)->asObject()->orderby('country', 'ASC')->findAll();
        $data['countries'] = $this->country_model->asObject()->findAll();
        $data['page']="Location";
        
        if ($tab == "interview_location") {
        $data['page'] = "interview_location";
      } elseif ($tab == "pratical") {
        $data['page'] = "Pratical";
      }

        return view('admin/location/index', $data);
    }
     public function update()
    {
        $session = session();
        $data = $this->request->getvar();

        $id = $data['id'];
      if($data['email_cc']){
          $email_cc=$data['email_cc'];
      }else{
          $email_cc="";
      }

      $cost = 0;
      if($session->admin_id == 1 && $data["venue"] == "AQATO"){
        $cost = $data["cost"];
      }

        $details = array(
            'city_name' => $data['city_name'],
            'country' => $data['country'],
            'email_cc' => $email_cc,
            'venue' => $data['venue'],
            'email' => $data['email'],
            'office_address' => $data['office_address'],
            'contact_details' => $data['contact_details'],
            'reg_date' =>  date("Y-m-d H:i:s"),
            'cost' => $cost,
        );
        
        // print_r($details);
        // exit;
        
        if ($this->stage_3_offline_location_model->update($id, $details)) {
            $callback = array(
                "color" => "success",
                "msg" => "update recode",
                "response" => true,
            );
        } else {
            $callback = array(
                "msg" => "unable to update record",
                "color" => "danger",
                "response" => false,
            );
        }
        echo json_encode($callback);
    }
   
}