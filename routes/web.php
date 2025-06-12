<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
//////////////////////////////////////////////////////////////////
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MailContentController;
use App\Http\Controllers\Admin\LeadController;
//////////////////////////////////////////////////////////////////
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\InvestorController;
use App\Http\Controllers\User\PartnerUserController;
use App\Http\Controllers\User\PartnerPropertyController;

/////////////////////////////////////////////////////////////////

Route::get('/', function () {
    return view('user.login');
});

Route::get('logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::get('investor-login', function () {
    return view('user.login');
})->name('login');
Route::post('investor-login/auth', [AuthController::class, 'login'])->name('user.login');


Route::middleware(['UserAuth'])->prefix('investor')->group(function () {
    Route::controller(InvestorController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/dashboard', 'index')->name('UserDashboard');
    });
    // User Main List
    Route::controller(PartnerUserController::class)->group(function () {
        Route::get('add-user', 'add_user')->name('User.AddUser')->middleware('CheckPermission:add_user');
        Route::post('save-user', 'save_user')->name('User.SaveUser')->middleware('CheckPermission:add_user');
        Route::get('user-list', 'user_list')->name('User.UserList')->middleware('CheckPermission:edit_user,delete_user');
        Route::post('user-search', 'user_search')->name('User.UserSearch')->middleware('CheckPermission:edit_user,delete_user');
        Route::get('delete-user/{uid}', 'delete_user')->name('User.DeleteUser')->middleware('CheckPermission:delete_user');
        Route::get('edit-user/{uid}', 'edit_user')->name('User.EditUser')->middleware('CheckPermission:edit_user');
        Route::post('update-user', 'update_user')->name('User.UpdateUser')->middleware('CheckPermission:edit_user');

        //Under Admin User Personal Report 
        Route::get('add-user-personal-report', 'add_user_personal_report')->name('User.UserPersonalReport')->middleware('CheckPermission:upload_personal_reports');
        Route::post('save-user-personal-report', 'save_user_personal_report')->name('User.SaveUserPersonalReport')->middleware('CheckPermission:upload_personal_reports');
        Route::get('view-user-personal-report', 'view_user_personal_report')->name('User.ViewUserPersonalReport');

        Route::get('change-password', 'change_password')->name('User.ChangePassword');
        Route::post('update-password', 'update_password')->name('User.UpdatePassword');
    });
    Route::controller(PartnerPropertyController::class)->group(function () {
        // Property List
        Route::get('add-property', 'add_property')->name('User.AddProperty')->middleware('CheckPermission:add_property');
        Route::post('get-subcategories', 'get_subcategories')->name('User.GetSubCategories')->middleware('CheckPermission:add_property');
        Route::post('save-property', 'save_property')->name('User.SaveProperty')->middleware('CheckPermission:add_property');
        Route::get('property-list', 'property_list')->name('User.PropertyList')->middleware('CheckPermission:add_property,edit_property,delete_property');
        Route::get('delete-property/{pid}', 'delete_property')->name('User.DeleteProperty')->middleware('CheckPermission:delete_property');
        Route::get('edit-property/{pid}', 'edit_property')->name('User.EditProperty')->middleware('CheckPermission:edit_property');
        Route::post('update-property', 'update_property')->name('User.UpdateProperty')->middleware('CheckPermission:edit_property');

        // Property Monthly Report
        Route::get('add-property-monthly-report', 'add_property_monthly_report')->name('User.PropertyMonthlyReport')->middleware('CheckPermission:add_monthly_report');
        Route::post('save-property-monthly-report', 'save_property_monthly_report')->name('User.SavePropertyMonthlyReport')->middleware('CheckPermission:add_monthly_report');
        Route::post('get-user-properties', 'get_user_properties')->name('User.GetUserProperties');
        Route::match(['get', 'post'], 'property-monthly-report-list', 'property_monthly_report_list')->name('User.PropertyMonthlyReportList');
    });
});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                            Admin Routes Start                                                 //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('admin-login', function () {
    return view('admin.admin-login');
})->name('AdminLogin');

Route::controller(LoginController::class)->group(function () {
    Route::post('admin-login', 'admin_login')->name('AuthAdminLogin');
});

Route::middleware(['AdminAuth'])->prefix('admin')->group(function () {

    /* ====================== Admin Routes Start =================== */
    Route::controller(AdminController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('dashboard', 'index')->name('AdminDashboard');
    });
    /* ====================== Admin Routes End =================== */

    /* ====================== Category Routes Start ==================== */
    Route::controller(CategoryController::class)->group(function () {
        Route::get('add-category', 'add_category')->name('Admin.AddCategory');
        Route::post('save-category', 'save_category')->name('Admin.SaveCategory');
        Route::post('save-subcategory', 'save_subcategory')->name('Admin.SaveSubCategory');
        Route::get('all-category', 'all_category')->name('Admin.AllCategory');
        Route::post('edit-category', 'edit_category')->name('Admin.EditCategory');
        Route::get('delete-category/{cid}', 'delete_category')->name('Admin.DeleteCategory');
    });
    /* ====================== Category Routes End ================= */

    /* ====================== Category Routes Start ==================== */
    Route::controller(PropertyController::class)->group(function () {
        // Property List
        Route::get('add-property', 'add_property')->name('Admin.AddProperty');
        Route::post('get-subcategories', 'get_subcategories')->name('Admin.GetSubCategories');
        Route::post('save-property', 'save_property')->name('Admin.SaveProperty');
        Route::get('property-list', 'property_list')->name('Admin.PropertyList');
        Route::get('delete-property/{pid}', 'delete_property')->name('Admin.DeleteProperty');
        Route::get('edit-property/{pid}', 'edit_property')->name('Admin.EditProperty');
        Route::post('update-property', 'update_property')->name('Admin.UpdateProperty');
        Route::get('set-property-order', 'set_property_order')->name('Admin.SetPropertyOrder');
        Route::post('update-property-order', 'update_property_order')->name('Admin.UpdatePropertyOrder');

        // Property Monthly Report
        Route::get('add-property-monthly-report', 'add_property_monthly_report')->name('Admin.PropertyMonthlyReport');
        Route::post('save-property-monthly-report', 'save_property_monthly_report')->name('Admin.SavePropertyMonthlyReport');
        Route::match(['get', 'post'], 'property-monthly-report-list', 'property_monthly_report_list')->name('Admin.PropertyMonthlyReportList');
        Route::get('delete-property-monthly-report/{pid}', 'delete_property_monthly_report')->name('Admin.DeletePropertyMonthlyReport');

        //Rehab Progress
        Route::get('add-property-rehab-progress', 'add_property_rehab_progress')->name('Admin.AddPropertyRehabProgress');
        Route::post('save-property-rehab-progress', 'save_property_rehab_progress')->name('Admin.SavePropertyRehabProgress');
        Route::get('new-rehab-progress', 'new_rehab_progress')->name('Admin.NewRehabProgress');
        Route::post('save-rehab-progress', 'save_rehab_progress')->name('Admin.SaveRehabProgress');
        Route::match(['get', 'post'], 'rehab-progress-list', 'rehab_progress_list')->name('Admin.RehabProgressList');
        Route::get('delete-rehab-progress/{rid}', 'delete_rehab_progress')->name('Admin.DeleteRehabProgress');
        Route::get('edit-rehab-progress/{rid}', 'edit_rehab_progress')->name('Admin.EditRehabProgress');
        Route::post('update-rehab-progress', 'update_rehab_progress')->name('Admin.UpdateRehabProgress');
        Route::get('delete-rehab-progress-image/{iid}', 'delete_rehab_progress_image')->name('Admin.DeleteRehabProgressImage');
    });
    /* ====================== Category Routes End ================= */

    /* ====================== Mail Content Routes Start ==================== */
    Route::controller(MailContentController::class)->group(function () {
        Route::get('mail-content', 'mail_content')->name('Admin.MailContent');
        Route::post('save-mail-content', 'save_mail_content')->name('Admin.SaveMailContent');
    });
    /* ====================== Mail Content Routes Start End ==================== */

    /* ====================== Under Admin Users Routes Start ==================== */
    Route::controller(UserController::class)->group(function () {

        // get user properties via helper
        Route::post('get-user-properties', 'get_user_properties')->name('Admin.GetUserProperties');

        //Under Admin  User Main List
        Route::get('add-user', 'add_user')->name('Admin.AddUser');
        Route::post('save-user', 'save_user')->name('Admin.SaveUser');
        Route::get('user-list', 'user_list')->name('Admin.UserList');
        Route::post('user-search', 'user_search')->name('Admin.UserSearch');
        Route::get('delete-user/{uid}', 'delete_user')->name('Admin.DeleteUser');
        Route::get('edit-user/{uid}', 'edit_user')->name('Admin.EditUser');
        Route::post('update-user', 'update_user')->name('Admin.UpdateUser');
        Route::match(['GET', 'POST'], 'user-summary-report', 'user_summary_report')->name('Admin.UserSummaryReport');
        Route::get('user-summary-export', 'user_summary_export')->name('Admin.UserSummaryExport');

        Route::get('user-permission/{uid}', 'user_permission')->name('Admin.UserPermission');
        Route::post('user-permission/update', 'user_permission_update')->name('Admin.UserPermission.Update');

        //Under Admin User Personal Report
        Route::get('add-user-personal-report', 'add_user_personal_report')->name('Admin.UserPersonalReport');
        Route::post('save-user-personal-report', 'save_user_personal_report')->name('Admin.SaveUserPersonalReport');
        Route::match(['get', 'post'], 'view-user-personal-report', 'view_user_personal_report')->name('Admin.ViewUserPersonalReport');
        Route::get('delete-user-personal-report/{rid}', 'delete_user_personal_report')->name('Admin.DeleteUserPersonalReport');

        Route::get('change-password', 'change_password')->name('Admin.ChangePassword');
        Route::post('update-password', 'update_password')->name('Admin.UpdatePassword');
    });
    /* ======================Under Admin Users Routes End ==================== */

    Route::controller(LeadController::class)->group(function () {
        Route::get('add-lead', 'add_lead')->name('Admin.AddLead');
        Route::post('save-lead', 'save_lead')->name('Admin.SaveLead');
        Route::get('lead-list', 'lead_list')->name('Admin.LeadList');
        Route::get('view-lead/{lid}', 'view_lead')->name('Admin.ViewLead');
        Route::get('delete-lead/{lid}', 'delete_lead')->name('Admin.DeleteLead');
        Route::get('edit-lead/{lid}', 'edit_lead')->name('Admin.EditLead');
        Route::get('delete-lead-image/{iid}', 'delete_lead_image')->name('Admin.DeleteLeadImage');
        Route::post('update-lead', 'update_lead')->name('Admin.UpdateLead');
        Route::post('add-new-note', 'add_new_note')->name('Admin.AddNewNote');
    });
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                              Admin Routes End                                              //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////