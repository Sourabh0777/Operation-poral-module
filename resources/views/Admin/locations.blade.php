 @include('Admin.header');
 @include('Admin.sidebar');
 <style>
    label{
        color:#000;
    }
 </style>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Locations Listed Below</h3>
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
                    <th>Location</th>
                    <th>Actions</th>
                    </tr>
                  </thead>
                    <tbody>
                        @if($locations)
                            @foreach($locations as $index=>$row)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$row->locationname}}</td>
                                    <td><a href="{{route('delete-location',$row->id)}}" class="btn btn-danger">Delete</a></td>
                                </tr>
                            @endforeach
                        @endif
                       
                    </tbody>
                  <tfoot>
                  <tr>
                    <th>SL</th>
                    <th>Location</th>
                    <th>Actions</th>
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
             <form action="{{route('save-location')}}" method="post">
                @csrf()
             <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Loation Entry Form</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
               
                  <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" placeholder="Enter ..." name="location">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status">
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