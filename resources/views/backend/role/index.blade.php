@extends('backend.layouts.app')

@section('content')
<style>
   .btnactiveClass{
    background-color: #f6b619 !important;
    border-color: #f6b619 !important;
    color: white !important;
    font-size: 13px;
    font-weight: 600;
   }
</style>
{{-- <div class="row">

    <ul class="nav nav-tabs nav-fill" role="tablist">
        <li class="nav-item">
            <a class="nav-link role" data-toggle="tab" href="#duck" role="tab" aria-controls="duck"
                aria-selected="true"><button   onclick="addColor()" type="button" class="btn btn-primary lead role_and_user"><i class="fa fa-exchange"
                        aria-hidden="true"></i> Role</button></a>
        </li>
        <li class="nav-item active ">
            <a  class="nav-link role " data-toggle="tab" href="#chicken" role="tab" aria-controls="chicken"
                aria-selected="false"><button  onclick="addColor()" type="button" class="btn btn-primary lead btnactiveClass role_and_user"><i class="fa fa-exchange"
                        aria-hidden="true"></i> User Role</button></a>
        </li>

    </ul>
</div> --}}

<div class="tab-content">

    <div class="tab-pane active" id="duck" role="tabpanel" aria-labelledby="duck-tab">

        <!-- role -->

        <!-- Button trigger modal -->
        @can('Create|Role')
            
        <button type="button" class="btn btn-primary lead"
            style="float:right;">
            <i class="fa fa-plus" aria-hidden="true" style="font-size:smaller;"></i> <a style="text-decoration: none;" href="{{route('role.create')}}">Add Role</a>
        </button>
        @endcan
        {{-- <button type="button" class="btn btn-primary lead" data-toggle="modal" data-target="#exampleModal"
            style="float:right;">
            <i class="fa fa-plus" aria-hidden="true" style="font-size:smaller;"></i> <a style="text-decoration: none;" href="{{route('role.create')}}">Add Role</a>
        </button> --}}

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Role Setup</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form action="#" method="POST" id="Form" class="mt-3 mb-1">

                            <div id="formSection">

                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <label>Title</label>
                                        <div>
                                            <input type="text" class="form-control" name="unique_name" value=""
                                                placeholder="Enter status name">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Permission</label>
                                        <div>
                                            <div class="form-group">
                                                <select class="form-control">
                                                    <option value="" selected disabled>Choose Below</option>
                                                    <option value="createContact">Create New</option>
                                                    <option value="">name</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary convert mt-3" id="submitBtn"
                                onclick="submitForm()">Submit</button>

                        </form>

                    </div>

                </div>
            </div>
        </div>
        <!--  -->

        <table class="table table-table table-light">
            <thead>
                <th>S.no</th>
                <th>Title</th>
                <th>Permission</th>

                <th>Action</th>

            </thead>
            <tbody id="roleTableData">
                {{-- @foreach($roles as $key=>$role)
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
                            </a> 
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
                {{-- delete modal end
                @endforeach --}}

            </tbody>
        </table>
    </div>



    <!-- role -->


    {{-- <div class="tab-pane active" id="chicken" role="tabpanel" aria-labelledby="chicken-tab">

        <!--  -->

        <!-- <button type="button" class="btn btn-primary lead" data-toggle="modal" data-target="#staticBackdrop"
            style="float:right">
            <i class="fa fa-plus" aria-hidden="true" style="font-size:smaller;"></i>Add User Role
        </button> -->

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">User Role Setup</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form action="#" method="POST" id="Form" class="mt-1 mb-1">

                            <div id="formSection">



                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label">Permission</label>

                                        <select class="form-control">
                                            <option value="" selected disabled>Choose Below</option>
                                            <option value="createContact">Create New</option>
                                            <option value="">name</option>

                                        </select>
                                    </div>




                                </div>
                            </div>

                            <button type="button" class="btn btn-primary convert mt-3" id="submitBtn"
                                onclick="submitForm()">Submit</button>

                        </form>

                    </div>

                </div>
            </div>
        </div>

        <table class="table table-table table-light">
            <thead>
                <th>S.no</th>
                <th>User</th>
                <th>Permission</th>

                <th>Action</th>

            </thead>
            <tbody id="userListTable">
            </tbody>
        </table>
    </div> --}}

</div>

<script>
    window.addEventListener('load',function(){
        getRoleAllData();
    })
    function getRoleAllData(){
        $.ajax({
            type: "get",
            url: "{{ route('role.getAllRoles') }}",
            success: function (res) {
               if(res.response==true){
                    $('#roleTableData').html(res.roles);
                    $('#userListTable').html(res.users);
               }else{
                Swal.fire({
                    title: res.message,
                    icon: 'error',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                });
               }     
            }
        });
    }

    function addColor(){
        let element=event.target;
        $('.role_and_user').removeClass('btnactiveClass');
        $(element).toggleClass('btnactiveClass');
    }
</script>
@endsection