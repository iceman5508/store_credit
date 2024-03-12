<div class="modal fade" id="deactivateFieldModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deactivate Field?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Are you sure you want to deactivate this field?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="{{ route('toggleField') }}" onclick="event.preventDefault();
                                                     document.getElementById('deactivate-field-form').submit();">Confirm</a>
                <form id="deactivate-field-form" action="{{ route('toggleField') }}" method="POST" class="d-none">
                    @csrf
                    <input type="hidden" value="0" name="field_id" class="field_id" required>
                    <input type="hidden" value="0" name="field_value" class="field_value" required>
                    <input type="hidden" value="0" name="field_status" required>
                </form>
            </div>

        </div>
    </div>
</div>
