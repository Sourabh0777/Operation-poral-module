<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Loginrequest;
use App\Models\User;
use App\Models\Employeeprofile;
use App\Models\Client;
use App\Models\Jobwork;
use App\Models\Jobcounter;
class Marketingcontroller extends Controller
{
    //

    public function post_new_job(){
        $data['users'] = Auth::user();
        $data['Jobwork'] = Jobwork::class;
        $data['joblist'] = Jobwork::with(['Client'])->get();
        $data['Writer'] = User::where('emp_type','Writer')->get();
        // dd($data['joblist']);
        $data['Client'] = Client::where('status','Active')->get();

        return view('Admin.post_new_job',$data);
    }
    public function update_new_job(Request $request){

        $Jobwork = Jobwork::find($request->input('id'));
        $Jobwork->status = $request->input('status');
        $Jobwork->extra_notes = $request->input('extra_notes');
        $Jobwork->save();
        return redirect(route('post-new-job'));
    }
    public function save_new_job(Request $request){
        // dd($request->file);
        // $fileName = str_replace(' ','_',$request->file->getClientOriginalName()).'_'.time().'.'.$request->file->extension();  
       
        // $request->file->move(public_path('uploads'), $fileName);

        $files  = $request->file('jobfiles');
        $file_name_array = [];
        foreach ($files as $key => $file) {
            $fileName = str_replace(' ','_',$file->getClientOriginalName()).'_'.time().'.'.$file->extension();  
       
             $file->move(public_path('uploads'), $fileName);

             $file_name_array[] = $fileName;
        }

        $Jobwork = new Jobwork();
        $Jobwork->jobnumber     = $request->input('jobNo');
        $Jobwork->jobtype       = $request->input('jobtype');
        $Jobwork->category      = $request->input('category');
        $Jobwork->client_id     = $request->input('client');
        $Jobwork->receive_date  = date('Y-m-d',strtotime($request->input('rec_date')));
        $Jobwork->deadline      = date('Y-m-d',strtotime($request->input('deadline')));
        $Jobwork->words         = $request->input('words');
        $Jobwork->requirement   = $request->input('requirement');
        $Jobwork->drive_link    = $request->input('drive_link');
        $Jobwork->attachment    = json_encode($file_name_array);//$fileName;
        $Jobwork->user_id = Auth::user()->id;
        $Jobwork->status  = 'pending';
        $Jobwork->save();

        $Jobcounter = Jobcounter::find(1);
        $Jobcounter->counter+=1;
        $Jobcounter->save();

        // return redirect(route('post-new-job')); 
        return redirect()->back();


    }
}
