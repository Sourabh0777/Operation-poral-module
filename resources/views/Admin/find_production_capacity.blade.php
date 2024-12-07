<table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
    <thead>
        <tr>
            <th>Writer </th> 
            <th>Capacity </th> 
            <th>Fresh Job </th>                
            <th>Rework Job </th>                  
            <th>Remaining </th>   
           </tr>
    </thead>
      <tbody>
        @if ($data)
            @foreach ($data as $item)
            <tr>
                <td>{{$item['name']}}</td>
                <td>{{$item['speed']}}</td>
                <td>{{$item['fresh_job']}}</td>
                <td>{{$item['rework_job']}}</td>
                <td>{{$item['speed'] - ($item['fresh_job']+$item['rework_job'])}}</td>
            </tr>
                
            @endforeach            
        @endif
          
      </tbody>
    <tfoot>
        <tr>
            
            <th>Writer </th> 
            <th>Capacity </th> 
            <th>Fresh Job </th>                
            <th>Rework Job </th>                  
            <th>Remaining </th>              
              
           </tr>
     </tfoot>
  </table>