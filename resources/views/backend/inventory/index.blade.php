@extends('backend.layouts.app')

@section('content')


<div class="row">
    <ul class="nav nav-tab" role="tablist" style="border-bottom:1px solid #eaeaea;">
        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-1" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <span class="contract-detail p-2">All</span></div>
            </div>
        </li>

        <li class="nav-item">
            <div class="nav-link active" data-toggle="tab" href="#tabs-2" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <span class="contract-detail p-2">Internal Transfer</span></div>
            </div>
        </li>

        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <span class="contract-detail p-2">Receipts</span></div>
            </div>
        </li>


    </ul>

   
</div>

<!-- Tab panes -->
<div class="bg-section mt-3 mb-5">
    <div class="tab-content mb-5">
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
      <th scope="col">Item</th>
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
      <td><button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tooltip on bottom">
  4
</button></td>
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
      <td><span class="badge badge-pill badge-danger">4</span></td>
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


<!--  -->


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

<div class="d-flex flex-row-reverse bd-highlight">




    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary customer" data-toggle="modal" data-target="#staticBackdrop">
<i class="fa fa-plus" aria-hidden="true" style="font-size:smaller;"></i> Add 
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Inventory</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
                        <div class="col-md-4">
                            <h6>Photo/Logo</h6>

                            <input type="text" name="id" value="" hidden>
                            <!-- <label for="inputImage" id="inputLabel">Click Here to upload logo</label> -->

                            <input type="file" id="inputImage" name="company-logo" onchange="changePicture()" />
                            <div id="preview-image">
                                <img src="backend/images/avatar-1.jpg" id="imageDiv" class="img-fluid customImage mt-3"
                                    alt="" style="border-radius:25px;">

                                <div id="placeholder">

                                    <div id="upload-area" title="select a image">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 mt-5">
                            <div class="row ">
                                <div class="col-md-12"><label class="labels mt-3">Full Name</label><input type="text"
                                        class="form-control" placeholder="Company name" name="name" value=""></div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-12"><label class="labels mt-3">Last Name</label><input type="text"
                                        class="form-control" placeholder="Company email" name="email" value="">
                                </div>
                            </div>
                        </div>
                    </div>



                </div>

                <div class="row p-2">
                    <div class="col-md-12">
                        <label class="labels">Agency Type</label>
                        <select name="agency_id" class="form-control" name="total_employees">
                            <option selected>Marketing Agency</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>

                <div class="row p-2">
                    <div class="col-md-12"><label class="labels">Email ID</label><input type="text" class="form-control"
                            placeholder="email id" name="name" value=""></div>
                    <p class="m-3" style="color:#4046DD;font-weight:500;"> + Add New</p>
                </div>

                <div class="row p-2">
                    <div class="col-md-12"><label class="labels">Contact</label><input type="text" class="form-control"
                            placeholder="contact" name="name" value=""></div>
                  
                </div>
                <div class="row p-2">
                    <div class="col-md-12"><label class="labels">Address</label><input type="text" class="form-control"
                            placeholder="address" name="name" value=""></div>
                  
                </div>

<div class="flex mt-5 mb-3 me-auto">
          
                <button type="button" class="btn btn-primary convert" data-toggle="modal" data-target="#myModal" style="width:45%;">Cancel</button>
                <button type="button" class="btn btn-primary save" data-toggle="modal" data-target="#myModal"style="width:45%;">Save</button>
</div>

  </div>
</div>
</div>

@endsection