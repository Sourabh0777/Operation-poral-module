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
               <h3 class="card-title">Teams</h3>
             </div>
             <!-- /.card-header -->
             <div class="card-body">
                {{-- <button class="btn btn-info"  data-toggle="modal" data-target="#modal-info-edit">New</button> --}}
               <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                       
                   <div class="row">
                       <div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                 <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date of join</th>
                        <th>Area of Exp.</th>
                        <th>Typing Speed</th>
                        <th>Assigned Project(Fresh)</th>
                        <th>Assigned Project(Rework)</th>
                   </tr>
                 </thead>
                   <tbody>
                        @if ($my_teams)
                            @foreach ($my_teams as $index=>$item)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->email}}</td>
                                <td></td>
                                <td></td>
                                <td>{{getTypeSpeed($item->id)}}</td>
                                <td>{!!getassignedProject($item,'Fresh')!!}</td>
                                <td>{!!getassignedProject($item,'Rework')!!}</td>
                            </tr>
                            @endforeach
                           
                        @endif

                   </tbody>
                 <tfoot>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date of join</th>
                        <th>Area of Exp.</th>
                        <th>Typing Speed</th>
                        <th>Assigned Project(Fresh)</th>
                        <th>Assigned Project(Rework)</th>
                   </tr>
                  </tfoot>
               </table>
            </div>
        </div>
               
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
       <form action="{{route('save-leave-request')}}" method="post" >
        <input type="hidden" name="id" id="id">
          @csrf()
       <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title">Leave Applications</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
         
            <div class="row">
                <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>From</label>
                      <input type="date" name="from_date" id="from_date" class="form-control" required>
                    </div> 
                </div>
                <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>To</label>
                      <input type="date" name="to_date" id="to_date" class="form-control" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Leave Type</label>
                      <input type="text" name="leave_type" id="leave_type" class="form-control" required>
                </div>
                <div class="col-sm-12">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Applied For</label>
                      <textarea name="applied_for" id="applied_for" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>
             
             
            </div>  
            
          </div>
        
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-warning finalsub">Apply</button>
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
     <script>
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