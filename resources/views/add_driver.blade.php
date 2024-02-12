@extends('layouts.master')

@section('content')


      <div class="card" style="margin:20px;">
         <div class="card-header">Create New Driver</div>
            <div class="card-body">

             
              @if (Session::get('success'))
              <script>
                toastr.success("{{ Session::get('success') }}");
              </script>
              @endif

              @if (Session::get('fail'))
              <div class="alert alert-danger">
                  {{ Session::get('fail') }}
              </div>  
              @endif

                @if($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                  </ul>
              </div>
              @endif

                  <form action="/drivers/store_driver" method="post">
                    @csrf
                    <div class="form-group mb-3">
                      <label for="">Driver Name: </label>
                      <input type="text" name="name" value="{{ old('name')}}" class="name form-control"> 
                    </div>

                    <div class="form-group mb-3">
                      <label for="">Contact: </label>
                      <input type="text" name="contact" value="{{ old('contact')}}" class="contact form-control"> 
                    </div>

                    <div class="form-group mb-3">
                      <label for="">Address: </label>
                      <input type="text" name="address" value="{{ old('address')}}" class="address form-control"> 
                    </div>
                    
                    <div class="form-group mb-3">
                      <label for="">Email: </label>
                      <input type="text" name="email" value="{{ old('email')}}" class="email form-control"> 
                    </div>
                    
                      <div class="ml-5">
                      <button type="submit" class="btn-float-left btn btn-success add_driver">Add Driver</button>
                    </div>
                  </form>
          </div>
       </div>



@endsection


@section('scripts');




    
@endsection


