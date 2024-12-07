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

class Usercontroller extends Controller
{
    public function login(){
        if(Auth::check()){
            return redirect()->intended('/dashboard');
        }else{
            return view('Admin.login');
        }
    }
    public function emp_leave_request(){
        // die('sdss');
        $data['users'] = Auth::user();   
        $data['emp_type'] = User::getPossibleEnumValues();    
        $emp_type = ['CRM'=>'Marketing','OH'=>'Operation','TL'=>'TL','Writer'=>'Writer','ECRM'=>'Marketing','QC'=>'QC'];
        $emp_type = array_values($emp_type);
        $data['emp_list'] = User::whereIn('emp_type',$emp_type)->get();
        $data['leave_request'] = Leaverequest::orderBy('id', 'DESC')->get();
        return view('Admin.emp_leave_request',$data);
    }
    public function my_teams(){
        $data['users'] = Auth::user();   
        $data['my_teams'] = User::where('parent_id',Auth::user()->id)->with(['Employeeprofile'])->get();
        // $data['my_teams'] = User::where('reportingManagerId',Auth::user()->employeeId)->with(['Employeeprofile'])->get();
        // dd($data['my_teams']);
        return view('Admin.my_teams',$data);
    }
    public function see_the_project_details($jobId){
        $data['users'] = Auth::user();   
        $data['jobwork'] = Jobwork::find($jobId);
        $data['Jobassign'] = Jobassign::where('job_id',$data['jobwork']->id)->get();
        // dd($data);
        // 
        return view('Admin.see_the_project_details',$data); 
    }
    public function save_leave_request(Request $request){
        $lr = new Leaverequest();
        $lr->from_date    = date('Y-m-d',strtotime($request->input('from_date')));
        $lr->to_date      = date('Y-m-d',strtotime($request->input('to_date')));
        $lr->user_id      = $request->input('emp');
        $lr->from_head    = $request->input('leave_type');
        $lr->applied_for  = $request->input('applied_for');
        $lr->status       ='approved';
        $lr->save();
        return redirect(route('emp-leave-request'));
    }
    public function testing(){
        // $ticket_id=1;
        // $myid = 10;
        // $count = Communication::where('ticket_id',$ticket_id)->where('status','unread')->where('commented_by','<>',$myid)->get();
        // dd($count);
        $user = User::find(11);
        $user->password = Hash::make('123456');
        $user->save();
    }
    public function edit_employee($id){
        $data['users'] = Auth::user();  
        $data['emp_type'] = User::getPossibleEnumValues();     
        $data['employee'] = User::with(['Employeeprofile'])->find($id);
        $data['userlist'] = User::where('status','Active')->get();
        return view('Admin.edit_employee',$data);
    }
    public function post_login(Loginrequest $request)  {
        $credentials = $request->only('email', 'password');
        // dd($credentials);
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }else{
            return redirect('/')->with('message','Invalid Credentials');
        }
    }
    public function ticket_section($id){
        $data['users'] = Auth::user();  
        // dd($data['users']);
        $data['jobAssignId'] = $id;
        $data['Jobdetails'] = Jobassign::find($id);
        // $userlist = get_user_network(Auth::user());
        $userlist = [];
        $list_of_users = User::where('status','Active')->get();
        if($list_of_users){
            foreach ($list_of_users as $key => $row) {
                $userlist[] = $row->id;
            }
        }
        $userlist[] = Auth::user()->id;
        // $userlist[] = get_parent_network(Auth::user());
        // dd($userlist); 
        $data['tickets'] = Ticket::whereIn('posted_by',$userlist)->where('job_id',$id)->get();
        return view('Admin.ticket_section',$data);
    }
    public function query_solved($id){
        $ticket = Ticket::find($id);
        $ticket->ticket_status='Closed';
        $ticket->save();
        return redirect()->back();
    }
    public function projects_on_network(){
        $data['users'] = Auth::user();  
        $userlist = get_user_network(Auth::user());
        // $data['projects'] = Jobassign::whereIn('user_id',$userlist)->get();
        $data['projects'] = DB::table('jobworks')->join('jobassigns','jobworks.id','=','jobassigns.job_id')->join('users','jobassigns.user_id','=','users.id')->whereIn('jobassigns.user_id',$userlist)->select('jobworks.*','jobassigns.status','jobassigns.writer_attachment','jobassigns.extra_information','jobassigns.dead_line','jobassigns.word','jobassigns.user_id','users.name')->get();
        // dd($data['projects']);
        return view('Admin.projects_on_network',$data);
    }
    public function post_ticket_comments(Request $request){
        $comment = new Communication();
        $comment->ticket_id        = $request->input('ticket_id');
        $comment->commented_by     = Auth::user()->id;
        $comment->message          =  $request->input('message');
        $comment->posted_date_time = date('Y-m-d H:i:s'); 
        $comment->status = 'unread'; 
        $comment->save();
        // return redirect(route('ticket-section',$request->input('id')));
    }
    public function start_job($id){
        $assign = Jobassign::find($id);
        $assign->status='Started';
        $assign->save();
        return redirect(route('writer-job-list'));
    }
    public function stop_job($id){
        $assign = Jobassign::find($id);
        $assign->status='Assign';
        $assign->save();
        return redirect(route('writer-job-list'));
    }
    public function create_new_ticket(Request $request){
        $assign = Jobassign::find($request->input('id'));
        // dd($assign);
        $ticketno = Jobwork::find($assign->job_id)->jobnumber;
        $ticket = new Ticket();
        $ticket->ticket_id = $ticketno;
        $ticket->job_id    = $request->input('id');
        $ticket->posted_by = Auth::user()->id;
        $ticket->commented_by = 0;
        $ticket->title        = $request->input('title');
        $ticket->ticket_message = $request->input('message');
        // $ticket->attachment 
        $ticket->ticket_status  = 'Open';
        $ticket->save();
        return redirect(route('ticket-section',$request->input('id')));

    }
    public function split_job_section($id){
        $data['users'] = Auth::user();
        $split_partners = Jobassign::where('job_id',$id)->where('user_id','<>',Auth::user()->id)->get();
        $data['my_job'] = $split_partners;
        return view('Admin.split_job_section',$data);
    }
    public function completed_projects(){
        $data['users'] = Auth::user();
        return view('Admin.completed_projects',$data);
    }
    public function leave_view(){
        $data['users'] = Auth::user();   
        $data['emp_type'] = User::getPossibleEnumValues();  

        $leaveDetails = DB::table('emp_leave_request')->join('users','emp_leave_request.user_id','=','users.id')->select('emp_leave_request.*', 'users.name','users.employeeId')->get();
       
        $eventarray = [];
        foreach ($leaveDetails as $key => $row) {
            $start = date('Y-m-d',strtotime($row->from_date));
            $end = date('Y-m-d',strtotime($row->to_date));
           $eventarray[] = ['title'=>$row->name.'('.$row->employeeId.')','start'=>$start,'end'=>$end];
        }

        $data['events'] = json_encode($eventarray);
        return view('Admin.job_calender_view',$data);
    }
    public function set_rework_word(Request $request){
        $id   = $request->input('id');
        $word = $request->input('word');
        $Jobassign = Jobassign::find($id);
        $Jobassign->word =$word;
        $Jobassign->rework_start_status = 2;
        $Jobassign->save();
    }
    public function job_calender_view(){
        $data['users'] = Auth::user();   
        $data['emp_type'] = User::getPossibleEnumValues();    
        // if(Auth::user()) 
        // dd(Auth::user());
        $userList = [];
        if(Auth::user()->emp_type=='Operation'){
            
            $list_of_writers = User::where('emp_type','Writer')->get();
            if($list_of_writers){
                foreach ($list_of_writers as $key => $value) {
                    $userList[] = $value->id;
                }
            }
        }else{
            $userList = get_user_network(Auth::user());
        }
        
        
        $my_job = Jobassign::whereIn('user_id',$userList)->where('assign_type','fresh')->get();
        $my_job_rework = Jobassign::whereIn('user_id',$userList)->where('assign_type','rework')->get();
        $eventarray = [];
        foreach ($my_job as $key => $row) {
            $start = date('Y-m-d',strtotime($row->dead_line)).'T00:00:00';
            $end = str_replace(' ','T',$row->dead_line);
           $eventarray[] = ['title'=>getJobId($row->job_id),'start'=>$start,'end'=>$end];
        }
        foreach ($my_job_rework as $key => $row) {
            $start = date('Y-m-d',strtotime($row->dead_line)).'T00:00:00';
            $end = str_replace(' ','T',$row->dead_line);
           $eventarray[] = ['title'=>getJobId($row->job_id),'start'=>$start,'end'=>$end];
        }

        $my_leave = DB::table('emp_leave_request')->where('user_id',Auth::user()->id)->get();

        foreach ($my_leave as $key => $row) {
            $start = date('Y-m-d',strtotime($row->from_date));
            $end = date('Y-m-d',strtotime($row->to_date));
           $eventarray[] = ['title'=>'Leave '.$start.' To '.$end,'start'=>$start,'end'=>$end];
        }

        $data['events'] = json_encode($eventarray);
        return view('Admin.job_calender_view',$data);
    }
    public function direct_chat($id){
        $data['users'] = Auth::user();
        $data['jobid'] = $id;
        $job_posted_by = Jobwork::find($id)->user_id;
        $job_assign_by = Jobassign::where('job_id',$id)->first()->assign_by;
        $writer = Jobassign::where('job_id',$id)->first()->user_id;
        $userObj = User::find($writer);
        $job_network_users = get_parent_network($userObj);
        $job_network_users[] = $job_posted_by;
        $job_network_users[] = $job_assign_by;
        $data['list_of_teams'] = User::whereIn('emp_type',['Writer','Operation','QC','TL','Marketing','Admin'])->where('id','<>',Auth::user()->id)->whereIn('id',$job_network_users)->get();
        return view('Admin.direct_chat',$data);
    }
    public function load_direct_chat_messages($id,$jobId){
            // $jobId =  $request->input('jobid');
            $chat_opener = Auth::user()->id;
            $chat_person = $id;
            $data['users'] = Auth::user();
            $job_posted_by = Jobwork::find($id)->user_id;
            $job_assign_by = Jobassign::where('job_id',$jobId)->first()->assign_by;
            $writer = Jobassign::where('job_id',$jobId)->first()->user_id;
            $userObj = User::find($writer);
            $job_network_users = get_parent_network($userObj);
            $job_network_users[] = $job_posted_by;
            $job_network_users[] = $job_assign_by;
            $msg1 =  DB::table('direct_chats')->whereIn('from_id',$job_network_users)->whereIn('to_id',[$chat_opener])->get();
            $msg2 =  DB::table('direct_chats')->whereIn('from_id',[$chat_opener])->whereIn('to_id',$job_network_users)->get();
            $messages = [];
            if($msg1){
                foreach ($msg1 as $key => $value) {
                    $messages[$value->id] = $value;
                }
            }
            if($msg2){
                foreach ($msg2 as $key => $value) {
                    $messages[$value->id] = $value;
                }
            }

            ksort($messages);
            $data['messages'] = $messages;
            // print_r($data['messages']);die;
            return view('Admin.direct_chat_messages',$data);
    }
    public function post_direct_chat_messages(Request $request){
       

        $insertArry = [
            'from_id'=>Auth::user()->id,
            'to_id' =>$request->input('chat_person'),
            'message'=>$request->input('message'),
            'job_id'=>$request->input('jobid')
        ];

        DB::table('direct_chats')->insert($insertArry);

     
        exit;
    }

    public function job_extension_request(Request $request){
        $requst_by = Auth::user()->id;
        $message   = $request->input('message');
        $job_id    = $request->input('job_id');

        $insertArry = ['job_id'=>$job_id,'request_by'=>$requst_by,'message'=>$message,'status'=>'open'];
        db::table('job_extension_request')->insert($insertArry);

        return redirect()->route('writer-job-list')->with('success', 'Request successfully created!');
    }


    public function load_ticket_messages(Request $request){
        $data['allMessages'] = Communication::where("ticket_id",$request->input('id'))->orderBy('id','ASC')->get();
        Communication::where("ticket_id",$request->input('id'))->where("commented_by",'<>', Auth::user()->id)->update(['status'=>'read']);
        $data['users'] = Auth::user();
        return view('Admin.load_ticket_messages',$data);
    }
    public function dashboard ()  {
        $data['users'] = Auth::user();
        // dd($data['users']->name);
        return view('Admin.dashboard',$data);
    }
    public function logout() {
        Auth::logout();
        $data['message'] = 'Session End';
        return redirect('/dashboard')->with('message','Session End');
    }
    public function update_job_form(Request $request){ 
        // dd($request->file);
        $user =  Auth::user();
        // $fileName = str_replace(' ','_',$request->file->getClientOriginalName()).'_'.time().'.'.$request->file->extension();  
       
        // $request->file->move(public_path('uploads'), $fileName);

        $files  = $request->file('attachment');
        $file_name_array = [];
        foreach ($files as $key => $file) {
            $fileName = str_replace(' ','_',$file->getClientOriginalName()).'_'.time().'.'.$file->extension();  
       
             $file->move(public_path('uploads'), $fileName);

             $file_name_array[] = $fileName;
        }
        
       

        $Jobassign = Jobassign::find($request->input('id'));
        $jobattachment = new Jobattachment();
        $jobattachment->job_id = $Jobassign->job_id;
        $jobattachment->user_id = $Jobassign->user_id;
        $jobattachment->file_names = json_encode($file_name_array);
        $jobattachment->save();

        $Jobassign->writer_attachment = json_encode($file_name_array);
        if($user->emp_type=='Writer'){
            $Jobassign->status  = 'Waiting for TL';
        }
        if($user->emp_type=='TL'){
            $Jobassign->status  = $request->input('status');
            if($request->input('status')=='Rework'){
                $Jobassign->assign_type  = $request->input('status');
                $Jobassign->rework_counter +=1;
            }
            
            $Jobassign->extra_information .= "<br><hr/>".$request->input('notes');
        }
        if($user->emp_type=='QC'){
            $Jobassign->status  = $request->input('status');
            // $Jobassign->assign_type  = $request->input('status');
            if($request->input('status')=='Rework'){
                $Jobassign->assign_type  = $request->input('status');
                $Jobassign->rework_counter +=1; 
            }
            $Jobassign->extra_information .= "<br><hr/>".$request->input('notes');
        }
        if($user->emp_type=='Operation'){
            $Jobassign->status  = $request->input('status');
            if($request->input('status')=='Rework'){
                $Jobassign->assign_type  = $request->input('status');
            }
            $Jobassign->extra_information .= "<br><hr/>".$request->input('notes');
        }
        $Jobassign->save();
        return redirect(route('writer-job-list'));
    }
    public function see_the_progress($id){

        $data['users'] = Auth::user();   
        $data['emp_type'] = User::getPossibleEnumValues();     
        $data['my_job'] = Jobassign::where('job_id',$id)->get();
        return view('Admin.see_the_progress',$data);
    }

    public function get_hrm_data(){
        $employee = json_decode(getdatafromHRM());
        if($employee){
            foreach ($employee as $key => $row) {
                // $is_exist = DB::table('dept_list')->where('dept_name',$row->department)->first();
                
                // if(!$is_exist){
                //     DB::table('dept_list')->insert(['dept_name'=>$row->department]);
                //     echo '<br>'.$row->department;
                // }
                $emp_type = ['Admin'=>'Admin','BOE'=>'BOE','CRM'=>'Marketing','OH'=>'Operation','TL'=>'TL','Writer'=>'Writer','ECRM'=>'Marketing','HR'=>'HR','QC'=>'QC','Floor Head'=>'Floor Head','Back Office'=>'Back Office'];
                $emp_array = [
                    'employeeId'=>$row->employeeId,
                    'reportingManagerId'=>$row->reportingManagerId,
                    'name'=>$row->employeeName,
                    'sex'=>$row->sex,
                    'designation'=>$row->designation,
                    'email'=>$row->emailId,
                    'mobileNumber'=>$row->mobileNumber,
                    'emp_type'=>$emp_type[$row->department],
                    'password'=>Hash::make('123456'),
                    'parent_id'=>0,
                    'status'=>$row->status,
                ];
                $is_exist = DB::table('users')->where('employeeId',$row->employeeName)->first();
                if(!$is_exist){
                    DB::table('users')->insert($emp_array);
                    $last_id = DB::getPdo()->lastInsertId();

                    $employeeprofiles = [
                                            'user_id'=>$last_id,
                                            'doj'=>date('Y-m-d',strtotime($row->dateOfJoin)),
                                            'mob'=>$row->mobileNumber,
                                            'type_speed'=>0,
                                            'experience'=>$row->experience,
                                            'area_of_exp'=>'No Data',
                                        ];
                    // echo '<br>'.$row->department;
                    DB::table('employeeprofiles')->insert($employeeprofiles);
                }

            }
        }
        // DB::table('dept_list')->insert(['dept_name'=>'Admin']);
        // $is_exist = DB::table('dept_list')->where('dept_name','Admin')->first();
        // a($is_exist);
    }
    public function assign_to_writer($id){
        $data['users'] = Auth::user();   
        $data['jobworks'] = Jobwork::find($id);
        $data['assigned'] = Jobassign::where('job_id',$id)->get();
        $assigned_emp = [];
        if($data['assigned']){
            foreach($data['assigned'] as $row){
                $assigned_emp[] = $row->user_id;
            }
        }
        $assigned_emp = [];
        $data['Writer'] = User::where('emp_type','Writer')->whereNotIn('id',$assigned_emp)->get();
       
        // a($data); 
        return view('Admin.assign_job_to_writer',$data);
    }
    public function delete_job_from_writer($id){
        $item = Jobassign::find($id);
        $item->delete();
        // return redirect(route('post-new-job'));
        return redirect()->back();
    }
    public function update_job_to_writer($id){
        // $item = Jobassign::find($id);
        // $item->delete();
        // return redirect(route('post-new-job'));
    }

    public function job_assign_validation($writer,$assigndate,$job_id,$word){
        $data['date_flag']  = 0;
        $data['limit_flag'] = 0;
          
        $is_assigned_on_same_date = DB::table('jobassigns')->whereDate('dead_line',date('Y-m-d',$assigndate))->where('user_id',$writer)->where('job_id',$job_id)->count();
        if($is_assigned_on_same_date>0){
            $data['date_flag']  = 1;
        }

        $writer_limit = getTypeSpeed($writer);

        $total_assigned  = DB::table('jobassigns')->whereDate('dead_line',date('Y-m-d',$assigndate))->where('user_id',$writer)->sum('word');
        $remain = $writer_limit - $total_assigned;
        if($remain<$word){
            $data['limit_flag'] = 1;
        }
        return $data;
    }
    public function assign_job_to_writer(Request $request){
        // dd($request->all());
        $job_id =$request->input('job_id');
        $deadline = strtotime($request->input('deadline'));
        $writer = $request->input('writer');
        $word = explode(',',$request->input('word'));
        $extra_notes = $request->input('extra_notes');
        $res = [];
        $ins_flag = 0;
        foreach($writer as $index=>$row){
            $validation = $this->job_assign_validation($row,$deadline,$job_id,$word[$index]);
            if($validation['date_flag']==0 && $validation['limit_flag']==0){
                $jobass = new Jobassign();
                $jobass->job_id = $job_id;
                $jobass->user_id = $row;
                $jobass->assign_by = Auth::user()->id;
                // $jobass->status = ;
                $jobass->extra_information = $extra_notes;
                $jobass->dead_line    = date('Y-m-d H:i:s',$deadline);
                $jobass->word         = $word[$index];
                $jobass->save();
                $ins_flag = 1;
            }else{
                $res[] = "sorry unable to assign task for ".getemp_name($row)." Please check load Limit ";
            }
        }
          if($ins_flag==1){
            $jobwork = Jobwork::find($job_id);
            $jobwork->status = 'Assign';
            $jobwork->save();
          }
    //    return redirect(route('post-new-job'));
        return redirect()->back()->with('res',$res);
    }
    public function writer_job_list(){
        // ini_set('display_errors',1);
        $data['users'] = Auth::user();   
        $data['emp_type'] = User::getPossibleEnumValues();    
        // if(Auth::user()) 
        // dd(Auth::user());
        $userList = [];
        if(Auth::user()->emp_type=='Operation'){
            
            $list_of_writers = User::where('emp_type','Writer')->get();
            if($list_of_writers){
                foreach ($list_of_writers as $key => $value) {
                    $userList[] = $value->id;
                }
            }
        }else{
            $userList = get_user_network(Auth::user());
        }
        
        
        $data['my_job'] = Jobassign::whereIn('user_id',$userList)->where('assign_type','fresh')->get();
        $data['my_job_rework'] = Jobassign::whereIn('user_id',$userList)->where('assign_type','rework')->get();
        // dd($data);
        if(Auth::user()->emp_type=='Writer'){
            return view('Admin.writer_job_list',$data);
        }else{
            return view('Admin.junior_job_list',$data);
        }
        
    }
    public function count_rework_job(){
        // $userList = get_user_network(Auth::user());
        $userList = [];
        if(Auth::user()->emp_type=='Operation'){
            
            $list_of_writers = User::where('emp_type','Writer')->get();
            if($list_of_writers){
                foreach ($list_of_writers as $key => $value) {
                    $userList[] = $value->id;
                }
            }
        }else{
            $userList = get_user_network(Auth::user());
        }
        $data['my_job_rework'] = Jobassign::whereIn('user_id',$userList)->where('assign_type','rework')->where('status','Assign')->get();
        echo count($data['my_job_rework']);
    }
    public function employee_list(){
        $data['users'] = Auth::user();   
        $data['emp_type'] = User::getPossibleEnumValues();     
        $data['emp_list'] = User::where('emp_type','<>','Admin')->with(['Employeeprofile'])->get();
        // dd($data['emp_list']);
        // dd();
        // dd(DB::select(DB::raw("SHOW COLUMNS FROM users WHERE Field = 'emp_type'"))[0]->Type);
        return view('Admin.employee_list',$data);
    }
    public function save_employee(Request $request){

        // dd($request->input());

        $user = new User();
        $user->name     = $request->input('name');
        $user->email    = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->emp_type = $request->input('emp_type');
        $user->status   = $request->input('status');
        $user->save();

        $Employeeprofile = new Employeeprofile();
        $Employeeprofile->user_id      = $user->id;
        $Employeeprofile->doj         = date('y-m-d',strtotime($request->input('doj')));
        
        $Employeeprofile->mob         = $request->input('mob');
        
        
        $Employeeprofile->area_of_exp =  $request->input('area_of_exp');

        $Employeeprofile->save();

        return redirect(route('employee-list'));
    }
    public function Client_list(){
          $data['clients'] = Client::with(['user'])->get();  
          $data['users'] = Auth::user();  
          $data['Country'] = Country::all();
          $data['Currency'] = Currency::all();
          return view('Admin.client_list',$data);
    }
    public function save_client(Request $request){
        // dd($request->input());
        $client =  new Client();
        $client->clientname = $request->input('client_name');
        $client->email      = $request->input('email');
        $client->mob        = $request->input('mob');
        $client->address    = $request->input('address');
        $client->extra_info = $request->input('extra_info');
        $client->country = $request->input('country');
        $client->currency = $request->input('currency');
        $client->price = $request->input('price');
        $client->status     = Auth::user()->emp_type=='Admin'?$request->input('status'):'Inactive';
        $client->user_id    = Auth::user()->id;
        $client->save();
        return redirect(route('client-list'));

    }
    public function team_structure(){
        $data['teamlead'] = User::where('emp_type','TL')->get();
        $data['users'] = Auth::user();  
        return view('Admin.team_structure',$data);
    } 
    public function update_employee(Request $request){
        $user = User::find($request->input('id'));
        $user->name     = $request->input('name');
        $user->email    = $request->input('email');
        if($request->input('password')!=''){
            $user->password = Hash::make($request->input('password'));
        }
        if($request->input('super_emp')!=''){
            $user->parent_id = $request->input('super_emp');
        }
        $user->emp_type = $request->input('emp_type');
        $user->status   = $request->input('status');
        $user->save();
        $Employeeprofile = Employeeprofile::where('user_id',$request->input('id'))->first();
        // dd($Employeeprofile);
        $Employeeprofile->doj         = date('y-m-d',strtotime($request->input('doj')));        
        $Employeeprofile->mob         = $request->input('mob'); 
        $Employeeprofile->area_of_exp =  $request->input('area_of_exp');
        if($request->input('emp_type')=='Writer'){
            $Employeeprofile->type_speed =  $request->input('type_speed');
        }
        
        $Employeeprofile->save();
        return redirect(route('employee-list'));
    }
    public function load_emp_data(Request $request){
        $users = User::where('id',$request->input('id'))->with(['Employeeprofile'])->get()->toArray();
        return response()->json($users);
    }
    public function load_client_info(Request $request){
        $client =  Client::find($request->input('id'));
        return response()
            ->json($client->toArray());
    }
    public function delete_client_info(Request $request){
        $client =  Client::find($request->input('id'));
        if($client){
            $client->delete();
            return response()
            ->json(['success'=>TRUE]);
        }else{
            return response()
            ->json(['success'=>FALSE]);
        }
        
        
    }
    public function delete_employee(Request $request){
        $user =  User::find($request->input('id'));
        if($user){
            $user->delete();
            return response()
            ->json(['success'=>TRUE]);
        }else{
            return response()
            ->json(['success'=>FALSE]);
        }
    }
    public function update_client(Request $request){
        $client =  Client::find($request->input('id'));
        $client->clientname = $request->input('client_name');
        $client->email      = $request->input('email');
        $client->mob        = $request->input('mob');
        $client->address    = $request->input('address');
        $client->extra_info = $request->input('extra_info');
        $client->status     = $request->input('status');
        $client->save();
        return redirect(route('client-list'));
    }
}
