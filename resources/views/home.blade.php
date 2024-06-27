@extends('backend.layouts.app')
@section('content')

    <h5 class="main-activity mb-3">Activity</h5>
    <div class="row">
        <!-- task, page, download counter  start -->
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="pl-3 pr-3 card-block">

                    <div class="d-flex bd-highlight mb-3 mt-3">
                        <div class="bd-highlight"><i class="fa fa-user-o f-18 ds-icon"></i></div>
                        <div class="p-2 bd-highlight"><span class="ds-list">No. of Users</span></div>
                        <div class="ml-auto p-2 bd-highlight"><i class="fa fa-angle-right"></i></div>
                    </div>


                    <div class="row align-items-center">


                        <div class="col-6 p-1">
                            <h2 class="activity text p-3">{{$data['noOfUsers']}}</h2>

                        </div>
{{--                        <div class="col-6 text-right">--}}
{{--                            <span class="ds-date">Last 7 days <i class="fa fa-angle-down"></i></span>--}}
{{--                        </div>--}}


                    </div>
                </div>

            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="pl-3 pr-3 card-block">

                    <div class="d-flex bd-highlight mb-3 mt-3">
                        <div class=" bd-highlight"><i class="fa fa-file-text-o f-18 ds-icon1"></i></div>
                        <div class="p-2 bd-highlight"><span class="ds-list">No. of Companies</span></div>
                        <div class="ml-auto p-2 bd-highlight"><i class="fa fa-angle-right"></i></div>
                    </div>


                    <div class="row align-items-center">


                        <div class="col-6 p-1">
                            <h2 class="activity text p-3">{{$data['noOfCompany']}}</h2>

                        </div>
                        {{--                    <div class="col-6 text-right">--}}
                        {{--                        <span class="badge badge-pill badge-danger">-2%</span> --}}
                        {{--                    </div>--}}


                    </div>
                </div>

            </div>
        </div>

            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="pl-3 pr-3 card-block">
                        <div class="d-flex bd-highlight mb-3 mt-3">
                            <div class=" bd-highlight"><i class="fa fa-calendar-o f-18 ds-icon3" aria-hidden="true"></i> </div>
                            <div class="p-2 bd-highlight"><span class="ds-list">No. of projects</span></div>
                            <div class="ml-auto p-2 bd-highlight"><i class="fa fa-angle-right"></i></div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-6 p-1">
                                <h2 class="activity text p-3">{{$data['noOfProject']}}</h2>
                            </div>
                            <div class="col-6 text-right">
                                <span class="ds-date"><span class="badge badge-pill badge-success">2%</span> </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="pl-3 pr-3 card-block">
                    <div class="d-flex bd-highlight mb-3 mt-3">
                            <div class="bd-highlight"> <i class="fa fa-file-text-o f-18 ds-icon3"></i></div>
                            <div class="p-2 bd-highlight"><span class="ds-list">No. of Tasks</span></div>
                            <div class="ml-auto p-2 bd-highlight"><i class="fa fa-angle-right"></i></div>
                        </div>

                        <div class="row align-items-center">
                        <div class="col-4 p-1">
                                <h2 class="activity text p-3">{{$data['noOfTasks']}}</h2>

                            </div>
                            <div class="col-8 text-right">
                                <span class="ds-date">Completed <span class="badge badge-pill badge-success">{{$data['completedPercentage']}}%</span> </span>
                                <span class="ds-date">Ongoing <span class="badge badge-pill badge-success">{{$data['remainingPercentage']}}%</span> </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <!-- task, page, download counter  end -->

        <!--  sale analytics start -->
{{--        <div class="col-xl-12 col-md-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <div class="d-flex bd-highlight">--}}
{{--                        <div class="mr-auto p-2 bd-highlight"><h5 class=" main-activity mb-3">Sales Forcasting<span--}}
{{--                                    class="badge badge-pill badge-success ml-5">6%</span></h5></div>--}}
{{--                        <div class="p-2 bd-highlight"><h5 class="ds-date"><b>Rs.45,0000</b></h5></div>--}}
{{--                        <div class="bd-highlight">--}}
{{--                            <button type="button" class="btn btn-primary convert mb-5">Today <i--}}
{{--                                    class="fa fa-angle-down"></i></button>--}}
{{--                        </div>--}}
{{--                    </div>--}}


{{--                </div>--}}
{{--                <div class="card-block">--}}
{{--                    <div id="myChart" style="width:100%; height:500px;"></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <!-- <div class="col-xl-4 col-md-12">
            <div class="card">
                <div class="card-block">
                    <div class="row">
                        <div class="col">
                            <h4>$256.23</h4>
                            <p class="text-muted">This Month</p>
                        </div>
                        <div class="col-auto">
                            <label class="label label-success">+20%</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <canvas id="this-month" style="height: 150px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card quater-card">
                <div class="card-block">
                    <h6 class="text-muted m-b-15">This Quarter</h6>
                    <h4>$3,9452.50</h4>
                    <p class="text-muted">$3,9452.50</p>
                    <h5>87</h5>
                    <p class="text-muted">Online Revenue<span class="f-right">80%</span></p>
                    <div class="progress">
                        <div class="progress-bar bg-c-blue" style="width: 80%"></div>
                    </div>
                    <h5 class="m-t-15">68</h5>
                    <p class="text-muted">Offline Revenue<span class="f-right">50%</span></p>
                    <div class="progress">
                        <div class="progress-bar bg-c-green" style="width: 50%"></div>
                    </div>
                </div>
            </div> -->
    </div>



    <!--  sale analytics end -->

    <!--  project and team member start -->
{{--    <div class="col-xl-12 col-md-12">--}}


{{--        <div class="d-flex bd-highlight mb-3">--}}
{{--            <div class="align-self-center">--}}
{{--                <h5 class="main-activity mb-3">All Leads</h5>--}}
{{--            </div>--}}
{{--            <div class="mr-auto p-2 bd-highlight">--}}

{{--            </div>--}}

{{--            <div class="p-2 bd-highlight">--}}

{{--                <!-- Button trigger modal -->--}}
{{--                <button type="button" class="btn btn-primary lead" data-toggle="modal" data-target="#staticBackdrop">--}}
{{--                    <i class="fa fa-plus" aria-hidden="true" style="font-size:smaller;"></i> Add Leads--}}
{{--                </button>--}}

{{--                <!-- Modal -->--}}
{{--                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"--}}
{{--                     aria-labelledby="staticBackdropLabel" aria-hidden="true">--}}
{{--                    <div class="modal-dialog">--}}
{{--                        <div class="modal-content p-3">--}}
{{--                            <div class="modal-header">--}}
{{--                                <h5 class="modal-title" id="staticBackdropLabel">Add Leads</h5>--}}
{{--                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                    <span aria-hidden="true">&times;</span>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                            <div class="modal-body">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-4">--}}
{{--                                        <h6>Photo/Logo</h6>--}}

{{--                                        <input type="text" name="id" value="" hidden>--}}
{{--                                        <!-- <label for="inputImage" id="inputLabel">Click Here to upload logo</label> -->--}}

{{--                                        <input type="file" id="inputImage" name="company-logo"--}}
{{--                                               onchange="changePicture()"/>--}}
{{--                                        <div id="preview-image">--}}
{{--                                            <img src="backend/images/avatar-1.jpg" id="imageDiv"--}}
{{--                                                 class="img-fluid customImage mt-3"--}}
{{--                                                 alt="" style="border-radius:25px;">--}}

{{--                                            <div id="placeholder">--}}

{{--                                                <div id="upload-area" title="select a image">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-md-8 mt-5">--}}
{{--                                        <div class="row ">--}}
{{--                                            <div class="col-md-12"><label class="labels mt-3">Full Name</label><input--}}
{{--                                                    type="text"--}}
{{--                                                    class="form-control" placeholder="Company name" name="name"--}}
{{--                                                    value=""></div>--}}
{{--                                        </div>--}}
{{--                                        <div class="row mt-1">--}}
{{--                                            <div class="col-md-12"><label class="labels mt-3">Last Name</label><input--}}
{{--                                                    type="text"--}}
{{--                                                    class="form-control" placeholder="Company email" name="email"--}}
{{--                                                    value="">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}


{{--                            </div>--}}

{{--                            <div class="row p-2">--}}
{{--                                <div class="col-md-12">--}}
{{--                                    <label class="labels">Agency Type</label>--}}
{{--                                    <select name="agency_id" class="form-control" name="total_employees">--}}
{{--                                        <option selected>Marketing Agency</option>--}}
{{--                                        <option value="1">One</option>--}}
{{--                                        <option value="2">Two</option>--}}
{{--                                        <option value="3">Three</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="row p-2">--}}
{{--                                <div class="col-md-12"><label class="labels">Email ID</label><input type="text"--}}
{{--                                                                                                    class="form-control"--}}
{{--                                                                                                    placeholder="email id"--}}
{{--                                                                                                    name="name"--}}
{{--                                                                                                    value=""></div>--}}
{{--                                <p class="m-3" style="color:#4046DD;font-weight:500;"> + Add New</p>--}}
{{--                            </div>--}}

{{--                            <div class="row p-2">--}}
{{--                                <div class="col-md-12"><label class="labels">Contact</label><input type="text"--}}
{{--                                                                                                   class="form-control"--}}
{{--                                                                                                   placeholder="contact"--}}
{{--                                                                                                   name="name" value="">--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                            <div class="row p-2">--}}
{{--                                <div class="col-md-12"><label class="labels">Address</label><input type="text"--}}
{{--                                                                                                   class="form-control"--}}
{{--                                                                                                   placeholder="address"--}}
{{--                                                                                                   name="name" value="">--}}
{{--                                </div>--}}

{{--                            </div>--}}

{{--                            <div class="flex mt-5 mb-3 me-auto">--}}

{{--                                <button type="button" class="btn btn-primary convert" data-toggle="modal"--}}
{{--                                        data-target="#myModal" style="width:45%;">Cancel--}}
{{--                                </button>--}}
{{--                                <button type="button" class="btn btn-primary save" data-toggle="modal"--}}
{{--                                        data-target="#myModal" style="width:45%;">Save--}}
{{--                                </button>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}


{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="scrollbar" id="style-1">--}}

{{--            <table class="table table-light" style="border-radius:12px!important;">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th scope="col">Leads</th>--}}
{{--                    <th scope="col">Contact No.</th>--}}
{{--                    <th scope="col">Invoice</th>--}}
{{--                    <th scope="col">Date</th>--}}
{{--                    <th scope="col">Status</th>--}}
{{--                    <th scope="col">Action</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                <tr>--}}
{{--                    <th scope="row">--}}

{{--                        <div class="d-flex bd-highlight mb-3">--}}
{{--                            <div class="align-self-center">--}}
{{--                                <img src="backend/images/avatar-1.jpg" id="imageDiv" class="img-fluid customImage"--}}
{{--                                     alt=""--}}
{{--                                     style="border-radius:50%; width:50px;">--}}
{{--                            </div>--}}
{{--                            <div class="align-self-center p-3 bd-highlight">--}}
{{--                                <h6>Jonny Deo</h6>--}}
{{--                                <span class="profile-customer"> Email@gmail.com | 98000000000 </span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </th>--}}

{{--                    <td>Mark</td>--}}
{{--                    <td><span style="color:#4046DD!important;">Rs. 550000</span></td>--}}
{{--                    <td>@mdo</td>--}}
{{--                    <td><span class="badge badge-pill badge-success">Completed</span></td>--}}
{{--                    <td><i class="fa fa-edit customer"></i>--}}
{{--                        <i class="fa fa-trash customer" aria-hidden="true"></i>--}}
{{--                        <i class="fa fa-eye customer" aria-hidden="true"></i>--}}
{{--                    </td>--}}

{{--                </tr>--}}

{{--                <tr>--}}
{{--                    <th scope="row">--}}

{{--                        <div class="d-flex bd-highlight mb-3">--}}
{{--                            <div class="align-self-center">--}}
{{--                                <img src="backend/images/avatar-1.jpg" id="imageDiv" class="img-fluid customImage"--}}
{{--                                     alt=""--}}
{{--                                     style="border-radius:50%; width:50px;">--}}
{{--                            </div>--}}
{{--                            <div class="align-self-center p-3 bd-highlight">--}}
{{--                                <h6>Jonny Deo</h6>--}}
{{--                                <span class="profile-customer"> Email@gmail.com | 98000000000 </span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </th>--}}

{{--                    <td>Mark</td>--}}
{{--                    <td><span style="color:#4046DD!important;">Rs. 550000</span></td>--}}
{{--                    <td>@mdo</td>--}}
{{--                    <td><span class="badge badge-pill badge-danger">Pending</span></td>--}}
{{--                    <td><i class="fa fa-edit customer"></i>--}}
{{--                        <i class="fa fa-trash customer" aria-hidden="true"></i>--}}
{{--                        <i class="fa fa-eye customer" aria-hidden="true"></i>--}}
{{--                    </td>--}}

{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <th scope="row">--}}

{{--                        <div class="d-flex bd-highlight mb-3">--}}
{{--                            <div class="align-self-center">--}}
{{--                                <img src="backend/images/avatar-1.jpg" id="imageDiv" class="img-fluid customImage"--}}
{{--                                     alt=""--}}
{{--                                     style="border-radius:50%;width:50px;">--}}
{{--                            </div>--}}
{{--                            <div class="align-self-center p-3 bd-highlight">--}}
{{--                                <h6>Jonny Deo</h6>--}}
{{--                                <span class="profile-customer"> Email@gmail.com | 98000000000 </span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </th>--}}

{{--                    <td>Mark</td>--}}
{{--                    <td><span style="color:#4046DD!important;">Rs. 550000</span></td>--}}
{{--                    <td>@mdo</td>--}}
{{--                    <td><span class="badge badge-pill badge-success">Completed</span></td>--}}
{{--                    <td><i class="fa fa-edit customer"></i>--}}
{{--                        <i class="fa fa-trash customer" aria-hidden="true"></i>--}}
{{--                        <i class="fa fa-eye customer" aria-hidden="true"></i>--}}
{{--                    </td>--}}

{{--                </tr>--}}

{{--                </tbody>--}}

{{--            </table>--}}
{{--        </div>--}}


{{--        <!-- <div class="col-xl-4 col-md-12">--}}
{{--        <div class="card ">--}}
{{--            <div class="card-header">--}}
{{--                <h5>Team Members</h5>--}}
{{--                <div class="card-header-right">--}}
{{--                    <ul class="list-unstyled card-option">--}}
{{--                        <li><i class="fa fa fa-wrench open-card-option"></i></li>--}}
{{--                        <li><i class="fa fa-window-maximize full-card"></i></li>--}}
{{--                        <li><i class="fa fa-minus minimize-card"></i></li>--}}
{{--                        <li><i class="fa fa-refresh reload-card"></i></li>--}}
{{--                        <li><i class="fa fa-trash close-card"></i></li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="card-block">--}}
{{--                <div class="align-middle m-b-30">--}}
{{--                    <img src="assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">--}}
{{--                    <div class="d-inline-block">--}}
{{--                        <h6>David Jones</h6>--}}
{{--                        <p class="text-muted m-b-0">Developer</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="align-middle m-b-30">--}}
{{--                    <img src="assets/images/avatar-1.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">--}}
{{--                    <div class="d-inline-block">--}}
{{--                        <h6>David Jones</h6>--}}
{{--                        <p class="text-muted m-b-0">Developer</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="align-middle m-b-30">--}}
{{--                    <img src="assets/images/avatar-3.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">--}}
{{--                    <div class="d-inline-block">--}}
{{--                        <h6>David Jones</h6>--}}
{{--                        <p class="text-muted m-b-0">Developer</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="align-middle m-b-30">--}}
{{--                    <img src="{{ asset('backend/images/avatar-4.jpg') }}" alt="user image"--}}
{{--                        class="img-radius img-40 align-top m-r-15">--}}
{{--                    <div class="d-inline-block">--}}
{{--                        <h6>David Jones</h6>--}}
{{--                        <p class="text-muted m-b-0">Developer</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="align-middle m-b-10">--}}
{{--                    <img src="assets/images/avatar-5.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">--}}
{{--                    <div class="d-inline-block">--}}
{{--                        <h6>David Jones</h6>--}}
{{--                        <p class="text-muted m-b-0">Developer</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="text-center">--}}
{{--                    <a href="#!" class="b-b-primary text-primary">View all Projects</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div> -->--}}
{{--    </div>--}}
{{--    <!--  project and team member end -->--}}
{{--    </div>--}}
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://rawgit.com/gionkunz/chartist-js/master/dist/chartist.min.js"></script>

    <script>
        google.charts.load('current', {packages: ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
// Set Data
            const data = google.visualization.arrayToDataTable([
                ['Price', 'Size'],
                [50, 7], [60, 8], [70, 8], [80, 9], [90, 9],
                [100, 9], [110, 10], [120, 11],
                [130, 14], [140, 14], [150, 15]
            ]);
// Set Options
            const options = {
                title: 'Sales Analaysis',
                hAxis: {title: 'Date'},
                vAxis: {title: 'time'},
                legend: 'none'
            };
// Draw
            const chart = new google.visualization.LineChart(document.getElementById('myChart'));
            chart.draw(data, options);
        }
    </script>

@endsection
