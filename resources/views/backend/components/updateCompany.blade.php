    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit - {{ $company->name }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container-fluid card rounded bg-white mt-3 mb-3 customCard">
                {{-- <h5 class="card-title">Details</h5> --}}
                <form action="{{ route('company.update') }}" id="updatecompanyform{{ $company['id'] }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <h6>Photo/Logo</h6>
                            <div class="d-flex flex-column align-items-center">
                                <input type="text" name="id" value="{{ $company['id'] }}" hidden>
                                <label for="inputImage" id="inputLabel">Choose Logo</label>
                                <input type="file" id="inputImage" name="company-logo"
                                    onchange="changeCompanyPicture()" />
                                <div id="preview-image">
                                    <img src="{{ $company->hasMedia('company-logo') ? $company->getMedia('company-logo')[0]->getFullUrl() : '' }}"
                                        id="imageDiv" class="img-fluid customImage" alt="">

                                    <div id="placeholder">

                                        <div id="upload-area" title="select a image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="profileNameBox">
                                <div><label class="labels">Name <sup class="text-danger">*</sup></label><input
                                        type="text" class="form-control" placeholder="Company name" name="name"
                                        value="{{ $company['name'] }}" id="name{{ $company['id'] }}"></div>
                                <div class="mt-5"><label class="labels">Email <sup
                                            class="text-danger">*</sup></label><input type="email"
                                        class="form-control" placeholder="Company email" name="email"
                                        value="{{ $company['email'] }}" id="email{{ $company['id'] }}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div><label class="labels">Contact Number</label><input type="text" class="form-control"
                                    placeholder="Contact Number" name="phone_number"
                                    value="{{ $company['phone_number'] }}"></div>
                        </div>
                        <div class="col-md-6">
                            <div><label class="labels">Address</label><input type="text" class="form-control"
                                    placeholder="Address" name="address" value="{{ $company['address'] }}"></div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        @if ($company['package_id'] == null)
                            <div class="col-md-6">
                                <div><label class="labels">Employees <sup class="text-danger">*</sup></label><input
                                        type="number" class="form-control" placeholder="Total Employees"
                                        name="total_employees" value="{{ $company['total_employees'] }}"
                                        id="total_employees{{ $company['id'] }}"></div>
                            </div>
                            <div class="col-md-6">
                                <div><label class="labels">Companies URL</label><input type="text"
                                        class="form-control" placeholder="URL" name="website"
                                        value="{{ $company['website'] }}"></div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div><label class="labels">Employees</label><input type="text" class="form-control"
                                        placeholder="Total Employees" name="total_employees"
                                        value="{{ $company['total_employees'] }}"
                                        id="total_employees{{ $company['id'] }}"></div>
                            </div>
                            <div class="col-md-6">
                                <div><label class="labels">Companies URL</label><input type="text"
                                        class="form-control" placeholder="URL" name="website"
                                        value="{{ $company['website'] }}"></div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label class="labels">Package</label>
                                    <select name="package_id" class="form-control">
                                        @forelse ($packages as $package)
                                            <option value="{{ $package['id'] }}"
                                                {{ $company->package->title == $package['title'] ? 'selected' : '' }}>
                                                {{ $package['title'] }}</option>
                                        @empty
                                            <option>No data!</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p id="companyErr" class="text-danger">
                            <p id="emailErr" class="text-danger">
                            </p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <button class="btn updateBtn" type="button"
                                onclick="submitCompanyUpdate({{ $company['id'] }})">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
