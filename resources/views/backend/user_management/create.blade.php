@extends('backend.layouts.app')

@section('content')

<div class="row mt-5 mb-3" style="background-color:white;border-radius:10px;">
    <div class="col-md-3 border-right">
        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
            <img id="imagePreview" class="rounded-circle mt-5" width="200px" height="190px" src="user" alt="user"
                style="border:1px solid #ddd; background-color: aliceblue;">

            <span class="font-weight-bold"></span><span class="text-black-50"></span><span> </span>
        </div>
    </div>

    <div class="col-md-9  border-right">
        <div class="p-3 py-5">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="pageMainTitle mb-4">User Setup</h4>
            </div>


            {{-- @if ($no_of_users<=count())

            @endif --}}
            <form action="{{ route('user_management.store') }}" method="POST" id="profileForm"
                enctype="multipart/form-data">
                @csrf

                <hr>

            <div class="scrollbar p-3" id="style-7">
            <div class="force-overflow">
                <div class="row mt-5">
                    <div class="col-md-6">
                        <label class="labels">Username <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" placeholder="Username" name="username" value=""
                            id="username" required>
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Name <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" placeholder="first name" name="name" value="" id="name"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Email <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" placeholder="enter email" name="email" value=""
                            id="email" required>
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Personal Number</label>
                        <input type="text" class="form-control" placeholder="enter personal number"
                            name="personal_number" value="" required>
                    </div>
                    <div class="col-md-6"><label class="labels">Office Number</label>
                        <input type="text" class="form-control" placeholder="enter office number" name="office_number"
                            value="" required>
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Permanent Address</label>
                        <input type="text" class="form-control" placeholder="enter permanent address"
                            name="permanent_address" value="" required>
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Temporary Address</label>
                        <input type="text" class="form-control" placeholder="enter temporary address"
                            name="temporary_address" value="" required>
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Company Name</label>
                        <input type="text" class="form-control" placeholder="enter company name"
                            value="{{ auth()->user()->company->name }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Designation</label>
                        <input type="text" class="form-control" placeholder="enter designation" name="designation"
                            value="" required>
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Photo</label>
                        <input type="file" class="form-control" name="photo" onchange="changePhoto()">
                    </div>
                    <p class="text-danger" id="errDiv"></p>
                </div>
                <div class="col-md-12 mt-3">Role</div>
                <div class="row">
                    <div class="col-md-12">
                        <select name="role_id" id="" class="form-control" onchange="getPermissionOfRole(event.target.value)">
                            <option value="{{ null }}">Choose Option</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>

                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12 mt-3">Permission</div>
                <div class="row">
                    <div class="col-md-12" id="viewPermissionRoleWise">

                    </div>
                </div>
                @can('Create|User Management')

                <button class="btn updateBtn mt-5" type="submit">Submit</button>
                @endcan
            </form>
        </div>
    </div>
</div>

</div>
    </div>
@endsection

<script>

    window.addEventListener('load',function(){
        getPermissionOfRole();
    });

    function getPermissionOfRole(roleId){
        $.ajax({
            type: "get",
            url: "{{route('user_management.getPermission')}}",
            data: {roleId:roleId},
            success: function (response) {
                if(response.status){
                    $('#viewPermissionRoleWise').html(response.view);

                }
            }
        });
    }
    function handlePermissionCheck(key) {
        let isChecked = event.target.checked;
        let count=0;

        $('#permission_module_update_' + key).find(':checkbox').each(function() {

            let disable= $(this).is('[disabled]');
            let check= $(this).is('[checked]');
            if(disable!=true){

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

    function changePhoto() {
        let imagePreviewDiv = document.getElementById('imagePreview');
        if (event.target.files.length > 0) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function() {
                imagePreviewDiv.src = reader.result;
            };
        } else {
            imagePreviewDiv.src = 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg';
        }
    }

    function updateProfile(){
        let form = document.getElementById('profileForm');
        let entries = [document.getElementById('name') , document.getElementById('email')];
        let validationRes = validateProfile(entries);
        if (validationRes == true) {
            form.submit();
        }
    }

    function validateProfile(entries) {
        let errCount = 0;
        entries.forEach(element => {
            if (element.value == '') {
                errCount++
                element.style.border = '1px solid red';
            }else{
                element.style.border = '1px solid #cccccc';
            }
        });

        if (errCount > 0) {
            document.getElementById('errDiv').innerText = 'Please fill the highlighted fields';
            return false;
        } else {
            document.getElementById('errDiv').innerText = '';
            return true;
        }
    }

</script>
