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
               <h3 class="card-title">All Employee Listed Below</h3>
             </div>
             <!-- /.card-header -->
             <div class="card-body">
               
               <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                   <div class="row">
                       <div class="col-sm-2">
                       <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-info">Add</button>
                       </div>
                   <div class="col-sm-12 col-md-6">
                   
                   </div><div class="col-sm-12 col-md-6">

                   </div></div>
                   <div class="row">
                       <div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                 <thead>
                 <tr>
                    <th>SL</th>
                    <th>Employee Name</th>
                    <th>Employee Type</th>
                    <th>Contact Information</th>
                    <th>Joinging Date</th>
                    <th>Area of Expartise</th>
                    <th>Login Email</th>
                    <th>Action</th>
                   </tr>
                 </thead>
                   <tbody>
                   @if ($emp_list)
                   @php
                      //  dd($emp_list);
                   @endphp
                       @foreach ($emp_list as $index=>$item)
                           <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->emp_type}}</td>
                            <td>{{$item->Employeeprofile->mob?$item->Employeeprofile->mob:''}}</td>
                            <td>{{$item->Employeeprofile->doj?$item->Employeeprofile->doj:''}}</td>
                            <td>{{$item->Employeeprofile->area_of_exp?$item->Employeeprofile->area_of_exp:''}}</td>
                            <td>{{$item->email}}</td>
                            <td>
                              <a href="{{route('edit-employee',$item->id)}}" class="btn btn-warning">Edit</a>
                              <a href="javascript:void(0)" class="btn btn-danger" onclick="deleteemp({{$item->id}})">Delete</a>
                            </td>
                           </tr>
                       @endforeach
                   @endif
                      
                   </tbody>
                 <tfoot>
                 <tr>
                    <th>SL</th>
                    <th>Employee Name</th>
                    <th>Employee Type</th>
                    <th>Contact Information</th>
                    <th>Joinging Date</th>
                    <th>Area of Expartise</th>
                    <th>Login Email</th>
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
       <form action="{{route('update-employee')}}" method="post">
        <input type="hidden" name="id" id="id">
          @csrf()
       <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title">Employee Edit Form</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
         
            <div class="row">
              <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" id="name" class="form-control" placeholder="Enter ..." name="name" required>
                </div>
              </div>
              <div class="col-sm-6">
               <!-- text input -->
               <div class="form-group">
                 <label>Email</label>
                 <input type="email" id="email" class="form-control" placeholder="Enter ..." name="email" required>
               </div>
             </div>
             <div class="col-sm-6">
               <!-- text input -->
               <div class="form-group">
                 <label>Password</label>
                 <input type="password" class="form-control" placeholder="Enter ..." name="password" required>
               </div>
             </div>
             <div class="col-sm-6">
               <!-- text input -->
               <div class="form-group">
                 <label>Employee Type</label>
                 <select name="emp_type" id="" class="form-control" required>
                     @foreach ($emp_type as $item)
                         <option value="{{$item}}">{{$item}}</option>
                     @endforeach
                 </select>
               </div>
             </div>
             <div class="col-sm-6">
               <!-- text input -->
               <div class="form-group">
                 <label>Date Of Joining</label>
                 <input type="text" id="doj" class="form-control datepicker" placeholder="Enter ..." name="doj" required>
               </div>
             </div>
             <div class="col-sm-6">
               <!-- text input -->
               <div class="form-group">
                 <label>Mobile No</label>
                 <input type="text" id="mob" class="form-control" placeholder="Enter ..." name="mob" required>
               </div>
             </div>
             <div class="col-sm-12">
               <!-- text input -->
               <div class="form-group">
                 <label>Area of Expartise</label>
                 <textarea name="area_of_exp" class="form-control" id="area_of_exp" cols="30" rows="10" required></textarea>
               </div>
             </div>
             <div class="col-sm-6 super_emp" >
              <div class="form-group">
                <label>Select <span id="emp_type_label"></span></label>
                <select class="form-control" name="status" required>
                  <option value="0">Select</option>
                  
                </select>
              </div>
            </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status" required>
                    <option value="">Select</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive </option>
                  </select>
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
            <form action="{{route('save-employee')}}" method="post">
               @csrf()
            <div class="card card-warning">
             <div class="card-header">
               <h3 class="card-title">Employee Entry Form</h3>
             </div>
             <!-- /.card-header -->
             <div class="card-body">
              
                 <div class="row">
                   <div class="col-sm-6">
                     <!-- text input -->
                     <div class="form-group">
                       <label>Name</label>
                       <input type="text" class="form-control" placeholder="Enter ..." name="name" required>
                     </div>
                   </div>
                   <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" placeholder="Enter ..." name="email" required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" class="form-control" placeholder="Enter ..." name="password" required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Employee Type</label>
                      <select name="emp_type" id="" class="form-control" required>
                          @foreach ($emp_type as $item)
                              <option value="{{$item}}">{{$item}}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Date Of Joining</label>
                      <input type="text" class="form-control datepicker" placeholder="Enter ..." name="doj" required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Mobile No</label>
                      <input type="text" class="form-control" placeholder="Enter ..." name="mob" required>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Area of Expartise</label>
                      <textarea name="area_of_exp" class="form-control" id="" cols="30" rows="10" required></textarea>
                    </div>
                  </div>
                   <div class="col-sm-6">
                     <div class="form-group">
                       <label>Status</label>
                       <select class="form-control" name="status" required>
                         <option value="Active">Active</option>
                         <option value="Inactive">Inactive </option>
                       </select>
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
     $( function() {
      $(".table").DataTable();
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