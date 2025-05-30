<?php
use App\Models\Jobcounter;
use App\Models\Jobwork;
use App\Models\User;
use App\Models\Employeeprofile;
use App\Models\Jobassign;
use App\Models\Communication;
use App\Models\Client;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
$userarray = [];
function testing(){
    return "subhajit";
}
function counttotalunread($ticket_id,$myid){
    
    $count = Communication::where('ticket_id',$ticket_id)->where('status','unread')->where('commented_by','<>',$myid)->get();
    if($count){
        return count($count);
    }else{
        return 0;
    }
    
}
function a($data){
    echo "<pre>";
    print_r($data);
    die;
}
function getJobnumber(){
    $value = Jobcounter::find(1)->counter;
    return "ASMT/".date('Ym').'/'.$value;
}
function getJobId($id){
    return Jobwork::find($id)->jobnumber;
}
function getUsername($id){
    //return User::find($id)->name;
    $user_id_exist = User::where('id', $id)->first();
        if(!$user_id_exist){
            return '';
        }
        return $user_id_exist->name;
}
function getUserParentname($id){
    // parent_id
    $parentID = User::find($id)->parent_id;
    return getUsername($parentID);
}

function getdatafromHRM(){   
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://studentlife.247hrm.com/middleware/api/v1/third-party/employees',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'x-api-key: A0A369D9-7267-4851-BC44-01120FF04DAC'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;

}
function attahment($id){
     
    return Jobwork::find($id)->attachment;//"<a href="{{asset('uploads').'/'.}}" target="_blank">Download</a>";
}
// function getworkingattchments($id){
//     $jobassign = Jobassign::find($id);
//     $fileurl = "";
//     if($jobassign){
//         if($jobassign->writer_attachment!=""){
//             foreach(json_decode($jobassign->writer_attachment) as $row){
//                 $fileurl.="<a href="{{asset('uploads'.'/'.$row)}}" target='_blank'>Download</a>";
//             }
//         }
//     }
// }
function drivelink($id){
    return Jobwork::find($id)->drive_link;
}
function jobinformation($id){
    return Jobwork::find($id)->requirement;
}
function jobId($id){
    return Jobwork::find($id)->jobnumber;
}
function countRework(){
    
}
function getassignedProject($userObj,$type){
    $userlist = get_user_network($userObj);
    $list = Jobassign::whereIn('user_id',$userlist)->where('status','<>','Finished')->where('assign_type',$type)->get();
    $jobids = [];
    if($list){
        foreach ($list as $key => $value) {
             $jobids[] =  "<a href='".route('see-the-project-details',$value->job_id)."'>".getJobId($value->job_id)."</a>"; 
        }

    return implode(',',$jobids);
    }else{
        return "No Project";
    }
}
function get_user_network($userObj){
    
    $userarray[] = $userObj->id;
    $userlist = User::where('parent_id',$userObj->id)->get();
    foreach ($userlist as $key => $row) {
        $userarray[] = $row->id;
        if($row->emp_type!="Writer"){
          return  get_user_network($row);
        }
    }
    return $userarray;
}
function get_parent_network($userObj){
    // $list = [];
    // $list[] = $userObj->id;
    // $list[] = $userObj->parent_id;
    // // $user= User::where('id',$userObj->parent_id)->first();
    // // $list[] = $user->id;
    // return $list;
    $userarray[] = $userObj->id;
    $users = User::where('id',$userObj->parent_id)->first();
    if($users->parent_id!=0){
        $userarray[] = $users->id;
        return get_parent_network($users);
    }else{
        $userarray[] = $users->id;
    }
    return $userarray;
}
function totalassign($id,$total_word){
    $totalAssigned = Jobassign::where('job_id',$id)->sum('word');
    return $total_word - $totalAssigned;
//   return $total_word;
}
function getTypeSpeed($emp_id){
    $Employeeprofile = Employeeprofile::where('user_id',$emp_id)->first();
    if($Employeeprofile){
        return $Employeeprofile->type_speed;
    }
    return 0;
    
}
function used_word($emp_id){
    $word = DB::table('jobassigns')->where('user_id',$emp_id)->whereDate('dead_line','=',date('Y-m-d'))->sum('word');
    return $word;
}
function client_name($id){
    $Client = Client::find($id);
    return $Client->clientname; 
}
function getemp_name($emp_id){
    $emp  = User::find($emp_id);
    return $emp->name; 
}
function getNotification($type,$userIds){
    if($type=='QC'){
           $data =  Jobassign::where('status','Waiting for QC')->whereIn('user_id',$userIds)->get();
           return $data;
    }
    else if($type=='TL'){
        $data =  Jobassign::where('status','Waiting for TL')->whereIn('user_id',$userIds)->get();
        return $data;

    }else if($type=='Writer'){
        $data =  Jobassign::where('status','Assign')->whereIn('user_id',$userIds)->get();
        return $data;
    }else{
        $data = [];
        return $data;
    }
}
function getWrites($emp_id){
    // $emp  = User::where('parent_id',$emp_id)->with(['Employeeprofile'])->get();
    $emp  = User::where('reportingManagerId',$emp_id)->where('emp_type','Writer')->get();
    return $emp;
}
function getlistoffreshproject($emp_id,$type){
        $joblist = Jobassign::where('user_id',$emp_id)->get();
        $jobId = [];
        $count = 0;
         if($joblist){
            foreach($joblist as $row){
                $jobId[]= jobId($row->job_id).'='.$row->word;
                $count+=$row->word;
            }
         }
         return ['list'=>implode(',',$jobId),'count'=>$count];
}
?>