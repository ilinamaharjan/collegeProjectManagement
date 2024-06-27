@forelse ($organizations as $organization)
    <option value="{{ $organization['id'] }}" onclick="setContactDropdown()">{{ $organization['name'] }}</option>
@empty
    <option value="">No data</option>
@endforelse
{{-- <script src="{{asset('backend/js/custom.js')}}"></script> --}}
{{-- @include('{{asset('backend/js/customjs')}}') --}}
@include('backend/js/customjs')
