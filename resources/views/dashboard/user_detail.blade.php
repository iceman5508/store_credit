@extends('dashboard.layouts.dashboard')

@section('title', Auth::user()->store->name)

@section('content')

    <div class="container-xl px-4 mt-4">
        <!-- Account page navigation-->
        <hr class="mt-0 mb-4">
        <div class="row">
            <div class="col-xl-4">
                <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">{{$user->name}}</div>
                    <div class="card-body text-center">
                        <!-- Profile picture image-->
                        <img class="img-account-profile rounded-circle mb-2" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
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
                        <form>
                            <!-- Form Group (username)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputUsername">Name</label>
                                <input class="form-control" id="inputUsername" type="text" placeholder="Enter Customer Name" value="{{$user->name}}">
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="customerEmail">Email</label>
                                    <input class="form-control" id="customerEmail" type="text" placeholder="Enter Customer Email" value="{{$user->email}}">
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
                            <button class="btn btn-primary" type="button">Save changes</button>
                        </form>
                    </div>
                </div>

                @include('dashboard.content.transaction-table')

            </div>
        </div>
    </div>





@endsection


@section('scripts')
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                order: [[2, 'desc']]
            });
        });
    </script>

@endsection


