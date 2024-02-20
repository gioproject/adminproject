@extends('layouts.master')

@section('content')

<div class="row ">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>150</h3>
        <p>Users</p>
      </div>
      <div class="icon">
       <i class="ion ion-android-people"></i>
      </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>

<div class="col-lg-3 col-6">
  <div class="small-box bg-success">
    <div class="inner">
      <h3>150</h3>
      <p>Drivers</p>
    </div>
    <div class="icon">
     <i class="ion ion-person"></i>
    </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>

<div class="col-lg-3 col-6">
  <div class="small-box bg-warning">
    <div class="inner">
      <h3>150</h3>
      <p>Vehicles</p>
    </div>
    <div class="icon">
      <i class="ion ion-android-car"></i>
    </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>

<div class="col-lg-3 col-6">
  <div class="small-box bg-secondary">
    <div class="inner">
      <h3>150</h3>
      <p>Bookings</p>
    </div>
    <div class="icon">
  
     <i class="ion ion-ios-list-outline"></i>
    </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>
  
<div class="row">
  <div class="col-md-12">
          <div class="card ">
              <div class="card-header">
                <h1 class="card-title mb-2">List of Vehicles</h1>
       <div id="success_message"></div>

          <table class="table table-bordered vehicle_datatable">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Vehicle Name</th>
                      <th>Rec No.</th>
                      <th>Seats</th>
                      <th>Driver</th>
                      <th>Vehicle Category</th>
                      <th>Status</th>
                  </tr>
              </thead>
              <tbody>
            
              </tbody>
          </table>
      </div>
  </div>
</div>

@endsection

@section('scripts');

<script>

  $(document).ready(function (){

      var table = $('.vehicle_datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{{route("manage_vehicles.index")}}',
          columns: [
                      {data: 'id', name: 'id'},
                      {data: 'vehicle_name', name: 'vehicle_name'},   
                      {data: 'vehicle_registration_number', name: 'vehicle_registration_number'},
                      {data: 'vehicle_number_of_seats', name: 'vehicle_number_of_seats'},    
                      {data: 'driver_name', name: 'driver_name'}, 
                      {data: 'vehicle_category', name: 'vehicle_category'}, 
                      {data: 'status', name: 'status'}, 
                    ],

              columnDefs: [ 
                  {
                    targets: 6,
                    render: function( data ) {
                      return '<span class="badge badge-success">' +data+ '</span>';
                    }
                  }
                ]
            });

          });

</script>

    
@endsection
