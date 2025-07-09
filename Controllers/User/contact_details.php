<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class contact_details extends BaseController
{
    public function contact_details($ENC_pointer_id)
    {
        // Decode ------
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        $contact_details = $this->stage_1_contact_details_model->where(['pointer_id' => $pointer_id])->first();
        $country_list = $this->country_model->findAll();


        $Residential_country = $contact_details['country'];
        $Residential_building_prop_name = $contact_details['building_prop_name'];
        $Residential_unit_flat_number = $contact_details['unit_flat_number'];
        $Residential_street_lot_number = $contact_details['street_lot_number'];
        $Residential_street_name = $contact_details['street_name'];
        $Residential_suburb = $contact_details['suburb'];
        $Residential_state_proviance = $contact_details['state_proviance'];
        $Residential_postcode = $contact_details['postcode'];
        $Residential_email = $contact_details['email'];
        $Residential_alternate_email = $contact_details['alternate_email'];
        $Residential_mobile_number_code = $contact_details['mobile_number_code'];
        $Residential_mobile_number = $contact_details['mobile_number'];
        $Residential_alter_mobile_code = $contact_details['alter_mobile_code'];
        $Residential_alter_mobile = $contact_details['alter_mobile'];

        $postal_address_is_different = $contact_details['postal_address_is_different'];

        $Postal_country =  $contact_details['Postal_country'];
        $postal_unit_flat_number =  $contact_details['postal_unit_flat_number'];
        $postal_street_lot_number =  $contact_details['postal_street_lot_number'];
        $postal_street_name =  $contact_details['postal_street_name'];
        $postal_suburb =  $contact_details['postal_suburb'];
        $postal_state_proviance =  $contact_details['postal_state_proviance'];
        $postal_postcode =  $contact_details['postal_postcode'];

        $Emergency_first_name =  $contact_details['first_name'];
        $Emergency_surname =  $contact_details['surname'];
        $Emergency_relationship =  $contact_details['relationship'];
        $Emergency_emergency_mobile_code =  $contact_details['emergency_mobile_code'];
        $Emergency_emergency_mobile =  $contact_details['emergency_mobile'];

        $user_id = $this->session->get('user_id');
        
        //   auto set value on first time on that page only for applicant 
        if (empty($Residential_mobile_number) || empty($Residential_unit_flat_number) || empty($Residential_email)) {
            if (is_Applicant()) {
                $register_user = $this->user_account_model->where(['id' => $user_id])->first();

                $Residential_unit_flat_number = (empty($Residential_unit_flat_number) ? $register_user['unit_flat'] : $Residential_unit_flat_number);
                $Residential_street_lot_number = (empty($Residential_street_lot_number) ? $register_user['street_lot'] : $Residential_street_lot_number);
                $Residential_street_name = (empty($Residential_street_name) ? $register_user['street_name'] : $Residential_street_name);
                $Residential_suburb = (empty($Residential_suburb) ? $register_user['suburb_city'] : $Residential_suburb);
                $Residential_state_proviance = (empty($Residential_state_proviance) ? $register_user['state_province'] : $Residential_state_proviance);
                $Residential_postcode = (empty($Residential_postcode) ? $register_user['postcode'] : $Residential_postcode);
                $Residential_email = (empty($Residential_email) ? $register_user['email'] : $Residential_email);
                $Residential_mobile_number_code = (empty($Residential_mobile_number_code) ? $register_user['mobile_code'] : $Residential_mobile_number_code);
                $Residential_mobile_number = (empty($Residential_mobile_number) ? $register_user['mobile_no'] : $Residential_mobile_number);

                if ($register_user['postal_unit_flat'] != 'yes') {
                    $postal_unit_flat_number =  (empty($postal_unit_flat_number) ? $register_user['postal_unit_flat'] : $postal_unit_flat_number);
                    $postal_street_lot_number =  (empty($postal_street_lot_number) ? $register_user['postal_street_lot'] : $postal_street_lot_number);
                    $postal_street_name =  (empty($postal_street_name) ? $register_user['postal_street_name'] : $postal_street_name);
                    $postal_suburb =  (empty($postal_suburb) ? $register_user['postal_suburb_city'] : $postal_suburb);
                    $postal_state_proviance =  (empty($postal_state_proviance) ? $register_user['postal_state_province'] : $postal_state_proviance);
                    $postal_postcode =  (empty($postal_postcode) ? $register_user['postal_postcode'] : $postal_postcode);
                    $postal_address_is_different = "no";
                } else {
                    $postal_address_is_different = "yes";
                }
            }
        }


        $data = [
            'page' => "Contact Details",
            'country_list' => $country_list,
            'contact_details' => $contact_details,
            'ENC_pointer_id' => $ENC_pointer_id,

            'Residential_country' => $Residential_country,
            'Residential_building_prop_name' => $Residential_building_prop_name,
            'Residential_unit_flat_number' => $Residential_unit_flat_number,
            'Residential_street_lot_number' => $Residential_street_lot_number,
            'Residential_street_name' => $Residential_street_name,
            'Residential_suburb' => $Residential_suburb,
            'Residential_state_proviance' => $Residential_state_proviance,
            'Residential_postcode' => $Residential_postcode,
            'Residential_email' => $Residential_email,
            'Residential_alternate_email' => $Residential_alternate_email,
            'Residential_mobile_number_code' => $Residential_mobile_number_code,
            'Residential_mobile_number' => $Residential_mobile_number,
            'Residential_alter_mobile_code' => $Residential_alter_mobile_code,
            'Residential_alter_mobile' => $Residential_alter_mobile,

            'postal_address_is_different' => $postal_address_is_different,

            'Postal_country' => $Postal_country,
            'postal_unit_flat_number' => $postal_unit_flat_number,
            'postal_street_lot_number' => $postal_street_lot_number,
            'postal_street_name' => $postal_street_name,
            'postal_suburb' => $postal_suburb,
            'postal_state_proviance' => $postal_state_proviance,
            'postal_postcode' => $postal_postcode,

            'Emergency_first_name' => $Emergency_first_name,
            'Emergency_surname' => $Emergency_surname,
            'Emergency_relationship' => $Emergency_relationship,
            'Emergency_emergency_mobile_code' => $Emergency_emergency_mobile_code,
            'Emergency_emergency_mobile' => $Emergency_emergency_mobile,
            'portal_reference_no' => portal_reference_no($pointer_id),

        ];

        return view('user/stage_1/contact_details', $data);
    } // funtion close

    public function contact_details_()
    {

        $data = $this->request->getvar();
        // Decode ------
        $ENC_pointer_id = $data['ENC_pointer_id'];
        $pointer_id = pointer_id_decrypt($ENC_pointer_id);

        // hide show
        $postal_address_is_different = "";
        if (isset($data['postal_address_is_different'])) {
            $postal_address_is_different = $data['postal_address_is_different'];
        }
        if ($postal_address_is_different == "no") {
            $Postal_country = (isset($data['Postal_country'])) ? $data['Postal_country'] : '';
            $postal_building_prop_name = (isset($data['postal_building_prop_name'])) ? $data['postal_building_prop_name'] : '';
            $postal_unit_flat_number = (isset($data['postal_unit_flat_number'])) ? $data['postal_unit_flat_number'] : '';
            $postal_street_lot_number = (isset($data['postal_street_lot_number'])) ? $data['postal_street_lot_number'] : '';
            $postal_street_name = (isset($data['postal_street_name'])) ? $data['postal_street_name'] : '';
            $postal_suburb = (isset($data['postal_suburb'])) ? $data['postal_suburb'] : '';
            $postal_state_proviance = (isset($data['postal_state_proviance'])) ? $data['postal_state_proviance'] : '';
            $postal_postcode = (isset($data['postal_postcode'])) ? $data['postal_postcode'] : '';
        } else if ($postal_address_is_different == "yes") {
            $Postal_country = $data['country'];
            $postal_building_prop_name = $data['building_prop_name'];
            $postal_unit_flat_number = $data['unit_flat_number'];
            $postal_street_lot_number = $data['street_lot_number'];
            $postal_street_name = $data['street_name'];
            $postal_suburb = $data['suburb'];
            $postal_state_proviance = $data['state_proviance'];
            $postal_postcode = $data['postcode'];
        }

        // hide show
        $mobile_number = (isset($data['mobile_number'])) ? $data['mobile_number'] : '';
        $mobile_number_code = (isset($data['mobile_number_code'])) ? $data['mobile_number_code'] : '';
        $alter_mobile = (isset($data['alter_mobile'])) ? $data['alter_mobile'] : '';
        $alter_mobile_code = (isset($data['alter_mobile_code'])) ? $data['alter_mobile_code'] : '';
        $emergency_mobile = (isset($data['emergency_mobile'])) ? $data['emergency_mobile'] : '';
        $emergency_mobile_code = (isset($data['emergency_mobile_code'])) ? $data['emergency_mobile_code'] : '';

        // array list for Update
        $details = [
            'emergency_mobile_code' => $emergency_mobile_code,
            'alter_mobile_code' => $alter_mobile_code,
            'mobile_number_code' => $mobile_number_code,
            'country' => (isset($data['country'])) ? $data['country'] : '',
            'building_prop_name' => (isset($data['building_prop_name'])) ? $data['building_prop_name'] : '',
            'unit_flat_number' => (isset($data['unit_flat_number'])) ? $data['unit_flat_number'] : '',
            'street_lot_number' => (isset($data['street_lot_number'])) ? $data['street_lot_number'] : '',
            'street_name' => (isset($data['street_name'])) ? $data['street_name'] : '',
            'suburb' => (isset($data['suburb'])) ? $data['suburb'] : '',
            'state_proviance' => (isset($data['state_proviance'])) ? $data['state_proviance'] : '',
            'postcode' => (isset($data['postcode'])) ? $data['postcode'] : '',
            'mobile_number' => $mobile_number,
            'alter_mobile' => $alter_mobile,
            'email' => (isset($data['email'])) ? strtolower($data['email']) : '',
            'alternate_email' => (isset($data['alternate_email'])) ? strtolower($data['alternate_email']) : '',
            'postal_address_is_different' => (isset($data['postal_address_is_different'])) ? $data['postal_address_is_different'] : '',
            'Postal_country' => (isset($Postal_country)) ? $Postal_country : '',
            'postal_building_prop_name' => (isset($postal_building_prop_name)) ? $postal_building_prop_name : '',
            'postal_unit_flat_number' => (isset($postal_unit_flat_number)) ? $postal_unit_flat_number : '',
            'postal_street_lot_number' => (isset($postal_street_lot_number)) ? $postal_street_lot_number : '',
            'postal_street_name' => (isset($postal_street_name)) ? $postal_street_name : '',
            'postal_suburb' => (isset($postal_suburb)) ? $postal_suburb : '',
            'postal_state_proviance' => (isset($postal_state_proviance)) ? $postal_state_proviance : '',
            'postal_postcode' => (isset($postal_postcode)) ? $postal_postcode : '',
            'first_name' => (isset($data['first_name'])) ? ucwords(strtolower(trim($data['first_name']))) : '',
            'surname' => (isset($data['surname'])) ? ucwords(strtolower(trim($data['surname']))) : '',
            'relationship' => (isset($data['relationship'])) ? ucwords(strtolower(trim($data['relationship']))) : '',
            'emergency_mobile' => $emergency_mobile,
        ];
// print_r($details);
// die;
        // Stepper update if new form is open 
        if (isset($data['submit'])) {
            $details['status'] = '1';
        }

        $this->stage_1_contact_details_model->where('pointer_id', $pointer_id)->set($details)->update();

        if (isset($data['submit'])) {  //for next button
            if ($data['submit'] == 'Next') {
                return redirect()->to(base_url('user/stage_1/identification_details/' . $ENC_pointer_id));
            } else if ($data['submit'] == 'Save & Exit') {
                return redirect()->to('user/dashboard');
            }
        }  // On button click else Auto update

    } // Funtion close
}
