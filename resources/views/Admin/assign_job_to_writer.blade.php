@include('Admin.header');
@include('Admin.sidebar');
<style>
   label{
       color:#000;
   }
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
     <div class="container-fluid">
       <div class="row">
           <div class="col-12">
           <div class="card">
            @if (session('res'))
            @foreach(session()->get('res')  as $arr)
            <div class="alert alert-danger">
              {{ $arr }}
          </div>
              @endforeach
   
@endif
             <div class="card-header">
               <h3 class="card-title">Job Details</h3>
             </div>
             <!-- /.card-header -->
             <div class="card-body">
               
               <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                   <div class="row">
                       <div class="col-sm-2">
                       
                        <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-jobAssign" onclick="setjobId({{$jobworks->id}})">Add Writer</button>
                      
                      
                       </div>
                   <div class="col-sm-12 col-md-6">
                   
                   </div><div class="col-sm-12 col-md-6">

                   </div></div>
                   <div class="row">
                       <div class="col-sm-12">
                        <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                 <thead>
                 <tr>
                    <th>Job Number</th>
                    <th>Job Type</th>
                    <th>Category</th>                    
                    <th>Received Date</th>
                    <th>DeadLine</th>
                    <th>Number of Words</th>
                    <th>Words Remain</th>
                    <th>Requirements</th>
                    <th>Drive Link</th>
                    <th>Attachment</th>
                    <th>Status</th>
                    
                    
                   </tr>
                 </thead>
                   <tbody>
                    <tr>
                        <td>{{$jobworks->jobnumber}}</td>
                        <td>{{$jobworks->jobtype}}</td>
                        <td>{{$jobworks->category}}</td>
                        <td>{{$jobworks->receive_date}}</td>
                        <td>{{$jobworks->deadline}}</td>
                        <td>{{$jobworks->words}}</td>
                        <td>{{totalassign($jobworks->id,$jobworks->words)}}</td>
                        <td>{!!$jobworks->requirement!!}</td>
                        <td>{{$jobworks->drive_link}}</td>
                        <td>
                          @if ($jobworks->attachment!="")
                              @foreach (json_decode($jobworks->attachment) as $row)
                              <a href="{{asset('uploads').'/'.$row}}" target="_blank">Download</a>
                              @endforeach
                          @endif
                          </td>
                        <td> <span class="text text-{{$jobworks->status=='pending'?'warning':($jobworks->status=='Rejected'?'danger':'success')}}">
                            {{$jobworks->status}}
                          </span> </td>
                    </tr>
                      
                   </tbody>
                 <tfoot>
                 <tr>
                    <th>Job Number</th>
                    <th>Job Type</th>
                    <th>Category</th>                    
                    <th>Received Date</th>
                    <th>DeadLine</th>
                    <th>Number of Words</th>
                    <th>Words Remain</th>
                    <th>Requirements</th>
                    <th>Drive Link</th>
                    <th>Attachment</th>
                    <th>Status</th>
                    
                   
                   </tr>
                  </tfoot>
               </table></div></div>
               
             </div>
             <!-- /.card-body -->
           </div>
           </div>
      
       </div><!-- /.row -->
     </div><!-- /.container-fluid -->

     <div class="row">
        <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Job Allocation List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-hover dataTable dtr-inline">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Writer Name</th>
                            <th>Typing Speed</th>
                            <th>Alloted Word</th>
                            <th>Dead Line</th>
                            <th>Job Status</th>
                            <th>Action</th>

                        </tr>
                        
                    </thead>
                    <tbody>
                        @if ($assigned)
                            @foreach ($assigned as $index=>$item)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{getemp_name($item->user_id)}}</td>
                                    <td>{{getTypeSpeed($item->user_id)}}</td>
                                    <td>{{$item->word}}</td>
                                    <td>{{date('d-m-Y H:i:s',strtotime($item->dead_line))}}</td>
                                    <td>{{$item->status}}</td>
                                    <td><a href="{{route('delete-job-from-writer',$item->id)}}" onclick="return confirm('Are You Sure')">Delete</a></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
              </div>
            </div>
        </div>
     </div> 
     </div>
   </div>
   <!-- /.content-header -->

   <!-- Main content -->
 
   <!-- /.content -->
   </div></div>
 
 <!-- /.content-wrapper -->
 @include('Admin.footer');

 <div class="modal fade" id="modal-jobAssign">
 <div class="modal-dialog">
   <div class="modal-content bg-info">
     <div class="modal-header">
       <h4 class="modal-title"></h4>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body">
      <form action="{{route('assign-job-to-writer')}}" method="post">
         @csrf()
         <input type="hidden" name="job_id" id="job_id">
      <div class="card card-warning">
       <div class="card-header">
         <h3 class="card-title">Assign Job</h3>
       </div>
       <!-- /.card-header -->
       <div class="card-body">
        
           <div class="row">
             
           <div class="col-sm-12">
             <!-- text input -->
             <div class="form-group">
               <label>Select Writer</label>
               <select name="writer[]" id="" required class="form-control select2" multiple="multiple" data-placeholder="Select Writer" >
                 <option value="">Select</option>
                 @if ($Writer)
                     @foreach ($Writer as $item)
                         @if ($item->emp_type=='Writer')
                         <option value="{{$item->id}}">{{$item->name}} - Limit: {{getTypeSpeed($item->id) - used_word($item->id)}}</option>
                         @endif
                     @endforeach
                 @endif
                
               </select>
             </div>
           </div>
           </div>
           <div class="row">
           <div class="col-sm-6">
             <!-- text input -->
             <div class="form-group">
               <label>Words</label>
               <input type="text" name="word" id="" class="form-control" required>
             </div>
           </div>
          
           <div class="col-sm-6">
             <!-- text input -->
             <div class="form-group">
               <label>Deadline</label>
               <input type="datetime-local" name="deadline" id="reservationdatetime" class="form-control reservationdatetime " required>
             </div>
           </div>
           </div>
           <div class="row">
             
             <div class="col-sm-8">
               <!-- text input -->
               <div class="form-group">
                 <label>Instructions</label>
                 
                  <textarea name="extra_notes" id="" cols="30" rows="10" required class="form-control summernote"></textarea>
                 
               </div>
             </div>
             
            
              
             </div>
         </div>
       
       </div>
       <!-- /.card-body -->
       <div class="card-footer">
           <button type="submit" class="btn btn-warning">Assign</button>
           <button type="reset" class="btn btn-default float-right" data-dismiss="modal">Cancel</button>
         </div>
     </div>
      </form>
     </div>
     <div class="modal-footer justify-content-between">
       
     </div>
   </div>
   <!-- /.modal-content -->
 </div>
 
 
 
  <!-- /.modal-dialog -->
 
     
     </div>
     <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
     <script src="{{asset('assets/custom/jquery.datetimepicker.min.js')}}"></script>
     
     <script>
        // $('#reservationdatetime').datetimepicker({
        //     startDate:'+2024/01/01'         
        // });
      function setId(id){
        $("#id").val(id);
      }
      function setjobId(id){
        $("#job_id").val(id)
      }
     $( function() {
       $( ".datepicker" ).datepicker({
         changeMonth: true,
         changeYear: true
       });
     } );

     function load_client_info(id){
        $.ajax({
          url:"{{route('load-client-info')}}",
          type:'POST',
          data:{
            "_token": "{{ csrf_token() }}",
            "id":id
          },
          success:function(res){
            $("#id").val(res.id);
            $("#client_name").val(res.clientname);
            $("#email").val(res.email);
            $("#mob").val(res.mob);
            $("#address").text(res.address);
            $("#extra_info").text(res.extra_info);
          }
        })
     }
     function delete_client(id){
      if(confirm("Are you Sure?")){
        $.ajax({
          url:"{{route('delete-client-info')}}",
          type:'POST',
          data:{
            "_token": "{{ csrf_token() }}",
            "id":id
          },
          success:function(res){
            window.location.reload();
          }
        })
      }
      
     }
     </script>