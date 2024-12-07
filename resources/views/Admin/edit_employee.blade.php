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
            <form action="{{route('update-employee')}}" method="post">
                @csrf()
                <input type="hidden" name="id" id="id" value="{{$employee->id}}">
           <div class="card">
             <div class="card-header">
               <h3 class="card-title">Employee Details</h3>
             </div>
             <!-- /.card-header -->
             <div class="card-body">
         
                <div class="row">
                  <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" id="name" value="{{$employee->name}}" class="form-control" placeholder="Enter ..." name="name" required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                   <!-- text input -->
                   <div class="form-group">
                     <label>Email</label>
                     <input type="email" id="email" value="{{$employee->email}}" class="form-control" placeholder="Enter ..." name="email" required>
                   </div>
                 </div>
                 <div class="col-sm-6">
                   <!-- text input -->
                   <div class="form-group">
                     <label>Password</label>
                     <input type="password" class="form-control"  value="" placeholder="Enter ..." name="password" >
                   </div>
                 </div>
                 <div class="col-sm-6">
                   <!-- text input -->
                   <div class="form-group">
                     <label>Employee Type</label>
                     <select name="emp_type" id="" class="form-control" required>
                         @foreach ($emp_type as $item)
                             <option value="{{$item}}" {{$item==$employee->emp_type?'selected':''}}>{{$item}}</option>
                         @endforeach
                     </select>
                   </div>
                 </div>
                 <div class="col-sm-6">
                   <!-- text input -->
                   <div class="form-group">
                     <label>Date Of Joining</label>
                     <input type="text" id="doj" value="{{$employee->Employeeprofile->doj}}" class="form-control datepicker" placeholder="Enter ..." name="doj" required>
                   </div>
                 </div>
                 <div class="col-sm-6">
                   <!-- text input -->
                   <div class="form-group">
                     <label>Mobile No</label>
                     <input type="text" id="mob" value="{{$employee->Employeeprofile->mob}}"class="form-control" placeholder="Enter ..." name="mob" required>
                   </div>
                 </div>
                 <div class="col-sm-12">
                   <!-- text input -->
                   <div class="form-group">
                     <label>Area of Expartise</label>
                     <textarea name="area_of_exp" class="form-control" id="area_of_exp" cols="30" rows="10" required>
                        {{$employee->Employeeprofile->area_of_exp}}
                     </textarea>
                   </div>
                 </div>
                 @if ($employee->emp_type=='Writer')
                 <div class="col-sm-6 super_emp" >
                    <div class="form-group">
                        <label>Typing Speed</label>
                        <input type="text" id="mob" value="{{$employee->Employeeprofile->type_speed}}"class="form-control" placeholder="Enter ..." name="type_speed" required>
                      </div>
                  </div>
                  <div class="col-sm-6 super_emp" >
                    <div class="form-group">
                      <label>Select Team Lead</label>
                      <select class="form-control"name="super_emp" required >
                        <option value="0">Select</option>
                            @foreach ($userlist as $item)
                                @if ($item->emp_type=='TL')
                                <option value="{{$item->id}}" {{$item->id==$employee->parent_id?'selected':''}}>{{$item->name}}</option>
                                @endif
                            @endforeach
                      </select>
                    </div>
                  </div>
                 @endif
                 @if ($employee->emp_type=='TL')
                 <div class="col-sm-6 super_emp" >
                    <div class="form-group">
                      <label>Select QC</label>
                      <select class="form-control" name="super_emp" required>
                        <option value="0">Select</option>
                            @foreach ($userlist as $item)
                                @if ($item->emp_type=='QC')
                                <option value="{{$item->id}}"  {{$item->id==$employee->parent_id?'selected':''}}>{{$item->name}}</option>
                                @endif
                            @endforeach
                      </select>
                    </div>
                  </div>
                 @endif
               
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Status</label>
                      <select class="form-control" name="status" required>
                        <option value="">Select</option>
                        <option value="Active" {{$employee->status=='Active'?'selected':''}}>Active</option>
                        <option value="Inactive" {{$employee->status=='Inactive'?'selected':''}}>Inactive </option>
                      </select>
                    </div>
                  </div>
                </div>
                
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-warning">Save</button>
                <a href="{{route('employee-list')}}" class="btn btn-danger">Cancel</a>
              </div>
           </div>
            </form>
      
       </div><!-- /.row -->
     </div><!-- /.container-fluid -->

     
     </div>
   </div>
   <!-- /.content-header -->

   <!-- Main content -->
 
   <!-- /.content -->
   </div></div>
 
 <!-- /.content-wrapper -->
 @include('Admin.footer');

 
 
 
 
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