@extends("layout.app")

@section("content")

<div class="content" id="content">

    <div class="table-container">

      

        <!-- Table -->
        <button class="btn btn-primary"><a href="{{ route('dashboard') }}" style="color: white;text-decoration: none">Back to dashboard</a></button>

        <table class="table table-sm table-hover">

            <thead class="bg-secondary text-white">
                <tr>
                    <th>Module</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>IP Address</th>
                    <th>Platform</th>
                    <th>Time</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($activities as $a)
                                 <tr>
                                    <td>{{ $a->module }}</td>
                                    <td>{{ $a->action }}</td>
                                    <td>{{ $a->description }}</td>
                                    <td>{{ $a->ip_address }}</td>
                                    <td>{{ $a->platform }}</td>
                                    <td>{{ $a->created_at->diffForHumans() }}</td>
                                 </tr>
                                 
                                     
                                 @endforeach

            </tbody>

        </table>

        
    </div>

</div>
@if(session('success') || session('error'))

<div class="modal fade" id="successModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content text-center">

            @if(session('success'))

                <div class="modal-body p-5">

                    <i class="fas fa-check-circle text-success"
                       style="font-size:80px;"></i>

                    <h3 class="mt-3 text-success">
                        Success
                    </h3>

                    <p style="color:green">
                        {{ session('success') }}
                    </p>

                    <button type="button"
                            class="btn btn-success"
                            data-bs-dismiss="modal">
                        OK
                    </button>

                </div>

            @endif

            @if(session('error') || $errors->any())

<div class="modal-body p-5">

    <i class="fas fa-times-circle text-danger"
       style="font-size:80px;"></i>

    <h3 class="mt-3 text-danger">
        Failed
    </h3>

    @if(session('error'))
        <p style="color:red">
            {{ session('error') }}
        </p>
    @endif

    @if($errors->any())
        <ul class="text-danger text-start">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <button type="button"
            class="btn btn-danger"
            data-bs-dismiss="modal">
        OK
    </button>

</div>

@endif

        </div>

    </div>

</div>

@endif
@if(session('success') || session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    let modal = new bootstrap.Modal(
        document.getElementById('successModal')
    );
    modal.show();
});
</script>
@endif
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection