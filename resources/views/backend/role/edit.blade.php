@extends('backend.layouts.app')

@section('content')

<div class="container-fluid">
<div class="card p-5">
        
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary pr-3 pl-3 float-right btn-sm" href="{{ route('home.role') }}"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
        </div>
    <div class="col-md-12">
        <h5 class="modal-title mt-3 mb-3" id="exampleModalLongTitle">Update Role {{$role->name}}</h5>
    </div>
</div>
    <div class="row ">
        <div class="col-md-12">
        <form method="POST" action="{{ route('role.update',$role->id) }}" id="storeRoleForm" enctype="multipart/form-data">
            @csrf
            <div class="row p-2 mb-3">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="">Role Name</label>
                        <input @if($role->name=='Admin') readonly @endif value="{{$role->name}}" type="text" name="name"
                        class="form-control input-default" placeholder="Role Name">
                    </div>
                </div>
            </div>
            @foreach(getModuleWisePermissions() as $pkey=>$permissions)
            @php
            $rand=rand();
            $checkedCount=0;
            $totalCount=0;
            @endphp
            <div class="mt-2" id="permission_module_update_{{$rand}}">
                <div class="row p-2">
                    <div class="col-md-12 " style="background-color:#ddd;">
                        <label><b class="text-dark ">{{$permissions['moduleName']}}</b></label> &nbsp;&nbsp;&nbsp;
                        <input type="checkbox" onchange="handlePermissionCheck(`{{$rand}}`)" id="parentPermission{{ $rand }}">
                    </div>
                </div>
                <div class="row p-2">
                    
                    @foreach($permissions['action'] as $act=>$action)
                    @php
                        $totalCount++;
                    @endphp
                    <div class="col mt-2">
                        @if($role->hasPermissionTo($action['id']))
                        @php
                            $checkedCount++;
                        @endphp
                        @endif
                        <input permission-name="{{$action['name']}}"
                            {{$role->hasPermissionTo($action['id'])?'checked':''}} 
                            value="{{$action['id']}}"
                        name="permissions[]" type="checkbox" id="permission_{{$action['id']}}" class="child_permission{{ $rand }}"
                        onchange="handleSinglePermissionCheck({{ $rand }})">
                        <label for="permission_{{$action['id']}}">
                            {{$action['name']}}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            <script>
                var rand="{{ $rand }}";
                var checkedbtn="{{ $checkedCount }}";
                var totalCount="{{ $totalCount }}";
                if(checkedbtn==totalCount){
                   
                    $('#parentPermission'+rand).prop('checked',true);
                }
            </script>
            @endforeach
            <div class="row mt-3">
                <div class="col-md-2">
                    <button class="btn btn-primary lead mt-3 pr-3 pl-3">Update</button>
                </div>
            </div>
        </form>
    </div>
    </div>

</div>
</div>
<script>
   
    function handlePermissionCheck(key) {
        let isChecked = event.target.checked;
        $('#permission_module_update_' + key).find(':checkbox').each(function() {
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
</script>
@endsection