

@foreach ($contacts as $contact)
    <option value="{{ $contact['id'] }}">{{ $contact['name'] }}</option>
@endforeach
{{-- <script src="{{asset('backend/js/custom.js')}}"></script> --}}
{{-- @include('{{asset('backend/js/customjs')}}') --}}
@include('backend/js/customjs')
