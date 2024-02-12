@extends('layouts.master')

@section('content')


<div class="modal fade" id="AddPermissionModal" class="modal-backdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Permission</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

       <ul id="saveform_errlist"></ul>


       <div class="form-group mb-3">
        <label for="">Post Name</label>
        <input type="text" id="input_permission" class="input_permission form-control">
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_permission">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- {{-- End- AddPermissionModal --}} -->


{{-- Delete RoleModal --}}

<div class="modal fade" id="DeletePermissionModal" class="modal-backdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Permission</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

       
        <input type="hidden" id="delete_permission_id">

        <h4>You Sure You want to delete ?</h4>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary delete_permission_btn">Yes Delete</button>
      </div>
    </div>
  </div>
</div>

{{-- End- DeleteRoleModal --}}


  <div class="row">
    <div class="col-md-12">
            <div class="card">
                <div class="card-header">
          
         <div id="success_message"></div>

            <h1 class="card-title"> Manage Permissions </h1>
            <a href="" data-bs-toggle="modal" data-bs-target="#AddPermissionModal" class="btn btn-dark mb-2 ml-2"><i class="bi bi-plus-square"></i> CREATE</a>
            <table class="table table-bordered permission_datatable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  {{-- @foreach ($permissions as $permission)
                      <tr>
                        <td>
                          {{ $permission->name}}
                        </td>
                        <td>
                        <a href="" class="btn btn-primary">Edit</a>
                        <a href="" class="btn btn-danger">Delete</a>
                      </td>
                      </tr>
                  @endforeach --}}
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



      
      var table = $('.permission_datatable').DataTable({
           processing: true,
           serverSide: true,
           ajax: '{{route("permissions.index")}}',
           columns: [
                  
                      {data: 'name', name: 'name'},
                      {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
            });


          $(document).on('click','.add_permission', function (e) {
          e.preventDefault();


         
               var data = {
                'name': $('#input_permission').val(),
                }

                // console.log(data);

                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });


                $.ajax({  
                type: "post",
                url: '{{route("permissions.store")}}',
                data: data,
                dataType: "json",
                success: function (response) {
                    // console.log(response);

                    if(response.status == 400){
                    $('#saveform_errlist').html("");
                    $('#saveform_errlist').addClass('alert alert-danger');
                    $.each(response.errors, function (key, err_values) { 

                        $('#saveform_errlist').append('<li>'+err_values+'</li>');

                    });
                    } 
                    else {
                        $('#saveform_errlist').html("");
                        $('#success_message').addClass("alert alert-success");
                        $('#success_message').text(response.message);
                        $('#AddPermissionModal').modal('hide');
                        $('.modal-backdrop').remove();
                        $('#AddPermissionModal').find('input').val("");

                     
                                setTimeout(function() {
                                $('#success_message').fadeOut().text('')
                                }, 5000 );
                                $('#success_message').fadeIn().delay(5000).fadeOut();

                                $('.permission_datatable').DataTable().ajax.reload();

                              

                          }
                    
                   }
                });

             });


                  // DELETE Permission

    $(document).on('click','.delete_permission', function (e) {
       e.preventDefault();

            var permission_id = $(this).val();
            // alert(stud_id);
            $('#delete_permission_id').val(permission_id);
            $('#DeletePermissionModal').modal('show')
          });

        $(document).on('click','.delete_permission_btn', function (e) {
          e.preventDefault();
          
          var permission_id = $('#delete_permission_id').val();

          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });

              $.ajax({
                type: "get",
                url: '/permissions/delete/'+permission_id,
                success: function (response) {

                  // console.log(response);
                  $('#success_message').addClass('alert alert-success');
                  $('#success_message').text(response.message);
                  $('#DeletePermissionModal').modal('hide');
                  $('.modal-backdrop').remove();
                  
                 
                  $('.permission_datatable').DataTable().ajax.reload();

              
                         setTimeout(function() {
                         $('#success_message').fadeOut().text('')
                         }, 5000 );
                          $('#success_message').fadeIn().delay(5000).fadeOut();
            }
        });

      });

      // End- DELETE Permission
      
 

    });
  
    
</script>

    
@endsection
