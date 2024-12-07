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
            <h3 class="card-title">All Fresh Job Listed Below</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
              
                <div class="row">
                    <div class="col-sm-12">
                      <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
              <thead>
              <tr>
                 <th>SL</th>
                 <th>Job Id</th>
                 <th>Writer</th>                 
                 <th>Writer Attachment</th>
                 <th>Operation Instructions</th>
                 <th>Dead Line</th>
                 <th>Words</th>
                 <th>Assign Date</th>
                 <th>Status</th>
                 
                </tr>
              </thead>
                <tbody>
                @if ($my_job)
                    @foreach ($my_job as $index=>$item)
                    
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{getJobId($item->job_id)}}</td>
                            <td>{{getUsername($item->user_id)}}</td>  
                            <td>
                               
                                @if ($item->writer_attachment!="")
                                @foreach (json_decode($item->writer_attachment) as $row)
                                <a href="{{asset('uploads').'/'.$row}}" target="_blank">Download</a>
                                @endforeach
                            @endif
                              

                            </td>
                            <td>{!!$item->extra_information!!}</td>
                            <td>{{$item->dead_line}}</td>
                            <td>{{$item->word}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>{{$item->status}}</td>
                        </tr>
                    @endforeach
                @endif
                   
                </tbody>
              <tfoot>
                 <tr>
                    <th>SL</th>
                    <th>Job Id</th>
                    <th>Writer</th>                 
                    <th>Writer Attachment</th>
                    <th>Operation Instructions</th>
                    <th>Dead Line</th>
                    <th>Words</th>
                    <th>Assign Date</th>
                    <th>Status</th>
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
       <form action="{{route('update-job-form')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id">
          @csrf()
       <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title">Edit Job Form</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
         
            <div class="row">
            
             
             <div class="col-sm-12">
               <!-- text input -->
               <div class="form-group">
                 <label>Attachment</label>
                 <input type="file" name="attachment[]" id="file" class="form-control" required multiple>
               </div>
             </div>
             <div class="col-sm-12">
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Item 1" id="flexCheckDefault" name="cond[]">
                  <label class="form-check-label" for="flexCheckDefault">
                    Item 1
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Item 1" id="flexCheckDefault" name="cond[]">
                  <label class="form-check-label" for="flexCheckDefault">
                    Item 2
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Item 1" id="flexCheckDefault" name="cond[]">
                  <label class="form-check-label" for="flexCheckDefault">
                    Item 3
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Item 1" id="flexCheckDefault" name="cond[]">
                  <label class="form-check-label" for="flexCheckDefault">
                    Item 4
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Item 1" id="flexCheckDefault" name="cond[]">
                  <label class="form-check-label" for="flexCheckDefault">
                    Item 5
                  </label>
                </div>
                
              </div>
             </div>
            </div>
            
          </div>
        
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-warning finalsub" disabled>Save</button>
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
     