@if ($allMessages)
    @foreach ($allMessages as $item)
        @if ($item->commented_by==$users->id)
        <div class="direct-chat-msg right">
            <div class="direct-chat-infos clearfix">
              <span class="direct-chat-name float-right">{{$users->name}}</span>
              <span class="direct-chat-timestamp float-left">{{$item->posted_date_time}}</span>
            </div>
            <!-- /.direct-chat-infos -->
            <img class="direct-chat-img" src="{{asset('assets/dist/img/user3-128x128.jpg')}}" alt="Message User Image">
            <!-- /.direct-chat-img -->
            <div class="direct-chat-text">
                {!!$item->message!!}
            </div>
            <!-- /.direct-chat-text -->
          </div>
        @else
        <div class="direct-chat-msg">
            <div class="direct-chat-infos clearfix">
              <span class="direct-chat-name float-left">{{getUsername($item->commented_by)}}</span>
              <span class="direct-chat-timestamp float-right">{{$item->posted_date_time}}</span>
            </div>
            <!-- /.direct-chat-infos -->
            <img class="direct-chat-img" src="{{asset('assets/dist/img/user1-128x128.jpg')}}" alt="Message User Image">
            <!-- /.direct-chat-img -->
            <div class="direct-chat-text">
              {!!$item->message!!}
            </div>
            <!-- /.direct-chat-text -->
          </div>
        @endif
    
    @endforeach
@endif

