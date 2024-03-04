<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Transaction Table</h6>
                <div class="btn btn-primary float-right text-white" id="newCustBtn" data-toggle="modal" data-target="#addCustomerModal">Add Transaction</div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Employee</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Employee</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach ($user->credit as $credit)
                            <tr>
                                <td>{{$credit->created_at}}</td>
                                <td>{{$credit->value}}</td>
                                <td>{{$credit->operator->name}}</td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
