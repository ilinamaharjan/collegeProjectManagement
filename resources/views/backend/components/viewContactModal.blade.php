<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h6 class="pageMainTitle modal-title">{{ $contact->name }} Details </h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="width:70%;">
            <div class="d-flex bd-highlight mb-3">
                {{-- <div class="align-self-center">
                    <img src="{{ $contact->hasMedia('contact-logo') ? $contact->getMedia('contact-logo')[0]->getFullUrl() : 'backend/images/avatar-1.jpg' }}"
                        class="img-fluid customImage" alt="company logo" style="height:130px; width:130px;">
                </div> --}}
                <div class="align-self-center p-3 bd-highlight">

                    <table class="table">
                        <thead>
                            <tr>



                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="col"><b>Contact Person</b> </th>
                                <th scope="col"> : {{ $contact['name'] }}</th>

                            </tr>
                            <tr>
                                <th scope="col"><b>Organization Name</b> </th>
                                <th scope="col"> : {{ $contact->organization == null ? '' : $contact->organization->name }}</th>

                            </tr>
                            <tr>
                                <th scope="col"><b>Company Name</b> </th>
                                <th scope="col"> : {{ $contact->company->name }}</th>

                            </tr>
                            <tr>
                                <th scope="col"><b>Email</b> </th>
                                <th scope="col"> : {{ implode(',',$decoded_emails) }}</th>

                            </tr>
                            <tr>
                                <th scope="col"><b>Numbers</b> </th>
                                <th scope="col"> : {{ implode(',',$decoded_phones) }}</th>

                            </tr>
                            @if (count($helper_data) > 0)
                                @foreach ($helper_data as $hd)
                                @if ($hd['value'] == null)
                                    
                                @else
                                <tr>
                                    <th scope="col"><b>{{$hd['label']}}</b> </th>
                                    <th scope="col"> : {{ $hd['value'] }}</th>
                                </tr>
                                @endif
                                @endforeach
                            @endif
                            
                        </tbody>
                    </table>



                </div>
            </div>
        </div>

    </div>
</div>
