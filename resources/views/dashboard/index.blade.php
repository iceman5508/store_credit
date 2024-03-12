@extends('dashboard.layouts.dashboard')

@section('title', Auth::user()->store->name)

@section('content')
                <!-- Page Heading -->

                <!-- Content Row -->
                @include('dashboard.content.summary-cards')


                @include('dashboard.content.store-transaction-table')

                <!-- Content Row -->


            @include('dashboard.content.users-table')
@endsection


@section('scripts')

    @include('dashboard.partials.addCustomer')
    @include('dashboard.partials.addTransaction', ['customerTransaction' => Auth::user()->store->customers, 'show_default' => false])
    <!-- Page level plugins -->

    <script src="{{asset('vendors/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable2').DataTable( {
                order: [[3, 'asc']]
            });
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


