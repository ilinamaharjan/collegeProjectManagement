@extends('backend.layouts.app')

@section('content')

<div class="row">
    <ul class="nav nav-tab" role="tablist" style="border-bottom:1px solid #eaeaea;">
        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-1" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <span class="contract-detail p-2">All Document</span></div>
            </div>
        </li>

        <li class="nav-item">
            <div class="nav-link active" data-toggle="tab" href="#tabs-2" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <span class="contract-detail p-2">Quatations</span></div>
            </div>
        </li>

        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <span class="contract-detail p-2">Proposal</span></div>
            </div>
        </li>


        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-4" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <span class="contract-detail p-2">Other Documents</span></div>
            </div>
        </li>
    </ul>

    <div class="ml-auto">
        <button type="button" class="btn btn-primary convert"><i class="fa fa-exchange"
                aria-hidden="true"></i>Convert</button>

        <button type="button" class="btn btn-primary contract">Manage</button>
    </div>

</div>

<!-- Tab panes -->
<div class="bg-section mt-3 mb-5">
    <div class="tab-content">
        <div class="tab-pane active" id="tabs-2" role="tabpanel">

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

        <hr>


        <div class="tab-pane" id="tabs-1" role="tabpanel">

            fffffffffffffffffffff
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

<div class="d-flex flex-row-reverse bd-highlight">

 <button type="button" class="btn btn-primary lead" data-toggle="modal" data-target="#myModal" style="margin-top:-45px;">
       <i class="fa fa-plus" aria-hidden="true"></i>DOC
</div>

@endsection
