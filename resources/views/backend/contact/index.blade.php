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
<div class="d-flex bd-highlight">
    <div class="p-2 flex-grow-1 bd-highlight">
  <h4 class="pageMainTitle mb-3 mt-3">Contact Person</h4></div>
  {{-- <div class="p-2 bd-highlight"><a href="{{route('company.viewCompanies')}}"><button type="button" class="btn btn-primary lead" data-toggle="modal" data-target="#staticBackdrop"style="float:right;">
  <i class="fa fa-eye" aria-hidden="true" style="font-size:smaller;"></i> View
  </button></a></div> --}}
    <div class="p-2 bd-highlight">
    <a>
        <button type="button" class="btn btn-primary lead mb-3 mt-3"  data-toggle="modal" data-target="#commonModal" onclick="loadModal('{{ route('contact.create') }}')" style="float:right;">
            <i class="fa fa-plus" aria-hidden="true" style="font-size:smaller;"></i> Add Contacts
        </button>
        
    </a>
    </div>
  </div>
        

<table class="table table-table table-light">
    <thead>
    <th>S.no</th>
    <th>Name</th>
    <th>Company</th>
    <th>Organization</th>
    <th>Status</th>
    <th></th>
    </thead>
    <tbody>
    @forelse ($contacts as $key => $contact)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $contact['name'] }}</td>
            <td>{{ $contact->company->name }}</td>
            <td>{{ $contact['organization_id'] == null ? '' : $contact->organization->name }}</td>
            <td><span class="badge badge-pill {{ $contact['status'] == 'Active' ? 'badge-success' : 'badge-danger'}}">{{ $contact['status'] }}</span></td>
            <td class="">
                <a href="" class="actionBtnHolder editColor"  data-toggle="modal" data-target="#commonModal" onclick="loadModal('{{ route('contact.updateModal',$contact['id']) }}')">
                    <i class="fa fa-edit customer"></i>
                </a> 
                <a href="{{ route('contact.disable',$contact['id']) }}">
                    <i class="fa fa-trash customer" aria-hidden="true"></i>
                </a>
                <a href="" class="actionBtnHolder"  data-toggle="modal" data-target="#commonModal" onclick="loadModal('{{ route('contact.showModal',$contact['id']) }}')" class="btn btn-primary">
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
    @endforelse
    </tbody>
</table>
@endsection
