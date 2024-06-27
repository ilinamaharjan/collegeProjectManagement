
<a class="nav-link dropdown-toggle" href="#" role="button" onclick="toggleBell('bellDetails')">
    <i class="ti-bell"></i> ({{ $count }})
</a>
<div class="dropdown-menu dropdown-menu-right" id="bellDetails">
    <ul class="list-unstyled notification_div" style="margin-left:0">

        @forelse ($notifications as $notification)
        @if($notification['notify_message']!='')
        @if($notification['has_detail_modal']==true)
        <li class="dropdown-item" style="background-color: #f3d5d5" data-toggle="modal" data-target="#commonModal" onclick="loadModal('{{ route('ajax.getNotificationDetails', $notification['id']) }}')">
            @else
        <li class="dropdown-item" style="background-color: #ffff">
            @endif
            <div class="media-body">
                <p>{{ $notification['notify_message'] }}
                </p>
            </div>
            <span class="notify-time"><small>{{ $notification['created_at'] }}</small></span>
        </li>
        @endif
        @empty
        <li class="dropdown-item">
            <div class="media-body">
                <p> No new Notifications
                </p>
            </div>
        </li>



        @endforelse
    </ul>
    <a class="all-notification" target="_blank" href="">See all notifications <i class="ti-arrow-right"></i></a>
</div>

