@extends('dashboard.layouts.dashboard')

@section('title', Auth::user()->store->name)

@section('content')

    @if ($errors->any())
        <div class="card mb-4">
            <div class="card-header text-danger">Error</div>

            <div class="card-body text-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        </div>
    @endif

    @include('dashboard.content.fields-table')

@endsection


@section('scripts')
    <script src="{{asset('vendors/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/dataTables.bootstrap4.min.js')}}"></script>


    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({});
        });

        @if($errors->has('field'))
            $('#newField').click();
        @endif


        //save transaction
        $('#submitField').on('click', function (){
            let elements = ['field'];
            let valid = true;
            elements.forEach(function(element){

                console.log($(`#${element}`).val());
                if($(`#${element}`).val() == null || $(`#${element}`).val() == "" ){
                    valid = false;
                    $(`.${element}-error`).html(`Field is required`);
                }else{
                    $(`.${element}-error`).html('');
                }
            });
            if(valid){
                document.getElementById('save-field-form').submit();
            }else{

                $('#save-field-form').addClass('was-validated');
            }

        });

    </script>


@endsection


