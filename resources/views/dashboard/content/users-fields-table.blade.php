<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">User Field Table</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered dataTable table-striped" id="user-field-list" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Field</th>
                            <th>Value</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Field</th>
                            <th>Value</th>
                        </tr>
                        </tfoot>
                        <tbody >
                        @foreach ($user_fields as $user_field)
                            <tr data-toggle="modal" data-target="#UserFieldModal" onclick="
                                $('#fieldValue').val('{{$user_field->value}}');
                                  $('.selField').val({{$user_field->field_id}});
                                @if(!empty($user_field->um_id)) $('#userMeta').val({{$user_field->um_id}}); @endif
                            ">
                                <td>{{$user_field->name}}</td>
                                <td>{{$user_field->value}}</td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@include('dashboard.partials.userFieldModal', ['storeField' => $user_fields, 'user' => $user->id]);
