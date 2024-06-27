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



    #upload-area {
        width: 100%;
        height: auto;
        margin: auto;
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
    <!-- <ul id="breadcrumb">
            <li><a href="#"><span class="fa fa-home"></span> Company</a></li>
            <li><a href="#"><span class="fa fa-snowflake-o"> </span> Company Configurations</a></li>
        </ul> -->

    <div class="d-flex bd-highlight">
        <div class="p-2 flex-grow-1 bd-highlight">
            <h4 class="pageMainTitle mb-4">Company Profile</h4>
        </div>
        <div class="p-2 bd-highlight"><a href="{{ route('company.viewCompanies') }}"><button type="button"
                    class="btn btn-primary lead" data-toggle="modal" data-target="#staticBackdrop"style="float:right;">
                    <i class="fa fa-eye" aria-hidden="true" style="font-size:smaller;"></i> View
                </button></a></div>
        <div class="p-2 bd-highlight">
            <a href="{{ route('company.create') }}"><button type="button" class="btn btn-primary lead" data-toggle="modal"
                    data-target="#staticBackdrop"style="float:right;">
                    <i class="fa fa-plus" aria-hidden="true" style="font-size:smaller;"></i> Add
                </button></a>
        </div>
    </div>


    <div class="container-fluid card rounded bg-white mt-3 mb-3 customCard">
        {{-- <h5 class="card-title">Details</h5> --}}
        <form action="{{ route('company.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <h6>Photo/Logo</h6>
                    <div class="d-flex flex-column align-items-center">
                        <input type="text" name="id" value="{{ $company['id'] }}" hidden>
                        <label for="inputImage" id="inputLabel">Choose Logo</label>
                        <input type="file" id="inputImage" name="company-logo" onchange="changePicture()" />
                        <div id="preview-image">
                            <img src="{{ $company->hasMedia('company-logo') ? $company->getMedia('company-logo')[0]->getFullUrl() : '' }}"
                                id="imageDiv" class="img-fluid customImage" alt="">

                            <div id="placeholder">

                                <div id="upload-area" title="select a image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="profileNameBox">
                        <div><label class="labels">Name</label><input type="text" class="form-control"
                                placeholder="Company name" name="name" value="{{ $company['name'] }}"></div>
                        <div class=""><label class="labels">Email</label><input type="text" class="form-control"
                                placeholder="Company email" name="email" value="{{ $company['email'] }}"></div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div><label class="labels">Contact Number</label><input type="text" class="form-control"
                            placeholder="Contact Number" name="phone_number" value="{{ $company['phone_number'] }}"></div>
                </div>
                <div class="col-md-6">
                    <div><label class="labels">Address</label><input type="text" class="form-control"
                            placeholder="Address" name="address" value="{{ $company['address'] }}"></div>
                </div>
            </div>
            <div class="row mt-3">
                @if ($company['package_id'] == null)
                    <div class="col-md-6">
                        <div><label class="labels">Employees</label><input type="text" class="form-control"
                                placeholder="Total Employees" name="total_employees"
                                value="{{ $company['total_employees'] }}"></div>
                    </div>
                    <div class="col-md-6">
                        <div><label class="labels">Companies URL</label><input type="text" class="form-control"
                                placeholder="URL" name="website" value="{{ $company['website'] }}"></div>
                    </div>
                @else
                    <div class="col-md-6">
                        <div><label class="labels">Employees</label><input type="text" class="form-control"
                                placeholder="Total Employees" name="total_employees"
                                value="{{ $company['total_employees'] }}"></div>
                    </div>
                    <div class="col-md-6">
                        <div><label class="labels">Companies URL</label><input type="text" class="form-control"
                                placeholder="URL" name="website" value="{{ $company['website'] }}"></div>
                    </div>
                    <div class="col-md-6">
                        <div><label class="labels">Package</label><input type="text" class="form-control"
                                placeholder="URL" name="website" value="{{ $company['package_id'] }}"></div>
                    </div>
                @endif
            </div>
            <div class="row mt-4">
                <div class="col">
                    <button class="btn updateBtn">Update</button>
                </div>
            </div>
        </form>
    </div>

    <!-- <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h6 class="pageTitle mt-3">Packages</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card package mt-3">
                        <div class="card-body p-0">
                            <h4 class="card-title">500<span> /mo </span></h4>

                            <p class="card-text package">Ability to manually enter new leads into the CRM</p>
                            <a href="#"><button class="btn packageBtn mt-3">Buy</button></a>
                            <a href="#" class="card-link" style="float:right"><i class='fa fa-angle-double-right packageLnk'></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card packages mt-3">
                      
                        <div class="card-body p-0">
                            <div>
                                <div class="mostUsedDiv">Most used</div>
                                <div class="inverted-border-radius"></div>
                            </div>
                            <h4 class="card-title">10,000<span> /mo </span></h4>
                            <p class="card-text package" style="color:white">Ability to manually enter new leads into the CRM</p>
                            <a href="#"><button class="btn packageBtn mt-3">Buy</button></a>
                            <a href="#" class="card-link" style="float:right"><i class='fa fa-angle-double-right packageLnk' style="color:white;"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card package mt-3">
                        <div class="card-body p-0">
                            <h4 class="card-title">20,000<span> /mo </span></h4>

                            <p class="card-text package">Ability to manually enter new leads into the CRM</p>
                            <a href="#"><button class="btn packageBtn mt-3">Buy</button></a>
                            <a href="#" class="card-link" style="float:right"><i class='fa fa-angle-double-right packageLnk'></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->





    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h6 class="pageTitle mt-3">Packages</h6>
            </div>
        </div>

        <div class="row">
            @foreach ($packages as $key => $package)
                <div class="col-md-4">
                    <div class="card package mt-3">
                        <div class="card-body p-0">
                            <h4 class="card-title">{{ $package->price }} <span> /mo </span></h4>

                            <p class="card-text package">{{ $package->title }}</p>
                            <a href="#"><button class="btn packageBtn mt-3">Buy</button></a>
                            <a href="#" class="card-link" style="float:right"><i
                                    class='fa fa-angle-double-right packageLnk'></i></a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
<script>
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
