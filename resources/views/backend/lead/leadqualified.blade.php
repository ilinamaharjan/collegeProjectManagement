@extends('backend.layouts.app')

@section('content')
<a href="{{ route('lead.index') }}"><button type="button" class="btn btn-primary convert mb-1"><i class="fa fa-arrow-left" aria-hidden="true">  Back</i></button></a>
<div class="d-flex bd-highlight mb-3">
    <div class="align-self-center">
       
    </div>
    <div class="align-self-center mr-auto p-2 bd-highlight">

  <input placeholder="Select date" type="date" id="example_date" class="form-control"> 


      <!-- <form>
        <div class="form-group">
          <div class="datepicker date input-group">
          
            <div class="input-group-append">
              <span class="input-group-text"style=" border-radius:50px; padding:14px;"><i class="fa fa-calendar"></i></span>
              <div class="p-2">Created at <span class="p-2"> <b> 01 Aug, 2023 </b></span></div>
            </div>
          </div>
        </div>
</form> -->
    </div>

    <div class="p-2 bd-highlight"> <button type="button" class="btn btn-primary convert"><i class="fa fa-exchange"
                aria-hidden="true"></i>Convert</button></div>
    <div class="p-2 bd-highlight"> <button type="button" class="btn btn-primary qualified"><i class="fa fa-arrow-down"
                aria-hidden="true"></i>QUALIFIED</button></div>
</div>



<div class="bg-section">
    <div class="row" style="border-bottom:1px solid #eaeaea;">
        <div class="col-md-3">

            <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <img src="backend/images/avatar-1.jpg" id="imageDiv" class="img-fluid customImage" alt=""
                        style="border-radius:50%;height:50px; width:50px; border:3px solid #4DB5D6!important;">
                </div>
                <div class="align-self-center p-3 bd-highlight">
                    <h6>Jonny Deo</h6>
                    <span class="profile-sec"> Email@gmail.com | 98000000000 </span>
                </div>
            </div>

        </div>

        <div class="col-md-3">

            <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <i class="fa fa-building profile" aria-hidden="true"></i>
                </div>
                <div class="align-self-center p-3 bd-highlight">
                    <h6 class="profile-sec">Jonny Deo</h6>
                    Global Equity

                </div>
            </div>

        </div>

        <div class="col-md-3">


            <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <i class="fa fa-building profile" aria-hidden="true"></i>
                </div>
                <div class="align-self-center p-3 bd-highlight">
                    <h6 class="profile-sec">Job Title</h6>
                    Global Equity

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <i class="fa fa-building profile" aria-hidden="true"></i>
                </div>
                <div class="align-self-center p-3 bd-highlight">
                    <h6 class="profile-sec">Owner</h6>
                    Global Equity

                </div>
            </div>
        </div>

    </div>


    <ul class="nav nav-tab" role="tablist" style="border-bottom:1px solid #eaeaea;">
	<li class="nav-item">
		<div class="nav-link" data-toggle="tab" href="#tabs-1" role="tab">
            <div style="border-right:1px solid #eaeaea;">
        <i class="fa fa-building profile"
                aria-hidden="true"></i> <span class="p-2">Activity</span></div>
</div>
    </li>
    
	<li class="nav-item">
		<div class="nav-link active" data-toggle="tab" href="#tabs-2" role="tab">
        <div style="border-right:1px solid #eaeaea;">
        <i class="fa fa-building profile"
                aria-hidden="true"></i> <span class="p-2">File</span></div>
</div>
    </li>
    
	<li class="nav-item">
		<div class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">
        <div style="border-right:1px solid #eaeaea;">
             <i class="fa fa-building profile"
                aria-hidden="true"></i> <span class="p-2">Invoice</span></div>
</div>
    </li>
    
     
	<li class="nav-item">
		<div class="nav-link" data-toggle="tab" href="#tabs-4" role="tab">
        <div style="border-right:1px solid #eaeaea;">
             <i class="fa fa-building profile"
                aria-hidden="true"></i> <span class="p-2">Mail</span></div>
</div>
	</li>
</ul>

<!-- Tab panes -->
<div class="tab-content mt-5">
	<div class="tab-pane active" id="tabs-2" role="tabpanel">

           
    <div class="d-flex bd-highlight mb-3">
  <div class="mr-auto p-2 bd-highlight"><h6 class="profile-sec">Aggrement List</h6></div>
  <div class="p-2 bd-highlight">
 
                <i class="fa fa-trash profile" aria-hidden="true"></i>
  <i class="fa fa-arrow-down profile" aria-hidden="true"> </i>
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
  <div class="mr-auto p-2 bd-highlight"><h6 class="profile-sec">Aggrement List</h6></div>
  <div class="p-2 bd-highlight">
 
                <i class="fa fa-trash profile" aria-hidden="true"></i>
  <i class="fa fa-arrow-down profile" aria-hidden="true"> </i>
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
		
  <div class="row">
        <div class="col-md-4">
            <div class="card mt-3">
                <div class="card-body p-3" style="border: 1px solid #eaeaea;border-radius: 5px;">
                    <div class="d-flex bd-highlight">
                        <div class="p-2 w-100 bd-highlight">
                            <h5 class="card-title">Special title treatment</h5>
                        </div>
                        <div class="p-2 flex-shrink-1 bd-highlight"><input class="form-check-input" type="checkbox"
                                id="inlineCheckbox1" value="1"></div>
                    </div>



                    <i class="fa fa-building profile mt-3" aria-hidden="true"></i> <span class="p-2">15 Nov 2020</span>

                </div>
            </div>


        </div>
        <div class="col-md-4">
            <div class="card mt-3">
                <div class="card-body p-3" style="border: 1px solid #eaeaea;border-radius: 5px;">
                    <div class="d-flex bd-highlight">
                        <div class="p-2 w-100 bd-highlight">
                            <h5 class="card-title">Special title treatment</h5>
                        </div>
                        <div class="p-2 flex-shrink-1 bd-highlight"><input class="form-check-input" type="checkbox"
                                id="inlineCheckbox1" value="1"></div>
                    </div>



                    <i class="fa fa-building profile mt-3" aria-hidden="true"></i> <span class="p-2">15 Nov 2020</span>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mt-3">
                <div class="card-body p-3" style="border: 1px solid #eaeaea;border-radius: 5px;">
                    <div class="d-flex bd-highlight">
                        <div class="p-2 w-100 bd-highlight">
                            <h5 class="card-title">Special title treatment</h5>
                        </div>
                        <div class="p-2 flex-shrink-1 bd-highlight"><input class="form-check-input" type="checkbox"
                                id="inlineCheckbox1" value="1"></div>
                    </div>



                    <i class="fa fa-building profile mt-3" aria-hidden="true"></i> <span class="p-2">15 Nov 2020</span>

                </div>
            </div>
           


        </div>
  </div>
</div>
	<div class="tab-pane" id="tabs-3" role="tabpanel">
		<p>Third Panel</p>
    </div>
    
    <div class="tab-pane" id="tabs-4" role="tabpanel">
		<p>4 Panel</p>
	</div>
</div>

<!--  -->
<!-- 
    <div class="d-flex flex-row bd-highlight align-self-center mb-3 mt-1 p-3" style="border-bottom:1px solid #eaeaea;">
        <div class="p-3 bd-highlight" style="border-right:1px solid #eaeaea;"> <i class="fa fa-building profile"
                aria-hidden="true"></i> <span class="p-2">Activity</span></div>

        <div class="p-3 bd-highlight file" style="border-right:1px solid #eaeaea;"> <i class="fa fa-building profile"
                aria-hidden="true"></i> <span class="p-2">File</span></div>

        <div class="p-3 bd-highlight" style="border-right:1px solid #eaeaea;"> <i class="fa fa-building profile"
                aria-hidden="true"></i> <span class="p-2">Invoice</span></div>

        <div class="p-3 bd-highlight" style="border-right:1px solid #eaeaea;"> <i class="fa fa-building profile"
                aria-hidden="true"></i> <span class="p-2">Invoice</span></div>
    </div>


           
<div class="d-flex bd-highlight mb-3">
  <div class="mr-auto p-2 bd-highlight"><h6 class="profile-sec">Aggrement List</h6></div>
  <div class="p-2 bd-highlight">
 
                <i class="fa fa-trash profile" aria-hidden="true"></i>
  <i class="fa fa-arrow-down profile" aria-hidden="true"> </i>
            </div>
  <div class="p-2 bd-highlight">
  <form>
        <div class="form-group">
          <div class="datepicker date input-group">
          
            <div class="input-group-append">
              <span class="input-group-text"style=" border-radius:50px; padding:14px;"><i class="fa fa-calendar"></i></span>
              <div class="p-2">Uploaded <span class="p-2"> <b> 01 Aug, 2023 </b></span></div>
            </div>
          </div>
        </div>
</form>

  </div>
</div>

<hr>

           
<div class="d-flex bd-highlight mb-3">
  <div class="mr-auto p-2 bd-highlight"><h6 class="profile-sec">Aggrement List</h6></div>
  <div class="p-2 bd-highlight">
 
                <i class="fa fa-trash profile" aria-hidden="true"></i>
  <i class="fa fa-arrow-down profile" aria-hidden="true"> </i>
            </div>
  <div class="p-2 bd-highlight">
  <form>
        <div class="form-group">
          <div class="datepicker date input-group">
          
            <div class="input-group-append">
              <span class="input-group-text"style=" border-radius:50px; padding:14px;"><i class="fa fa-calendar"></i></span>
              <div class="p-2">Uploaded <span class="p-2"> <b> 01 Aug, 2023 </b></span></div>
            </div>
          </div>
        </div>
</form>

  </div>
</div> -->
        
            
        
    <div class="row">
    

        <textarea class="form-control form-control-sm mb-3 p-3 m-3" rows="3" placeholder="Textarea" style="background-color:#FCFBFB;"></textarea>
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

 <button type="button" class="btn btn-primary lead" data-toggle="modal" data-target="#myModal">
       <i class="fa fa-plus" aria-hidden="true"></i> Add Lead
    </button> 
</div>

</div>

<script>
    $(function () {
  $('.datepicker').datepicker({
    language: "es",
    autoclose: true,
    format: "dd/mm/yyyy"
  });
});

    </script>



    @endsection
