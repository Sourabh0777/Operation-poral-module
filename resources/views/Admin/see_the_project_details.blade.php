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
            <h3 class="card-title">All Job Details View</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
              
                <div class="row">
                    <div class="col-sm-12">
                      <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
              <thead>
              <tr>
                
                 <th>Job Id</th>
                
                 <th>Word</th>       
                 <th>Deadline </th>    
                 <th>Split</th>      
                 <th>Instructions</th>
                 <th>Drive Link</th>
                 <th>Attachments</th>
                 
                </tr>
              </thead>
                  <tbody>
                    <tr>
                      <td>{{$jobwork->jobnumber}}</td>
                      <td>{{$jobwork->words}}</td>
                      <td>{{$jobwork->deadline}}</td>
                      <td>
                        <table class="dataTables_wrapper dt-bootstrap4">
                            <thead>
                              <tr>
                                <th>Writer</th>
                                <th>Job Type</th>
                                <th>Word</th>
                                <th>Information</th>
                                <th>Status</th>                               
                                <th>Dead Line</th>
                              </tr>
                              <tbody>
                                @if ($Jobassign)
                                    @foreach ($Jobassign as $item)
                                        <tr>
                                          <td>{{getUsername($item->user_id)}}</td>
                                          <td>{{$item->assign_type}}</td>
                                          <td>{{$item->word}}</td>
                                          <td>{!!$item->extra_information!!}</td>
                                          <td>{{$item->status}}</td>
                                          <td>{{$item->dead_line}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                <tr>
                                  <td></td>
                                </tr>
                              </tbody>
                            </thead>
                        </table>
                      </td>
                      <td>{!!$jobwork->requirement!!}</td>
                      <td>{{$jobwork->drive_link}}</td>
                      <td>
                        @foreach (json_decode($jobwork->attachment) as $file)
                        <a href="{{asset('uploads').'/'.$file}}" target="_blank">Download</a> |

                        @endforeach
                      </td>
                    </tr>
                  </tbody>
              <tfoot>
                 <tr>
                 
                  <th>Job Id</th>
                 
                  <th>Word</th>       
                  <th>Deadline </th>    
                  <th>Split</th>      
                  <th>Instructions</th>
                  <th>Drive Link</th>
                  <th>Attachments</th>
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
     