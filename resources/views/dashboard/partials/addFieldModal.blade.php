<div class="modal fade" id="addUserFieldModal" tabindex="-1" role="dialog" aria-labelledby="CustomerLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Field</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="save-field-form" action="{{ route('addField') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input
                            placeholder="Field Name"
                            id="field" type="text" value="{{old('field')}}" class="form-control form-control-field @error('field') is-invalid @enderror" name="field" required>

                        @if (!$errors->any())
                            <span class="invalid-feedback field-error" role="alert">
                                         </span>
                        @endif

                        @error('field')
                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                         </span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary"  id="submitField">Save</button>

            </div>

        </div>
    </div>
</div>
