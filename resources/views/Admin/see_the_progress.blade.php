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
               <h3 class="card-title">All Assigned Job Listed Below</h3>
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
                    <th>Writer Name </th>
                    <th>Requirement Attachment</th>
                    <th>Drive Link</th>
                    <th>Job Information</th>
                    <th>Operation Instructions</th>
                    <th>Dead Line</th>
                    <th>Words</th>
                    <th>Assign Date</th>
                    <th>Status</th>
                    <th>Writer Attachment</th>
                    <th>Action</th>
                   </tr>
                 </thead>
                   <tbody>
                   @if ($my_job)
                       @foreach ($my_job as $index=>$item)
                       
                           <tr>
                            <td>{{$index+1}}</td>
                            <td>{{getJobId($item->job_id)}}</td>
                            <td>{{getUsername($item->user_id)}}</td>
                            <td><a href="{{asset('uploads').'/'.attahment($item->job_id)}}" target="_blank">Download</a></td>
                            <td>{{drivelink($item->job_id)}}</td>
                            <td>{{jobinformation($item->job_id)}}</td>
                            <td>{{$item->extra_information}}</td>
                            <td>{{$item->dead_line}}</td>
                            <td>{{$item->word}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>{{$item->status}}</td>
                            <td>
                                @if ($item->status!='Assign')
                                <a href="{{asset('uploads').'/'.$item->writer_attachment}}" target="_blank">Download</a>
                                @endif
                               
                            
                            </td>
                            <td>
                                                           
                            </td>
                           </tr>
                       @endforeach
                   @endif
                      
                   </tbody>
                 <tfoot>
                    <tr>
                    <th>SL</th>
                    <th>Job Id</th>
                    <th>Writer Name </th>
                    <th>Requirement Attachment</th>
                    <th>Drive Link</th>
                    <th>Job Information</th>
                    <th>Operation Instructions</th>
                    <th>Dead Line</th>
                    <th>Words</th>
                    <th>Assign Date</th>
                    <th>Status</th>
                    <th>Writer Attachment</th>
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
 
 
 
     <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
     <script>
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