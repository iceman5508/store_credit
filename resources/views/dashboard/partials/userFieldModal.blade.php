<div class="modal fade" id="UserFieldModal" tabindex="-1" role="dialog" aria-labelledby="CustomerLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Field</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="save-field-form" action="{{ route('toggleUserField', ['user' => $user]) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <select class="form-select form-control selField @error('selField') is-invalid @enderror" aria-label="Default select example" id="selField" name="selField" required disabled>
                            <option value="">Select a Field</option>
                            @foreach($storeField as $field)
                                <option value="{{$field->field_id}}">{{$field->name}}</option>
                            @endforeach
                        </select>


                        @if (!$errors->any())
                            <span class="invalid-feedback selField-error" role="alert">
                                         </span>
                        @endif

                        @error('selField')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                         </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input
                            placeholder="Field Value"
                            id="fieldValue" type="text" value="{{old('fieldValue')}}" class="form-control form-control-field  @error('fieldValue') is-invalid @enderror" name="fieldValue" required>

                        @if (!$errors->any())
                            <span class="invalid-feedback fieldValue-error" role="alert">
                                         </span>
                        @endif

                        @error('fieldValue')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                         </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input
                            placeholder="user_metta"
                            id="userMeta" type="hidden" value="0" class="form-control form-control-field"  name="userMeta" required>
                        <input
                            placeholder="selected_field"
                             type="hidden" value="0" class="form-control form-control-field selField"  name="selected_field" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary"  id="submitUserField">Save</button>

            </div>

        </div>
    </div>
</div>
