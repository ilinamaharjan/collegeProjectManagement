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
        object-fit: contain
        border-radius: 0 0 10px 10px;
    }

</style>
@section('content')
<!-- <ul id="breadcrumb">
    <li><a href="#"><span class="fa fa-home"></span> Settings</a></li>
    <li><a href="#"><span class="fa fa-snowflake-o"> </span> Lead Status Settings</a></li>
</ul> -->

<div class="container-fluid card rounded bg-white mt-3 mb-3">
    <form action="{{ route('lead_setting.store') }}" method="POST" id="leadForm" class="mt-4 mb-4">
        @csrf
        <div id="formSection">
            @if ( $unique_name != null )
                <div class="row mb-2">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="unique_name" value="{{ $unique_name }}" hidden>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" class="form-control status_name" name="status_name[]" placeholder="Enter status name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="number" class="form-control heirarchy_order" name="heirarchy_order[]" onchange="handleOrder('heirarchy_order')" placeholder="Enter heirarchy order">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <button type="button" id="addBtn" onclick="addRows()" class="">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <p class="text-danger mt-2" id="pErr"></p>
        <p class="text-danger mt-2" id="rErr"></p>
        <button type="button" class="btn btn-primary" id="submitBtn" onclick="submitForm()">Submit</button>

    </form>
</div>
@endsection

<script>
    function addRows() {
        let parentDiv = document.getElementById('formSection');
        let div = document.createElement('div');
        div.classList.add('row');
        div.classList.add('mt-2');
        div.innerHTML = `
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" class="form-control status_name" name="status_name[]" placeholder="Enter status name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="number" class="form-control heirarchy_order" name="heirarchy_order[]" onchange="handleOrder('heirarchy_order')" placeholder="Enter heirarchy order">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <button type="button" onclick="removeRows()" class="">Remove</button>
                    </div>
                </div>
        `;
        parentDiv.appendChild(div);
    }

    function removeRows() {
        event.target.parentElement.parentElement.parentElement.remove();
    }

    function handleOrder(name) {
        let heirarchyInputs = document.getElementsByClassName(name);
        let currentArr = Array.from(heirarchyInputs);
        let currentValue = event.target.value;
        let count = 0;
        currentArr.find((element)=>{
            if (element.value == currentValue) {
                count++;
            }
        });
        if (count > 1) {
            event.target.style.border = '1px solid red';
            document.getElementById('addBtn').disabled = true;
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('pErr').innerText = 'Heirarchy already exists , please change!';
        }else{
            event.target.style.border = '1px solid #cccccc';
            document.getElementById('addBtn').disabled = false;
            document.getElementById('submitBtn').disabled = false;
            document.getElementById('pErr').innerText = '';
        }
    }


    function submitForm() {
        let form = document.getElementById('leadForm');
        let statusNameInputsArr = Array.from(document.getElementsByClassName('status_name'));
        let heirarchyInputsArr = Array.from(document.getElementsByClassName('heirarchy_order'));

        let inputs = [...statusNameInputsArr,...heirarchyInputsArr];
        let validationResponse = validateFields(inputs);
        if (validationResponse == false) {
            document.getElementById('rErr').innerText = 'Please fill the highlighted fields';
        } else {
            document.getElementById('rErr').innerText = '';
            form.submit();
        }
        debugger;
    }

    function validateFields(entries) {
        let errorCount = 0;
        entries.forEach(element => {
            if (element.value == '') {
                errorCount++;
                element.style.border = '1px solid red';
            }else{
                element.style.border = '1px solid #cccccc'
            }
        });

        if (errorCount > 0) {
            return false;
        } else {
            return true;
        }
    }
</script>