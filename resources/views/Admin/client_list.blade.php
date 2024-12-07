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
               <h3 class="card-title">All Clients Listed Below</h3>
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
                    <th>Client Name</th>
                    <th>Contact Information</th>
                    <th>Added By</th>
                    <th>Country</th>
                    <th>Price/Word</th>
                    <th>Currency</th>
                    <th>Created At</th>
                    <th>Update At</th>
                    <th>Status</th>
                    @if ($users->emp_type=='Admin')
                      <th>Action</th>
                                          
                    @endif
                   </tr>
                 </thead>
                   <tbody>
                   @if ($clients)
                       @foreach ($clients as $index=>$item)
                           <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$item->clientname}}</td>
                            <td>{{$item->email}} | {{$item->mob}}</td>
                            <td>{{$item->User->name}}</td>
                            <td>{{$item->country}}</td>
                            <td>{{$item->price}}</td>
                            <td>{{$item->currency}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>{{$item->updated_at}}</td>
                            <td><span class="text text-{{$item->status=='Active'?'success':'danger'}}"> {{$item->status}} </span></td>
                            @if ($users->emp_type=='Admin'){
                              <td>
                                <a href="#" data-toggle="modal" data-target="#modal-info2" class="btn btn-warning" onclick="load_client_info({{$item->id}})">Edit</a>
                                <a href="#" onclick="delete_client({{$item->id}})" class="btn btn-danger">Delete</a>
                              </td>
                            }                        
                            @endif
                           
                           </tr>
                       @endforeach
                   @endif
                      
                   </tbody>
                 <tfoot>
                 <tr>
                    <th>SL</th>
                    <th>Client Name</th>
                    <th>Contact Information</th>
                    <th>Added By</th>
                    <th>Country</th>
                    <th>Price/Word</th>
                    <th>Currency</th>
                    <th>Created At</th>
                    <th>Update At</th>
                    <th>Status</th>
                    @if ($users->emp_type=='Admin')
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
       <form action="{{route('update-client')}}" method="post">
          @csrf()
          <input type="hidden" name="id" id="id">
       <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title">Client Edit Form</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
         
            <div class="row">
              <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                  <label>Client Name</label>
                  <input type="text" id="client_name" class="form-control" placeholder="Enter ..." name="client_name">
                </div>
              </div>
              <div class="col-sm-6">
               <!-- text input -->
               <div class="form-group">
                 <label>Email</label>
                 <input type="email" class="form-control" placeholder="Enter ..." name="email" id="email">
               </div>
             </div>
          
             <div class="col-sm-6">
               <!-- text input -->
               <div class="form-group">
                 <label>Mobile No</label>
                 <input type="text" class="form-control" placeholder="Enter ..." name="mob" id="mob">
               </div>
             </div>
             <div class="col-sm-12">
               <!-- text input -->
               <div class="form-group">
                 <label>Address</label>
                 <textarea name="address" class="form-control" id="address" cols="30" rows="10" id="address"></textarea>
               </div>
             </div>
             <div class="col-sm-12">
               <!-- text input -->
               <div class="form-group">
                 <label>Extra Information</label>
                 <textarea name="extra_info" class="form-control" id="extra_info" cols="30" rows="10" id="extra_info"></textarea>
               </div>
             </div>
             @if ($users->emp_type=='Admin'){
               <div class="col-sm-6">
                 <div class="form-group">
                   <label>Status</label>
                   <select class="form-control" name="status">
                     <option value="Active">Active</option>
                     <option value="Inactive">Inactive </option>
                   </select>
                 </div>
               </div>
             }                        
             @endif
             
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
            <form action="{{route('save-client')}}" method="post">
               @csrf()
            <div class="card card-warning">
             <div class="card-header">
               <h3 class="card-title">Client Entry Form</h3>
             </div>
             <!-- /.card-header -->
             <div class="card-body">
              
                 <div class="row">
                   <div class="col-sm-6">
                     <!-- text input -->
                     <div class="form-group">
                       <label>Client Name</label>
                       <input type="text" class="form-control" placeholder="Enter ..." name="client_name">
                     </div>
                   </div>
                   <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" placeholder="Enter ..." name="email">
                    </div>
                  </div>
               
                  <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Mobile No</label>
                      <input type="text" class="form-control" placeholder="Enter ..." name="mob">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Country</label>
                      <select name="country" class="form-control" id="country">
                        <option value="">Select</option>
                          @if ($Country)
                              @foreach ($Country as $item)
                                  <option value="{{$item->name}}">{{$item->name}}</option>
                              @endforeach
                          @endif
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Address</label>
                      <textarea name="address" class="form-control" id="" cols="30" rows="5"></textarea>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Extra Information</label>
                      <textarea name="extra_info" class="form-control" id="" cols="30" rows="5"></textarea>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Price/Word</label>
                        <input type="text" class="form-control" name="price" id="price" />
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Currency</label>
                      <select name="currency" class="form-control" id="country">
                        <option value="">Select</option>
                          @if ($Currency)
                              @foreach ($Currency as $item)
                                  <option value="{{$item->name}}">{{$item->name.'('.$item->symbol.')'}}</option>
                              @endforeach
                          @endif
                      </select>
                    </div>
                  </div>
                  @if ($users->emp_type=='Admin'){
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status">
                          <option value="Active">Active</option>
                          <option value="Inactive">Inactive </option>
                        </select>
                      </div>
                    </div>
                  }                        
                  @endif
                  
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
     <script>
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