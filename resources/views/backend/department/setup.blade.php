@extends('backend.layouts.app')
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

    #inputImage {
        display: none;
        color: black;
        background: none;
        cursor: pointer;
    }

    #preview-image {
        width: 100%;
        height: 200px;
        background: #eee;
        border-radius: 0 0 10px 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        columns: 600px 1;
        /* border: 1px solid black; */
    }

    #upload-area {
        width: 100%;
        height: auto;
        margin: auto;
    }

    #inputLabel {
        width: 100%;
        height: 50px;
        padding: 10px;
        background: #375893;
        /* position: relative; */
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border-radius: 5px 5px 0 0;
        font-weight: 200;
        text-transform: uppercase;
        color: white;
        letter-spacing: 1px;
        /* border: 1px solid black; */
    }

    #placeholder {
        display: flex;
        flex-direction: column;
        height: 200px;
        background: url("https://avatars.mds.yandex.net/i?id=ac9425f0536b1cc38165d187ca0db7fcfce1f2f6-9181395-images-thumbs&n=13");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        justify-content: center;
        align-items: center;
        border-radius: 0 0 10px 10px;
    }

    .customImage {
        /* width: 200px;
        height: 200px; */
        max-height: 100%;
        object-fit: contain border-radius: 0 0 10px 10px;
    }
</style>
@section('content')
    {{-- <ul id="breadcrumb">
    <li><a href="#"><span class="fa fa-home"></span> Company</a></li>
    <li><a href="#"><span class="fa fa-snowflake-o"> </span> Company Setup</a></li>
</ul> --}}

    <h4 class="pageMainTitle mb-4">Company Setup</h4>
    <div class="container-fluid card rounded bg-white mt-3 mb-3 customCard">
        {{-- <h5 class="card-title">Details</h5> --}}
        <form action="{{ route('company.storeAjax') }}" method="POST" id="companyCreateform" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <h6>Photo/Logo</h6>
                    <div class="d-flex flex-column align-items-center">
                        <label for="inputImage" id="inputLabel">Choose Logo</label>
                        <input type="file" id="inputImage" name="company-logo" onchange="changePicture()" />
                        <div id="preview-image">
                            <img src="https://th.bing.com/th/id/OIP.CeJW5zarN4QLM4eumohCPQAAAA?rs=1&pid=ImgDetMain" id="imageDiv" class="img-fluid customImage" alt="">

                            <div id="placeholder">

                                <div id="upload-area" title="select a image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="profileNameBox">
                        <div><label class="labels">Name<sup class="text-danger">*</sup></label><input type="text"
                                class="form-control" placeholder="Company name" name="name" id="name"></div>
                        <div class=""><label class="labels">Email<sup class="text-danger">*</sup></label><input
                                type="email" class="form-control" placeholder="Company email" name="email"
                                id="email"></div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div><label class="labels">Contact Number</label><input type="text" class="form-control"
                            placeholder="Contact Number" name="phone_number" id="phone_number"></div>
                </div>
                <div class="col-md-6">
                    <div><label class="labels">Address</label><input type="text" class="form-control"
                            placeholder="Address" name="address" id="address"></div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div><label class="labels">Employees<sup class="text-danger">*</sup></label><input type="number"
                            class="form-control" placeholder="Total Employees" name="total_employees" min="0"
                            id="total_employees">
                    </div>
                </div>
                <div class="col-md-6">
                    <div><label class="labels">Companies URL</label><input type="text" class="form-control"
                            placeholder="URL" name="website" id="website"></div>
                </div>
{{--                <div class="col-md-6">--}}
{{--                    <div>--}}
{{--                        <label class="labels">Package</label>--}}
{{--                        <select name="package_id" class="form-control">--}}
{{--                            @forelse ($packages as $package)--}}
{{--                                <option value="{{ $package['id'] }}">{{ $package['title'] }}</option>--}}
{{--                            @empty--}}
{{--                                <option>No data!</option>--}}
{{--                            @endforelse--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <p id="companyErr" class="text-danger">
                    <p id="emailErr" class="text-danger">
                    </p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <button class="btn updateBtn" type="button" onclick="companySetupSubmit()">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // import  {changePhoto}  from "..../public/js/portfolio.js";

        window.addEventListener('load', () => {
            let userForm = document.getElementById('userForm');
            userForm.style.display = 'none';
        });

        async function submitUser() {
            let form = document.getElementById('userForm');
            let formData = new FormData(form);
            let url = "{{ route('ajax.storeUser') }}";
            let requestOptions = {
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                method: "POST",
                body: formData
            };
            let response = await fetch(url, requestOptions);
            if (response.status == 200) {
                let data = await response.json();
                if (data.response == true) {
                    Swal.fire(
                        'Success', data.message, 'success'
                    );
                    window.location.href = data.url;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                        footer: '<a href="">Why do I have this issue?</a>'
                    });
                }
            }
            debugger;
        }

        function changePhoto() {
            let imagePreviewDiv = document.getElementById('imagePreview');
            if (event.target.files.length > 0) {
                let file = event.target.files[0];
                let reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function() {
                    imagePreviewDiv.src = reader.result;
                };
            } else {
                imagePreviewDiv.src =
                    'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg';
            }
        }

        function updateProfile() {
            let form = document.getElementById('profileForm');
            let entries = [document.getElementById('name'), document.getElementById('email')];
            let validationRes = validateProfile(entries);
            if (validationRes == true) {
                form.submit();
            }
        }

        function validateProfile(entries) {
            let errCount = 0;
            entries.forEach(element => {
                if (element.value == '') {
                    errCount++
                    element.style.border = '1px solid red';
                } else {
                    element.style.border = '1px solid #cccccc';
                }
            });

            if (errCount > 0) {
                document.getElementById('errDiv').innerText = 'Please fill the highlighted fields';
                return false;
            } else {
                document.getElementById('errDiv').innerText = '';
                return true;
            }
        }

        async function submitCompany() {
            let form = document.getElementById('companyForm');
            let formData = new FormData(form);

            let url = "{{ route('company.storeAjax') }}";
            let responseOptions = {
                method: 'POST',
                body: formData,
                headers: {
                    "X-CSRF-Token": "{{ csrf_token() }}"
                }
            };

            try {
                let response = await fetch(url, responseOptions);
                if (response.status == 200) {
                    let data = await response.json();
                    let userForm = document.getElementById('userForm');
                    let companyForm = document.getElementById('companyForm');
                    if (data.response == true) {
                        Swal.fire(
                            'Success', data.message, 'success'
                        );
                        userForm.style.display = 'block';
                        companyForm.style.display = 'none';
                        document.getElementById('userCompanyId').value = data.company_id;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            footer: '<a href="">Why do I have this issue?</a>'
                        });
                        userForm.style.display = 'none';
                        companyForm.style.display = 'block';

                    }
                }
            } catch (error) {
                debugger;
            }
        }

        function changePicture() {
            const inputImage = document.getElementById("inputImage");
            const previewArea = document.getElementById("preview-image");
            const placeholder = document.getElementById("placeholder");
            const imageDiv = document.getElementById('imageDiv');
            debugger;
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function() {
                // const img = document.createElement("img");
                imageDiv.src = reader.result;
                imageDiv.classList.add("img");
                placeholder.style.display = "none";
                // previewArea.append(img);
            };
        }
    </script>
@endsection
