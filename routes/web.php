<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GlobeController;

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

//ROUTE TO USER'S HOME
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/activities/{agent_id?}', [UserController::class, 'activities_agent']);
    Route::get('/', [UserController::class, 'index']);
    Route::get('/onboarding', [UserController::class, 'onboarding']);
    Route::post('/address', [UserController::class, 'getAddress'])->name('get.address');
    Route::post('/send-invitation', [InviteController::class, 'send_invitation'])->name('invite.send');
    Route::post('/change-password', [UserController::class, 'change_password'])->name('update.password');
    Route::post('/finish-onboarding', [UserController::class, 'finish_onboarding'])->name('finish.onboarding');
    Route::get('/profile-switcher/{profile_id}', [UserController::class, 'profile_switcher'])->name('profile.switcher');
    Route::post('/upload-image-file', [UserController::class, 'upload_image_file']);

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

    Route::get('/all-agent/{program_id}', [GlobeController::class, 'agents'])->name('all.agent');
    Route::get('/all-newagent/{program_id}', [GlobeController::class, 'newagent'])->name('all.newagent');

    Route::post('/assign-agent', [GlobeController::class, 'assign_agent'])->name('assign.agent');

    Route::get('/get-region', [GlobeController::class, 'get_region'])->name('get.region');
    
    Route::get('/get-location/{location_id}/{location_type}', [GlobeController::class, 'get_location'])->name('get.location');

    Route::post('/assign-agent-site', [GlobeController::class, 'assign_agent_site'])->name('assign.agent_site');

    Route::get('/assigned-sites/list/{program_id}/{mode}', [GlobeController::class, 'vendor_assigned_sites'])->name('vendor_assigned_sites.list');
    Route::get('/assigned-sites/columns', [GlobeController::class, 'agent_assigned_sites_columns'])->name('agent_assigned_sites.columns');

    Route::get('/assigned-sites/{sam_id}', [UserController::class, 'view_assigned_site'])->name('view_assigned_site');
    

    Route::get('/table/request/{request_status}', [VendorController::class, 'getMyRequest'])->name('get.requestDate');
    Route::post('/requests/add', [VendorController::class, 'add_agent_request'])->name('add_agent_request');
    Route::post('/requests/approve-reject', [VendorController::class, 'approvereject_agent_request'])->name('approvereject_agent_request');


    Route::get('/vendor-agents', [GlobeController::class, 'vendor_agents'])->name('vendor_agents');
    Route::get('/vendor-supervisors', [GlobeController::class, 'vendor_supervisors'])->name('vendor_supervisors');
    
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


    // Milestone Datatable Source - Document Validation
    Route::get('/site-doc-validation/{program_id}/{profile_id}/{activity_type}', [GlobeController::class, 'get_site_doc_validation'])->name('get_site_doc_validation.list');


    // Milestone Modal Site Status
    Route::get('/modal-view-site-component/{sam_id}/{component}', [GlobeController::class, 'modal_view_site_components'])->name('modal_view_site_components');


    ////////////////////////////////////////////////

    // File management
    Route::get('/loi-template/{sam_id?}/{sub_activity_id?}', [GlobeController::class, 'loi_template']);
    Route::post('/download-pdf', [GlobeController::class, 'download_pdf']);
    Route::post('/upload-file', [GlobeController::class, 'fileupload']);
    Route::post('/upload-my-file', [GlobeController::class, 'upload_my_file']);
    Route::post('/get-my-uploaded-file', [GlobeController::class, 'get_my_uploade_file']);
    Route::get('/doc-validation-approvals/{id}/{action}', [GlobeController::class, 'doc_validation_approvals'])->name('doc_validation_approvals');

    
    Route::get('/get-my-uploaded-file-data/{sub_activity_id}/{sam_id}', [GlobeController::class, 'get_my_uploade_file_data']);

    
    Route::post('/doc-validation-approval', [GlobeController::class, 'doc_validation_approvals']);

    Route::post('/get-all-docs', [GlobeController::class, 'get_all_docs'])->name('get_all_docs');

    Route::get('/doc-validation-approve-reject/{data_id}/{data_action}', [GlobeController::class, 'approve_reject_docs']);

    // Issue management
    Route::get('/get-issue/{issue_name}', [GlobeController::class, 'get_issue']);
    Route::get('/get-issue/details/{issue_id}', [GlobeController::class, 'get_issue_details']);
    Route::get('/get-my-issue/{sam_id}', [GlobeController::class, 'get_my_issue']);
    Route::get('/cancel-my-issue/{issue_id}', [GlobeController::class, 'cancel_issue']);
    Route::post('/add-issue', [GlobeController::class, 'add_issue']);

    // Chat
    Route::post('/chat-send', [GlobeController::class, 'chat_send']);

    // Calendar
    Route::get('/get-my-calendar', [UserController::class, 'my_calendar']);

    //RTB Declaration
    Route::post('/declare-rtb', [GlobeController::class, 'declare_rtb']);
    Route::post('/approve-reject-rtb', [GlobeController::class, 'approve_reject_rtb']);
    
    // Lessor Engagement
    Route::post('/add-engagement', [GlobeController::class, 'save_engagement']);
    Route::get('/get-engagement', [GlobeController::class, 'get_engagement']);

    // Get agent based on program id
    Route::get('/get-agent-based-program/{program_id}', [GlobeController::class, 'get_agent_based_program']);
    
});

Route::post('/register-user', [UserController::class, 'register_user'])->name('register.user');

Route::get('/invitation-link/{token}/{invitation_code}', [InviteController::class, 'invitation_registration'])->name('invite.link')->middleware(['invitation']);

Route::view('/team', 'team');

//ROUTE TO SLUG 
//USERCONTROLLER WILL TAKE OVER THE ROUTING 

Route::get('/{slug}', [UserController::class, 'show'])
    ->where('slug', '.*')
    ->middleware(['auth', 'verified']);

