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
                                                                                                                    <li><a href="#"><span class="fa fa-home"></span> Company</a></li>
                                                                                                                    <li><a href="#"><span class="fa fa-snowflake-o"> </span> All Companies</a></li>
                                                                                                                </ul> -->


    <div class="d-flex bd-highlight mb-3">
        <div class="align-self-center mt-3">
            <h5 class=" pageMainTitle mb-3">Company Details</h5>
        </div>
        <div class="mr-auto p-2 bd-highlight">

        </div>
        <div class=" p-2 bd-highlight"></div>
        <div class="p-2 bd-highlight">
            <button type="button" class="btn btn-primary lead" onclick="location.href='{{ route('company.create') }}'">
                <i class="fa fa-plus" aria-hidden="true" style="font-size:smaller;"></i> Add Company
            </button>
        </div>
    </div>


    <table class="table table-table table-light">
        <thead>
        <tr>

            <th scope="col">Department Name</th>
            <th scope="col">No.of Staffs</th>
            <th scope="col">Company Name</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($department as $key=> $company)
            <tr>
                <th scope="row">

                    <div class="d-flex bd-highlight mb-3">
                        <div class="align-self-center">
                            <img
                                src="{{ $company->hasMedia('company-logo') ? $company->getMedia('company-logo')[0]->getFullUrl() : 'backend/images/avatar-1.jpg' }}"
                                class="img-fluid customImage" alt=""
                                style="border-radius:50%;height:50px; width:50px;">
                        </div>
                        <div class="align-self-center p-3 bd-highlight">
                            <h6>{{ $company['name'] }}</h6>
                            <span class="profile-customer"> {{ $company['email'] }} | {{ $company['phone_number'] }}
                                </span>
                        </div>
                    </div>
                </th>

                <td><span style="color:#4046DD!important;">{{ $company['total_employees'] }}</span></td>
                <td>{{ $company['website'] }}</td>
                <td><span class="badge badge-pill badge-success">Active</span></td>
                <td>
                    @if (count($company->users) == 0)
                        <a href="{{ route('profile.userPage', $company->id) }}" class="actionBtnHolder editColor"> <i
                                class="fa fa-user customer"></i></a>
                    @endif
                    <a href="" class="actionBtnHolder editColor" data-toggle="modal" data-target="#commonModal"
                       onclick="loadModal('{{ route('company.phdateModal', $company->id) }}')">
                        <i class="fa fa-edit customer"></i>
                    </a>
                    {{-- <a href="{{ route('company.delete', $company->id) }}">
                        <i class="fa fa-trash customer" aria-hidden="true"></i>
                    </a> --}}
                    <i class="fa fa-trash customer" aria-hidden="true" data-toggle="modal"
                       data-target="#deleteModalCompany{{ $key }}"></i>

                    <a href="" class="actionBtnHolder" data-toggle="modal" data-target="#commonModal"
                       onclick="loadModal('{{ route('company.viewOwnCompany', $company->id) }}')"
                       class="btn btn-primary">
                        <i class="fa fa-eye customer"></i>
                    </a>
                </td>

            </tr>

            <div class="modal fade text-dark" id="deleteModalCompany{{ $key }}" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Delete
                                Company</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body pt-1">
                            <p>Are you sure want to delete this company?</p>

                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('company.delete', $company->id) }}" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
        @endforelse


        </tbody>
    </table>
    </div>
    </div>


    <nav class="mt-3 mb-5" aria-label="Page navigation example ">
        <ul class="pagination justify-content-center mt-3">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">

                    <span aria-hidden="true">&laquo;</span>
                    <i class="fa fa-chevron-left" style="font-size:10px;"></i>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item active"><a class="page-link active" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <i class="fa fa-chevron-right" style="font-size:10px;"></i>
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>

        </ul>


    </nav>
@endsection
