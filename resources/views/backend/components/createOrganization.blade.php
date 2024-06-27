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
                        <h5 class="mt-5">Contact person info :</h5>
                    </div>
                    {{-- <div class="col-md-12">
                        <div class="form-group" id="use_above">
                            <label class="form-label">Use the email and contact number from above</label>
                            <input type="checkbox" id="useAboveInfo" name="use" onclick="useAboveData()">
                        </div>
                    </div> --}}
                    <div class="col-md-3">
                        <h6>Photo/Logo</h6>
                        <div class="d-flex flex-column align-items-center">
                            <label for="inputImage" id="inputLabel">Choose Logo</label>
                            <input type="file" id="inputImage_con" name="contact[person_img]" class="inputImage"
                                onchange="changePictureContact('inputImage_con','preview_image_con','placeholder_con','imageDiv_con')" />
                            <div id="preview_image_con">
                                <img src="" id="imageDiv_con" class="img-fluid customImage" alt="">

                                <div id="placeholder_con">

                                    <div id="upload-area" title="select a image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-8">
                        <div class="form-group" id="contact_person">
                            <label class="form-label">Contact Person Name <sup class="text-danger">*</sup></label>
                            <input type="text" id="contactPersonName" class="form-control contact_person"
                                name="contact[name]">
                        </div>
                        <div class="form-group" id="contact_email">
                            <label class="form-label">Contact Person Email<span class="text-danger"
                                    onclick="addOrganizationFields('contact[email][]','text','contact_email')"><i
                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                            <input type="email" id="contactPersonEmail" class="form-control contact_email"
                                name="contact[email][]">
                        </div>
                        <div class="form-group" id="contact_person_numbers">
                            <label class="form-label">Contact Person Number<span class="text-danger"
                                    onclick="addOrganizationFields('contact[phone_number][]','text','contact_person_numbers')"><i
                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                            <input type="text" id="contactPersonNumber" class="form-control contact_person_numbers"
                                name="contact[phone_number][]">
                        </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Organization Info :</h5>
                    </div>
                         <div class="col-md-3">
                            <h6>Photo/Logo</h6>
                            <div class="d-flex flex-column align-items-center">
                                <label for="inputImage" id="inputLabel">Choose Logo</label>
                                <input type="file" id="inputImage_org" class="inputImage" name="organization[logo]" onchange="changePictureContact('inputImage_org','preview_image_org','placeholder_org','imageDiv_org')" />
                                <div id="preview_image_org">
                                    <img src="" id="imageDiv_org" class="img-fluid customImage" alt="">
            
                                    <div id="placeholder_org">
            
                                        <div id="upload-area" title="select a image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="organization[name]">
                        </div>
                        <div class="form-group" id="org_email">
                            <label class="form-label">Email <span class="text-danger"
                                    onclick="addOrganizationFields('organization[email][]','email','org_email')"><i
                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                            <input type="email" class="form-control org_email" name="organization[email][]">
                        </div>
                        <div class="form-group" id="org_number">
                            <label class="form-label">Contact Number <span class="text-danger"
                                    onclick="addOrganizationFields('organization[number][]','number','org_number')"><i
                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                            <input type="number" class="form-control org_number" name="organization[number][]">
                        </div>
                    <div class="col-md-12">
                        <div class="form-group" id="org_address">
                            <label class="form-label">Address <span class="text-danger"
                                    onclick="addOrganizationFields('organization[address][]','text','org_address')"><i
                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                            <input type="text" class="form-control org_address" name="organization[address][]">
                        </div>
                    </div>
                   
                </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group" id="deal_type">
                        <label class="form-label">Select lifecycle stage</label>
                        <select name="deal_type" id="" class="form-control">
                            <option value="Lead">Lead</option>
                            <option value="Customer">Customer</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="row mx-2 mt-2">
            <div class="col-md-12">
                <p id="emailErr" class="text-danger"></p>
                <p id="orgErr" class="text-danger"></p>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" onclick="submitOrganizationForm()" class="btn btn-primary lead">Submit</button>
    </div>
</div>


{{-- <div class="modal-footer"> --}}
{{-- <button type="button" onclick="submitOrganizationForm()" class="btn btn-primary lead">Submit</button> --}}
{{-- <button type="submit"  class="btn btn-primary lead">Submit</button> --}}
{{-- </div> --}}
