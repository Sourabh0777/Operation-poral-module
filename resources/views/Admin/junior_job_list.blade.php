@include('Admin.header');
@include('Admin.sidebar');
<style>
   label{
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
                 <th>Assign To </th>    
                 <th>TL</th>      
                 <th>Attachment</th>
                 <th>Drive Link</th>
                 <th>Job Information</th>
                 <th>Operation Instructions</th>
                 <th>Dead Line</th>
                 <th>Words</th>
                 <th>Assign Date</th>
                 <th>Status</th>
                 <th>Working Attachment</th>
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
                         <td>{{getUsername($item->user_id)}}</td>   
                         <td>{{getUserParentname($item->user_id)}}</td>                    
                         <td><a href="{{asset('uploads').'/'.attahment($item->job_id)}}" target="_blank">Download</a></td>
                         <td>{{drivelink($item->job_id)}}</td>
                         <td>{!! jobinformation($item->job_id) !!}</td>
                         <td>{!!$item->extra_information!!}</td>
                         <td>{{$item->dead_line}}</td>
                         <td>{{$item->word}}</td>
                         <td>{{$item->created_at}}</td>
                         <td>{{$item->status}}</td>
                         <td>

                          @if ($item->writer_attachment!="")
                              @foreach (json_decode($item->writer_attachment) as $row)
                              <a href="{{asset('uploads').'/'.$row}}" target="_blank">Download</a>
                              @endforeach
                          @endif

                      </td>
                         <td>
                             @if ($item->status!='Assign')
                             <a href="#" data-toggle="modal" data-target="#modal-info-edit" onclick="edit_my_job({{$item->id}})" class="btn btn-warning">Submit Work</a>
                             @endif
                             @if ($item->status=='Assign')
                             {{-- <a href="{{route('start-job',$item->id)}}" class="btn btn-success" >Start Job</a> --}}
                             @endif
                             
                             <a href="{{route('ticket-section',$item->id)}}" class="btn btn-warning" >Query</a>
                          
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
                     <th>Assign To </th>    
                     <th>TL</th>                 
                     <th>Attachment</th>
                     <th>Drive Link</th>
                     <th>Job Information</th>
                     <th>Operation Instructions</th>
                     <th>Dead Line</th>
                     <th>Words</th>
                     <th>Assign Date</th>
                     <th>Status</th>
                     <th>Working Attachment</th>
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
                    <th>Assign To </th>
                    <th>TL</th>    
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
                            <td>{{getUsername($item->user_id)}}</td>
                            <td>{{getUserParentname($item->user_id)}}</td>  
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
                                  @foreach (json_decode($item->writer_attachment) as $row)
                                  <a href="{{asset('uploads').'/'.$row}}" target="_blank">Download</a>
                                  @endforeach
                              @endif

                          </td>
                            <td>
                                @if ($item->status=='Started' || $item->status=='Waiting for TL' || $item->status=='Waiting for QC')
                                <a href="#" data-toggle="modal" data-target="#modal-info-edit" onclick="edit_my_job({{$item->id}})" class="btn btn-warning">Submit Work</a>
                                @endif
                                @if ($item->status=='Assign')
                                <a href="{{route('start-job',$item->id)}}" class="btn btn-success" >Start Job</a>
                                @endif
                                
                                <a href="{{route('ticket-section',$item->id)}}" class="btn btn-warning" >Query</a>
                             
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
                        <th>Assign To </th>
                        <th>TL</th>    
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
            
              <!-- text input -->
              @if ($users->emp_type=='TL' || $users->emp_type=='QC' || $users->emp_type=='Operation' || $users->emp_type=='Marketing' )
              <div class="col-sm-12">
              <div class="form-group">
                <label>Status</label>
                <Select class="form-control" name="status">
                  @if ($users->emp_type=='TL')
                  <option value="Rework">Rework</option>
                  <option value="Waiting for QC">Waiting for QC</option>
                  @endif
                  @if ($users->emp_type=='QC')
                  <option value="Rework">Rework</option>
                  <option value="Waiting for Marketing">Waiting for Marketing</option>
                  @endif
                  @if ($users->emp_type=='Operation' || $users->emp_type=='Marketing')
                  <option value="Rework">Rework</option>
                  <option value="Ready">Ready</option>
                  @endif
                </Select>
              </div>
            </div>
              <div class="col-sm-12">
                <!-- text input -->
                <div class="form-group">
                  <label>Notes</label>
                  <textarea name="notes" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
              </div>
              @endif

              @if ($users->emp_type=='QC5')
              <div class="col-sm-12">
              <div class="form-group">
                <label>Status</label>
                <Select class="form-control" name="status">
                    <option value="Rework">Rework</option>
                    <option value="Finished">Finished</option>
                </Select>
              </div>
            </div>
              <div class="col-sm-12">
                <!-- text input -->
                <div class="form-group">
                  <label>Notes</label>
                  <textarea name="notes" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
              </div>
              @endif
              
         
           
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
 
       
         <!-- /.modal-content -->
       </div>
       <!-- /.modal-dialog -->
     </div>
     <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
     <script src="https://cdn.datatables.net/v/bs4/dt-2.1.0/datatables.min.js"></script>
     <script>
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
        if(totalchkbxk==totalcked){
          $(".finalsub").removeAttr('disabled')
        }else{
          $(".finalsub").attr('disabled','disabled')
        }
    });
});

        
        function edit_my_job(id){
            $("#id").val(id)
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