<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Contact Book Update : </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="p-3">
            <form action="{{ route('organization.update') }}" method="POST" id="org_form{{ $contact->id }}"
                enctype="multipart/form-data">
                @csrf

                <input name="contact_id" value="{{ $contact->id }}" hidden>
                <input type="number" id="updateorganizationModal{{ $contact->id }}"
                    value="{{ $contact->organization_id }}" hidden>

                <div class="row">
                    <div class="col-md-12">
                        <h5>Contact Person Info :</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Contact Person Image</label>
                            <input type="file" class="form-control person_img" id="person_img"
                                name="contact[person_img]">
                            <img src="{{ $contact->hasMedia('contact_media') ? $contact->getMedia('contact_media')[0]->getFullUrl() : asset('backend/images/default-user.png')}}"
                                id="imageDiv" class="img-fluid customImage" alt=""
                                style="border-radius:50%;height:100px; width:100px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Name <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="contactPersonUpdate{{ $contact->id }}"
                                name="contact[name]" value="{{ $contact->name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="contact_email_update{{ $contact->id }}">
                            <label class="form-label">Contact Email <span class="text-danger"
                                    onclick="addOrganizationFields('contact[email][]','email','contact_email_update{{ $contact->id }}')"><i
                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                            @foreach ($emails as $email)
                                <div class="mt-1">
                                <input type="email" class="form-control contact_email_update{{ $contact->id }} {{ $loop->first ? '': 'input-append'}}"
                                    name="contact[email][]" value="{{ $email }}">
                                    @if (!$loop->first)
                                   <span><i onclick="removeInputField()" class='fa fa-trash customer' aria-hidden='true'></i></span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                     

                    <div class="col-md-6">
                        <div class="form-group" id="contact_number_update{{ $contact->id }}">
                            <label class="form-label">Contact Number <span class="text-danger"
                                    onclick="addOrganizationFields('contact[number][]','text','contact_number_update{{ $contact->id }}')"><i
                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                            @foreach ($phone_numbers as $number)
                            <div class="mt-1">
                                <input type="text" class="form-control contact_number_update{{ $contact->id }} {{ $loop->first ? '': 'input-append'}}""
                                    name="contact[number][]" value="{{ $number }}">
                                    @if (!$loop->first)
                                   <span><i onclick="removeInputField()" class='fa fa-trash customer' aria-hidden='true'></i></span>
                                    @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if ($contact->organization_id !=null)
                    <hr>
                    <div class="row">

                        <input  name="organization_id" value="{{ $contact->organization_id }}" hidden>
                        <div class="col-md-12">
                            <h5>Organization Info :</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Organization Logo</label>
                                <input type="file" class="form-control" id="logo" name="organization[logo]">
                                <img src="{{ $org['organization']->hasMedia('organization-logo') ? $org['organization']->getMedia('organization-logo')[0]->getFullUrl() : asset('backend/images/default-user.png') }}"
                                    id="imageDiv{{ $contact->id }}" class="img-fluid customImage" alt=""
                                    style="border-radius:50%;height:100px; width:100px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Name <sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="org_name_update{{ $contact->id }}"
                                    name="organization[name]" value="{{ $org['organization']->name }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="org_email_update{{ $contact->id }}">
                                <label class="form-label">Email <span class="text-danger"
                                        onclick="addOrganizationFields('organization[email][]','email','org_email_update{{ $contact->id }}')"><i
                                            class="fa fa-plus" aria-hidden="true"></i></span></label>
                                @foreach ($org['emails'] as $number)
                                <div class="mt-1">
                                    <input type="email"
                                        class="form-control contact_number_update{{ $contact->id }} {{ $loop->first ? '': 'input-append'}}"
                                        name="organization[email][]" value="{{ $number }}">
                                        @if (!$loop->first)
                                   <span><i onclick="removeInputField()" class='fa fa-trash customer' aria-hidden='true'></i></span>
                                    @endif
                                </div>
                                @endforeach

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" id="org_number_update{{ $contact->id }}">
                                <label class="form-label">Contact Number <span class="text-danger"
                                        onclick="addOrganizationFields('organization[number][]','text','org_number_update{{ $contact->id }}')"><i
                                            class="fa fa-plus" aria-hidden="true"></i></span></label>
                                @foreach ($org['contact_number'] as $number)
                                <div class="mt-1">
                                    <input type="text" class="form-control org_number_update{{ $contact->id }} {{ $loop->first ? '': 'input-append'}}"                                        name="organization[number][]" value="{{ $number }}">
                                        @if (!$loop->first)
                                   <span><i onclick="removeInputField()" class='fa fa-trash customer' aria-hidden='true'></i></span>
                                    @endif
                                </div>
                                @endforeach

                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group" id="org_address_update{{ $contact->id }}">
                                <label class="form-label">Address <span class="text-danger"
                                        onclick="addOrganizationFields('organization[address][]','text','org_address_update{{ $contact->id }}')"><i
                                            class="fa fa-plus" aria-hidden="true"></i></span></label>
                                @foreach ($org['address'] as $number)
                                <div class="mt-1">
                                    <input type="text" class="form-control org_address_update{{ $contact->id }} {{ $loop->first ? '': 'input-append'}}"
                                        name="organization[address][]" value="{{ $number }}">
                                        @if (!$loop->first)
                                   <span><i onclick="removeInputField()" class='fa fa-trash customer' aria-hidden='true'></i></span>
                                    @endif
                                </div>
                                @endforeach


                            </div>
                        </div>
                      

                    </div>
                    @if ($contact->organization_id !=null  && count($or_contact)>0)
                    <div class="row">
                    <div class="col-md-5">
                        <h5>Secondary Contact Person Info :</h5>
                        <hr>
                    </div>
                </div>

                    @foreach ($or_contact as $key=> $org_contact)
                        
                    <div class="row border mb-3" id="org_contact_delete_div{{$org_contact->id   }}">
                       <div class="col-md-12">
                        <a class="float-right mt-3" onclick="removeSecondaryContact({{ $org_contact->id }})"> <i class="fa fa-trash customer" aria-hidden="true" style="cursor: pointer;"></i></a>
                       </div>
                        <input type="hidden" name="org_contact[{{ $key }}][id]" value="{{ $org_contact->id }}">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Contact Person Image</label>
                                <input type="file" class="form-control person_img" id="person_img"
                                    name="org_contact[{{ $key }}][person_img]">
                                <img src="{{ $org_contact->hasMedia('contact_media') ? $org_contact->getMedia('contact_media')[0]->getFullUrl() : asset('backend/images/default-user.png') }}"
                                    id="imageDiv" class="img-fluid customImage" alt=""
                                    style="border-radius:50%;height:100px; width:100px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Name <sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="contactPersonUpdate{{  $org_contact->id }}"
                                    name="org_contact[{{ $key }}][name]" value="{{ $org_contact->name }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="contact_email_update{{ $org_contact->id }}">
                                <label class="form-label">Contact Email <span class="text-danger"
                                        onclick="addOrganizationFields('org_contact[{{ $key }}][email][]','email','contact_email_update{{ $org_contact->id }}')"><i
                                            class="fa fa-plus" aria-hidden="true"></i></span></label>
                                @if ($org_contact['emails']!=null)
                                @foreach ($org_contact['emails'] as $email)
                                <div class="mt-1">
                                    <input type="email" class="form-control contact_email_update{{ $org_contact->id }} {{ $loop->first ? '': 'input-append'}}"
                                        name="org_contact[{{ $key }}][email][]" value="{{ $email }}">
                                        @if (!$loop->first)
                                        <span><i onclick="removeInputField()" class='fa fa-trash customer' aria-hidden='true'></i></span>
                                         @endif
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="contact_number_update{{ $org_contact->id }}">
                                <label class="form-label">Contact Number <span class="text-danger"
                                        onclick="addOrganizationFields('org_contact[{{ $key }}][number][]','text','contact_number_update{{ $org_contact->id }}')"><i
                                            class="fa fa-plus" aria-hidden="true"></i></span></label>
                                @if ($org_contact['numbers']!=null)
                                @foreach ($org_contact['numbers'] as $number)
                                <div class="mt-1">
                                    <input type="text" class="form-control contact_number_update{{ $org_contact->id }} {{ $loop->first ? '': 'input-append'}}"
                                        name="org_contact[{{ $key }}][number][]" value="{{ $number }}">
                                        @if (!$loop->first)
                                        <span><i onclick="removeInputField()" class='fa fa-trash customer' aria-hidden='true'></i></span>
                                         @endif
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @endif
                @endif

                <div class="row mt-2">
                    <div class="col-md-12">
                        <p id="emailErr{{  $contact->id }}" class="text-danger"></p>
                        <p id="orgErr{{ $contact->id }}" class="text-danger"></p>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group" id="contact_person_number">
                        <label class="form-label">Select Deal Type</label>
                        <select name="deal_type" id="" class="form-control">
                            <option value="Customer" {{  $contact->deal_type=="Customer" ?'selected':'' }}>Customer</option>
                            <option value="Lead" {{  $contact->deal_type=="Lead" ?'selected':'' }}>Lead</option>
                         
                        </select>
                    </div>
                </div>
                {{-- <button type="submit" class="btn btn-primary lead">Update</button> --}}
            </form>
        </div>
    </div>
    <div class="modal-footer">
        
        <button type="button" onclick="updateOrganizationContactForm({{ $contact->id }})"
            class="btn btn-primary lead">Update</button>
    </div>
</div>
