@extends('backend.layouts.app')

@section('content')
    <div class="row mt-5 mb-3" style="background-color:white;border-radius:10px;">
        <div class="col-md-3 border-right" style="background-color:#e9ecef;">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img id="imagePreview" class="rounded-circle mt-5" width="200px" height="200px" src="user" alt="user"
                    style="border:1px solid #ddd;">

                <span class="font-weight-bold"></span><span class="text-black-50"></span><span> </span>
            </div>
        </div>

        <div class="col-md-9  border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="pageMainTitle mb-4">User Setup</h4>
                </div>
                <form action="{{ route('ajax.storeUser') }}" method="POST" id="profileForm" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="company_id" id="userCompanyId" value="{{ $company['id'] }}" hidden>
                    <hr>
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <label class="labels">Username <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" placeholder="Enter username" name="username"
                                value="" id="username">
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Name <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" placeholder="Enter name" name="name"
                                value="" id="name">
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Email <sup class="text-danger">*</sup></label>
                            <input type="email" class="form-control" placeholder="Enter email" name="email"
                                value="" id="email">
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Personal Number</label>
                            <input type="text" class="form-control" placeholder="Enter personal number"
                                name="personal_number" value="" id="personal_number">
                        </div>
                        <div class="col-md-6"><label class="labels">Office Number</label>
                            <input type="text" class="form-control" placeholder="Enter office number"
                                name="office_number" value="" id="office_number">
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Permanent Address</label>
                            <input type="text" class="form-control" placeholder="Enter permanent address"
                                name="permanent_address" id="permanent_address" value="">
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Temporary Address</label>
                            <input type="text" class="form-control" placeholder="Enter temporary address"
                                name="temporary_address" id="temporary_address">
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Company Name</label>
                            <input type="text" class="form-control" placeholder="Enter company name"
                                value="{{ $company['name'] }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Designation</label>
                            <input type="text" class="form-control" placeholder="Enter designation" name="designation"
                                id="designation">
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Photo</label>
                            <input type="file" class="form-control" name="photo" onchange="changePhoto()">
                        </div>

                    </div>
                    <div class="row mt-2 mx-2">
                        <div class="col-md-6">
                            <p class="text-danger" id="errDiv"></p>
                            <p class="text-danger" id="emailErr"></p>
                        </div>
                    </div>
                    <button class="btn updateBtn mt-5" type="button" onclick="userCreateSubmit()">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
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
            imagePreviewDiv.src =
                'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg';
        }
    }

    function updateProfile() {
        let form = document.getElementById('profileForm');
        let entries = [document.getElementById('name'), document.getElementById('email')];
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
            } else {
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
