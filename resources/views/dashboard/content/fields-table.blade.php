<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Fields Table</h6>
                <div class="btn btn-primary float-right text-white" id="newField" data-toggle="modal" data-target="#addUserFieldModal">Add Field</div>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Field Name</th>
                            <th>Status</th>
                            <th>Setting</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Field Name</th>
                            <th>Status</th>
                            <th>Setting</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach ($all_fields as $fields)

                            <tr onclick="  @if (!empty($fields->store_id)) $('.field_id').val({{$fields->enabled_id}}); @endif  $('.field_value').val({{$fields->field_id}});">
                                <td>{{$fields->name}}</td>
                                <td>{{!empty($fields->status) ? 'Active' : 'Inactive' }}</td>
                                <td>
                                    @if(empty($fields->status))
                                        <span class="btn btn-success" data-toggle="modal" data-target="#activateFieldModal">Activate</span>
                                    @else
                                        <span class="btn btn-danger" data-toggle="modal" data-target="#deactivateFieldModal">Deactivate</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




@include('dashboard.partials.deactivate-field-modal');
@include('dashboard.partials.activate-field-modal');
@include('dashboard.partials.addFieldModal');
