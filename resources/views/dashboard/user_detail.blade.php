@extends('dashboard.layouts.dashboard')

@section('title', Auth::user()->store->name)

@section('content')

    <div class="container-xl px-4 mt-4">
        <!-- Account page navigation-->
        <hr class="mt-0 mb-4">
        <div class="row mb-4">
            <div class="col-xl-4">
                <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">{{$user->name}}</div>
                    <div class="card-body text-center user-profile-img bg-gradient-red">
                        <!-- Profile picture image-->
                        <img src="{{asset('img/logo.png')}}" class="img-fluid" alt="Responsive image">
                        <!-- Profile picture help block-->

                        <!-- Profile picture upload button-->
{{--                        <button class="btn btn-primary" type="button">Upload new image</button>--}}
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <form class="user" method="POST" action="{{ route('updateUser', ['id' => $user->id]) }}">
                            @csrf
                            @method('PATCH')
                            <!-- Form Group (username)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputUsername">Name</label>
                                <input class="form-control  @error('inputUsername') is-invalid @enderror" id="inputUsername" name="inputUsername" type="text" placeholder="Enter Customer Name" value="{{$user->name}}" required>
                                @error('inputUsername')
                                <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="customerEmail">Email</label>
                                    <input class="form-control  @error('email') is-invalid @enderror" id="email" name="email" type="text" placeholder="Enter Customer Email" value="{{$user->email}}" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="emailVerified">Email Verified</label>
                                    <input class="form-control" id="emailVerified" type="text"  value="{{$user->verified()}}" readonly>
                                </div>
                            </div>
                            <!-- Form Row        -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (organization name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="lifetimeCredit">Lifetime Credit</label>
                                    <input class="form-control" id="lifetimeCredit" type="text" value="${{$user->lifetime_credit()}}" readonly>
                                </div>
                                <!-- Form Group (location)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="currentCredit">Current Credit</label>
                                    <input class="form-control" id="currentCredit" type="text"  value="${{$user->available_credit()}}" readonly>
                                </div>
                            </div>

                            <!-- Save changes button-->
                            <button class="btn btn-primary" type="submit">Save changes</button>
                        </form>
                    </div>
                </div>



            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-xl-6">

            </div>
            <div class="col-md-6 col-xl-6">
                @include('dashboard.content.transaction-table')
            </div>
        </div>
    </div>





@endsection


@section('scripts')

    @include('dashboard.partials.addTransaction', ['customerTransaction' => [$user], 'show_default' => true])
    <script src="{{asset('vendors/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                order: [[2, 'desc']]
            });
        });



        //save transaction
        $('#submitTransaction').on('click', function (){
            let elements = ['selCustomer','trans_credit'];
            let valid = true;
            elements.forEach(function(element){

                console.log($(`#${element}`).val());
                if($(`#${element}`).val() == null || $(`#${element}`).val() == "" ){
                    valid = false;
                    $(`.${element}-error`).html(`Field is required`);
                }else{
                    $(`.${element}-error`).html('');
                }
            });
            if(valid){
                document.getElementById('save-transaction-form').submit();
            }else{

                $('#save-transaction-form').addClass('was-validated');
            }

        });

    </script>

@endsection


