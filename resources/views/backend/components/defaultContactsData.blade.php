<option value="default" selected>Default</option>
<option value="createContact">Create New</option>
@foreach($contacts as $con)
    <option value="{{ $con->id }}">{{ $con->name }}</option>
@endforeach