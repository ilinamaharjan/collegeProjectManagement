
@extends('backend.layouts.app')

@section('content')

<div class="d-flex bd-highlight mb-3">
    <div class="align-self-center"><h5><b>Campaign</b></h5></div>
  <div class="mr-auto p-2 bd-highlight">
      
</div>
<div class=" p-2 bd-highlight"> <button type="button" class="btn btn-primary convert">Today <i class="fa fa-angle-down"></i></button></div>
  <div class="p-2 bd-highlight"> <button type="button" class="btn btn-primary convert">Manage</button></div>
</div>




<ul class="nav nav-tab" role="tablist" style="border-bottom:1px solid #eaeaea;">
	<li class="nav-item">
		<div class="nav-link" data-toggle="tab" href="#tabs-1" role="tab">
            <div style="border-right:1px solid #eaeaea;">
         <span class="p-2 campaign">All Campaign</span></div>
</div>
    </li>
    
	<li class="nav-item">
		<div class="nav-link active" data-toggle="tab" href="#tabs-2" role="tab">
        <div style="border-right:1px solid #eaeaea;">
       <span class="p-2 campaign">Campaign Catagories 1</span></div>
</div>
    </li>
    
	<li class="nav-item">
		<div class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">
        <div style="border-right:1px solid #eaeaea;">
        <span class="p-2 campaign">Campaign Catagories 2</span></div>
</div>
    </li>
    
  
</ul>

<!-- Tab panes -->
<div class="tab-content mt-3 mb-5" style="background-color:white; padding:20px;border-radius:5px;">
	<div class="tab-pane active" id="tabs-2" role="tabpanel">

           
    <div class="d-flex bd-highlight mb-3">
  <div class="mr-auto p-2 bd-highlight"><h6><b>Text Campaign List</b></h6><p>Text Campaign ListText Campaign ListText Campaign ListText Campaign List</p></div>
  <div class="p-2 bd-highlight">
 
  <span class="badge badge-pill badge-success" style="margin-top:14px;">Completed</span>
            </div>
  <div class="p-2 bd-highlight">
  <!-- <form>
        <div class="form-group">
          <div class="datepicker date input-group">
          
            <div class="input-group-append">
              <span class="input-group-text"style=" border-radius:50px; padding:14px;"><i class="fa fa-calendar"></i></span>
              <div class="p-2">Uploaded <span class="p-2"> <b> 01 Aug, 2023 </b></span></div>
            </div>
          </div>
        </div>
</form> -->
<div class="p-2">Uploaded <span class="p-2"> <b> 01 Aug, 2023 </b></span></div>
  </div>
</div>

<hr>

           
<div class="d-flex bd-highlight mb-3">
  <div class="mr-auto p-2 bd-highlight"><h6><b>Text Campaign List</b></h6><p>Text Campaign ListText Campaign ListText Campaign ListText Campaign List</p></div>
  <div class="p-2 bd-highlight">
  <span class="badge badge-pill badge-danger" style="margin-top:14px;">Pending</span>
            </div>
  <div class="p-2 bd-highlight">
  <!-- <form>
        <div class="form-group">
          <div class="datepicker date input-group">
          
            <div class="input-group-append">
              <span class="input-group-text"style=" border-radius:50px; padding:14px;"><i class="fa fa-calendar"></i></span>
              <div class="p-2">Uploaded <span class="p-2"> <b> 01 Aug, 2023 </b></span></div>
            </div>
          </div>
        </div>
</form> -->
<div class="p-2">Uploaded <span class="p-2"> <b> 01 Aug, 2023 </b></span></div>
  </div>
</div>
	</div>
	<div class="tab-pane" id="tabs-1" role="tabpanel">
	ssss
</div>
	<div class="tab-pane" id="tabs-3" role="tabpanel">
		<p>Third Panel</p>
    </div>
    
    <div class="tab-pane" id="tabs-4" role="tabpanel">
		<p>4 Panel</p>
	</div>
</div>



<nav aria-label="Page navigation example mt-5">
  <ul class="pagination justify-content-center mt-5">
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

 <button type="button" class="btn btn-primary lead" data-toggle="modal" data-target="#myModal">
       <i class="fa fa-plus" aria-hidden="true"></i> Add
    </button> 
</div>


@endsection