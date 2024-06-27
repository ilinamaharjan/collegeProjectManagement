@foreach($roles as $key=>$role)
<tr>
    <td> {{$key+1}}</td>
    <td> {{$role->name}}</td>
    <td>
        @can('View|Role')
        <a onclick="loadModal('{{route('role.viewPermissionOfRole',$role['id'])}}')" class="actionBtnHolder" data-toggle="modal" data-target="#commonModal"> <i class="fa fa-eye customer"></i></a>
        @endcan
    </td>
    <td class="">
        @can('Update|Role')
            <a href="{{ route('role.edit',$role->id) }}" class="actionBtnHolder editColor"
                onclick="loadModal">
                <i class="fa fa-edit customer"></i>
            </a>
        @endcan
       
        @can('Delete|Role')
            @if ($role->name !='Admin' && $role->name !='Super Admin')
            
            {{-- <a href="" data-toggle="modal" data-target="#deleteModal{{$key}}">
                <i class="fa fa-trash customer" aria-hidden="true"></i>
            </a> --}}
            <a onclick="deleteConfirmationFunction('{{ $role['id']}}','{{ route('role.delete', $role['id'])}}','role')">  <i class="fa fa-trash customer" aria-hidden="true"></i></a>
            @endif
        @endcan
    </td>

</tr>
{{-- delete modal start --}}
{{-- <div class="modal fade text-dark" id="deleteModal{{$key}}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete
                    Role {{ $role->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-1">
                <p>Are you sure want to delete this role?</p>

            </div>
            <div class="modal-footer">
                <a href="{{ route('role.delete', $role->id) }}" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div> --}}
{{-- delete modal end --}}
@endforeach