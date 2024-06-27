@extends('backend.layouts.app')

@section('content')
<div class="container-fluid rounded bg-white mt-3 mb-3">

    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img id="imagePreview" class="rounded-circle mt-5" width="200px" height="250px"
             src="{{ $user->hasMedia('profile-photo') ? $user->getMedia('profile-photo')[0]->getFullUrl() : 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' }}"><span class="font-weight-bold">{{ $user['name'] }}</span><span class="text-black-50">{{$user['email']}}</span><span> </span></div>
        </div>
        <div class="col-md-9 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="pageMainTitle text-right">Profile Settings</h4>
                </div>
                
                <form action="{{ route('profile.update') }}" method="POST" id="profileForm" enctype="multipart/form-data">
                
                    @csrf
                    <div class="row mt-2">
                        <div class="col-lg-6 col-md-12"><label class="labels">Name <sup class="text-danger">*</sup></label><input type="text" class="form-control" placeholder="first name" name="name" value="{{ $user['name'] }}" id="name"></div>
                        <div class="col-lg-6 col-md-12"><label class="labels">Email <sup class="text-danger">*</sup></label><input type="text" class="form-control" placeholder="enter email" name="email" value="{{ $user['email'] }}" id="email"></div>
                       
                        {{-- <div class="col-lg-6 col-md-12"><label class="labels">Surname</label><input type="text" class="form-control" value="" placeholder="surname"></div>  --}}
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-6 col-md-12"><label class="labels">Personal Number</label><input type="text" class="form-control" placeholder="enter personal number" name="personal_number" value="{{ $user['personal_number'] }}"></div>
                        <div class="col-lg-6 col-md-12"><label class="labels">Office Number</label><input type="text" class="form-control" placeholder="enter office number" name="office_number" value="{{ $user['office_number'] }}"></div>
                        <div class="col-lg-6 col-md-12"><label class="labels">Permanent Address</label><input type="text" class="form-control" placeholder="enter permanent address" name="permanent_address" value="{{ $user['permanent_address'] }}"></div>
                        <div class="col-lg-6 col-md-12"><label class="labels">Temporary Address</label><input type="text" class="form-control" placeholder="enter temporary address" name="temporary_address" value="{{ $user['temporary_address'] }}"></div>
                        <div class="col-lg-6 col-md-12"><label class="labels">Company Name</label><input type="text" class="form-control" placeholder="enter company name"  value="{{ $user->company->name }}" readonly></div>
                        <div class="col-lg-6 col-md-12"><label class="labels">Designation</label><input type="text" class="form-control" placeholder="enter designation" name="designation" value="{{ $user['designation'] }}"></div>
                        <div class="col-lg-6 col-md-12"><label class="labels">Photo</label><input type="file" class="form-control" placeholder="enter designation" name="photo" onchange="changePhoto()"></div>
                        <p class="text-danger" id="errDiv"></p>
                    </div>

                    <div class="mt-5 text-center"><button class="btn updateBtn mt-5" type="button" onclick="updateProfile()">Update Profile</button></div>

               
                </form>
            </div>
        </div>
    </div>
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