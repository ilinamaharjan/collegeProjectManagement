@forelse ($files as $file)
<div class="d-flex bd-highlight mb-3">
    <div class="mr-auto p-2 bd-highlight">
        <h6 class="profile-sec">{{ $file['remarks'] }}</h6>
    </div>
    <div class="p-2 bd-highlight">
        <select name="" class="form-control" onchange="linkActivity('{{$file['id']}}')">
            @forelse ($lead_activities as $l_a)
                <option value="{{ $l_a['id'] }}" >{{ $l_a['activity'] }}</option>
            @empty
                <option value="" disabled selected>No activities</option>
            @endforelse
        </select>
        <i class="fa fa-trash profile" aria-hidden="true"></i>
        <a href="{{ route('lead_file.download',$file['id']) }}"><i class="fa fa-arrow-down profile" aria-hidden="true"> </i></a>
    </div>
    <div class="p-2 bd-highlight">
        <div class="p-2">Uploaded <span class="p-2"> <b> {{$file['created_at']}} </b></span></div>
    </div>
</div>

<hr>
@empty
    <p>No files present here</p>
@endforelse
<br>
<div class="p-3">
    <form action="" method="POST" enctype="multipart/form-data" id="leadFileForm">
        @csrf
        <input type="text" name="lead_id" value="{{ $lead_id }}" class="form-control" hidden>
        <input type="text" name="field_type_id" value="{{ $file_type['id'] }}" class="form-control" hidden>
        <div class="row">
            <div class="col-md-12">
                <textarea name="remarks" class="form-control" cols="30" rows="10"></textarea>
            </div>
            <div class="col-md-6 mt-2">
                <div class="form-group">
                    <input type="file" name="files[]" class="form-control" {{$file_type['has_multiple'] == 1 ? 'multiple' : ''}}>
                </div>
                
            </div>
            <div class="col-md-6 mt-2">
                <div class="form-group">
                    <button type="button" onclick="submitLeadFile('{{ route('lead_file.store') }}')" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
{{-- <script src="{{asset('backend/js/custom.js')}}"></script> --}}
{{-- @include('{{asset('backend/js/customjs')}}') --}}
@include('backend/js/customjs')

