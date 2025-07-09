<?php

namespace Config;

use PHPUnit\TextUI\XmlConfiguration\Group;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(true);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


// Note:
// The web portal is having a technical glitch. The IT team is trying to resolve the issue. Kindly revisit in a couple of hours and hopefully it should be back up live. We apologize for any inconvenience it may have caused !

// Team ATTC-AQATO

// Login user > Login check 
// $routes->get('{any}', function(){
//     return view("user/login");
// });


// Check Session File
$routes->get('admin/check_user_login_ajax', 'Admin\login::check_user_login_ajax');

// Check Auto logout
$routes->get('admin/check_auto_logout', 'cron_jobs::check_auto_logout');


$routes->get('/', 'User\login::login_page');
$routes->get('/backup', 'User\login::login_page_backup');
$routes->post('user_login_check_backup', 'User\login::user_login_check_backup');
$routes->get('login/generate_captcha', 'User\login::generate_captcha');
$routes->get('login/(:any)', 'User\login::login_page/$1');
$routes->get('user/login', 'User\login::login_page');



$routes->get('/email_html_tem', 'User\login::email_html_tem');




$routes->get('stage_3_date_vishal', 'Admin\admin::stage_3_date_vishal');

$routes->post('user_login_check', 'User\login::user_login_check');
$routes->get('sing_out', 'User\login::sing_out');
$routes->get('day_night_mode/(:any)', 'User\login::day_night_mode/$1');

// <!-- use for developer  -->
$routes->get('Account_type_change', 'User\dashboard::Account_type_change');
// <!-- use for developer  -->



// forgot password send > verify > reset
$routes->get('user/forgot_Password', 'User\login::forgot_Password_page');
$routes->post('user_Forgot_Password_check', 'User\login::user_Forgot_Password_check');
$routes->get('New_password/(:any)', 'User\login::New_password_page/$1');
$routes->post('New_password_check', 'User\login::New_password_check');


// creat new account > email verify 
$routes->get('create_an_account', 'User\login::create_an_account_page');
$routes->post('create_an_account_code', 'User\login::create_an_account_code');
$routes->get('Verification/(:any)', 'User\login::Verification/$1');
$routes->get('Verification/(:any)', 'User\login::Verification/$1');
$routes->get('DS_applicant_declaration_pdf__', 'User\applicant_declaration::DS_applicant_declaration_pdf__');


$routes->get('user/digital_signing/creat_image/(:any)', 'User\digital_signing::creat_image/$1');
$routes->get('auto_save_download_PDF_/(:any)', 'User\application_preview::auto_save_download_PDF_/$1');
$routes->get('auto_save_download_PDF_admin/(:any)', 'User\application_preview::auto_save_download_PDF_admin/$1');

// akanksha 27-6-2023
$routes->get('update_review_pdf_html_code/(:any)','User\application_preview::update_review_pdf_html_code/$1');

// $routes->get('stage_1/application_preview/(:any)', 'User\application_preview::application_preview/$1');
// $routes->post('pdf_Download_check_', 'User\application_preview::pdf_Download_check_');
// $routes->post('pdf_Download_check_only_', 'User\application_preview::pdf_Download_check_only_');
// $routes->post('pdf_html_code_', 'User\application_preview::pdf_html_code_');
// $routes->get('download_PDF_/(:any)', 'User\application_preview::download_PDF_/$1');
$routes->group('', ['filter' => 'admin_login'], function ($routes) {
    $routes->get('application_transfer/(:any)', 'Admin\application_transfer::application_transfer/$1');
    $routes->post('application_transfer_', 'Admin\application_transfer::application_transfer_');
    
    // under dewloping
    $routes->get('Create_new_TRA_file/(:any)', 'Admin\application_transfer::Create_new_TRA_file/$1/$2');
    $routes->post('Create_new_TRA_file_pdf_html_code_', 'Admin\application_transfer::pdf_html_code_');
    $routes->get('Create_new_TRA_file_auto_save_download_PDF_/(:any)', 'Admin\application_transfer::auto_save_download_PDF_/$1');
    $routes->post('Create_new_TRA_file_file_Upload_', 'Admin\application_transfer::file_Upload_');
    $routes->post('Create_new_TRA_file_delete_file_/(:any)', 'Admin\application_transfer::delete_file_/$1/$2');
    $routes->get('Create_new_TRA_file_Send_email_/(:any)', 'Admin\application_transfer::Send_email_/$1');
    
    $routes->get('make_date_store_init', 'cron_jobs::make_date_store_init');
    
});


// filter For User --------------------------
$routes->group('user', ['filter' => 'user_login'], function ($routes) {
    
    $routes->post('comments/deleteDocumentAndComments', 'User\receipt_upload::deleteDocumentAndComments');
    // start dashboard --------
    $routes->get('/', 'User\user::dashboard_page');
    $routes->get('dashboard', 'User\user::dashboard_page');
    $routes->get('download_Form', 'User\user::download_Form');

    $routes->get('create_new_application', 'User\dashboard::create_new_application');

    $routes->get('incomplete_application', 'User\incomplete_application::incomplete_application');
    $routes->get('incomplete_application_/(:any)', 'User\incomplete_application::incomplete_application_/$1');
    $routes->get('incomplete_application_delete/(:any)', 'User\incomplete_application::incomplete_application_delete/$1');

    $routes->get('account_update', 'User\user::account_update_page');
    $routes->post('account_update_', 'User\user::account_update_');
    $routes->post('account_update_pass_reset', 'User\user::account_update_pass_reset');
    
    //verfication pending
    $routes->get('pending_verification', 'User\user::pending_verification');
    $routes->get('pending_view/(:any)', 'User\user::pending_view/$1');

    // start stage 1---------
    $routes->get('stage_1/occupation/(:any)', 'User\occupation::occupation_page/$1');
    $routes->post('occupation_', 'User\occupation::occupation_');

    $routes->get('stage_1/personal_details/(:any)', 'User\personal_details::personal_details/$1');
    $routes->post('personal_details_', 'User\personal_details::personal_details_');

    $routes->get('stage_1/contact_details/(:any)', 'User\contact_details::contact_details/$1');
    $routes->post('contact_details_', 'User\contact_details::contact_details_');

    $routes->get('stage_1/identification_details/(:any)', 'User\identification_details::identification_details/$1');
    $routes->post('identification_details_', 'User\identification_details::identification_details_');

    $routes->get('stage_1/usi_avetmiss/(:any)', 'User\usi_avetmiss::usi_avetmiss/$1');
    $routes->post('usi_avetmiss_', 'User\usi_avetmiss::usi_avetmiss_');

    $routes->get('stage_1/education_employment_details/(:any)', 'User\education_employment_details::education_employment_details/$1');
    $routes->post('education_employment_details_', 'User\education_employment_details::education_employment_details_');

    $routes->get('stage_1/application_preview/(:any)', 'User\application_preview::application_preview/$1');
    $routes->post('pdf_Download_check_', 'User\application_preview::pdf_Download_check_');
    $routes->post('pdf_Download_check_only_', 'User\application_preview::pdf_Download_check_only_');
    $routes->post('pdf_html_code_', 'User\application_preview::pdf_html_code_');
    $routes->get('download_PDF_/(:any)', 'User\application_preview::download_PDF_/$1');


    $routes->get('send_email_digital_signing/(:any)', 'User\digital_signing::send_email_digital_signing/$1');
    $routes->get('digital_signing/(:any)', 'User\digital_signing::index/$1');
    $routes->post('digital_signing/page_view_', 'User\digital_signing::page_view_');
    $routes->post('digital_signing/signing_upload_', 'User\digital_signing::signing_upload_');
    $routes->post('digital_signing/signing_get_upload_', 'User\digital_signing::signing_get_upload_');


    $routes->get('stage_1/applicant_declaration/(:any)', 'User\applicant_declaration::applicant_declaration/$1');
    $routes->post('applicant_declaration_', 'User\applicant_declaration::applicant_declaration_');
    $routes->get('information_release_form_/(:any)', 'User\applicant_declaration::information_release_form_/$1');
    $routes->get('applicant_declaration_pdf_/(:any)', 'User\applicant_declaration::applicant_declaration_pdf_/$1');
    $routes->get('DS_information_release_form_/(:any)', 'User\applicant_declaration::DS_information_release_form_/$1');
    $routes->get('DS_applicant_declaration_pdf_/(:any)', 'User\applicant_declaration::DS_applicant_declaration_pdf_/$1');

    $routes->get('stage_1/upload_documents/(:any)', 'User\upload_documents::upload_documents/$1');
    $routes->post('stage_1/upload_documents_', 'User\upload_documents::upload_documents_');
    $routes->post('stage_1/upload_documents/multy_file_upload_', 'User\upload_documents::multy_file_upload_');
    $routes->post('stage_1/delet_file_', 'User\upload_documents::delet_file_');
    $routes->match(['get', 'post'], 'stage_1/required_documents_list_/(:any)', 'User\upload_documents::required_documents_list_/$1');
    $routes->get('stage_1/upload_documents_file_validate_/(:any)', 'User\upload_documents::file_validate_/$1');
    $routes->get('stage_1/upload_documents_submit_stage_1_/(:any)', 'User\upload_documents::submit_stage_1_/$1');

    $routes->get('submitted_applications', 'User\submitted_applications::submitted_applications');
    // New Route
    $routes->get('submitted_applications_new', 'User\submitted_applications::submitted_applications_pagination');
    $routes->get('submitted_applications_fetch_data', 'User\submitted_applications::submitted_applications_fetch_data');
    $routes->get('submitted_applications_/(:any)', 'User\submitted_applications::submitted_applications_/$1');
    // $routes->get('submitted_applications_delete/(:any)', 'User\submitted_applications::submitted_applications_delete/$1');

    $routes->get('view_application/(:any)', 'User\view_application::view_application/$1');
    $routes->post('additional_information_request/(:any)', 'User\view_application::additional_information_request/$1');
    
    // Comment Checker
    
    $routes->post('getTheCommentBasedOnStage', 'User\view_application::getTheCommentBasedOnStage');

    // start stage 2---------
    $routes->get('stage_2/add_employment/(:any)', 'User\add_employment::add_employment_page/$1');
    $routes->post('stage_2_add_employment_/(:any)', 'User\add_employment::stage_2_add_employment_/$1');
    $routes->post('stage_2_delete_employe_/(:any)', 'User\add_employment::stage_2_delete_employe_/$1');
    $routes->post('stage_2_employe_Docs_check/(:any)', 'User\add_employment::stage_2_employe_Docs_check/$1');

    $routes->post('stage_2_edite_employment_/(:any)', 'User\add_employment::stage_2_edite_employment_/$1');

    $routes->get('stage_2/add_employment_document/(:any)', 'User\add_employment_document::add_employment_document_page/$1');
    $routes->post('stage_2/add_employment_document_list_/(:any)', 'User\add_employment_document::add_employment_document_list_/$1');
    $routes->post('stage_2/add_employment_document_info_/(:any)', 'User\add_employment_document::add_employment_document_info_/$1');
    $routes->post('stage_2/employe_document_upload_/(:any)', 'User\add_employment_document::employe_document_upload_/$1');
    $routes->post('stage_2/employe_document_multiple_upload_/(:any)', 'User\add_employment_document::employe_document_multiple_upload_/$1');
    $routes->post('stage_2/add_employment_document/upload_support_evidence_docs', 'User\add_employment_document::upload_support_evidence_docs');


    $routes->post('stage_2/assessment_documents_multiple_upload_/(:any)', 'User\add_employment_document::assessment_documents_multiple_upload_/$1');

    $routes->post('stage_2/assessment_documents_list_/(:any)', 'User\add_employment_document::assessment_documents_list_/$1');
    $routes->post('stage_2/assessment_documents_info_/(:any)', 'User\add_employment_document::assessment_documents_info_/$1');
    $routes->post('stage_2/assessment_documents_upload_/(:any)', 'User\add_employment_document::assessment_documents_upload_/$1');
    $routes->post('stage_2/documents_info_delete_file_/(:any)', 'User\add_employment_document::documents_info_delete_file_/$1');
    $routes->get('stage_2/add_employment_document_verify_/(:any)', 'User\add_employment_document::add_employment_document_verify_/$1');
    $routes->get('stage_2/submit_application_/(:any)', 'User\add_employment_document::submit_application_/$1');


    // view page
    $routes->get('stage_3/receipt_upload/(:any)', 'User\receipt_upload::receipt_upload_page/$1');
    
    $routes->post('stage_3/receipt_upload/comment_file_upload', 'User\receipt_upload::comment_file_upload');
    
    $routes->get('stage_3/receipt_upload_page__/(:any)','User\receipt_upload::receipt_upload_pagesecond/$1');
    $routes->get('stage_3/storepdf/(:any)','User\receipt_upload::storepdf/$1');
    $routes->post('stage_3/exemption_data/(:any)', 'User\receipt_upload::exemption_data/$1');
    $routes->post('stage_3/exemption_form/(:any)', 'User\receipt_upload::exemption_form/$1');
    $routes->post('stage_3/valication/(:any)', 'User\receipt_upload::valication/$1');

   
    $routes->post('stage_3/receipt_upload_action/(:any)', 'User\receipt_upload::receipt_upload_action/$1');
    $routes->get('stage_3/receipt_upload_delete/(:any)', 'User\receipt_upload::receipt_upload_delete/$1');
    $routes->post('stage_3/receipt_upload_delete/(:any)', 'User\receipt_upload::receipt_upload_delete/$1');
    $routes->post('stage_3/save_Preferred_info_/(:any)', 'User\receipt_upload::save_Preferred_info_/$1');
    $routes->post('stage_3/get_addresh_', 'User\receipt_upload::get_addresh_');
    $routes->post('stage_3/submit_/(:any)', 'User\receipt_upload::stage_3_submit_/$1');
    $routes->post('stage_3/submit_pageseconds3/(:any)','User\receipt_upload::submit_pageseconds3/$1');
    
    // akansha 18 july 2023
    $routes->post('stage_3_reassessment/start/(:any)', 'User\stage_3_reassessment::start/$1');
    $routes->post('stage_3_reassessment/save_pointer/(:any)', 'User\stage_3_reassessment::save_back/$1');
     $routes->get('stage_3_reassessment/storepdf/(:any)','User\stage_3_reassessment::storepdf/$1');
    $routes->get('stage_3_reassessment/receipt_upload/(:any)', 'User\stage_3_reassessment::receipt_upload_page/$1');
    $routes->get('stage_3_reassessment/receipt_upload_page__/(:any)', 'User\stage_3_reassessment::receipt_upload_page__/$1');
    $routes->post('stage_3_reassessment/exemption_data/(:any)', 'User\stage_3_reassessment::exemption_data/$1');
    $routes->post('stage_3_reassessment/exemption_form/(:any)', 'User\stage_3_reassessment::exemption_form/$1');
    $routes->post('stage_3_reassessment/valication/(:any)', 'User\stage_3_reassessment::valication/$1');

   
    $routes->post('stage_3_reassessment/receipt_upload_action/(:any)', 'User\stage_3_reassessment::receipt_upload_action/$1');
    $routes->get('stage_3_reassessment/receipt_upload_delete/(:any)', 'User\stage_3_reassessment::receipt_upload_delete/$1');
    $routes->post('stage_3_reassessment/receipt_upload_delete/(:any)', 'User\stage_3_reassessment::receipt_upload_delete/$1');
    $routes->post('stage_3_reassessment/save_Preferred_info_/(:any)', 'User\stage_3_reassessment::save_Preferred_info_/$1');
    $routes->post('stage_3_reassessment/get_addresh_', 'User\stage_3_reassessment::get_addresh_');
    $routes->post('stage_3_reassessment/submit_/(:any)', 'User\stage_3_reassessment::stage_3_submit_/$1');
    $routes->post('stage_3_reassessment/submit_pageseconds3/(:any)', 'User\stage_3_reassessment::submit_pageseconds3/$1');
   
    //stage 4 receipt upload page

    
    $routes->post('stage_4/receipt_upload/comment_file_upload', 'User\s4_receipt_upload::comment_file_upload');
    
    $routes->get('stage_4/receipt_upload/(:any)', 'User\s4_receipt_upload::receipt_upload_page/$1');
    
     $routes->post('stage_4/receipt_upload_action/(:any)', 'User\s4_receipt_upload::receipt_upload_action/$1');

    $routes->post('stage_4/receipt_upload_delete/(:any)', 'User\s4_receipt_upload::receipt_upload_delete/$1');

    $routes->post('stage_4/save_Preferred_info_/(:any)', 'User\s4_receipt_upload::save_Preferred_info_/$1');

    $routes->post('stage_4/get_addresh_', 'User\s4_receipt_upload::get_addresh_');

    $routes->post('stage_4/submit_/(:any)', 'User\s4_receipt_upload::stage_4_submit_/$1');
  


    $routes->get('Finish_application/(:any)', 'User\Finish_application::Finish_application/$1');


    $routes->get('stage_3/receipt_upload_getData/(:any)', 'User\receipt_upload::receipt_upload_getData/$1');
});



// Admin Routing grouping
$routes->group('admin/', function ($routes) {
    
    

    $routes->get('not_aqato_s3/', 'Admin\not_aqato_s3::index');
    $routes->post('not_aqato_s3/insert_booking', 'Admin\not_aqato_s3::insert_booking');
    $routes->post('not_aqato_s3/insert_booking_edite', 'Admin\not_aqato_s3::insert_booking_edite');
    $routes->post('not_aqato_s3/send_mail_non_aqato_zoom_meet', 'Admin\not_aqato_s3::send_mail_non_aqato_zoom_meet');

    $routes->get('login/', 'Admin\login::login_page');
    $routes->get('member_allocation/', 'Admin\login::member_allocation');
    // check details for login
    $routes->post('logincheck', 'Admin\login::logincheck');
    $routes->get('logout', 'Admin\login::logout');
    // forgot password send > verify > reset
    $routes->get('forgot_password', 'Admin\login::forgot_password_page');
    $routes->post('check_forgot_password', 'Admin\login::check_forgot_password');
    $routes->get('new_password/(:any)', 'Admin\login::new_password_page/$1');
    $routes->post('new_password_check', 'Admin\login::new_password_check');
        // akanksha 19-6-2023
    $routes->post('File_update_stage_2', 'Admin\admin::File_update_stage_2');

    // vishal patel 26-04-2023 
    $routes->post('File_update_stage_3', 'Admin\admin::File_update_stage_3');
    
    // akansha july 2023
    $routes->post('File_update_stage_3_R', 'Admin\admin::File_update_stage_3_R');

    $routes->post('File_update_stage_4', 'Admin\admin::File_update_stage_4');
    
    
    
});
// admin filters

// Template Route
$routes->get('admin/admin_functions/view_template_report', 'Admin\admin_functions::view_template_report');
$routes->get('admin/admin_functions/accounting/view_template_report', 'Admin\admin_functions::view_template_report__accounting');
$routes->get('admin/admin_functions/accounting/view_template_report_offshore', 'Admin\admin_functions::view_template_report__offshore');

// end Template Route

// admin filters
$routes->post('admin/update_preffered_location', 'Admin\Application_manager\application_manager::update_preffered_location');

$routes->group('admin/', ['filter' => 'admin_login'], function ($routes) {

    $routes->get('dashboard', 'Admin\admin::dashboard');
    $routes->get('dashboard/show_comment_record', 'Admin\admin::dashboard/$1');

    $routes->group('application_manager/', function ($routes) {
        // $routes->get('index_new', 'Admin\Application_manager\application_manager::index');
        
        $routes->get('', 'Admin\Application_manager\application_manager::index_new');
        
        // Comment Route
        $routes->post('show_s1_s2_s3_comments', 'Admin\comment_store_documents::show_s1_s2_s3_comments');
        $routes->post('show_s1_s2_s3_comments_single_delete', 'Admin\comment_store_documents::show_s1_s2_s3_comments_single_delete');
        $routes->post('show_s1_s2_s3_comments_all_delete', 'Admin\comment_store_documents::show_s1_s2_s3_comments_all_delete');
        
        // End
        
        $routes->get('fetch_application_records', 'Admin\Application_manager\application_manager::fetch_application_records');

        $routes->get('company/(:num)', 'Admin\Application_manager\application_manager::filter_company/$1');
        $routes->get('view_application/(:any)', 'Admin\Application_manager\application_manager::view_application/$1');
        
        
        $routes->post('change_team_member', 'Admin\Application_manager\application_manager::change_team_member');
        $routes->post('change_team_member_show', 'Admin\Application_manager\application_manager::change_team_member_show');
        
        $routes->post('change_team_member_show', 'Admin\Application_manager\application_manager::change_team_member_show');

        // ---------------admin Application Manager -> view_application -> stage 1 ----------------
        $routes->post('status_change/stage_1', 'Admin\Application_manager\mail::stage_1_change_status');
        $routes->post('edit_passpost_photo', 'Admin\Application_manager\application_manager::edit_passpost_photo');
        $routes->get('delete_document/(:any)', 'Admin\Application_manager\application_manager::delete_document/$1');
        $routes->post('delete_document/(:any)', 'Admin\Application_manager\application_manager::delete_document/$1');
         $routes->post('delete_request_new/(:any)', 'Admin\Application_manager\application_manager::delete_request_new/$1');
         $routes->post('delete_additional_req_all/(:any)', 'Admin\Application_manager\application_manager::delete_additional_req_all/$1');
        
        //   admin stage 2 delete
        $routes->post('delete_stage2/(:any)', 'Admin\Application_manager\application_manager::delete_stage_2_/$1');
        $routes->post('chef_to_cook/(:any)', 'Admin\Application_manager\application_manager::chef_to_cook/$1');
        $routes->post('osap_to_tss/(:any)', 'Admin\Application_manager\application_manager::osap_to_tss/$1');
        $routes->post('pathway_change/(:any)', 'Admin\Application_manager\application_manager::pathway_change/$1');
        
        // akanksha 27 june 2023
        $routes->post('delete_company/(:any)', 'Admin\Application_manager\application_manager::delete_company/$1');
        $routes->post('download_zip/(:num)/(:any)', 'Admin\Application_manager\application_manager::download_zip/$1/$2');
        $routes->post('comment_document', 'Admin\Application_manager\application_manager::comments_for_document');
        $routes->post('comment_document_stage_2', 'Admin\Application_manager\application_manager::comment_document_stage_2');
        $routes->post('verify_email_stage_1', 'Admin\Application_manager\application_manager::verify_email_stage_1');
        $routes->post('qualification_verification_form', 'Admin\Application_manager\application_manager::qualification_verification_form');
        $routes->post('qualification_verification_file', 'Admin\Application_manager\application_manager::qualification_verification_file');
        $routes->post('check_extra_files', 'Admin\Application_manager\application_manager::check_extra_files');
        $routes->post('delete_file_qulifiaction_verfication', 'Admin\Application_manager\application_manager::delete_file_qulifiaction_verfication');
        $routes->post('update_unique_no/stage_1/', 'Admin\Application_manager\application_manager::update_unique_no');

        // ---------------admin Application Manager -> view_application -> stage 2 ----------------
        $routes->post('status_change/stage_2', 'Admin\Application_manager\mail::stage_2_change_status');
        $routes->post('send_employ_email_stage_2', 'Admin\Application_manager\application_manager::send_email_employ_stage_2');
        $routes->post('verify_email_stage_2', 'Admin\Application_manager\application_manager::verify_email_stage_2');
        $routes->post('delete_stage_2/(:any)', 'Admin\Application_manager\application_manager::delete_stage_2/$1');


        $routes->post('upload_exemption_file', 'Admin\Application_manager\application_manager::upload_exemption_file');
        $routes->post('upload_applicant','Admin\Application_manager\application_manager::upload_applicant');  
        $routes->post('upload_applicant__','Admin\Application_manager\application_manager::upload_applicant__');  
        
        
        
        $routes->get('delete_exemption_file/(:any)', 'Admin\Application_manager\application_manager::delete_exemption_file/$1');
        
        $routes->post('s4_upload_exemption_file', 'Admin\Application_manager\application_manager::stage_4_upload_exemption_file');
        
        $routes->get('s4_delete_exemption_file/(:any)', 'Admin\Application_manager\application_manager::stage_4_delete_exemption_file/$1');
        
        
        

        // ---------------admin Application Manager -> view_application -> stage 3 ----------------
        $routes->post('status_change/stage_3', 'Admin\Application_manager\mail::stage_3_change_status');
        
        // akanksha 18 july 2023
        $routes->post('status_change/stage_3_reassessment', 'Admin\Application_manager\mail::stage_3_reassessment_change_status');

        $routes->post('status_change/stage_4', 'Admin\Application_manager\mail::stage_4_change_status');
    });
    $routes->post('save_Assigned_Team_Member/(:num)', 'Admin\Application_manager\application_manager::save_Assigned_Team_Member/$1');


    $routes->group('interview_calendar/', function ($routes) {
        $routes->get('', 'Admin\admin::interview_calendar');
    });

    $routes->group('scheduler/', function ($routes) {
        $routes->get('', 'Admin\scheduler::index');
    });

    $routes->group('interview_booking/', function ($routes) {
        
        
        $routes->get('__pagination', 'Admin\admin::interview_booking');
        $routes->get('', 'Admin\admin::interview_booking_pagination');
        $routes->get('fetch_application_records_interview_booking', 'Admin\admin::fetch_application_records_interview_booking');
        
        $routes->get('', 'Admin\admin::interview_booking');
        $routes->post('insert', 'Admin\admin::insert_booking');
        $routes->post('update', 'Admin\admin::update_booking');
        $routes->post('get_preference_location', 'Admin\admin::get_preference_location');
        
        // get_preference_location_stage4
        
        $routes->post('get_preference_location_stage4', 'Admin\admin::get_preference_location_stage4');
        // 
        
        $routes->post('get_applicant_location', 'Admin\admin::get_applicant_location');
        $routes->post('send_mail_zoom_meet', 'Admin\admin::send_mail_zoom_meet');
        $routes->post('interview_booking_cancle', 'Admin\admin::interview_booking_cancle');
        $routes->post('stage3_reass_interview_booking_cancle', 'Admin\admin::stage3_reass_interview_booking_cancle');
        $routes->post('non_aquato_interview_booking_cancle', 'Admin\admin::non_aquato_interview_booking_cancle');
        
        
       //$routes->post('interview_booking_cancle/(:num)', 'Admin\admin::interview_booking_cancle/$1');



    });
    
    // akanksha 19 july 2023
    $routes->group('interview_booking_reassessment/', function ($routes) {
        $routes->get('', 'Admin\admin::interview_booking_reassessment');
        $routes->post('insert', 'Admin\admin::insert_booking_reassessment');
        $routes->post('update', 'Admin\admin::update_booking_reassessment');
        $routes->post('get_preference_location', 'Admin\admin::get_preference_location_reassessment');
        $routes->post('get_applicant_location', 'Admin\admin::get_applicant_location_reassessment');
        $routes->post('send_mail_zoom_meet', 'Admin\admin::send_mail_zoom_meet_reassessment');

    });
    
 $routes->group('practical_booking/', function ($routes) {

        $routes->get('', 'Admin\practical_booking::practical_booking');

        $routes->post('insert', 'Admin\practical_booking::insert_booking');

        $routes->post('update', 'Admin\practical_booking::update_booking');

        $routes->post('get_preference_location', 'Admin\practical_booking::get_preference_location');
        
        $routes->post('get_applicant_location', 'Admin\practical_booking::get_applicant_location');
        
        $routes->post('practical_booking_cancle', 'Admin\practical_booking::practical_booking_cancle');

    });

    $routes->group('applicant_agent/', function ($routes) {

        $routes->get('applicant/(:num)', 'Admin\applicant_agent::view/$1');
        $routes->get('agent/(:num)', 'Admin\applicant_agent::view/$1');
        $routes->post('delete/(:num)', 'Admin\applicant_agent::delete/$1');
        $routes->post('update', 'Admin\applicant_agent::update');
        $routes->get('company/(:num)', 'Admin\Application_manager\application_manager::filter_company/$1');
        $routes->get('company/(:num)/(:any)', 'Admin\Application_manager\application_manager::filter_company/$1/$2');
        $routes->get('(:any)', 'Admin\applicant_agent::index/$1');
    });

    
    $routes->group('comment_store_documents/', function ($routes) {
        $routes->post('insertTheFile', 'Admin\comment_store_documents::insertTheFile');
        $routes->post('deleteTheRecord', 'Admin\comment_store_documents::deleteTheRecord');
    });
    
    
    $routes->group('admin_functions/', function ($routes) {

        // Reporting Route

        $routes->get('', 'Admin\admin_functions::reporting_view/$1');
        $routes->get('fetch_application_records', 'Admin\admin_functions::fetch_application_records');
        
        $routes->get('fetch_application_records_agent', 'Admin\admin_functions::fetch_application_records_agent');
        $routes->get('download_report', 'Admin\admin_functions::download_report');
        $routes->get('download_report_spreadsheet', 'Admin\admin_functions::download_report_spreadsheet');
    
        $routes->post('getTheCountry', 'Admin\admin_functions::getTheCountry');
        
        //chat module
        $routes->post('chat_system', 'Admin\chat_system::chat_system');
        $routes->post('chat_system_fetch', 'Admin\chat_system::chat_system_fetch');
        $routes->get('chat_system_fetch_reply', 'Admin\chat_system::chat_system_fetch_reply');
        $routes->post('chat_system_checksession', 'Admin\chat_system::chat_system_checksession');
        $routes->get('chat_system_getsession', 'Admin\chat_system::chat_system_getsession');
        $routes->post('last_one_data_fetch', 'Admin\chat_system::last_one_data_fetch');
         $routes->get('notification_store', 'Admin\chat_system::notification_store');
        $routes->post('update_chat_aftershownotification', 'Admin\chat_system::update_chat_aftershownotification');
         $routes->get('check_active', 'Admin\chat_system::check_active');
         $routes->post('store_doc_files_chat', 'Admin\chat_system::store_doc_files_chat');
        $routes->post('delete_chat_single', 'Admin\chat_system::delete_chat_single');
         
         //note module 
           $routes->post('notes', 'Admin\chat_system::notes');
         $routes->post('fetch_notes', 'Admin\chat_system::fetch_notes');
         $routes->post('fetch_last_note', 'Admin\chat_system::fetch_last_note');
         $routes->post('delete_notes_single', 'Admin\chat_system::delete_notes_single');
         $routes->get('notes_fetch', 'Admin\chat_system::notes_fetch');
         $routes->post('last_one_data_fetch_notes', 'Admin\chat_system::last_one_data_fetch_notes');
         $routes->post('for_update_message', 'Admin\chat_system::for_update_message');
         $routes->post('for_delete_message', 'Admin\chat_system::for_delete_message');
         $routes->get('chat_system_fetch_reply_note', 'Admin\chat_system::chat_system_fetch_reply_note');
         $routes->get('for_delete_all_trash_files', 'Admin\chat_system::for_delete_all_trash_files');

         
        // Accouting Routes
        $routes->group('accounting/', function ($routes) {

            // Referral Fees Report
            $routes->get('', 'Admin\admin_functions::accounting');
            $routes->get('fetch_application_records', 'Admin\admin_functions::fetch_application_records__accounting');
            $routes->get('fetch_application_records_agent', 'Admin\admin_functions::fetch_application_records_agent__accounting');
            
            $routes->get('download_report', 'Admin\admin_functions::download_report__accounting');
            $routes->get('download_report_spreadsheet', 'Admin\admin_functions::download_report_spreadsheet__accounting');

            // Offshores Fees
            $routes->get('offshore', 'Admin\admin_functions::offshore');
            $routes->get('fetch_application_records_offshore', 'Admin\admin_functions::fetch_application_records_offshore');
            $routes->get('fetch_application_records_agent_offshore', 'Admin\admin_functions::fetch_application_records_agent_offshore');
            
            $routes->get('download_report_offshore', 'Admin\admin_functions::download_report_offshore');
            $routes->get('download_report_spreadsheet_offshore', 'Admin\admin_functions::download_report_spreadsheet_offshore');

        });

    });

    $routes->group('staff_management/', function ($routes) {

        $routes->get('(:any)', 'Admin\staff_management::index/$1');
        $routes->get('edit(:num)', 'Admin\staff_management::edit/$1');
        $routes->post('insert', 'Admin\staff_management::insert');
        $routes->post('update', 'Admin\staff_management::update');
        $routes->post('delete/(:num)', 'Admin\staff_management::delete/$1');
        $routes->post('status/(:num)', 'Admin\staff_management::status/$1');
    });

    $routes->group('occupation_manager/', function ($routes) {

        $routes->get('', 'Admin\occupation_manager::index');
        $routes->get('edit(:num)', 'Admin\occupation_manager::edit/$1');
        $routes->post('insert', 'Admin\occupation_manager::insert');
        $routes->post('update', 'Admin\occupation_manager::update');
        $routes->post('delete/(:num)', 'Admin\occupation_manager::delete/$1');
        $routes->post('status/(:num)', 'Admin\occupation_manager::status/$1');
    });

    $routes->group('interview_location/', function ($routes) {

        $routes->get('', 'Admin\admin::interview_location');
        $routes->post('update', 'Admin\admin::update');
    });
    
     $routes->group('location/', function ($routes) {


        $routes->post('update', 'Admin\location::update');

        $routes->get('(:any)', 'Admin\location::index/$1');


    });


    // $routes->group('verification/', function ($routes) {
    //     $routes->get('', 'Admin\verification::index');
    //     $routes->get('view_application/(:num)', 'Admin\verification::view/$1');
    //     $routes->get('Change_status/(:num)/(:num)/(:any)', 'Admin\verification::Change_status/$1/$2/$3');
    //     $routes->post('edite_and_email_send/(:num)/(:num)', 'Admin\verification::edite_and_email_send/$1/$2');
    // });
    
     $routes->group('verification/', function ($routes) {
        // $routes->get('', 'Admin\verification::index');
        $routes->get('view_application/(:num)', 'Admin\verification::view/$1');
    $routes->post('edit_qualification_verification_form', 'Admin\verification::edit_qualification_verification_form');
    $routes->post('change_status_quali', 'Admin\verification::change_status_quali');
        $routes->get('Change_status/(:num)/(:num)/(:any)', 'Admin\verification::Change_status/$1/$2/$3');
        $routes->get('(:any)', 'Admin\verification::index/$1'); // index page
        $routes->post('edite_and_email_send/(:num)/(:num)', 'Admin\verification::edite_and_email_send/$1/$2');
    });
   
    $routes->group('mail_template/', function ($routes) {

        $routes->get('', 'Admin\Mail_template::index');
        $routes->get('add', 'Admin\Mail_template::add');
        $routes->post('add_action', 'Admin\Mail_template::add_action');
        $routes->get('edit/(:num)', 'Admin\Mail_template::edit/$1');
        $routes->post('edit_action', 'Admin\Mail_template::edit_action');
        $routes->get('name_keywords', 'Admin\Mail_template::name_keywords');
        $routes->post('add_name_keyword', 'Admin\Mail_template::add_name_keyword');
        $routes->post('edit_name_keyword', 'Admin\Mail_template::edit_name_keyword');
        $routes->match(['get', 'post'], 'test_email/', 'Admin\Mail_template::test_email/');
    });

    $routes->group('offline_files/', function ($routes) {

        $routes->get('(:any)', 'Admin\offline_files::index/$1');
        $routes->post('insert', 'Admin\offline_files::insert');
        $routes->post('update', 'Admin\offline_files::update');
        $routes->post('delete/(:num)', 'Admin\offline_files::delete/$1');
    });


    $routes->group('Archive/', function ($routes) {
        $routes->get('', 'Admin\Archive::index');
    });
});




// Auto run Cron jobs -------------------------------------
$routes->get('application_expiry_checker', 'cron_jobs::stage_1_expired');
$routes->get('stage_2_expired', 'cron_jobs::stage_2_expired');
$routes->get('stage_3_set_Conducted_status', 'cron_jobs::stage_3_auto_Conducted');
$routes->get('stage_3_R_auto_Conducted_status', 'cron_jobs::stage_3_R_auto_Conducted');
$routes->get('stage_4_set_Conducted_status', 'cron_jobs::stage_4_auto_Conducted');
$routes->get('read_email_and_Update', 'cron_jobs::google_api');
$routes->get('closed_expire_application', 'cron_jobs::closed_expire_application');
$routes->get('call_the_mail_queue', 'cron_jobs::call_the_mail_queue');



// akanksha 5 july 2023

$routes->get('update_pointer_id_s1_closed', 'cron_jobs::update_pointer_id_s1_closed');
//Rohit 
$routes->get('check_email_reminder', 'cron_jobs::check_email_reminder');
$routes->get('zoom_reminder', 'cron_jobs::zoom_reminder');

// $routes->get('read_email_and_Update', 'cron_jobs::google_api');








/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
