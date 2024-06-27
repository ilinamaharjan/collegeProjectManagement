@extends('backend.layouts.app')

@section('content')
<style>
    #breadcrumb {
        list-style: none;
        display: inline-block;
    }

    #breadcrumb .fa {
        font-size: 14px;
    }

    #breadcrumb li {
        float: left;
    }

    #breadcrumb li a {
        color: #FFF;
        display: block;
        background: #375893;
        text-decoration: none;
        position: relative;
        height: 40px;
        line-height: 40px;
        padding: 0 10px 0 5px;
        text-align: center;
        margin-right: 23px;
        margin-top: 10px
    }

    #breadcrumb li:nth-child(even) a {
        background-color: #375893;
    }

    #breadcrumb li:nth-child(even) a:before {
        border-color: #375893;
        border-left-color: transparent;
    }

    #breadcrumb li:nth-child(even) a:after {
        border-left-color: #375893;
    }

    #breadcrumb li:first-child a {
        padding-left: 15px;
        -moz-border-radius: 4px 0 0 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px 0 0 4px;
    }

    #breadcrumb li:first-child a:before {
        border: none;
    }

    #breadcrumb li:last-child a {
        padding-right: 15px;
        -moz-border-radius: 0 4px 4px 0;
        -webkit-border-radius: 0;
        border-radius: 0 4px 4px 0;
    }

    #breadcrumb li:last-child a:after {
        border: none;
    }

    #breadcrumb li a:before,
    #breadcrumb li a:after {
        content: "";
        position: absolute;
        top: 0;
        border: 0 solid #375893;
        border-width: 20px 10px;
        width: 0;
        height: 0;
    }

    #breadcrumb li a:before {
        left: -20px;
        border-left-color: transparent;
    }

    #breadcrumb li a:after {
        left: 100%;
        border-color: transparent;
        border-left-color: #375893;
    }

    .card .card-header h5:after {
        content: "";
        background-color: #cdb840 !important;
        position: absolute;
        left: -20px;
        top: 0;
        width: 4px;
        height: 20px;
    }
    .input-append{
        display: inline-block;
        width: 90%;
    }
</style>
    @if ($errors->any())
        <div class="notification is-danger is-light border border-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="d-flex bd-highlight mb-3">
        <div class="align-self-center mt-3">
            <h5 class=" pageMainTitle mb-3">Contact Book Details</h5>
        </div>
        <div class="mr-auto p-2 bd-highlight">

        </div>
        <div class="sample px-1   text-center">
            <form action="{{ route('contact.downloadContactExcel')  }}" method="GET">
                <button type="submit" class="btn btn-primary lead mt-3 mb-3">Download FIle Sample</button>
            </form>
        </div>
        <div class=" p-2 bd-highlight"></div>
        <form action="{{ route('contact.uploadContactExcel') }}" method="POST" id="excelform"
            enctype="multipart/form-data">
            @csrf
            <div class="row mx-2" style=" align-items:center;">
                <div class="col-md-6">
                    <input type="file" name="files" id="imagefile" style="overflow: hidden">
                </div>
                <div class="col-md-6 ">
                    <div class="contactexcelbtn">
                        <button type="button" class="btn btn-primary lead mt-3 mb-3"
                            onclick="submitExcelFile()">Submit</button>
                    </div>
                </div>


            </div>
            <div class="row mx-2">
                <div class="col-md-6">
                    <p id="Excelfilevalidate" class="text-danger">
                    </p>
                </div>
            </div>
        </form>
    </div>
    @can('ViewAll|Contact Organization')
    <div class=" px-2 bd-highlight">
        <a onclick="ViewAllContact('{{ route('organization.indexAllView')  }}')" class="btn btn-primary lead">View All</a>
    </div>
    @endcan
    <div id="spinner" style="display: none;"><div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="p-2 bd-highlight">
        <button href="#" data-toggle="modal" data-target="#commonModal"
            onclick="loadModal('{{ route('organization.create') }}')" class="btn btn-primary lead mt-3 mb-3"
            style="float:right;">Add Contact Book</button>
    </div>
    </div>

    <table class="table table-table table-light">
        <thead class="text-dark">
            <th>S.no</th>
            <th>Name</th>
            <th>Email</th>
            <th>Organization </th>
            <th>Contact Number</th>
            <th>Action</th>
        </thead>
        <tbody id="contact_book_table_list">
            {{-- @forelse ($contacts as $key => $contact)
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
                       
                            <a onclick="deleteConfirmationFunction('{{ $contact['id']}}','{{ route('organization.delete', $contact['id'])}}','contact book')">
                                <i class="fa fa-trash customer" aria-hidden="true" ></i>
                            </a>
                      
                        <a href="{{ route('organization.review', $contact['id']) }}" class="actionBtnHolder">
                            <i class="fa fa-eye customer"></i>
                        </a>

                    </td>
                </tr>
              
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        No data present
                    </td>
                </tr>
            @endforelse --}}
        </tbody>
    </table>


    <nav class=" mt-5 mb-5" aria-label="Page navigation example">
        <ul class="pagination justify-content-center mt-3">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">

                
                    <i class="fa fa-chevron-left" style="font-size:10px;"></i>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item active"><a class="page-link " href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <i class="fa fa-chevron-right" style="font-size:10px;"></i>
                 
                 
                    <span class="sr-only">Next</span>
                </a>
            </li>

        </ul>


</nav>
{{-- </div> --}}
<script>
     window.addEventListener('load',function(){
        getRoleAllData();
    })
    function getRoleAllData(){
        $.ajax({
            type: "get",
            url: "{{ route('organization.getAllContact') }}",
            success: function (res) {
               if(res.response==true){
                    $('#contact_book_table_list').html(res.view);
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
    function ViewAllContact(route){
        $('#spinner').show();
        $.ajax({
            type: "get",
            url: route,
            success: function (res) {
                $('#spinner').hide();
               if(res.response==true){
                
                                
                    $('#contact_book_table_list').html(res.view);
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
    function changePictureContact(InputImg,previewImg,placeholder,ImgDiv){
        let inputImageNew = document.getElementById(InputImg);
        let previewAreaNew = document.getElementById(previewImg);
        let placeholderNew = document.getElementById(placeholder);
        let imageDivNew = document.getElementById(ImgDiv);
        let file = event.target.files[0];
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function() {
        
            imageDivNew.src = reader.result;
            imageDivNew.classList.add("img");
            placeholder.style.display = "none";
           
        };
    }

    
    
    function formValidateNow(key) {
            let contactForm = document.getElementById('contact_form' + key);
            let name = document.getElementById('contactPersonName'+key);
            let email = Array.from(document.getElementsByClassName('contact_email' + key));
            let number = Array.from(document.getElementsByClassName('contact_person_number' + key));

            let organization_id = document.getElementById('organization_id' + key);

            let entries = [name, ...email, ...number];

            let validationRes = validateContact(entries);

            // if (validationRes == true) {
            //     contactForm.submit();
            //     document.getElementById('contactErr' + key).innerText = ``;
            // } else {

            //     document.getElementById('contactErr' + key).innerText = `Please fill the highlighted fields`;
            // }


            document.getElementById('contactError' + key).innerText = ``;
            document.getElementById('contactError' + key).innerText = ``;

            if (validationRes == true) {

                contactForm.submit();
                document.getElementById('contactError' + key).innerText = ``;
                document.getElementById('emailError' + key).innerText = ``;

            } else if (validationRes == "email") {

                document.getElementById('emailError' + key).innerText =
                    `Please enter valid email.`;
                document.getElementById('contactError' + key).innerText = ``;

            } else if (validationRes == "both") {

                document.getElementById('contactError' + key).innerText = `Please fill the highlighted fields`;
                document.getElementById('emailError' + key).innerText =
                    `Please enter valid email.`;

            } else {
                document.getElementById('contactError' + key).innerText = `Please fill the highlighted fields`;
                document.getElementById('emailError' + key).innerText = ``;
            }
        }

        function submitOrgForm(key) {
                       let organizationForm = document.getElementById('organization_form' + key);

            let name = document.getElementById('contactPersonName' + key);
            let email = Array.from(document.getElementsByClassName('contact_email' + key));
            let number = Array.from(document.getElementsByClassName('contact_person_number' + key));

            let org_name = document.getElementById('org_name' + key);
            let org_email = Array.from(document.getElementsByClassName('org_email' + key));
            let org_address = Array.from(document.getElementsByClassName('org_address' + key));
            let org_number = Array.from(document.getElementsByClassName('org_number' + key));

            let entries = [name, ...email, ...number, org_name, ...org_email, ...org_address, ...org_number];

            let validationRes = validateContact(entries);
           
            document.getElementById('orgErr' + key).innerText = ``;
            document.getElementById('emailErr' + key).innerText = ``;

            if (validationRes == true) {

                organizationForm.submit();
                document.getElementById('orgErr' + key).innerText = ``;
                document.getElementById('emailErr' + key).innerText = ``;

            } else if (validationRes == "email") {

                document.getElementById('emailErr' + key).innerText =
                    `Please enter valid email.`;
                document.getElementById('orgErr' + key).innerText = ``;

            } else if (validationRes == "both") {

                document.getElementById('orgErr' + key).innerText = `Please fill the highlighted fields`;
                document.getElementById('emailErr' + key).innerText =
                    `Please enter valid email.`;

            } else {
                document.getElementById('orgErr' + key).innerText = `Please fill the highlighted fields`;
                document.getElementById('emailErr' + key).innerText = ``;
            }
        }

        function changePhoto(idName) {
       
        let imagePreviewDiv = document.getElementById(idName);
        if (event.target.files.length > 0) {
            try {
                let file = event.target.files[0];
                let reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function() {
                    imagePreviewDiv.src = reader.result;
                };
            } catch (error) {
                console.log(error);
            }
        } else {
            imagePreviewDiv.src =
                'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg';
        }
    }
        function validateContact(entries) {
           
            let errorCount = 0;
            let emailCount = 0;
            entries.forEach(element => {
                element.style.border = '1px solid #cacaca';
                               if (element.value == '' || element.value == null || element.value == undefined) {
                    errorCount++;
                    element.style.border = '1px solid red';
                } else {

                    let validRegex = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                    if (element.type == 'email') {
                        if (!element.value.match(validRegex)) {

                            emailCount++;
                            element.style.border = '1px solid red';

                        } else {

                            element.style.border = '1px solid #cacaca';
                        }
                    }
                }
            });

            if (errorCount > 0 && emailCount == 0) {
                return false;
            } else if (emailCount > 0 && errorCount == 0) {
                return "email";

            } else if (errorCount > 0 && emailCount > 0) {
                return "both";
            } else {
                return true;
            }
        }
    </script>
@endsection
