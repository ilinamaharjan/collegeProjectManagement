@extends('backend.layouts.app')

@section('content')
    <!-- <ul id="breadcrumb">
                                                                                                                                <li><a href="#"><span class="fa fa-home"></span> Company</a></li>
                                                                                                                                <li><a href="#"><span class="fa fa-snowflake-o"> </span> All Companies</a></li>
                                                                                                                            </ul> -->
    <!-- <a href="{{ route('home.package') }}"><button type="button" class="btn btn-primary back"><i class='fa fa-arrow-left' style="font-size:13px;"> Back</i>
                                                                                                                            </button></a> -->
    <div class="d-flex bd-highlight mb-3">
        <div class="align-self-center mt-3">
            <h5 class=" pageMainTitle mb-3 mt-3">Package Details</h5>
        </div>
        <div class="mr-auto p-2 bd-highlight">

        </div>
        <div class=" p-2 bd-highlight"></div>
        <div class="p-2 bd-highlight">
            <button type="button" class="btn btn-primary lead mb-3 mt-3"
                onclick="location.href='{{ route('package.configure') }}'">
                <i class="fa fa-plus" aria-hidden="true" style="font-size:smaller;"></i> Add Package</button>
        </div>
    </div>


    <table class="table table-table table-light">
        <thead>
            <tr>
                <th scope="col">S.No</th>
                <th scope="col">Title</th>
                <th scope="col">Price</th>
                <th scope="col">No. of users</th>
                <th scope="">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($packages as $key => $package)
                <tr>

                    <td>{{ $key + 1 }}</td>
                    <td>{{ $package['title'] }}</td>
                    <td>{{ $package['price'] }}</td>
                    <td>{{ $package['no_of_users'] }}</td>
                    <td>
                        @if (count($package->company) == 0)
                            <a href="" class="actionBtnHolder editColor" data-toggle="modal"
                                data-target="#commonModal"
                                onclick="loadModal('{{ route('package.updateModal', $package->id) }}')">
                                <i class="fa fa-edit customer"></i>
                            </a>
                            {{-- <a href="{{ route('package.delete',$package->id) }}">
                <i class="fa fa-trash customer" aria-hidden="true"></i>
            </a> --}}
                            <i class="fa fa-trash customer" aria-hidden="true" data-toggle="modal"
                                data-target="#deleteModalPackage{{ $key }}"></i>
                        @endif
                        <a href="" class="actionBtnHolder" data-toggle="modal" data-target="#commonModal"
                            onclick="loadModal('{{ route('package.showModal', $package->id) }}')" class="btn btn-primary">
                            <i class="fa fa-eye customer"></i>
                        </a>
                    </td>

                </tr>

                <div class="modal fade text-dark" id="deleteModalPackage{{ $key }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Delete
                                    Package</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body pt-1">
                                <p>Are you sure want to delete this package?</p>

                            </div>
                            <div class="modal-footer">
                                <a href="{{ route('package.delete', $package->id) }}" class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>



            @empty
            @endforelse


        </tbody>
    </table>


    <nav class=" mt-5 mb-5"aria-label="Page navigation example">
        <ul class="pagination justify-content-center mt-3">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">

                  
                    <i class="fa fa-chevron-left" style="font-size:10px;"></i>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item active"><a class="page-link " href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <i class="fa fa-chevron-right" style="font-size:10px;"></i>
                
                    <span class="sr-only">Next</span>
                </a>
            </li>

        </ul>


    </nav>
@endsection
