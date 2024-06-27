@extends('backend.layouts.app')

@section('content')
<div class="row text-dark">
    <div class="col-lg-12">
        <div class="card p-5">
            <div class="card-body">
                <form method="POST" action="{{route('role.store')}}" id="storeRoleForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-2">
                            <div class="col-md-12">
                           <a href="{{ route('home.role') }}"  class="btn btn-primary convert float-right"style="font-size:13px;" > <i class="fa fa-arrow-left" aria-hidden="true" style="font-size:12px;"></i> Back</a>
                            </div>
                        <div class="col-sm-12">
                            <div class="welcome-text">
                                <h4>Create Role</h4>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Role Name</label>
                                <input type="text" name="name" class="form-control input-default" placeholder="Role Name" id="roleName">
                                <p id="namefieldError" class="text-danger"></p>
                            </div>
                        </div>
                    </div>
                    @foreach(getModuleWisePermissions() as $key=>$permissions)
                    
                    <div class="mt-2 " id="permission_module_{{$key}}">
                        <div class="row p-3">
                            <div class="col-md-12 p-1" style="background-color:#ddd;">
                                <label><b class="text-dark">{{$permissions['moduleName']}} @if ($permissions['moduleName']=="Role")And Permission
                                    
                                @endif</b></label> &nbsp;&nbsp;&nbsp;
                                <input type="checkbox" onchange="handlePermissionCheck(`{{$key}}`)" id="parentPermission{{ $key }}">
                            </div>
                        </div>
                        <div class="row p-2">
                            @foreach($permissions['action'] as $act=>$action)
                            <div class="col mt-2">
                                <input value="{{$action['id']}}" permission-name="{{$action['name']}}" name="permissions[]" type="checkbox" id="permission_{{$action['id']}}" class="child_permission{{ $key }}" onchange="handleSinglePermissionCheck({{ $key }})">
                                <label for="permission_{{$action['id']}}">
                                    {{$action['name']}}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                    {{-- <button class="btn btnCss mt-3">Save</button> --}}
                    @can('Create|Role')
                        
                    <a onclick="validationName()" class="btn btn-primary lead text-white mt-3 pl-5 pr-5">Save</a>
                    @endcan
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function handlePermissionCheck(key) {
        let isChecked = event.target.checked;
        $('#permission_module_' + key).find(':checkbox').each(function() {
            $(this).prop('checked', isChecked);
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
    function validationName() {
        let name=$('#roleName');
        let form=$('#storeRoleForm');
        $('#namefieldError').text('');
        if(name.val()=="" || name.val()==null || name.val()==undefined){
            $('#namefieldError').text('Name field is required');
            name.addClass('border border-danger')
            $.notify('Role name field is required','error');

        }else{
            if(onlyLettersAndSpaces(name.val())){
                form.submit();
            }else{
                name.addClass('border border-danger')
                $.notify('Only accepts letter and space in role name','error');
                $('#namefieldError').text('Only accepts letter and space in role name');
            }
        }
    }
    function onlyLettersAndSpaces(str) {
        return /^[A-Za-z\s]*$/.test(str);
    }

   
</script>
@endsection
