@extends('backend.layouts.app')
@section('content')
<div class="row">
    @can('Create|User Management')
    <div class="col-md-12">
        @if (count($users)<$no_of_users || auth()->user()->hasRole('Super Admin'))

            <button type="button" class="btn btn-primary lead" style="float:right"><a style="text-decoration: :none;"
                    href="{{  route('user_management.create')  }}">

                    <i class="fa fa-plus" aria-hidden="true" style="font-size:smaller;"></i>Add User
                </a>
            </button>
            @else
            @if (!auth()->user()->hasRole('Super Admin'))
            <div class="alert alert-danger" role="alert">
                You can not create more then {{ $no_of_users }} users. If want more users in your system then contact
                with
                us!
            </div>
            @endif
        @endif
    </div>
     @endcan

            <table class="table table-table table-light">
                <thead>
                    <th>S.no</th>
                    <th>User</th>
                    @if (auth()->user()->hasRole('Super Admin'))
                    <th>Company</th>
                    @endif
                    <th>Permission</th>
                    <th>User Status</th>

                    <th>Action</th>

                </thead>
                <tbody id="userTableData">
                </tbody>
            </table>
    </div>
    <script>
        window.addEventListener('load',function(){
        getRoleAllData();
    })
    function getRoleAllData(){
        $.ajax({
            type: "get",
            url: "{{ route('user_management.getAllUsers') }}",
            success: function (res) {
               if(res.response==true){
                    $('#userTableData').html(res.users);
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
     function changePhoto(id) {
        let imagePreviewDiv = document.getElementById('imagePreviewEditUser'+id);
        if (event.target.files.length > 0) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function() {
                imagePreviewDiv.src = reader.result;
            };
        } else {
            imagePreviewDiv.src = 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg';
        }
    }

    // validation user edit form 
    function validationUserEditBlade(id){
        allField=$('#profileFormEdit'+id).find('input');
        let userEditErr=0;
        let validaExtension=['jpg','jpeg','png'];
        $.each(allField, function (indexInArray, element) { 
            let name=element.name;
            let type=element.type;
            let val=element.value;

            $(element).removeClass('border border-danger');
            let nextEl=$(element).next();
            if($(nextEl).prop('tagName')=="SPAN"){
                $(nextEl).remove();
            }
            if(!name.includes('_token') && !name.includes('user_id')){
                if(type=="text" && (val=="" || val==null || val==undefined)){
                    userEditErr++;
                    $(element).addClass('border border-danger');
                } else {
                    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                    if (name == "email" && !(val.match(validRegex))) {
                        $('<span class="text-danger">Email is invalid</span>').insertAfter($(element));
                        $(element).addClass('border border-danger rounded');
                        userEditErr++;
                    }
                    if(name=="office_number" || name=="personal_number"){
                       
                        if(isNaN(val) || val.length<=9){
                            userEditErr++;
                            $('<span class="text-danger">Number is invalid</span>').insertAfter($(element));
                            $(element).addClass('border border-danger rounded');
                        }
                    }

                }
                if(type=="file" && name=="photo"){
                    if(element.files.length>0){
                        let file=element.files[0];
                        let file_ext=file.name.split('.').pop().toLowerCase();
                        let file_size=file.size;
                        if(file_size>4*1024*1024 || (!validaExtension.includes(file_ext))){
                            userEditErr++;
                            $(`<small class="text-danger">Image not valid!</small> <br>`).insertAfter($(element));
                        }
                    }
                }
            }
        });
        if(userEditErr==0){
            $('#profileFormEdit'+id).submit();
        }
    }

   
   
    </script>
    @endsection