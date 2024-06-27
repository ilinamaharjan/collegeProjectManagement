@forelse ($organizations as $organization)
    <option value="{{ $organization['id'] }}" onclick="setValueDropdown('{{$organization['id']}}','{{$organization['name']}}')">{{ $organization['name'] }}</option>
@empty
    <option value="">No data</option>
@endforelse
{{-- <script src="{{asset('backend/js/custom.js')}}"></script> --}}
@include('backend/js/customjs')