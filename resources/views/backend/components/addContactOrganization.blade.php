<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title p-1" id="exampleModalLabel">{{ $contact->organization_id == null?'Organization Contact Setup':"Contact person Setup" }}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="checkmodule">

            @if ($contact->organization_id == null)
                <div class="p-3">
                    <form action="{{ route('organization.organizationContactStore') }}"
                        method="POST" id="organization_form{{ $contact->id }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Organization Info :</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Organization
                                        Logo</label>
                                    <input type="file" class="form-control" id="logo"
                                        name="organization[logo]">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Name <sup
                                            class="text-danger">*</sup></label>
                                    <input type="text"
                                        class="form-control org_name{{ $contact->id }}"
                                        id="org_name{{ $contact->id }}"
                                        name="organization[name]">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="org_email{{ $contact->id }}">
                                    <label class="form-label">Email <span class="text-danger"
                                            onclick="addOrganizationFields('organization[email][]','email','org_email{{ $contact->id }}')"><i
                                                class="fa fa-plus"
                                                aria-hidden="true"></i></span></label>
                                    <input type="email"
                                        class="form-control org_email{{ $contact->id }}"
                                        name="organization[email][]">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" id="org_number{{ $contact->id }}">
                                    <label class="form-label">Contact Number <span
                                            class="text-danger"
                                            onclick="addOrganizationFields('organization[number][]','number','org_number{{ $contact->id }}')"><i
                                                class="fa fa-plus"
                                                aria-hidden="true"></i></span></label>
                                    <input type="number"
                                        class="form-control org_number{{ $contact->id }}"
                                        name="organization[number][]">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group" id="org_address{{ $contact->id }}">
                                    <label class="form-label">Address <span
                                            class="text-danger"
                                            onclick="addOrganizationFields('organization[address][]','text','org_address{{ $contact->id }}')"><i
                                                class="fa fa-plus"
                                                aria-hidden="true"></i></span></label>
                                    <input type="text"
                                        class="form-control org_address{{ $contact->id }}"
                                        name="organization[address][]">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3"
                                    style="font-size:18px;color:black;font-weight:600;">
                                    Contact
                                    person info </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Contact Person
                                        Image</label>
                                    <input type="file" class="form-control person_img"
                                        id="person_img" name="contact[person_img]">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="contact_person">
                                    <label class="form-label">Contact Person
                                        Name <sup class="text-danger">*</sup></label>
                                    {{-- <h5>{{ $contact->name }}</h5> --}}
                                    <input type="text"
                                        id="contactPersonName{{ $contact->id }}"
                                        class="form-control contact_person{{ $contact->id }}"
                                        name="contact[name]">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group"
                                    id="contact_email{{ $contact->id }}">
                                    <label class="form-label">Contact Person
                                        Email<span class="text-danger"
                                            onclick="addOrganizationFields('contact[email][]','text','contact_email{{ $contact->id }}')"><i
                                                class="fa fa-plus"
                                                aria-hidden="true"></i></span></label>
                                    <input type="email" id="contactPersonEmail"
                                        class="form-control contact_email{{ $contact->id }}"
                                        name="contact[email][]">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"
                                    id="contact_person_number{{ $contact->id }}">
                                    <label class="form-label">Contact Person
                                        Number<span class="text-danger"
                                            onclick="addOrganizationFields('contact[phone_number][]','text','contact_person_number{{ $contact->id }}')"><i
                                                class="fa fa-plus"
                                                aria-hidden="true"></i></span></label>
                                    <input type="text" id="contactPersonNumber"
                                        class="form-control contact_person_number{{ $contact->id }}"
                                        name="contact[phone_number][]">
                                </div>
                            </div>

                          
                            <div class="col-md-12">
                                <p id="orgErr{{ $contact->id }}" class="text-danger">
                                <p id="emailErr{{ $contact->id }}" class="text-danger">
                                </p>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <button type="button"
                                onclick="submitOrgForm({{ $contact->id }})"
                                class="btn btn-primary lead">Update</button>
                        </div>
                    </form>
                </div>
            @else
                <div class="p-3">
                    <form action="{{ route('organization.contactStore') }}" method="POST"
                        id="contact_form{{ $contact->id }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="organization_id"
                            id="organization_id{{ $contact->id }}"
                            value="{{ $contact->organization_id }}">

                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3"
                                    style="font-size:18px;color:black;font-weight:600;">
                                    Contact
                                    person info </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Contact Person
                                        Image</label>
                                    <input type="file" class="form-control person_img"
                                        id="person_img" name="contact[person_img]">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="contact_person">
                                    <label class="form-label">Contact Person
                                        Name</label>
                                    {{-- <h5>{{ $contact->name }}</h5> --}}
                                    <input type="text"
                                        id="contactPersonName{{ $contact->id }}"
                                        class="form-control contact_person{{ $contact->id }}"
                                        name="contact[name]">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group"
                                    id="contact_email{{ $contact->id }}">
                                    <label class="form-label">Contact Person
                                        Email<span class="text-danger"
                                            onclick="addOrganizationFields('contact[email][]','text','contact_email{{ $contact->id }}')"><i
                                                class="fa fa-plus"
                                                aria-hidden="true"></i></span></label>
                                    <input type="email" id="contactPersonEmail"
                                        class="form-control contact_email{{ $contact->id }}"
                                        name="contact[email][]">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"
                                    id="contact_person_number{{ $contact->id }}">
                                    <label class="form-label">Contact Person
                                        Number<span class="text-danger"
                                            onclick="addOrganizationFields('contact[phone_number][]','text','contact_person_number{{ $contact->id }}')"><i
                                                class="fa fa-plus"
                                                aria-hidden="true"></i></span></label>
                                    <input type="text" id="contactPersonNumber"
                                        class="form-control contact_person_number{{ $contact->id }}"
                                        name="contact[phone_number][]">
                                </div>
                            </div>


                        </div>
                     
                        <div class="col-md-12">
                            <p id="emailError{{ $contact->id }}" class="text-danger"></p>
                            <p id="contactError{{ $contact->id }}" class="text-danger">
                            </p>
                        </div>
                       
                        <div class="col-md-3">
                           
                            <button type="button"
                                onclick="formValidateNow({{ $contact->id }})"
                                class="btn btn-primary lead">Update</button>
                        </div>
                    </form>

                </div>
            @endif
        </div>
    </div>
   

</div>