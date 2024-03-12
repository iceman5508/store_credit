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
    </script>


@endsection


