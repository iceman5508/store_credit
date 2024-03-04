<div class="modal fade" id="addTransactionModal" tabindex="-1" role="dialog" aria-labelledby="CustomerLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Transaction</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="save-transaction-form" action="{{ route('saveTransaction') }}" method="POST" class="transaction">
                    @csrf
                    <div class="form-group">
                        <select class="form-select form-control @error('selCustomer') is-invalid @enderror" aria-label="Default select example" id="selCustomer" name="selCustomer" required>
                            <option value="">Select a Customer</option>
                            @foreach(Auth::user()->store->customers as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        </select>



                        @if (!$errors->any())
                            <span class="invalid-feedback selCustomer-error" role="alert">
                                         </span>
                        @endif

                        @error('selCustomer')
                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                         </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input
                            placeholder="Credit"
                            id="trans_credit" type="number" step="0.01" class="form-control form-control-user @error('trans_credit') is-invalid @enderror" name="trans_credit"
                        value="{{old('trans_credit')}}" autocomplete="trans_credit" required>
                        @if (!$errors->any())
                            <span class="invalid-feedback trans_credit-error" role="alert">
                                         </span>
                        @endif

                        @error('trans_credit')
                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                         </span>
                        @enderror
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary"  id="submitTransaction">Save</button>

            </div>

        </div>
    </div>
</div>
