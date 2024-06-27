<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Edit {{ $contact->name }} : </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="{{ route('contact.update') }}" method="POST" id="contact_form">
        <div class="modal-body">
            <div class="p-3">
                @csrf
                <input type="text" name="id" value="{{ $contact->id }}" hidden>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Name<sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="name" name="contact[name]"
                                value="{{ $contact->name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="contact_email">
                            <label class="form-label">Email<sup class="text-danger">*</sup> <span class="text-danger"
                                    onclick="addOrganizationFields('contact[email][]','email','contact_email')"><i
                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                            @foreach ($emails as $email)
                                <input type="email" class="form-control contact_email" name="contact[email][]"
                                    value="{{ $email }}">
                            @endforeach
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <div class="form-group" id="org_address">
                            <label class="form-label">Address <span class="text-danger" onclick="addOrganizationFields('organization[address][]','text','org_address')"><i class="fa fa-plus" aria-hidden="true"></i></span></label>
                            <input type="text" class="form-control org_address" name="organization[address][]">
                        </div>
                    </div> --}}
                    <div class="col-md-6">
                        <div class="form-group" id="contact_number">
                            <label class="form-label">Contact Number<sup class="text-danger">*</sup> <span
                                    class="text-danger"
                                    onclick="addOrganizationFields('contact[number][]','number','contact_number')"><i
                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                            @foreach ($phone_numbers as $phone)
                                <input type="number" class="form-control contact_number" name="contact[number][]"
                                    value="{{ $phone }}">
                            @endforeach
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <div class="form-group" id="organization">
                            <label class="form-label">Organization</label>
                            <input type="text" name="organization[is_new]" value="1" id="existingDataCheckModal" hidden>
                            <input type="text" name="organization[id]" value="" id="organizationDataId" hidden>
                            <input type="text" name="organization[name]" class="form-control" onkeyup="searchWords('{{route('ajax.getDropdown','something')}}')" id="searchWordsUniqueVal">
                            <div name="organization_id" class="form-control" id="inputSelect" style="display: none">
                                
                            </div>
                        </div>
                    </div> --}}
                    @if (count($helper_data) > 0)
                        @foreach ($helper_data as $h_d)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ $h_d['label'] }}</label>
                                    {!! $h_d['html'] !!}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <p id="orgErr" class="text-danger"></p>
                    </div>
                </div>
                <a href="{{ route('custom_field.index', 'Contacts') }}" class="text-primary">Do u want to add custom
                    fields</a>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="submitContactForm()" class="btn btn-secondary">Submit</button>
        </div>
    </form>

</div>
<script>
    function submitContactForm() {
        debugger;
    }
</script>
