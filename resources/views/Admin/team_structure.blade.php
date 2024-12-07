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
               <h3 class="card-title">Team Details</h3>
             </div>
             <!-- /.card-header -->
             <div class="card-body">
                <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                   <tbody>
                    @if ($teamlead)
                        @foreach ($teamlead as $item)
                        <tr>
                            <td colspan="7" align="center" style="color:green">{{$item->name}} ({{$item->employeeId}})</td>
                        </tr>
                        @php
                            $myteam = getWrites($item->employeeId); 
                           
                        @endphp
                            @if ($myteam)
                            <tr>
                                <th>Name</th>
                                <th>Total Capacity</th>
                                <th>Remain Capacity</th>
                                <th>Fresh Job Ids</th>
                                <th>Total Words</th>
                                <th>Reword Ids</th>
                                <th>Total Words</th>
                            </tr>
                            @foreach ($myteam as $index=>$item)
                            @php
                                $fresh = getlistoffreshproject($item->id,'Fresh');
                            @endphp
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>{{getTypeSpeed($item->id)}}</td>
                                <td>{{getTypeSpeed($item->id)-$fresh['count']}}</td>
                                <td>{{$fresh['list']}}</td>
                                <td>{{$fresh['count']}}</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            @endforeach
                               
                            @endif
                        @endforeach
                    @endif
                        
                   </tbody>
                </table>
                
                
              </div>
              
           </div>
            
      
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