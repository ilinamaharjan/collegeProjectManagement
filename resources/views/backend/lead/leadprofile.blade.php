@extends('backend.layouts.app')

@section('content')
<a href="" ><button type="button" class="btn btn-primary convert mb-1"><i class="fa fa-arrow-left" aria-hidden="true">
            Back</i></button></a>
<div class="d-flex bd-highlight mb-3">
    <div class="align-self-center">

    </div>
    <div class="align-self-center mr-auto p-2 bd-highlight">

        <span class="input-group-text" style="background-color:transparent!important; border:none!important;"><i
                class="fa fa-calendar" style="background-color: white;
    padding: 10px;
    border-radius: 50%;"></i> <input placeholder="Select date" type="date" id="example_date" class="form-control"
                value="{{ $lead['created_at'] == null ? '' : $lead['created_at']->toDateString() }}" disabled></span>



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

    <div class="p-2 bd-highlight"> <button type="button" class="btn btn-primary convert"><i class="fa fa-exchange"
                aria-hidden="true"></i>Convert</button></div>
    <div class="p-2 bd-highlight"> <button type="button" class="pl-3 pr-3"
            style="background-color: {{ $lead_setting['fav_color'] }} !important; font-size:14px;">{{ $lead_setting['status_name'] }} <i class="fa fa-angle-right" style="color:#0c8940;"></i></button></div>
</div>



<div class="bg-section">
    <div class="row" style="border-bottom:1px solid #eaeaea;">
        <div class="col-md-4">

            <div class="d-flex bd-highlight mb-3">
            
                <div class="align-self-center p-3 bd-highlight">
                    <h5 style="font-weight:600; font-size:12px;text-align:justify;">{{ $lead['title'] }}</h5>
                    <span class="profile-sec"> {{ $lead['email'] }} |
                        {{ $lead['num'] }} </span>
                </div>
            </div>

        </div>

        {{-- <div class="col-md-3">

            <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <i class="fa fa-building profile" aria-hidden="true"></i>
                </div>
                <div class="align-self-center p-3 bd-highlight">
                    <h6 class="profile-sec">Jonny Deo</h6>
                    Global Equity

                </div>
            </div>

        </div> --}}

        <div class="col-md-4">


            <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <i class="fa fa-building profile" aria-hidden="true"></i>
                </div>
                <div class="align-self-center p-3 bd-highlight">
                    <h6 class="profile-sec">Organization</h6>
                  <h6  style="font-weight:600; font-size:12px;">  {{ $lead->organization != null ? $lead->organization->name : '' }} </h6>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <i class="fa fa-building profile" aria-hidden="true"></i>
                </div>
                <div class="align-self-center p-3 bd-highlight">
                    <h6 class="profile-sec">Owner</h6>
                    <h6  style="font-weight:600; font-size:12px;">{{ $lead->creator->name }}</h6>

                </div>
            </div>
        </div>

    </div>


    <ul class="nav nav-tab" role="tablist" style="border-bottom:1px solid #eaeaea;">
        <li class="nav-item">
            <div class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <i class="fa fa-building profile" aria-hidden="true"></i> <span class="p-2">Activity</span>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <i class="fa fa-building profile" aria-hidden="true"></i> <span class="p-2">File</span>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <i class="fa fa-building profile" aria-hidden="true"></i> <span class="p-2">Invoice</span>
                </div>
            </div>
        </li>


        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-4" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <i class="fa fa-building profile" aria-hidden="true"></i> <span class="p-2">Notes</span>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-5" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <i class="fa fa-building profile" aria-hidden="true"></i> <span class="p-2">Status History</span>
                </div>
            </div>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content mt-5">
        <div class="tab-pane " id="tabs-2" role="tabpanel">
            <input type="text" id="leadId" value="{{ $lead['id'] }}" hidden>
            <select name="" class="form-control mb-3" id="" class="mb-2" onchange="toggleFiles()">
                <option value="all">Choose All</option>
                @foreach($file_types as $ft)
                <option value="{{ $ft['id'] }}">{{ $ft['name'] }}
                </option>
                @endforeach
            </select>

            <div id="dynamicFileDiv">

            </div>
        </div>

        <!-- activity -->
        <div class="tab-pane active" id="tabs-1" role="tabpanel">

            <div class="row">

                @forelse($lead['activities'] as $activity)
             
                <div class="col-lg-4 col-md-4">
                    <div class="card border">
                        <div class="card-body">
                            <div class="d-flex bd-highlight">
                                <div class="flex-fill bd-highlight">
                                    <h5 class="card-title {{ $activity->leadSetting->status_name=="Pitching"?'proposal':'' }}  {{ $activity->leadSetting->status_name=="Completed"?'inprogress':'' }}">{{ $activity->leadSetting->status_name }}</h5>
                                    <h6 class="card-subtitle proposal mb-2 mt-2">{{ $activity['activity'] }}</h6>
                                    <!--  -->
                                </div>
                                <div class=" flex-fill bd-highlight ">
                                    {{-- <i class="fa fa-file lead" aria-hidden="true"></i>
                                    <i class="fa fa-check lead"></i> --}}
                                    <input class="form-check-input float-right" type="checkbox" id="inlineCheckbox1" value="1" {{
                                        $activity['status']=='Completed' ? 'checked' : '' }}
                                        onclick="changeActivityStatus({{ $activity['id'] }})">
                                </div>
                            </div>
                            <div class="d-flex bd-highlight">
                                <div class="flex-fill bd-highlight mt-3">
                                    <a href="#" class="card-link ">
                                        <span class="input-group-text"
                                            style="background-color:transparent!important; border:none!important;padding:0px!important;"><i
                                                class="fa fa-calendar"
                                                style="background-color: #ddd;padding: 8px; border-radius: 50%;font-size:12px;"></i>
                                            <input placeholder="Select date" type="date" id="example_date"
                                                class="form-control"
                                                value="{{ $activity['deadline'] == null ? '' : $lead['created_at']->toDateString() }}"
                                                disabled></span>
                                    </a>
                                    <a href="#" class="card-link lead">Email</a>
                                </div>
                                <!-- <div class="flex-fill bd-highlight mt-3">
                                    <a href="#" class="card-link lead">Email</a>
                                </div> -->

                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-md-12">
                    <p>No Data Present !!</p>
                </div>
                @endforelse
                
                {{-- <div class="col-lg-4 col-md-4">
                    <div class="card border">
                        <div class="card-body">
                            <div class="d-flex bd-highlight">
                                <div class="flex-fill bd-highlight">
                                    <h5 class="card-title inprogress">In Progress</h5>
                                    <h6 class="card-subtitle proposal mb-2 mt-2">Prepare quote for Johny Doe</h6>


                                    <!--  -->


                                </div>
                                <div class=" flex-fill bd-highlight">
                                    <i class="fa fa-file lead" aria-hidden="true"></i>

                                    <i class="fa fa-check lead"
                                        style="background-color: rgba(44, 129, 78, 1);color: white;"></i>
                                </div>

                            </div>
                            <div class="d-flex bd-highlight">
                                <div class="flex-fill bd-highlight mt-3">
                                    <a href="#" class="card-link ">
                                        <span class="input-group-text"
                                            style="background-color:transparent!important; border:none!important;padding:0px!important;"><i
                                                class="fa fa-calendar"
                                                style="background-color: #ddd;padding: 8px; border-radius: 50%;font-size:12px;"></i>
                                            <input placeholder="Select date" type="date" id="example_date"
                                                class="form-control"
                                                value="{{ $lead['created_at'] == null ? '' : $lead['created_at']->toDateString() }}"
                                                disabled></span>
                                    </a>
                                </div>
                                <div class="flex-fill bd-highlight mt-3">
                                    <a href="#" class="card-link lead"
                                        style="background-color:rgba(44, 129, 78, 1);">Call</a>
                                </div>

                            </div>



                        </div>
                    </div>
                </div> --}}


                {{-- @forelse($activities as $activity)
                <div class="col-md-4">
                    <div class="card mt-3">
                        <div class="card-body p-3" style="border: 1px solid #eaeaea;border-radius: 5px;">
                            <div class="d-flex bd-highlight">
                                <div class="p-2 w-100 bd-highlight">
                                    <h5 class="card-title">{{ $activity['activity'] }}</h5>
                                </div>
                                <div class="p-2 flex-shrink-1 bd-highlight">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" {{
                                        $activity['status']=='Completed' ? 'checked' : '' }}
                                        onclick="changeActivityStatus({{ $activity['id'] }})">
                                </div>
                            </div>



                            <i class="fa fa-building profile mt-3" aria-hidden="true"></i> <span class="p-2">{{
                                $activity['deadline'] }}</span>

                        </div>
                    </div>


                </div>
                @empty
                <div class="col-md-12">
                    <p>No Data Present !!</p>
                </div>
                @endforelse --}}
            </div>
            <form action="{{ route('lead_activity.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-9">
                        <textarea class="form-control form-control-sm mb-3 p-5 m-3" name="activity" rows="3"
                            placeholder="Textarea" style="background-color:#FCFBFB;"></textarea>
                    </div>


                    <div class="col-3 d-flex flex-column">
                        <label>Deadline</label>
                        <input type="datetime-local" class="form-control mt-1" name="deadline">
                        <!-- <div class="p-3">
                            <input type="datetime-local" class="form-control" name="deadline">
                        </div>-->
                        <div class="mt-1">
                            <select name="activity_type_id" class="form-control" style="height:36px!important;">
                                @foreach($activity_types as $type)
                                <option value="{{ $type['id'] }}">
                                    {{ $type['type_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text" name="lead_id" id="activityLeadId" value="{{ $lead->id }}" hidden>
                        <input type="text" name="status_id" id="activityStatusId" value="{{ $lead->status_id }}" hidden>
                        <div class="py-3">
                            <button class="btn btn-primary activity" type="submit" style="font-size:13px;">Create
                                Activity</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane" id="tabs-3" role="tabpanel">
            <p>Third Panel</p>
        </div>

        <div class="tab-pane" id="tabs-4" role="tabpanel">
            <div class="bg-bggcolor mb-3 " id="lead_all_note_data">
                @foreach ($notes as $note)

                <div class="d-flex justify-content-between p-3" style="border-bottom:1px solid #ddd;">@if($note->is_important==1)
                    <i class="fa fa-star-half-o" aria-hidden="true"> @endif<span class="lead-note ml-3">{{ $note->notes
                            }} </span></i>

                    <span class="input-group-text"
                        style="background-color:transparent!important; border:none!important;padding:0px!important;"><i
                            class="fa fa-calendar" style="background-color: #ddd;
                
                    border-radius: 50%;"></i>
                        <!-- <label>Uploaded</label> -->
                        <input placeholder="Select date" type="date" id="example_date" class="form-control"
                            value="{{ $note['created_at'] == null ? '' : $note['created_at']->toDateString() }}"
                            disabled></span>
                </div>
                @endforeach

            </div>

            <div class="create_note  p-2">
                <h5>Create new note</h5>
                <form id="note_lead_form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="lead_id" value="{{ $lead->id }}" id="note_lead_id">
                        <div class="col-md-12">

                           
                            <textarea name="notes" id="note_notes" rows="3" class="form-control mt-3" placeholder="Note"></textarea>

                        </div>
                        <div class="col-md-12">
                            <label>Is Important ?</label>
                            <input type="checkbox" id="note_is_important" name="is_important" class="p-3 m-5"
                                style="height:20px;width:20px;">

                        </div>
                        <div class="col-md-3">
                            <a onclick="NoteValidation()" class="btn btn-primary mt-3 pl-3 pr-3" style="color:white;">Save</a>
                        </div>

                    </div>

                </form>
            </div>

        </div>

        <div class="tab-pane" id="tabs-5" role="tabpanel">
            @forelse($status_histories as $history)
            @if($history->from == null)
            <li>Status changed to {{ $history->to->status_name }} <button
                    style="background-color: {{ $history->to->favcolor }}" disabled></button> by
                {{ $history->creator->name }} on
                {{ $history['created_at']->format('d-m-y') }}</li>
            @else
            <li>Status changed from <button style="background-color: {{ $history->from->favcolor }}" disabled> </button>
                {{ $history->from->status_name }} to <button style="background-color: {{ $history->to->favcolor }}"
                    disabled></button>
                {{ $history->to->status_name }} by {{ $history->creator->name }} on
                {{ $history['created_at']->format('d-m-y') }}</li>
            @endif
            @empty

            @endforelse
        </div>
    </div>








    <nav aria-label="Page navigation example mt-3">
        <ul class="pagination justify-content-center mt-3">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">

                  
                    <i class="fa fa-chevron-left" style="font-size:10px;"></i>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item "><a class="page-link active" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <i class="fa fa-chevron-right" style="font-size:10px;"></i>
                  
                    <span class="sr-only">Next</span>
                </a>
            </li>

        </ul>


    </nav>
    <div class="d-flex flex-row-reverse bd-highlight">

        <button type="button" class="btn btn-primary lead" data-toggle="modal" data-target="#myModal">
            <i class="fa fa-plus" aria-hidden="true"></i> Add Lead
        </button>
    </div>

</div>


{{-- <script src="{{asset('backend/js/custom.js')}}"></script> --}}
{{-- @include('{{asset('backend/js/customjs')}}') --}}
@include('backend/js/customjs')

<script>
    $(function () {
        $('.datepicker').datepicker({
            language: "es",
            autoclose: true,
            format: "dd/mm/yyyy"
        });
    });

    async function changeActivityStatus(activityId) {
        let formData = new FormData();

        let defaultStatus = 'Ongoing';
        if (event.target.checked == true) {
            defaultStatus = 'Completed';
        }

        formData.append('activity_id', activityId);
        formData.append('status', defaultStatus);
        let url = "{{ route('ajax.changeActivityStatus') }}";
        let requestOptions = {
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            method: "POST",
            body: formData
        };

        let response = await fetch(url, requestOptions);
        if (response.status == 200) {
            let data = await response.json();
            if (data.response == true) {
                Swal.fire({
                    title: data.message,
                    icon: 'success',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                })
            } else {
                Swal.fire({
                    title: data.message,
                    icon: 'error',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                })
            }

        }
    }

    function toggleFiles() {
        let idVal = event.target.value;
        getRespectiveFiles(idVal);
    }

    function NoteValidation(){
      let allField=$('#note_lead_form').find('input,textarea');
      let error=0;
      let check=0;
      $.each(allField, function (indexInArray, element) { 
            let name=element.name;
            let val=element.value;
            let type=element.type;
            $(element).removeClass('border border-danger');

            if(name=="notes"){
                if(val=="" || val==null || val==undefined){
                    $(element).addClass('border border-danger');
                    error++;
                }
            }
            if(name=="is_important"){
               if(this.checked){
                check++;
               }      
            }
      });
      if(error==0){
        let notes=$('#note_notes').val();
        let lead_id=$('#note_lead_id').val();
        let is_important=check;
        $.ajax({
            type: "post",
            url: "{{route('lead_note.store') }}",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            data: {
                notes:notes,
                lead_id:lead_id,
                is_important:is_important,
            },
            success: function (response) {
                if (response.status== true) {
                    debugger
                Swal.fire({
                    title: response.message,
                    icon: 'success',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                })
                $('#lead_all_note_data').html(response.view);
                $('#note_lead_form')[0].reset()
            } else {
                Swal.fire({
                    title: response.message,
                    icon: 'error',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                })
            }
            }
        });
      }
    }

</script>



@endsection