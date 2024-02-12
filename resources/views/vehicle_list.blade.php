@extends('layouts.master')

@section('content')


<!-- {{-- AssignRole&PermissionModal --}} -->

<div class="modal fade" id="Drivers_Modal" class="modal-backdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Driver</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

       <ul id="saveform_errlist"></ul>

       <input type="hidden" id="edit_input_user_id"> 


       <div class="form-group mb-3">
        <label for="">Driver Name: </label>
        <input type="text" id="name"  class="name form-control"> 
      </div>

      <div class="form-group mb-3">
        <label for="">Contact: </label>
        <input type="text" id="contact"  class="contact form-control"> 
      </div>

      <div class="form-group mb-3">
        <label for="">Address: </label>
        <input type="text" id="address"  class="address form-control"> 
      </div>
      
      <div class="form-group mb-3">
        <label for="">Email: </label>
        <input type="text" id="email"  class="email form-control"> 
      </div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_vehicle">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- {{-- End AssignRole&PermissionModal --}} -->


<div class="row">
  <div class="col-md-12">
          <div class="card">
              <div class="card-header">
        
       <div id="success_message"></div>       
       <h1 class="card-title">Vehicle List</h1>
      
          <table class="table table-bordered vehicles_datatable">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Vehicle Name</th>
                      <th>Vehicle Number Of Seats</th>
                      <th>Driver Name</th>
                      <th>Vehicle Category</th>
               
                
                  </tr>
              </thead>
              <tbody>
            
              </tbody>
          </table>
      </div>
  </div>
</div>


</div>
</div>




@endsection


@section('scripts');


<script>

  $(document).ready(function (){

   
      
var table = $('.vehicles_datatable').DataTable({
     processing: true,
     serverSide: true,
     ajax: '{{route("vehicles.index")}}',
     columns: [
                {data: 'id', name: 'id'},
                {data: 'vehicle_name', name: 'vehicle_name'},    
                {data: 'vehicle_number_of_seats', name: 'vehicle_number_of_seats'},    
                {data: 'driver_name', name: 'driver_name'}, 
                {data: 'vehicle_category', name: 'vehicle_category'}, 
          
              ]
      });

    });


</script>

    
@endsection


