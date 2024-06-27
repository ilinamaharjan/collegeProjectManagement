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
    <li><a href="#"><span class="fa fa-home"></span> Package</a></li>
    <li><a href="#"><span class="fa fa-snowflake-o"> </span>View Package</a></li>
</ul> -->
<div class="d-flex bd-highlight mb-3">
    <div class="align-self-center mt-3">
        <h5>Package</h5>
    </div>
    <div class="mr-auto p-2 bd-highlight">

    </div>
    <div class="p-2 flex-grow-1 bd-highlight">
<h4 class="pageMainTitle mb-4">Profile</h4></div>
<div class="p-2 bd-highlight"></div>
    <div class="p-2 bd-highlight"> <button type="button" class="btn btn-primary convert">Download <i
                class="fa fa-arrow-down" aria-hidden="true"></i></button></div>
</div>

<div class="container-fluid">
    <div class="row mt-4">
        @foreach ($packages as $package)
        <div class="col-lg-4">
            @if ($loop->even)
            <div class="card card-margin" style="background-color: black;color:white">
                <div class="card-header no-border">
                    <h5 class="card-title text-white">{{$package->title}}</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="widget-49">
                        <div class="widget-49-title-wrapper">
                            <div class="widget-49-date-primary">
                                <p class="widget-49-date-day">Subscription mode : {{ $package->subscription_mode }}</p>
                                <p class="widget-49-date-month">Price : {{ $package->price }}</p>
                                <p class="widget-49-date-month">Number of users : {{ $package->no_of_users }}</p>
                            </div>
                            <div class="widget-49-meeting-info">
                                <span class="widget-49-meeting-time">The modules associated with this package :</span>
                            </div>
                        </div>
                        <ol class="widget-49-meeting-points">
                            @foreach ($package->modules->take(5) as $module)
                                <li class="widget-49-meeting-item"><span>{{$module->display_name}}</span></li>
                            @endforeach                            
                        </ol>
                        <div class="widget-49-meeting-action">
                            <a href="#" class="btn btn-sm btn-flash-border-primary text-white" 
                            style="background-color: #cdb840" data-toggle="modal" data-target="#commonModal" onclick="loadModal('{{ route('package.getModules',$package->id) }}')">View All</a>
                        </div>
                    </div>
                </div>
            </div>  
            @else
            <div class="card card-margin">
                <div class="card-header no-border">
                    <h5 class="card-title">{{$package->title}}</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="widget-49">
                        <div class="widget-49-title-wrapper">
                            <div class="widget-49-date-primary">
                                <p class="widget-49-date-day">Subscription mode : {{ $package->subscription_mode }}</p>
                                <p class="widget-49-date-month">Price : {{ $package->price }}</p>
                                <p class="widget-49-date-month">Number of users : {{ $package->no_of_users }}</p>
                            </div>
                            <div class="widget-49-meeting-info">
                                <span class="widget-49-meeting-time">The modules associated with this package :</span>
                            </div>
                        </div>
                        <ol class="widget-49-meeting-points">
                            @foreach ($package->modules->take(5) as $module)
                                <li class="widget-49-meeting-item"><span>{{$module->display_name}}</span></li>
                            @endforeach                            
                        </ol>
                        <div class="widget-49-meeting-action">
                            <a href="#" class="btn btn-sm btn-flash-border-primary text-white" style="background-color: #cdb840" 
                            data-toggle="modal" data-target="#commonModal" onclick="loadModal('{{ route('package.getModules',$package->id) }}')">View All</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection
<script>
    
</script>
