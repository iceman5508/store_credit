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
