@if ($role)

@foreach(getModuleWisePermissions() as $pkey=>$permissions)
@php
$rand=rand();
@endphp
<div class="mt-2" id="permission_module_update_{{$rand}}">
    <div class="row p-3">
        <div class="col-md-12 p-1" style="background-color:#ddd;">
            <label><b class="text-dark ">{{$permissions['moduleName']}}</b></label> &nbsp;&nbsp;&nbsp;
            <input type="checkbox" onchange="handlePermissionCheck(`{{$rand}}`)" id="parentPermission{{ $rand }}">
        </div>
    </div>
    <div class="row p-2">
        @foreach($permissions['action'] as $act=>$action)
        <div class="col mt-2">
            <input permission-name="{{$action['name']}}" {{$role->hasPermissionTo($action['id'])?'checked disabled':""}}
            {{ !$role->hasPermissionTo($action['id'])&& in_array($action['id'],$user_permission)?'checked':''}}
            value="{{$action['id']}}"
            name="permissions[]" type="checkbox" id="permission_{{$action['id']}}"
            onchange="handleSinglePermissionCheck({{ $rand }})" class="child_permission{{ $rand }}">
            <label for="permission_{{$action['id']}}">
                {{$action['name']}}</label>
        </div>
        @endforeach
    </div>
</div>

<script>
    var rand="{{ $rand }}";

    var disabledCount = 0
    var disabledClass= $('.child_permission'+rand).length;
    
$('.child_permission'+rand).each(function(i, element) {
        var check= $(element).is(":disabled");
        if(check){
            disabledCount++;
        }
        });
        if(disabledCount==disabledClass){
            $('#parentPermission'+rand).attr('disabled',true);
            $('#parentPermission'+rand).prop('checked',true);
        }else{
            $('#parentPermission'+rand).attr('disabled',false);
        }
</script>

@endforeach
@else
@foreach(getModuleWisePermissions() as $pkey=>$permissions)
@php
$rand=rand();
@endphp
<div class="mt-2" id="permission_module_update_{{$rand}}">
    <div class="row p-3">
        <div class="col-md-12 p-1" style="background-color:#ddd;" p-2 text-light text-center"
            style="background-color:gray;border-radius:5px">
            <label><b class="text-dark ">{{$permissions['moduleName']}}</b></label> &nbsp;&nbsp;&nbsp;
            <input type="checkbox" onchange="handlePermissionCheck(`{{$rand}}`)" id="parentPermission{{ $rand }}">
        </div>
    </div>
    <div class="row p-2">
        @foreach($permissions['action'] as $act=>$action)
        <div class="col mt-2">
            <input {{ in_array($action['id'],$user_permission)?'checked':''}} permission-name="{{$action['name']}}"
                value="{{$action['id']}}" name="permissions[]" type="checkbox" id="permission_{{$action['id']}}"
                onchange="handleSinglePermissionCheck({{ $rand }})" class="child_permission{{ $rand }}">
            <label for="permission_{{$action['id']}}">
                {{$action['name']}}</label>
        </div>
        @endforeach
    </div>
</div>

@endforeach
@endif