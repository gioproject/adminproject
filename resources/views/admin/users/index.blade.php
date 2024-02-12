@extends('layouts.master')

@section('content')


<!-- {{-- AssignRole&PermissionModal --}} -->

<div class="modal fade" id="Assign_Role_Permission_Modal" class="modal-backdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Role</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

       <ul id="saveform_errlist"></ul>

       <input type="hidden" id="edit_input_user_id"> 


       <div class="form-group mb-3">
        <label for="">User Name: </label>
        <input type="text" id="edit_input_user_name" disabled class="edit_input_role form-control"> 
      </div>
      
      <div class="form-group mb-3">
        <label for="">User Email: </label>
        <input type="text" id="edit_input_email" disabled class="edit_input_role form-control"> 
      </div>
      

      <div class="container">
       <div class="row">
        <form>
          <label>Roles</label>
          <select class="form-control selectpicker" multiple data-live-search="true" id="role_name">
            @foreach($roles as $role)
            <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
          </select>
        </form>
        </div>
      </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary assign_role_to_user">Assign</button>
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

          <h1 class="card-title"> Users</h1>
          <table class="table table-bordered users_datatable">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Name</th>
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

   
      
var table = $('.users_datatable').DataTable({
     processing: true,
     serverSide: true,
     ajax: '{{route("users.index")}}',
     columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
      });

    
    
      $(document).on('click','.assign_role_permission', function (e) {
          e.preventDefault();


              var user_id = $(this).val();

              $('#edit_input_user_id').val(user_id);
              
              $('#Assign_Role_Permission_Modal').modal('show');


             $.ajax({
            type: "get",
            url: '/users/user/'+user_id,
            dataType: "json",
            success: function (response) {

          //  console.log(response);
      
        
          if(response.status == 404){
            $('#success_message').htm("");
            $('#success_message').addClass('alert alert-danger');
            $('#success_message').text(response.message);

          }else{
          
              $('#edit_input_user_name').val(response.user.name);
              $('#edit_input_email').val(response.user.email);

          }
        }

      });

    });

    //Click Edit
    // $('#btn-add-permission').click(function(e){
    //   $('#btn-save').attr('disabled', false);
    //   $('#permissionform')[0].reset();
    //   $('.modal-title').empty().append('Add permission');
    //   action_type = 'add'
    // });


     $(document).on('click','.assign_role_to_user', function (e) {
          e.preventDefault();
          


              var user_id = $('#edit_input_user_id').val();

              var role_names = [];

              var role_names = $('#role_name').val();

              var data = {
                'user_id' : user_id,
                'role_name': role_names,
                }

                console.log(user_id);
                console.log(data);

              $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });

            $.ajax({
            type: "post",
            url: '/users/userr',
            dataType: "json",
            data: data,
            success: function (response) {

            console.log(response);


                 $('#saveform_errlist').html("");
                 $('#success_message').addClass("alert alert-success");
                 $('#success_message').text(response.message);
                 $('#Assign_Role_Permission_Modal').modal('hide');
                 $('.modal-backdrop').remove();
                 $('#Assign_Role_Permission_Modal').find('input').val("");

                     
                 setTimeout(function() {
                 $('#success_message').fadeOut().text('')
                 }, 5000 );
                 $('#success_message').fadeIn().delay(5000).fadeOut();

                
                 $('#role_name').val('').trigger('change');
      
        
      //   if(response.status == 404){
      //    $('#success_message').htm("");
      //    $('#success_message').addClass('alert alert-danger');
      //    $('#success_message').text(response.message);

      //  }else{
          
      //   $('#edit_input_user_name').val(response.user.name);
      //   $('#edit_input_email').val(response.user.email);
      //   }
       }

        
        
      });

    });

    

   });
</script>

    
@endsection


