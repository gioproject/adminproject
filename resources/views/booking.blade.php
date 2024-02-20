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
        <button type="button" class="btn btn-primary add_driver">Save</button>
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

       
       <h1 class="card-title">Driver List</h1>
      

          <table class="table table-bordered drivers_datatable">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Contact</th>
                      <th>Address</th>
                      <th>Email</th>
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

   
      
var table = $('.drivers_datatable').DataTable({
     processing: true,
     serverSide: true,
     ajax: '{{route("drivers.index")}}',
     columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'contact', name: 'contact'},
                {data: 'address', name: 'address'},
                {data: 'email', name: 'email'},
              
              ]
      });

    });


</script>

    
@endsection


