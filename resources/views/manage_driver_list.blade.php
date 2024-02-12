@extends('layouts.master')

@section('content')


<!-- {{-- EditModal --}} -->

<div class="modal fade" id="Edit_Driver_Modal" class="modal-backdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Driver</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

       <ul id="updateform_errlist"></ul>

       <ul id="saveform_errlist"></ul>

       <input type="hidden" id="edit_id"> 

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
        <button type="button" class="btn btn-primary update_driver">Update</button>
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

          <table class="table table-bordered drivers_datatable">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Contact</th>
                      <th>Address</th>
                      <th>Email</th>
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


  
    var table = $('.drivers_datatable').DataTable({
     processing: true,
     serverSide: true,
     ajax: '{{route("manage_drivers.index")}}',
     columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'contact', name: 'contact'},
                {data: 'address', name: 'address'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
      });


    
   // <!-- {{-- EditDriver Button --}} -->

   $(document).on('click', '.edit_driver', function (e) {

     e.preventDefault();

    

        var driver_id = $(this).val();

          console.log(driver_id);

          $('#Edit_Driver_Modal').modal('show');

          $.ajax({
            type: "get",
            url: "/drivers/edit/"+driver_id,
            dataType: "json",
            success: function (response) {

            // console.log(response);

            

                $('#name').val(response.driver.name);
                $('#contact').val(response.driver.contact);
                $('#address').val(response.driver.address);
                $('#email').val(response.driver.email);
                $('#edit_id').val(driver_id);
                

            }

        });

     });

    // <!-- {{-- EditDriver Button --}} -->


    // UPDATE 

    $(document).on('click', '.update_driver', function (e) {

      e.preventDefault();
            var driver_id = $('#edit_id').val();

            var data = {
                'name' : $('#name').val(),
                'contact' : $('#contact').val(),
                'address' : $('#address').val(),
                'email' : $('#email').val(),
            }

            $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

            $.ajax({
              type: "post",
              url: "/drivers/update_driver/"+driver_id,
              data: data,
              dataType: "json",
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
               
                  $('#Edit_Driver_Modal').modal('hide');
        
                  $('.drivers_datatable').DataTable().ajax.reload();

                  $('#updateform_errlist').text("");

                  $('#updateform_errlist').removeClass("alert alert-danger");


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

      $(document).on('click', '.delete_driver', function (e){

        var driver_id = $(this).val();

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
                url: "/drivers/delete_driver/" +driver_id,
                method: "get",
                data: {_token: "{{ csrf_token() }}", driver_id: driver_id},
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

                  $('.drivers_datatable').DataTable().ajax.reload();

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


