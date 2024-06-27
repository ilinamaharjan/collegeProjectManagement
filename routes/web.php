<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\LeadSettingController;
use App\Http\Controllers\LeadActivityController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\CustomerSettingController;
use App\Http\Controllers\EmailSettingController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\LeadFileController;
use App\Http\Controllers\LeadFileTypeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\RoleAndPermissionController;
use App\Http\Controllers\TaskController;
use App\Models\EmailSetting;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/disable-user', function () {
    if(auth()->user() && auth()->user()->status==0){
        return view('disableUser');
    }else{
        return redirect('/');
    }
});

Route::get('email-verify/{user}', [EmailVerificationController::class, 'verifyEmail'])->name('verifyEmail');
Auth::routes();
Route::get('/download-lead-file/{file}', [LeadFileController::class, 'download'])->name('lead_file.download');

// Route::name('leadfiletype.')->group(function () {
//     Route::controller(LeadFileTypeController::class)->group(function () {
//         Route::get('create', 'create')->name('create');
//     });
// });
Route::get('/leadfiletype_View', [LeadFileTypeController::class, 'index'])->name('leadfiletype.index');
Route::post('/leadfiletype_store', [LeadFileTypeController::class, 'store'])->name('leadfiletype.store');

Route::group(['middleware' => ['prevent-back-history','user-disable']], function () {
    Route::post('/verify-password', [HomeController::class, 'verifyPassword'])->name('verifyPassword');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('changePassword');
    Route::name('home.')->group(function () {
        Route::controller(HomeController::class)->group(function () {
            Route::get('/home', 'index')->name('home')->middleware(['can:Admin|Dashboard']);
            Route::get('/company', 'company')->name('company')->middleware(['can:View|Company']);
            Route::get('/profile', 'profile')->name('profile');
            Route::get('/logout', 'logout')->name('logout');
            Route::get('view-package', 'viewpackage')->name('viewpackage')->middleware(['can:View|Package']);
            Route::get('/package', 'package')->name('package')->middleware(['can:View|Package']);
            Route::get('/lead', 'lead')->name('lead')->middleware(['can:View|Lead']);
            Route::get('/customer', 'customer')->name('customer')->middleware(['can:View|Customer']);
            Route::get('/customer-all', 'customerAll')->name('customerAll')->middleware(['can:ViewAll|Customer']);
            Route::get('/customer-lead-details/{id}', 'customerDetails')->name('customerDetails')->middleware(['can:ViewDetails|Customer']);
            Route::get('/customer-lead-status-details/{id}', 'dealStatusDetail')->name('dealStatusDetail')->middleware(['can:View|Lead']);
            Route::get('/role', 'role')->name('role')->middleware(['can:View|Role']);
            Route::get('/project-manager', 'projectManager')->name('pm');
            // Route::get('/organization', 'organization')->name('organization');
        });
    });
    Route::name('ajax.')->group(function () {
        Route::controller(AjaxController::class)->group(function () {
            Route::post('store-user', 'storeUser')->name('storeUser');
            Route::post('update-lead', 'updateLead')->name('updateLead');
            Route::post('update-task', 'updateTask')->name('updateTask');
            Route::post('store-settings', 'storeStatusSetting')->name('storeStatusSetting');
            Route::post('update-activity-status', 'changeActivityStatus')->name('changeActivityStatus');
            Route::get('get-settings/{category}', 'getStatusSetting')->name('getStatusSetting');
            Route::post('get-lead-files', 'getLeadFiles')->name('getLeadFiles');
            Route::get('get-lead-status/{id}', 'getLeadStatus')->name('getLeadStatus');
            Route::get('get-contacts/{organization}', 'getContacts')->name('getContacts');
            Route::get('get-dropdown/{word}', 'getDropdown')->name('getDropdown');
            Route::get('get-dropdown2/{word}', 'getDropdown2')->name('getDropdown2');
            Route::get('get-tasks/{category}', 'getTask')->name('getTask');
            Route::get('get-notifications', 'getNotifications')->name('getNotifications');
            Route::get('get-notifications-detail/{id}', 'getNotificationDetails')->name('getNotificationDetails');
            Route::post('get-assignee-tasks', 'getAssigneesTask')->name('getAssigneesTask');
            Route::post('store-task-time', 'storeTaskLog')->name('storeTaskLog');
        });
    });

    Route::name('lead_setting.')->group(function () {
        Route::controller(LeadSettingController::class)->group(function () {
            Route::get('lead-setting', 'index')->name('index')->middleware(['can:View|Lead Status Setting']);
            Route::get('create-lead-setting', 'create')->name('create')->middleware(['can:Create|Lead Status Setting']);
            Route::post('/store-lead-setting', 'store')->name('store')->middleware(['can:Create|Lead Status Setting']);
        });
    });


    Route::name('lead.')->group(function () {
        Route::controller(LeadController::class)->group(function () {
            Route::get('index', 'index')->name('index')->middleware(['can:View|Lead']);
            Route::get('create', 'create')->name('create')->middleware(['can:Create|Lead']);
            Route::get('lead-convert/{lead}', 'convert')->name('convert');
            Route::post('/store-leads', 'store')->name('store')->middleware(['can:Create|Lead']);
            Route::get('/leadprofile/{id}', 'leadprofile')->name('leadprofile')->middleware(['can:View|Lead']);
        });
    });
    Route::name('task.')->group(function () {
        Route::controller(TaskController::class)->group(function () {
            Route::post('/store-tasks', 'store')->name('store');
            Route::get('/taskprofile/{id}', 'taskprofile')->name('taskprofile');
            Route::get('/assignee/{id}', 'getAssignee')->name('getAssignee');
            Route::post('/assign-users', 'assignUser')->name('assignUser');
            Route::post('/change-task-status', 'changeStatus')->name('changeStatus');
            Route::post('/update-task-description', 'updateDescription')->name('updateDescription');
            Route::post('/store-sub-task', 'storeSubTask')->name('storeSubTask');
        });
    });
    Route::name('lead_activity.')->group(function () {
        Route::controller(LeadActivityController::class)->group(function () {
            Route::post('/store-lead-activity', 'store')->name('store')->middleware(['can:Create|Lead Activity']);
        });
    });
    Route::name('lead_file.')->group(function () {
        Route::controller(LeadFileController::class)->group(function () {
            Route::post('/store-lead-file', 'store')->name('store')->middleware(['can:Create|Lead File']);
            Route::post('/link-activity', 'linkActivity')->name('linkActivity');
        });
    });

    Route::name('customer_setting.')->group(function () {
        Route::controller(CustomerSettingController::class)->group(function () {
            Route::get('customer-setting', 'index')->name('index')->middleware(['can:View|Customer Status Setting']);
            Route::get('create-customer-setting', 'create')->name('create')->middleware(['can:Create|Customer Status Setting']);
            Route::post('/store-customer-setting', 'store')->name('store')->middleware(['can:Create|Customer Status Setting']);
        });
    });
    Route::name('custom_field.')->group(function () {
        Route::controller(CustomFieldController::class)->group(function () {
            Route::get('view-custom-fields/{field_type}', 'index')->name('index');
            Route::get('create-custom-fields/{type_id}', 'create')->name('create');
            Route::post('store-custom-fields', 'store')->name('store');
        });
    });


    Route::name('organization.')->group(function () {
        Route::controller(OrganizationController::class)->group(function () {
            Route::get('view-organization', 'index')->name('index')->middleware(['can:View|Contact Organization']);
            Route::get('view-all-contact', 'getAllContact')->name('getAllContact')->middleware(['can:View|Contact Organization']);
            Route::get('view-organization-all-contact', 'indexAllView')->name('indexAllView')->middleware(['can:ViewAll|Contact Organization']);
            Route::get('organization-review/{id}', 'review')->name('review');
            Route::get('create-organization', 'create')->name('create')->middleware(['can:Create|Contact Organization']);
            Route::post('store-organization', 'store')->name('store')->middleware(['can:Create|Contact Organization']);
            Route::get('show-organization/{organization}', 'showModal')->name('showModal')->middleware(['can:View|Contact Organization']);
            Route::get('edit-organization/{contact}', 'updateModal')->name('updateModal')->middleware(['can:Update|Contact Organization']);
            Route::get('add-organization/{contact}', 'addContactOrganization')->name('addContactOrganization')->middleware(['can:Update|Contact Organization']);
            Route::post('update-organization/', 'update')->name('update')->middleware(['can:Update|Contact Organization']);
            Route::get('checkbothdata-organization', 'checkbothdata')->name('checkbothdata');
            Route::post('add-contact-organization', 'contactStore')->name('contactStore');
            Route::post('add-organization-contact', 'organizationContactStore')->name('organizationContactStore');
            Route::get('delete-organization-contact/{id}', 'delete')->name('delete');
            Route::get('delete-organization-secondary-contact', 'secondaryContactDelete')->name('secondaryContactDelete');
        });
    });
    // Route::get('checkbothdata', [OrganizationController::class, 'checkbothdata'])->name('organization.checkbothdata');

    Route::name('email_settings.')->group(function (){
        Route::controller(EmailSettingController::class)->group(function(){
            Route::post('store-email-settings','store')->name('store');
        });
    });

    Route::name('contact.')->group(function () {
        Route::controller(\App\Http\Controllers\ContactController::class)->group(function () {
            Route::get('view-contacts', 'index')->name('index')->middleware(['can:View|Contact Person']);
            Route::get('create-contacts', 'create')->name('create')->middleware(['can:Create|Contact Person']);
            Route::post('store-contacts', 'store')->name('store')->middleware(['can:Create|Contact Person']);
            Route::get('show-contacts/{contact}', 'showModal')->name('showModal')->middleware(['can:View|Contact Person']);
            Route::get('edit-contact/{contact}', 'updateModal')->name('updateModal')->middleware(['can:Update|Contact Person']);
            Route::get('delete-contact/{contact}', 'disable')->name('disable')->middleware(['can:Delete|Contact Person']);
            Route::post('update-contact/', 'update')->name('update')->middleware(['can:Update|Contact Person']);
            Route::post('import-excel-contact/', 'uploadContactExcel')->name('uploadContactExcel');
            Route::get('export-excel-contact/', 'downloadContactExcel')->name('downloadContactExcel');
        });
    });

    Route::name('company.')->group(function () {
        Route::controller(CompanyController::class)->group(function () {
            Route::get('view-companies', 'viewCompanies')->name('viewCompanies')->middleware(['can:View|Company']);
            Route::get('display-company/{id}', 'viewOwnCompany')->name('viewOwnCompany')->middleware(['can:View|Company']);
            Route::get('/create-company', 'create')->name('create')->middleware(['can:Create|Company']);
            Route::get('/update-modal/{company}', 'updateModal')->name('phdateModal')->middleware(['can:Update|Company']);
            Route::get('/delete-company/{company}', 'delete')->name('delete')->middleware(['can:Delete|Company']);
            Route::post('/store-company', 'store')->name('store')->middleware(['can:Create|Company']);
            Route::post('/store-companyAjax', 'storeAjax')->name('storeAjax');
            Route::post('/update-company', 'update')->name('update')->middleware(['can:Update|Company']);
        });
    });

    Route::name('department.')->group(function () {
        Route::controller(\App\Http\Controllers\DepartmentController::class)->group(function () {
            Route::get('view-departments', 'viewdepartments')->name('viewdepartments')->middleware(['can:View|Company']);
//            Route::get('display-company/{id}', 'viewOwnCompany')->name('viewOwnCompany')->middleware(['can:View|Company']);
//            Route::get('/create-company', 'create')->name('create')->middleware(['can:Create|Company']);
//            Route::get('/update-modal/{company}', 'updateModal')->name('phdateModal')->middleware(['can:Update|Company']);
//            Route::get('/delete-company/{company}', 'delete')->name('delete')->middleware(['can:Delete|Company']);
//            Route::post('/store-company', 'store')->name('store')->middleware(['can:Create|Company']);
//            Route::post('/store-companyAjax', 'storeAjax')->name('storeAjax');
//            Route::post('/update-company', 'update')->name('update')->middleware(['can:Update|Company']);
        });
    });
    Route::name('profile.')->group(function () {
        Route::controller(ProfileController::class)->group(function () {
            Route::post('/update-profile', 'update')->name('update');
            Route::get('/user-setup/{company}', 'userPage')->name('userPage');
        });
    });
    Route::name('package.')->group(function () {
        Route::controller(PackageController::class)->group(function () {
            Route::post('/store', 'store')->name('store')->middleware(['can:Create|Package']);
            Route::get('/configure', 'configure')->name('configure');
            Route::post('/update-package', 'update')->name('update')->middleware(['can:Update|Package']);
            Route::get('/package-list', 'index')->name('index')->middleware(['can:View|Package']);
            Route::get('view-package', 'viewpackage')->name('viewpackage')->middleware(['can:View|Package']);
            Route::get('/get-modules/{id}', 'getModules')->name('getModules');
            Route::get('/delete-package/{package}', 'delete')->name('delete')->middleware(['can:Delete|Package']);
            Route::get('/package-update-modal/{package}', 'updateModal')->name('updateModal')->middleware(['can:Update|Package']);
            Route::get('/package-show-modal/{package}', 'showModal')->name('showModal')->middleware(['can:View|Package']);
        });
    });
    Route::name('role.')->prefix('/role')->group(function () {
        Route::controller(RoleAndPermissionController::class)->group(function () {
            Route::get('getAllRoles','getAllRoles')->name('getAllRoles');
            Route::get('/create', 'create')->name('create')->middleware(['can:Create|Role']);
            Route::post('/store', 'store')->name('store')->middleware(['can:Create|Role']);
            Route::get('/edit/{id}', 'edit')->name('edit')->middleware(['can:Update|Role']);
            Route::get('/user-permission/{id}', 'userPermissionEdit')->name('userEdit')->middleware(['can:View|User Management']);
            Route::post('/user-permission-update/{id}', 'userPermissionUpdate')->name('userPermissionUpdate')->middleware(['can:View|User Management']);
            Route::post('/update/{id}', 'update')->name('update')->middleware(['can:Update|Role']);
            Route::get('/delete/{id}', 'delete')->name('delete')->middleware(['can:Delete|Role']);
            Route::get('/view-permission-of-role/{role}', 'viewPermissionOfRole')->name('viewPermissionOfRole')->middleware(['can:View|Role']);
        });
    });
    Route::name('user_management.')->prefix('/user-management')->group(function () {
        Route::controller(UserManagementController::class)->group(function () {
            Route::get('getAllUsers','getAllUsers')->name('getAllUsers')->middleware(['can:View|User Management']);
            Route::get('index', 'index')->name('index')->middleware(['can:View|User Management']);
            Route::get('/create', 'create')->name('create')->middleware(['can:Create|User Management']);
            Route::get('/edit/{id}', 'create')->name('edit')->middleware(['can:Update|User Management']);
            Route::post('/store', 'store')->name('store')->middleware(['can:Create|User Management']);
            Route::get('/get-ajax-permission', 'getPermission')->name('getPermission');
            Route::get('/view-permission-user/{user}', 'viewPermissionOfUser')->name('viewPermissionOfUser');
            Route::get('/get-ajax-permission-edit', 'getPermissionUpdate')->name('getPermissionUpdate');
            Route::get('/delete/{id}', 'delete')->name('delete')->middleware(['can:Delete|User Management']);
            Route::get('/edit-user-info/{user}', 'userInfoEdit')->name('userInfoEdit')->middleware(['can:Update|User Management']);
            Route::post('/update-user-info', 'updateUser')->name('updateUser')->middleware(['can:Update|User Management']);
            Route::get('/update-user-status', 'userStatusUpdate')->name('userStatusUpdate')->middleware(['can:Update|User Management']);
        });
    });
    Route::name('lead_note.')->prefix('/lead-note')->group(function () {
        Route::controller(NoteController::class)->group(function () {
            Route::post('/store', 'store')->name('store');
        });
    });
});
