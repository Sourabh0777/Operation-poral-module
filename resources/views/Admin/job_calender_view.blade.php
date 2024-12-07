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
               <h3 class="card-title">Records</h3>
             </div>
             <!-- /.card-header -->
             <div class="card-body">
                <div id='calendar'></div>
                
                
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
  <div class="modal fade" id="modal-info-extension">
    <div class="modal-dialog">
      <div class="modal-content bg-info">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <form action="{{route('job-extension-request')}}" method="post" enctype="multipart/form-data">
          <input type="hidden" name="job_id" id="job_id">
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
                   <label>Your Message</label>
                  <textarea name="message" id="message" class="form-control summernote" cols="30" rows="10"></textarea>
                 </div>
               </div>
               
              </div>
              
            </div>
          
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
              <button type="submit" class="btn btn-warning ">Request</button>
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
     <script src="https://cdn.datatables.net/v/bs4/dt-2.1.0/datatables.min.js"></script>
     <script src="{{asset('cal_assets/dist/index.global.js')}}"></script>
     <script>
var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();

today = yyyy + '-' + mm + '-' +dd ;
        document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
      
          var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
              left: 'prev,next today',
              center: 'title',
              right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            initialDate: today,
            navLinks: true, // can click day/week names to navigate views
            businessHours: true, // display business hours
            editable: true,
            selectable: true,
            events: 
              <?=$events?>
            
          });
      
          calendar.render();
        });
      
      </script>
      <style>
      
        body {
          margin: 40px 10px;
          padding: 0;
          font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
          font-size: 14px;
        }
      
        #calendar {
          max-width: 1100px;
          margin: 0 auto;
        }
      
      </style>
     <script>
      var selected = [];
      $(document).ready(function() {
        $(".table").DataTable();
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
        if(totalchkbxk==totalcked || totalcked==5){
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