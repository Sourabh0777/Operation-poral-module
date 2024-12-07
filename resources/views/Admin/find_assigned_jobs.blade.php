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
  </table>