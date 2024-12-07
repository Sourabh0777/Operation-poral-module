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
                    <th>Received Date</th>
                    <th>Project DeadLine</th>
                    <th>Task DeadLine</th>
                    <th>Number of Words</th>
                    <th>Task Words</th>
                    <th>Requirements</th>
                    <th>Drive Link</th>
                    <th>Attachment</th>
                    <th>Task Notes</th>
                    <th>Assigned_to</th>
                    <th>Writer Attachment</th>
                    <th>Created At</th>
                    <th>Update At</th>
                    <th>Status</th>
                   
                   
                   </tr>
                 </thead>
                   <tbody>
                    @if ($projects)
                        @foreach ($projects as $index=>$item)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$item->jobnumber}}</td>
                                <td>{{$item->jobtype}}</td>
                                <td>{{$item->category}}</td>                                
                                <td>{{$item->receive_date}}</td>
                                <td>{{$item->deadline}}</td>
                                <td>{{$item->dead_line}}</td>
                                <td>{{$item->words}}</td>
                                <td>{{$item->word}}</td>
                                <td>{{$item->requirement}}</td>
                                <td>{{$item->drive_link}}</td>
                                <td><a href="{{asset('uploads').'/'.attahment($item->id)}}" target="_blank">Download</a></td>
                                <td>{{$item->extra_information}}</td>
                                <td>{{$item->name}}</td>
                                @if ($item->writer_attachment)
                                <td><a href="{{asset('uploads').'/'.attahment($item->id)}}" target="_blank">Download</a></td>
                                @else
                                <td></td>
                                
                                @endif
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->updated_at}}</td>
                                <td>{{$item->status}}</td>
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
                    <th>Received Date</th>
                    <th>Project DeadLine</th>
                    <th>Task DeadLine</th>
                    <th>Number of Words</th>
                    <th>Task Words</th>
                    <th>Requirements</th>
                    <th>Drive Link</th>
                    <th>Attachment</th>
                    <th>Task Notes</th>
                    <th>Assigned_to</th>
                    <th>Writer Attachment</th>
                    <th>Created At</th>
                    <th>Update At</th>
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
   </div>
   <!-- /.content-header -->

   <!-- Main content -->
 
   <!-- /.content -->
   </div></div>
 
 <!-- /.content-wrapper -->
 @include('Admin.footer');

  
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
 
     
     </div>
     <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
     
     <script>
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