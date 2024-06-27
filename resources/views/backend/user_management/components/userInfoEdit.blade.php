<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Edit Information of {{$user->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <form action="{{ route('user_management.updateUser') }}" method="POST" id="profileFormEdit{{ $user['id'] }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row mt-3 mb-2" style="background-color:white;border-radius:10px;">
                    <div class="col-md-4 border-right">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-3">
                            <img id="imagePreviewEditUser{{ $user['id'] }}" class="rounded-circle mt-5" width="200px" height="190px"
                                src="{{ $user->hasMedia('profile-photo') ? $user->getMedia('profile-photo')[0]->getFullUrl():'' }}"
                                alt="user" style="border:1px solid #ddd; background-color: aliceblue;">

                            <span class="font-weight-bold"></span><span class="text-black-50"></span><span> </span>
                        </div>
                        <div class="col-md-12">
                            <label class="labels">User Profile </label>
                            <input type="file" class="form-control" name="photo" onchange="changePhoto({{ $user['id'] }})">
                            <small style="font-size: 11px;font-weight:800;">[ File must be < 4 MB and png,jpg,jpeg extension]</small>
                        </div>
                    </div>
                    <div class="col-md-8  border-right">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="pageMainTitle mb-4">Edit User Info:</h4>
                        </div>
                       
                            <hr>
                            <div class="row ">
                                <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                                {{-- <div class="col-md-6">
                                    <label class="labels">Username <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" placeholder="Username" name="username"
                                        value="{{ $user['username'] }}" id="username" required>
                                </div> --}}
                                <div class="col-md-6">
                                    <label class="labels">Name <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" placeholder="first name" name="name"
                                        value="{{ $user['name'] }}" id="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">Email <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" placeholder="enter email" name="email"
                                        value="{{ $user['name'] }}" id="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">Personal Number</label>
                                    <input type="text" class="form-control" placeholder="enter personal number"
                                        name="personal_number" value="{{ $user['personal_number'] }}" >
                                </div>
                                <div class="col-md-6"><label class="labels">Office Number</label>
                                    <input type="text" class="form-control" placeholder="enter office number"
                                        name="office_number" value="{{ $user['office_number'] }}" >
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">Permanent Address</label>
                                    <input type="text" class="form-control" placeholder="enter permanent address"
                                        name="permanent_address" value="{{ $user['permanent_address'] }}" >
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">Temporary Address</label>
                                    <input type="text" class="form-control" placeholder="enter temporary address"
                                        name="temporary_address" value="{{ $user['temporary_address'] }}" >
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">Company Name</label>
                                    <input type="text" class="form-control" placeholder="enter company name"
                                        value="{{ auth()->user()->company->name }}" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">Designation</label>
                                    <input type="text" class="form-control" placeholder="enter designation"
                                        name="designation" value="{{ $user['designation'] }}" >
                                </div>
                                <p class="text-danger" id="errDiv"></p>
                            </div>
                            @can('Create|User Management')
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" onclick="validationUserEditBlade({{ $user['id'] }})" class="btn updateBtn mt-5 px-4 py-2" type="submit">Update</button>
                                </div>
                            </div>
                            @endcan
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>