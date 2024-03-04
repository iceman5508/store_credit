<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Store Transaction Table</h6>
                <div class="btn btn-primary float-right text-white" id="newTransaction" data-toggle="modal" data-target="#addTransactionModal">Add Transaction</div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered dataTable" id="dataTable2" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Amount</th>
                            <th>Employee</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>

                            <th>Customer Name</th>
                            <th>Amount</th>
                            <th>Employee</th>
                            <th>Date</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach (Auth::user()->store->credit as $credit)
                            <tr onclick="window.location = '{{route("customerDetail",['id' => $credit->customer->id])}}'">
                                <td>{{$credit->customer->name}}</td>
                                <td>{{$credit->value}}</td>
                                <td>{{$credit->operator->name}}</td>
                                <td>{{$credit->created_at}}</td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
