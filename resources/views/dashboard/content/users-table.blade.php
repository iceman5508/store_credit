<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Customer Table</h6>
                <div class="btn btn-primary float-right text-white" id="newCustBtn" data-toggle="modal" data-target="#addCustomerModal">Add Customer</div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Email Verified</th>
                            <th>Lifetime Credit</th>
                            <th>Available Credit</th>
                            <th>Date Added</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Email Verified</th>
                            <th>Lifetime Credit</th>
                            <th>Available Credit</th>
                            <th>Date Added</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach (Auth::user()->store->customers as $customer)
                            <tr onclick="window.location = '{{route("customerDetail",['id' => $customer->id])}}'">
                                <td>{{$customer->name}}</td>
                                <td>{{$customer->email}}</td>
                                <td>{{$customer->verified()}}</td>
                                <td>${{$customer->lifetime_credit()}}</td>
                                <td>${{$customer->available_credit()}}</td>
                                <td>{{$customer->created_at}}</td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
