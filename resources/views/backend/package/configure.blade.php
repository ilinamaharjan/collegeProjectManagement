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
</style>
@section('content')
    <!-- <ul id="breadcrumb">
                                    <li><a href="#"><span class="fa fa-home"></span> Package</a></li>
                                    <li><a href="#"><span class="fa fa-snowflake-o"> </span> Package Configurations</a></li>
                                </ul> -->



    <div class="d-flex bd-highlight mb-3">
        <div class="align-self-center mt-3">
            <h5 class="pageMainTitle">Package Setup</h5>
        </div>
        <div class="mr-auto p-2 bd-highlight">

        </div>
        <div class=" p-2 bd-highlight">
            <a href="{{ route('package.viewpackage') }}">
                <button type="button" class="btn btn-primary lead" data-toggle="modal" data-target="#staticBackdrop"
                    style="float:right;">
                    <i class="fa fa-eye" aria-hidden="true" style="font-size:smaller;"></i> View
                </button>
            </a>
        </div>
        {{-- <div class="p-2 bd-highlight"> 
        <button type="button" class="btn btn-primary convert">Download 
            <i class="fa fa-arrow-down" aria-hidden="true"></i>
        </button>
    </div> --}}
    </div>




    <div class="container-fluid card rounded bg-white mt-5 mb-3">
        <form action="{{ route('package.store') }}" method="POST" id="packageForm">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="p-3">
                        <label for="title">Title<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="title" name="title" value="" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3">
                        <label for="no_of_users">No. of users<sup class="text-danger">*</sup></label>
                        <input type="number" min="0" class="form-control" id="no_of_users" name="no_of_users"
                            value="" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3">
                        <label for="price_per_user">Price per User</label>
                        <input type="number" min="0" class="form-control" id="price_per_user"
                            onchange="setPackagePrice()" name="price_per_user" value="" />
                        <p class="text-danger" id="ppuErr"></p>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="p-3">
                        <label for="price">Price<sup class="text-danger">*</sup></label>
                        <input type="number" min="0" class="form-control" id="price" name="price"
                            value="" />
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="p-3">
                        <label for="subscription_mode" id="subscription_mode">Subscription<sup
                                class="text-danger">*</sup></label>
                        <select name="subscription_mode" class="form-control">
                            <option value="Weekly">Weekly</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Yearly">Yearly</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 py-2">
                        <label for="modules">Modules<sup class="text-danger">*</sup></label>
                        <select name="modules[]" class="form-control" id="modules" size="4" multiple>
                            @forelse($modules as $module)
                                <option value="{{ $module['id'] }}">
                                    {{ $module['display_name'] }}</option>
                            @empty
                                <option value="">No data</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 py-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="" onclick="checkSpecific()"
                                id="specificBox">
                            <label class="form-check-label" for="myCheckbox">
                                Is this package specific?
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" id="companyDiv">
                    <div class="p-3 py-2">
                        <label for="company">Companies</label>
                        <select name="company_id[]" class="form-control" size="5" multiple>
                            @forelse ($companies as $item)
                                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @empty
                                <option disabled>Please first make one company, no data present now </option>
                            @endforelse
                        </select>
                    </div>
                </div>
            </div>
            <div>
                <p class="text-danger" id="errDiv"></p>
            </div>
            <button type="button" onclick="submitPackage()" class="btn updateBtn mb-5 mt-5">Save</button>
            <!-- <button class="btn btn-long btn-primary mb-3 rounded">Save</button> -->
        </form>



    </div>



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
            <!-- <div class="col-md-4">
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
                                        </div> -->
        </div>
    </div>
@endsection
<script>
    window.onload = function() {
        let companyDiv = document.getElementById('companyDiv');
        companyDiv.style.display = 'none';
    };

    function checkSpecific() {
        let companyDiv = document.getElementById('companyDiv');
        if (event.target.checked) {
            companyDiv.style.display = 'block';
        } else {
            companyDiv.style.display = 'none';
        }
    }

    function setPackagePrice() {
        let noOfUsers = document.getElementById('no_of_users');
        let errorTag = document.getElementById('ppuErr');
        if (noOfUsers.value == '') {
            errorTag.innerText = 'Fill the number of users first for calculation of price';
            event.target.value = '';
        } else {
            let priceField = document.getElementById('price');
            let price = parseInt(noOfUsers.value) * parseInt(event.target.value);
            priceField.value = price;
            errorTag.innerText = '';
        }
    }

    function submitPackage() {
        let form = document.getElementById('packageForm');
        let title = document.getElementById('title');
        let modules = document.getElementById('modules');
        let no_of_users = document.getElementById('no_of_users');
        let price = document.getElementById('price');
        let errDiv = document.getElementById('errDiv');

        let entries = [title, no_of_users, price, modules];
        let validRes = validatePackage(entries);
        if (validRes == false) {
            errDiv.innerText = 'Please fill the highlighted fields';
        } else {
            errDiv.innerText = '';
            form.submit();
        }
    }

    function validatePackage(entries) {
        let errCount = 0;
        entries.forEach(element => {
            let elName = element.getAttribute('name');
            if (elName == 'modules[]') {
                if (element.selectedOptions.length == 0) {
                    errCount++;
                    element.style.border = '1px solid red';
                } else {
                    element.style.border = '1px solid #cccccc';
                }
            } else {
                if (element.value == '') {
                    errCount++;
                    element.style.border = '1px solid red';
                } else {
                    element.style.border = '1px solid #cccccc';
                }
            }
        });

        if (errCount > 0) {
            return false;
        } else {
            return true;
        }
    }
</script>
