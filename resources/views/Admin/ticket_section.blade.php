@include('Admin.header');
@include('Admin.sidebar');
<style>
   label{
       color:#000;
   }
   .ck-content{
    color:#000;
   }
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
     <div class="container-fluid">
       <div class="row">
           <div class="col-12">
           <div class="card">
             <div class="card-header">
               <h3 class="card-title">All Query Listed Below</h3>
             </div>
             <!-- /.card-header -->
             <div class="card-body">
               
               <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-md-2">
                        <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-info">Open New</button>
                      
                        </div>
                    </div>
                   <div class="row">
                       <div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                 <thead>
                 <tr>
                    <th>SL</th>    
                    <th>Posted By</th>
                    <th>Ticket</th>              
                    <th>Title</th>
                    <th>Query</th>
                    <th>Status</th>
                    <th>Query Status</th>
                    <th>Action</th>
                   </tr>
                 </thead>
                   <tbody>
                    @if($tickets)
                        @foreach($tickets as $index=>$row)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{getUsername($row->posted_by)}}</td>
                                <td>{{$row->ticket_id}}</td>
                                <td>{{$row->title}}</td>
                                <td>{!!$row->ticket_message!!}</td>
                                <td>
                                   {{$row->ticket_status}}
                                </td>
                                <th>
                                  @if ($row->ticket_status=='Closed')
                                  <i class="fa fa-check" aria-hidden="true"></i>
                                  @else
                                  <i class="fa fa-times" aria-hidden="true"></i>
                                  @endif
                                 
                                
                                </th>
                                <td>
                                <a class="btn btn-app" onclick="load_messages({{$row->id}})">
                                <span class="badge bg-danger badge_{{$row->id}}">{{counttotalunread($row->id,$users->id)}}</span>
                                        <i class="fas fa-bullhorn"></i> Notifications
                                </a>
                                @if ($users->emp_type=='Writer' && $row->ticket_status!='Closed')

                                <a href="{{route('query-solved',$row->id)}}" class="btn btn-success" ><i class="fa fa-check" aria-hidden="true"></i> Query Solved</a>
                            @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                      
                   </tbody>
                 <tfoot>
                  <tr>
                    <th>SL</th>    
                    <th>Posted By</th>
                    <th>Ticket</th>              
                    <th>Title</th>
                    <th>Query</th>
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
      
       <div class="row">
        <div class="col-12">
        <div class="card card-primary card-outline direct-chat direct-chat-primary" style="display: none;">
              <div class="card-header">
                <h3 class="card-title">Direct Chat</h3>

                <div class="card-tools">
                  <span title="3 New Messages" class="badge bg-primary">3</span>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                  </button>
                 
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages">
                 
                </div>
                <!--/.direct-chat-messages-->

              
                
                <!-- /.direct-chat-pane -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer" style="display: block;">
                <form action="{{route('post-ticket-comments')}}" method="post">
                  <input type="hidden" name="ticket_id" id="ticket_id" value="">
                  <input type="hidden" name="jobass_id" id="jobass_id" value="{{$jobAssignId}}">
                  @csrf()
                  <div class="input-group">
                    <textarea type="text" name="message" id="message" placeholder="Type Message ..." class="form-control summernote"></textarea>
                    <span class="input-group-append">
                      <button type="button" class="btn btn-primary submit-chat-message">Send</button>
                    </span>
                  </div>
                </form>
              </div>
              <!-- /.card-footer-->
            </div>
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
       <form action="{{route('create-new-ticket')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id" value="{{$jobAssignId}}">
     
          @csrf()
       <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title">Query</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
         
            <div class="row">
            
             
             <div class="col-sm-12">
               <!-- text input -->
               <div class="form-group">
                 <label>Title</label>
                 <input type="text" name="title" id="file" class="form-control" required>
               </div>
               <div class="form-group">
                 <label>Message</label>
                 
                 <textarea name="message" id="summernote"  class="form-control summernote"></textarea>
                 {{-- <div id="q_message"></div> --}}
               </div>
               <div class="form-group">
                 <label>Attachment</label>
                 <input type="file" name="file" id="file" class="form-control" >
               </div>
             </div>
             <div class="col-sm-12">
              <div class="form-group">
              </div>
             </div>
            </div>
            
          </div>
        
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-warning finalsub">Save</button>
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

<script>
  // ClassicEditor
  //     .create( document.querySelector( '#q_message' ) )
  //     .catch( error => {
  //         console.error( error );
  //     } );
  //     ClassicEditor
  //     .create( document.querySelector( '#message' ) )
  //     .catch( error => {
  //         console.error( error );
  //     } );
      
      
</script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
  $(".submit-chat-message").click(()=>{
   var ticket_id = $("#ticket_id").val()
   var jobass_id = $("#jobass_id").val()
   var message   = $("#message").val()
    $.ajax({
    url:"{{route('post-ticket-comments')}}",
    type:'POST',
    data:{
      ticket_id:ticket_id,
      jobass_id:jobass_id,
      message:message,
      "_token": "{{ csrf_token() }}",
    },
    success:function(res){
      $("#message").val('')
      load_messages(ticket_id)
    }
  })
  })
function load_messages(id){
  $(".direct-chat-primary").show();
  // alert(id)
  $("#ticket_id").val(id)
  $.ajax({
    url:"{{route('load-ticket-messages')}}",
    type:'POST',
    data:{
      id:id,
      "_token": "{{ csrf_token() }}",
    },
    success:function(res){
        $(".direct-chat-messages").html(res)
    }
  })
}

var selected = [];
      $(document).ready(function() {
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