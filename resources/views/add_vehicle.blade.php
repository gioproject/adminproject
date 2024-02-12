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

                  <form action="/vehicles/store_vehicle" method="post" enctype="multipart/form-data">
                    @csrf
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
                      <select class="form-control selectpicker" name="driver_name">
                        <option selected disabled>Choose Driver</option>
                        @foreach($data as $data)
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
                      <input type="file" name="photo" class="photo form-control"> 
                    </div>

                      <div class="ml-4">
                      <button type="submit" class="btn-float-left btn btn-success add_driver">Add Vehicle</button>
                    </div>
                  </form>
          </div>
       </div>

@endsection


@section('scripts');




    
@endsection


