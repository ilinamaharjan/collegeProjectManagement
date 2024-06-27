
@extends('backend.layouts.app')

@section('content')

<div class="d-flex bd-highlight mb-3">
    <div class="align-self-center"><h5><b>Payment Breakdown</b></h5></div>
  <div class="mr-auto p-2 bd-highlight">
      
</div>
<div class=" p-2 bd-highlight"> <button type="button" class="btn btn-primary convert">Today <i class="fa fa-angle-down"></i></button></div>
  <div class="p-2 bd-highlight"> <button type="button" class="btn btn-primary convert">Download <i class="fa fa-arrow-down" aria-hidden="true"></i></button></div>
</div>


<div class="row">
    <!-- task, page, download counter  start -->
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">

                <div class="d-flex bd-highlight mb-3">
                    <div class="p-2 bd-highlight"> <i class="fa fa-money f-28 ds-icon"></i></div>
                    <div class="p-2 bd-highlight"><span class="ds-list">All Invoice</span></div>
                    <div class="ml-auto p-2 bd-highlight"><i class="fa fa-angle-right"></i></div>
                </div>



                <div class="row align-items-center">


                    <div class="col-8">
                        <h2 class="text p-3">Rs.290</h2>

                    </div>
                    <div class="col-4 text-right">
                        <span class="ds-date">Last 7 days <i class="fa fa-angle-down"></i></span>
                    </div>


                </div>
            </div>

        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">

                <div class="d-flex bd-highlight mb-3">
                    <div class="p-2 bd-highlight"> <i class="fa fa-credit-card f-28 ds-icon1"></i></div>
                    <div class="p-2 bd-highlight"><span class="ds-list">Paid</span></div>
                    <div class="ml-auto p-2 bd-highlight"><i class="fa fa-angle-right"></i></div>
                </div>



                <div class="row align-items-center">


                    <div class="col-8">
                        <h2 class="text p-3">Rs.290</h2>

                    </div>
                    <div class="col-4 text-right">
                        <span class="badge badge-pill badge-danger">-2%</span> 
                    </div>


                </div>
            </div>

        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">

                <div class="d-flex bd-highlight mb-3">
                    <div class="p-2 bd-highlight"> <i class="fa fa-file-text-o f-28 ds-icon3"></i></div>
                    <div class="p-2 bd-highlight"><span class="ds-list">UnPaid</span></div>
                    <div class="ml-auto p-2 bd-highlight"><i class="fa fa-angle-right"></i></div>
                </div>



                <div class="row align-items-center">


                    <div class="col-8">
                        <h2 class="text p-3">Rs.290</h2>

                    </div>
                    <div class="col-4 text-right">
                        <span class="ds-date"><span class="badge badge-pill badge-success">2%</span> </span>
                    </div>


                </div>
            </div>

        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
            <div class="d-flex bd-highlight mb-3">
                    <div class="p-2 bd-highlight"> <i class="fa fa-calendar f-28 ds-icon3"></i></div>
                    <div class="p-2 bd-highlight"><span class="ds-list">Schdeuled</span></div>
                    <div class="ml-auto p-2 bd-highlight"><i class="fa fa-angle-right"></i></div>
                </div>

                <div class="row align-items-center">
                <div class="col-8">
                        <h2 class="text p-3">Rs.290</h2>

                    </div>
                    <div class="col-4 text-right">
                        <span class="ds-date"><span class="badge badge-pill badge-success">6%</span> </span>
                    </div>
                </div>
            </div>
           
        </div>
    </div>


</div>
    <!--  -->

    <div class="row">
    <ul class="nav nav-tab" role="tablist" style="border-bottom:1px solid #eaeaea;">
        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-1" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <span class="contract-detail p-2">All Invoice</span></div>
            </div>
        </li>

        <li class="nav-item">
            <div class="nav-link active" data-toggle="tab" href="#tabs-2" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <span class="contract-detail p-2">Paid</span></div>
            </div>
        </li>

        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <span class="contract-detail p-2">UnPaid</span></div>
            </div>
        </li>


        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-4" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <span class="contract-detail p-2">Schdeuled</span></div>
            </div>
        </li>
    </ul>

   
</div>

<!-- Tab panes -->
<div class="bg-section mt-3 mb-5">
    <div class="tab-content">
        <div class="tab-pane " id="tabs-2" role="tabpanel">

            <div class="d-flex bd-highlight mb-3">
                <div class="mr-auto p-2 bd-highlight">
                    <h6 class="profile-sec">Aggrement List</h6>
                </div>
                <div class="p-2 bd-highlight">

                    <i class="fa fa-trash profile" aria-hidden="true"></i>
                    <i class="fa fa-arrow-down profile" aria-hidden="true"> </i>
                </div>
                <div class="p-2 bd-highlight">

                    <div class="p-2">Uploaded <span class="p-2"> <b> 01 Aug, 2023 </b></span></div>
                </div>

            </div>
        </div>

    


        <div class="tab-pane active" id="tabs-1" role="tabpanel">

        <table class="table table-light" style="border-radius:20px;">
  <thead>
    <tr>
      <th scope="col">Customer</th>
      <th scope="col">Payment Type</th>
      <th scope="col">Invoice</th>
      <th scope="col">Date</th>
      <th scope="col">Status</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">

       <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <img src="backend/images/avatar-1.jpg" id="imageDiv" class="img-fluid customImage" alt=""
                        style="border-radius:50%;height:50px; width:50px;">
                </div>
                <div class="align-self-center p-3 bd-highlight">
                    <h6>Jonny Deo</h6>
                    <span class="profile-customer"> Email@gmail.com | 98000000000 </span>
                </div>
            </div>
      </th>

      <td>Mark</td>
      <td><span style="color:#4046DD!important;">Rs. 550000</span></td>
      <td>@mdo</td>
      <td><span class="badge badge-pill badge-success">Completed</span></td>
      <td><i class="fa fa-edit customer"></i>
      <i class="fa fa-trash customer" aria-hidden="true"></i>
      <i class="fa fa-eye customer" aria-hidden="true"></i>
    </td>
    
    </tr>

    <tr>
      <th scope="row">

       <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <img src="backend/images/avatar-1.jpg" id="imageDiv" class="img-fluid customImage" alt=""
                        style="border-radius:50%;height:50px; width:50px;">
                </div>
                <div class="align-self-center p-3 bd-highlight">
                    <h6>Jonny Deo</h6>
                    <span class="profile-customer"> Email@gmail.com | 98000000000 </span>
                </div>
            </div>
      </th>

      <td>Mark</td>
      <td><span style="color:#4046DD!important;">Rs. 550000</span></td>
      <td>@mdo</td>
      <td><span class="badge badge-pill badge-danger">Pending</span></td>
      <td><i class="fa fa-edit customer"></i>
      <i class="fa fa-trash customer" aria-hidden="true"></i>
      <i class="fa fa-eye customer" aria-hidden="true"></i>
    </td>
    
    </tr>
    <tr>
      <th scope="row">

       <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <img src="backend/images/avatar-1.jpg" id="imageDiv" class="img-fluid customImage" alt=""
                        style="border-radius:50%;height:50px; width:50px;">
                </div>
                <div class="align-self-center p-3 bd-highlight">
                    <h6>Jonny Deo</h6>
                    <span class="profile-customer"> Email@gmail.com | 98000000000 </span>
                </div>
            </div>
      </th>

      <td>Mark</td>
      <td><span style="color:#4046DD!important;">Rs. 550000</span></td>
      <td>@mdo</td>
      <td><span class="badge badge-pill badge-success">Completed</span></td>
      <td><i class="fa fa-edit customer"></i>
      <i class="fa fa-trash customer" aria-hidden="true"></i>
      <i class="fa fa-eye customer" aria-hidden="true"></i>
    </td>
    
    </tr>
   
  </tbody>
</table>

        </div>
        <div class="tab-pane" id="tabs-3" role="tabpanel">
            <p>Third Panel</p>
        </div>

        <div class="tab-pane" id="tabs-4" role="tabpanel">
            <p>4 Panel</p>
        </div>
    </div>

</div>


    
<nav aria-label="Page navigation example mt-3">
  <ul class="pagination justify-content-center mt-3">
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Previous">
     
        <span aria-hidden="true">&laquo;</span>
        <i class="fa fa-chevron-left" style="font-size:10px;"></i>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    <li class="page-item "><a class="page-link active" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Next">
      <i class="fa fa-chevron-right"style="font-size:10px;"></i>
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
 
  </ul>


</nav>


@endsection