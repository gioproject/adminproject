@extends('layouts.master')

@section('content')




<div class="modal fade" id="AddRoleModal" class="modal-backdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Role</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

       <ul id="saveform_errlist"></ul>

{{-- @can('user-create')


@endcan --}}

       <div class="form-group mb-3">
        <label for="">Role Name</label>
        <input type="text" id="input_role" class="input_role form-control">
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_role">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- {{-- End- AddRoleModal --}} -->

{{-- Delete RoleModal --}}

<div class="modal fade" id="DeleteRoleModal" class="modal-backdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Role</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

       
        <input type="hidden" id="delete_role_id">

        <h4>You Sure You want to delete ?</h4>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary delete_role_btn">Yes Delete</button>
      </div>
    </div>
  </div>
</div>

{{-- End- DeleteRoleModal --}}

  {{-- Edit RoleModal --}}
  <div class="modal fade" id="EditRoleModal" class="modal-backdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Manage Role</h1>
          <button type="button" id="close_student_list_modal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
  
         <ul id="saveform_errlist"></ul>

         <input type="hidden" id="edit_role_id">
    

         <div class="form-group mb-3">
          <h1 class="card-title">Role Name</h1>
          <input type="text" id="edit_input_role" disabled class="edit_input_role form-control"> 
        </div>
        
        {{-- {{$role}} --}}
          {{-- @foreach ($role->permissions as $role_permissions)
              <spa>{{ $role_permission->name }}</spa>
          @endforeach
        @endif --}}



         <h1 class="card-title"> Permissions</h1><br><br>
      
         <table class="table table-bordered permission_list_datatable">
             <thead>
                 <tr>
                  <th width="1px"> <input type="checkbox" name="" id="select_all_ids"></th> 
                  <th>Name</th>
                 </tr>
             </thead>
             <tbody></tbody>
         </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary assign_role">Assign</button>
        </div>
      </div>
    </div>
  </div>
  
  {{-- End- EditRoleModal --}}



  <div class="row">
    <div class="col-md-12">
            <div class="card">
                <div class="card-header">
          
         <div id="success_message"></div>

            <h1 class="card-title"> Manage Roles</h1>
            <a href="" data-bs-toggle="modal" data-bs-target="#AddRoleModal" class="btn btn-dark mb-2 ml-2"><i class="bi bi-plus-square"></i> Create Role</a>
            <table class="table table-bordered role_datatable">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
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



      
      var table = $('.role_datatable').DataTable({
           processing: true,
           serverSide: true,
           ajax: '{{route("roles.index")}}',
           columns: [
            {data: 'id', name: 'id'},
                      {data: 'name', name: 'name'},
                      {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
            });

            



          $(document).on('click','.assign_role', function (e) {
          e.preventDefault();
          
          var role_id = $('#edit_role_id').val();

          // console.log(permission_id);

                
                var permission_id_arr = [];
                $('input:checkbox[name=permission_id]:checked').each(function(){
                  permission_id_arr.push($(this).val());
                });

                var data = {
                'role_id' : role_id,
                'permission': permission_id_arr,
                }
              

                // console.log(data);

                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });


                $.ajax({  
                type: "post",
                url: '/roles/permissions',
                data: data,
                dataType: "json",
                success: function (response) {
                    // console.log(response);

                  //   if(response.status == 400){
                  //   $('#saveform_errlist').html("");
                  //   $('#saveform_errlist').addClass('alert alert-danger');
                  //   $.each(response.errors, function (key, err_values) { 

                  //       $('#saveform_errlist').append('<li>'+err_values+'</li>');

                  //   });
                  //   } 
                  //   else {

                        $('#saveform_errlist').html("");
                        $('#success_message').addClass("alert alert-success");
                        $('#success_message').text(response.message);
                        $('#EditRoleModal').modal('hide');
                        $('.modal-backdrop').remove();
                        $('#AddEditModal').find('input').val("");

                     
                        setTimeout(function() {
                        $('#success_message').fadeOut().text('')
                             }, 5000 );

                         $('#success_message').fadeIn().delay(5000).fadeOut();

                        $('.permission_datatable').DataTable().ajax.reload();

                              

                  //         }
                    
                   }
                // });

             });
          



      });



          $(document).on('click','.add_role', function (e) {
          e.preventDefault();


         
               var data = {
                'name': $('#input_role').val(),
                }

                // console.log(data);

                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });


                $.ajax({  
                type: "post",
                url: '{{route("roles.store")}}',
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
                        $('#AddRoleModal').modal('hide');
                        $('.modal-backdrop').remove();
                        $('#AddRoleModal').find('input').val("");

                     
                                setTimeout(function() {
                                $('#success_message').fadeOut().text('')
                                }, 5000 );
                                $('#success_message').fadeIn().delay(5000).fadeOut();

                                $('.role_datatable').DataTable().ajax.reload();

                              

                          }
                    
                   }
                });

             });
          

                  // DELETE ROLE

    $(document).on('click','.delete_role', function (e) {
       e.preventDefault();

            var role_id = $(this).val();
            // alert(stud_id);
            $('#delete_role_id').val(role_id);
            $('#DeleteRoleModal').modal('show')
          });

        $(document).on('click','.delete_role_btn', function (e) {
          e.preventDefault();
          
          var role_id = $('#delete_role_id').val();

          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });

              $.ajax({
                type: "get",
                url: '/roles/delete/'+role_id,
                success: function (response) {

                  // console.log(response);
                  $('#success_message').addClass('alert alert-success');
                  $('#success_message').text(response.message);
                  $('#DeleteRoleModal').modal('hide');
                  $('.modal-backdrop').remove();
                  
                 
                  $('.role_datatable').DataTable().ajax.reload();

              
                         setTimeout(function() {
                         $('#success_message').fadeOut().text('')
                         }, 5000 );
                          $('#success_message').fadeIn().delay(5000).fadeOut();
            }
        });

      });

      // End- DELETE ROLE

      // <!-- {{-- EditStudent Button --}} -->

      $(document).on('click', '.edit_role', function (e) {
      
       e.preventDefault();


      
       var table1 = $('.permission_list_datatable').DataTable({
              ajax: '{{route("roles.index_permission_list")}}',
              processing: true,
              serverSide: true,
              retrieve: true,
              columns: [
                          {data: 'action', name: 'action', orderable: false, searchable: false},
                          {data: 'name', name: 'name'},
                      
                        ]
                });

         $('#select_all_ids').prop('checked', false);

         $('#select_all_ids').click(function() {
          
          if ($(this).prop('checked')) {
            $.each( $("input[name^='permission_id']"), function(){
                    $(this).prop('checked', true);
                  });
            
            } else {
              
            $.each( $("input[name^='permission_id']"), function(){
                    $(this).prop('checked', false);
                  });
              }
        });

                
        var role_id = $(this).val();
        
        table1.ajax.reload(); 

        // console.log(role_id);
        $('#EditRoleModal').modal('show');
         
     
   
        $.ajax({
          type: "get",
          url: '/roles/edit/'+role_id,
          dataType: "json",
          success: function (response) {

          // console.log(response);
      
        
          var permissions = response.rolePermissions;

          if(response.status == 404){
            $('#success_message').htm("");
            $('#success_message').addClass('alert alert-danger');
            $('#success_message').text(response.message);

          }else{
          
              $('#edit_input_role').val(response.role.name);
              $('#edit_role_id').val(role_id);

            // check all permissions of specific role
           $.each( $("input[name^='permission_id']"), function(){
            // console.log($(this).val());
           
            var permission_id = parseInt($(this).val())

            if(permissions.includes(permission_id))
            {
              $(this).prop('checked', true);
            
            }
          });

          
          }
        }

        
        
      });


       
      
    });

   // <!-- {{-- End EditStudent Button --}} -->

   

    });
  
    
</script>

    
@endsection


