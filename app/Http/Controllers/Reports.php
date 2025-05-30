<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Loginrequest;
use App\Models\User;
use App\Models\Employeeprofile;
use App\Models\Client;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Jobassign;
use App\Models\Jobwork;
use App\Models\Ticket;
use App\Models\Communication;
use App\Models\Leaverequest;
use App\Models\Jobattachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
class Reports extends Controller
{
   public function list_idle_writters(){
        $today = date('Y-m-d');
        // DB::enableQueryLog();
        $users = DB::table('users')
                 ->join('jobassigns','users.id','=','jobassigns.user_id')
                 ->select('users.*')
                 ->whereDate('jobassigns.dead_line','>=',$today)
                 ->where('users.emp_type','=','Writer')
                 ->get();
                //  dd(DB::getQueryLog());
        $userIds =Arr::pluck($users, 'id');
        $writers = DB::table('users')->whereNotIn('id',$userIds)->where('emp_type','=','Writer')->where('status','=','Active')->get();
        $data['users'] = Auth::user();   
        $data['emp_type'] = User::getPossibleEnumValues();     
        $data['writers'] = $writers;
        return view('Admin.list_idle_writters',$data);
   }

   public function employee_details(){
      // echo Auth::user()->id;
      $data['users'] = Auth::user();   
      $data['emp_type'] = User::getPossibleEnumValues(); 
      if(Auth::user()->emp_type=='Operation'){
         $data['emp'] =  User::whereIn('emp_type',['Writer','QC','TL'])->with(['Employeeprofile'])->get();
         
      }
      if(Auth::user()->emp_type=='QC' || Auth::user()->emp_type=='Admin'){
         $data['emp'] =  User::where('parent_id',Auth::user()->id)->with(['Employeeprofile'])->get();
     
      }    
      
      return view('Admin.employee_details',$data);
   }

   public function job_id_deadline(){
      $data['users'] = Auth::user();   
      $data['emp_type'] = User::getPossibleEnumValues(); 
      if(Auth::user()->emp_type=='Operation'){
         $data['job_work'] =  DB::table('jobworks')->whereNotIn('status',['Rejected'])->whereIn('jobtype',['Fresh','Rework'])->get();
         
      }
      if(Auth::user()->emp_type=='QC' || Auth::user()->emp_type=='Admin'){
         $get_user_network         = get_user_network(Auth::user());
         $project_under_my_network = DB::table('jobassigns')->whereIn('user_id',$get_user_network)->where('status','<>','Finished')->get();

         $project_ids = Arr::pluck($project_under_my_network,'id');
         $data['job_work'] =  DB::table('jobworks')->whereNotIn('status',['Rejected'])->whereIn('jobtype',['Fresh','Rework'])->whereIn('id',$project_ids)->get();
     
      }    
      return view('Admin.job_id_deadline',$data);
   }

   public function demo_job_list(){
      $data['users'] = Auth::user();   
      $data['emp_type'] = User::getPossibleEnumValues(); 
      if(Auth::user()->emp_type=='Operation'){
         $data['job_work'] =  DB::table('jobworks')->whereNotIn('status',['Rejected'])->whereIn('jobtype',['Demo'])->get();
         
      }
      if(Auth::user()->emp_type=='QC' || Auth::user()->emp_type=='Admin'){
         $get_user_network         = get_user_network(Auth::user());
         $project_under_my_network = DB::table('jobassigns')->whereIn('user_id',$get_user_network)->where('status','<>','Finished')->get();

         $project_ids = Arr::pluck($project_under_my_network,'id');
         $data['job_work'] =  DB::table('jobworks')->whereNotIn('status',['Rejected'])->whereIn('jobtype',['Demo'])->whereIn('id',$project_ids)->get();
     
      }    
      return view('Admin.demo_job_list',$data);
   }

   public function emp_reports($id){
      $data['users'] = Auth::user();   
      $data['emp_type'] = User::getPossibleEnumValues(); 
      $data['emp_data'] = User::find($id);     
      $assign_proj = DB::table('jobassigns')->where('user_id','=',$id)->where('status','<>','Finished')->get();
      $assign_proj_id = "";
      $job_id = [];
      if($assign_proj){
         $job_id = Arr::pluck($assign_proj,'job_id');
         $project_id = DB::table('jobworks')->whereIN('id',$job_id)->get();
         if($project_id){
            $assign_proj_id = Arr::pluck($project_id,'jobnumber');
         } 
      }
      $data['assign_proj'] = $assign_proj_id;
      $data['getTypeSpeed'] = getTypeSpeed($id);
      $data['remain_capacity'] = $data['getTypeSpeed'] - DB::table('jobassigns')->whereIn('job_id',$job_id)->where('user_id','=',$id)->whereDate('dead_line','=',date('Y-m-d'))->sum('word');
      $data['total_words'] = DB::table('jobassigns')->where('user_id','=',$id)->whereIn('status',['Finished','Waiting for TL','Waiting for QC','Waiting for Marketing'])->sum('word');
      $data['total_fresh'] =  DB::table('jobassigns')->where('user_id','=',$id)->whereNotIn('status',['Finished'])->where('assign_type','=','Fresh')->count('id');
      $data['total_rework'] = DB::table('jobassigns')->where('user_id','=',$id)->whereNotIn('status',['Finished'])->where('assign_type','=','Rework')->count('id');
      return view('Admin.emp_reports',$data);
   }

   public function floor_assigned_job(){
      $data['users'] = Auth::user();  
      $data['my_jobs'] = DB::table('jobassigns')->whereDate('dead_line','=',date('Y-m-d'))->whereIn('user_id',get_user_network( Auth::user()))->get();
      // a($data['my_jobs']); 
      return view('Admin.floor_assigned_job',$data);
   }
   public function production_capacity(){
      $data['users'] = Auth::user();  
      $data['my_jobs'] = [];
      $get_user_network         = get_user_network(Auth::user());
      $data['writer'] = User::where('emp_type','Writer')->whereIn('id',$get_user_network)->get();
      return view('Admin.production_capacity',$data);
   }
   public function production_details(){
      $data['users'] = Auth::user();  
      $data['my_jobs'] = [];
      $get_user_network         = get_user_network(Auth::user());
      $data['writer'] = User::where('emp_type','Writer')->whereIn('id',$get_user_network)->get();
      return view('Admin.production_details',$data);
   }
   public function find_production_details(Request $request){
      sleep(1);
      $data['my_jobs'] = DB::table('jobassigns')->whereDate('dead_line','>=',$request->input('date1'))->whereDate('dead_line','<=',$request->input('date2'))->where('user_id',$request->input('writer_id'))->get();
      // a($data);
      $data['fresh_job'] = 0;
      $data['rework_job'] = 0;
      if($data['my_jobs']){
         foreach ($data['my_jobs']  as $key => $value) {
           if($value->assign_type=='Fresh'){
            $data['fresh_job'] +=$value->word;
           }
           if($value->assign_type=='Rework'){
            $data['rework_job'] +=$value->word;
           }
         }
      }
      return view('Admin.find_production_details',$data);
   }

   public function find_production_capacity(Request $request){
      // sleep(1);
      $writes = DB::table('users')->where('emp_type','writer')->get();

      $dataarray = [];
      $each = [];
      foreach ($writes as $key => $row) {
         $each = [];
         $each['name'] =$row->name;
         $fresh_job = 0;
         $rework_job = 0;
         $my_jobs = DB::table('jobassigns')->whereDate('dead_line','=',$request->input('date'))->where('user_id',$row->id)->get();
         if($my_jobs){
            foreach ($my_jobs  as $key => $value) {
              if($value->assign_type=='Fresh'){
               $fresh_job +=$value->word;
              }
              if($value->assign_type=='Rework'){
               $rework_job +=$value->word;
              }
            }
         }
         $each['fresh_job'] = $fresh_job;
         $each['rework_job'] = $rework_job;
         $each['speed'] = getTypeSpeed($row->id);
         $dataarray[] = $each;
      }
      // a($dataarray);
      return view('Admin.find_production_capacity',['data'=>$dataarray]);
   }
   public function find_assigned_jobs(Request $request){
      sleep(1);
      $data['my_jobs'] = DB::table('jobassigns')->whereDate('dead_line','>=',$request->input('date1'))->whereDate('dead_line','<=',$request->input('date2'))->whereIn('user_id',get_user_network( Auth::user()))->get();
      
      return view('Admin.find_assigned_jobs',$data);
   }

   public function write_new_feedback(){
         $data['users'] = Auth::user();   
         $data['emp_type'] = User::getPossibleEnumValues(); 
         $get_user_network         = get_user_network(Auth::user());
         $data['writer'] = User::where('emp_type','Writer')->whereIn('id',$get_user_network)->get();
         $mycmt = DB::table('writer_feedback')
                     ->join('users','writer_feedback.emp_id','=','users.id')
                     ->select('users.name','users.employeeId','writer_feedback.*')
                     ->where('writer_feedback.commented_by','=',Auth::user()->id)->get();
         $data['mycmt'] = $mycmt;

         return view('Admin.write_new_feedback',$data);

   }
   public function write_new_feedback_post(Request $request){

      $insertArr = ['emp_id'=>$request->input('writer_id'),'comments'=>$request->input('comment'),'commented_by'=>Auth::user()->id];
      $id = DB::table('writer_feedback')->insertGetId($insertArr);
      if($id){
         return redirect()->route('write-new-feedback')->with('success', 'Feedback created!');
      }else{
         return redirect()->route('write-new-feedback')->with('error', 'Unable to post Feedback!');
      }
      
   }
   public function get_writer_feedback(){
      // $feedback =  DB::table('writer_feedback')->orderBy('created_at')->limit(10)->get();
      $data['users'] = Auth::user();   
     
      $feedback = DB::table('writer_feedback')
                     ->join('users','writer_feedback.emp_id','=','users.id')
                     ->select('users.name','users.employeeId','writer_feedback.*')
                     ->orderBy('writer_feedback.created_at')->limit(10)->get();

      $data['feedback'] = $feedback;
      return view('Admin.get_writer_feedback',$data);

   }
   public function mark_as_review($id){
      DB::table('writer_feedback')->where('id',$id)->update(['review_by'=>Auth::user()->id]);
      return redirect()->back()->with('success', 'Feedback marked as READ');
   }


   public function word_details(){
      $data['users'] = Auth::user(); 
      return view('Admin.word_details',$data);
   }

   public function query_section(){
      $data['users'] = Auth::user(); 
      //print_r($data['users']);exit;
      $data['tickets'] = DB::table('tickets')->where('ticket_status','Open')->get();

      //print_r($data['tickets']);exit;
      return view('Admin.query_section',$data);
   }

}
