<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\GlobeController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\LocalCoopController;
use App\Http\Controllers\TowerCoController;
use App\Http\Controllers\NewSitesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\RenewalController;
use App\Http\Controllers\ApiController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

///////////////////////////////////////////////////////////
//                                                       //
//                   VENDOR MANAGEMENT                   //
//                                                       //
///////////////////////////////////////////////////////////

// Route::get('/clean', [GlobeController::class, 'clean_table']);

Route::get('/login-as/{email}', [UserController::class, 'login_as']);

Route::group(['middleware' => ['auth', 'verified', 'active']], function () {

    Route::post('/change-active-program', [GlobeController::class, 'change_active_program'])->name('change_active_program');

    Route::post('/update-profile-data', [UserController::class, 'update_profile_data']);
    Route::any('/get-all-users', [UserController::class, 'get_all_users']);
    Route::post('/add-new-user', [UserController::class, 'add_new_user']);
    Route::post('/get-data-user', [UserController::class, 'get_data_user']);

    Route::post('/daily-activity', [UserController::class, 'daily_activity'])->name('daily_activity');
    Route::post('/work-plan', [UserController::class, 'work_plan'])->name('work_plan');
    Route::get('/onboarding', [UserController::class, 'onboarding']);

    Route::post('/address', [UserController::class, 'getAddress'])->name('get.address');

    Route::post('/send-invitation', [InviteController::class, 'send_invitation'])->name('invite.send');

    Route::post('/change-password', [UserController::class, 'change_password'])->name('update.password');

    Route::post('/finish-onboarding', [UserController::class, 'finish_onboarding'])->name('finish.onboarding');

    Route::post('/add-vendor', [VendorController::class, 'add_vendor'])->name('add.vendor');

    Route::get('/all-vendor-list', [VendorController::class, 'all_vendor'])->name('all.vendors');

    Route::get('/vendor-data/{vendor_id}', [VendorController::class, 'get_vendor'])->name('get.vendors');

    Route::get('/getVendorList/{program_status}', [VendorController::class, 'vendor_list'])->name('vendor.list');

    Route::post('/terminateVendor', [VendorController::class, 'terminate_vendor'])->name('terminate.vendor');

    Route::get('/info-vendor/{vendor_id}', [VendorController::class, 'info_vendor'])->name('info.vendor');

    Route::get('/site-vendor/{vendor_id}', [UserController::class, 'site_vendor'])->name('site.vendor');

    Route::get('/site-vendordata/{vendor_id}', [VendorController::class, 'site_vendor_table'])->name('site.vendortable');

    Route::get('/get-vendor', [VendorController::class, 'get_vendor_list'])->name('get.vendor');

    Route::post('/transfer-vendor', [VendorController::class, 'transfer_vendor'])->name('transfer.vendor');

    Route::post('/upload-image-file', [UserController::class, 'upload_image_file']);

});
//******************** END OF Vendor Management ********************//



///////////////////////////////////////////////////////////
//                                                       //
//                         TOWERCO                       //
//                                                       //
///////////////////////////////////////////////////////////

Route::group(['middleware' => ['auth', 'verified', 'active']], function () {

    Route::get('/get-towerco', [TowerCoController::class, 'get_towerco'])->name('get_towerco');

    Route::get('/get-towerco-all/{actor}', [TowerCoController::class, 'get_towerco_all'])->name('get_towerco_all');

    Route::get('/get-towerco-multi/{actor}', [TowerCoController::class, 'get_towerco_multi'])->name('get_towerco_multi');

    Route::get('/get-towerco-logs/{serial}', [TowerCoController::class, 'get_towerco_logs'])->name('get_towerco_logs');

    Route::get('/get-towerco/{serial_number}/{actor}', [TowerCoController::class, 'get_towerco_serial'])->name('get_towerco_serial');

    Route::post('/save-towerco', [TowerCoController::class, 'save_towerco_serial'])->name('save_towerco_serial');

    Route::post('/save-towerco-multi', [TowerCoController::class, 'save_towerco_multi'])->name('save_towerco_multi');

    Route::post('/upload-my-file-towerco', [TowerCoController::class, 'upload_my_file_towerco']);

    Route::get('/get-my-towerco-file/{serial_number}/{type}', [TowerCoController::class, 'get_my_towerco_file']);

    Route::get('/get-towerco/export', [TowerCoController::class, 'TowerCoExport'])->name('TowerCoExport');

    Route::get('/get-towerco-filter/{towerco}/{region}/{tssr_status}/{milestone_status}/{actor}', [TowerCoController::class, 'filter_towerco'])->name('filter_towerco');

});
//******************** END OF TowerCo ********************//



///////////////////////////////////////////////////////////
//                                                       //
//                       LocalCOOP                       //
//                                                       //
///////////////////////////////////////////////////////////

Route::group(['middleware' => ['auth', 'verified', 'active']], function () {

    Route::get('/localcoop/{program_id}/{profile_id}/{activity_type}', [LocalCoopController::class, 'get_localcoop'])->name('get_localcoop');
    Route::post('/update-coop-details', [LocalCoopController::class, 'update_coop_details'])->name('update_coop_details');
    Route::get('/localcoop-details-approval', [LocalCoopController::class, 'localcoop_details_approval'])->name('localcoop_details_approval');

    Route::get('/localcoop-details/{coop}', [LocalCoopController::class, 'get_localcoop_details'])->name('get_localcoop_details');
    Route::get('/approve-change-details/{id}/{status}', [LocalCoopController::class, 'approve_change_details'])->name('approve-change-details');

    Route::get('/localcoop-values/{coop}/{type}', [LocalCoopController::class, 'get_localcoop_values'])->name('get_localcoop_values');

    Route::get('/localcoop-values-data/{coop}/{type}', [LocalCoopController::class, 'get_localcoop_values_data'])->name('get_localcoop_values_data');

    Route::post('/add-coop-value', [LocalCoopController::class, 'add_coop_value']);

    Route::get('/issue-history-data/{id}', [LocalCoopController::class, 'issue_history_data']);

    Route::get('/edit-contact/{id}/{action?}', [LocalCoopController::class, 'get_contact']);

    Route::get('/localcoop-issues', [LocalCoopController::class, 'get_coop_issues']);

    Route::get('/localcoop-issues', [LocalCoopController::class, 'get_coop_issues']);

    Route::get('/localcoop-get-issue-list/{issue_type}', [LocalCoopController::class, 'get_coop_issue_list']);


});
//******************* END OF LocalCOOP *******************//



///////////////////////////////////////////////////////////
//                                                       //
//                         Unused                        //
//                                                       //
///////////////////////////////////////////////////////////


Route::group(['middleware' => ['auth', 'verified', 'active']], function () {

    Route::get('/profile-switcher/{profile_id}', [UserController::class, 'profile_switcher'])->name('profile.switcher');


});
//******************* END OF Unused *******************//



///////////////////////////////////////////////////////////
//                                                       //
//                     Multi Program                     //
//                                                       //
///////////////////////////////////////////////////////////


Route::group(['middleware' => ['auth', 'verified', 'active']], function () {

    Route::get('/', [UserController::class, 'index']);

    Route::post('/get-users-report', [UserController::class, 'get_users_report']);

    //Notifications
    Route::get('/notifications', [UserController::class, 'notifications'])->name('notifications');
    Route::get('/read-notification/{id}/{action}', [UserController::class, 'read_notifications']);

    Route::get('/my-profile', [UserController::class, 'my_profile'])->name('my_profile');

    Route::get('/activities/{agent_id?}', [UserController::class, 'activities_agent']);

    // FTTH
    Route::post('/tag-artb', [GlobeController::class, 'tag_artb'])->name('tag_artb');

    Route::get('/all-profile', [ProfileController::class, 'all_profile'])->name('all.profile');
    Route::get('/edit-profile/{id}', [ProfileController::class, 'edit_profile'])->name('edit.profile');
    Route::post('/update-profile', [ProfileController::class, 'update_profile'])->name('update.profile');
    Route::get('/get-profile', [ProfileController::class, 'get_profile'])->name('get.profile');
    Route::post('/assign-profile', [ProfileController::class, 'assign_profile'])->name('assign.profile');

    Route::get('/all-permission', [ProfileController::class, 'all_permission'])->name('all.permission');
    Route::get('/edit-permission/{permission}', [ProfileController::class, 'edit_permission'])->name('edit.permission');
    Route::post('/addupdate-permission', [ProfileController::class, 'addupdate_permission'])->name('addupdate.permission');
    Route::post('/delete-permission', [ProfileController::class, 'deletePermission'])->name('delete.permission');


    Route::post('/accept-reject-endorsement', [GlobeController::class, 'acceptRejectEndorsement'])->name('accept-reject.endorsement');

    Route::get('/forverification', [UserController::class, 'forverification_list'])->name('all.forverification');
    Route::get('/for-pending-onboarding', [UserController::class, 'forpendingonboarding_list'])->name('all.forpendingonboarding');


    Route::get('/workflow-data-proc/{program_id}', [GlobeController::class, 'getDataWorkflow'])->name('all.getDataWorkflow');

    Route::get('/unassigend-sites-data/{profile_id}/{program_id}/{activity_id}/{what_to_load}', [GlobeController::class, 'unassignedSites'])->name('all.unassignedSites');
    Route::get('/stored-proc/{profile_id}/{program_id}/{activity_id}/{what_to_load}', [GlobeController::class, 'getDataNewEndorsement'])->name('all.getDataNewEndorsement');

    Route::post('/all-agent', [GlobeController::class, 'agents'])->name('all.agent');
    Route::post('/get-user-details', [GlobeController::class, 'get_user_details']);
    Route::post('/all-vendor-admin', [GlobeController::class, 'vendor_admin'])->name('vendor_admin');
    Route::get('/all-newagent/{program_id}', [GlobeController::class, 'newagent'])->name('all.newagent');

    Route::post('/assign-agent', [GlobeController::class, 'assign_agent'])->name('assign.agent');
    Route::post('/assign-supervisor', [GlobeController::class, 'assign_supervisor'])->name('assign.supervisor');

    Route::get('/get-region', [GlobeController::class, 'get_region'])->name('get.region');
    Route::post('/get-sam-region', [GlobeController::class, 'get_sam_region']);

    // Route::get('/get-location/{location_id}/{location_type}', [GlobeController::class, 'get_location'])->name('get.location');

    Route::post('/assign-agent-site', [GlobeController::class, 'assign_agent_site'])->name('assign.agent_site');
    Route::post('/update-agent-site', [GlobeController::class, 'update_agent_site']);

    Route::get('/assigned-sites/list/{program_id}/{mode}', [GlobeController::class, 'vendor_assigned_sites'])->name('vendor_assigned_sites.list');
    Route::get('/assigned-sites/columns', [GlobeController::class, 'agent_assigned_sites_columns'])->name('agent_assigned_sites.columns');

    Route::get('/assigned-sites/{sam_id}', [UserController::class, 'view_assigned_site'])->name('view_assigned_site');


    Route::get('/table/request/{request_status}', [VendorController::class, 'getMyRequest'])->name('get.requestDate');
    Route::post('/requests/add', [VendorController::class, 'add_agent_request'])->name('add_agent_request');
    Route::post('/requests/approve-reject', [VendorController::class, 'approvereject_agent_request'])->name('approvereject_agent_request');


    Route::post('/vendor-agents', [GlobeController::class, 'vendor_agents'])->name('vendor_agents');
    Route::get('/vendor-supervisors', [GlobeController::class, 'vendor_supervisors'])->name('vendor_supervisors');
    Route::get('/vendor-employees', [GlobeController::class, 'vendor_employees'])->name('vendor_employees');

    Route::get('/get-supervisor', [ProfileController::class, 'get_supervisor']);
    Route::get('/get-agent', [ProfileController::class, 'get_agent']);


    Route::get('/get-agent-of-supervisor/{user_id}', [GlobeController::class, 'get_agent_of_supervisor']);


    ////////////////////////////////////////////////


    //Dynamic Datatable Program Columns
    Route::get('/datatables-columns/{program_id}/{table_name}/{profile_id}', [GlobeController::class, 'get_datatable_columns']);

    // Sites with documents for validation
    Route::get('/doc-validation/{program_id}', [GlobeController::class, 'get_doc_validations'])->name('doc_validations.list');

    // Sites for Approval
    Route::get('/site-approvals/{program_id}/{profile_id}/', [GlobeController::class, 'get_site_approvals'])->name('get_site_approvals.list');

    // Milestone Datatable Source
    Route::get('/site-milestones/{program_id}/{profile_id}/{activity_type}', [GlobeController::class, 'get_site_milestones'])->name('get_site_milestones.list');

    Route::post('/get-milestone-per-program', [DataController::class, 'get_milestone_per_program']);
    Route::post('/site-approvals-per-site', [DataController::class, 'site_approvals_per_site']);

    

    Route::get('/yajra-test', [GlobeController::class, 'YajraTest'])->name('YajraTest');


    Route::get('/zip-download', [DataController::class, 'zipDownload'])->name('zip-download');




    // Site issues
    Route::get('/get-site-issue-details/{issue_id}/{what_table}', [GlobeController::class, 'get_site_issues']);
    Route::get('/resolve-issue/{issue_id}', [GlobeController::class, 'resolve_issues']);

    // Create PR
    Route::post('/add-create-pr', [GlobeController::class, 'add_create_pr']);
    Route::post('/approve-reject-pr', [GlobeController::class, 'approve_reject_pr']);


    // Milestone Datatable Source - Document Validation
    Route::get('/site-doc-validation/{program_id}/{profile_id}/{activity_type}', [GlobeController::class, 'get_site_doc_validation'])->name('get_site_doc_validation.list');


    // Milestone Modal Site Status
    // Route::get('/modal-view-site-component/{sam_id}/{component}', [GlobeController::class, 'modal_view_site_components'])->name('modal_view_site_components');
    Route::post('/modal-view-site-component', [GlobeController::class, 'modal_view_site_components'])->name('modal_view_site_components');


    // Get Sub Activity Action
    // Route::get('/subactivity-view/{sam_id}/{sub_activity}/{sub_activity_id}/{program_id}/{site_category}/{activity_id}', [GlobeController::class, 'sub_activity_view'])->name('sub_activity_view');
    Route::post('/subactivity-view', [GlobeController::class, 'sub_activity_view'])->name('sub_activity_view');


    ////////////////////////////////////////////////

    // File management
    Route::get('/loi-template/{sam_id?}/{sub_activity_id?}', [GlobeController::class, 'loi_template']);
    Route::post('/download-pdf', [GlobeController::class, 'download_pdf']);
    Route::post('/upload-file', [GlobeController::class, 'fileupload']);
    Route::post('/upload-my-file', [GlobeController::class, 'upload_my_file']);
    Route::post('/get-my-uploaded-file', [GlobeController::class, 'get_my_uploade_file']);
    Route::get('/doc-validation-approvals/{id}/{action}', [GlobeController::class, 'doc_validation_approvals'])->name('doc_validation_approvals');



    
    //Form Generator
    Route::post('/get-form-generator-view', [GlobeController::class, 'get_form_generator_view'])->name('get_form_generator_view');

    //Form get
    Route::get('/get-form/{sub_activity_id}/{form_name}', [GlobeController::class, 'get_form'])->name('get_form');
    Route::post('/get-form-program-data', [GlobeController::class, 'get_form_program_data']);

    
    Route::post('/get-form-fields', [GlobeController::class, 'get_form_fields'])->name('get_form_fields');


    Route::get('/get-my-sub_act_value/{get_my_sub_act_value}/{sam_id}', [GlobeController::class, 'get_my_sub_act_value']);
    Route::post('/get-link-old-data', [GlobeController::class, 'get_link_old_data']);

    Route::get('/get-uploaded-files/{get_my_sub_act_value}/{sam_id}', [GlobeController::class, 'get_uploaded_files']);

    Route::get('/get-my-uploaded-file-data/{sub_activity_id}/{sam_id}', [GlobeController::class, 'get_my_uploade_file_data']);


    Route::post('/doc-validation-approval', [GlobeController::class, 'doc_validation_approvals']);
    Route::post('/doc-validation-approval-reviewer', [GlobeController::class, 'doc_validation_approval_reviewer']);

    // Route::post('/get-all-docs', [GlobeController::class, 'get_all_docs'])->name('get_all_docs');
    Route::post('/get-component', [ActivityController::class, 'get_component'])->name('get_component');

    Route::get('/doc-validation-approve-reject/{data_id}/{data_action}', [GlobeController::class, 'approve_reject_docs']);

    // Issue management
    Route::get('/get-issue/{issue_name}', [GlobeController::class, 'get_issue']);
    Route::get('/get-issue-callouts/{issue_name}', [GlobeController::class, 'get_issue_callouts']);
    Route::get('/get-issue/details/{issue_id}', [GlobeController::class, 'get_issue_details']);
    Route::get('/get-my-issue/{sam_id}', [GlobeController::class, 'get_my_issue']);
    Route::get('/cancel-my-issue/{issue_id}', [GlobeController::class, 'cancel_issue']);
    Route::post('/add-issue', [GlobeController::class, 'add_issue']);

    // Chat
    Route::post('/chat-send', [GlobeController::class, 'chat_send']);

    // Calendar
    Route::get('/get-my-calendar', [UserController::class, 'my_calendar']);
    Route::get('/get-my-calendar-activities', [UserController::class, 'my_calendar_activities']);



    //RTB Declaration
    Route::post('/declare-rtb', [GlobeController::class, 'declare_rtb']);
    Route::post('/approve-reject-rtb', [GlobeController::class, 'approve_reject_rtb']);

    // Lessor Engagement
    Route::post('/add-engagement', [GlobeController::class, 'save_engagement']);
    Route::get('/get-engagement/{sub_activity_id}/{sam_id}', [GlobeController::class, 'get_engagement']);

    // Get agent based on program id
    Route::get('/get-agent-based-program/{program_id}', [GlobeController::class, 'get_agent_based_program']);
    Route::get('/agent-based-program/{program_id}', [GlobeController::class, 'agent_based_program']);

    // NewSites

    // PR Memo
    Route::post('/get-pr-memo', [GlobeController::class, 'get_PRMemo']);
    Route::post('/get-new-clp-site', [GlobeController::class, 'get_new_clp_site']);
    // Route::get('/get-new-clp-site/{vendor_id}', [GlobeController::class, 'get_new_clp_site']);


    Route::post('/add-site-candidates', [GlobeController::class, 'add_site_candidates']);


    // SSDS
    Route::post('/add-ssds', [GlobeController::class, 'add_ssds']);

    Route::post('/schedule-jtss', [NewSitesController::class, 'schedule_jtss']);
    Route::get('/get-jtss-site-table/{sam_id}', [NewSitesController::class, 'get_jtss_site_table']);
    Route::get('/view-jtss-site/{id}', [NewSitesController::class, 'view_jtss_site']);
    Route::post('/set-rank-site', [NewSitesController::class, 'set_rank_site']);

    Route::get('/get-my-scheduled-jtss/{sam_id}', [NewSitesController::class, 'get_my_scheduled_jtss']);
    Route::post('/confirm-schedule', [NewSitesController::class, 'confirm_schedule']);
    Route::get('/get-my-site/{sub_activity_id}/{sam_id}', [GlobeController::class, 'get_my_site']);

    Route::get('/get-my-uploaded-site/{sub_activity_id}/{sam_id}', [GlobeController::class, 'get_my_uploaded_site']);
    Route::post('/set-approve-site', [GlobeController::class, 'set_approve_site']);


    // NEWSITES PR-PO COUNTER
    Route::get('/newsites/get-pr-po-counter', [NewSitesController::class, 'get_pr_po_counter']);

    Route::get('/newsites/get-site-by-activity-id/{activity_id}', [NewSitesController::class, 'get_site_by_activity_id']);

    Route::get('/ibs/get-site-by-activity-id/{activity_id}', [NewSitesController::class, 'ibs_get_site_by_activity_id']);

    //Site Category
    Route::post('/set-site-category', [GlobeController::class, 'set_site_category']);

    //Agent - Supervisor
    // Route::get('/get-user-data/{user_id}/{vendor_id}/{is_id}', [GlobeController::class, 'get_user_data']);
    Route::post('/get-user-data', [GlobeController::class, 'get_user_data']);
    Route::post('/update-user-data', [GlobeController::class, 'update_user_data']);


    Route::get('/change-supervisor/{user_id}/{is_id}', [GlobeController::class, 'change_supervisor']);

    //Issue Management
    Route::get('/get-site_issue_remarks/{issue_id}', [GlobeController::class, 'get_site_issue_remarks']);
    Route::post('/add-remarks', [GlobeController::class, 'add_remarks']);

    // Sub activity steo
    Route::get('/subactivity-step/{sub_activity_id}/{sam_id}/{sub_activity}', [GlobeController::class, 'subactivity_step']);
    Route::post('/submit-subactivity-step', [GlobeController::class, 'submit_subactivity_step']);

    // PR / PO
    // Route::get('/get-fiancial-analysis/{sam_id}/{vendor}', [GlobeController::class, 'get_fiancial_analysis']);
    Route::post('/get-fiancial-analysis', [GlobeController::class, 'get_fiancial_analysis']);
    Route::post('/add-pr-po', [GlobeController::class, 'add_pr_po']);
    Route::get('/get-create-pr-memo/{program_id}', [GlobeController::class, 'get_create_pr_memo']);
    Route::post('/approve-reject-pr-memo', [GlobeController::class, 'approve_reject_pr_memo']);
    Route::post('/vendor-awarding-sites', [GlobeController::class, 'vendor_awarding_sites']);

    Route::get('/remove-fiancial-analysis/{sam_id}', [GlobeController::class, 'remove_fiancial_analysis']);
    Route::get('/remove-fiancial-analysis/{sam_id}/{vendor}', [GlobeController::class, 'remove_fiancial_analysis']);

    Route::get('/get-line-items/{sam_id}/{vendor}', [GlobeController::class, 'get_line_items']);
    Route::post('/save-line-items', [GlobeController::class, 'save_line_items']);

    Route::post('/print-to-pdf-pr-po', [GlobeController::class, 'print_to_pdf_pr_po']);

    Route::get('/export/line-items/{sam_id}', [GlobeController::class, 'export_line_items']);

    Route::post('/reject-site', [GlobeController::class, 'reject_site']);

    Route::post('/add-remarks-file', [GlobeController::class, 'add_remarks_file']);
    Route::get('/get-remarks-file/{id}/{sam_id}', [GlobeController::class, 'get_remarks_file']);

    //ARTB
    Route::post('/endorse-atrb', [GlobeController::class, 'endorse_atrb']);

    Route::get('/get-coloc-filter/{site_type}/{program}/{technology}', [GlobeController::class, 'get_coloc_filter']);

    Route::get('/get-program-fields/{sam_id}/{program}', [GlobeController::class, 'get_program_fields']);


    // View PR Memo Sites
    Route::get('/get-site-memo/{value}', [GlobeController::class, 'get_site_memo']);

    // AEPM
    Route::post('/set-schedule', [GlobeController::class, 'set_schedule']);
    Route::post('/get-site-candidate', [GlobeController::class, 'get_site_candidate']);
    // Route::get('/get-site-candidate/{sam_id}/{status}', [GlobeController::class, 'get_site_candidate']);
    // Route::get('/get-jtss-schedule/{id}', [GlobeController::class, 'get_jtss_schedule']);
    Route::post('/get-jtss-schedule', [GlobeController::class, 'get_jtss_schedule']);
    Route::post('/submit-ssds', [GlobeController::class, 'submit_ssds']);
    Route::get('/get-ssds-schedule/{id}', [GlobeController::class, 'get_ssds_schedule']);

    Route::get('/get-sub-activity-value/{id}', [GlobeController::class, 'get_sub_activity_value']);
    // Route::post('/save-lease-details', [GlobeController::class, 'save_lease_details']);


    // AGENT
    Route::get('/get-agent-activity-timeline', [GlobeController::class, 'get_agent_activity_timeline']);
    Route::get('/jtss-representative/{sam_id}', [GlobeController::class, 'jtss_representative']);
    Route::post('/add-representative', [GlobeController::class, 'add_representative']);
    Route::post('/done-adding-representative', [GlobeController::class, 'done_adding_representative']);
    Route::post('/submit-ranking', [GlobeController::class, 'submit_ranking']);
    Route::post('/submit-assds', [GlobeController::class, 'submit_assds']);


    // TRAINING

    Route::get('/training/{id}', [TrainingController::class, 'index']);


    // SIGNATURE
    Route::get('/signature_pad', [SignatureController::class, 'index']);
    Route::post('/signature-pad/post', [SignatureController::class, 'store'])->name('signature_pad.store');
         
    Route::get('/get-dar-dashboard/{program_id}', [GlobeController::class, 'get_DAR_dashboard']);

    // Activities
    Route::any('/save-stage-activities-profiles', [ActivityController::class, 'save_stage_activities_profiles'])->name('save_stage_activities_profiles');
    Route::any('/save-stage-activities', [ActivityController::class, 'save_stage_activities'])->name('save_stage_activities');
    Route::get('/delete-stage-activities-profiles/{id}', [ActivityController::class, 'delete_stage_activities_profiles'])->name('delete_stage_activities_profiles');

    // ////////////////////////////// //
    //                                //
    //        DATACONTROLLER          //
    //                                //
    // ////////////////////////////// //


    // Datatable Data
    Route::get('/datatable-data/{program_id}/{profile_id}/{activity_type}', [DataController::class, 'Datatable_Data'])->name('Datatable_Data');

    
    // WORK PLAN
    Route::post('/work-plan/add', [DataController::class, 'Add_Work_Plan'])->name('Add_Work_Plan');

    // ENGAGEMENT PLAN
    Route::post('/engagement/add', [DataController::class, 'add_engagement'])->name('add_engagement');

    // GET STAGE ACTIVITIES
    Route::post('/site-ajax', [DataController::class, 'SiteAjax'])->name('SiteAjax');


    // GET DATATABLE CONTENTS
    Route::post('/get-datatable', [DataController::class, 'GetDatatable'])->name('GetDatatable');

    
    // Datatable Assigened Sites
    Route::get('/get-assigned-sites', [DataController::class, 'get_assigned_sites'])->name('get_assigned_sites');

    
    // Renewal
    Route::post('/save-loi', [RenewalController::class, 'save_loi'])->name('save_loi');
    Route::post('/create-pr-renewal', [RenewalController::class, 'create_pr'])->name('create_pr');
    Route::post('/email-loi', [RenewalController::class, 'email_loi'])->name('email_loi');
    Route::post('/email-lrn', [RenewalController::class, 'email_lrn'])->name('email_lrn');
    Route::post('/save-lrn', [RenewalController::class, 'save_lrn'])->name('save_lrn');
    Route::post('/save-elas', [RenewalController::class, 'save_elas'])->name('save_elas');
    Route::post('/save-saving-computation', [RenewalController::class, 'save_saving_computation'])->name('save_saving_computation');
    Route::post('/save-endorsment-to-sts', [RenewalController::class, 'save_endorsment_to_sts'])->name('save_endorsment_to_sts');
    Route::post('/approve-schedule-of-payment', [RenewalController::class, 'approve_schedule_of_payment'])->name('approve_schedule_of_payment');
    Route::post('/elas-approval-confirm', [RenewalController::class, 'elas_approval_confirm'])->name('elas_approval_confirm');
    Route::post('/elas-approval-confirm-sam-head', [RenewalController::class, 'elas_approval_confirm_sam_head'])->name('elas_approval_confirm_sam_head');
    Route::post('/save-commecial-negotiation', [RenewalController::class, 'save_commecial_negotiation']);
    Route::get('/get-commercial-engagement/{sub_activity_id}/{sam_id}', [RenewalController::class, 'get_commercial_engagement']);

    
    Route::post('/renewal-upload-file', [RenewalController::class, 'fileupload']);
    Route::post('/renewal-upload-my-file', [RenewalController::class, 'upload_my_file']);


    // Mobile
    Route::post('mobi/login', [ApiController::class, 'login']);
    Route::post('mobi/login2', [ApiController::class, 'login']);
    Route::post('mobi/login3', [ApiController::class, 'login']);

});
    

// PUSHER DEMO
Route::get('/notification-tester', function () {
    return view('notification-tester');
});

Route::get('send',[NotificationController::class, 'notification']);

// Route::get('test', function () {
//     event(new App\Events\StatusLiked('Guest'));
//     return "Event has been sent!";
// });



//******************* END OF Multi Program *******************//


Route::get('/elas-approval/{token}/{sam_id}/{program_id}/{site_category}/{activity_id}/{action}', [RenewalController::class, 'elas_approval'])->name('elas_approval');

Route::post('/register-user', [UserController::class, 'register_user'])->name('register.user');

Route::get('/invitation-link/{token}/{invitation_code}', [InviteController::class, 'invitation_registration'])->name('invite.link')->middleware(['invitation']);

Route::view('/team', 'team');
Route::view('/privacy', 'privacy');

//ROUTE TO SLUG
//USERCONTROLLER WILL TAKE OVER THE ROUTING

$uri = Request::path();

if ($uri != 'api/send-invitation-vendor') {
    Route::get('/{slug}', [UserController::class, 'show'])
        ->where('slug', '.*')
        ->middleware(['auth', 'verified']);
}




