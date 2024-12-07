@include('Admin.header');
@include('Admin.sidebar');
<style>
   label{
       color:#000;
   }
   .note-editable>p{
    color:#000;
   }
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.0/css/dataTables.dataTables.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
     <div class="container-fluid">
      <div class="row">
        <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">All Fresh Job Listed Below</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
              
                <div class="row">
                    <div class="col-sm-12">
                      <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
              <thead>
              <tr>
                 <th>SL</th>
                 <th>Job Id</th>
                 {{-- <th>Job Title</th> --}}
                 <th>Assign By </th>                 
                 <th>Attachment</th>
                 <th>Drive Link</th>
                 <th>Job Information</th>
                 <th>Operation Instructions</th>
                 <th>Dead Line</th>
                 <th>Words</th>
                 <th>Assign Date</th>
                 <th>Status</th>
                 <th>Query Status</th>
                 <th>Action</th>
                </tr>
              </thead>
                <tbody>
                @if ($my_job)
                    @foreach ($my_job as $index=>$item)
                    
                        <tr>
                         <td>{{$index+1}}</td>
                         <td>{{getJobId($item->job_id)}}</td>
                         <td>{{getUsername($item->assign_by)}}</td>                         
                         {{-- <td><a href="{{asset('uploads').'/'.attahment($item->job_id)}}" target="_blank">Download</a></td> --}}
                         <td>  @if (attahment($item->job_id)!="")
                          @foreach (json_decode(attahment($item->job_id)) as $row)
                          <a href="{{asset('uploads').'/'.$row}}" target="_blank">Download</a>
                          @endforeach
                      @endif</td>
                         <td>{{drivelink($item->job_id)}}</td>
                         <td>{!!jobinformation($item->job_id)!!}</td>
                         <td>{!!$item->extra_information!!}</td>
                         <td>{{$item->dead_line}}</td>
                         <td>{{$item->word}}</td>
                         <td>{{$item->created_at}}</td>
                         <td>{{$item->status}}</td>
                         <td><i class="fa fa-check" aria-hidden="true"></i></td>
                         <td>
                             @if ($item->status=='Started')
                             <a href="#" data-toggle="modal" data-target="#modal-info-edit" onclick="edit_my_job({{$item->id}})" class="btn btn-warning">Submit Work</a>
                             <a href="{{route('stop-job',$item->id)}}" class="btn btn-danger" >Stop Job</a>
                             <a href="#" data-toggle="modal" data-target="#modal-info-extension" onclick="edit_ext_job({{$item->id}})" class="btn btn-info">Request</a>
                             @endif
                             @if ($item->status=='Assign')
                             <a href="{{route('start-job',$item->id)}}" class="btn btn-success" >Start Job</a>
                             @endif
                             @if (in_array($item->status,['Started','Assign','Rework']))
                             <a href="{{route('ticket-section',$item->id)}}" class="btn btn-warning" >Query</a>
                             @endif
                           
                             <a href="{{route('split-job-section',$item->job_id)}}" class="btn btn-info" >Split Works Status</a>
                             <a href="{{route('direct-chat',$item->job_id)}}" class="btn btn-info" >Chat</a>
                         </td>
                        </tr>
                    @endforeach
                @endif
                   
                </tbody>
              <tfoot>
                 <tr>
                     <th>SL</th>
                     <th>Job Id</th>
                     <th>Assign By </th>                     
                     <th>Attachment</th>
                     <th>Drive Link</th>
                     <th>Job Information</th>
                     <th>Operation Instructions</th>
                     <th>Dead Line</th>
                     <th>Words</th>
                     <th>Assign Date</th>
                     <th>Status</th>
                     <th>Query Status</th>
                     <th>Action</th>
                    </tr>
               </tfoot>
            </table></div></div>
            
          </div>
          <!-- /.card-body -->
        </div>
        </div>
   
    </div><!-- /.row -->
    @php
        // dd($my_job_rework);
    @endphp
  </div><!-- /.container-fluid -->
       <div class="row">
           <div class="col-12">
           <div class="card">
             <div class="card-header">
               <h3 class="card-title">All Rework Job Listed Below</h3>
             </div>
             <!-- /.card-header -->
             <div class="card-body">
               
               <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                 
                   <div class="row">
                       <div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                 <thead>
                 <tr>
                    <th>SL</th>
                    <th>Job Id</th>
                    {{-- <th>Job Title</th> --}}
                    <th>Assign By </th>
                    <th>Attachment</th>
                    <th>Drive Link</th>
                    <th>Job Information</th>
                    <th>Operation Instructions</th>
                    <th>Dead Line</th>
                    <th>Rework Counter</th>
                    <th>Words</th>
                    <th>Assign Date</th>
                    <th>Status</th>
                    <th>Working Attachment</th>
                    <th>Query Status</th>
                    <th>Action</th>
                   </tr>
                 </thead>
                   <tbody>
                   @if ($my_job_rework)
                       @foreach ($my_job_rework as $index=>$item)
                       
                           <tr>
                            <td>{{$index+1}}</td>
                            <td>{{getJobId($item->job_id)}}</td>
                            <td>{{getUsername($item->assign_by)}}</td>
                            <td>
                              @foreach (json_decode(attahment($item->job_id)) as $file)
                              <a href="{{asset('uploads').'/'.$file}}" target="_blank">Download</a>
                              @endforeach
                            </td>
                            <td>{{drivelink($item->job_id)}}</td>
                            <td>{!!jobinformation($item->job_id)!!}</td>
                            <td>{!!$item->extra_information!!}</td>
                            <td>{{$item->dead_line}}</td>
                            <td>{{$item->rework_counter}}</td>
                            <td>{{$item->word}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>{{$item->status}}</td>
                            <td>

                                @if ($item->writer_attachment!="")
                                    @foreach (json_decode($item->writer_attachment) as $file)
                                    <a href="{{asset('uploads').'/'.$file}}" target="_blank">Download</a>
                                    @endforeach
                                @endif

                            </td>
                            <td><i class="fa-solid fa-check"></i></td>
                            <td>
                                @if ($item->status=='Started')
                                <a href="#" data-toggle="modal" data-target="#modal-info-edit" onclick="edit_my_job({{$item->id}})" class="btn btn-warning">Submit Work</a>
                                <a href="{{route('stop-job',$item->id)}}" class="btn btn-danger" >Stop Job</a>
                                <a href="#" data-toggle="modal" data-target="#modal-info-extension" onclick="edit_ext_job({{$item->id}})" class="btn btn-info">Request</a>
                                @endif
                                @if (in_array($item->status,['Assign','Rework']))
                                  @if ($item->rework_start_status==1)
                                    <a href="{{route('start-job',$item->id)}}" class="btn btn-success" >Start Job</a>
                                  @elseif($item->rework_start_status==0)
                                    <a href="javascript:void(0)" onclick="setword('{{$item->id}}')" class="btn btn-info" >Set Re-Word</a>
                                  @else
                                  <p class="text-danger">Waiting for Rework Word Confirmation</p>
                                  @endif
                               
                                
                                @endif
                                @if (in_array($item->status,['Started','Assign','Rework']))
                                <a href="{{route('ticket-section',$item->id)}}" class="btn btn-warning" >Query</a> 
                                @endif
                                
                             
                            </td>
                           </tr>
                       @endforeach
                   @endif
                      
                   </tbody>
                 <tfoot>
                    <tr>
                        <th>SL</th>
                        <th>Job Id</th>
                        <th>Assign By </th>
                        <th>Attachment</th>
                        <th>Drive Link</th>
                        <th>Job Information</th>
                        <th>Operation Instructions</th>
                        <th>Dead Line</th>
                        <th>Rework Counter</th>
                        <th>Words</th>
                        <th>Assign Date</th>
                        <th>Status</th>
                        <th>Working Attachment</th>
                        <th>Query Status</th>
                        <th>Action</th>
                       </tr>
                  </tfoot>
               </table></div></div>
               
             </div>
             <!-- /.card-body -->
           </div>
           </div>
      
       </div><!-- /.row -->
       
     </div><!-- /.container-fluid -->
   </div>
   <!-- /.content-header -->

   <!-- Main content -->
 
   <!-- /.content -->
   </div></div>
 
 <!-- /.content-wrapper -->
 @include('Admin.footer');
 <div class="modal fade" id="modal-info-edit">
  <div class="modal-dialog">
    <div class="modal-content bg-info">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form action="{{route('update-job-form')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id">
          @csrf()
       <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title">Edit Job Form</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
         
            <div class="row">
            
             
             <div class="col-sm-12">
               <!-- text input -->
               <div class="form-group">
                 <label>Attachment</label>
                 <input type="file" name="attachment[]" id="file" class="form-control" required multiple>
               </div>
             </div>
             <div class="col-sm-12">
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Item 1" id="flexCheckDefault" name="cond[]">
                  <label class="form-check-label" for="flexCheckDefault">
                    Item 1
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Item 1" id="flexCheckDefault" name="cond[]">
                  <label class="form-check-label" for="flexCheckDefault">
                    Item 2
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Item 1" id="flexCheckDefault" name="cond[]">
                  <label class="form-check-label" for="flexCheckDefault">
                    Item 3
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Item 1" id="flexCheckDefault" name="cond[]">
                  <label class="form-check-label" for="flexCheckDefault">
                    Item 4
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Item 1" id="flexCheckDefault" name="cond[]">
                  <label class="form-check-label" for="flexCheckDefault">
                    Item 5
                  </label>
                </div>
                
              </div>
             </div>
            </div>
            
          </div>
        
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-warning finalsub" disabled>Save</button>
            <button type="submit" class="btn btn-default float-right" data-dismiss="modal">Cancel</button>
          </div>
      </div>
       </form>
      </div>
      <div class="modal-footer justify-content-between">
        
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <div class="modal fade" id="modal-info-extension">
    <div class="modal-dialog">
      <div class="modal-content bg-info">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <form action="{{route('job-extension-request')}}" method="post" enctype="multipart/form-data">
          <input type="hidden" name="job_id" id="job_id">
            @csrf()
         <div class="card card-warning">
          <div class="card-header">
            <h3 class="card-title">Edit Job Form</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
           
              <div class="row">
              
               
               <div class="col-sm-12">
                 <!-- text input -->
                 <div class="form-group">
                   <label>Your Message</label>
                  <textarea name="message" id="message" class="form-control summernote" cols="30" rows="10"></textarea>
                 </div>
               </div>
               
              </div>
              
            </div>
          
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
              <button type="submit" class="btn btn-warning ">Request</button>
              <button type="submit" class="btn btn-default float-right" data-dismiss="modal">Cancel</button>
            </div>
        </div>
         </form>
        </div>
        <div class="modal-footer justify-content-between">
          
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
       
         <!-- /.modal-content -->
       </div>
       <!-- /.modal-dialog -->
     </div>
     <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
     <script src="https://cdn.datatables.net/v/bs4/dt-2.1.0/datatables.min.js"></script>
     <script>
      function setword(jobid){
        let word = prompt("Please set Rework word:")
        word = parseInt(word)
        if(word>0){
          $.ajax({
        url:"{{route('set-rework-word')}}",
        type:'POST',
        data:{
          "_token":"{{csrf_token()}}",
          "id":jobid,
          "word":word
        },
        success:function(res){
            alert("Request Sent. Please wait for confirmation")           
        }
      })
        }
       
      }
      var selected = [];
      $(document).ready(function() {
        $(".table").DataTable();
    // Assuming your checkbox list has the class "checkbox-list"
    var totalchkbxk = 0;
    var totalcked = 0; 
    $('input[type="checkbox"]').each(()=>{
      totalchkbxk+=1;
    })
    console.log(totalchkbxk);
    $('input[type="checkbox"]').change(function() {
        if ($(this).is(':checked')) {
            // Checkbox is checked
            console.log($(this).val() + ' is checked.');
            totalcked++;
            // You can perform additional actions here
        } else {
            // Checkbox is unchecked
            console.log($(this).val() + ' is unchecked.');
            // You can perform additional actions here
            totalcked--;
        }
        if(totalchkbxk==totalcked || totalcked==5){
          $(".finalsub").removeAttr('disabled')
        }else{
          $(".finalsub").attr('disabled','disabled')
        }
    });
});

        
        function edit_my_job(id){
            $("#id").val(id)
        }
        function edit_ext_job(id){
            $("#job_id").val(id)
        }
     $( function() {
       $( ".datepicker" ).datepicker({
         changeMonth: true,
         changeYear: true
       });
     } );
     function load_emp_data(id,emp_type){
      $("#emp_type_label").text("");
      if(emp_type=="Writer"){
        $("#emp_type_label").text("Team Leader");
      }
      else if(emp_type=="TL"){
        $("#emp_type_label").text("QC");
      }
      else{
        $(".super_emp").hide();
      }

      $.ajax({
        url:"{{route('load-emp-data')}}",
        type:'POST',
        data:{
          "_token":"{{csrf_token()}}",
          "id":id
        },
        success:function(res){
            $("#id").val(id);
            $("#name").val(res[0].name);
            $("#email").val(res[0].email);
            $("#doj").val(res[0].employeeprofile.doj);
            $("#mob").val(res[0].employeeprofile.mob);
            $("#area_of_exp").text(res[0].employeeprofile.area_of_exp);
           
        }
      })
     }
     function deleteemp(id){
      if(confirm("Are you sure?")){
        $.ajax({
          url:"{{route('delete-employee')}}",
          type:'POST',
          data:{
            "_token":"{{csrf_token()}}",
            "id":id,
          },
          success:function(res){
            if(res.success){
              window.location.reload();
            }
          }
        })
      }
     }
     </script>