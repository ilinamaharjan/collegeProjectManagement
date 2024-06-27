@forelse ($contacts as $key => $contact)
<tr>
    <td>{{ $key + 1 }}</td>
    <td>{{ $contact['name'] }}</td>
    @php
        $emailArr = explode(',', $contact['email']);
        $phoneArr = explode(',', $contact['phone']);
    @endphp
    <td>{{ $emailArr[0] }}</td>
    <td>{{ $contact->organization->name ?? '-' }}</td>
    <td>{{ $phoneArr[0] }}</td>
    <td>
        <a class="actionBtnHolder" data-toggle="modal" data-target="#commonModal"
        onclick="loadModal('{{ route('organization.addContactOrganization', $contact['id']) }}')"
        class="btn btn-primary">
            <i class="fa fa-user customer" aria-hidden="true"></i>
        </a>
       
        <a href="" class="actionBtnHolder" data-toggle="modal" data-target="#commonModal"
            onclick="loadModal('{{ route('organization.updateModal', $contact['id']) }}')"
            class="btn btn-primary">
            <i class="fa fa-edit customer"></i>
        </a>
        {{-- <i class="fa fa-trash customer" aria-hidden="true" data-toggle="modal"
            data-target="#deleteModalOrganization{{ $key }}"></i> --}}
            <a onclick="deleteConfirmationFunction('{{ $contact['id']}}','{{ route('organization.delete', $contact['id'])}}','contact book')">
                <i class="fa fa-trash customer" aria-hidden="true" ></i>
            </a>
      
        <a href="{{ route('organization.review', $contact['id']) }}" class="actionBtnHolder">
            <i class="fa fa-eye customer"></i>
        </a>

    </td>
</tr>
{{-- delete modal start --}}
{{-- <div class="modal fade text-dark" id="deleteModalOrganization{{ $key }}" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete
                    Contact Book</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-1">
                <p>Are you sure want to delete this contact?</p>

            </div>
            <div class="modal-footer">
                <a href="{{ route('organization.delete', $contact->id) }}"
                    class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div> --}}
{{-- delete modal end --}}
@empty
<tr>
    <td colspan="6" class="text-center">
        No data present
    </td>
</tr>
@endforelse