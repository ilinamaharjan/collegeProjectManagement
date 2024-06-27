<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Contact Book Setup : </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="p-3">
            <form action="{{ route('organization.store') }}" method="POST" id="org_form"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <h5>Organization Info :</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Organization Logo</label>
                            <input type="file" class="form-control" id="logo" name="organization[logo]">
                        </div>
                        {{-- <div class="col-md-3">
                            <h6>Photo/Logo</h6>
                            <div class="d-flex flex-column align-items-center">
                                <label for="inputImage" id="inputLabel">Choose Logo</label>
                                <input type="file" id="inputImage" name="organization[logo]" onchange="changePicture()" />
                                <div id="preview-image">
                                    <img src="" id="imageDiv" class="img-fluid customImage" alt="">
            
                                    <div id="placeholder">
            
                                        <div id="upload-area" title="select a image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="organization[name]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="org_email">
                            <label class="form-label">Email <span class="text-danger"
                                    onclick="addOrganizationFields('organization[email][]','email','org_email')"><i
                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                            <input type="email" class="form-control org_email" name="organization[email][]">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" id="org_number">
                            <label class="form-label">Contact Number <span class="text-danger"
                                    onclick="addOrganizationFields('organization[number][]','number','org_number')"><i
                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                            <input type="number" class="form-control org_number" name="organization[number][]">
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group" id="org_address">
                            <label class="form-label">Address <span class="text-danger"
                                    onclick="addOrganizationFields('organization[address][]','text','org_address')"><i
                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                            <input type="text" class="form-control org_address" name="organization[address][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="contact_person_number">
                            <label class="form-label">Select Deal Type</label>
                            <select name="organization[deal_type]" id="" class="form-control">
                                <option value="Customer">Customer</option>
                                <option value="Lead">Lead</option>
                                {{-- <option value="Left">Left</option> --}}
                            </select>
                        </div>
                    </div>

                    @if (count($organization_custom_fields) > 0)
                        @foreach ($organization_custom_fields as $ocf)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ $ocf['field_name'] }}</label>
                                    {!! $ocf['html_element'] !!}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                {{-- <div class="test" id="useData" style="display: none">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="org_email">
                                <label class="form-label">Email <span class="text-danger"
                                        onclick="addOrganizationFields('organization[email][]','email','org_email')"><i
                                            class="fa fa-plus" aria-hidden="true"></i></span></label>
                                <input type="email" class="form-control org_email" name="organization[email][]">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="org_number">
                                <label class="form-label">Contact Number <span class="text-danger"
                                        onclick="addOrganizationFields('organization[number][]','number','org_number')"><i
                                            class="fa fa-plus" aria-hidden="true"></i></span></label>
                                <input type="number" class="form-control org_number" name="organization[number][]">
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-md-12">
                        <h5>Contact person info :</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Contact Person Image</label>
                            <input type="file" class="form-control person_img" id="person_img"
                                name="contact[person_img]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="contact_person">
                            <label class="form-label">Contact Person Name</label>
                            <input type="text" id="contactPersonName" class="form-control contact_person"
                                name="contact[name]">
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group" id="contact_email">
                            <label class="form-label">Contact Person Email<span class="text-danger"
                                    onclick="addOrganizationFields('contact[email][]','text','contact_email')"><i
                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                            <input type="text" id="contactPersonEmail" class="form-control contact_email"
                                name="contact[email][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="contact_person_number">
                            <label class="form-label">Contact Person Number<span class="text-danger"
                                    onclick="addOrganizationFields('contact[phone_number][]','text','contact_person_number')"><i
                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                            <input type="text" id="contactPersonNumber" class="form-control contact_person_number"
                                name="contact[phone_number][]">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" id="contact_person_number">
                            <label class="form-label">Select Deal Type</label>
                            <select name="contact[deal_type]" id="" class="form-control">
                                <option value="Customer">Customer</option>
                                <option value="Lead">Lead</option>
                            </select>
                        </div>
                    </div>


                </div>
                <div class="col-md-12">
                    <div class="form-group" id="use_above">
                        <label class="form-label">Use the email and contact number from above</label>
                        <input type="checkbox" id="useAboveInfo" name="use" onclick="useAboveData()" checked>
                    </div>
                </div>

                {{-- <hr> --}}

                {{-- <div class="row">
                    <div class="col-md-12">
                        <h5>Contact person info :</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" id="use_above">
                            <label class="form-label">Use the email and contact number from above</label>
                            <input type="checkbox" id="useAboveInfo" name="use" onclick="useAboveData()" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Contact Person Image</label>
                            <input type="file" class="form-control person_img" id="person_img"
                                name="contact[person_img]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="contact_person">
                            <label class="form-label">Contact Person</label>
                            <input type="text" id="contactPersonName" class="form-control contact_person"
                                name="contact[name]">
                        </div>
                    </div>
                    </div>

                    <div class="test" id="useData" style="display: none">
                    <div class="row">

                    <div class="col-md-6">
                        <div class="form-group" id="contact_email">
                            <label class="form-label">Contact Person Email<span class="text-danger"
                                    onclick="addOrganizationFields('contact[email][]','text','contact_email')"><i
                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                            <input type="text" id="contactPersonEmail" class="form-control contact_email"
                                name="contact[email][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="contact_person_number">
                            <label class="form-label">Contact Person Number<span class="text-danger"
                                    onclick="addOrganizationFields('contact[phone_number][]','text','contact_person_number')"><i
                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                            <input type="text" id="contactPersonNumber" class="form-control contact_person_number"
                                name="contact[phone_number][]">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group" id="use_above">
                            <label class="form-label">Is this primary contact person?</label>
                            <input type="checkbox" id="usePrimary" name="contact[is-primary]"
                                onclick="isPrimaryField()" checked>
                        </div>
                    </div>
                </div> --}}
                {{-- </div>
                </div> --}}
                {{-- <div class="row mt-2">
                    <div class="col-md-12">
                        <p id="orgErr" class="text-danger"></p>
                    </div>
                </div>
                <a href="{{ route('custom_field.index', 'Organization') }}" class="text-primary">Do you want to
                    add
                    custom
                    fields ?</a> --}}

                <button type="submit" class="btn btn-primary lead">Submit</button>

            </form>
            <br>
            <div class="toggleform">
                {{-- <button id="showForm" class="btn btn-primary" onclick="showForm()">Add New Field</button> --}}
                {{-- <div id="classone" style="display: none;"> --}}
                {{-- <div class="p-3">
                        <div class="row" id="customer-field-section">
                            <div class="col-md-6">
                                <button onclick="" style="width:400px;">
                                    <p class="p-1">Text</p>
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button onclick=""style="width:400px;">
                                    <p class="p-1">Dropdown</p>
                                </button>
                            </div>
                        </div>

                        {{-- <form action="{{ route('custom_field.store') }}" id="customerFieldSetting" method="POST">
                            @csrf
                        </form> 
                    </div> --}}
                {{-- <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Field </h5>
                            <br>
                            <form action="" method="POST" enctype="multipart/form-data" id="addslug">
                                @csrf
                                @method('POST')

                                <div class="row card-block">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Field Name <sup
                                                class="text-danger">*</sup></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="field_name"
                                                id="field_name">
                                            <p class="text-danger"></p>
                                        </div>
                                    </div>


                                    <div class="form-group row ">
                                        <label class="col-sm-2 col-form-label">Options [Note should be separeted by
                                            comma] <sup class="text-danger">*</sup></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="code"
                                                id="code">
                                            <p class="text-danger"></p>

                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Field Name <sup
                                                    class="text-danger">*</sup></label>
                                            <input type="text" class="form-control" name="field_name"
                                                id="field_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="contact_person">
                                            <label class="form-label">Options [Note should be separeted by
                                                comma] <sup class="text-danger">*</sup></label>
                                            <input type="text" class="form-control" name="code"
                                                id="code">
                                        </div>
                                    </div>

                                </div>
                                <div class="">
                                    <button type="button" onclick="submitnow()"
                                        class="btn btn-primary lead">Next</button>
                                </div>
                            </form>
                        </div>

                    </div> --}}


            </div>

        </div>
    </div>
</div>


{{-- <div class="modal-footer"> --}}
{{-- <button type="button" onclick="submitOrganizationForm()" class="btn btn-primary lead">Submit</button> --}}
{{-- <button type="submit"  class="btn btn-primary lead">Submit</button> --}}
{{-- </div> --}}
</div>
