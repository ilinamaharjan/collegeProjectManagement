@extends('backend.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="card p-5">
        <div class="row">
            <div class="col-md-12">

                <a class="btn btn-primary pr-3 pl-3 float-right" href="{{ route('user_management.index') }}"> <i
                        class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>
            <div class="col-md-12">
                <h5 class="modal-title mt-3 mb-3" id="exampleModalLongTitle">Update Permission for {{$user->name}}</h5>
            </div>
        </div>

        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ route('role.userPermissionUpdate',$user->id) }}" id="storeRoleForm"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-12 mt-3">Role</div>
                    <div class="row">
                        <div class="col-md-12">
                            <select name="role_id" id="" class="form-control"
                                onchange="getPermissionOfRoleUpdate(event.target.value,{{ $user->id }})">
                                <option value="{{ null }}">Choose Option</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ in_array($role->id,$userRoles)?'selected':'' }}>{{
                                    $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="editUserPermissionRole{{ $user->id }}">
                        @foreach(getModuleWisePermissions() as $pkey=>$permissions)


                        @php
                        $rand=rand();
                        $checkedCount=0;
                        $totalCount=0;
                        @endphp
                        <div class="mt-2 permission-container" id="permission_module_update_{{$rand}}">
                            <div class="row">
                                <div class="col-md-12 m-1" style="background-color:#ddd;">
                                    <label><b class="text-dark ">{{$permissions['moduleName']}}</b></label>
                                    &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" onchange="handlePermissionCheck(`{{$rand}}`)"
                                        id="parentPermission{{ $rand }}" class="parentPermission">
                                </div>
                            </div>
                            <div class="row p-2">
                                @foreach($permissions['action'] as $act=>$action)


                                @php
                                $totalCount++;
                                @endphp
                                <div class="col mt-2">
                                    @if(in_array($action['id'],$user_permission))
                                    @php
                                    $checkedCount++;
                                    @endphp
                                    @endif
                                    <input permission-name="{{$action['name']}}" {{$previous_role!=null &&
                                        $previous_role->hasPermissionTo($action['id'])?'checked disabled':''}}
                                    {{$previous_role!=null && !$previous_role->hasPermissionTo($action['id']) &&
                                    in_array( $action['id'],$user_permission)?'checked': ''}} {{$previous_role==null &&
                                    in_array( $action['id'],$user_permission)?'checked': ''}}
                                    value="{{$action['id']}}"
                                    name="permissions[]" type="checkbox" id="permission_{{$action['id']}}"
                                    onchange="handleSinglePermissionCheck({{ $rand }})" class="child_permission{{ $rand
                                    }} childPermissionsCheck">
                                    <label for="permission_{{$action['id']}}">
                                        {{$action['name']}}</label>
                                </div>

                                @endforeach
                            </div>
                        </div>
                        {{-- @push('scripts') --}}
                        <script>
                            var rand="{{ $rand }}";
                var checkedbtn="{{ $checkedCount }}";
                
                var totalCount="{{ $totalCount }}";
                if(checkedbtn==totalCount){
                    $('#parentPermission'+rand).prop('checked',true);
                }
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
                        {{-- @endpush --}}

                        @endforeach
                    </div>
                    <div class="row mt-3">

                        @can('Update|User Management')

                        <button class="btn updateBtn">Update</button>
                        @endcan

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    let key="{{ $user->id }}";
     window.addEventListener('load',function(){
        getPermissionOfRoleUpdate(key);
    });
   
    function getPermissionOfRoleUpdate(roleId,key){
        $.ajax({
            type: "get",
            url: "{{route('user_management.getPermissionUpdate')}}",
            data: {
                roleId:roleId,
                userId:key,
            },
            success: function (response) {
                if(response.status){
                    $('#editUserPermissionRole'+key).html(response.view);

                }
            }
        });
    }
    function handlePermissionCheck(key) {
        let isChecked = event.target.checked;
        $('#permission_module_update_' + key).find(':checkbox').each(function() {
            if(!$(this).attr('disabled')){
                $(this).prop('checked', isChecked);
            }
        });
    }
    function handleSinglePermissionCheck(key) {
       
       let count=0;
       var numItems = $('.child_permission'+key).length; 
       $('.child_permission'+key).each(function(i, element) {
           let check= $(element).is(":checked");
           if(check){
               count++;
           }

       });
       if(count==numItems){
           $('#parentPermission'+key).prop('checked',true);
       }else{
           $('#parentPermission'+key).prop('checked',false);
       }
      
   }

</script>
@endsection