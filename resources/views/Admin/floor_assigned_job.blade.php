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
            <h3 class="card-title">Find Jobs</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<form action="{{route('write-new-feedback')}}" method="POST" id="searchform">
    @csrf()
    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">From</label>        
                    <input type="date" name="date1" id="date1" class="form-control" value="<?=date('d-m-Y')?>">
                  </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">To</label>        
                    <input type="date" name="date2" id="date2" class="form-control" value="<?=date('d-m-Y')?>">
                  </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">  &nbsp;   </label>        
                    <button type="button" class="btn btn-warning find" style="margin-top: 30px;">Find</button>
                  </div>
            </div>
              
        </div>
      
   
      
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      
    </div>
  </form>
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
            <h3 class="card-title">Reports</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
           <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
              
            <div class="row">
                <div class="col-sm-12 table_data">
                  <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
          <thead>
          <tr>
             <th>SL</th>
             <th>Writer </th>                
             <th>Job ID</th>                 
             <th>Instructions</th> 
             <th>DeadLine</th>
             <th>Status</th>  
             <th>Word</th>                              
             <th>Work Type</th>     
            </tr>
          </thead>
            <tbody>
                @if ($my_jobs)
                    @foreach ($my_jobs as $index=>$item)
                        <tr>
                            <td><?=$index+1?></td>
                            <td>{{getemp_name($item->user_id)}}</td>
                            <td>{{getJobId($item->job_id)}}</td>
                            <td>{!!$item->extra_information!!}</td>
                            <td>{{$item->dead_line}}</td>
                            <td>{{$item->status}}</td>
                            <td>{{$item->word}}</td>
                            <td>{{$item->assign_type}}</td>
                        </tr>
                    @endforeach
                @endif
               
            </tbody>
          <tfoot>
            <tr>
                <th>SL</th>
             <th>Writer </th>                
             <th>Job ID</th>                 
             <th>Instructions</th> 
             <th>DeadLine</th>
             <th>Status</th>     
             <th>Word</th>                             
             <th>Work Type</th>     
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
  </div>
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
     <script src="https://cdn.datatables.net/v/bs4/dt-2.1.0/datatables.min.js"></script>

   
     <script>
      var selected = [];
      var datatables = '';
      $(document).ready(function() {
        datatables = $("#example2").DataTable();
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
       <script>
        $(".find").click(function(){
            if($("#date1").val()!='' || $("#date2").val()!=''){
                $(".table_data").html("<h5 class='alert alert-info'>Loading</h5>")
                $.ajax({
                url:'{{route("find-assigned-jobs")}}',
                data:$("#searchform").serialize(),
                type:'POST',
                success:function(res){
                    datatables.destroy();
                    $(".table_data").html(res)
                    datatables = $("#example2").DataTable();
                }
            })
            }else{
                alert("please input date")
            }
          
        })
     </script>