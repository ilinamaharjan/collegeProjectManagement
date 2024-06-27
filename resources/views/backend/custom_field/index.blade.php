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
    .card .card-header h5:after {
    content: "";
    background-color: #cdb840 !important;
    position: absolute;
    left: -20px;
    top: 0;
    width: 4px;
    height: 20px;
    }
</style>

@section('content')
<!-- <ul id="breadcrumb">
    <li><a href="#"><span class="fa fa-home"></span> Custom Fields</a></li>
    <li><a href="#"><span class="fa fa-snowflake-o"> </span> Organizations</a></li>
</ul> -->

<div class="container-fluid card rounded bg-white mt-3 mb-3">
    <div class="mt-4 mb-4">
        <button href="#"  data-toggle="modal" data-target="#commonModal" onclick="loadModal('{{ route('custom_field.create',$type->id) }}')" class="btn btn-primary lead">Add Custom Field</button>    
    </div>   
    
    <div class="">
    <table class="table table-sm table-light rounded border">
            <thead style="background-color: #375893" class="text-white">
                <th>S.no</th>
                <th>Field Name</th>
                <th>Type</th>
                <th>Status</th>
                {{-- <th></th> --}}
            </thead>
            <tbody>
                @forelse ($custom_fields as $key => $custom_field)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $custom_field['field_name'] }}</td>
                        <td>{{ $custom_field['type'] }}</td>
                        <td><span class="badge badge-pill badge-success">{{ $custom_field['status'] }}</span></td>
                        {{-- <td class="text-center">
                            <a href="" class="text-danger"><i class="fa fa-trash"></i></a>
                        </td> --}}
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