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
    <li><a href="#"><span class="fa fa-snowflake-o"> </span> Customer Status Settings</a></li>
</ul> -->

<div class="container-fluid card rounded bg-white mt-3 mb-3">
    <div class="mt-4 mb-4">
        <a href="{{ route('customer_setting.create') }}" class="btn btn-primary">Add Setting</a>    
    </div>   
    
    <div class="table-responsive p-3">
        <table class="table table-bordered">
            <thead style="background-color: #375893" class="text-white">
                <th>S.no</th>
                <th>Status Name</th>
                <th>Unique Name</th>
                <th>Heirarchy</th>
                <th></th>
            </thead>
            <tbody>
                @forelse ($customer_settings as $key => $cs)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $cs['status_name'] }}</td>
                        <td>{{ $cs['unique_name'] }}</td>
                        <td>{{ $cs['heirarchy_order'] }}</td>
                        <td class="text-center">
                            {{-- <a href="" class="text-primary" data-toggle="modal" data-target="#commonModal" onclick="loadModal('{{ route('company.viewOwnCompany',$company->id) }}')"><i class="fa fa-eye"></i></a> --}}
                            <a href="" class="text-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            No data present
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection