@extends('dashboard.layouts.dashboard')

@section('title', Auth::user()->store->name)

@section('content')

    @include('dashboard.content.store-transaction-table')

@endsection


@section('scripts')
    @include('dashboard.partials.addTransaction', ['customerTransaction' => Auth::user()->store->customers, 'show_default' => false])

    <script src="{{asset('vendors/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <script>
        $(document).ready(function() {

            $('#dataTable2').DataTable( {
                order: [[3, 'asc']]
            });
        });


        //save transaction
        $('#submitTransaction').on('click', function (){
            let elements = ['selCustomer','trans_credit'];
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
                document.getElementById('save-transaction-form').submit();
            }else{

                $('#save-transaction-form').addClass('was-validated');
            }

        });

    </script>


@endsection


