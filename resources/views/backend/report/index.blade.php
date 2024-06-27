@extends('backend.layouts.app')

@section('content')



<div class="d-flex bd-highlight mb-3">
    <div class="align-self-center"><h5><b>Analytics</b></h5></div>
  <div class="mr-auto p-2 bd-highlight">
      
</div>
<div class=" p-2 bd-highlight"> <button type="button" class="btn btn-primary convert">Today <i class="fa fa-angle-down"></i></button></div>
  <div class="p-2 bd-highlight"> <button type="button" class="btn btn-primary convert">Manage </button></div>
</div>


<div class="row">
    <!-- task, page, download counter  start -->
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">

                <div class="d-flex bd-highlight mb-3">
                    <div class="p-2 bd-highlight"> <i class="fa fa-user f-28 ds-icon"></i></div>
                    <div class="p-2 bd-highlight"><span class="ds-list">No. of Deals</span></div>
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
                    <div class="p-2 bd-highlight"> <i class="fa fa-users f-28 ds-icon1"></i></div>
                    <div class="p-2 bd-highlight"><span class="ds-list">Open Deals</span></div>
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
                    <div class="p-2 bd-highlight"> <i class="fa fa-calendar-o f-28 ds-icon3"></i></div>
                    <div class="p-2 bd-highlight"><span class="ds-list">Win</span></div>
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
                    <div class="p-2 bd-highlight"> <i class="fa fa-money f-28 ds-icon3"></i></div>
                    <div class="p-2 bd-highlight"><span class="ds-list">Revenue</span></div>
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
    <div class="section">
<h6>Analytics</h6>
    <canvas id="myChart" style="width:100%;max-width:600px;background-color:white;padding:20px;border-radius:15px;"></canvas>
</div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <script>
var xValues = ["Marketing", "Sales", "SEO", "Information"];
var yValues = [55, 49, 44, 24, 15];
var barColors = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#e8c3b9",
  "#1e7145"
];

new Chart("myChart", {
  type: "doughnut",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Service Sale"
    }
  }
});
</script>

@endsection