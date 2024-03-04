<div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="CustomerLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="save-customer-form" action="{{ route('saveCustomer') }}" method="POST" class="test">
                    @csrf
                    <div class="form-group">
                        <input
                            placeholder="Customer Name"
                            id="name" type="text" value="{{old('name')}}" class="form-control form-control-user @error('name') is-invalid @enderror" name="name" required autocomplete="name"
                        >

                        @if (!$errors->any())
                            <span class="invalid-feedback name-error" role="alert">
                                         </span>
                        @endif

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                         </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="email" type="email" class="form-control form-control-user  @error('email') is-invalid @enderror"
                               aria-describedby="emailHelp"
                               placeholder="Enter Email Address"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @if (!$errors->any())
                            <span class="invalid-feedback email-error" role="alert">
                                         </span>
                        @endif

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input
                            placeholder="Credit"
                            id="credit" type="number" step="0.01" class="form-control form-control-user @error('credit') is-invalid @enderror" name="credit"
                        value="{{old('credit')}}" autocomplete="credit" required>
                        @if (!$errors->any())
                            <span class="invalid-feedback credit-error" role="alert">
                                         </span>
                        @endif

                        @error('credit')
                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                         </span>
                        @enderror
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary"  id="submitCustomer">Save</button>

            </div>

        </div>
    </div>
</div>
