@extends('layouts.master')

@section('content')


<!-- {{-- EditModal --}} -->

<div class="modal fade" id="Edit_Vehicle_Modal" class="modal-backdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Vehicle</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

       <ul id="updateform_errlist"></ul>

       <ul id="saveform_errlist"></ul>

      <form id="UpdateVehicleForm" method="POST" enctype="multipart/form-data">
       <input type="hidden" name="id" id="edit_id"> 
       <input type="hidden" name="emp_photo" class="emp_photo" id="emp_photo"> 

       
       <div class="form-group mb-3">
        <label for="">Vehicle Name: </label>
        <input type="text" name="vehicle_name" value="{{ old('vehicle_name')}}" class="vehicle_name form-control"> 
      </div>

      <div class="form-group mb-3">
        <label for="">Vehicle Registration Number: </label>
        <input type="text" name="vehicle_registration_number" value="{{ old('vehicle_registration_number')}}" class="vehicle_registration_number form-control"> 
      </div>

      <div class="form-group mb-3">
        <label for="">Vehicle Number Of Seats: </label>
        <input type="text" name="vehicle_number_of_seats" value="{{ old('vehicle_number_of_seats')}}" class="vehicle_number_of_seats form-control"> 
      </div>

      <div class="form-group mb-3">
        <label for="">Driver: </label>   

        <select class="form-control selectpicker driver_name" name="driver_name" id="driver_name">
          @foreach($dataa as $data)
          <option value="{{ $data->name }}">{{ $data->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group mb-3">
        <label for="">Vehicle Category: </label>
        <input type="text" name="vehicle_category" value="{{ old('vehicle_category')}}" class="vehicle_category form-control"> 
      </div>

      <div class="form-group mb-3">
        <label for="">Vehicle Picture: </label>
        <input type="file" name="photo" class="photo form-control" id="photo"> 
      </div>

      <div class="img">
  
      </div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary update_vehicle">Update</button>
      </div>
    </form>
    </div>
  </div>
</div>
<!-- {{-- End AssignRole&PermissionModal --}} -->


<div class="row">
  <div class="col-md-12">
          <div class="card">
              <div class="card-header">
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
                      <th>Action</th>
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
                {data: 'action', name: 'action', orderable: false, searchable: false},
              ],

        // columnDefs: [ 
        //     {
        //       targets: 3,
        //       render: function( data ) {
        //         return '<span class="badge badge-primary">' +data+ '</span>';
        //       }
        //     }
        // ]
      });


    
   // <!-- {{-- EditDriver Button --}} -->

   $(document).on('click', '.edit_vehicle', function (e) {

     e.preventDefault();

  
        var vehicle_id = $(this).val();

          console.log(vehicle_id);

          $('#Edit_Vehicle_Modal').modal('show');

          $.ajax({
            type: "get",
            url: "/vehicles/edit/"+vehicle_id,
            dataType: "json",
            success: function (response) {

            console.log(response);

                $('.img').html("");

                $(".img").append(`<img src="/assets/img/${response.vehicle.photo}"  class="img-fluid elevation-2" alt="User Image">`);

                $('.vehicle_name').val(response.vehicle.vehicle_name);
                $('.vehicle_registration_number').val(response.vehicle.vehicle_registration_number);
                $('.vehicle_number_of_seats').val(response.vehicle.vehicle_number_of_seats);
                $('.driver_name').val(response.vehicle.driver_name).change();
                $('.vehicle_category').val(response.vehicle.vehicle_category);
          
                $('#edit_id').val(vehicle_id);

            }

        });

     });

    // <!-- {{-- EditDriver Button --}} -->

    $(document).on('submit', '#UpdateVehicleForm', function (e) {

      e.preventDefault();
            var vehicle_id = $('#edit_id').val();

            // var data = {
            //     'vehicle_name' : $('#vehicle_name').val(),
            //     'vehicle_registration_number' : $('#vehicle_registration_number').val(),
            //     'vehicle_number_of_seats' : $('#vehicle_number_of_seats').val(),
            //     'driver_name' : $('#driver_name').val(),
            //     'vehicle_category' : $('#vehicle_category').val(),
                
            // }

            let formData = new FormData($('#UpdateVehicleForm')[0]);
              
            $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

            $.ajax({
              type: "POST",
              url: "/vehicles/update_vehicle/"+vehicle_id,
              data: formData,
              contentType: false,
              processData: false,
              success: function (response) {

                // console.log(response);
              
                if(response.status == 400){
                  $('#updateform_errlist').html("");
                  $('#updateform_errlist').addClass('alert alert-danger');
                  $.each(response.errors, function (key, err_values){
                    $('#updateform_errlist').append('<li>'+err_values+'</li>');
                });

              }else if(response.status == 404){
                  $('#updateform_errlist').html("");
                  $('#success_message').addClass('alert alert-success');
                  $('#success_message').text(response.message);

                }else{

                  $('#photo').val('');

                  $('#Edit_Vehicle_Modal').modal('hide');
        
                  $('.vehicle_datatable').DataTable().ajax.reload();
                
                  Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Record has successfully Updated',
                  showConfirmButton: true,
                  timer: 2500
                  });

                  
                  
            }

          }
        });

      });

      // Update



      // DELETE

      $(document).on('click', '.delete_vehicle', function (e){

        var vehicle_id = $(this).val();

        // console.log(driver_id);

          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Delete record!'

          }).then((result) => {
            if (result.value) {
              $.ajax({
                url: "/vehicles/delete_vehicle/" +vehicle_id,
                method: "get",
                data: {_token: "{{ csrf_token() }}", vehicle_id: vehicle_id},
                success: function(response){
                  console.log(response);
                  if(response.success)
                  {
                    Swal.fire(
                      'Deleted!',
                      'Record has been deleted.',
                      'success'
                    );
                    
                  }

                  Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Record has successfully Deleted',
                  showConfirmButton: true,
                  timer: 2500
                  });

                  $('.vehicle_datatable').DataTable().ajax.reload();

                },
                error: function(response){
                  console.log(response);
                }
              });

            }
          });
     
      });

      // DELETE

    });



</script>

    
@endsection


