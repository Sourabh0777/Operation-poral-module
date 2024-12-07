@if ($messages)
    @foreach ($messages as $item)
        @if ($item->from_id==$users->id)
                
            <!-- Message to the right -->
            <div class="direct-chat-msg right">
                <div class="direct-chat-infos clearfix">
                <span class="direct-chat-name float-right">{{getUsername($item->from_id)}}</span>
                <span class="direct-chat-timestamp float-left">{{$item->created_at}}</span>
                </div>
                <!-- /.direct-chat-infos -->
                <img class="direct-chat-img" src="https://static.vecteezy.com/system/resources/thumbnails/027/951/137/small_2x/stylish-spectacles-guy-3d-avatar-character-illustrations-png.png" alt="message user image">
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                    {!!$item->message!!}
                </div>
                <!-- /.direct-chat-text -->
            </div>
        @elseif($item->to_id==$users->id)
            <div class="direct-chat-msg ">
                <div class="direct-chat-infos clearfix">
                <span class="direct-chat-name float-left">{{getUsername($item->from_id)}}</span>
                <span class="direct-chat-timestamp float-left">{{$item->created_at}}</span>
                </div>
                <!-- /.direct-chat-infos -->
                <img class="direct-chat-img" src="https://static.vecteezy.com/system/resources/thumbnails/027/951/137/small_2x/stylish-spectacles-guy-3d-avatar-character-illustrations-png.png" alt="message user image">
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                    {!!$item->message!!}
                </div>
                <!-- /.direct-chat-text -->
            </div>
        
        @elseif($item->to_id!=$users->id)
            <div class="direct-chat-msg">
                <div class="direct-chat-infos clearfix">
                <span class="direct-chat-name float-right">{{getUsername($item->to_id)}} hree2</span>
                <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                </div>
                <!-- /.direct-chat-infos -->
                <img class="direct-chat-img" src="https://static.vecteezy.com/system/resources/thumbnails/027/951/137/small_2x/stylish-spectacles-guy-3d-avatar-character-illustrations-png.png" alt="message user image">
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                You better believe it!
                </div>
                <!-- /.direct-chat-text -->
            </div>
        

        @else
            <div class="direct-chat-msg">
            <div class="direct-chat-infos clearfix">
              <span class="direct-chat-name float-left">{{getUsername($item->from_id)}}</span>
              <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm hree</span>
            </div>
            <!-- /.direct-chat-infos -->
            <img class="direct-chat-img" src="https://static.vecteezy.com/system/resources/thumbnails/027/951/137/small_2x/stylish-spectacles-guy-3d-avatar-character-illustrations-png.png" alt="message user image">
            <!-- /.direct-chat-img -->
            <div class="direct-chat-text">
              Is this template really for free? That's unbelievable!
            </div>
            <!-- /.direct-chat-text -->
          </div>
          <!-- /.direct-chat-msg -->
        @endif
    @endforeach
    @else
    <div class="direct-chat-text">
        No Chat Data
      </div>
@endif


