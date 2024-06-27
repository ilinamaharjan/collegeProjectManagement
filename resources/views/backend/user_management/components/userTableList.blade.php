@foreach($users as $key=>$user)
<tr>
    <td> {{$key+1}}</td>
    <td> {{$user->name}}</td>
    @if (auth()->user()->hasRole('Super Admin'))
    <td>{{ $user->company->name }}</td>
    @endif
<style>
    .permission_user{
        background-color: rgba(31, 179, 209, 0.94);
    padding: 6px;
    color: white;
    border-radius: 5px;
    }


    .toggle-switch {
        position: relative;
        width: 30px;
        height: 15px;
        cursor: pointer;
      }
      
      .toggle-input {
        display: none;
      }
      
      .toggle-label {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #ccc;
        border-radius: 8px; 
        transition: background-color 0.3s;
      }
      
      .toggle-input:checked + .toggle-label {
        background-color: #4CAF50;
      }
      
      .toggle-slider {
        position: absolute;
        top: 65%;
        left: 0;
        width: 15px; 
        height: 15px; 
        background-color: #fff;
        border-radius: 50%;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s;
      }
      
      .toggle-input:checked + .toggle-label + .toggle-slider {
        transform: translateX(15px); 
      }
    
</style>
    <td>
        @can('View|User Management')
       
        <a class="actionBtnHolder editColor" data-toggle="modal" data-target="#commonModal" 
        onclick="loadModal('{{ route('user_management.viewPermissionOfUser', $user['id']) }}')"
        class="btn btn-primary">
        <i class="fa fa-eye customer"></i>
        </a>
        @endcan
    </td>
    <td>
        {{-- <label class="switch">
            <input type="checkbox" class="success" {{ $user['status']==1 ?'checked':'' }} onchange="changeUserStatus({{ $user['id'] }})">
            <span class="slider"></span>
          </label> --}}

          
            <div class="toggle-switch" onclick="toggleSwitch({{ $user['id'] }})">
                <input type="checkbox" id="customSwitch{{ $user['id'] }}" class="toggle-input" {{ $user['status']==1 ?'checked':'' }} onchange="alert('dfd');changeUserStatus({{ $user['id'] }})">
                <label for="customSwitch" class="toggle-label"></label>
                <div class="toggle-slider"></div>
            </div>
    </td>
    <td class="">
        <a class="actionBtnHolder editColor" onclick="loadModal('{{ route('user_management.userInfoEdit',$user->id) }}')" data-toggle="modal" data-target="#commonModal" >
            <i class="fa fa-edit customer"></i>
        </a>
        @can('Update|User Management')

        <a href="{{ route('role.userEdit',$user->id) }}" class="actionBtnHolder">
            <i class="fa fa-lock permission_user"></i>
        </a>
        @endcan
        @can('Delete|User Management')
        
        <a onclick="deleteConfirmationFunction('{{ $user['id']}}','{{ route('user_management.delete', $user['id'])}}','user')" data-toggle="modal" data-target="#deleteModalUser{{$key}}">
            <i class="fa fa-trash customer" aria-hidden="true"></i>
        </a>

        @endcan
    </td>
    
</tr>
{{-- delete modal start --}}
{{-- <div class="modal fade text-dark" id="deleteModalUser{{$key}}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete
                    User {{ $user->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-1">
                <p>Are you sure want to delete this user?</p>

            </div>
            <div class="modal-footer">
                <a href="{{ route('user_management.delete', $user->id) }}"
                    class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div> --}}
{{-- delete modal end --}}
@endforeach