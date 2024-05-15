@extends('dashboard.layouts.dashboard')

@section('title', Auth::user()->store->name)

@section('content')

    @include('dashboard.content.users-table')

@endsection


@section('scripts')
    @include('dashboard.partials.addCustomer')

    <script src="{{asset('vendors/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <script>
        $(document).ready(function() {

            $('#dataTable').DataTable(
                {
                    order: [[5, 'asc']]
                }
            );
        });

        @if($errors->has('email') || $errors->has('name') || $errors->has('credit'))
        $('#newCustBtn').click();
        @endif



        //add customer form submit
        $('#submitCustomer').on('click', function (){
            let elements = ['name','email','credit'];
            let valid = true;
            elements.forEach(function(element){
                if($(`#${element}`).val() == null || $(`#${element}`).val() == "" ){
                    valid = false;
                    $(`.${element}-error`).html(`${element.toUpperCase()} is required`);
                }else{
                    $(`.${element}-error`).html('');
                }
            });
            if(valid){
                document.getElementById('save-customer-form').submit();
            }else{

                $('#save-customer-form').addClass('was-validated');
            }

        });

    </script>


@endsection


