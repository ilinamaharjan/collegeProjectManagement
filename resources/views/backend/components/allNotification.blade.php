@extends('backend.layouts.app')


@section('content')
<div class="card">
    <div class="card-body">

        <div class="row mt-3 mb-2">
            <div class="col">
                <div class="welcome-text">
                    <h4>All Notification [ Total: {{$count}} ] [ Unread: {{$unreadCount}} ]</h4>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="text-dark table header-border table-responsive-sm">
                                <tbody>
                                    @foreach($notifications as $key=>$notification)
                                    @if($notification['notify_message']!='')
                                    <tr class="{{$notification['read_at']==null?'bg-success':''}}">
                                        <td>
                                            <b>{{$key+1}}.</b>
                                        </td>
                                        <td>
                                           {{$notification['notify_message']}}
                                        </td>
                                        <td>
                                           {{$notification['created_date']}}
                                        </td>
                                        <td>
                                            @if($notification['read_at']==null)
                                            <span class="badge badge-danger text-light c-pointer" onclick="markNotificationAsRead(`{{$notification['id']}}`)">Mark as Read</span>
                                            @else
                                            <span class="badge badge-success text-light">Read</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($notification['has_detail_modal']==true)
                                        <span class="badge badge-secondary text-light c-pointer" >View</span>
                                        @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalNotiDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl " role="document">
        <div class="modal-content" id="notification_detail_div">
        </div>
    </div>
</div>
@endsection

<script>
    function markRead(){
        debugger;
        let el=event.target;
        el.parentElement.parentElement.classList.remove('bg-success')
    }
    function markNotificationAsRead(id){
        let el=event.target;
        let route =
                "{{ route('dashboard.markNotificationAsRead', ':p') }}"
            route = route.replace(':p', id);
            $.ajax({
                url: route,
                type: "GET",
                success: function(response) {
                    if(response.status){
                        el.removeAttribute('onclick');
                        el.parentElement.parentElement.classList.remove('bg-success')
                        el.classList.remove('badge-danger')
                        el.classList.add('badge-success')
                        el.innerHTML='Read'
                        $.notify(response.message, "success", {
                        clickToHide: true,
                        autoHide: true,
                        autoHideDelay: 3000,
                        arrowShow: true,
                    });
                    getNotifications();
                    }else{
                        $.notify(response.message, "warn", {
                        clickToHide: true,
                        autoHide: true,
                        autoHideDelay: 3000,
                        arrowShow: true,
                    });
                    }
                },
                error: function(error) {
                    $.notify('Oops! Something went wrong', "warn", {
                        clickToHide: true,
                        autoHide: true,
                        autoHideDelay: 3000,
                        arrowShow: true,
                    });
                }
            })
    }
</script>
