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
        <div class="col-6">
            
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Latest Members</h3>

                  <div class="card-tools">
                    <span class="badge badge-danger">{{count($list_of_teams)}} Members</span>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0" style="display: block;">
                  <ul class="users-list clearfix" style="max-height:200px;overflow-y:scroll">
                    @if ($list_of_teams)
                        @foreach ($list_of_teams as $item)
                        <li>
                            <img width="100px" src="https://static.vecteezy.com/system/resources/thumbnails/027/951/137/small_2x/stylish-spectacles-guy-3d-avatar-character-illustrations-png.png" alt="User Image">
                            <a class="users-list-name" href="#" onclick="load_direct_chat('<?=$item->name?>','<?=$item->id?>')">{{$item->name}}</a>
                            <span class="users-list-date">{{$item->emp_type}}</span>
                          </li>
                        @endforeach
                    @endif
                  
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-center" style="display: block;">
                  <a href="javascript:">View All Users</a>
                </div>
                <!-- /.card-footer -->
              </div>
        </div><!-- /.row -->
        <div class="col-6">
            <div class="card direct-chat direct-chat-warning direct-chat-block" style="display: none">
                <div class="card-header">
                  <h3 class="card-title direct-chat-title"></h3>

                  <div class="card-tools">
                    <span title="3 New Messages" class="badge badge-warning"></span>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                      <i class="fas fa-comments"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="display: block;">
                  <!-- Conversations are loaded here -->
                  <div class="direct-chat-messages">
                    <!-- Message. Default to the left -->
                    
                    <!-- /.direct-chat-msg -->



                  </div>
                  <!--/.direct-chat-messages-->

                  <!-- Contacts are loaded here -->
                  
                  <!-- /.direct-chat-pane -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer" style="display: block;">
                  <form action="javascript:void(0)" method="post" id="chatform">
                    <input type="hidden" name="chat_person" id="chat_person">
                    <input type="hidden" name="jobid" id="jobid" value="{{$jobid}}">
                    <div class="input-group">
                      {{-- <input type="text" name="message" placeholder="Type Message ..." class="form-control"> --}}
                      <textarea name="message" class="form-control summernote" id="message" cols="30" rows="10"></textarea>
                      <span class="input-group-append">
                        <button type="button" class="btn btn-warning chatformsend">Send</button>
                      </span>
                    </div>
                  </form>
                </div>
                <!-- /.card-footer-->
              </div>
        </div>
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
     <script>
        function load_direct_chat(chat_name,id){
            $(".direct-chat-block").show();
            $(".direct-chat-title").html(chat_name)
            $("#chat_person").val(id)
            load_direct_messages(id)
        }

        function load_direct_messages(id){
          let jobid = $("#jobid").val()
            $.ajax({
                url:'/assignment/load-direct-chat-messages/'+id+'/'+jobid,
                success:function(res){
                    $(".direct-chat-messages").html(res)
                }
            })
        }

        $(".chatformsend").click(function(){
            let  chat_person = $("#chat_person").val();
            let  message = $("#message").val();
            let jobid = $("#jobid").val()
            $.ajax({
                url:'/assignment/post-direct-chat-messages',
                type:'POST',
                data:{
                    chat_person:chat_person,
                    message:message,
                    jobid:jobid,
                    "_token": "{{ csrf_token() }}",
                },
                success:function(res){
                    $("#message").val("")
                    $(".note-editable>p").html("")
                    load_direct_messages(chat_person)
                }
            })
        })

        setInterval(() => {
           let id =  $("#chat_person").val()
           load_direct_messages(id)
        }, 3000);
     </script>