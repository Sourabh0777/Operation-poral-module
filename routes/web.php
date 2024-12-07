<?php

use App\Http\Controllers\Homecontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\Mastercontroller;
use App\Http\Controllers\Marketingcontroller;
use App\Http\Controllers\Reports;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/emp-leave-request',[Usercontroller::class,'emp_leave_request'])->name('emp-leave-request')->middleware('auth');
Route::post('/save-leave-request',[Usercontroller::class,'save_leave_request'])->name('save-leave-request')->middleware('auth');

Route::get('/',[Usercontroller::class,'login'])->name('login');

Route::get('/get-hrm-data',[Usercontroller::class,'get_hrm_data'])->name('get-hrm-data');

Route::get('/testing',[Usercontroller::class,'testing'])->name('testing');
Route::post('/post-login',[Usercontroller::class,'post_login'])->name('post-login');
Route::get('/dashboard',[Usercontroller::class,'dashboard'])->name('dashboard')->middleware('auth');
Route::get('/locations',[Mastercontroller::class,'locations'])->name('locations')->middleware('auth');
Route::get('/delete-location/{id}',[Mastercontroller::class,'delete_location'])->name('delete-location')->middleware('auth');
Route::post('/save-location',[Mastercontroller::class,'save_location'])->name('save-location')->middleware('auth');
Route::get('/logout',[Usercontroller::class,'logout'])->name('logout');

Route::get('/employee-list',[Usercontroller::class,'employee_list'])->name('employee-list')->middleware('auth');
Route::get('/team-structure',[Usercontroller::class,'team_structure'])->name('team-structure')->middleware('auth');
Route::get('/edit-employee/{id}',[Usercontroller::class,'edit_employee'])->name('edit-employee')->middleware('auth');
Route::post('/save-employee',[Usercontroller::class,'save_employee'])->name('save-employee')->middleware('auth');
Route::get('/client-list',[Usercontroller::class,'Client_list'])->name('client-list')->middleware('auth'); 
Route::post('/save-client',[Usercontroller::class,'save_client'])->name('save-client')->middleware('auth');
Route::post('/load-client-info',[Usercontroller::class,'load_client_info'])->name('load-client-info')->middleware('auth');
Route::post('/update-client',[Usercontroller::class,'update_client'])->name('update-client')->middleware('auth');
Route::post('/delete-client-info',[Usercontroller::class,'delete_client_info'])->name('delete-client-info')->middleware('auth');
Route::post('/delete-employee',[Usercontroller::class,'delete_employee'])->name('delete-employee')->middleware('auth');
Route::post('/load-emp-data',[Usercontroller::class,'load_emp_data'])->name('load-emp-data')->middleware('auth');
Route::post('/update-employee',[Usercontroller::class,'update_employee'])->name('update-employee')->middleware('auth');
Route::post('/assign-job-to-writer',[Usercontroller::class,'assign_job_to_writer'])->name('assign-job-to-writer')->middleware('auth');
Route::get('/writer-job-list',[Usercontroller::class,'writer_job_list'])->name('writer-job-list')->middleware('auth');
Route::post('/update-job-form',[Usercontroller::class,'update_job_form'])->name('update-job-form')->middleware('auth'); 
Route::get('/start-job/{id}',[Usercontroller::class,'start_job'])->name('start-job')->middleware('auth');
Route::get('/stop-job/{id}',[Usercontroller::class,'stop_job'])->name('stop-job')->middleware('auth');
Route::get('/see-the-progress/{id}',[Usercontroller::class,'see_the_progress'])->name('see-the-progress')->middleware('auth'); 
Route::get('/job-calender-view',[Usercontroller::class,'job_calender_view'])->name('job-calender-view')->middleware('auth'); 
Route::get('/leave-view',[Usercontroller::class,'leave_view'])->name('leave-view')->middleware('auth'); 
Route::post('/set-rework-word',[Usercontroller::class,'set_rework_word'])->name('set-rework-word')->middleware('auth'); 

Route::get('/see-the-project-details/{id}',[Usercontroller::class,'see_the_project_details'])->name('see-the-project-details')->middleware('auth'); 

Route::get('/assign-to-writer/{id}',[Usercontroller::class,'assign_to_writer'])->name('assign-to-writer')->middleware('auth');
Route::get('/delete-job-from-writer/{id}',[Usercontroller::class,'delete_job_from_writer'])->name('delete-job-from-writer')->middleware('auth');
Route::get('/update-job-to-writer/{id}',[Usercontroller::class,'update_job_to_writer'])->name('update-job-to-writer')->middleware('auth');

Route::get('/ticket-section/{id}',[Usercontroller::class,'ticket_section'])->name('ticket-section')->middleware('auth');
Route::post('/create-new-ticket',[Usercontroller::class,'create_new_ticket'])->name('create-new-ticket')->middleware('auth');
Route::get('/query-solved/{id}',[Usercontroller::class,'query_solved'])->name('query-solved')->middleware('auth');
Route::get('/count-rework-job',[Usercontroller::class,'count_rework_job'])->name('count-rework-job')->middleware('auth');

Route::post('/post-ticket-comments',[Usercontroller::class,'post_ticket_comments'])->name('post-ticket-comments')->middleware('auth');
Route::post('/load-ticket-messages',[Usercontroller::class,'load_ticket_messages'])->name('load-ticket-messages')->middleware('auth');
Route::get('/split-job-section/{id}',[Usercontroller::class,'split_job_section'])->name('split-job-section')->middleware('auth');
Route::get('/completed-projects',[Usercontroller::class,'completed_projects'])->name('completed-projects')->middleware('auth');
Route::post('/job-extension-request',[Usercontroller::class,'job_extension_request'])->name('job-extension-request')->middleware('auth');


Route::get('/direct-chat/{id}',[Usercontroller::class,'direct_chat'])->name('direct-chat')->middleware('auth');
Route::get('/load-direct-chat-messages/{id}/{jobId}',[Usercontroller::class,'load_direct_chat_messages'])->name('load-direct-chat-messages')->middleware('auth');
Route::post('/post-direct-chat-messages',[Usercontroller::class,'post_direct_chat_messages'])->name('post-direct-chat-messages')->middleware('auth');

/**Reports */
Route::get('/list-idle-writters',[Reports::class,'list_idle_writters'])->name('list-idle-writters')->middleware('auth');
Route::get('/employee-details',[Reports::class,'employee_details'])->name('employee-details')->middleware('auth');
Route::get('/job-id-deadline',[Reports::class,'job_id_deadline'])->name('job-id-deadline')->middleware('auth');
Route::get('/demo-job-list',[Reports::class,'demo_job_list'])->name('demo-job-list')->middleware('auth');
Route::get('/emp-reports/{id}',[Reports::class,'emp_reports'])->name('emp-reports')->middleware('auth');
Route::get('/write-new-feedback',[Reports::class,'write_new_feedback'])->name('write-new-feedback')->middleware('auth');
Route::post('/write-new-feedback',[Reports::class,'write_new_feedback_post'])->name('write-new-feedback')->middleware('auth');
Route::get('/get-writer-feedback',[Reports::class,'get_writer_feedback'])->name('get-writer-feedback')->middleware('auth');
Route::get('/mark-as-review/{id}',[Reports::class,'mark_as_review'])->name('mark-as-review')->middleware('auth');
Route::get('/word-details',[Reports::class,'word_details'])->name('word-details')->middleware('auth');
Route::get('/query-section',[Reports::class,'query_section'])->name('query-section')->middleware('auth');

Route::get('/floor-assigned-job',[Reports::class,'floor_assigned_job'])->name('floor-assigned-job')->middleware('auth');
Route::post('/find-assigned-jobs',[Reports::class,'find_assigned_jobs'])->name('find-assigned-jobs')->middleware('auth');

Route::get('/production-details',[Reports::class,'production_details'])->name('production-details')->middleware('auth');
Route::post('/find-production-details',[Reports::class,'find_production_details'])->name('find-production-details')->middleware('auth');

Route::get('/production-capacity',[Reports::class,'production_capacity'])->name('production-capacity')->middleware('auth');
Route::post('/find-production-capacity',[Reports::class,'find_production_capacity'])->name('find-production-capacity')->middleware('auth');

//Market
Route::get('/post-new-job',[Marketingcontroller::class,'post_new_job'])->name('post-new-job')->middleware('auth');
Route::post('/save-new-job',[Marketingcontroller::class,'save_new_job'])->name('save-new-job')->middleware('auth');
Route::post('/update-new-job',[Marketingcontroller::class,'update_new_job'])->name('update-new-job')->middleware('auth');



//TL
Route::get('/my-teams',[Usercontroller::class,'my_teams'])->name('my-teams')->middleware('auth');

Route::get('/projects-on-network',[Usercontroller::class,'projects_on_network'])->name('projects-on-network')->middleware('auth');
