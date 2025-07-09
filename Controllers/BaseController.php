<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\Admin_account;
use App\Models\Email_interview_location;
use App\Models\Additional_info_request;
use App\Models\Comment_store_documents;
use App\Models\Application_Pointer;
use App\Models\Country;
use App\Models\Digital_signature_info;
use App\Models\Documents;
use App\Models\Email_verification;
use App\Models\Email_Format;
use App\Models\Mail_Box;
use App\Models\Mail_Template;
use App\Models\Mail_Template_Name_Keyword;
use App\Models\Offline_File;
use App\Models\Occupation_list;
use App\Models\Required_documents_list;
use App\Models\Stage_1;
use App\Models\Stage_1_occupation;
use App\Models\Stage_1_contact_details;
use App\Models\Stage_1_education_and_employment;
use App\Models\Stage_1_identification_details;
use App\Models\Stage_1_personal_details;
use App\Models\Stage_1_review_confirm;
use App\Models\Stage_1_usi_avetmiss;
use App\Models\Stage_2;
use App\Models\Stage_2_add_employment;
use App\Models\Stage_3;
use App\Models\Stage_3_interview_booking;
use App\Models\Stage_3_reassessment;
use App\Models\Stage_3_reassessment_interview_booking;
use App\Models\Stage_3_offline_location;
use App\Models\Time_Zone;
use App\Models\Token;
use App\Models\User_account;
use App\Models\stage_3_interview_booking_time_slots;
use App\Models\not_aqato_s3;
use App\Models\Stage_4;
use App\Models\Stage_4_practical_booking;
use App\Models\not_aqato_s3_cancle_req;
use App\Models\stage3_cancle_interview_booking;
use App\Models\stage4_cancle_interview_booking;
use App\Models\stage3_reass_cancle_interview_booking;
use App\Models\chat_system;
use App\Models\notes;
use App\Models\notes_documents;
use App\Models\chats_documents;
// use App\Models\notes;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    // protected $helpers = [];
    protected $helpers = [
        'Session_helper',
        'Email_helper',
        'Common_helper',
        'Admin_helper',
    ];
    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }


    // New add ----------------
    protected $db;
    protected $session;
    protected $encrypter;

    protected $email_interview_location_model;
    protected $admin_account_model;
    protected $additional_info_request_model;
    protected $comment_store_documents_model;
    protected $application_pointer_model;
    protected $digital_signature_info_model;
    protected $documents_model;
    protected $email_format_model;
    protected $email_verification_model;
    protected $country_model;
    protected $mail_box_model;
    protected $mail_template_model;
    protected $mail_template_name_keyword_model;
    protected $offline_file_model;
    protected $occupation_list_model;
    protected $stage_1_model;
    protected $stage_1_occupation_model;
    protected $stage_1_contact_details_model;
    protected $stage_1_education_and_employment_model;
    protected $stage_1_identification_details_model;
    protected $stage_1_personal_details_model;
    protected $stage_1_review_confirm_model;
    protected $stage_1_usi_avetmiss_model;
    protected $stage_2_model;
    protected $stage_2_add_employment_model;
    protected $stage_3_model;
    protected $stage_3_reassessment_model;
    protected $stage_3_offline_location_model;
    protected $stage_3_interview_booking_model;
    protected $stage_3_reassessment_interview_booking_model;
    protected $required_documents_list_model;
    protected $time_zone_model;
    protected $token_model;
    protected $user_account_model;
    protected $stage_3_interview_booking_time_slots_model;
    protected $not_aqato_s3_model;
    protected $stage_4_model;
    protected $stage_4_practical_booking_model;
    protected $not_aqato_s3_cancle_req;
    protected $stage3_cancle_interview_booking;
    protected $stage4_cancle_interview_booking;
    protected $stage3_reass_cancle_interview_booking;
    protected $chat_system;
    protected $notes;
    protected $notes_documents;
    protected $chats_documents;
    // protected $notes;


    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        $this->encrypter = \Config\Services::encrypter();

        $this->additional_info_request_model = new Additional_info_request();
        $this->comment_store_documents_model = new Comment_store_documents();
        $this->admin_account_model = new Admin_account();
        $this->application_pointer_model = new Application_Pointer();
        $this->country_model = new Country();
        $this->digital_signature_info_model = new Digital_signature_info();
        $this->documents_model = new Documents();
        $this->email_verification_model = new Email_verification();
        $this->email_format_model = new Email_Format();
        $this->mail_box_model = new Mail_Box();
        $this->mail_template_model = new Mail_Template();
        $this->mail_template_name_keyword_model = new Mail_Template_Name_Keyword();
        $this->occupation_list_model = new Occupation_list();
        $this->offline_file_model = new Offline_File();
        $this->required_documents_list_model = new Required_documents_list();
        $this->stage_1_model = new Stage_1();
        $this->stage_1_occupation_model = new Stage_1_occupation();
        $this->stage_1_contact_details_model = new Stage_1_contact_details();
        $this->stage_1_education_and_employment_model = new Stage_1_education_and_employment();
        $this->stage_1_identification_details_model = new Stage_1_identification_details();
        $this->stage_1_personal_details_model = new Stage_1_personal_details();
        $this->stage_1_review_confirm_model = new Stage_1_review_confirm();
        $this->stage_1_usi_avetmiss_model = new Stage_1_usi_avetmiss();
        $this->stage_2_model = new Stage_2();
        $this->stage_2_add_employment_model = new Stage_2_add_employment();
        $this->stage_3_interview_booking_model = new Stage_3_interview_booking();
        $this->stage_3_model = new Stage_3();
        $this->stage_3_reassessment_interview_booking_model = new Stage_3_reassessment_interview_booking();
        $this->stage_3_reassessment_model = new Stage_3_reassessment();
        $this->stage_3_offline_location_model = new Stage_3_offline_location();
        $this->time_zone_model = new Time_Zone();
        $this->token_model = new Token();
        $this->user_account_model = new User_account();
        $this->stage_3_interview_booking_time_slots_model = new stage_3_interview_booking_time_slots();
        $this->not_aqato_s3_model = new not_aqato_s3();
        $this->stage_4_practical_booking_model = new Stage_4_practical_booking();
        $this->stage_4_model = new Stage_4();
        $this->email_interview_location_model = new Email_interview_location();
        $this->not_aqato_s3_cancle_req_model =new not_aqato_s3_cancle_req();
        $this->stage3_cancle_interview_booking =new stage3_cancle_interview_booking();
        $this->stage4_cancle_interview_booking =new stage4_cancle_interview_booking();
        $this->stage3_reass_cancle_interview_booking =new stage3_reass_cancle_interview_booking();
        $this->chat_system =new chat_system();
        $this->notes =new notes();
        $this->notes_documents =new notes_documents();
        $this->chats_documents =new chats_documents();
        // $this->notes =new notes();
        
    }
    
}
