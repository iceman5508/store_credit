@extends('dashboard.layouts.dashboard')

@section('title', Auth::user()->store->name)

@section('content')
    <div class="container-xl px-4 mt-4">
        <!-- Account page navigation-->
        <hr class="mt-0 mb-4">
        <div class="row mb-4">
            <div class="col-xl-12">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">Add Employee</div>
                    <div class="card-body">
                        <form class="user" method="POST" action="{{route('addEmployee')}}">
                            @csrf
                            <!-- Form Group (username)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputUsername">Name</label>
                                <input class="form-control  @error('name') is-invalid @enderror" id="name" name="name" type="text" placeholder="Enter Employee Name" value="" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-12">
                                    <label class="small mb-1" for="email">Email</label>
                                    <input class="form-control  @error('email') is-invalid @enderror" id="email" name="email" type="text" placeholder="Enter Employee Email" value="" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Form Row        -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (organization name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="password">Password</label>
                                    <input class="form-control @error('password') is-invalid @enderror" name="password" id="password" type="password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <!-- Form Group (location)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="verifyEmployeePassword">Verify Password</label>
                                    <input class="form-control  @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="verifyEmployeePassword" type="password"  value="">
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Save changes button-->
                            <button class="btn btn-primary" type="submit">Add Employee</button>
                        </form>
                    </div>
                </div>



            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('dashboard.content.employee-table')
            </div>

        </div>
    </div>


@endsection


@section('scripts')
    <script src="{{asset('vendors/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <script>
        $(document).ready(function() {

            $('#dataTable').DataTable( {
                order: [[2, 'asc']]
            });
        });
    </script>


@endsection


