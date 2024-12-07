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
               <h3 class="card-title">All Jobs Listed Below</h3>
             </div>
             <!-- /.card-header -->
             <div class="card-body">
               
               <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                   <div class="row">
                       <div class="col-sm-2">
                        @if ($users->emp_type=='Marketing')
                        <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-info">Add</button>
                        @endif
                      
                       </div>
                   <div class="col-sm-12 col-md-6">
                   
                   </div><div class="col-sm-12 col-md-6">

                   </div></div>
                   <div class="row">
                       <div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                 <thead>
                 <tr>
                    <th>SL</th>
                    <th>Job Number</th>
                    <th>Job Type</th>
                    <th>Category</th>
                    <th>Client</th>
                    <th>Received Date</th>
                    <th>DeadLine</th>
                    <th>Number of Words</th>
                    <th>Requirements</th>
                    <th>Drive Link</th>
                    <th>Attachment</th>
                    <th>Created At</th>
                    <th>Update At</th>
                    <th>Status</th>
                    <th>Job status info</th>
                    @if ($users->emp_type=='Operation')
                    <th>Action</th>
                    @endif
                   </tr>
                 </thead>
                   <tbody>
                    @if ($joblist)
                        @foreach ($joblist as $index=>$item)
                            <tr>
                              <td>{{$index+1}}</td>
                              <td>
                                @if ($item->status=='Approve')
                                <a href="{{route('assign-to-writer',$item->id)}}">{{$item->jobnumber}}</a>  
                                @elseif($item->status=='Assign')
                                <a href="{{route('assign-to-writer',$item->id)}}">{{$item->jobnumber}}</a>  
                                @else
                                <a href="javascript:void(0)">{{$item->jobnumber}}</a>
                                @endif
                               
                              </td>
                              <td>{{$item->jobtype}}</td>
                              <td>{{$item->category}}</td>
                              <td>{{$item->client->clientname}}</td>
                              <td>{{date('d-m-Y',strtotime($item->receive_date))}}</td>
                              <td>{{date('d-m-Y',strtotime($item->deadline))}}</td>
                              <td>{{$item->words}}</td>
                              <td>{!!$item->requirement!!}</td>
                              <td>{{$item->drive_link}}</td>
                              <td>
                                @if ($item->attachment)
                                    @foreach (json_decode($item->attachment) as $file)
                                    <a href="{{asset('uploads').'/'.$file}}" target="_blank">Download</a>
                                    @endforeach
                                @endif
                                
                              </td>
                              <td>{{$item->created_at}}</td>
                              <td>{{$item->updated_at}}</td>
                              <td>
                              <span class="text text-{{$item->status=='pending'?'warning':($item->status=='Rejected'?'danger':'success')}}">
                                {{$item->status}}
                              </span>  
                              </td>
                              <td>{!!$item->extra_notes!!}</td>
                              @if ($users->emp_type=='Operation')
                                  @if ($item->status=='pending')
                                  <td>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-info2" class="btn btn-warning" onclick="setId({{$item->id}})">Edit</a>
                                  </td>
                                  @endif
                                  @if ($item->status=='Assign')
                                  <td>
                                    <a href="{{route('see-the-progress',$item->id)}}"  class="btn btn-warning" onclick="setId({{$item->id}})">Progress</a>
                                  </td>
                                  @else
                                  <td></td>
                                  @endif
                             
                              @endif
                            </tr>
                        @endforeach
                    @endif
                      
                   </tbody>
                 <tfoot>
                 <tr>
                    <th>SL</th>
                    <th>Job Number</th>
                    <th>Job Type</th>
                    <th>Category</th>
                    <th>Client</th>
                    <th>Received Date</th>
                    <th>DeadLine</th>
                    <th>Number of Words</th>
                    <th>Requirements</th>
                    <th>Drive Link</th>
                    <th>Attachment</th>
                    <th>Created At</th>
                    <th>Update At</th>
                    <th>Status</th>
                    <th>Job status info</th>
                    @if ($users->emp_type=='Operation')
                    <th>Action</th>
                    @endif
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
                          <option value="{{$item->id}}">{{$item->name}}</option>
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
                <input type="text" name="word" id="" class="form-control">
              </div>
            </div>
           
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Deadline</label>
                <input type="text" name="deadline" id="" class="form-control datepicker">
              </div>
            </div>
            </div>
            <div class="row">
              
              <div class="col-sm-8">
                <!-- text input -->
                <div class="form-group">
                  <label>Instructions</label>
                  
                   <textarea name="extra_notes" id="" cols="30" rows="10" required class="form-control"></textarea>
                  
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
 <div class="modal fade" id="modal-info2">
  <div class="modal-dialog">
    <div class="modal-content bg-info">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form action="{{route('update-new-job')}}" method="post">
          @csrf()
          <input type="hidden" name="id" id="id">
       <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title">Edit Job</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
         
            <div class="row">
              
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Status</label>
                <select name="status" id="" required class="form-control">
                  <option value="">Select</option>
                  <option value="pending">Pending</option>
                  <option value="Approve">Approve</option>
                  <option value="Rejected">Rejected</option>
                </select>
              </div>
            </div>
            
           
             
            </div>
            <div class="row">
              
              <div class="col-sm-8">
                <!-- text input -->
                <div class="form-group">
                  <label>Comment for Status Change</label>
                  
                   <textarea name="extra_notes" id="" cols="30" rows="10" required class="form-control summernote"></textarea>
                  
                </div>
              </div>
              
             
               
              </div>
          </div>
        
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-warning">Save</button>
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
 <div class="modal fade" id="modal-info">
  <div class="modal-dialog">
    <div class="modal-content bg-info">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form action="{{route('save-new-job')}}" method="post" enctype="multipart/form-data">
          @csrf()
          
       <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title">Post New Job</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
         
            <div class="row">
              <div class="col-sm-4">
                <!-- text input -->
                <div class="form-group">
                  <label>Job Number</label>
                  <input type="text" value="{{getJobnumber()}}" id="client_name" class="form-control" placeholder="Enter ..." name="jobNo" readonly>
                </div>
              </div>
              <div class="col-sm-4">
               <!-- text input -->
               <div class="form-group">
                 <label>Job Type</label>
                 <select name="jobtype" id="" class="form-control" required>
                  <option value="">Select</option>
                  @foreach ($Jobwork::getPossibleEnumValues() as $item)
                    <option value="{{$item}}">{{$item}}</option>
                  @endforeach
                  
                  {{-- <option value=""></option> --}}
                 </select>
               </div>
             </div>
          
             <div class="col-sm-4">
               <!-- text input -->
               <div class="form-group">
                 <label>Category</label>
                 <select name="category" id="" class="form-control" required>
                  <option value="">Select</option>
                  <option value="Management">Management</option>
                  <option value="IT">IT</option>
                  <option value="Law">Law</option>
                 </select>
               </div>
             </div>
             <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Select Client</label>
                <select name="client" id="" class="form-control" required>
                  <option value="">Select</option>
                  @if ($Client)
                      @foreach ($Client as $item)
                      <option value="{{$item->id}}">{{$item->clientname}} || {{$item->email}}  ||{{$item->mob}}  </option>
                      @endforeach
                  @endif
                 
                 </select>
              </div>
            </div>
             <div class="col-sm-4">
               <!-- text input -->
               <div class="form-group">
                 <label>Received Date:</label>
               <input type="text" name="rec_date" id="" class="form-control datepicker" required>
               </div>
             </div>
             <div class="col-sm-4">
               <!-- text input -->
               <div class="form-group">
                 <label>Deadline</label>
                 <input type="text" name="deadline" id="" class="form-control datepicker" required>
               </div>
             </div>
             <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Words</label>
                <input type="text" name="words" id="" class="form-control" required value="0">
              </div>
            </div>
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Requirement</label>
                <textarea name="requirement" id="" cols="30" rows="3" class="form-control summernote" required></textarea>
              </div>
            </div>
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Drive link</label>
                <input type="text" name="drive_link" id="" class="form-control" required>
              </div>
            </div>
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Attachment</label>
                <input type="file" name="jobfiles[]" id="" class="form-control" multiple required>
              </div>
            </div>
           
             
            </div>
            
          </div>
        
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-warning">Save</button>
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
  <!-- /.modal-dialog -->
 
     
     </div>
     <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
     <script src="https://cdn.datatables.net/v/bs4/dt-2.1.0/datatables.min.js"></script>
     
     <script>
      $(document).ready(function(){
        $("#example2").DataTable();
      })
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