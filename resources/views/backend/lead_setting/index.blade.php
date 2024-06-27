@extends('backend.layouts.app')
<style>
   

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
    <div class="mt-4 mb-4">
        <button href="{{ route('lead_setting.create') }}" class="btn btn-primary lead">Add Setting</button>    
    </div>   
    
    <div class="table-responsive p-3">
        <table class="table table-sm table-light rounded border">
            <thead style="background-color: #375893" class="text-white">
                <th>S.no</th>
                <th>Status Name</th>
                <th>Unique Name</th>
                <th>Heirarchy</th>
                <th></th>
            </thead>
            <tbody>
                @forelse ($lead_settings as $key => $ls)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $ls['status_name'] }}</td>
                        <td>{{ $ls['unique_name'] }}</td>
                        <td>{{ $ls['heirarchy_order'] }}</td>
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