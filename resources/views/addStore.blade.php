<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage Stores</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('vendors/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin-2.css')}}" rel="stylesheet">

</head>
<body class="bg-gradient-primary">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" style="margin-top: 15%">
                <div class="card">
                    <div class="card-header">{{ __('Manage Stores') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#addStoreModal">
                            Add Store
                        </button>

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Store Name</th>
                                <th scope="col">Subscription Package</th>
                                <th scope="col">Subscriptions</th>
                                <th scope="col">Status</th>
                                <th scope="col">Expires</th>


                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($store as $stores)
                                <tr>
                                    <th scope="row">{{$stores->id}}</th>
                                    <td>{{$stores->name}}</td>
                                    <td>{{($stores->package) ? $stores->package->name : 'Not Selected' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#subscriptionModal" data-store-id="{{ $stores->id }}">
                                            Select Subscription
                                        </button>
                                    </td>
                                    @if($stores->package)
                                        <td>{{(strtotime($stores->expired_at) > strtotime(date("Y-m-d"))) ? 'Active' : 'Inactive'}}</td>
                                        <td>{{date("m-d-Y", strtotime($stores->expired_at))}}</td>
                                    @else
                                        <td>Inactive</td>
                                        <td>No Active Subscription</td>
                                    @endif
                                    <td>
                                        @if($stores->package)
                                            <a href="{{route('storeLogin', [$stores->id])}}"
                                               class="btn btn-primary">Login</a>
                                        @endif

                                        <!-- <a href="" class="btn btn-primary">edit</a> -->
                                        <a href="{{route('deleteStore', [$stores->id])}}"
                                           class="btn btn-danger">delete</a>


                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No store available</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal fade" id="addStoreModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Store</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('stores') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="storeName" class="form-label">Store Name</label>
                            <input type="text" class="form-control" id="storeName" name="name"
                                   placeholder="Enter store name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Store</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Subscription Modal -->
    <div class="modal fade" id="subscriptionModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Select Subscription Package</h4>
                    <button type="button" class="btn-close" data-dismiss="modal">X</button>
                </div>
                <div class="modal-body">
                    <form id="subscriptionForm" method="POST" action="{{ route('payment') }}">
                        @csrf
                        <input type="hidden" id="storeIdInput" name="store_id" value="">
                        <div class="mb-3">
                            <label for="subscriptionPackage" class="form-label">Subscription Package</label>
                            <select class="form-select" id="subscriptionPackage" name="subscription_package" required>
                                @foreach($package as $packages)
                                    <option value="{{$packages->id}}">{{$packages->name}} {{$packages->price}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="cardNumber" class="form-label">Card Number</label>
                            <input type="text" class="form-control" id="cardNumber" name="card_number"
                                   placeholder="Enter your card number" required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="expiryDate" class="form-label">Expiry Date</label>
                                <input type="text" class="form-control" id="expiryDate" name="expiry_date"
                                       placeholder="MM/YY" required>
                            </div>
                            <div class="col">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="cvv" name="cvv" placeholder="Enter CVV"
                                       required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Subscribe Now</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('vendors/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendors/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('vendors/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('js/sb-admin-2.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#subscriptionModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var storeId = button.data('store-id');
                $('#storeIdInput').val(storeId);
                console.log('here');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#subscriptionModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var storeId = button.data('store-id');
                $('#storeIdInput').val(storeId);
            });

            // Validate card number format
            $('#cardNumber').on('input', function() {
                var cardNumber = $(this).val().trim();
                // Perform validation logic here, you can use a library like Stripe.js for this purpose
            });

            // Validate expiry date format
            $('#expiryDate').on('input', function() {
                var expiryDate = $(this).val().trim();
                // Perform validation logic here, check if it matches MM/YY format
            });

            // Validate CVV format
            $('#cvv').on('input', function() {
                var cvv = $(this).val().trim();
                // Perform validation logic here, e.g., check if it's a 3 or 4 digit number
            });
        });
    </script>
</body>
