@extends('backend.layouts.app')

@section('content')
<a href="{{ route('home.customer') }}"><button type="button" class="btn btn-primary convert mb-1"><i class="fa fa-arrow-left" aria-hidden="true">
            Back</i></button></a>
<div class="d-flex bd-highlight mb-3">
    <div class="align-self-center">

    </div>
    <div class="align-self-center mr-auto  bd-highlight">

        <span class="input-group-text" style="background-color:transparent!important; border:none!important;"><i
                class="fa fa-calendar" style="background-color: white;
    padding: 10px;
    border-radius: 50%;"></i>
            <span class="cr-date">Created Date </span>
            <span class="cr-date"> {{ $contact['created_at'] == null ? '' : $contact['created_at']->toDateString()
                }}</span>




            <!-- <form>
                <div class="form-group">
                  <div class="datepicker date input-group">
                  
                    <div class="input-group-append">
                      <span class="input-group-text"style=" border-radius:50px; padding:14px;"><i class="fa fa-calendar"></i></span>
                      <div class="p-2">Created at <span class="p-2"> <b> 01 Aug, 2023 </b></span></div>
                    </div>
                  </div>
                </div>
        </form> -->
    </div>


    {{-- <div class=" bd-highlight m-1"> <button type="button" class="btn btn-primary proposal">{{ $lead->settings->status_name }} <i
                class='fa fa-angle-right' style="color:rgba(255, 134, 134, 1);"></i> </button></div> --}}

    <div class=" bd-highlight m-1"> <button type="button" class="btn btn-primary convert"><i class="fa fa-filter"
                aria-hidden="true"></i>Filter</button></div>
    <div class="bd-highlight">
        <span class="input-group-text" style="background-color:transparent!important; border:none!important;"><i
                class="fa fa-calendar" style="background-color: white;
    padding: 10px;
    border-radius: 50%;"></i>
            <div class="m-1">
                <span class="cr-date">Convert Date</span>
                <span class="cr-date"> {{ $contact['updated_at'] == null ? '-' : $contact['updated_at']->toDateString()
                    }}</span>
            </div>
    </div>
</div>





<div class="bg-section">
    <div class="row">
        <div class="col-md-3">

            <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <img src="{{ $data['organization']!=null && $data['organization']->hasMedia('organization-logo') ? $data['organization']->getMedia('organization-logo')[0]->getFullUrl() : asset('backend/images/default-user.png')  }}"
                        id="imageDiv" class="img-fluid customImage" alt=""
                        style="border-radius:50%;height:40px; width:50px;">
                </div>
                <div class="align-self-center p-3 bd-highlight">
                    <h5 style="font-weight:600;">{{ $data['organization']!=null ? $data['organization']->name:''}}</h5>
                    <span class="profile-sec"> {{ count($data['organization_emails'])>0 ? $data['organization_emails'][0] : ''}}|
                        {{ count($data['organization_numbers'])>0 ? $data['organization_numbers'][0] : ''}} </span>
                </div>
            </div>

        </div>
        @if($organization!=null)
        <div class="col-md-3">


            <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <i class="fa fa-building profile" aria-hidden="true"></i>
                </div>
                <div class="align-self-center p-3 bd-highlight">
                    <h6 class="profile-sec">Primary Contact</h6>
                    <h6> {{$data['contact']!=null ? $data['contact']->name:'-' }} </h6>

                </div>
            </div>
        </div>
      

        <div class="col-md-3">
            <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <i class="fa fa-building profile" aria-hidden="true"></i>
                </div>
                <div class="align-self-center p-3 bd-highlight">
                    <h6 class="profile-sec">Contact Number</h6>
                    <h6> {{count($data['contact']->phones) > 0 ? $data['contact']->phones[0]:'' }} </h6>

                </div>
            </div>
        </div>
        @elseif ($contact!=null)
        <div class="col-md-3">
            <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <i class="fa fa-building profile" aria-hidden="true"></i>
                </div>
                <div class="align-self-center p-3 bd-highlight">
                    <h6 class="profile-sec">Primary Contact</h6>
                    <h6> {{ $data['contact']->name }} </h6>

                </div>
            </div>
        </div>
          
            <div class="col-md-3">
                <div class="d-flex bd-highlight mb-3">
                    <div class="align-self-center">
                        <i class="fa fa-building profile" aria-hidden="true"></i>
                    </div>
                    <div class="align-self-center p-3 bd-highlight">
                        <h6 class="profile-sec">Contact Number</h6>
                        <h6> {{count($data['contact']->phones) > 0 ? $data['contact']->phones[0]:'' }} </h6>

                    </div>
                </div>
            </div>
        
        @endif




        <div class="col-md-3">


            <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <i class="fa fa-building profile" aria-hidden="true"></i>
                </div>
                <div class="align-self-center p-3 bd-highlight">
                    <h6 class="profile-sec">Owner</h6>
                    <h6> {{$data['owner'] ?$data['owner']->name: auth()->user()->name }} </h6>

                </div>
            </div>
        </div>

    </div>



    <table class="table table-table table-light" style="border:1px solid #eaeaea; border-radius:20px!important;">
        <thead>
            <tr>
                <th class="contact-view">Deal</th>
                <th class="contact-view">Category</th>
                <th class="contact-view">Status</th>
                <th class="contact-view">Started</th>
                <th class="contact-view">Estimated Time</th>
                <th class="contact-view">Closed</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($allleads as $lead)
                
           
            <tr>
                <td>{{ $lead->title }}</td>
                <td>{{ $lead->settings->status_setting->name ?? '-'}}</td>
                <td>
                    <a href="" class="actionBtnHolder" data-toggle="modal" data-target="#commonModal"
                    onclick="loadModal('{{ route('home.dealStatusDetail', $lead['id']) }}')"
                    class="btn btn-primary">
                    <i class="fa fa-eye customer"></i>
                </a>
                </td>
                <td>{{ $lead['created_at'] == null ? '' : $lead['created_at']->toDateString() }}</td>
                <td>{{ $lead['expected_closure_date'] == null ? '-' : $lead['expected_closure_date'] }}</td>
                {{-- <td>{{ $lead['expected_closure_date'] == null ? '-' : $lead['expected_closure_date']->toDateString() }}</td> --}}
                <td>{{ $lead['converted_at'] == null ? '-' : $lead['converted_at']->toDateString() }}</td>
                <td><a href="{{ route('lead.leadprofile',$lead['id']) }}"  >
                    <i class="fa fa-solid fa-arrow-right"></i>
            </a></td>
            </tr>

            @endforeach

        </tbody>
    </table>

   

    <ul class="nav nav-tab mt-5" role="tablist">
        <li class="nav-item">
            <div class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <i class="fa fa-building profile" aria-hidden="true"></i> <span class="p-2">Contact</span>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <i class="fa fa-building profile" aria-hidden="true"></i> <span class="p-2">Handler</span>
                </div>
            </div>
        </li>


        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <i class="fa fa-building profile" aria-hidden="true"></i> <span class="p-2">Note</span>
                </div>
            </div>
        </li>


        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-4" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <i class="fa fa-building profile" aria-hidden="true"></i> <span class="p-2">Company
                        Details</span>
                </div>
            </div>
        </li>


    </ul>

    <!-- Tab panes -->
    <div class="tab-content mt-5">
        <div class="tab-pane active" id="tabs-1" role="tabpanel" style=" border: 1px solid #eaeaea;
    padding: 25px;
    border-radius: 10px;">

            <div class="row">
                @if (count($data)>0 && count($data['og_contacts'])>0 && $lead->organization_id!=null)
                @foreach ($data['og_contacts'] as $contact)
                    <div class="col-md-4">

                        <div class="d-flex bd-highlight mb-3">
                            <div class="align-self-center">
                                <img src="{{ $contact->hasMedia('contact_media') ? $contact->getMedia('contact_media')[0]->getFullUrl() : asset('backend/images/default-user.png')  }}"
                                    id="imageDiv" class="img-fluid customImage" alt=""
                                    style="border-radius:50%;height:40px; width:50px;">
                            </div>
                            <div class="align-self-center p-3 bd-highlight" style="border-right:1px solid #eaeaea;">
                                <h6 class="profile-sec">
                                    {{ $contact->is_primary == '1' ? 'Primary Contact' : 'Secondary Contact' }}</h6>
                                <h6> {{ $contact->name }} </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex bd-highlight mb-3">
                            <div class="align-self-center">
                                <i class="fa fa-building profile" aria-hidden="true"></i>
                            </div>
                            <div class="align-self-center p-3 bd-highlight" style="border-right:1px solid #eaeaea;">
                                <h6 class="profile-sec">Contact Number</h6>
                                <h6>
                                    @foreach ( $contact->phones as $key => $value)
                                    {{ $value }} {{ $loop->last ? '' : '|' }}
                                    @endforeach
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex bd-highlight mb-3">
                            <div class="align-self-center">
                                <i class="fa fa-building profile" aria-hidden="true"></i>
                            </div>
                            <div class="align-self-center p-3 bd-highlight">
                                <h6 class="profile-sec">Email</h6>
                                <h6>
                                    @foreach ( $contact->emails as $key => $value)
                                    {{ $value }} {{ $loop->last ? '' : '|' }}
                                    @endforeach
                                </h6>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- @elseif($lead->contact_id!=null)
                    <div class="col-md-4">
                        <div class="d-flex bd-highlight mb-3">
                            <div class="align-self-center">
                                <img src="{{ $data['contact']->hasMedia('contact_media') ? $data['contact']->getMedia('contact_media')[0]->getFullUrl() : '' }}"
                                    id="imageDiv" class="img-fluid customImage" alt=""
                                    style="border-radius:50%;height:40px; width:50px;">
                            </div>
                            <div class="align-self-center p-3 bd-highlight" style="border-right:1px solid #eaeaea;">
                                <h6 class="profile-sec">
                                    {{ $data['contact']->is_primary == '1' ? 'Primary Contact' : 'Secondary Contact' }}</h6>
                                <h6> {{ $data['contact']->name }} </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">


                        <div class="d-flex bd-highlight mb-3">
                            <div class="align-self-center">
                                <i class="fa fa-building profile" aria-hidden="true"></i>
                            </div>
                            <div class="align-self-center p-3 bd-highlight" style="border-right:1px solid #eaeaea;">
                                <h6 class="profile-sec">Contact Number</h6>
                                <h6>
                                    @foreach ($data['contact_numbers'] as $key => $value)
                                    {{ $value }} {{ $loop->last ? '' : '|' }}
                                    @endforeach
                                </h6>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex bd-highlight mb-3">
                            <div class="align-self-center">
                                <i class="fa fa-building profile" aria-hidden="true"></i>
                            </div>
                            <div class="align-self-center p-3 bd-highlight">
                                <h6 class="profile-sec">Email</h6>
                                <h6>
                                    @foreach ($data['contact_emails'] as $key => $value)
                                    {{ $value }} {{ $loop->last ? '' : '|' }}
                                    @endforeach
                                </h6>

                            </div>
                        </div>
                    </div> --}}
                @endif


            </div>

        </div>


        <div class="tab-pane" id="tabs-2" role="tabpanel" style=" border: 1px solid #eaeaea;padding: 25px;border-radius: 10px;">

            <div class="row">
                <div class="col-md-4">

                    <div class="d-flex bd-highlight mb-3">
                        <div class="align-self-center">
                            <img src="backend/images/avatar-1.jpg" id="imageDiv" class="img-fluid customImage" alt=""
                                style="border-radius:50%;height:40px; width:50px;">
                        </div>
                        <div class="align-self-center p-3 bd-highlight" style="border-right:1px solid #eaeaea;">
                            <h6 class="profile-sec">Primary Contact</h6>
                            <h6> Organization Details </h6>
                        </div>
                    </div>

                </div>

                <div class="col-md-4">

                    <div class="d-flex bd-highlight mb-3">
                        <div class="align-self-center">
                            <img src="backend/images/avatar-1.jpg" id="imageDiv" class="img-fluid customImage" alt=""
                                style="border-radius:50%;height:40px; width:50px;">
                        </div>
                        <div class="align-self-center p-3 bd-highlight" style="border-right:1px solid #eaeaea;">
                            <h6 class="profile-sec">Primary Contact</h6>
                            <h6> Organization Details </h6>
                        </div>
                    </div>

                </div>


                <div class="col-md-4">

                    <div class="d-flex bd-highlight mb-3">
                        <div class="align-self-center">
                            <img src="backend/images/avatar-1.jpg" id="imageDiv" class="img-fluid customImage" alt=""
                                style="border-radius:50%;height:40px; width:50px;">
                        </div>
                        <div class="align-self-center p-3 bd-highlight" style="border-right:1px solid #eaeaea;">
                            <h6 class="profile-sec">Primary Contact</h6>
                            <h6> Organization Details </h6>
                        </div>
                    </div>

                </div>


            </div>
        </div>
        <div class="tab-pane" id="tabs-3" role="tabpanel" style=" border: 1px solid #eaeaea;padding: 25px;border-radius: 10px;">
            <div class="d-flex bd-highlight">
                <div class="p-2 flex-fill bd-highlight mt-2"><i class="fa fa-sticky-note-o"
                        style="font-size:14px;margin-right:10px;"></i>
                    <span class="cr-date">Updated phone numbers in letterhead and social media post</span>
                </div>
                <div class="flex-fill bd-highlight">

                    <span class="input-group-text"
                        style="background-color:transparent!important; border:none!important;"><i class="fa fa-calendar"
                            style="background-color:#ddd;padding: 10px;border-radius: 50%;"></i>

                        <span class="cr-date">Upload Date</span>
                        <span class="cr-date"></span>


                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <textarea class="form-control form-control-sm mb-3 p-5 m-3" name="activity" rows="1"
                        placeholder="Textarea" style="background-color:#FCFBFB;"></textarea>
                </div>

                <div class="col-3">

                    <div class="py-3">
                        <button class="btn btn-primary" type="submit" style="font-size:13px;">Create
                            Activity</button>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->
        <div class="tab-pane" id="tabs-4" role="tabpanel" style=" border: 1px solid #eaeaea;padding: 25px;border-radius: 10px;">
            <div class="row">
                <div class="col-md-3">
                    <div class="d-flex bd-highlight mb-3">
                        <div class="align-self-center">
                            <img src="{{ $company->hasMedia('company-logo') ? $company->getMedia('company-logo')[0]->getFullUrl() : asset('backend/images/default-user.png')  }}"
                                id="imageDiv" class="img-fluid customImage" alt=""
                                style="border-radius:50%;height:40px; width:50px;">
                        </div>
                        <div class="align-self-center p-3 bd-highlight" style="border-right:1px solid #eaeaea;">
                          
                            <h6> {{ $company->name }} </h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex bd-highlight mb-3">
                        <div class="align-self-center">
                            <i class="fa fa-building profile" aria-hidden="true"></i>
                        </div>
                        <div class="align-self-center p-3 bd-highlight" style="border-right:1px solid #eaeaea;">
                            <h6 class="profile-sec">Contact Number</h6>
                            <h6>
                              {{ $company->phone_number }} 
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex bd-highlight mb-3">
                        <div class="align-self-center">
                            <i class="fa fa-building profile" aria-hidden="true"></i>
                        </div>
                        <div class="align-self-center p-3 bd-highlight" style="border-right:1px solid #eaeaea;">
                            <h6 class="profile-sec">Email</h6>
                            <h6>
                                {{ $company->email }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
        </div>
        <!--  -->
    </div>
</div>
</div>


<nav class=" mt-5 mb-5" aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-3">
        <li class="page-item">
            <a class="page-link" href="#" aria-label="Previous">

                <span aria-hidden="true">&laquo;</span>
                <i class="fa fa-chevron-left" style="font-size:10px;"></i>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        <li class="page-item active"><a class="page-link " href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
            <a class="page-link" href="#" aria-label="Next">
                <i class="fa fa-chevron-right" style="font-size:10px;"></i>
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>

    </ul>


</nav>
@endsection